<?php
// Bắt đầu session trước khi có bất kỳ output nào
session_start();

// Simple test to check database connection
try {
    $pdo = new PDO('mysql:host=localhost;dbname=movie_online', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Database connection successful!<br>";
    
    // Test session handling
    $_SESSION['test'] = 'Testing session';
    echo "Session ID: " . session_id() . "<br>";
    echo "Session value: " . $_SESSION['test'] . "<br>";
    
    // Test the cookie handling
    setcookie('test_cookie', 'cookie_value', time() + 3600, '/');
    echo "Cookie set successfully!<br>";
    
    // Display PHP info
    echo "PHP Version: " . phpversion() . "<br>";
    
    echo "<h2>Test Complete</h2>";
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?> 