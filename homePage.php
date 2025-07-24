
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/school/assets/css/style4.css">
	  <style>
        .header-right {
            position: fixed;
            top: 10px;
            right: 10px;
            font-size: 22px;
            background-color:#f8f9fa; /* لون خلفية اختياري */
            padding: 5px 10px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
			color: black;
        }
        .header-right a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }
        .header-right a:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>

<?php

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
?>

<h1>Welcom To Glory School</h1> <!-- Welcome title -->

<h3  class="header-right"> <?php echo "Hello! ". $_SESSION['username'] ." - "."<a href='logout.php'> Logout</a>"; ?> </h3>

<div class="icon-container">
    <div class="row">
        <div class="icon" onclick='window.location.href="studentInf.php";'>
			<img src="assets/images/student.jpg" alt="Student Icon">
            <div class="icon-text">Student</div>
        </div>
        <div class="icon" onclick='window.location.href="viewAllGrades.php";'>
			<img src="assets/images/grades.jpg" alt="Grades Icon">
            <div class="icon-text">Grades</div>
        </div>
    </div>
    <div class="icon" onclick='window.location.href="createStudent.php";'>
		<img src="assets/images/newstudent.jpg" alt="New Student Icon">
        <div class="icon-text">New Student</div>
    </div>
</div>

</body>
</html>
