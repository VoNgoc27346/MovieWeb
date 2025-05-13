<?php
function getUserByUsername($username) {
    $pdo = new PDO('mysql:host=localhost;dbname=your_dbname', 'your_user', 'your_pass');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    return $stmt->fetch();
}
?>