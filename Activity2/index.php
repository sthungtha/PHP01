<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Basic PHP Calculator</title>
</head>
<body>

<?php
/*
    Activity 2: Basic PHP Calculator
    --------------------------------
    This script demonstrates:
    - Writing PHP inside HTML
    - Creating and calling a function
    - Declaring numerical variables
    - Performing arithmetic (addition)
    - Outputting HTML using echo
    - Using single-line and multi-line comments
*/

// ---------------------------------------------
// 1. Define a function that performs addition
// ---------------------------------------------
function addNumbers() {

    // Declare two number variables
    $num1 = 10;
    $num2 = 25;

    // Add the numbers together
    $sum = $num1 + $num2;

    // Output the result as HTML using concatenation
    echo "<h2>The sum of " . $num1 . " and " . $num2 . " is: " . $sum . "</h2>";

    /*
        The echo above prints an <h2> heading containing:
        - The first number
        - The second number
        - Their calculated sum
        This demonstrates PHP arithmetic and HTML output.
    */

    // echo "<p>This line is commented out and will not run.</p>";
    // If uncommented, the line above would display an extra paragraph.
}

// ---------------------------------------------
// 2. Call the function so it executes
// ---------------------------------------------
addNumbers();

?>

</body>
</html>
