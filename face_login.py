# face_login.py
from flask import Flask, request, jsonify
import cv2
import numpy as np
import base64
import mediapipe as mp
import face_recognition

app = Flask(__name__)

# Load known image (replace with actual user image)
known_image = face_recognition.load_image_file("uploads/user1.jpg")
known_encoding = face_recognition.face_encodings(known_image)[0]

@app.route('/', methods=['POST'])
def face_login():
    data = request.get_json()
    image_data = data['image'].split(',')[1]
    img_bytes = base64.b64decode(image_data)

    nparr = np.frombuffer(img_bytes, np.uint8)
    img = cv2.imdecode(nparr, cv2.IMREAD_COLOR)

    try:
        face_encodings = face_recognition.face_encodings(img)
        if not face_encodings:
            return jsonify({"status": "error", "message": "No face detected"})

        match = face_recognition.compare_faces([known_encoding], face_encodings[0])
        if match[0]:
            return jsonify({"status": "success"})
        else:
            return jsonify({"status": "error", "message": "Face does not match"})

    except Exception as e:
        return jsonify({"status": "error", "message": str(e)})

if __name__ == '__main__':
    app.run(debug=True)
