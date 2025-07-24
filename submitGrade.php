<?php

require_once "D:\wamp64\www\school\assets\databaseconnection\db.php";  // استدعاء ملف الاتصال بقاعدة البيانات
// استقبال المدخلات مع التأكد من وجودها بشكل صحيح
$student_id = isset($_POST['student_id']) ? (int)$_POST['student_id'] : 0;
$subject = isset($_POST['subject']) ? $con->real_escape_string($_POST['subject']) : '';
$student_grade = isset($_POST['student_grade']) ? (int)$_POST['student_grade'] : -1;
$max_grade = isset($_POST['max_grade']) ? (int)$_POST['max_grade'] : 0;

// تحقق من أن الدرجة في النطاق الصحيح
if ($student_grade < 0 || $student_grade > 100) {
    echo "<script>alert('Error: Grade must be between 0 and 100.'); window.history.back();</script>";
    exit();
}

// تحقق من وجود الطالب في قاعدة البيانات
$student_check = $con->query("SELECT * FROM studentdata WHERE id = '$student_id'");
if ($student_check->num_rows == 0) {
    echo "<script>alert('Error: Student not found.'); window.history.back();</script>";
    exit();
}

// تحقق من عدم إدخال نفس الدرجة مسبقًا لنفس المادة
$grade_check = $con->query("SELECT * FROM grades WHERE student_id = '$student_id' AND subject = '$subject'");
if ($grade_check->num_rows > 0) {
    echo "<script>alert('Error: Grade for this subject has already been entered.'); window.history.back();</script>";
    exit();
}

// إدخال الدرجة في قاعدة البيانات
$sql = "INSERT INTO grades (student_id, subject, student_grade, max_grade) VALUES ('$student_id', '$subject', '$student_grade', '$max_grade')";
if ($con->query($sql) === TRUE) {
   
} else {
    echo "<script>alert('Error: " . $con->error . "'); window.history.back();</script>";
}

$con->close();
?>
