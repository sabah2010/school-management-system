<?php

require_once "D:\wamp64\www\school\assets\databaseconnection\db.php";  // استدعاء ملف الاتصال بقاعدة البيانات


// التحقق مما إذا تم إرسال ID الطالب
if (isset($_POST['delete'])) {
    $student_id = $_POST['student_id'];

    // استعلام للتحقق من وجود درجات للطالب
    $checkGradesQuery = "SELECT COUNT(*) AS gradeCount FROM grades WHERE student_id = ?";
    $stmt = $con->prepare($checkGradesQuery);
    
    if ($stmt) {
        $stmt->bind_param("i", $student_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row['gradeCount'] > 0) {
            // إذا كان لدى الطالب درجات مخزنة
            echo "<script>alert('لا يمكنك حذف هذا الطالب لأنه لديه درجات مخزنة.'); window.location.href='studentInf.php';</script>";
        } else {
            // إذا لم يكن لدى الطالب درجات، احذفه
            $deleteQuery = "DELETE FROM studentdata WHERE id = ?";
            $stmt = $con->prepare($deleteQuery);
            
            if ($stmt) {
                $stmt->bind_param("i", $student_id);
                
                if ($stmt->execute()) {
                    // تم حذف الطالب بنجاح
                    echo "<script>alert('تم حذف الطالب بنجاح.'); window.location.href='studentInf.php';</script>";
                } else {
                    // فشل حذف الطالب
                    echo "<script>alert('فشل حذف الطالب.'); window.location.href='studentInf.php';</script>";
                }
            } else {
                echo "<script>alert('فشل إنشاء استعلام الحذف.'); window.location.href='studentInf.php';</script>";
            }
        }
        $stmt->close(); // إغلاق العبارة
    } else {
        echo "<script>alert('فشل إنشاء استعلام التحقق من الدرجات.'); window.location.href='studentInf.php';</script>";
    }
}

// إغلاق الاتصال
$con->close();
?>
