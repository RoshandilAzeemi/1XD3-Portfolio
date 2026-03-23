<?php
require 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $poll_id = $_POST['poll_id'];
    $option_num = $_POST['option'];

    // Validate Option (1-4)
    if (!in_array($option_num, [1, 2, 3, 4])) {
        die("Error: Invalid option selected.");
    }

    try {
        // 1. Check if the Poll ID exists using the 'ID' column 
        $checkStmt = $pdo->prepare("SELECT * FROM poll WHERE ID = ?");
        $checkStmt->execute([$poll_id]);
        
        if ($checkStmt->rowCount() == 0) {
            die("Error: Invalid Poll ID ($poll_id). This poll does not exist.");
        }

        // 2. Increment the correct 'voteX' column 
        $column = "vote" . $option_num; 
        $sql = "UPDATE poll SET $column = $column + 1 WHERE ID = ?";
        $stmt = $pdo->prepare($sql);
        
        if ($stmt->execute([$poll_id])) {
            echo "Success! Your vote has been recorded in the '$column' column for Poll #$poll_id.";
        } else {
            echo "Error: Could not record vote.";
        }

    } catch (PDOException $e) {
        die("Database Error: " . $e->getMessage());
    }
}
?>