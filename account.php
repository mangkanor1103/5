<?php
include_once 'dbConnection.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("location:index.php");
    exit(); // Ensure no further code is executed
} else {
    $name = $_SESSION['name'];
    $email = $_SESSION['email']; // Initialize the email variable
}
?>
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

    <style>
        body {
            background-color: #f8f9fa; /* Light background */
            color: #333;
            font-family: 'Roboto', sans-serif;
            overflow: hidden; /* Prevent body scrolling */
            height: 100vh; /* Full height */
            display: flex;
            flex-direction: column;
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
        .navbar {
            margin-top: 60px; /* Space below the header */
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
            background-color: white;
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
        .footer a {
            color: white;
            text-decoration: none;
            transition: color 0.3s; /* Transition for footer links */
        }
        .footer a:hover {
            color: #00c6ff; /* Change color on hover */
        }
        .quiz-container {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            width: 100%;
            min-width: 1200px; /* Ensures it stays at least 1200px */
            margin: 0 auto;
            padding: 20px;
            position: relative; /* Needed for absolute positioning inside */
        }
        .quiz-section {
            flex: 1;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
            margin-right: 20px;
        }
        .camera-section {
            width: 120px; /* Smaller box */
            height: 120px; /* Square shape */
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
            position: absolute; /* Position inside .quiz-container */
            bottom: 20px; /* Distance from bottom */
            right: 20px; /* Distance from right */
        }
        .camera-section img {
            width: 100%;
            height: auto;
            border-radius: 10px;
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
    </style>
</head>

<body>

<div class="header">
    <h1>Online Exam System</h1>
    <div>
        <span class="pull-right top title1">
            <span class="log1"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;Hello,</span>
            <a href="account.php?q=1" class="log log1" style="color: yellow;"><?php echo htmlspecialchars($name); ?></a>&nbsp;|&nbsp;
            <a href="logout.php?q=account.php" class="log" style="color: yellow;">
                <span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>&nbsp;Logout
            </a>
        </span>
    </div>
</div>


<nav class="navbar navbar-default title1">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav navbar-nav">
                <li <?php if (@$_GET['q'] == 1) echo 'class="active"'; ?>><a href="account.php?q=1"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>&nbsp;Home</a></li>
                <!-- Removed History and Ranking -->
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php if (@$_GET['q'] == 1) { ?>
                <h3 class="text-center" style="margin-top: -220px;">Available Tests</h3> <!-- Moves title higher -->
                <?php
                $result = mysqli_query($con, "SELECT * FROM quiz ORDER BY date DESC") or die('Error');
                echo '<div class="panel"><table class="table table-striped title1">
                <tr><td><b>S.N.</b></td><td><b>Topic</b></td><td><b>Total Question</b></td><td><b>Marks</b></td><td><b>Time limit</b></td><td></td></tr>';
                $c = 1;
                while ($row = mysqli_fetch_array($result)) {
                    $title = $row['title'];
                    $total = $row['total'];
                    $sahi = $row['sahi'];
                    $time = $row['time'];
                    $eid = $row['eid'];
                    $q12 = mysqli_query($con, "SELECT score FROM history WHERE eid='$eid' AND email='$email'") or die('Error98');
                    $rowcount = mysqli_num_rows($q12);
                    if ($rowcount == 0) {
                        echo '<tr><td>' . $c++ . '</td><td>' . $title . '</td><td>' . $total . '</td><td>' . $sahi * $total . '</td><td>' . $time . '&nbsp;min</td>
                        <td><b><a href="account.php?q=quiz&step=2&eid=' . $eid . '&n=1&t=' . $total . '" class="pull-right btn btn-register" style="margin:0px;">
                        <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>&nbsp;<span class="title1"><b>Start</b></span></a></b></td></tr>';
                    } else {
                        echo '<tr style="color:#2db44a"><td>' . $c++ . '</td><td>' . $title . '&nbsp;<span title="This exam has been already solved by you" class="glyphicon glyphicon-ok" aria-hidden="true"></span></td><td>' . $total . '</td><td>' . $sahi * $total . '</td><td>' . $time . '&nbsp;min</td>
                        <td><b><a href="update.php?q=quizre&step=25&eid=' . $eid . '&n=1&t=' . $total . '" class="pull-right btn btn-register" style="margin:0px;">
                        <span class="glyphicon glyphicon-repeat" aria-hidden="true"></span>&nbsp;<span class="title1"><b>Restart</b></span></a></b></td></tr>';
                    }
                }
                echo '</table></div>';
            } ?>

            <?php
            if (@$_GET['q'] == 'quiz' && @$_GET['step'] == 2) {
                $eid = @$_GET['eid'];
                $sn = @$_GET['n'];
                $total = @$_GET['t'];
                $q = mysqli_query($con, "SELECT * FROM questions WHERE eid='$eid' ORDER BY RAND()");
                echo '<div class="quiz-container" style="display: flex; flex-direction: column; align-items: center; gap: 20px; padding: 20px; height: 60vh; position: relative;margin-top: -200px;">';
                echo '<div class="quiz-section" style="flex: 1; width: 100%; max-width: 800px; background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0px 0px 10px rgba(0,0,0,0.1); auto; position: relative;">';
                echo '<h2 style="border-bottom: 2px solid #007bff; padding-bottom: 10px;">Question ' . $sn . '</h2>';

                $row = mysqli_fetch_array($q);
                    $qns = $row['qns'];
                    $qid = $row['qid'];
                    echo '<p style="font-size: 18px; margin-bottom: 15px;">' . $qns . '</p>';


                $q = mysqli_query($con, "SELECT * FROM options WHERE qid='$qid' ORDER BY RAND()");
                echo '<form action="update.php?q=quiz&step=2&eid=' . $eid . '&n=' . $sn . '&t=' . $total . '&qid=' . $qid . '" method="POST">';
                $optionLabels = ['A', 'B', 'C', 'D']; // Labels for options
                $index = 0; // Index for option labels
                while ($row = mysqli_fetch_array($q)) {
                    $option = $row['option'];
                    $optionid = $row['optionid'];
                    echo '<label style="display: block; margin-bottom: 10px;">
                            <input type="radio" name="ans" value="' . $optionid . '" style="margin-right: 10px;">' . $optionLabels[$index++] . '. ' . $option . '
                          </label>';
                }

                echo '<br /><button type="submit" class="btn btn-register" style="padding: 10px 20px; font-size: 16px; border-radius: 5px; cursor : pointer;">
                        Submit
                      </button>
                      </form>';

                // Camera Section (inside the quiz section, slightly above bottom to align with options)
                echo '<div class="camera-section" style="width: 200px; height: 200px; background: #f8f9fa; padding: 10px; border-radius: 10px; box-shadow: 0px 0px 10px rgba(0,0,0,0.1); position: absolute; bottom: 50px; right: 20px; display: flex; align-items: center; justify-content: center;">
                        <img src="http://127.0.0.1:5000/video_feed" style="width: 100%; height: auto; border-radius: 10px;">
                      </div>';

                echo '</div>'; // End of quiz section
                echo '</div>'; // End of quiz container
            }
            ?>

            <?php
            if (@$_GET['q'] == 'result' && @$_GET['eid']) {
                $eid = @$_GET['eid'];
                $q = mysqli_query($con, "SELECT * FROM history WHERE eid='$eid' AND email='$email' ") or die('Error157');
                echo '<div class="panel" style="margin-top: -400px;"> <!-- Move it up -->
                <center><h1 class="title" style="color:#660033">Result</h1><center><br />
                <table class="table table-striped title1" style="font-size:20px;font-weight:1000;">';
                while ($row = mysqli_fetch_array($q)) {
                    $s = $row['score'];
                    $w = $row['wrong'];
                    $r = $row['sahi'];
                    $qa = $row['level'];
                    echo '<tr style="color:#66 CCFF"><td>Total Questions</td><td>' . $qa . '</td></tr>
                          <tr style="color:#99cc32"><td>Right Answer&nbsp;<span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span></td><td>' . $r . '</td></tr>
                          <tr style="color:red"><td>Wrong Answer&nbsp;<span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span></td><td>' . $w . '</td></tr>
                          <tr style="color:#66CCFF"><td>Score&nbsp;<span class="glyphicon glyphicon-star" aria-hidden="true"></span></td><td>' . $s . '</td></tr>';
                }
                $q = mysqli_query($con, "SELECT * FROM rank WHERE email='$email' ") or die('Error157');
                while ($row = mysqli_fetch_array($q)) {
                    $s = $row['score'];
                    echo '<tr style="color:#990000"><td>Overall Score&nbsp;<span class="glyphicon glyphicon-stats" aria-hidden="true"></span></td><td>' . $s . '</td></tr>';
                }
                echo '</table></div>';
            }
            ?>
        </div>
    </div>
</div>

<div class="footer" style="display: flex; justify-content: center; align-items: center; text-align: center; padding: 20px;">
    <div class="row" style="display: flex; gap: 30px;">
        <div class="col-md-4">
            <a href="#" data-toggle="modal" data-target="#developers">Developers</a>
        </div>
        <div class="col-md-4">
            <a href="feedback.php" target="_blank">Feedback</a>
        </div>
    </div>
</div>

<!-- Modal for Developers -->
<div class="modal fade" id="developers">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #28a745; color: white;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Developers</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <img src="image/CAM00121.jpg" width=100 height=100 alt="Developer" class="img-rounded">
                    </div>
                    <div class="col-md-8">
                        <a style="color: #28a745; font-size: 18px; text-decoration: none;">Kian A. Rodriguez</a>
                        <h4 style="color: #28a745;">+917785068889</h4>
                        <h4 style="color: #28a745;">kianr664@gmail.com</h4>
                        <h4 style="color: #28a745;">MinSU</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let faceDetectionInterval;

    function checkFacePosition() {
        fetch('http://192.168.1.6:5000/face_position')
            .then(response => response.json())
            .then(data => {
                console.log("Face Position:", data.position);
                if (data.position === "LEFT" || data.position === "RIGHT") {
                    sessionStorage.setItem("faceDetected", "true");
                    clearInterval(faceDetectionInterval);
                    window.location.href = "warning.html";
                }
            })
            .catch(error => console.error("Error fetching face position:", error));
    }

    function startFaceDetection() {
        if (!faceDetectionInterval) {
            faceDetectionInterval = setInterval(checkFacePosition, 1000);
        }
    }

    function restartFaceDetection() {
        if (sessionStorage.getItem("faceDetected") === "true") {
            sessionStorage.removeItem("faceDetected");
            setTimeout(() => {
                startFaceDetection();
            }, 500);
        } else {
            startFaceDetection();
        }
    }

    window.onload = restartFaceDetection;
</script>

</body>
</html>