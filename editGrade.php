<?php
require_once "D:\wamp64\www\school\assets\databaseconnection\db.php";

if (isset($_GET['id'])) {
    $student_id = (int)$_GET['id'];

    // الحصول على درجات الطالب
    $grades_query = $con->query("SELECT subject, student_grade FROM grades WHERE student_id = $student_id");
    $grades = [];
    while ($row = $grades_query->fetch_assoc()) {
        $grades[$row['subject']] = $row['student_grade'];
    }

    // الحصول على أسماء المواد
    $subjects_query = $con->query("SELECT DISTINCT subject FROM grades");
    $subjects = [];
    while ($subject = $subjects_query->fetch_assoc()) {
        $subjects[] = $subject['subject'];
    }
}

// حفظ التغييرات
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST['grades'] as $subject => $grade) {
        $grade = (int)$grade; // تأكد من أن القيمة عدد صحيح
        $con->query("UPDATE grades SET student_grade = $grade WHERE student_id = $student_id AND subject = '$subject'");
    }
    header("Location: viewAllGrades.php"); // إعادة التوجيه بعد الحفظ
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Grades</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/school/assets/css/style5.css">
</head>
<body>
<div class="container">
    <h1>Edit Grades for Student ID: <?= htmlspecialchars($student_id) ?></h1>
    <form method="POST">
        <?php foreach ($subjects as $subject): ?>
            <?php if (isset($grades[$subject])): // عرض الحقل فقط إذا كانت هناك درجة مدخلة ?>
                <div class="form-group">
                    <label><?= htmlspecialchars($subject) ?></label>
                    <input type="number" name="grades[<?= htmlspecialchars($subject) ?>]" class="form-control" value="<?= htmlspecialchars($grades[$subject]) ?>" min="0" max="100" required oninput="validateGrade(this)">
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
        <button type="submit" class="btn btn-success">Save Changes</button>
    </form>
    <a href="viewAllGrades.php" class="btn btn-secondary">Back to Grades</a>
</div>
<script>
function validateGrade(input) {
    const value = parseInt(input.value, 10);
    if (value < 0 || value > 100) {
        alert("Grade must be between 0 and 100.");
        input.value = ''; // تعيين القيمة إلى فارغة
    }
}
</script>
</body>
</html>
