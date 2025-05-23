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
                <a class="nav-item <?php if(@$_GET['q']==6) echo 'active'; ?>" href="dash.php?q=6">
                    <i class="fas fa-redo-alt mr-2"></i> Restart Settings
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
                        else if(@$_GET['q']==6) echo "Restart Settings";
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
                                echo '<tr class="border-b border-gray-200 hover:bg-gray-50">
                                    <td class="px-4 py-4">'.$c++.'</td>
                                    <td class="px-4 py-4 font-medium">'.$title.'</td>
                                    <td class="px-4 py-4 text-center">'.$total.'</td>
                                    <td class="px-4 py-4 text-center">'.$sahi*$total.'</td>
                                    <td class="px-4 py-4 text-center">'.$time.'&nbsp;min</td>
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
                                } else {
                                    // For overall rankings, get name from user table
                                    $e = $row['email'];
                                    $s = $row['score'];
                                    $q12 = mysqli_query($con, "SELECT * FROM user WHERE email='$e'") or die('Error231');
                                    while ($row = mysqli_fetch_array($q12)) {
                                        $name = $row['name'];
                                    }
                                }
                                
                                // Determine remarks based on score
                                if ($s >= 12) {
                                    $remarks = '<span class="px-2 py-1 bg-green-100 text-green-800 rounded-full">Excellent</span>';
                                } elseif ($s >= 9) {
                                    $remarks = '<span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full">Very Good</span>';
                                } elseif ($s >= 6) {
                                    $remarks = '<span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full">Good</span>';
                                } elseif ($s >= 3) {
                                    $remarks = '<span class="px-2 py-1 bg-orange-100 text-orange-800 rounded-full">Satisfactory</span>';
                                } else {
                                    $remarks = '<span class="px-2 py-1 bg-red-100 text-red-800 rounded-full">Needs Improvement</span>';
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
                                    <td class="px-4 py-4 text-center text-primary font-bold">'.$s.'</td>
                                    <td class="px-4 py-4 text-center">'.$remarks.'</td>
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
                        
                        <div class="bg-gray-50 p-6 rounded-xl shadow-md">
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
                    <?php } ?>

                    <?php if(@$_GET['q']==5) { ?>
                        <h2 class="panel-title">Warning Records</h2>
                        <p class="text-gray-600 mb-6">Manage users with warnings and control their account status.</p>
                        
                        <?php
                        // Check if an enable/disable action is triggered
                        if (isset($_GET['action']) && isset($_GET['user_email'])) {
                            $userEmail = $_GET['user_email'];
                            $action = $_GET['action'];
                            $status = ($action === 'enable') ? 1 : 0;

                            $updateSql = "UPDATE user SET status = $status WHERE email = '$userEmail'";
                            if ($con->query($updateSql) === TRUE) {
                                echo '<div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded">
                                    <p>User status updated successfully!</p>
                                </div>';
                            } else {
                                echo '<div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded">
                                    <p>Failed to update user status: ' . $con->error . '</p>
                                </div>';
                            }
                        }

                        // Fetch and group data from the warning table
                        $query = "SELECT u.email, COUNT(w.email) AS warning_count, u.status 
                                  FROM warning w 
                                  RIGHT JOIN user u ON w.email = u.email 
                                  GROUP BY u.email, u.status 
                                  ORDER BY warning_count DESC";
                        $result = $con->query($query);
                        
                        if ($result->num_rows > 0) {
                            echo '<div class="overflow-x-auto">
                                <table class="min-w-full bg-white border-collapse">
                                <thead>
                                    <tr class="bg-gray-50 border-b-2 border-gray-200">
                                        <th class="px-4 py-3 text-left">Email</th>
                                        <th class="px-4 py-3 text-center">Warnings</th>
                                        <th class="px-4 py-3 text-center">Status</th>
                                        <th class="px-4 py-3 text-center">Remarks</th>
                                        <th class="px-4 py-3 text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>';
                            
                            while ($row = $result->fetch_assoc()) {
                                $statusClass = $row['status'] == 1 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
                                $warningCount = (int)$row['warning_count'];
                                
                                // Determine remarks based on warning count
                                if ($warningCount >= 40) {
                                    $remarks = '<span class="px-2 py-1 bg-red-100 text-red-800 rounded-full">Critical Violation</span>';
                                } elseif ($warningCount >= 30) {
                                    $remarks = '<span class="px-2 py-1 bg-orange-100 text-orange-800 rounded-full">Severe Violation</span>';
                                } elseif ($warningCount >= 20) {
                                    $remarks = '<span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full">Major Violation</span>';
                                } elseif ($warningCount >= 10) {
                                    $remarks = '<span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full">Moderate Violation</span>';
                                } elseif ($warningCount > 0) {
                                    $remarks = '<span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full">Minor Violation</span>';
                                } else {
                                    $remarks = '<span class="px-2 py-1 bg-green-100 text-green-800 rounded-full">No Violations</span>';
                                }
                                
                                echo '<tr class="border-b border-gray-200 hover:bg-gray-50">
                                    <td class="px-4 py-4 font-medium">' . htmlspecialchars($row['email']) . '</td>
                                    <td class="px-4 py-4 text-center">' . htmlspecialchars($row['warning_count']) . '</td>
                                    <td class="px-4 py-4 text-center">
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold ' . $statusClass . '">
                                            ' . ($row['status'] == 1 ? 'Enabled' : 'Disabled') . '
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 text-center">' . $remarks . '</td>
                                    <td class="px-4 py-4 text-center">';
                                
                                if ($row['status'] == 1) {
                                    echo '<a href="dash.php?q=5&action=disable&user_email=' . urlencode($row['email']) . '" 
                                        class="btn-secondary inline-flex items-center justify-center space-x-1 py-1 px-3"
                                        onclick="return confirm(\'Are you sure you want to disable this user?\');">
                                        <i class="fas fa-user-slash"></i>
                                        <span>Disable</span>
                                    </a>';
                                } else {
                                    echo '<a href="dash.php?q=5&action=enable&user_email=' . urlencode($row['email']) . '" 
                                        class="btn-primary inline-flex items-center justify-center space-x-1 py-1 px-3">
                                        <i class="fas fa-user-check"></i>
                                        <span>Enable</span>
                                    </a>';
                                }
                                
                                echo '</td></tr>';
                            }
                            
                            echo '</tbody></table></div>';
                        } else {
                            echo '<div class="text-center p-8 bg-gray-50 rounded-lg">
                                <i class="fas fa-exclamation-circle text-4xl text-gray-400 mb-3"></i>
                                <p class="text-gray-500">No warnings found in the database.</p>
                            </div>';
                        }
                        ?>
                    <?php } ?>

                    <?php if(@$_GET['q']==6) { ?>
                        <h2 class="panel-title">Exam Restart Permissions</h2>
                        <p class="text-gray-600 mb-6">Manage which users are allowed to restart exams they have already taken.</p>
                        
                        <?php
                        // Process permission updates if submitted
                        if(isset($_POST['update_permissions'])) {
                            $user_email = mysqli_real_escape_string($con, $_POST['user_email']);
                            $exam_id = mysqli_real_escape_string($con, $_POST['exam_id']);
                            $allow_restart = isset($_POST['allow_restart']) ? 1 : 0;
                            
                            // Check if a record already exists
                            $check_query = mysqli_query($con, "SELECT * FROM user_exam_settings WHERE email='$user_email' AND eid='$exam_id'");
                            
                            if(mysqli_num_rows($check_query) > 0) {
                                // Update existing record
                                mysqli_query($con, "UPDATE user_exam_settings SET allow_restart='$allow_restart' WHERE email='$user_email' AND eid='$exam_id'") 
                                    or die("Error updating permission: " . mysqli_error($con));
                            } else {
                                // Insert new record
                                mysqli_query($con, "INSERT INTO user_exam_settings (email, eid, allow_restart) VALUES ('$user_email', '$exam_id', '$allow_restart')")
                                    or die("Error inserting permission: " . mysqli_error($con));
                            }
                            
                            echo '<div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded">
                                <p>Restart permission updated successfully!</p>
                            </div>';
                        }
                        
                        // Form for setting new permissions
                        ?>
                        <div class="bg-white rounded-xl shadow-md p-6 mb-8">
                            <h3 class="text-xl font-semibold mb-6 text-primary">Set Restart Permission</h3>
                            
                            <form method="post" action="dash.php?q=6" class="space-y-6">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label class="form-label">Select User</label>
                                        <select name="user_email" class="form-input" required>
                                            <option value="">-- Select User --</option>
                                            <?php
                                            $users_result = mysqli_query($con, "SELECT email, name FROM user ORDER BY name ASC");
                                            while($user = mysqli_fetch_array($users_result)) {
                                                echo '<option value="'.$user['email'].'">'.$user['name'].' ('.$user['email'].')</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    
                                    <div>
                                        <label class="form-label">Select Exam</label>
                                        <select name="exam_id" class="form-input" required>
                                            <option value="">-- Select Exam --</option>
                                            <?php
                                            $exams_result = mysqli_query($con, "SELECT eid, title FROM quiz ORDER BY title ASC");
                                            while($exam = mysqli_fetch_array($exams_result)) {
                                                echo '<option value="'.$exam['eid'].'">'.$exam['title'].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    
                                    <div class="flex items-end">
                                        <label class="inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="allow_restart" value="1" class="h-5 w-5 text-primary rounded border-gray-300">
                                            <span class="ml-2 text-gray-700">Allow Restart</span>
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="flex justify-end">
                                    <button type="submit" name="update_permissions" class="btn-primary inline-flex items-center justify-center space-x-2">
                                        <i class="fas fa-save"></i>
                                        <span>Save Permission</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                        
                        <?php
                        // Display existing permissions
                        $permissions_query = mysqli_query($con, "
                            SELECT s.email, s.eid, s.allow_restart, u.name as username, q.title as exam_title 
                            FROM user_exam_settings s
                            JOIN user u ON s.email = u.email
                            JOIN quiz q ON s.eid = q.eid
                            ORDER BY u.name ASC, q.title ASC
                        ");
                        
                        if(mysqli_num_rows($permissions_query) > 0) {
                            echo '<div class="bg-white rounded-xl shadow-md p-6">
                                <h3 class="text-xl font-semibold mb-6 text-primary">Current Restart Permissions</h3>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full bg-white border-collapse">
                                        <thead>
                                            <tr class="bg-gray-50 border-b-2 border-gray-200">
                                                <th class="px-4 py-3 text-left">User</th>
                                                <th class="px-4 py-3 text-left">Email</th>
                                                <th class="px-4 py-3 text-left">Exam</th>
                                                <th class="px-4 py-3 text-center">Restart Status</th>
                                                <th class="px-4 py-3 text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>';
                            
                            while($row = mysqli_fetch_array($permissions_query)) {
                                $status_class = $row['allow_restart'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
                                $status_text = $row['allow_restart'] ? 'Allowed' : 'Not Allowed';
                                
                                echo '<tr class="border-b border-gray-200 hover:bg-gray-50">
                                    <td class="px-4 py-4 font-medium">'.htmlspecialchars($row['username']).'</td>
                                    <td class="px-4 py-4">'.htmlspecialchars($row['email']).'</td>
                                    <td class="px-4 py-4">'.htmlspecialchars($row['exam_title']).'</td>
                                    <td class="px-4 py-4 text-center">
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold '.$status_class.'">
                                            '.$status_text.'
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <form method="post" action="dash.php?q=6" class="inline">
                                            <input type="hidden" name="user_email" value="'.$row['email'].'">
                                            <input type="hidden" name="exam_id" value="'.$row['eid'].'">
                                            <input type="hidden" name="allow_restart" value="'.($row['allow_restart'] ? '0' : '1').'">
                                            <button type="submit" name="update_permissions" class="btn-'.($row['allow_restart'] ? 'secondary' : 'primary').' inline-flex items-center justify-center space-x-1 py-1 px-3">
                                                <i class="fas fa-'.($row['allow_restart'] ? 'ban' : 'check').'"></i>
                                                <span>'.($row['allow_restart'] ? 'Revoke' : 'Allow').'</span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>';
                            }
                            
                            echo '</tbody></table></div></div>';
                        } else {
                            echo '<div class="text-center p-8 bg-gray-50 rounded-lg">
                                <i class="fas fa-info-circle text-4xl text-gray-400 mb-3"></i>
                                <p class="text-gray-500">No restart permissions have been set yet.</p>
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
