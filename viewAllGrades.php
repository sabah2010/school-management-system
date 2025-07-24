<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
require_once "D:\wamp64\www\school\assets\databaseconnection\db.php";  // استدعاء ملف الاتصال بقاعدة البيانات
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View All Grades</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" type="text/css" href="/school/assets/css/style5.css">
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

<h1>All Students and Grades</h1>
<h3  class="header-right"> <?php echo "Hello! ". $_SESSION['username'] ." - "."<a href='logout.php'> Logout</a>"; ?> </h3>
<!-- Back to Home button -->
<center><a href="homePage.php" class="btn-home">Back to Home</a></center>

<!-- Add Grades button -->
<button class="btn btn-primary" id="addGradeBtn">Add Grades</button>
<!-- Modal for entering grades -->
<div id="addGradeModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h3>Enter Grades for Student</h3>
        <form id="gradeForm" action="submitGrade.php" method="POST" onsubmit="return validateForm();">
            <div class="form-group">
                <label for="student">Select Student:</label>
                <select name="student_id" class="form-control" id="student" required>
                    <option value="" disabled selected>Select Student</option>
                    <?php
                    $students_query = $con->query("SELECT id, name FROM studentdata");
                    while ($student = $students_query->fetch_assoc()) {
                        echo '<option value="' . $student['id'] . '">' . htmlspecialchars($student['name']) . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="subject">Select Subject:</label>
                <select name="subject" class="form-control" id="subject" required>
                    <option value="" disabled selected>Select Subject</option>
                    <?php
                    $subjects_query = $con->query("SELECT DISTINCT subject FROM grades");
                    while ($subject = $subjects_query->fetch_assoc()) {
                        echo '<option value="' . htmlspecialchars($subject['subject']) . '">' . htmlspecialchars($subject['subject']) . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="max_grade">Maximum Grade:</label>
                <input type="number" name="max_grade" class="form-control" id="max_grade" min="1" max="100" required oninput="validateGrade(this)">
            </div>
            <div class="form-group">
                <label for="student_grade">Enter Grade:</label>
                <input type="number" name="student_grade" class="form-control" id="student_grade" min="0" max="100" required oninput="validateGrade(this)">
            </div>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>
</div>

<!-- Grades table -->
<table id="studentTable" class="table table-striped">
    <thead>
        <tr>
            <th>Student Name</th>
            <?php
            $subjects_query = $con->query("SELECT DISTINCT subject FROM grades ORDER BY subject");
            $subjects = [];
            while ($row = $subjects_query->fetch_assoc()) {
                $subjects[] = $row['subject'];
                echo '<th>' . htmlspecialchars($row['subject']) . '</th>';
            }
            ?>
            <th>Action</th> <!-- New Action column -->
        </tr>
    </thead>
    <tbody>
        <?php
        

        $students_query = $con->query("SELECT id, name FROM studentdata");
        while ($student = $students_query->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($student['name']) . '</td>';
            
            foreach ($subjects as $subject) {
                $grade_query = $con->query("SELECT student_grade FROM grades WHERE student_id = {$student['id']} AND subject = '$subject'");
                $grade = $grade_query->fetch_assoc();
                echo '<td>' . (isset($grade['student_grade']) ? htmlspecialchars($grade['student_grade']) : '-') . '</td>';
            }

            // Add action button for editing
            echo '<td>
                    <a href="editGrade.php?id=' . $student['id'] . '" class="btn btn-warning btn-sm">Edit</a>
                  </td>';

            echo '</tr>';
        }
        ?>
    </tbody>
</table>
 

<script>
$(document).ready(function() {
   $('#studentTable').DataTable({
        "paging": true,   // Enable pagination
        "pageLength": 10, // Number of records per page
        "lengthMenu": [5, 10, 25, 50], // Options for page length
        "searching": true,
        "columnDefs": [{
            "targets": [-1], // Disable search for the action column
            "searchable": false
        }]
    });
});

// Function to open modal
document.getElementById('addGradeBtn').onclick = function() {
    document.getElementById('addGradeModal').style.display = "block";
};

// Function to close modal
document.getElementsByClassName("close")[0].onclick = function() {
    document.getElementById('addGradeModal').style.display = "none";
};

// Close modal when clicking outside
window.onclick = function(event) {
    if (event.target === document.getElementById('addGradeModal')) {
        document.getElementById('addGradeModal').style.display = "none";
    }
};

// Validate form input
function validateGrade(input) {
    const value = parseInt(input.value, 10);
    if (value < 0 || value > 100) {
        alert("Grade must be between 0 and 100.");
        input.value = '';
    }
}

function validateForm() {
    const grade = document.getElementById('student_grade').value;
    if (grade < 0 || grade > 100) {
        alert("Please enter a valid grade between 0 and 100.");
        return false;
    }
    return true;
}
</script>
</body>
</html>
