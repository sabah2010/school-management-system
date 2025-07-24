<h1>Welcom to Glory School</h1>
<?php
session_start();
if (isset($_SESSION['username'])) {
    // إعادة توجيه المستخدم إذا كان قد سجل الدخول بالفعل
    header("Location: homePage.php");
    exit();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // تحقق بسيط (استبدل بهذا تحقق من قاعدة البيانات)
    if ($username === 'admin' && $password === '1234') {
        $_SESSION['username'] = $username;
        header("Location: homePage.php"); // عدل الصفحة حسب حاجتك
        exit();
    } else {
        $error = 'اسم المستخدم أو كلمة المرور غير صحيحة.';
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول</title>
    <link rel="stylesheet" href="assets/style.css">
	 <link rel="stylesheet" type="text/css" href="/school/assets/css/style6.css">
</head>
<body>
    <section class="login-section">
        <form method="POST" action="index.php">
            <h2>تسجيل الدخول</h2>
            <input type="text" name="username" placeholder="اسم المستخدم" required>
            <input type="password" name="password" placeholder="كلمة المرور" required>
            <button type="submit">دخول</button>
            <p style="color: red;"><?= $error ?></p>
        </form>
    </section>
</body>
</html>
