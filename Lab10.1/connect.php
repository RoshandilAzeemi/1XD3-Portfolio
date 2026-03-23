<?php
// Database credentials
$host = 'localhost';
$db   = 'azeemir_db';
$user = 'azeemir_local';
$pass = '{+IRXCT9'; 
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
     $pdo = new PDO($dsn, $user, $pass, $options);
     // If you want to confirm success during testing (Part 1 of lab)
     // echo "Connected successfully"; 
} catch (\PDOException $e) {
     // Letting the user know what happened (Requirement for Exercise 4)
     die("Connection failed: " . $e->getMessage());
}
?>