<!DOCTYPE html>
<html lang="en">

<head>
    <title>Glory School</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="assets/css/style1.css">
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
    <script>
        function showMessage() {
            alert("Registration/Update successful");
            return true;
        }

        function validateDate() {
            const birthDate = new Date(document.getElementById("bod").value);
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            
            const sixYearsAgo = new Date();
            sixYearsAgo.setFullYear(today.getFullYear() - 6);
            
            const sevenYearsAgo = new Date();
            sevenYearsAgo.setFullYear(today.getFullYear() - 7);

            
            if (birthDate > sixYearsAgo || birthDate <= sevenYearsAgo) {
                alert("You must be between 6 and 7 years old to register!");
                return false;
            }
            return true;
        }
		

    </script>
</head>

<body>

<h1>Glory School</h1>
<h2>Student Registration Form</h2>
<!-- Back to Home button -->
<center><a href="homePage.php" class="btn-home">Back to Home</a></center>
<h3  class="header-right"> <?php echo "Hello! ". $_SESSION['username'] ." - "."<a href='logout.php'> Logout</a>"; ?> </h3>
<?php

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
require_once "D:\wamp64\www\school\assets\databaseconnection\db.php";  // استدعاء ملف الاتصال بقاعدة البيانات

// Initialize variables
$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
$name = '';
$birth = '';
$gender = '';
$city = '';

// Fetch data if editing
if ($id) {
    $result = $con->query("SELECT * FROM studentdata WHERE id = $id");
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $birth = $row['date_of_birth'];
        $gender = $row['gender'];
        $city = $row['city'];
    } else {
        echo "Student not found.";
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_REQUEST['studentName'];
    $birth = $_REQUEST['bod'];
    $gender = $_REQUEST['gender'];
    $city = $_REQUEST['city'];

    if ($id) {
        // Update existing student
        $stmt = $con->prepare("UPDATE studentdata SET name=?, date_of_birth=?, gender=?, city=? WHERE id=?");
        $stmt->bind_param('ssssi', $username, $birth, $gender, $city, $id);
        $stmt->execute();
    } else {
        // Insert new student
        $stmt = $con->prepare("INSERT INTO studentdata (name, date_of_birth, gender, city) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('ssss', $username, $birth, $gender, $city);
        $stmt->execute();
    }

    $stmt->close();
    $con->close();
    header('Location: studentInf.php');
    exit();
}
?>

<form method="POST" onsubmit="return validateDate() && showMessage()">
    <center>
        <table>
            <tr>
                <td>Name</td>
                <td><input name="studentName" id="studentName" type="text" value="<?php echo htmlspecialchars($name); ?>" required></td>
            </tr>
            <tr>
                <td>Date of Birth</td>
                <td><input id="bod" name="bod" type="date" value="<?php echo htmlspecialchars($birth); ?>" required></td>
            </tr>
            <tr>
                <td>Gender</td>
                <td>
                    <select name="gender" id="gender" required>
                        <option value="" selected disabled>Select</option>
                        <option value="Female" <?php if ($gender == 'Female') echo 'selected'; ?>>Female</option>
                        <option value="Male" <?php if ($gender == 'Male') echo 'selected'; ?>>Male</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>City</td>
                <td>
                    <select name="city" id="city" required>
                        <option value="" selected disabled>Select</option>
                        <option value="Riyadh" <?php if ($city == 'Riyadh') echo 'selected'; ?>>Riyadh</option>
                        <option value="Makkah" <?php if ($city == 'Makkah') echo 'selected'; ?>>Makkah</option>
                        <option value="Dammam" <?php if ($city == 'Dammam') echo 'selected'; ?>>Dammam</option>
                    </select>
                </td>
            </tr>
        </table>
    </center>
    <center><input type="submit" value="Submit"></center> 
</form>
<br>

</body>
</html>
