from flask import Flask, Response, jsonify
from flask_cors import CORS
import cv2
import mediapipe as mp
import numpy as np
import math
import os
os.environ['TF_CPP_MIN_LOG_LEVEL'] = '2'  # Suppress TensorFlow INFO and WARNING messages

app = Flask(__name__)
CORS(app)

# Initialize MediaPipe Face Mesh
mp_face_mesh = mp.solutions.face_mesh
mp_drawing = mp.solutions.drawing_utils
mp_drawing_styles = mp.solutions.drawing_styles

face_mesh = mp_face_mesh.FaceMesh(
    max_num_faces=1,
    refine_landmarks=True,
    min_detection_confidence=0.5,
    min_tracking_confidence=0.5
)

# Movement tracking variables
prev_x = None
movement_direction = "CENTER"
gaze_direction = "CENTER"

def calculate_gaze_direction(face_landmarks, image_shape):
    # Get specific landmarks for left and right eye
    # Left eye corners (points 33 and 133)
    left_eye_left = face_landmarks.landmark[33]
    left_eye_right = face_landmarks.landmark[133]
    
    # Right eye corners (points 362 and 263)
    right_eye_left = face_landmarks.landmark[362]
    right_eye_right = face_landmarks.landmark[263]
    
    # Nose tip (point 1)
    nose_tip = face_landmarks.landmark[1]
    
    # Convert normalized coordinates to pixel coordinates
    height, width = image_shape[:2]
    nose_x = int(nose_tip.x * width)
    left_eye_center_x = int((left_eye_left.x + left_eye_right.x) / 2 * width)
    right_eye_center_x = int((right_eye_left.x + right_eye_right.x) / 2 * width)
    
    # Calculate eye line midpoint
    eye_line_center_x = (left_eye_center_x + right_eye_center_x) // 2
    
    # Calculate horizontal difference between nose and eye line center
    horizontal_diff = nose_x - eye_line_center_x
    
    # Increased threshold for more tolerance
    threshold = 20
    
    if horizontal_diff > threshold:
        return "RIGHT"
    elif horizontal_diff < -threshold:
        return "LEFT"
    return "CENTER"

def generate_frames():
    global prev_x, movement_direction, gaze_direction
    cap = cv2.VideoCapture(0)
    frame_width = int(cap.get(3))
    center_x = frame_width // 2

    while True:
        success, frame = cap.read()
        if not success:
            break

        # Flip the frame horizontally for a later selfie-view display
        frame = cv2.flip(frame, 1)
        
        # Convert BGR image to RGB
        frame_rgb = cv2.cvtColor(frame, cv2.COLOR_BGR2RGB)
        
        # Process the frame and detect facial landmarks
        results = face_mesh.process(frame_rgb)

        if results.multi_face_landmarks:
            for face_landmarks in results.multi_face_landmarks:
                # Draw the face mesh
                mp_drawing.draw_landmarks(
                    image=frame,
                    landmark_list=face_landmarks,
                    connections=mp_face_mesh.FACEMESH_TESSELATION,
                    landmark_drawing_spec=None,
                    connection_drawing_spec=mp_drawing_styles.get_default_face_mesh_tesselation_style()
                )
                
                # Draw the face contours
                mp_drawing.draw_landmarks(
                    image=frame,
                    landmark_list=face_landmarks,
                    connections=mp_face_mesh.FACEMESH_CONTOURS,
                    landmark_drawing_spec=None,
                    connection_drawing_spec=mp_drawing_styles.get_default_face_mesh_contours_style()
                )

                # Calculate face position
                nose_tip = face_landmarks.landmark[1]
                x = int(nose_tip.x * frame.shape[1])
                y = int(nose_tip.y * frame.shape[0])

                # Determine movement direction based on face position
                if prev_x is not None:
                    if x < center_x - 100:  # Increased threshold
                        movement_direction = "LEFT"
                    elif x > center_x + 100:  # Increased threshold
                        movement_direction = "RIGHT"
                    else:
                        movement_direction = "CENTER"

                prev_x = x

                # Calculate gaze direction
                new_gaze = calculate_gaze_direction(face_landmarks, frame.shape)
                
                # Only update gaze direction if face is centered
                if movement_direction == "CENTER":
                    gaze_direction = new_gaze
                else:
                    gaze_direction = "CENTER"  # Reset gaze when face is not centered

                # Display movement and gaze information
                cv2.putText(frame, f"Face: {movement_direction}", 
                           (10, 30), cv2.FONT_HERSHEY_SIMPLEX, 
                           0.7, (0, 255, 0), 2)
                cv2.putText(frame, f"Gaze: {gaze_direction}", 
                           (10, 60), cv2.FONT_HERSHEY_SIMPLEX, 
                           0.7, (255, 0, 0), 2)

        else:
            # Reset directions when no face is detected
            movement_direction = "CENTER"
            gaze_direction = "CENTER"

        # Encode the frame for streaming
        ret, buffer = cv2.imencode('.jpg', frame)
        frame = buffer.tobytes()
        
        yield (b'--frame\r\n'
               b'Content-Type: image/jpeg\r\n\r\n' + frame + b'\r\n')

@app.route('/video_feed')
def video_feed():
    return Response(generate_frames(),
                   mimetype='multipart/x-mixed-replace; boundary=frame')

@app.route('/face_position')
def face_position():
    global movement_direction, gaze_direction
    # Only return non-center gaze direction if face is centered
    response_gaze = gaze_direction if movement_direction == "CENTER" else "CENTER"
    return jsonify({
        "position": movement_direction,
        "gaze": response_gaze
    })

if __name__ == '__main__':
    try:
        app.run(host='127.0.0.1', port=5000, debug=False, threaded=True)
    except Exception as e:
        print(f"Error: {e}")
    finally:
        cv2.destroyAllWindows()
