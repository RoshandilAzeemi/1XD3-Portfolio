<?php session_start(); 
if(!isset($_SESSION['credits'])) $_SESSION['credits'] = 10; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>AJAX Slot Machine</title>
    <style>
        body { font-family: 'Arial', sans-serif; background: #2c3e50; color: white; text-align: center; padding-top: 50px; }
        .slot-machine { background: #c0392b; display: inline-block; padding: 30px; border-radius: 20px; border: 8px solid #f1c40f; }
        .reels-container { display: flex; gap: 10px; background: #ecf0f1; padding: 15px; border-radius: 10px; margin: 20px 0; }
        .reel { width: 80px; height: 80px; background: white; display: flex; align-items: center; justify-content: center; border: 2px solid #34495e; }
        .reel img { width: 70%; }
        .controls { margin-top: 20px; }
        input[type="number"] { padding: 10px; width: 60px; border-radius: 5px; border: none; }
        button { padding: 10px 20px; background: #f1c40f; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; }
        #message { height: 30px; font-weight: bold; margin-bottom: 10px; }
    </style>
</head>
<body>

    <div class="slot-machine">
        <h1>FRUIT SLOTS</h1>
        <div id="message">Enter a bet and spin!</div>
        <div id="credits-display">Credits: <strong><?= $_SESSION['credits'] ?></strong></div>

        <div class="reels-container">
            <div class="reel"><img id="r0" src="images/fruit/1.png"></div>
            <div class="reel"><img id="r1" src="images/fruit/1.png"></div>
            <div class="reel"><img id="r2" src="images/fruit/1.png"></div>
        </div>

        <div class="controls">
            <input type="number" id="betAmount" value="1" min="1">
            <button onclick="spin()">SPIN</button>
        </div>
    </div>

    <script>
    async function spin() {
        const bet = document.getElementById('betAmount').value;
        const msgDiv = document.getElementById('message');
        
        try {
            const response = await fetch('backend.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `bet=${bet}`
            });

            const data = await response.json();

            if (data.error) {
                msgDiv.style.color = "yellow";
                msgDiv.innerText = data.error;
                return;
            }

            // Update Images
            data.reels.forEach((img, index) => {
                document.getElementById(`r${index}`).src = `images/fruit/${img}`;
            });

            // Update UI
            msgDiv.style.color = "white";
            msgDiv.innerText = data.message + " (Won: " + data.payout + ")";
            document.getElementById('credits-display').innerHTML = `Credits: <strong>${data.credits}</strong>`;

            if (data.gameOver) {
                alert("Game Over! You've run out of credits.");
                location.reload();
            }

        } catch (err) {
            console.error("Error connecting to backend", err);
        }
    }
    </script>
</body>
</html>