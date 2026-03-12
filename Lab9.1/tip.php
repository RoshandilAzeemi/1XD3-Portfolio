<?php
/**
 * TIP CALCULATOR - Single File PHP App
 * Logic: 
 * 1. If the page is loaded normally (GET), show the form.
 * 2. If the form is submitted (POST), validate and show the receipt.
 */

$show_receipt = false;
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Capture and Sanitize Inputs
    $server_name = htmlspecialchars($_POST['server_name'] ?? '');
    $email = $_POST['email'] ?? '';
    $confirm_email = $_POST['confirm_email'] ?? '';
    $amount = isset($_POST['amount']) ? (float)$_POST['amount'] : 0;
    $percent = isset($_POST['tip_percent']) ? (int)$_POST['tip_percent'] : 0;
    $cc = str_replace([' ', '-'], '', $_POST['cc_number'] ?? '');

    // 2. Strict Validation (Requirement: Print error and nothing else if invalid)
    if (empty($server_name) || empty($email) || empty($cc)) {
        die("Error: All fields are required.");
    }
    if ($email !== $confirm_email) {
        die("Error: Email addresses do not match.");
    }
    if ($amount <= 0 || $percent < 0) {
        die("Error: Amount and Tip must be positive numbers.");
    }
    if (strlen($cc) !== 16 || !is_numeric($cc)) {
        die("Error: Credit card number must be exactly 16 digits.");
    }

    // 3. Perform Calculations
    $tip_total = $amount * ($percent / 100);
    $final_total = $amount + $tip_total;
    $show_receipt = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professional Tip Calculator</title>
    <style>
        /* Centering Logic using Flexbox */
        body { 
            font-family: 'Segoe UI', Arial, sans-serif; 
            background-color: #f4f7f6; 
            margin: 0; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            min-height: 100vh; 
        }

        .card { 
            background: white; 
            padding: 30px; 
            border-radius: 12px; 
            box-shadow: 0 4px 20px rgba(0,0,0,0.1); 
            width: 100%; 
            max-width: 400px; 
            box-sizing: border-box; 
        }

        h2, h3 { color: #333; margin-top: 0; text-align: center; }

        .form-group { margin-bottom: 15px; }
        
        label { 
            display: block; 
            margin-bottom: 5px; 
            font-weight: 600; 
            font-size: 0.9em; 
        }

        input { 
            width: 100%; 
            padding: 10px; 
            border: 1px solid #ddd; 
            border-radius: 6px; 
            box-sizing: border-box; /* Keeps inputs inside the box */
            font-size: 1em;
        }

        button { 
            width: 100%; 
            padding: 12px; 
            background-color: #007bff; 
            color: white; 
            border: none; 
            border-radius: 6px; 
            cursor: pointer; 
            font-size: 1em; 
            font-weight: bold;
            transition: background 0.2s;
        }

        button:hover { background-color: #0056b3; }

        /* Receipt Styling */
        .receipt-line { 
            display: flex; 
            justify-content: space-between; 
            padding: 8px 0; 
            border-bottom: 1px dashed #eee; 
        }

        .total-line { 
            font-weight: bold; 
            font-size: 1.2em; 
            border-top: 2px solid #333; 
            margin-top: 10px; 
            padding-top: 10px; 
        }

        .btn-back { 
            display: inline-block; 
            margin-top: 20px; 
            text-decoration: none; 
            color: #007bff; 
            font-size: 0.9em; 
        }
    </style>
</head>
<body>

<div class="card">
    <?php if (!$show_receipt): ?>
        <h2>Tip Calculator</h2>
        <form id="tipForm" method="POST" action="">
            <div class="form-group">
                <label>Server Name</label>
                <input type="text" name="server_name" required>
            </div>
            <div class="form-group">
                <label>Customer Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Confirm Email</label>
                <input type="email" id="confirm_email" name="confirm_email" required>
            </div>
            <div class="form-group">
                <label>Bill Amount ($)</label>
                <input type="number" name="amount" step="0.01" min="0.01" required>
            </div>
            <div class="form-group">
                <label>Tip Percentage (%)</label>
                <input type="number" name="tip_percent" min="0" required>
            </div>
            <div class="form-group">
                <label>Credit Card Number (16 digits)</label>
                <input type="text" name="cc_number" required>
            </div>
            <button type="submit">Process Payment</button>
        </form>

        <script>
            // JavaScript validation to prevent submission if emails don't match
            document.getElementById('tipForm').onsubmit = function(e) {
                const email = document.getElementById('email').value;
                const confirm = document.getElementById('confirm_email').value;
                
                if (email !== confirm) {
                    alert("The two email addresses do not match!");
                    e.preventDefault(); // Stop the form from submitting
                    return false;
                }
                return true;
            };
        </script>

    <?php else: ?>
        <h3>Payment Receipt</h3>
        <p><strong>Server:</strong> <?= $server_name ?></p>
        <p><strong>Customer:</strong> <?= htmlspecialchars($email) ?></p>
        
        <div class="receipt-line">
            <span>Original Bill:</span>
            <span>$<?= number_format($amount, 2) ?></span>
        </div>
        <div class="receipt-line">
            <span>Tip (<?= $percent ?>%):</span>
            <span>$<?= number_format($tip_total, 2) ?></span>
        </div>
        <div class="receipt-line total-line">
            <span>Total:</span>
            <span>$<?= number_format($final_total, 2) ?></span>
        </div>
        
        <p style="font-size: 0.8em; color: #777; text-align: center; margin-top: 15px;">
            Paid via Card: **** **** **** <?= substr($cc, -4) ?>
        </p>

        <div style="text-align: center;">
            <a href="" class="btn-back">← Calculate New Bill</a>
        </div>
    <?php endif; ?>
</div>

</body>
</html>