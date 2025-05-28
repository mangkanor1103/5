<?php
// Start session at the very beginning of the file
include_once 'dbConnection.php';
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RS Online Exam System - Admin Dashboard</title>
    
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
        /* Base styling to match account.php */
        body {
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
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
        
        .nav-item {
            @apply relative px-4 py-3 flex items-center text-gray-700 hover:text-primary transition-all duration-300;
        }
        
        .nav-item.active {
            @apply text-primary font-medium;
        }
        
        .nav-item.active::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            background-color: #28a745;
            transform: scaleX(0.8);
            transition: transform 0.3s ease;
        }
        
        .nav-item:hover::after {
            transform: scaleX(1);
        }
        
        .panel-title {
            @apply text-2xl font-bold text-primary mb-4 pb-2 border-b-2 border-primary;
        }
        
        .action-btn {
            transition: all 0.3s ease;
        }
        
        .action-btn:hover {
            transform: translateY(-2px);
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
                <h1 class="text-xl md:text-2xl font-bold text-primary">RS Online Exam - Admin</h1>
            </div>

            <?php
            include_once 'dbConnection.php';
            $email = $_SESSION['email'];
            if (!(isset($_SESSION['email']))) {
                header("location:index.php");
            } else {
                $name = $_SESSION['name'];
                echo '<div class="flex items-center space-x-4">
                    <span class="text-gray-700 font-medium">Hello, <span class="text-primary font-semibold">'.htmlspecialchars($name).'</span></span>
                    <a href="logout.php?q=account.php" class="btn-secondary flex items-center space-x-2 text-sm">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </div>';
            }
            ?>
        </div>
    </header>

    <!-- Navigation Menu -->
    <nav class="fixed top-20 w-full bg-white bg-opacity-90 backdrop-filter backdrop-blur-lg shadow-md z-40 transition-all duration-300">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center">
                <a class="nav-item <?php if(@$_GET['q']==0) echo 'active'; ?>" href="dash.php?q=0">
                    <i class="fas fa-home mr-2"></i> Home
                </a>
                <a class="nav-item <?php if(@$_GET['q']==1) echo 'active'; ?>" href="dash.php?q=1">
                    <i class="fas fa-users mr-2"></i> Users
                </a>
                <a class="nav-item <?php if(@$_GET['q']==2) echo 'active'; ?>" href="dash.php?q=2">
                    <i class="fas fa-trophy mr-2"></i> Rankings
                </a>
                <a class="nav-item <?php if(@$_GET['q']==3) echo 'active'; ?>" href="dash.php?q=3">
                    <i class="fas fa-comments mr-2"></i> Feedback
                </a>
                <a class="nav-item <?php if(@$_GET['q']==4) echo 'active'; ?>" href="dash.php?q=4">
                    <i class="fas fa-plus-circle mr-2"></i> Add Exams
                </a>
                <a class="nav-item <?php if(@$_GET['q']==5) echo 'active'; ?>" href="dash.php?q=5">
                    <i class="fas fa-exclamation-triangle mr-2"></i> Warnings
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow pt-40 pb-16">
        <div class="container mx-auto px-4 py-8">
            <!-- Breadcrumb -->
            <div class="flex items-center text-sm mb-6 bg-white rounded-lg px-4 py-2 shadow-md">
                <a href="dash.php?q=0" class="text-primary hover:text-primary-dark transition-colors">Dashboard</a>
                <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                <span class="text-gray-600">
                    <?php 
                        if(@$_GET['q']==0) echo "Exams Management";
                        else if(@$_GET['q']==1) echo "User Management";
                        else if(@$_GET['q']==2) echo "Rankings";
                        else if(@$_GET['q']==3) echo "Feedback";
                        else if(@$_GET['q']==4) echo "Add Exam";
                        else if(@$_GET['q']==5) echo "Warnings";
                        else echo "Dashboard";
                    ?>
                </span>
            </div>

            <div class="max-w-6xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden transform transition-all duration-500 hover:shadow-2xl mb-10">
                <div class="p-8 md:p-12 bg-gradient-to-br from-white to-green-50">
                    
                    <?php if(@$_GET['q']==0) { ?>
                        <h2 class="panel-title">Exam Management</h2>
                        <p class="text-gray-600 mb-6">Manage all exams in the system. You can add, edit, or remove exams from here.</p>
                        
                        <?php
                        $result = mysqli_query($con,"SELECT * FROM quiz ORDER BY date DESC") or die('Error');
                        if(mysqli_num_rows($result) > 0) {
                            echo '<div class="overflow-x-auto">
                            <table class="min-w-full bg-white border-collapse">
                                <thead>
                                    <tr class="bg-gray-50 border-b-2 border-gray-200">
                                        <th class="px-4 py-3 text-left">S.N.</th>
                                        <th class="px-4 py-3 text-left">Topic</th>
                                        <th class="px-4 py-3 text-center">Questions</th>
                                        <th class="px-4 py-3 text-center">Marks</th>
                                        <th class="px-4 py-3 text-center">Time</th>
                                        <th class="px-4 py-3 text-center">Restart</th>
                                        <th class="px-4 py-3 text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>';
                            $c=1;
                            while($row = mysqli_fetch_array($result)) {
                                $title = $row['title'];
                                $total = $row['total'];
                                $sahi = $row['sahi'];
                                $time = $row['time'];
                                $eid = $row['eid'];
                                $allow_restart = $row['allow_restart'];
                                
                                echo '<tr class="border-b border-gray-200 hover:bg-gray-50">
                                    <td class="px-4 py-4">'.$c++.'</td>
                                    <td class="px-4 py-4 font-medium">'.$title.'</td>
                                    <td class="px-4 py-4 text-center">'.$total.'</td>
                                    <td class="px-4 py-4 text-center">'.$sahi*$total.'</td>
                                    <td class="px-4 py-4 text-center">'.$time.'&nbsp;min</td>
                                    <td class="px-4 py-4 text-center">';
                                
                                if($allow_restart == 1) {
                                    echo '<span class="px-2 py-1 rounded-full bg-green-100 text-green-800 text-xs font-semibold">Enabled</span>
                                        <a href="update.php?action=toggle_restart&eid='.$eid.'&val=0" class="ml-2 text-sm text-blue-500 hover:underline">Disable</a>';
                                } else {
                                    echo '<span class="px-2 py-1 rounded-full bg-red-100 text-red-800 text-xs font-semibold">Disabled</span>
                                        <a href="update.php?action=toggle_restart&eid='.$eid.'&val=1" class="ml-2 text-sm text-blue-500 hover:underline">Enable</a>';
                                }
                                
                                echo '</td>
                                    <td class="px-4 py-4 text-center">
                                        <a href="update.php?q=rmquiz&eid='.$eid.'" class="btn-secondary inline-flex items-center justify-center space-x-1 py-2 px-4" onclick="return confirm(\'Are you sure you want to remove this exam?\');">
                                            <i class="fas fa-trash-alt"></i>
                                            <span>Remove</span>
                                        </a>
                                    </td>
                                </tr>';
                            }
                            echo '</tbody></table></div>';
                        } else {
                            echo '<div class="text-center p-8 bg-gray-50 rounded-lg">
                                <i class="fas fa-info-circle text-4xl text-gray-400 mb-3"></i>
                                <p class="text-gray-500 mb-4">No exams available. Add an exam to get started.</p>
                                <a href="dash.php?q=4" class="btn-primary inline-flex items-center justify-center space-x-2">
                                    <i class="fas fa-plus"></i>
                                    <span>Add New Exam</span>
                                </a>
                            </div>';
                        }
                        ?>
                    <?php } ?>

                    <?php if(@$_GET['q'] == 2) { ?>
                        <h2 class="panel-title">User Rankings</h2>
                        <p class="text-gray-600 mb-6">View and manage user performance rankings based on their exam scores.</p>
                        
                        <?php
                        // Get all exams for the filter dropdown
                        $exams_result = mysqli_query($con, "SELECT * FROM quiz ORDER BY title ASC") or die('Error fetching exams');
                        
                        // Check if a specific exam is selected for filtering
                        $selected_eid = isset($_GET['eid']) ? $_GET['eid'] : '';
                        
                        // Show different queries based on whether a filter is applied
                        if (!empty($selected_eid)) {
                            // Get rankings from history table for the specific exam
                            $q = mysqli_query($con, "SELECT h.email, h.score, u.name FROM history h 
                                                    JOIN user u ON h.email = u.email 
                                                    WHERE h.eid='$selected_eid' 
                                                    ORDER BY h.score DESC") or die('Error fetching filtered rankings');
                            $ranking_title = "Exam Rankings";
                        } else {
                            // Get overall rankings from the rank table
                            $q = mysqli_query($con, "SELECT * FROM rank ORDER BY score DESC") or die('Error223');
                            $ranking_title = "Overall Rankings";
                        }
                        
                        echo '<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                            <div class="bg-gray-50 px-4 py-2 rounded-lg shadow-sm">
                                <span class="text-gray-600">' . $ranking_title . ': <span class="font-bold text-primary">'.mysqli_num_rows($q).'</span></span>
                            </div>
                            
                            <div class="flex flex-col md:flex-row gap-3 items-start md:items-center">
                                <form method="get" action="dash.php" class="flex items-center space-x-2">
                                    <input type="hidden" name="q" value="2">
                                    <select name="eid" class="form-input py-2 px-3" onchange="this.form.submit()">
                                        <option value="">Overall Rankings</option>';
                                        
                                        while($exam = mysqli_fetch_array($exams_result)) {
                                            $selected = ($selected_eid == $exam['eid']) ? 'selected' : '';
                                            echo '<option value="'.$exam['eid'].'" '.$selected.'>'.$exam['title'].'</option>';
                                        }
                                        
                        echo '      </select>
                                </form>
                                
                                <form method="post" action="" class="flex items-center">
                                    <button type="submit" name="clear_ranking" class="btn-secondary inline-flex items-center justify-center space-x-2" onclick="return confirm(\'Are you sure you want to clear the ranking?\');">
                                        <i class="fas fa-trash-alt"></i>
                                        <span>Clear Ranking</span>
                                    </button>
                                </form>
                            </div>
                        </div>';
                        
                        if(mysqli_num_rows($q) > 0) {
                            echo '<div class="overflow-x-auto">
                            <table class="min-w-full bg-white border-collapse">
                            <thead>
                                <tr class="bg-gray-50 border-b-2 border-gray-200">
                                    <th class="px-4 py-3 text-left">Rank</th>
                                    <th class="px-4 py-3 text-left">Name</th>
                                    <th class="px-4 py-3 text-center">Score</th>
                                    <th class="px-4 py-3 text-center">Remarks</th>
                                </tr>
                            </thead>
                            <tbody>';
                            $c = 0;
                            while ($row = mysqli_fetch_array($q)) {
                                if (!empty($selected_eid)) {
                                    // We already have name and score from our JOIN query
                                    $name = $row['name'];
                                    $s = $row['score'];
                                    
                                    // NEW: Get total possible score for this exam
                                    $examQuery = mysqli_query($con, "SELECT total, sahi FROM quiz WHERE eid='$selected_eid'") or die('Error fetching exam details');
                                    $examData = mysqli_fetch_array($examQuery);
                                    $totalPossible = $examData['total'] * $examData['sahi'];
                                } else {
                                    // For overall rankings, get name from user table
                                    $e = $row['email'];
                                    $s = $row['score'];
                                    $q12 = mysqli_query($con, "SELECT * FROM user WHERE email='$e'") or die('Error231');
                                    while ($row = mysqli_fetch_array($q12)) {
                                        $name = $row['name'];
                                    }
                                }
                                $c++;
                                echo '<tr class="border-b border-gray-200 hover:bg-gray-50">
                                    <td class="px-4 py-4">';
                                    if($c == 1) echo '<div class="flex items-center"><i class="fas fa-trophy text-yellow-500 mr-2"></i> '.$c.'</div>';
                                    else if($c == 2) echo '<div class="flex items-center"><i class="fas fa-trophy text-gray-400 mr-2"></i> '.$c.'</div>';
                                    else if($c == 3) echo '<div class="flex items-center"><i class="fas fa-trophy text-yellow-700 mr-2"></i> '.$c.'</div>';
                                    else echo $c;
                                    echo '</td>
                                    <td class="px-4 py-4 font-medium">'.$name.'</td>
                                    <td class="px-4 py-4 text-center text-primary font-bold">';
                                    
                                    // Display score as fraction for specific exams
                                    if (!empty($selected_eid)) {
                                        echo $s . ' / ' . $totalPossible;
                                    } else {
                                        echo $s;
                                    }
                                    
                                    echo '</td>
                                    <td class="px-4 py-4 text-center">';
                                    
                                    // Add remarks based on score
                                    if (!empty($selected_eid)) {
                                        // Calculate percentage
                                        $percentage = ($s / $totalPossible) * 100;
                                        
                                        if ($percentage >= 90) {
                                            echo '<span class="px-2 py-1 rounded-full bg-blue-100 text-blue-800 text-xs font-semibold">Excellent (A)</span>';
                                        } else if ($percentage >= 85) {
                                            echo '<span class="px-2 py-1 rounded-full bg-green-100 text-green-800 text-xs font-semibold">Very Satisfactory (B+)</span>';
                                        } else if ($percentage >= 80) {
                                            echo '<span class="px-2 py-1 rounded-full bg-green-100 text-green-800 text-xs font-semibold">Satisfactory (B)</span>';
                                        } else if ($percentage >= 75) {
                                            echo '<span class="px-2 py-1 rounded-full bg-yellow-100 text-yellow-800 text-xs font-semibold">Fairly Satisfactory (C)</span>';
                                        } else {
                                            echo '<span class="px-2 py-1 rounded-full bg-red-100 text-red-800 text-xs font-semibold">Did Not Meet Expectations (F)</span>';
                                        }
                                    } else {
                                        // For overall rankings, just show general performance indicators
                                        if ($s >= 100) {
                                            echo '<span class="px-2 py-1 rounded-full bg-blue-100 text-blue-800 text-xs font-semibold">Outstanding</span>';
                                        } else if ($s >= 75) {
                                            echo '<span class="px-2 py-1 rounded-full bg-green-100 text-green-800 text-xs font-semibold">Satisfactory</span>';
                                        } else if ($s >= 50) {
                                            echo '<span class="px-2 py-1 rounded-full bg-yellow-100 text-yellow-800 text-xs font-semibold">Fair</span>';
                                        } else {
                                            echo '<span class="px-2 py-1 rounded-full bg-red-100 text-red-800 text-xs font-semibold">Needs Improvement</span>';
                                        }
                                    }
                                    
                                    echo '</td>
                                </tr>';
                            }
                            echo '</tbody></table></div>';
                        } else {
                            echo '<div class="text-center p-8 bg-gray-50 rounded-lg">
                                <i class="fas fa-chart-bar text-4xl text-gray-400 mb-3"></i>
                                <p class="text-gray-500">No ranking data available yet.</p>
                            </div>';
                        }
                        
                        if (isset($_POST['clear_ranking'])) {
                            mysqli_query($con, "DELETE FROM rank");
                            echo "<script>alert('Ranking cleared successfully!'); window.location.href='dash.php?q=2';</script>";
                        }
                        ?>
                    <?php } ?>

                    <?php if(@$_GET['q']==1) { ?>
                        <h2 class="panel-title">User Management</h2>
                        <p class="text-gray-600 mb-6">Manage all registered users in the system.</p>
                        
                        <?php
                        $result = mysqli_query($con,"SELECT * FROM user") or die('Error');
                        echo '<div class="flex justify-between items-center mb-6">
                            <div class="bg-gray-50 px-4 py-2 rounded-lg shadow-sm">
                                <span class="text-gray-600">Total Users: <span class="font-bold text-primary">'.mysqli_num_rows($result).'</span></span>
                            </div>
                            <form method="post" action="" class="flex items-center">
                                <button type="submit" name="clear_table" class="btn-secondary inline-flex items-center justify-center space-x-2" onclick="return confirm(\'Are you sure you want to clear the table?\');">
                                    <i class="fas fa-trash-alt"></i>
                                    <span>Clear All Users</span>
                                </button>
                            </form>
                        </div>';
                        
                        if(mysqli_num_rows($result) > 0) {
                            echo '<div class="overflow-x-auto">
                            <table class="min-w-full bg-white border-collapse">
                            <thead>
                                <tr class="bg-gray-50 border-b-2 border-gray-200">
                                    <th class="px-4 py-3 text-left">S.N.</th>
                                    <th class="px-4 py-3 text-left">Name</th>
                                    <th class="px-4 py-3 text-left">Gender</th>
                                    <th class="px-4 py-3 text-left">Year and Section</th>
                                    <th class="px-4 py-3 text-left">Email</th>
                                    <th class="px-4 py-3 text-left">Mobile</th>
                                    <th class="px-4 py-3 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>';
                            $c=1;
                            while($row = mysqli_fetch_array($result)) {
                                $name = $row['name'];
                                $mob = $row['mob'];
                                $gender = $row['gender'];
                                $email = $row['email'];
                                $college = $row['college'];
                                echo '<tr class="border-b border-gray-200 hover:bg-gray-50">
                                    <td class="px-4 py-4">'.$c++.'</td>
                                    <td class="px-4 py-4 font-medium">'.$name.'</td>
                                    <td class="px-4 py-4">'.$gender.'</td>
                                    <td class="px-4 py-4">'.$college.'</td>
                                    <td class="px-4 py-4">'.$email.'</td>
                                    <td class="px-4 py-4">'.$mob.'</td>
                                    <td class="px-4 py-4 text-center">
                                        <a title="Delete User" href="update.php?demail='.$email.'" class="btn-secondary inline-flex items-center justify-center space-x-1 py-1 px-3" onclick="return confirm(\'Are you sure you want to delete this user?\');">
                                            <i class="fas fa-user-times"></i>
                                            <span>Delete</span>
                                        </a>
                                    </td>
                                </tr>';
                            }
                            echo '</tbody></table></div>';
                        } else {
                            echo '<div class="text-center p-8 bg-gray-50 rounded-lg">
                                <i class="fas fa-users text-4xl text-gray-400 mb-3"></i>
                                <p class="text-gray-500">No users registered yet.</p>
                            </div>';
                        }
                        
                        if(isset($_POST['clear_table'])) {
                            mysqli_query($con, "DELETE FROM user");
                            echo "<script>alert('All users deleted successfully!'); window.location.href='dash.php?q=1';</script>";
                        }
                        ?>
                    <?php } ?>

                    <?php if(@$_GET['q']==3 && !(@$_GET['fid'])) { ?>
                        <h2 class="panel-title">Feedback Management</h2>
                        <p class="text-gray-600 mb-6">View and manage user feedback submissions.</p>
                        
                        <?php
                        $result = mysqli_query($con,"SELECT * FROM `feedback` ORDER BY `feedback`.`date` DESC") or die('Error');
                        if(mysqli_num_rows($result) > 0) {
                            echo '<div class="overflow-x-auto">
                            <table class="min-w-full bg-white border-collapse">
                            <thead>
                                <tr class="bg-gray-50 border-b-2 border-gray-200">
                                    <th class="px-4 py-3 text-left">S.N.</th>
                                    <th class="px-4 py-3 text-left">Subject</th>
                                    <th class="px-4 py-3 text-left">Email</th>
                                    <th class="px-4 py-3 text-left">Date</th>
                                    <th class="px-4 py-3 text-left">Time</th>
                                    <th class="px-4 py-3 text-left">By</th>
                                    <th class="px-4 py-3 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>';
                            $c=1;
                            while($row = mysqli_fetch_array($result)) {
                                $date = $row['date'];
                                $date= date("d-m-Y",strtotime($date));
                                $time = $row['time'];
                                $subject = $row['subject'];
                                $name = $row['name'];
                                $email = $row['email'];
                                $id = $row['id'];
                                echo '<tr class="border-b border-gray-200 hover:bg-gray-50">
                                    <td class="px-4 py-4">'.$c++.'</td>
                                    <td class="px-4 py-4 font-medium"><a title="Click to open feedback" href="dash.php?q=3&fid='.$id.'" class="hover:text-primary transition-colors">'.$subject.'</a></td>
                                    <td class="px-4 py-4">'.$email.'</td>
                                    <td class="px-4 py-4">'.$date.'</td>
                                    <td class="px-4 py-4">'.$time.'</td>
                                    <td class="px-4 py-4">'.$name.'</td>
                                    <td class="px-4 py-4 text-center">
                                        <div class="flex justify-center space-x-2">
                                            <a title="View Feedback" href="dash.php?q=3&fid='.$id.'" class="bg-primary text-white p-2 rounded-lg hover:bg-primary-dark transition-colors">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a title="Delete Feedback" href="update.php?fdid='.$id.'" class="bg-secondary text-white p-2 rounded-lg hover:bg-secondary-dark transition-colors" onclick="return confirm(\'Are you sure you want to delete this feedback?\');">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>';
                            }
                            echo '</tbody></table></div>';
                        } else {
                            echo '<div class="text-center p-8 bg-gray-50 rounded-lg">
                                <i class="fas fa-comments text-4xl text-gray-400 mb-3"></i>
                                <p class="text-gray-500">No feedback submissions yet.</p>
                            </div>';
                        }
                        ?>
                    <?php } ?>

                    <?php if(@$_GET['fid']) {
                        $id=@$_GET['fid'];
                        $result = mysqli_query($con,"SELECT * FROM feedback WHERE id='$id' ") or die('Error');
                        
                        echo '<div class="mb-6">
                            <a href="dash.php?q=3" class="btn-outline inline-flex items-center space-x-2">
                                <i class="fas fa-arrow-left"></i>
                                <span>Back to Feedback List</span>
                            </a>
                        </div>';
                        
                        while($row = mysqli_fetch_array($result)) {
                            $name = $row['name'];
                            $subject = $row['subject'];
                            $date = $row['date'];
                            $date= date("d-m-Y",strtotime($date));
                            $time = $row['time'];
                            $feedback = $row['feedback'];
                            
                            echo '<div class="bg-white rounded-xl shadow-lg p-6 mb-4 border-l-4 border-primary">
                                <h2 class="text-2xl font-bold mb-4 text-primary">'.$subject.'</h2>
                                <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4 text-sm">
                                        <div class="bg-white p-3 rounded-lg shadow-sm">
                                            <span class="block text-xs text-gray-500 mb-1">Date</span>
                                            <span class="font-medium text-gray-800">'.$date.'</span>
                                        </div>
                                        <div class="bg-white p-3 rounded-lg shadow-sm">
                                            <span class="block text-xs text-gray-500 mb-1">Time</span>
                                            <span class="font-medium text-gray-800">'.$time.'</span>
                                        </div>
                                        <div class="bg-white p-3 rounded-lg shadow-sm">
                                            <span class="block text-xs text-gray-500 mb-1">From</span>
                                            <span class="font-medium text-gray-800">'.$name.'</span>
                                        </div>
                                    </div>
                                    <div class="mt-6 p-5 bg-white rounded-lg border border-gray-200 shadow-sm">
                                        <p class="whitespace-pre-wrap text-gray-700">'.$feedback.'</p>
                                    </div>
                                </div>
                                <div class="flex justify-end">
                                    <a href="update.php?fdid='.$id.'" class="btn-secondary inline-flex items-center space-x-2" onclick="return confirm(\'Are you sure you want to delete this feedback?\');">
                                        <i class="fas fa-trash-alt"></i>
                                        <span>Delete Feedback</span>
                                    </a>
                                </div>
                            </div>';
                        }
                    } ?>

                    <?php if(@$_GET['q']==4 && !(@$_GET['step'])) { ?>
                        <h2 class="panel-title">Add New Exam</h2>
                        <p class="text-gray-600 mb-6">Create a new exam by filling out the form below.</p>
                        
                        <div class="bg-gray-50 p-6 rounded-xl shadow-md">
                            <form class="form-horizontal" name="form" action="update.php?q=addquiz" method="POST">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="mb-4">
                                        <label for="name" class="form-label">Exam Title</label>
                                        <input id="name" name="name" placeholder="Enter exam title" class="form-input" type="text" required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="total" class="form-label">Total Questions</label>
                                        <input id="total" name="total" placeholder="Enter total number of questions" class="form-input" type="number" required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="right" class="form-label">Marks for Correct Answer</label>
                                        <input id="right" name="right" placeholder="Enter marks for right answer" class="form-input" min="0" type="number" required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="wrong" class="form-label">Negative Marks</label>
                                        <input id="wrong" name="wrong" placeholder="Enter negative marks (without sign)" class="form-input" min="0" type="number" required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="time" class="form-label">Time Limit (minutes)</label>
                                        <input id="time" name="time" placeholder="Enter time limit in minutes" class="form-input" min="1" type="number" required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="tag" class="form-label">Tag</label>
                                        <input id="tag" name="tag" placeholder="Enter #tag for searching" class="form-input" type="text">
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label">Allow Exam Restart</label>
                                        <div class="flex items-center space-x-2">
                                            <div class="flex items-center">
                                                <input type="radio" id="restart_yes" name="allow_restart" value="1" class="mr-2">
                                                <label for="restart_yes">Yes</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input type="radio" id="restart_no" name="allow_restart" value="0" class="mr-2" checked>
                                                <label for="restart_no">No</label>
                                            </div>
                                        </div>
                                        <p class="text-gray-500 text-sm mt-1">If enabled, users can take this exam multiple times</p>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="desc" class="form-label">Description</label>
                                    <textarea rows="4" name="desc" id="desc" class="form-input" placeholder="Write exam description here..." required></textarea>
                                </div>
                                <div class="mt-8 flex justify-end">
                                    <button type="submit" class="btn-primary inline-flex items-center justify-center space-x-2 text-lg">
                                        <i class="fas fa-save"></i>
                                        <span>Create Exam</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    <?php } ?>

                    <?php if(@$_GET['q']==4 && @$_GET['step']==1) { ?>
                        <h2 class="panel-title">Add Questions</h2>
                        <p class="text-gray-600 mb-6">Create questions for your exam.</p>
                        
                        <!-- Tabs for question entry methods -->
                        <div class="mb-6">
                            <div class="flex border-b border-gray-200">
                                <button id="individualTab" class="px-4 py-2 font-medium text-primary border-b-2 border-primary" onclick="switchTab('individual')">Individual Questions</button>
                                <button id="bulkTab" class="px-4 py-2 font-medium text-gray-500 hover:text-primary" onclick="switchTab('bulk')">Bulk Import</button>
                            </div>
                        </div>
                        
                        <!-- Individual Questions Form -->
                        <div id="individualForm" class="bg-gray-50 p-6 rounded-xl shadow-md">
                            <form class="form-horizontal" name="form" action="update.php?q=addqns&n=<?php echo @$_GET['n']; ?>&eid=<?php echo @$_GET['eid']; ?>&ch=4" method="POST">
                                <?php
                                for($i=1; $i<=@$_GET['n']; $i++) {
                                    echo '<div class="mb-8 p-5 border border-gray-200 rounded-xl bg-white shadow-sm">
                                        <h3 class="text-xl font-semibold mb-4 text-primary flex items-center">
                                            <span class="h-8 w-8 bg-primary text-white rounded-full flex items-center justify-center mr-3">'.$i.'</span>
                                            Question '.$i.'
                                        </h3>
                                        <div class="mb-5">
                                            <label for="qns'.$i.'" class="form-label">Question Text</label>
                                            <textarea rows="3" name="qns'.$i.'" id="qns'.$i.'" class="form-input" placeholder="Write question '.$i.' here..." required></textarea>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div class="mb-3">
                                                <label for="'.$i.'1" class="form-label">Option A</label>
                                                <input id="'.$i.'1" name="'.$i.'1" placeholder="Enter option A" class="form-input" type="text" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="'.$i.'2" class="form-label">Option B</label>
                                                <input id="'.$i.'2" name="'.$i.'2" placeholder="Enter option B" class="form-input" type="text" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="'.$i.'3" class="form-label">Option C</label>
                                                <input id="'.$i.'3" name="'.$i.'3" placeholder="Enter option C" class="form-input" type="text" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="'.$i.'4" class="form-label">Option D</label>
                                                <input id="'.$i.'4" name="'.$i.'4" placeholder="Enter option D" class="form-input" type="text" required>
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <label for="ans'.$i.'" class="form-label">Correct Answer</label>
                                            <select id="ans'.$i.'" name="ans'.$i.'" class="form-input" required>
                                                <option value="">Select correct answer</option>
                                                <option value="a">Option A</option>
                                                <option value="b">Option B</option>
                                                <option value="c">Option C</option>
                                                <option value="d">Option D</option>
                                            </select>
                                        </div>
                                    </div>';
                                }
                                ?>
                                <div class="mt-8 flex justify-end">
                                    <button type="submit" class="btn-primary inline-flex items-center justify-center space-x-2 text-lg">
                                        <i class="fas fa-save"></i>
                                        <span>Save Questions</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Bulk Import Form -->
                        <div id="bulkForm" class="bg-gray-50 p-6 rounded-xl shadow-md hidden">
                            <form class="form-horizontal" name="bulkform" action="update.php?q=addbulkqns&eid=<?php echo @$_GET['eid']; ?>&ch=4" method="POST">
                                <input type="hidden" name="n" value="<?php echo @$_GET['n']; ?>">
                                
                                <div class="mb-6">
                                    <h3 class="text-lg font-semibold mb-2 text-primary">Bulk Questions Import</h3>
                                    <p class="text-gray-600 mb-4">Paste your questions in the following format (one question per line):</p>
                                    <div class="bg-gray-100 p-4 rounded-lg mb-4 text-sm font-mono">
                                        <p>Question text | Option A | Option B | Option C | Option D | Correct Answer (a,b,c,d)</p>
                                        <p>Example: What is 2+2? | 3 | 4 | 5 | 6 | b</p>
                                    </div>
                                    <textarea rows="15" name="bulk_questions" class="form-input font-mono text-sm" placeholder="Paste your questions here..."></textarea>
                                </div>
                                
                                <div class="mt-8 flex justify-end">
                                    <button type="submit" class="btn-primary inline-flex items-center justify-center space-x-2 text-lg">
                                        <i class="fas fa-file-import"></i>
                                        <span>Import Questions</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                        
                        <script>
                            function switchTab(tab) {
                                // Hide all forms
                                document.getElementById('individualForm').classList.add('hidden');
                                document.getElementById('bulkForm').classList.add('hidden');
                                
                                // Remove active class from all tabs
                                document.getElementById('individualTab').classList.remove('border-primary', 'text-primary');
                                document.getElementById('individualTab').classList.add('text-gray-500');
                                document.getElementById('bulkTab').classList.remove('border-primary', 'text-primary');
                                document.getElementById('bulkTab').classList.add('text-gray-500');
                                
                                // Show selected form and activate tab
                                if (tab === 'individual') {
                                    document.getElementById('individualForm').classList.remove('hidden');
                                    document.getElementById('individualTab').classList.add('border-b-2', 'border-primary', 'text-primary');
                                    document.getElementById('individualTab').classList.remove('text-gray-500');
                                } else {
                                    document.getElementById('bulkForm').classList.remove('hidden');
                                    document.getElementById('bulkTab').classList.add('border-b-2', 'border-primary', 'text-primary');
                                    document.getElementById('bulkTab').classList.remove('text-gray-500');
                                }
                            }
                        </script>
                    <?php } ?>

                    <?php if(@$_GET['q']==5) { ?>
                        <h2 class="panel-title">System Warnings</h2>
                        <p class="text-gray-600 mb-6">Monitor system warnings and potential issues.</p>
                        
                        <?php
                        // Check for various system warnings
                        $warnings = array();
                        
                        // 1. Check for quizzes with no questions
                        $empty_quiz_result = mysqli_query($con, "SELECT q.eid, q.title 
                                           FROM quiz q 
                                           LEFT JOIN questions qn ON q.eid = qn.eid 
                                           WHERE qn.eid IS NULL") or die('Error');
                        while($row = mysqli_fetch_array($empty_quiz_result)) {
                            $warnings[] = array(
                                'type' => 'empty_quiz',
                                'severity' => 'high',
                                'message' => 'Quiz "'.$row['title'].'" has no questions',
                                'eid' => $row['eid']
                            );
                        }
                        
                        // 2. Check for users who haven't taken any quiz
                        $inactive_users_result = mysqli_query($con, "SELECT u.email, u.name 
                                               FROM user u 
                                               LEFT JOIN history h ON u.email = h.email 
                                               WHERE h.email IS NULL") or die('Error');
                        while($row = mysqli_fetch_array($inactive_users_result)) {
                            $warnings[] = array(
                                'type' => 'inactive_user',
                                'severity' => 'medium',
                                'message' => 'User "'.$row['name'].'" has not taken any quiz yet',
                                'email' => $row['email']
                            );
                        }
                        
                        // 3. Check for quizzes with low performance (high failure rate)
                        $quiz_performance_result = mysqli_query($con, "SELECT q.eid, q.title, q.total, q.sahi,
                                                COUNT(h.email) as attempts,
                                                AVG(h.score) as avg_score
                                                FROM quiz q
                                                JOIN history h ON q.eid = h.eid
                                                GROUP BY q.eid
                                                HAVING COUNT(h.email) > 3") or die('Error');
                        while($row = mysqli_fetch_array($quiz_performance_result)) {
                            $max_score = $row['total'] * $row['sahi'];
                            $avg_percent = ($row['avg_score'] / $max_score) * 100;
                            
                            if($avg_percent < 60) {
                                $warnings[] = array(
                                    'type' => 'low_performance',
                                    'severity' => 'medium',
                                    'message' => 'Quiz "'.$row['title'].'" has low average performance ('.round($avg_percent, 1).'%)',
                                    'eid' => $row['eid']
                                );
                            }
                        }
                        
                        // 4. Check for disabled users
                        $disabled_users_result = mysqli_query($con, "SELECT email, name, status FROM user WHERE status=0") or die('Error checking disabled users');
                        while($row = mysqli_fetch_array($disabled_users_result)) {
                            $warnings[] = array(
                                'type' => 'disabled_user',
                                'severity' => 'high',
                                'message' => 'User "'.$row['name'].'" has been disabled',
                                'email' => $row['email']
                            );
                        }
                        
                        // Display warnings
                        if(count($warnings) > 0) {
                            echo '<div class="overflow-x-auto">
                            <table class="min-w-full bg-white border-collapse">
                            <thead>
                                <tr class="bg-gray-50 border-b-2 border-gray-200">
                                    <th class="px-4 py-3 text-left">Warning</th>
                                    <th class="px-4 py-3 text-left">Severity</th>
                                    <th class="px-4 py-3 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>';
                            
                            foreach($warnings as $warning) {
                                echo '<tr class="border-b border-gray-200 hover:bg-gray-50">';
                                
                                // Warning message
                                echo '<td class="px-4 py-4">';
                                
                                // Icon based on warning type
                                if($warning['type'] == 'empty_quiz') {
                                    echo '<div class="flex items-center"><i class="fas fa-exclamation-circle text-yellow-500 mr-2"></i> ';
                                } else if($warning['type'] == 'inactive_user') {
                                    echo '<div class="flex items-center"><i class="fas fa-user-clock text-blue-500 mr-2"></i> ';
                                } else if($warning['type'] == 'low_performance') {
                                    echo '<div class="flex items-center"><i class="fas fa-chart-line text-red-500 mr-2"></i> ';
                                } else if($warning['type'] == 'disabled_user') {
                                    echo '<div class="flex items-center"><i class="fas fa-user-slash text-red-500 mr-2"></i> ';
                                }
                                
                                echo $warning['message'].'</div></td>';
                                
                                // Severity
                                echo '<td class="px-4 py-4">';
                                if($warning['severity'] == 'high') {
                                    echo '<span class="px-2 py-1 rounded-full bg-red-100 text-red-800 text-xs font-semibold">High</span>';
                                } else if($warning['severity'] == 'medium') {
                                    echo '<span class="px-2 py-1 rounded-full bg-yellow-100 text-yellow-800 text-xs font-semibold">Medium</span>';
                                } else {
                                    echo '<span class="px-2 py-1 rounded-full bg-blue-100 text-blue-800 text-xs font-semibold">Low</span>';
                                }
                                echo '</td>';
                                
                                // Actions
                                echo '<td class="px-4 py-4 text-center">';
                                if($warning['type'] == 'empty_quiz') {
                                    echo '<a href="dash.php?q=4&step=1&eid='.$warning['eid'].'" class="btn-primary inline-flex items-center justify-center space-x-1 py-1 px-3">
                                        <i class="fas fa-plus"></i>
                                        <span>Add Questions</span>
                                    </a>';
                                } else if($warning['type'] == 'inactive_user') {
                                    echo '<a href="mailto:'.$warning['email'].'" class="btn-primary inline-flex items-center justify-center space-x-1 py-1 px-3">
                                        <i class="fas fa-envelope"></i>
                                        <span>Contact User</span>
                                    </a>';
                                } else if($warning['type'] == 'low_performance') {
                                    echo '<a href="dash.php?q=0&review='.$warning['eid'].'" class="btn-primary inline-flex items-center justify-center space-x-1 py-1 px-3">
                                        <i class="fas fa-search"></i>
                                        <span>Review Quiz</span>
                                    </a>';
                                } else if($warning['type'] == 'disabled_user') {
                                    echo '<a href="update.php?action=enable_user&email='.$warning['email'].'" class="btn-primary inline-flex items-center justify-center space-x-1 py-1 px-3">
                                        <i class="fas fa-user-check"></i>
                                        <span>Enable User</span>
                                    </a>';
                                }
                                echo '</td></tr>';
                            }
                            
                            echo '</tbody></table></div>';
                        } else {
                            echo '<div class="text-center p-8 bg-gray-50 rounded-lg">
                                <i class="fas fa-check-circle text-5xl text-green-500 mb-3"></i>
                                <p class="text-gray-700 font-medium mb-2">No warnings found</p>
                                <p class="text-gray-500">The system is running smoothly with no detected issues.</p>
                            </div>';
                        }
                        ?>
                    <?php } ?>
                </div>
            </div>
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
                &copy; <?php echo date('Y'); ?> RS Online Exam System | All Rights Reserved
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

    <script>
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
    });
    </script>
</body>
</html>
