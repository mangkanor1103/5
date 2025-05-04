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

// Track if the user is currently taking an exam
if (!isset($_SESSION['exam_active'])) {
    $_SESSION['exam_active'] = false; // Default to inactive
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RS Online Exam System</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#28a745',     // Green color matching index.php
                        'primary-dark': '#218838', // Darker green for hover states
                        'primary-light': '#9be3b0', // Light green for subtle highlights
                        secondary: '#dc3545',   // Red secondary color
                        'secondary-dark': '#bd2130', // Darker red for hover states
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'bounce-slow': 'bounce 3s infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-20px)' },
                        },
                    }
                }
            }
        }
    </script>
    
    <style>
        /* Base styling to match index.php */
        body {
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
            text-align: center;
        }
        
        .animated-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background: linear-gradient(120deg, #dff8e7 0%, #b6e6c4 100%);
            overflow: hidden;
        }
        
        .floating-icon {
            position: absolute;
            opacity: 0.5;
            filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.15));
            z-index: -1;
            transition: all 0.3s ease;
            color: #28a745;
        }
        
        .floating-icon:hover {
            opacity: 0.7;
            transform: scale(1.2);
        }
        
        @keyframes blob {
            0%, 100% { border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%; }
            25% { border-radius: 30% 60% 70% 40% / 50% 60% 30% 60%; }
            50% { border-radius: 50% 60% 30% 40% / 40% 30% 70% 60%; }
            75% { border-radius: 40% 30% 70% 60% / 60% 40% 30% 70%; }
        }
        
        .blob {
            position: absolute;
            background: rgba(40, 167, 69, 0.18);
            width: 300px;
            height: 300px;
            animation: blob 15s linear infinite alternate;
            z-index: -1;
        }
        
        .form-input {
            @apply w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-300;
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
        }
        
        .form-input:hover {
            @apply border-gray-400;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.08);
        }
        
        .form-input:focus {
            @apply border-primary;
            box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.25);
            outline: none;
        }
        
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #374151;
            font-size: 0.875rem;
            text-align: left;
        }
        
        .btn-primary {
            @apply bg-primary hover:bg-primary-dark text-white font-medium py-2 px-6 rounded-lg transform transition-all duration-300 hover:scale-105 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-primary focus:ring-opacity-50;
        }
        
        .btn-secondary {
            @apply bg-secondary hover:bg-secondary-dark text-white font-medium py-2 px-6 rounded-lg transform transition-all duration-300 hover:scale-105 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-secondary focus:ring-opacity-50;
        }
        
        .btn-outline {
            @apply border border-gray-400 text-gray-700 font-medium py-2 px-6 rounded-lg transform transition-all duration-300 hover:scale-105 hover:shadow-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50;
        }
        
        /* Tailwind-style Button Register */
        .btn-register {
            @apply bg-secondary hover:bg-primary text-white font-medium py-2 px-4 rounded-lg transform transition-all duration-300 hover:scale-105 hover:shadow-lg focus:outline-none;
        }
        
        /* Modal styling */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 50;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            padding: 1rem;
        }
        
        .modal-content {
            background-color: white;
            border-radius: 0.75rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            width: 100%;
            max-width: 28rem;
            transform: scale(0.95);
            transition: transform 0.3s ease-in-out;
            text-align: center;
        }
        
        .modal.active {
            display: flex !important;
            animation: fadeIn 0.3s ease-out forwards;
        }
        
        .modal.active .modal-content {
            transform: scale(1);
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>

<body class="min-h-screen flex flex-col">
    <!-- Animated Background -->
    <div class="animated-bg">
        <div class="blob" style="top: 10%; left: 10%;"></div>
        <div class="blob" style="top: 60%; left: 80%;"></div>
        <div class="blob" style="top: 80%; left: 30%;"></div>
        
        <!-- Floating Icons -->
        <i class="fas fa-graduation-cap floating-icon text-5xl animate-float" style="top: 15%; left: 10%;"></i>
        <i class="fas fa-book floating-icon text-4xl animate-pulse-slow" style="top: 30%; left: 85%;"></i>
        <i class="fas fa-laptop floating-icon text-5xl animate-bounce-slow" style="top: 70%; left: 15%;"></i>
        <i class="fas fa-pencil-alt floating-icon text-4xl animate-float" style="top: 80%; left: 80%; animation-delay: 2s;"></i>
        <i class="fas fa-users floating-icon text-5xl animate-pulse-slow" style="top: 40%; left: 50%; animation-delay: 1s;"></i>
    </div>

    <!-- Header -->
    <header class="fixed w-full bg-white bg-opacity-90 backdrop-filter backdrop-blur-lg shadow-md z-50 transition-all duration-300">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <img src="image/rslogo.jpg" alt="RS Logo" class="h-12 w-12 rounded-full shadow-md transition-transform duration-300 hover:scale-110">
                <h1 class="text-xl md:text-2xl font-bold text-primary">RS Online Exam</h1>
            </div>
            <div class="flex items-center space-x-4">
                <span class="text-gray-700 font-medium">Hello, <span class="text-primary font-semibold"><?php echo htmlspecialchars($name); ?></span></span>
                <a href="logout.php?q=account.php" class="btn-secondary flex items-center space-x-2 text-sm">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow pt-24 pb-16">
        <div class="container mx-auto px-4 py-8">
            <?php if (@$_GET['q'] == 1) { ?>
                <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden transform transition-all duration-500 hover:shadow-2xl mb-10">
                    <div class="p-8 md:p-12 bg-gradient-to-br from-white to-green-50">
                        <h2 class="text-2xl md:text-3xl font-bold text-center text-primary mb-8">Available Tests</h2>
                        
                        <div class="overflow-x-auto">
                            <table class="w-full table-auto border-collapse">
                                <thead>
                                    <tr class="bg-gray-50 border-b-2 border-gray-200">
                                        <th class="px-4 py-3 text-left">S.N.</th>
                                        <th class="px-4 py-3 text-left">Topic</th>
                                        <th class="px-4 py-3 text-center">Total Question</th>
                                        <th class="px-4 py-3 text-center">Marks</th>
                                        <th class="px-4 py-3 text-center">Time limit</th>
                                        <th class="px-4 py-3 text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $result = mysqli_query($con, "SELECT * FROM quiz ORDER BY date DESC") or die('Error');
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
                                            echo '<tr class="border-b border-gray-200 hover:bg-gray-50">';
                                            echo '<td class="px-4 py-3">' . $c++ . '</td>';
                                            echo '<td class="px-4 py-3">' . $title . '</td>';
                                            echo '<td class="px-4 py-3 text-center">' . $total . '</td>';
                                            echo '<td class="px-4 py-3 text-center">' . $sahi * $total . '</td>';
                                            echo '<td class="px-4 py-3 text-center">' . $time . '&nbsp;min</td>';
                                            echo '<td class="px-4 py-3 text-center">
                                                <a href="account.php?q=quiz&step=2&eid=' . $eid . '&n=1&t=' . $total . '" class="btn-register inline-flex items-center justify-center space-x-1">
                                                    <i class="fas fa-play-circle"></i>
                                                    <span>Start</span>
                                                </a>
                                            </td>';
                                            echo '</tr>';
                                        } else {
                                            echo '<tr class="border-b border-gray-200 hover:bg-gray-50 text-primary">';
                                            echo '<td class="px-4 py-3">' . $c++ . '</td>';
                                            echo '<td class="px-4 py-3">' . $title . '&nbsp;<i class="fas fa-check-circle" title="This exam has been already solved by you"></i></td>';
                                            echo '<td class="px-4 py-3 text-center">' . $total . '</td>';
                                            echo '<td class="px-4 py-3 text-center">' . $sahi * $total . '</td>';
                                            echo '<td class="px-4 py-3 text-center">' . $time . '&nbsp;min</td>';
                                            echo '<td class="px-4 py-3 text-center">
                                                <a href="update.php?q=quizre&step=25&eid=' . $eid . '&n=1&t=' . $total . '" class="btn-register inline-flex items-center justify-center space-x-1">
                                                    <i class="fas fa-redo"></i>
                                                    <span>Restart</span>
                                                </a>
                                            </td>';
                                            echo '</tr>';
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <?php
            if (@$_GET['q'] == 'quiz' && @$_GET['step'] == 2) {
                $eid = @$_GET['eid'];
                $sn = @$_GET['n'];
                $total = @$_GET['t'];
                $q = mysqli_query($con, "SELECT * FROM questions WHERE eid='$eid' ORDER BY RAND()");
            ?>
                <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden transform transition-all duration-500 hover:shadow-2xl">
                    <div class="p-8 md:p-12 bg-gradient-to-br from-white to-green-50 relative">
                        <h2 class="text-2xl md:text-3xl font-bold text-center text-primary mb-8 pb-2 border-b-2 border-primary">Question <?php echo $sn; ?></h2>
                        
                        <?php
                        $row = mysqli_fetch_array($q);
                        $qns = $row['qns'];
                        $qid = $row['qid'];
                        ?>
                        
                        <p class="text-lg mb-6"><?php echo $qns; ?></p>
                        
                        <form action="update.php?q=quiz&step=2&eid=<?php echo $eid; ?>&n=<?php echo $sn; ?>&t=<?php echo $total; ?>&qid=<?php echo $qid; ?>" method="POST" class="space-y-4">
                            <?php
                            $q = mysqli_query($con, "SELECT * FROM options WHERE qid='$qid' ORDER BY RAND()");
                            $optionLabels = ['A', 'B', 'C', 'D']; // Labels for options
                            $index = 0; // Index for option labels
                            
                            while ($row = mysqli_fetch_array($q)) {
                                $option = $row['option'];
                                $optionid = $row['optionid'];
                            ?>
                                <div class="flex items-center space-x-3 p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                                    <input type="radio" name="ans" id="option<?php echo $index; ?>" value="<?php echo $optionid; ?>" class="form-radio h-5 w-5 text-primary focus:ring-primary">
                                    <label for="option<?php echo $index; ?>" class="flex-1 cursor-pointer">
                                        <span class="font-medium"><?php echo $optionLabels[$index++]; ?>.</span> <?php echo $option; ?>
                                    </label>
                                </div>
                            <?php } ?>
                            
                            <div class="mt-8 text-center">
                                <button type="submit" class="btn-primary px-8 py-3 text-lg">
                                    <span class="flex items-center justify-center space-x-2">
                                        <i class="fas fa-paper-plane"></i>
                                        <span>Submit Answer</span>
                                    </span>
                                </button>
                            </div>
                        </form>
                        
                        <!-- Camera Section -->
                        <div class="absolute bottom-10 right-10 w-48 h-48 bg-gray-100 rounded-lg shadow-md overflow-hidden border-2 border-primary p-1">
                            <img src="http://127.0.0.1:5000/video_feed" class="w-full h-full object-cover rounded">
                        </div>
                    </div>
                </div>
            <?php } ?>

            <?php
            if (@$_GET['q'] == 'result' && @$_GET['eid']) {
                $eid = @$_GET['eid'];
                $q = mysqli_query($con, "SELECT * FROM history WHERE eid='$eid' AND email='$email' ") or die('Error157');
            ?>
                <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden transform transition-all duration-500 hover:shadow-2xl">
                    <div class="p-8 md:p-12 bg-gradient-to-br from-white to-green-50">
                        <h2 class="text-2xl md:text-3xl font-bold text-center text-primary mb-8">Test Result</h2>
                        
                        <div class="overflow-x-auto">
                            <table class="w-full table-auto border-collapse">
                                <tbody>
                                    <?php
                                    while ($row = mysqli_fetch_array($q)) {
                                        $s = $row['score'];
                                        $w = $row['wrong'];
                                        $r = $row['sahi'];
                                        $qa = $row['level'];
                                    ?>
                                        <tr class="border-b border-gray-200">
                                            <td class="px-4 py-4 font-medium text-green-600">Right Answers</td>
                                            <td class="px-4 py-4 font-bold text-green-600"><?php echo $r; ?></td>
                                        </tr>
                                        <tr class="border-b border-gray-200">
                                            <td class="px-4 py-4 font-medium text-blue-500">Total Questions</td>
                                            <td class="px-4 py-4 font-bold text-blue-500"><?php echo $qa; ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-6 text-center">
                            <a href="account.php?q=1" class="btn-primary px-6 py-2 inline-flex items-center justify-center space-x-2">
                                <i class="fas fa-home"></i>
                                <span>Return to Home</span>
                            </a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-primary text-white py-6 mt-auto">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-center">
                <div class="group">
                    <a href="#" id="developersBtn" class="inline-flex justify-center items-center space-x-2 hover:text-green-200 transition-colors duration-300">
                        <i class="fas fa-code text-xl"></i>
                        <span>Developers</span>
                    </a>
                </div>
                <div class="group">
                    <a href="feedback.php" target="_blank" class="inline-flex justify-center items-center space-x-2 hover:text-green-200 transition-colors duration-300">
                        <i class="fas fa-comments text-xl"></i>
                        <span>Feedback</span>
                    </a>
                </div>
            </div>
            <div class="text-center mt-6 text-sm text-green-100">
                &copy; 2025 RS Online Exam System | All Rights Reserved
            </div>
        </div>
    </footer>

    <!-- Developers Modal -->
    <div id="developersModal" class="modal">
        <div class="modal-content w-full max-w-md">
            <div class="bg-primary text-white px-6 py-4 rounded-t-xl flex justify-between items-center">
                <h3 class="text-xl font-bold">Developers</h3>
                <button class="closeModal text-white text-2xl hover:text-green-200 transition-colors">&times;</button>
            </div>
            <div class="p-6">
                <div class="flex flex-col md:flex-row items-center md:space-x-4 space-y-4 md:space-y-0">
                    <div class="flex-shrink-0">
                        <img src="image/CAM00121.jpg" class="h-24 w-24 object-cover rounded-full shadow-lg border-2 border-primary transition-transform duration-300 hover:scale-105" alt="Developer">
                    </div>
                    <div class="text-center md:text-left">
                        <h4 class="text-xl font-bold text-primary mb-1">Kian A. Rodrigez</h4>
                        <p class="flex items-center justify-center md:justify-start text-gray-600 mb-1">
                            <i class="fas fa-phone-alt mr-2 text-primary"></i>
                            +9366717240
                        </p>
                        <p class="flex items-center justify-center md:justify-start text-gray-600">
                            <i class="fas fa-envelope mr-2 text-primary"></i>
                            kianr664@gmail.com
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script for face detection -->
    <script>
    // JavaScript for face detection
    let faceDetectionInterval;

    function checkFacePosition() {
        fetch('http://127.0.0.1:5000/face_position')
            .then(response => {
                if (!response.ok) throw new Error('Server not reachable');
                return response.json();
            })
            .then(data => {
                console.log("Face Position:", data.position);
                console.log("Gaze Direction:", data.gaze);
                console.log("Mouth Status:", data.mouth);

                if (data.position === "LEFT" || data.position === "RIGHT" ||
                    data.gaze === "LEFT" || data.gaze === "RIGHT" ||
                    data.mouth === "OPEN") {

                    let warnings = parseInt(sessionStorage.getItem("warnings")) || 0;
                    warnings++;
                    sessionStorage.setItem("warnings", warnings);

                    if (warnings >= 3) {
                        clearInterval(faceDetectionInterval);
                        sessionStorage.clear(); // Clear warnings

                        // Call the backend to disable the user
                        fetch('disable_user.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({ email: '<?php echo $_SESSION["email"]; ?>' }),
                        })
                        .then(disableResponse => {
                            if (disableResponse.ok) {
                                console.log("User disabled successfully");
                                return fetch('logout.php');
                            } else {
                                throw new Error("Failed to disable user");
                            }
                        })
                        .then(logoutResponse => {
                            if (logoutResponse.ok) {
                                console.log("Logged out successfully");
                                setTimeout(() => {
                                    window.location.reload(); 
                                }, 1000);
                                return fetch('http://127.0.0.1:5000/restart', { method: 'POST' });
                            } else {
                                console.error("Logout failed");
                            }
                        })
                        .then(restartResponse => {
                            if (restartResponse.ok) {
                                console.log("Server restarting...");
                            } else {
                                console.error("Server restart failed");
                            }
                        })
                        .catch(error => console.error("Error:", error));
                    } else {
                        window.location.href = "warning.php";
                    }
                }
            })
            .catch(error => {
                console.error("Error fetching face position:", error);
                setTimeout(checkFacePosition, 5000); // Retry after 5 seconds
            });
    }

    function startFaceDetection() {
        if (!faceDetectionInterval) {
            faceDetectionInterval = setInterval(checkFacePosition, 1000);
        }
    }

    function stopFaceDetection() {
        clearInterval(faceDetectionInterval);
        faceDetectionInterval = null;
    }

    // Handle modal functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Get all modals
        const modalElements = document.querySelectorAll('.modal');
        
        // Open modal function
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            
            if (modal) {
                // Hide all modals first
                modalElements.forEach(m => {
                    m.classList.remove('active');
                });
                
                // Show the selected modal
                modal.classList.add('active');
                document.body.style.overflow = 'hidden';
            }
        }
        
        // Set up click listeners for open buttons
        const developersBtn = document.getElementById('developersBtn');
        if (developersBtn) {
            developersBtn.addEventListener('click', (e) => {
                e.preventDefault();
                openModal('developersModal');
            });
        }
        
        // Close modal when clicking close button
        document.querySelectorAll('.closeModal').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const modal = btn.closest('.modal');
                if (modal) {
                    modal.classList.remove('active');
                    document.body.style.overflow = '';
                }
            });
        });
        
        // Close modal when clicking outside
        modalElements.forEach(modal => {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    modal.classList.remove('active');
                    document.body.style.overflow = '';
                }
            });
        });

        // Start/stop face detection based on session state
        <?php if ($_SESSION['exam_active']) { ?>
            startFaceDetection();
        <?php } else { ?>
            stopFaceDetection();
        <?php } ?>
    });
    </script>
</body>
</html>