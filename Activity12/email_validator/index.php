<?php
// ------------------------------------------------------------
// Activity 12.2: Email Validator
// Fully annotated version with example data
// ------------------------------------------------------------

// STEP 1: Email validation function
function validateEmail($email, $strict = false) {

    // Base regex:
    // Username: letters, digits, dots, underscores, hyphens
    // Domain: letters, digits, hyphens
    // TLD: 2–63 letters
    $pattern = "/^[A-Za-z0-9._-]+@[A-Za-z0-9-]+\.[A-Za-z]{2,63}$/";

    // Strict mode: no consecutive dots in username
    if ($strict) {
        if (strpos($email, '..') !== false) {
            return ["valid" => false, "reason" => "Username contains consecutive dots"];
        }
    }

    // Run regex
    if (!preg_match($pattern, $email)) {
        return ["valid" => false, "reason" => "Does not match required email format"];
    }

    return ["valid" => true];
}

// ------------------------------------------------------------
// STEP 2: Handle form submission
// ------------------------------------------------------------
$results = [];
$strictMode = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $emails = $_POST["emails"] ?? "";
    $strictMode = isset($_POST["strict"]);

    // Split emails by line
    $emailList = array_filter(array_map("trim", explode("\n", $emails)));

    foreach ($emailList as $email) {
        $results[$email] = validateEmail($email, $strictMode);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Email Validator</title>
    <style>
        body { font-family: Arial; margin: 40px; }
        textarea { width: 100%; height: 150px; }
        .valid { color: green; font-weight: bold; }
        .invalid { color: red; font-weight: bold; }
        .box { background: #f4f4f4; padding: 15px; margin-top: 20px; }
    </style>
</head>
<body>

<h2>Email Validator</h2>

<!-- STEP 3: Form with example data -->
<form method="post">
    <label><strong>Enter email addresses (one per line):</strong></label><br>

    <textarea name="emails"><?= htmlspecialchars($emails ?? 
"john.doe@example.com
invalid-email
user..dots@example.com
hello@domain
sarah-smith@company.co.uk") ?></textarea>
    <br><br>

    <label>
        <input type="checkbox" name="strict" <?= $strictMode ? "checked" : "" ?>>
        Enable strict mode (no consecutive dots)
    </label>
    <br><br>

    <button type="submit">Validate Emails</button>
</form>

<!-- STEP 4: Display results -->
<?php if (!empty($results)): ?>
<div class="box">
    <h3>Validation Results</h3>
    <ul>
        <?php foreach ($results as $email => $info): ?>
            <?php if ($info["valid"]): ?>
                <li class="valid"><?= htmlspecialchars($email) ?> — VALID</li>
            <?php else: ?>
                <li class="invalid">
                    <?= htmlspecialchars($email) ?> — INVALID (<?= $info["reason"] ?>)
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

</body>
</html>
