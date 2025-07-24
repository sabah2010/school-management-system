<?php
require('D:\wamp64\www\school\assets\fpdf\fpdf.php');  // استدعاء مكتبة FPDF
require_once "D:/wamp64/www/school/assets/databaseconnection/db.php";  // الاتصال بقاعدة البيانات

if (isset($_GET['student_id'])) {
    $student_id = $_GET['student_id'];

    // جلب بيانات الطالب
    $student_query = $con->query("SELECT * FROM studentdata WHERE id = $student_id");
    $student = $student_query->fetch_assoc();

    // جلب درجات الطالب
    $grades_query = $con->query("SELECT subject, student_grade, max_grade FROM grades WHERE student_id = $student_id");

    // حساب المتوسط الحسابي (GPA)
    $total_grade = 0;
    $total_max_grade = 0;
    $subject_count = 0;

    while ($grade = $grades_query->fetch_assoc()) {
        $total_grade += $grade['student_grade'];
        $total_max_grade += $grade['max_grade'];
        $subject_count++;
    }

    // التأكد من وجود درجات لحساب المتوسط
    $gpa = $subject_count > 0 ? round(($total_grade / $total_max_grade) * 100, 2) : 0;

    // إعادة تعيين مؤشر استعلام الدرجات لعرضها في PDF لاحقًا
    $grades_query->data_seek(0);

    // إنشاء PDF
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Image('D:/wamp64/www/school/assets/images/logo.jpg', 160, 10, 30);

    // عرض بيانات الطالب
    $pdf->Cell(40, 10, 'Student Information');
    $pdf->Ln(10);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(40, 10, 'Name: ' . $student['name']);
    $pdf->Ln(8);
    $pdf->Cell(40, 10, 'Date of Birth: ' . $student['date_of_birth']);
    $pdf->Ln(8);
    $pdf->Cell(40, 10, 'Gender: ' . $student['gender']);
    $pdf->Ln(8);
    $pdf->Cell(40, 10, 'City: ' . $student['city']);
    $pdf->Ln(15);

    // عرض جدول الدرجات
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(60, 10, 'Subject', 1);
    $pdf->Cell(60, 10, 'Grade', 1);
    $pdf->Cell(60, 10, 'Max Grade', 1);
    $pdf->Ln();

    while ($grade = $grades_query->fetch_assoc()) {
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(60, 10, $grade['subject'], 1);
        $pdf->Cell(60, 10, $grade['student_grade'], 1);
        $pdf->Cell(60, 10, $grade['max_grade'], 1);
        $pdf->Ln();
    }

    // عرض المتوسط الحسابي (GPA)
    $pdf->Ln(10);  // مسافة قبل عرض GPA
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(40, 10, 'GPA: ' . $gpa . '%');
    // إخراج PDF إلى المتصفح
    $pdf->Output();
} else {
    echo "Invalid student ID.";
}
?>
