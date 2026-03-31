<?php
session_start();

// Handle resetting the game
if (isset($_GET['reset'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}

// Determine which page to show
$step = $_POST['step'] ?? $_SESSION['step'] ?? 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Three-Page Guessing Game</title>
    <style>
        body { font-family: sans-serif; line-height: 1.6; padding: 20px; max-width: 400px; }
        .error { color: red; }
        .success { color: green; font-weight: bold; }
    </style>
</head>
<body>

<?php
// --- PAGE 1: Set the Range ---
if ($step == 1): ?>
    <h2>Step 1: Set the Range</h2>
    <form method="post">
        <label>Min Number: <input type="number" name="min" required></label><br><br>
        <label>Max Number: <input type="number" name="max" required></label><br><br>
        <input type="hidden" name="step" value="2">
        <button type="submit">Set Range</button>
    </form>

<?php
// --- PAGE 2: Make a Guess ---
elseif ($step == 2):
    if (isset($_POST['min']) && isset($_POST['max'])) {
        $_SESSION['min'] = (int)$_POST['min'];
        $_SESSION['max'] = (int)$_POST['max'];
        $_SESSION['target'] = rand($_SESSION['min'], $_SESSION['max']);
        $_SESSION['step'] = 2;
    }
    ?>
    <h2>Step 2: Guess the Number</h2>
    <p>I am thinking of a number between 
       <strong><?php echo $_SESSION['min']; ?></strong> and 
       <strong><?php echo $_SESSION['max']; ?></strong>.
    </p>
    <form method="post">
        <input type="number" name="guess" required autofocus>
        <input type="hidden" name="step" value="3">
        <button type="submit">Guess!</button>
    </form>

<?php
// --- PAGE 3: Result ---
elseif ($step == 3):
    $guess = (int)$_POST['guess'];
    $target = $_SESSION['target'];

    if ($guess === $target): ?>
        <h2 class="success">Correct!</h2>
        <p>You nailed it! The number was <?php echo $target; ?>.</p>
        <?php session_destroy(); // Game over, clean up ?>
        <a href="index.php">Play Again from Scratch</a>

    <?php else: ?>
        <h2 class="error">Wrong!</h2>
        <p>You guessed <?php echo $guess; ?>, but that's not it.</p>
        <form method="post">
            <input type="hidden" name="step" value="2">
            <button type="submit">Try Again</button>
        </form>
        <br>
        <a href="index.php?reset=1">Start over with new range</a>
    <?php endif; ?>

<?php endif; ?>

</body>
</html>