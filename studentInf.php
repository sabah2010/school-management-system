<!DOCTYPE html>
<html lang="en">
<head>
    <title>Student Data</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">  
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/school/assets/css/style3.css">
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

<center><h1>Student Data</h1></center>
<center><button class="add-button" onClick='window.location.href="createStudent.php";'>Add New Student</button></center>
<center><a href="homePage.php" class="btn-home">Back to Home</a></center>
<h3  class="header-right"> <?php echo "Hello! ". $_SESSION['username'] ." - "."<a href='logout.php'> Logout</a>"; ?> </h3>
<?php

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
require_once "D:/wamp64/www/school/assets/databaseconnection/db.php";

$records_per_page = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start_from = ($page - 1) * $records_per_page;

$total_records_query = $con->query("SELECT COUNT(*) AS total FROM studentdata");
$total_records = $total_records_query->fetch_assoc()['total'];
$total_pages = ceil($total_records / $records_per_page);

$result = $con->query("SELECT * FROM studentdata ORDER BY id DESC LIMIT $start_from, $records_per_page");
/*
echo "<div class='pagination'>";
echo "<button " . ($page == 1 ? "class='disabled' disabled" : "onclick=\"window.location.href='?page=1'\"") . ">First</button>";
echo "<button " . ($page == 1 ? "class='disabled' disabled" : "onclick=\"window.location.href='?page=" . ($page - 1) . "'\"") . ">Previous</button>";
echo "<span>Page $page of $total_pages pages</span>";
echo "<button " . ($page == $total_pages ? "class='disabled' disabled" : "onclick=\"window.location.href='?page=" . ($page + 1) . "'\"") . ">Next</button>";
echo "<button " . ($page == $total_pages ? "class='disabled' disabled" : "onclick=\"window.location.href='?page=$total_pages'\"") . ">Last</button>";
echo "</div>";
*/
if ($result->num_rows > 0) {
    echo "<table id='studentTable' class='student-table'>
    <thead>
    <tr>
        <th>#</th>
        <th>Student ID</th>
        <th>Name</th>
        <th>Date of Birth</th>
        <th>Gender</th>
        <th>City</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>";
    $i = $start_from + 1;
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $i . "</td>
                <td>" . $row['id'] . "</td>
                <td>" . $row['name'] . "</td>
                <td>" . $row['date_of_birth'] . "</td>
                <td>" . $row['gender'] . "</td>
                <td>" . $row['city'] . "</td>
                <td style='display: flex; gap: 10px; justify-content: center;'>
                    <a href='createStudent.php?id=" . $row['id'] . "' class='edit-button'>Edit</a>
                    <form method='POST' action='deleteStudent.php' style='display:inline;'>
                        <input type='hidden' name='student_id' value='" . $row['id'] . "'>
                        <button type='submit' name='delete' onclick='return confirm(\"Are you sure you want to delete this student?\");' style='color: #ffffff;'>Delete</button>
                    </form> |
                    <button class='enter-grade-button' onclick='showGradeForm(" . $row['id'] . ");'>Enter Grade</button> |
                    <button class='view-grade-button' onclick='viewGrades(" . $row['id'] . ");'>View Grades</button> |
                    <button class='view-grade-button' onclick=\"window.open( 'generateStudentPDF.php?student_id=" . $row['id'] . "' );\">Generate PDF</button> 
                </td>
              </tr>";
        $i++;
    }
    echo "</tbody></table>";
} else {
    echo "<h2>No records found.</h2>";
}

$con->close();
?>

<!-- Bootstrap Modal for Grade Entry -->
<div class="modal fade" id="gradeModal" tabindex="-1" aria-labelledby="gradeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" style="background-color: #f5f5f5;">
      <div class="modal-header" style="background-color: #007bff; color: #fff;">
        <h5 class="modal-title" id="gradeModalLabel">Enter Grade</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body" style="background-color: #e9ecef; color: #333;">
        <form id="gradeForm">
          <input type="hidden" id="studentId">
          <div class="form-group">
            <label for="subject">Subject Name</label>
            <select class="form-control" id="subject" required>
                <option value="">Select Subject</option>
                <option value="Arabic">Arabic</option>
                <option value="Math">Math</option>
                <option value="Science">Science</option>
                <option value="Social">Social</option>
                <option value="Computer">Computer</option>
                <option value="English">English</option>
            </select>
          </div>
          <div class="form-group">
            <label for="max_grade">Maximum Grade</label>
            <input type="number" class="form-control" id="max_grade" min="1" max="100" required oninput="validateGrade(this)">
          </div>
          <div class="form-group">
            <label for="grade">Grade</label>
            <input type="number" class="form-control" id="grade" min="0" max="100" required oninput="validateGrade(this)">
          </div>
          <button type="button" class="btn btn-primary" id="submitGrade">Submit</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script>  
$(document).ready(function() {
    $('#studentTable').DataTable({
        "paging": true,   // تمكين تقسيم الصفحات
        "searching": true, // تمكين البحث
        "info": true,      // عرض معلومات الجدول (مثل: Showing 1 to 10 of 50 entries)
        "columnDefs": [{
            "targets": [6], // تعطيل البحث على عمود "Action"
            "searchable": false
        }]
    }); // Initialize DataTable
});

function showGradeForm(studentId) {
    $('#studentId').val(studentId);
    $('#gradeModal').modal('show');
}

$('#submitGrade').click(function() {
    const studentId = $('#studentId').val();
    const subject = $('#subject').val();
    const grade = $('#grade').val();
    const max_grade = $('#max_grade').val();

    if (!subject || grade === '' || max_grade === '') {
        Swal.fire({
            icon: 'warning',
            title: 'Incomplete Fields',
            text: 'Please fill all fields.',
        });
        return;
    }

    $.post('submitGrade.php', {
        student_id: studentId,
        subject: subject,
        student_grade: grade,
        max_grade: max_grade
    }, function(response) {
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: response,
            timer: 2000,
            showConfirmButton: false
        }).then(() => {
            $('#gradeModal').modal('hide');
            location.reload(); // Reload to reflect changes
        });
    }).fail(function() {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Failed to submit grade.',
        });
    });
});

function viewGrades(studentId) {
    window.location.href = 'getGrades.php?student_id=' + studentId;
}

function validateGrade(input) {
        if (input.value > 100) {
            alert("Grade cannot exceed 100.");
            input.value = 100; // Reset to 100 if it exceeds
        }
    }
	

</script>

</body>
</html>
