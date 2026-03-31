<?php
session_start();
header('Content-Type: application/json');

// Error 1: No active session/Initialization
if (!isset($_SESSION['credits'])) {
    $_SESSION['credits'] = 10;
}

// Check for POST data
$bet = isset($_POST['bet']) ? (int)$_POST['bet'] : 0;

// Validation Logic
if ($bet < 1) {
    echo json_encode(['error' => 'Minimum bet is 1 credit.']);
    exit;
}

if ($bet > $_SESSION['credits']) {
    echo json_encode(['error' => 'You do not have enough credits!']);
    exit;
}

// The Spin
$fruits = ['1.png', '2.png', '3.png', '4.png', '5.png', '6.png'];
$r1 = rand(0, count($fruits) - 1);
$r2 = rand(0, count($fruits) - 1);
$r3 = rand(0, count($fruits) - 1);

$payout_multiplier = 0;
$message = "No luck!";

// Win Logic
if ($r1 === $r2 && $r2 === $r3) {
    $payout_multiplier = 10; // 10x for Triple
    $message = "JACKPOT! 💰";
} elseif ($r1 === $r2 || $r2 === $r3 || $r1 === $r3) {
    $payout_multiplier = 2;  // 2x for Pair
    $message = "YOU WIN! 🏆";
}

// Update Credits
$winnings = $bet * $payout_multiplier;
$_SESSION['credits'] = ($_SESSION['credits'] - $bet) + $winnings;

$gameOver = false;
if ($_SESSION['credits'] <= 0) {
    $gameOver = true;
    session_destroy();
}

// Return JSON
echo json_encode([
    'reels' => [$fruits[$r1], $fruits[$r2], $fruits[$r3]],
    'message' => $message,
    'credits' => $_SESSION['credits'],
    'payout' => $winnings,
    'gameOver' => $gameOver
]);