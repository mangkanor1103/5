<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DASHBOARD</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,700' rel='stylesheet' type='text/css'>
</head>

<body class="bg-gray-100 font-roboto">
    <div class="bg-gradient-to-r from-green-500 to-green-600 p-4 shadow-md">
        <div class="flex justify-between items-center">
            <span class="text-white text-2xl font-bold">Online Exam System</span>
            <?php
            include_once 'dbConnection.php';
            session_start();
            $email = $_SESSION['email'];
            if (!(isset($_SESSION['email']))) {
                header("location:index.php");
            } else {
                $name = $_SESSION['name'];
                echo '<span class="text-white"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;Hello, <a href="#" class="text-white underline">'.$name.'</a>&nbsp;|&nbsp;<a href="logout.php?q=account.php" class="text-white underline"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>&nbsp;Logout</a></span>';
            }
            ?>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="bg-white shadow-md">
        <div class="container mx-auto">
            <div class="flex justify-between">
                <div class="flex items-center">
                    <a class="text-green-600 font-bold p-4" href="dash.php?q=0">Dashboard</a>
                </div>
                <div class="flex space-x-4">
                    <a href="dash.php?q=0" class="p-4 hover:bg-gray-200">Home</a>
                    <a href="dash.php?q=1" class="p-4 hover:bg-gray-200">Users</a>
                    <a href="dash.php?q=2" class="p-4 hover:bg-gray-200">User Rankings</a>
                    <a href="dash.php?q=3" class="p-4 hover:bg-gray-200">Feedback</a>
                    <a href="dash.php?q=4" class="p-4 hover:bg-gray-200">Add Exams</a>
                    <a href="user.php" class="p-4 hover:bg-gray-200">Warnings</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mx-auto p-4">
        <div class="bg-white rounded-lg shadow-md p-4 mb-4">
            <?php if(@$_GET['q']==0) {
                $result = mysqli_query($con,"SELECT * FROM quiz ORDER BY date DESC") or die('Error');
                echo '<table class="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="py-2 px-4 border-b">S.N.</th>
                            <th class="py-2 px-4 border-b">Topic</th>
                            <th class="py-2 px-4 border-b">Total Questions</th>
                            <th class="py-2 px-4 border-b">Marks</th>
                            <th class="py-2 px-4 border-b">Time Limit</th>
                            <th class="py-2 px-4 border-b">Actions</th>
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
                    echo '<tr class="'.($c % 2 == 0 ? 'bg-gray-50' : '').'">
                        <td class="py-2 px-4 border-b">'.$c++.'</td>
                        <td class="py-2 px-4 border-b">'.$title.'</td>
                        <td class="py-2 px-4 border-b">'.$total.'</td>
                        <td class="py-2 px-4 border-b">'.$sahi*$total.'</td>
                        <td class="py-2 px-4 border-b">'.$time.'&nbsp;min</td>
                        <td class="py-2 px-4 border-b"><a href="update.php?q=rmquiz&eid='.$eid.'" class="bg-red-500 text-white py-1 px-3 rounded hover:bg-red-600"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Remove</a></td>
                    </tr>';
                }
                echo '</tbody></table>';
            }

            if(@$_GET['q'] == 2) {
                $q = mysqli_query($con, "SELECT * FROM rank ORDER BY score DESC") or die('Error223');
                echo '<div class="panel title">
                <form method="post" action="">
                    <button type="submit" name="clear_ranking" class="bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600" onclick="return confirm(\'Are you sure you want to clear the ranking?\');">Clear Ranking</button>
                </form>
                <table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="py-2 px-4 border-b">Rank</th>
                        <th class="py-2 px-4 border-b">Name</th>
                        <th class="py-2 px-4 border-b">Score</th>
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
                        <td class="py-2 px-4 border-b text-green-600 font-bold">'.$c.'</td>
                        <td class="py-2 px-4 border-b">'.$name.'</td>
                        <td class="py-2 px-4 border-b">'.$s.'</td>
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
        <button type="submit" name="clear_table" class="bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600" onclick="return confirm(\'Are you sure you want to clear the table?\');">Clear Table</button>
    </form>
    <table class="min-w-full bg-white border border-gray-200">
    <thead>
        <tr class="bg-gray-100">
            <th class="py-2 px-4 border-b">S.N.</th>
            <th class="py-2 px-4 border-b">Name</th>
            <th class="py-2 px-4 border-b">Gender</th>
            <th class="py-2 px-4 border-b">Year and Section</th>
            <th class="py-2 px-4 border-b">Email</th>
            <th class="py-2 px-4 border-b">Mobile</th>
            <th class="py-2 px-4 border-b">Actions</th> <!-- Actions header -->
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
            <td class="py-2 px-4 border-b">'.$c++.'</td>
            <td class="py-2 px-4 border-b">'.$name.'</td>
            <td class="py-2 px-4 border-b">'.$gender.'</td>
            <td class="py-2 px-4 border-b">'.$college.'</td>
            <td class="py-2 px-4 border-b">'.$email.'</td>
            <td class="py-2 px-4 border-b">'.$mob.'</td>
            <td class="py-2 px-4 border-b">
                <a title="Delete User" href="update.php?demail='.$email.'" class="text-red-600 hover:text-red-800" onclick="return confirm(\'Are you sure you want to delete this user?\');">
                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete
                </a>
            </td>
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
                echo '<div class="panel"><table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="py-2 px-4 border-b">S.N.</th>
                        <th class="py-2 px-4 border-b">Subject</th>
                        <th class="py-2 px-4 border-b">Email</th>
                        <th class="py-2 px-4 border-b">Date</th>
                        <th class="py-2 px-4 border-b">Time</th>
                        <th class="py-2 px-4 border-b">By</th>
                        <th class="py-2 px-4 border-b">Actions</th>
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
                        <td class="py-2 px-4 border-b">'.$c++.'</td>
                        <td class="py-2 px-4 border-b"><a title="Click to open feedback" href="dash.php?q=3&fid='.$id.'">'.$subject.'</a></td>
                        <td class="py-2 px-4 border-b">'.$email.'</td>
                        <td class="py-2 px-4 border-b">'.$date.'</td>
                        <td class="py-2 px-4 border-b">'.$time.'</td>
                        <td class="py-2 px-4 border-b">'.$name.'</td>
                        <td class="py-2 px-4 border-b">
                            <a title="View Feedback" href="dash.php?q=3&fid='.$id.'" class="text-blue-600 hover:text-blue-800">View</a>
                            <a title="Delete Feedback" href="update.php?fdid='.$id.'" class="text-red-600 hover:text-red-800" onclick="return confirm(\'Are you sure you want to delete this feedback?\');"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
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
                    echo '<div class="panel bg-white rounded-lg shadow-md p-4 mb-4"><a title="Back to Archive" href="update.php?q1=2"><span class="glyphicon glyphicon-level-up" aria-hidden="true"></span></a><h2 class="text-center text-xl font-bold">'.$subject.'</h2>';
                    echo '<div class="px-4 py-2"><span class="font-bold">DATE:</span>&nbsp;'.$date.'<br /><span class="font-bold">Time:</span>&nbsp;'.$time.'<br /><span class="font-bold">By:</span>&nbsp;'.$name.'</span><br />'.$feedback.'</div></div>';
                }
            }

            if(@$_GET['q']==4 && !(@$_GET['step'])) {
                echo '<div class="text-center mb-4">
                <span class="text-2xl font-bold"><b>Enter Exam Details</b></span><br /><br />
                <div class="mx-auto w-1/2"><form class="form-horizontal" name="form" action="update.php?q=addquiz" method="POST">
                <fieldset>
                <div class="mb-4">
                    <input id="name" name="name" placeholder="Enter Exam Title" class="form-control border rounded p-2 w-full" type="text">
                </div>
                <div class="mb-4">
                    <input id="total" name="total" placeholder="Enter total number of questions" class="form-control border rounded p-2 w-full" type="number">
                </div>
                <div class="mb-4">
                    <input id="right" name="right" placeholder="Enter marks on right answer" class="form-control border rounded p-2 w-full" min="0" type="number">
                </div>
                <div class="mb-4">
                    <input id="wrong" name="wrong" placeholder="Enter minus marks on wrong answer without sign" class="form-control border rounded p-2 w-full" min="0" type="number">
                </div>
                <div class="mb-4">
                    <input id="time" name="time" placeholder="Enter time limit for test in minute" class="form-control border rounded p-2 w-full" min="1" type="number">
                </div>
                <div class="mb-4">
                    <input id="tag" name="tag" placeholder="Enter #tag which is used for searching" class="form-control border rounded p-2 w-full" type="text">
                </div>
                <div class="mb-4">
                    <textarea rows="8" cols="8" name="desc" class="form-control border rounded p-2 w-full" placeholder="Write description here..."></textarea>
                </div>
                <div class="mb-4">
                    <input type="submit" class="bg-blue-500 text-white py-2 px-4 rounded" value="Submit"/>
                </div>
                </fieldset>
                </form></div>';
            }

            if(@$_GET['q']==4) {
                echo '<div class="text-center mb-4">
                <span class="text-2xl font-bold"><b>Enter Question Details</b></span><br /><br />
                <div class="mx-auto w-1/2"><form class="form-horizontal" name="form" action="update.php?q=addqns&n='.@$_GET['n'].'&eid='.@$_GET['eid'].'&ch=4" method="POST">
                <fieldset>';
                for($i=1; $i<=@$_GET['n']; $i++) {
                    echo '<b>Question number&nbsp;'.$i.'&nbsp;:</b><br />
                    <div class="mb-4">
                        <textarea rows="3" cols="5" name="qns'.$i.'" class="form-control border rounded p-2 w-full" placeholder="Write question number '.$i.' here..."></textarea>
                    </div>
                    <div class="mb-4">
                        <input id="'.$i.'1" name="'.$i.'1" placeholder="Enter option a" class="form-control border rounded p-2 w-full" type="text">
                    </div>
                    <div class="mb-4">
                        <input id="'.$i.'2" name="'.$i.'2" placeholder="Enter option b" class="form-control border rounded p-2 w-full" type="text">
                    </div>
                    <div class="mb-4">
                        <input id="'.$i.'3" name="'.$i.'3" placeholder="Enter option c" class="form-control border rounded p-2 w-full" type="text">
                    </div>
                    <div class="mb-4">
                        <input id="'.$i.'4" name="'.$i.'4" placeholder="Enter option d" class="form-control border rounded p-2 w-full" type="text">
                    </div>
                    <br />
                    <b>Correct answer</b>:<br />
                    <select id="ans'.$i.'" name="ans'.$i.'" class="form-control border rounded p-2 w-full">
                        <option value="a">Select answer for question '.$i.'</option>
                        <option value="a">option a</option>
                        <option value="b">option b</option>
                        <option value="c">option c</option>
                        <option value="d">option d</option>
                    </select><br /><br />';
                }
                echo '<div class="mb-4">
                    <input type="submit" class="bg-blue-500 text-white py-2 px-4 rounded" value="Submit"/>
                </div>
                </fieldset>
                </form></div>';
            }
            ?>
        </div>
    </div>
</body>
</html>
