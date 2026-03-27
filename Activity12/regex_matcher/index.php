<?php
// ------------------------------------------------------------
// Activity 12.1: Regular Expression Matcher
// Fully annotated version for learning + demonstration
// ------------------------------------------------------------

// STEP 1: Initialise variables for output
$matches = [];
$error = "";
$count = 0;

// STEP 2: Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Retrieve user inputs safely
    $text      = $_POST["text"] ?? "";
    $pattern   = $_POST["pattern"] ?? "";
    $modifier  = $_POST["modifier"] ?? "";

    // Build final regex pattern
    // Example: /hello/i
    $finalPattern = "/" . $pattern . "/" . $modifier;

    // STEP 3: Try running preg_match_all with error handling
    try {
        $result = @preg_match_all($finalPattern, $text, $matches, PREG_OFFSET_CAPTURE);

        if ($result === false) {
            // Invalid regex pattern
            $error = "Your regular expression is invalid. Please check your pattern.";
        } else {
            $count = $result; // Number of matches
        }

    } catch (Throwable $e) {
        $error = "Regex processing error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Regular Expression Matcher</title>
    <style>
        body { font-family: Arial; margin: 40px; }
        textarea { width: 100%; height: 120px; }
        input[type=text] { width: 100%; }
        .result-box { background: #f4f4f4; padding: 15px; margin-top: 20px; }
        .error { color: red; font-weight: bold; }
        .match { color: green; }
    </style>
</head>
<body>

<h2>Regular Expression Matcher</h2>

<!-- STEP 4: HTML Form -->
<form method="post">

    <!-- SAMPLE TEXT -->
    <label><strong>Sample Text:</strong></label><br>
    <textarea name="text"><?= htmlspecialchars($text ?? "Hello world! 123 banana banana.") ?></textarea><br><br>

    <!-- COMMON PATTERNS DROPDOWN -->
    <label><strong>Common Patterns:</strong></label><br>
    <select id="commonPatterns" onchange="insertPattern()">
        <option value="">-- Select a pattern --</option>
        <option value="\d">\\d — digit (0–9)</option>
        <option value="\w">\\w — word character</option>
        <option value="\s">\\s — whitespace</option>
        <option value=".">. — any character</option>
        <option value="^">^ — start of string</option>
        <option value="$">$ — end of string</option>
        <option value="[A-Za-z]+">[A-Za-z]+ — letters only</option>
        <option value="\bword\b">\\bword\\b — whole word</option>
        <option value="(abc)">(abc) — grouping</option>
        <option value="(abc){2}">(abc){2} — repeated group</option>
    </select>
    <br><br>

    <!-- REGEX INPUT -->
    <label><strong>Regular Expression (without slashes):</strong></label><br>
    <input type="text" name="pattern" 
           value="<?= htmlspecialchars($pattern ?? "ba(na){2}") ?>"><br><br>

    <!-- MODIFIER DROPDOWN -->
    <label><strong>Modifier:</strong></label><br>
    <select name="modifier">
        <option value="">None</option>
        <option value="i" <?= ($modifier ?? "i") === "i" ? "selected" : "" ?>>i (case-insensitive)</option>
        <option value="m" <?= ($modifier ?? "") === "m" ? "selected" : "" ?>>m (multi-line)</option>
        <option value="s" <?= ($modifier ?? "") === "s" ? "selected" : "" ?>>s (dot matches newline)</option>
        <option value="u" <?= ($modifier ?? "") === "u" ? "selected" : "" ?>>u (UTF-8)</option>
    </select><br><br>

    <button type="submit">Test Regex</button>
</form>

<!-- STEP 5: Display Results -->
<?php if (!empty($error)): ?>
    <p class="error"><?= $error ?></p>
<?php elseif ($_SERVER["REQUEST_METHOD"] === "POST"): ?>
    <div class="result-box">
        <h3>Results</h3>

        <p><strong>Matches Found:</strong> <?= $count ?></p>

        <?php if ($count > 0): ?>
            <h4>Match Details:</h4>
            <ul>
                <?php foreach ($matches[0] as $m): ?>
                    <li>
                        <span class="match"><?= htmlspecialchars($m[0]) ?></span>
                        (position: <?= $m[1] ?>)
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
<?php endif; ?>

<!-- STEP 6: Regex Help Section -->
<div class="result-box">
    <h3>Regex Help</h3>
    <p><strong>Common Patterns:</strong></p>
    <ul>
        <li><code>\d</code> — digit (0–9)</li>
        <li><code>\w</code> — word character (letters, digits, underscore)</li>
        <li><code>\s</code> — whitespace</li>
        <li><code>.</code> — any character except newline</li>
    </ul>

    <p><strong>Common Modifiers:</strong></p>
    <ul>
        <li><code>i</code> — case-insensitive</li>
        <li><code>m</code> — multi-line mode</li>
        <li><code>s</code> — dot matches newline</li>
        <li><code>u</code> — UTF-8 mode</li>
    </ul>
</div>

<!-- STEP 7: JavaScript for inserting patterns -->
<script>
function insertPattern() {
    const dropdown = document.getElementById("commonPatterns");
    const patternInput = document.querySelector("input[name='pattern']");
    const value = dropdown.value;

    if (value !== "") {
        patternInput.value = value;
    }
}
</script>

</body>
</html>
