<?php
/*
    Activity 1: Showcase the Basics of PHP
    -------------------------------------
    This script demonstrates the fundamentals of PHP syntax:
    - PHP tags
    - Variables (string and number)
    - echo output
    - Single-line and multi-line comments
    - Commenting out code to observe behavior
*/

// ---------------------------------------------
// 1. Variable Declarations
// ---------------------------------------------

// A string variable storing a user's name
$userName = "John";

// A number variable storing a user's age
$userAge = 32;

// ---------------------------------------------
// 2. Output Using echo
// ---------------------------------------------

// Output a greeting message using variables
echo "Hello $userName, your age is $userAge!<br>";

/*
    The echo statement above prints text to the browser.
    PHP automatically replaces $userName and $userAge
    with their assigned values.
*/

// ---------------------------------------------
// 3. Commenting Out Code
// ---------------------------------------------

// The line below is intentionally commented out.
// If uncommented, it would display an additional message.

// echo "This line is currently commented out and will not run.<br>";

/*
    When code is commented out, PHP ignores it completely.
    This is useful for testing, debugging, or temporarily
    disabling parts of your script.
*/
?>
