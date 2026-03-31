<?php
// TEMPORARY: Pause for 2 seconds to test the loading state
sleep(2);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'])) {
    $pwd = $_POST['password'];

    $hasLength = strlen($pwd) >= 6;
    $hasUpper  = preg_match('/[A-Z]/', $pwd);
    $hasLower  = preg_match('/[a-z]/', $pwd);
    $hasDigit  = preg_match('/\d/', $pwd);
    $hasSymbol = preg_match('/[^A-Za-z0-9]/', $pwd);

    if ($hasLength && $hasUpper && $hasLower && $hasDigit && $hasSymbol) {
        echo "VALID";
    } else {
        echo "INVALID";
    }
}
?>
<?php
// Ensure we only process POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'])) {
    $pwd = $_POST['password'];

    // Validation Criteria:
    // 1. At least 6 characters
    // 2. Contains uppercase
    // 3. Contains lowercase
    // 4. Contains a digit
    // 5. Contains a symbol
    $hasLength = strlen($pwd) >= 6;
    $hasUpper  = preg_match('/[A-Z]/', $pwd);
    $hasLower  = preg_match('/[a-z]/', $pwd);
    $hasDigit  = preg_match('/\d/', $pwd);
    $hasSymbol = preg_match('/[^A-Za-z0-9]/', $pwd);

    if ($hasLength && $hasUpper && $hasLower && $hasDigit && $hasSymbol) {
        echo "VALID";
    } else {
        echo "INVALID";
    }
}
?>