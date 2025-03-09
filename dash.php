
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DASHBOARD</title>
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <link rel="stylesheet" href="css/font.css">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,700' rel='stylesheet' type='text/css'>

    <style>
        body {
            background-color: #f4f7fa; /* Light background for a modern look */
            font-family: 'Roboto', sans-serif;
        }
        .navbar {
            background: linear-gradient(90deg, #4CAF50, #66BB6A); /* Gradient navbar */
        }
        .navbar a {
            color: white; /* White text for navbar links */
        }
        .btn-danger {
            background-color: #e57373; /* Soft red for danger buttons */
            color: white; /* White text for buttons */
            transition: background-color 0.3s; /* Smooth transition */
        }
        .btn-danger:hover {
            background-color: #ef5350; /* Darker red on hover */
        }
        .panel {
            border: none; /* Remove default border */
            border-radius: 8px; /* Rounded corners */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
            margin-bottom: 20px; /* Space between panels */
        }
        .title1 {
            color: #4CAF50; /* Green text for titles */
            font-weight: bold; /* Bold titles */
        }
        .table {
            background-color: white; /* White background for tables */
            border-radius: 8px; /* Rounded corners */
            overflow: hidden; /* Prevent overflow */
        }
        .table th, .table td {
            vertical-align: middle; /* Center align text */
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f9f9f9; /* Light gray for odd rows */
        }
        .header {
            padding: 20px; /* Padding for header */
            background-color: #fff; /* White background for header */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
            border-radius: 8px; /* Rounded corners */
            margin-bottom: 20px; /* Space below header */
        }
        .logo {
            font-size: 24px; /* Larger logo text */
            font-weight: bold; /* Bold logo text */
        }
    </style>

    <script src="js/jquery.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
</head>

<body>
    <div class="header">
        <div class="row">
            <div class="col-lg-6">
                <span class="logo">Online Exam System</span>
            </div>
            <?php
            include_once 'dbConnection.php';
            session_start();
            $email = $_SESSION['email'];
            if (!(isset($_SESSION['email']))) {
                header("location:index.php");
            } else {
                $name = $_SESSION['name'];
                echo '<span class="pull-right top title1"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;Hello, <a href="#" class="log log1">'.$name.'</a>&nbsp;|&nbsp;<a href="logout.php?q=account.php" class="log"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>&nbsp;Logout</a></span>';
            }
            ?>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="navbar navbar-default title1">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></ <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="dash.php?q=0"><b>Dashboard</b></a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav">
                    <li <?php if(@$_GET['q']==0) echo 'class="active"'; ?>><a href="dash.php?q=0">Home<span class="sr-only">(current)</span></a></li>
                    <li <?php if(@$_GET['q']==1) echo 'class="active"'; ?>><a href="dash.php?q=1">Users</a></li>
                    <li <?php if(@$_GET['q']==2) echo 'class="active"'; ?>><a href="dash.php?q=2">User  Rankings</a></li>
                    <li <?php if(@$_GET['q']==3) echo 'class="active"'; ?>><a href="dash.php?q=3">Feedback</a></li>
                    <li <?php if(@$_GET['q']==4) echo 'class="active"'; ?>><a href="dash.php?q=4">Add Exams</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php if(@$_GET['q']==0) {
                    $result = mysqli_query($con,"SELECT * FROM quiz ORDER BY date DESC") or die('Error');
                    echo '<div class="panel"><table class="table table-striped title1">
                    <thead>
                        <tr>
                            <th>S.N.</th>
                            <th>Topic</th>
                            <th>Total Questions</th>
                            <th>Marks</th>
                            <th>Time Limit</th>
                            <th>Actions</th>
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
                        echo '<tr>
                            <td>'.$c++.'</td>
                            <td>'.$title.'</td>
                            <td>'.$total.'</td>
                            <td>'.$sahi*$total.'</td>
                            <td>'.$time.'&nbsp;min</td>
                            <td><a href="update.php?q=rmquiz&eid='.$eid.'" class="btn btn-danger"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Remove</a></td>
                        </tr>';
                    }
                    echo '</tbody></table></div>';
                }

                if(@$_GET['q'] == 2) {
                    $q = mysqli_query($con, "SELECT * FROM rank ORDER BY score DESC") or die('Error223');
                    echo '<div class="panel title">
                    <form method="post" action="">
                        <button type="submit" name="clear_ranking" class="btn btn-danger" onclick="return confirm(\'Are you sure you want to clear the ranking?\');">Clear Ranking</button>
                    </form>
                    <table class="table table-striped title1">
                    <thead>
                        <tr>
                            <th>Rank</th>
                            <th>Name</th>
                            <th>Score</th>
                        </tr>
                    </thead>
                    <tbody>';
                    $c = 0;
                    while ($row = mysqli_fetch_array($q)) {
                        $e = $row['email'];
                        $s = $row['score'];
                        $q12 = mysqli_query($con, "SELECT * FROM user WHERE email='$e'") or die('Error231');
                        while ($row = mysqli_fetch_array($q12)) {
                            $name = $row['name'];
                        }
                        $c++;
                        echo '<tr>
                            <td style="color:#99cc32"><b>'.$c.'</b></td>
                            <td>'.$name.'</td>
                            <td>'.$s.'</td>
                        </tr>';
                    }
                    echo '</tbody></table></div>';
                    if (isset($_POST['clear_ranking'])) {
                        mysqli_query($con, "DELETE FROM rank");
                        echo "<script>alert('Ranking cleared successfully!'); window.location.href='dash.php?q=2';</script>";
                    }
                }

                if(@$_GET['q']==1) {
                    $result = mysqli_query($con,"SELECT * FROM user") or die('Error');
                    echo '<div class="panel">
                    <form method="post" action="">
                        <button type="submit" name="clear_table" class="btn btn-danger onclick="return confirm(\'Are you sure you want to clear the table?\');">Clear Table</button>
                    </form>
                    <table class="table table-striped title1">
                    <thead>
                        <tr>
                            <th>S.N.</th>
                            <th>Name</th>
                            <th>Gender</th>
                            <th>College</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Actions</th>
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
                        echo '<tr>
                            <td>'.$c++.'</td>
                            <td>'.$name.'</td>
                            <td>'.$gender.'</td>
                            <td>'.$college.'</td>
                            <td>'.$email.'</td>
                            <td>'.$mob.'</td>
                            <td><a title="Delete User" href="update.php?demail='.$email.'"><span class="glyphicon glyphicon-trash" style="color:red;" aria-hidden="true"></span></a></td>
                        </tr>';
                    }
                    echo '</tbody></table></div>';
                    if(isset($_POST['clear_table'])) {
                        mysqli_query($con, "DELETE FROM user");
                        echo "<script>alert('Table cleared successfully!'); window.location.href='dash.php?q=1';</script>";
                    }
                }

                if(@$_GET['q']==3) {
                    $result = mysqli_query($con,"SELECT * FROM `feedback` ORDER BY `feedback`.`date` DESC") or die('Error');
                    echo '<div class="panel"><table class="table table-striped title1">
                    <thead>
                        <tr>
                            <th>S.N.</th>
                            <th>Subject</th>
                            <th>Email</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>By</th>
                            <th>Actions</th>
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
                        echo '<tr>
                            <td>'.$c++.'</td>
                            <td><a title="Click to open feedback" href="dash.php?q=3&fid='.$id.'">'.$subject.'</a></td>
                            <td>'.$email.'</td>
                            <td>'.$date.'</td>
                            <td>'.$time.'</td>
                            <td>'.$name.'</td>
                            <td>
                                <a title="Open Feedback" href="dash.php?q=3&fid='.$id.'"><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span></a>
                                <a title="Delete Feedback" href="update.php?fdid='.$id.'"><span class="glyphicon glyphicon-trash" style="color:red;" aria-hidden="true"></span></a>
                            </td>
                        </tr>';
                    }
                    echo '</tbody></table></div>';
                }

                if(@$_GET['fid']) {
                    echo '<br />';
                    $id=@$_GET['fid'];
                    $result = mysqli_query($con,"SELECT * FROM feedback WHERE id='$id' ") or die('Error');
                    while($row = mysqli_fetch_array($result)) {
                        $name = $row['name'];
                        $subject = $row['subject'];
                        $date = $row['date'];
                        $date= date("d-m-Y",strtotime($date));
                        $time = $row['time'];
                        $feedback = $row['feedback'];
                        echo '<div class="panel"><a title="Back to Archive" href="update.php?q1=2"><span class="glyphicon glyphicon-level-up" aria-hidden="true"></span></a><h2 style="text-align:center; margin-top:-15px;"><b>'.$subject.'</b></h2>';
                        echo '<div style="margin-left:10px;margin-right:10px; max-height:450px; line-height:35px;padding:5px;"><span style="line-height:35px;padding:5px;">-&nbsp;<b>DATE:</b>&nbsp;'.$date.'</span>
                        <span style="line-height:35px;padding:5px;">&nbsp;<b>Time:</b>&nbsp;'.$time.'</span><span style="line-height:35px;padding:5px;">&nbsp;< b>By:</b>&nbsp;'.$name.'</span><br />'.$feedback.'</div></div>';
                    }
                }

                if(@$_GET['q']==4 && !(@$_GET['step'])) {
                    echo '<div class="row">
                    <span class="title1" style="margin-left:40%;font-size:30px;"><b>Enter Exam Details</b></span><br /><br />
                    <div class="col-md-3"></div><div class="col-md-6"><form class="form-horizontal title1" name="form" action="update.php?q=addquiz" method="POST">
                    <fieldset>
                    <div class="form-group">
                        <label class="col-md-12 control-label" for="name"></label>
                        <div class="col-md-12">
                        <input id="name" name="name" placeholder="Enter Exam Title" class="form-control input-md" type="text">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12 control-label" for="total"></label>
                        <div class="col-md-12">
                        <input id="total" name="total" placeholder="Enter total number of questions" class="form-control input-md" type="number">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12 control-label" for="right"></label>
                        <div class="col-md-12">
                        <input id="right" name="right" placeholder="Enter marks on right answer" class="form-control input-md" min="0" type="number">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12 control-label" for="wrong"></label>
                        <div class="col-md-12">
                        <input id="wrong" name="wrong" placeholder="Enter minus marks on wrong answer without sign" class="form-control input-md" min="0" type="number">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12 control-label" for="time"></label>
                        <div class="col-md-12">
                        <input id="time" name="time" placeholder="Enter time limit for test in minute" class="form-control input-md" min="1" type="number">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12 control-label" for="tag"></label>
                        <div class="col-md-12">
                        <input id="tag" name="tag" placeholder="Enter #tag which is used for searching" class="form-control input-md" type="text">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12 control-label" for="desc"></label>
                        <div class="col-md-12">
                        <textarea rows="8" cols="8" name="desc" class="form-control" placeholder="Write description here..."></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12 control-label" for=""></label>
                        <div class="col-md-12">
                            <input type="submit" style="margin-left:45%" class="btn btn-primary" value="Submit"/>
                        </div>
                    </div>
                    </fieldset>
                    </form></div>';
                }

                if(@$_GET['q']==4) {
                    echo '<div class="row">
                    <span class="title1" style="margin-left:40%;font-size:30px;"><b>Enter Question Details</b></span><br /><br />
                    <div class="col-md-3"></div><div class="col-md-6"><form class="form-horizontal title1" name="form" action="update.php?q=addqns&n='.@$_GET['n'].'&eid='.@$_GET['eid'].'&ch=4" method="POST">
                    <fieldset>';
                    for($i=1; $i<=@$_GET['n']; $i++) {
                        echo '<b>Question number&nbsp;'.$i.'&nbsp;:</b><br />
                        <div class="form-group">
                            <label class="col-md-12 control-label" for="qns'.$i.'"></label>
                            <div class="col-md-12">
                            <textarea rows="3" cols="5" name="qns'.$i.'" class="form-control" placeholder="Write question number '.$i.' here..."></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12 control-label" for="'.$i.'1"></ <div class="col-md-12">
                            <input id="'.$i.'1" name="'.$i.'1" placeholder="Enter option a" class="form-control input-md" type="text">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12 control-label" for="'.$i.'2"></label>
                        <div class="col-md-12">
                            <input id="'.$i.'2" name="'.$i.'2" placeholder="Enter option b" class="form-control input-md" type="text">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12 control-label" for="'.$i.'3"></label>
                        <div class="col-md-12">
                            <input id="'.$i.'3" name="'.$i.'3" placeholder="Enter option c" class="form-control input-md" type="text">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12 control-label" for="'.$i.'4"></label>
                        <div class="col-md-12">
                            <input id="'.$i.'4" name="'.$i.'4" placeholder="Enter option d" class="form-control input-md" type="text">
                        </div>
                    </div>
                    <br />
                    <b>Correct answer</b>:<br />
                    <select id="ans'.$i.'" name="ans'.$i.'" class="form-control input-md">
                        <option value="a">Select answer for question '.$i.'</option>
                        <option value="a">option a</option>
                        <option value="b">option b</option>
                        <option value="c">option c</option>
                        <option value="d">option d</option>
                    </select><br /><br />';
                }
                echo '<div class="form-group">
                    <label class="col-md-12 control-label" for=""></label>
                    <div class="col-md-12">
                        <input type="submit" style="margin-left:45%" class="btn btn-primary" value="Submit"/>
                    </div>
                </div>
                </fieldset>
                </form></div>';
            }
            ?>
        </div>
    </div>
</div>
</body>
</html>