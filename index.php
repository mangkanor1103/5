<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Exam System</title>
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <link rel="stylesheet" href="css/bootstrap-theme.min.css"/>
    <link rel="stylesheet" href="css/font.css"/>
    <script src="js/jquery.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #f8f9fa; /* Light background */
            color: #333;
            font-family: 'Roboto', sans-serif;
            overflow: hidden; /* Prevent body scrolling */
            height: 100vh; /* Full height */
            display: flex;
            flex-direction: column;
            position: relative; /* Position relative for absolute children */
        }
        .header {
            background-color: #28a745; /* Green background */
            color: white;
            padding: 10px 20px; /* Padding for header */
            display: flex;
            justify-content: space-between; /* Space between title and button */
            align-items: center; /* Center items vertically */
            position: fixed;
            width: 100%;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }
        .header h1 {
            margin: 0; /* Remove default margin */
            font-size: 24px; /* Font size for title */
        }
        .container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: calc(100vh - 60px); /* Adjust height to account for header */
            overflow-y: auto; /* Allow scrolling for the container */
            padding-top: 60px; /* Space for fixed header */
        }
        .panel {
            background-image: url(image/bg.jpg);
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            padding: 30px;
            margin: 20px;
            width: 100%;
            max-width: 800px; /* Increased width for two columns */
            animation: fadeIn 0.5s ease-in-out; /* Animation for panel */
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .form-control {
            border-radius: 5px;
            border: 1px solid #28a745; /* Green border */
            transition: border-color 0.3s, box-shadow 0.3s; /* Transition for input focus */
        }
        .form-control:focus {
            border-color: #218838; /* Darker green on focus */
            box-shadow: 0 0 5px rgba(40, 167, 69, 0.5);
        }
        .btn-danger {
            background-color: #28a745; /* Green button */
            border: none;
            border-radius: 5px;
            color: white;
            transition: background-color 0.3s, transform 0.3s; /* Transition for button hover */
        }
        .btn-danger:hover {
            background-color: #218838; /* Darker green on hover */
            transform: translateY(-2px); /* Lift effect on hover */
        }
        .footer {
            background-color: #28a745; /* Green footer */
            color: white;
            padding: 10px 0;
            text-align: center;
            position: absolute;
            bottom: 0;
            width: 100%;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.3);
        }
        .btn-custom {
    background-color: white !important;
    color: black !important;
    border: 1px solid black;
}
.btn:hover {
    background-color: #218838 !important; /* Darker green */
    transform: scale(1.05); /* Slightly increase size */
    transition: all 0.3s ease-in-out;
}
.btn-register {
    background-color: #b30000 !important; /* Green */
    border: none;
    color: white !important;
    transition: background-color 0.3s, transform 0.3s;
}

.btn-register:hover {
    background-color: #218838 !important; /* Darker Green */
    transform: scale(1.05);
}


        .footer a {
            color: white;
            text-decoration: none;
            transition: color 0.3s; /* Transition for footer links */
        }
        .footer a:hover {
            color: #00c6ff; /* Change color on hover */
        }
        .form-row {
            margin-bottom: 15px; /* Space between form rows */
        }

        /* Moving Icons Background */
        .moving-icons {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none; /* Prevent interaction with icons */
            overflow: hidden; /* Hide overflow */
            z-index: 0; /* Behind other content */
        }
        .moving-icons i {
            position: absolute;
            font-size: 50px; /* Size of icons */
            color: rgba(40, 167, 69, 0.5); /* Light green color */
            animation: move 10s linear infinite; /* Animation for moving icons */
        }
        @keyframes move {
            0% { transform: translateY(0); }
            100% { transform: translateY(-100vh); }
        }
    </style>
</head>

<body>
    <div class="moving-icons">
        <i class="fas fa-graduation-cap" style="left: 10%; animation-delay: 0s;"></i>
        <i class="fas fa-book" style="left: 30%; animation-delay: 2s;"></i>
        <i class="fas fa-laptop" style="left: 50%; animation-delay: 4s;"></i>
        <i class="fas fa-pencil-alt" style="left: 70%; animation-delay: 6s;"></i>
        <i class="fas fa-users" style="left: 90%; animation-delay: 8s;"></i>
    </div>

    <div class="header">
    <img src="image/rslogo.jpg" alt="RS Logo" style="height: 50px; margin-right: 10px; border-radius: 50%;">
    <h1 style="display: flex; align-items: center; margin: 0;">
        RS Online Exam
    </h1>
    <a href="#" class="btn btn-register" data-toggle="modal" data-target="#myModal">
        <i class="fa fa-sign-in-alt"></i> Login
    </a>
</div>

<div class="container">
    <div class="panel">
        <form class="form-horizontal" name="form" action="sign.php?q=account.php" 
              onSubmit="return validateForm()" method="POST" enctype="multipart/form-data">
            <fieldset>
                <legend class="text-center" style="color: #28a745;"><b>Register Now</b></legend>

                <div class="row">
                    <div class="col-md-6 form-row">
                        <label class="control-label" for="name">Full Name</label>
                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                        <input id="name" name="name" placeholder="Fullname" class="form-control" type="text" required>
                    </div>
                    <div class="col-md-6 form-row">
                        <label class="control-label" for="gender">Gender</label>
                        <span class="input-group-text"><i class="fa fa-venus-mars"></i></span>
                        <select id="gender" name="gender" class="form-control" required>
                            <option value="">Select Gender</option>
                            <option value="M">Male</option>
                            <option value="F">Female</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-row">
                        <label class="control-label" for="college">Year and Section</label>
                        <span class="input-group-text"><i class="fa fa-school"></i></span>
                        <input id="college" name="college" placeholder="Year and Section" class="form-control" type="text" required>
                    </div>
                    <div class="col-md-6 form-row">
                        <label class="control-label" for="email">Email ID</label>
                        <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                        <input id="email" name="email" placeholder="Email ID" class="form-control" type="email" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-row">
                        <label class="control-label" for="mob">Contact Number</label>
                        <span class="input-group-text"><i class="fa fa-phone"></i></span>
                        <input id="mob" name="mob" placeholder="Contact Number" class="form-control" type="number" required>
                    </div>
                    <div class="col-md-6 form-row">
                        <label class="control-label" for="password">Password</label>
                        <span class="input-group-text"><i class="fa fa-lock"></i></span>
                        <input id="password" name="password" placeholder="Password" class="form-control" type="password" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-row">
                        <label class="control-label" for="cpassword">Confirm Password</label>
                        <span class="input-group-text"><i class="fa fa-check-circle"></i></span>
                        <input id="cpassword" name="cpassword" placeholder="Confirmation Password" class="form-control" type="password" required>
                    </div>
                    <div class="col-md-6 form-row">
    <label class="control-label">Profile Photo</label>
    <div class="mb-2">
        <video id="camera" autoplay playsinline width="100%" style="display:none;"></video>
        <button type="button" class="btn btn-outline-primary btn-sm mt-2" onclick="startCamera()">📷 Upload Photo</button>
        <button type="button" class="btn btn-success btn-sm mt-2" onclick="capture()" style="display:none;" id="captureBtn">✅ Capture</button>
    </div>
    <canvas id="snapshot" style="display:none;"></canvas>
    <input type="hidden" name="photo_data" id="photo_data" required>
    <img id="preview" src="#" alt="Captured photo" style="display:none; max-width: 100%; margin-top: 10px; border: 1px solid #ccc;">
</div>

                </div>

                <div class="form-group text-center">
                    <input type="submit" class="btn btn-register" value="Register"/>
                </div>
            </fieldset>
        </form>
    </div>
</div>


    <div class="footer">
        <div class="row">
            <div class="col-md-4">
                <a href="#" data-toggle="modal" data-target="#login" class="icon">
                    <i class="fas fa-user-shield"></i> Admin Login
                </a>
            </div>
            <div class="col-md-4">
                <a href="#" data-toggle="modal" data-target="#developers" class="icon">
                    <i class="fas fa-code"></i> Developers
                </a>
            </div>
            <div class="col-md-4">
                <a href="feedback.php" target="_blank" class="icon">
                    <i class="fas fa-comments"></i> Feedback
                </a>
            </div>
        </div>
    </div>
<!-- Modal for Login -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #28a745; color: white;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">User Login</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="login.php?q=index.php" method="POST">
                    <div class="form-group">
                        <label class="control-label" for="email">Email</label>
                        <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                        <div>
                            <input id="email" name="email" placeholder="Email" class="form-control" type="email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="password">Password</label>
                        <span class="input-group-text"><i class="fa fa-lock"></i></span>
                        <div>
                            <input id="password" name="password" placeholder="Password" class="form-control" type="password">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-register" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-register">Log in</button>
                    </div>
                </form>

                <!-- Face Login Button -->
                <div class="text-center mb-2">
                    <button class="btn btn-outline-success" onclick="openFaceLoginModal()">Login using Face</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal for Face Login (Real-time Camera Feed) -->
<div class="modal fade" id="faceLoginModal" tabindex="-1" role="dialog" aria-labelledby="faceLoginModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #28a745; color: white;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Face Login</h4>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <video id="faceCam" width="100%" autoplay style="display:block;"></video>
                    <canvas id="faceCanvas" style="display:none;"></canvas>
                    <div id="statusMessage"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const videoElement = document.getElementById("faceCam");
    const canvasElement = document.getElementById("faceCanvas");
    const context = canvasElement.getContext('2d');

    // Set up the camera feed
    async function startCamera() {
        const stream = await navigator.mediaDevices.getUserMedia({ video: true });
        videoElement.srcObject = stream;
    }

    // Capture frame and send to the server for recognition
    function captureAndMatchFace() {
        canvasElement.width = videoElement.videoWidth;
        canvasElement.height = videoElement.videoHeight;
        context.drawImage(videoElement, 0, 0, canvasElement.width, canvasElement.height);

        // Send the image data to the server
        canvasElement.toBlob((blob) => {
            let formData = new FormData();
            formData.append('image', blob);
            
            // Send to server via Fetch API
            fetch('/face-recognition', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.match) {
                    document.getElementById('statusMessage').innerText = "Face Matched!";
                } else {
                    document.getElementById('statusMessage').innerText = "No Match Found.";
                }
            })
            .catch(error => console.error('Error:', error));
        });
    }

    // Start camera feed when modal is opened
    $('#faceLoginModal').on('shown.bs.modal', function() {
        startCamera();
    });

    // Capture and match the face every 2 seconds
    setInterval(captureAndMatchFace, 2000);
</script>



    <!-- Modal for Developers -->
    <div class="modal fade" id="developers">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #28a745; color: white;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Developers</h4>
                </div>
                <div class="modal-body">
                    <p>
                        <div class="row">
                            <div class="col-md-4">
                                <img src="image/CAM00121.jpg" width=100 height=100 alt="Developer" class="img-rounded">
                            </div>
                            <div class="col-md-8">
                                <a style="color: #28a745; font-size: 18px; text-decoration: none;">Kian A. Rodrigez</a>
                                <h4 style="color: #28a745;">+9366717240</h4>
                                <h4 style="color: #28a745;">kianr664@gmail.com</h4>
                            </div>
                        </div>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Admin Login -->
    <div class="modal fade" id="login">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #28a745; color: white;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Admin Login</h4>
                </div>
                <div class="modal-body">
                    <form role="form" method="post" action="admin.php?q=index.php">
                        <div class="form-group">
                        <label class="control-label" for="email">Username</label>
                        <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                            <input type="text" name="uname" maxlength="20" placeholder="Admin Email" class="form-control" required/>
                        </div>
                        <div class="form-group">
                        <label class="control-label" for="email">Password</label>
                        <span class="input-group-text"><i class="fa fa-lock"></i></span>
                            <input type="password" name="password" maxlength="15" placeholder="Password" class="form-control" required/>
                        </div>
                        <div class="form-group text-center">
                            <input type="submit" name="login" value="Login" class="btn btn-register" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
    let video = null;
    let canvas = null;
    let photo_data_input = null;

    function startCamera() {
        video = document.getElementById('camera');
        canvas = document.getElementById('snapshot');
        photo_data_input = document.getElementById('photo_data');
        const captureBtn = document.getElementById('captureBtn');

        navigator.mediaDevices.getUserMedia({ video: true })
            .then(stream => {
                video.srcObject = stream;
                video.style.display = 'block';
                captureBtn.style.display = 'inline-block';
            })
            .catch(err => {
                alert("Camera access denied: " + err);
            });
    }

    function capture() {
        const context = canvas.getContext('2d');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        const dataURL = canvas.toDataURL('image/png');
        document.getElementById('preview').src = dataURL;
        document.getElementById('preview').style.display = 'block';
        photo_data_input.value = dataURL;
        video.style.display = 'none';
        document.getElementById('captureBtn').style.display = 'none';
    }
    // Open the Face Login Modal and start the webcam feed
function openFaceLoginModal() {
    // Show the modal
    $('#faceLoginModal').modal('show');

    // Start the video feed
    startFaceLogin();
}

// Start webcam and video feed
function startFaceLogin() {
    const videoElement = document.getElementById("faceCam");
    const canvasElement = document.getElementById("faceCanvas");
    const statusMessage = document.getElementById("statusMessage");

    // Set up webcam stream
    navigator.mediaDevices.getUserMedia({
        video: true
    }).then(stream => {
        videoElement.srcObject = stream;
        videoElement.style.display = 'block'; // Show the video element
        statusMessage.innerText = "Please position your face in front of the camera for recognition.";

        // Start detecting faces once the video is ready
        videoElement.onplay = function () {
            detectFace();
        };
    }).catch(err => {
        console.log("Error accessing webcam:", err);
        statusMessage.innerText = "Unable to access the camera.";
    });
}

// Perform face recognition and compare with saved faces
function detectFace() {
    const videoElement = document.getElementById("faceCam");
    const canvasElement = document.getElementById("faceCanvas");
    const context = canvasElement.getContext('2d');
    
    // Set canvas size to match the video
    canvasElement.width = videoElement.videoWidth;
    canvasElement.height = videoElement.videoHeight;

    // Draw the current frame from the video to the canvas
    context.drawImage(videoElement, 0, 0, canvasElement.width, canvasElement.height);

    // Here you would integrate your face recognition logic.
    // Example: Detect face and compare it with saved photos in the "uploads" folder.

    // After recognition, show status messages or move to the next steps.
    // For demo purposes, assume a match occurs:
    setTimeout(() => {
        statusMessage.innerText = "Face recognized successfully!";
        // You can add a redirect or proceed with login actions here
    }, 2000);
}

// Close modal and stop webcam
function closeFaceLoginModal() {
    $('#faceLoginModal').modal('hide');
    const videoElement = document.getElementById("faceCam");
    const stream = videoElement.srcObject;
    const tracks = stream.getTracks();

    tracks.forEach(track => track.stop()); // Stop the video stream
    videoElement.srcObject = null;
}

</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let video = document.getElementById('faceCam');
    let canvas = document.getElementById('faceCanvas');
    let context = canvas.getContext('2d');

    // Function to start face login process
    function startFaceLogin() {
        navigator.mediaDevices.getUserMedia({ video: true })
            .then((stream) => {
                // Show video and start the camera stream
                video.style.display = 'block';
                video.srcObject = stream;

                // Wait for the camera to warm up (you can adjust this timing)
                setTimeout(() => {
                    // Capture an image from the video stream
                    context.drawImage(video, 0, 0, canvas.width, canvas.height);
                    let faceData = canvas.toDataURL('image/jpeg'); // Capture the image as base64

                    // Send the captured image to the server
                    fetch('face_login.py', {
                        method: 'POST',
                        body: JSON.stringify({ image: faceData }),
                        headers: { 'Content-Type': 'application/json' }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'success') {
                            alert('Face login successful!');
                            window.location.href = 'index.php'; // Redirect after successful login
                        } else {
                            alert('Face not recognized.');
                        }
                    })
                    .catch((err) => {
                        console.error('Error during face recognition:', err);
                        alert('An error occurred during face recognition.');
                    });
                }, 3000); // Wait 3 seconds before capturing the photo
            })
            .catch((err) => {
                console.error('Camera error:', err);
                alert("Unable to access camera.");
            });
    }

    // Attach the startFaceLogin function to your button
    document.getElementById('startFaceLoginBtn').addEventListener('click', startFaceLogin);
});
</script>


</body>
</html>


