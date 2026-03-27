<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Simple PHP Password Checker</title>
</head>
<body>

<?php
/*
    Activity 3: Simple PHP Password Checker
    ---------------------------------------
    This script demonstrates:
    - Declaring variables
    - Using built‑in PHP string functions
    - Outputting results as HTML
    - Commenting (single‑line, multi‑line, commented‑out code)
*/

// ---------------------------------------------
// 1. Declare the password variable
// ---------------------------------------------
$password = "Str0ngP@ssw0rd";

// ---------------------------------------------
// 2. Apply PHP string functions
// ---------------------------------------------

// Count the number of characters in the password
$passwordLength = strlen($password);

// Count the number of words in the password
$wordCount = str_word_count($password);

// Reverse the password string
$reversedPassword = strrev($password);

// Find the position of the character "0"
$charPosition = strpos($password, "0");

// Replace all "0" characters with "*"
$replacedPassword = str_replace("0", "*", $password);

/*
    The variables above demonstrate how PHP can:
    - Measure string length
    - Count words
    - Reverse strings
    - Search for characters
    - Replace characters
*/

// ---------------------------------------------
// 3. Output results to the browser
// ---------------------------------------------
echo "<h2>Password Checker Results</h2>";
echo "Original password: $password <br>";
echo "Password length: $passwordLength <br>";
echo "Word count: $wordCount <br>";
echo "Reversed password: $reversedPassword <br>";
echo "Position of '0': $charPosition <br>";
echo "Password with replacements: $replacedPassword <br>";

// ---------------------------------------------
// 4. Commented‑out code example
// ---------------------------------------------
// echo "<p>This line is commented out and will not run.</p>";
// If uncommented, the line above would display an extra paragraph.

?>

</body>
</html>
