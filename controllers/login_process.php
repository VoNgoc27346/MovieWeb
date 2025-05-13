<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=your_dbname', 'your_username', 'your_password');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$username = $_POST['username'];
$password = $_POST['password'];

// Tìm user trong DB
$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch();

if ($user) {
    // So sánh mật khẩu (SHA-256)
    if (hash('sha256', $password) === $user['password']) {
        // Đăng nhập thành công
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        header('Location: index.php');
        exit;
    }
}

$_SESSION['error'] = "Sai tên đăng nhập hoặc mật khẩu.";
header('Location: login.php');
exit;
