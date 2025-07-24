<?php

require_once "D:\wamp64\www\school\assets\databaseconnection\db.php";  // استدعاء ملف الاتصال بقاعدة البيانات

// تحقق مما إذا كانت student_id موجودة في عنوان URL
if (isset($_GET['student_id'])) {
    $student_id = intval($_GET['student_id']); // تحويل القيمة إلى عدد صحيح

    // استعلام لجلب معلومات الطالب
    $student_query = $con->prepare("SELECT * FROM studentdata WHERE id = ?");
    $student_query->bind_param('i', $student_id);
    $student_query->execute();
    $student = $student_query->get_result()->fetch_assoc();

    if ($student) {
        echo "<h2>Grades for " . htmlspecialchars($student['name']) . "</h2>";

        // استعلام لجلب درجات الطالب
        $result = $con->prepare("SELECT subject, max_grade, student_grade FROM grades WHERE student_id = ?");
        $result->bind_param('i', $student_id);
        $result->execute();
        $grades_result = $result->get_result();

        if ($grades_result->num_rows > 0) {
            echo "<table class='table table-striped'>
                <thead>
                    <tr>
                        <th>Subject Name</th>
                        <th>Maximum Grade</th>
                        <th>Student's Grade</th>
                    </tr>
                </thead>
                <tbody>";
            while ($row = $grades_result->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($row['subject']) . "</td>
                        <td>" . htmlspecialchars($row['max_grade']) . "</td>
                        <td>" . htmlspecialchars($row['student_grade']) . "</td>
                      </tr>";
            }
            echo "</tbody>
                  </table>";
        } else {
            echo "<h4 class='text-center'>No grades available.</h4>";
        }
    } else {
        echo "<h4 class='text-center'>Student not found.</h4>";
		
    }
} else {
    echo "<h4 class='text-center'>No student selected.</h4>";
}

$con->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Grades</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/school/assets/css/style2.css
	">
</head>
<body>

<div class="container">
    <a href="studentInf.php" class="btn btn-primary btn-back">Back to Student List</a>
</div>

</body>
</html>
