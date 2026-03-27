<?php
session_start(); // MUST be first before any output

/******************************************************
 * Activity 11.1 – Super Global Variables Explorer
 ******************************************************/

// -------------------------------
// 1. Handle POST submission (name)
// -------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_name'])) {
    $postedName = htmlspecialchars($_POST['post_name']);
    $_SESSION['username'] = $postedName;
}

// -------------------------------
// 2. Handle GET submission (color)
// -------------------------------
$getColor = htmlspecialchars($_GET['color'] ?? '');

// -------------------------------
// 3. Handle REQUEST (GET + POST + COOKIE)
// -------------------------------
$requestValue = htmlspecialchars($_REQUEST['anything'] ?? '');

// -------------------------------
// 4. Handle Cookie Input
// -------------------------------
if (isset($_POST['cookie_value'])) {
    $cookieInput = htmlspecialchars($_POST['cookie_value']);

    // Set cookie for 10 seconds (short for testing)
    setcookie("my_cookie", $cookieInput, time() + 10);

    // Refresh page to load new cookie value
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Retrieve cookie safely
$cookieValue = $_COOKIE['my_cookie'] ?? "No cookie set yet";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Superglobals Explorer</title>
</head>
<body>

<h1>Super Global Variables Explorer</h1>

<!-- ============================= -->
<!-- (1) $_SERVER OUTPUT -->
<!-- ============================= -->
<h2>1. $_SERVER Information</h2>
<p><strong>Current Script:</strong> <?php echo $_SERVER['PHP_SELF']; ?></p>
<p><strong>Server Name:</strong> <?php echo $_SERVER['SERVER_NAME']; ?></p>
<p><strong>Request Method:</strong> <?php echo $_SERVER['REQUEST_METHOD']; ?></p>

<hr>

<!-- ============================= -->
<!-- INPUT FORMS -->
<!-- ============================= -->
<h2>Submit Data</h2>

<!-- POST -->
<form method="post" action="">
    <label>Enter your name (POST):</label>
    <input type="text" name="post_name">
    <button type="submit">Submit POST</button>
</form>

<br>

<!-- GET -->
<form method="get" action="">
    <label>Favourite color (GET):</label>
    <input type="text" name="color">
    <button type="submit">Submit GET</button>
</form>

<br>

<!-- REQUEST -->
<form method="get" action="">
    <label>Anything (REQUEST):</label>
    <input type="text" name="anything">
    <button type="submit">Submit REQUEST</button>
</form>

<br>

<!-- COOKIE -->
<form method="post" action="">
    <label>Set Cookie Value:</label>
    <input type="text" name="cookie_value">
    <button type="submit">Set Cookie</button>
</form>

<hr>

<!-- ============================= -->
<!-- (2) $_POST OUTPUT -->
<!-- ============================= -->
<h2>2. $_POST Output</h2>
<p><?php echo isset($postedName) ? "POST Name: $postedName" : "No POST data submitted."; ?></p>

<!-- ============================= -->
<!-- (3) $_GET OUTPUT -->
<!-- ============================= -->
<h2>3. $_GET Output</h2>
<p><?php echo $getColor ? "GET Color: $getColor" : "No GET data submitted."; ?></p>

<!-- ============================= -->
<!-- (4) $_REQUEST OUTPUT -->
<!-- ============================= -->
<h2>4. $_REQUEST Output</h2>
<p><?php echo $requestValue ? "REQUEST Value: $requestValue" : "No REQUEST data submitted."; ?></p>

<hr>

<!-- ============================= -->
<!-- (5) $_SESSION OUTPUT -->
<!-- ============================= -->
<h2>5. $_SESSION Output</h2>
<p>
    <?php
    if (isset($_SESSION['username'])) {
        echo "Stored Session Username: " . $_SESSION['username'];
    } else {
        echo "No session data stored yet.";
    }
    ?>
</p>

<hr>

<!-- ============================= -->
<!-- (6) $_COOKIE OUTPUT -->
<!-- ============================= -->
<h2>6. $_COOKIE Output</h2>
<p>Cookie Value: <?php echo htmlspecialchars($cookieValue); ?></p>

</body>
</html>
