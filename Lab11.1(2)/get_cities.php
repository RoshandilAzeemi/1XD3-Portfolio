<?php
header('Content-Type: application/json');

$host = 'localhost';
$db = 'azeemir_db';
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

    // Get min and max from GET request
    $min = isset($_GET['min']) ? (int)$_GET['min'] : 0;
    $max = isset($_GET['max']) ? (int)$_GET['max'] : 2000000000;

    // Prepare and execute the query
    $stmt = $pdo->prepare("SELECT Name, District, Population FROM City 
    WHERE Population BETWEEN :min AND :max 
    ORDER BY Population DESC");
    $stmt->execute(['min' => $min, 'max' => $max]);
    
    $cities = $stmt->fetchAll();

    echo json_encode($cities);

} catch (\PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>