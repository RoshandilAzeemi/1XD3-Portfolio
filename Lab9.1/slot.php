<?php
/**
 * Simple Slot Machine
 * Logic: Generate 3 random numbers, map them to images, and check for matches.
 */

// 1. Define your fruit images (update these names to match your actual files)
// If your files are named fruit0.png, fruit1.png, etc., this list works perfectly.
$fruits = ['1.png', '2.png', '3.png', '4.png', '5.png', '6.png'];

// 2. "Spin" the reels by picking 3 random indexes
$reel1_idx = rand(0, count($fruits) - 1);
$reel2_idx = rand(0, count($fruits) - 1);
$reel3_idx = rand(0, count($fruits) - 1);

// 3. Get the actual filenames
$res1 = $fruits[$reel1_idx];
$res2 = $fruits[$reel2_idx];
$res3 = $fruits[$reel3_idx];

// 4. Determine the win status
$message = "Better luck next time!";
$win_class = "no-win";

if ($res1 === $res2 && $res2 === $res3) {
    $message = "JACKPOT! 💰💰💰";
    $win_class = "jackpot";
} elseif ($res1 === $res2 || $res2 === $res3 || $res1 === $res3) {
    $message = "YOU WIN! 🏆";
    $win_class = "win";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHP Slot Machine</title>
    <style>
        body {
            font-family: 'Arial Black', sans-serif;
            background-color: #2c3e50;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            color: white;
        }

        .slot-machine {
            background: #c0392b;
            padding: 40px;
            border: 10px solid #f1c40f;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 0 50px rgba(0,0,0,0.5);
        }

        .reels-container {
            display: flex;
            gap: 15px;
            background: #ecf0f1;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 25px;
            border: 5px solid #34495e;
        }

        .reel {
            width: 100px;
            height: 100px;
            background: white;
            border-radius: 8px;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        .reel img {
            width: 80%;
            height: auto;
        }

        .status-message {
            font-size: 1.5em;
            margin-bottom: 20px;
            text-shadow: 2px 2px #000;
        }

        .jackpot { color: #f1c40f; animation: blink 0.5s infinite; }
        .win { color: #2ecc71; }
        
        @keyframes blink {
            0% { opacity: 1; }
            50% { opacity: 0.5; }
            100% { opacity: 1; }
        }

        .spin-button {
            display: inline-block;
            background: #f1c40f;
            color: #2c3e50;
            padding: 15px 40px;
            text-decoration: none;
            border-radius: 50px;
            font-weight: bold;
            font-size: 1.2em;
            box-shadow: 0 5px #d35400;
            transition: all 0.1s;
        }

        .spin-button:active {
            box-shadow: 0 2px #d35400;
            transform: translateY(3px);
        }
    </style>
</head>
<body>

    <div class="slot-machine">
        <h1>FRUIT SLOTS</h1>
        
        <div class="status-message <?= $win_class ?>">
            <?= $message ?>
        </div>

        <div class="reels-container">
            <div class="reel">
                <img src="images/fruit/<?= $res1 ?>" alt="Fruit 1">
            </div>
            <div class="reel">
                <img src="images/fruit/<?= $res2 ?>" alt="Fruit 2">
            </div>
            <div class="reel">
                <img src="images/fruit/<?= $res3 ?>" alt="Fruit 3">
            </div>
        </div>

        <a href="slot.php" class="spin-button">SPIN AGAIN</a>
    </div>

</body>
</html>