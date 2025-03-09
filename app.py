from flask import Flask, Response, jsonify
from flask_cors import CORS
import cv2

app = Flask(__name__)
CORS(app)  # Enable CORS for all routes

# Load OpenCV's Haar cascade for face detection
face_cascade = cv2.CascadeClassifier(cv2.data.haarcascades + 'haarcascade_frontalface_default.xml')

# Movement tracking
prev_x = None
movement_direction = "CENTER"

@app.route('/face_position')
def face_position():
    global movement_direction
    return jsonify({"position": movement_direction})  # Return JSON response

def generate_frames():
    global prev_x, movement_direction
    cap = cv2.VideoCapture(0)

    frame_width = int(cap.get(3))
    center_x = frame_width // 2  # Middle of the frame

    while True:
        success, frame = cap.read()
        if not success:
            break

        # Convert frame to grayscale for detection
        gray = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)
        faces = face_cascade.detectMultiScale(gray, scaleFactor=1.3, minNeighbors=5, minSize=(30, 30))

        for (x, y, w, h) in faces:
            # Draw face box
            cv2.rectangle(frame, (x, y), (x + w, y + h), (0, 255, 0), 2)

            # Determine movement direction
            if prev_x is not None:
                dx = x - prev_x
                if abs(dx) > 10:
                    if x + w // 2 < center_x - 30:
                        movement_direction = "LEFT"
                    elif x + w // 2 > center_x + 30:
                        movement_direction = "RIGHT"
                    else:
                        movement_direction = "CENTER"

            prev_x = x

            # Overlay movement direction inside face box
            cv2.putText(frame, f"Movement: {movement_direction}", (x, y - 10),
                        cv2.FONT_HERSHEY_SIMPLEX, 0.7, (0, 0, 255), 2)

        # Encode frame as JPEG
        ret, buffer = cv2.imencode('.jpg', frame)
        frame = buffer.tobytes()

        yield (b'--frame\r\n'
               b'Content-Type: image/jpeg\r\n\r\n' + frame + b'\r\n')

@app.route('/video_feed')
def video_feed():
    return Response(generate_frames(), mimetype='multipart/x-mixed-replace; boundary=frame')

if __name__ == '__main__':
    app.run(host='127.0.0.1', port=5000, debug=True)