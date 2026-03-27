<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Activity 4: Numerical Operations Calculator</title>
</head>
<body>

<h2>Activity 4: Numerical Operations Calculator with PHP</h2>

<?php
// -------------------------------------------------------------
// A PHP script to perform arithmetic operations, type conversions,
// and handle large and infinite numbers based on user input.
// -------------------------------------------------------------

// STEP 1: Default example values (as strings so they stay in the textboxes)
$default_num1 = "3.4";
$default_num2 = "2";
$default_large = "1e308";
$default_infinite = "1e309";

// STEP 2: If form submitted, use user inputs; otherwise use defaults
if (isset($_POST['submit'])) {

    // Raw inputs (preserved for textboxes)
    $num1_input = $_POST['num1'];
    $num2_input = $_POST['num2'];
    $large_input = $_POST['large_number'];
    $infinite_input = $_POST['infinite_number'];

    // Converted numeric values
    $num1 = (float)$num1_input;
    $num2 = (float)$num2_input;
    $large_number = (float)$large_input;
    $infinite_number = (float)$infinite_input;

} else {

    // First load → use defaults
    $num1_input = $default_num1;
    $num2_input = $default_num2;
    $large_input = $default_large;
    $infinite_input = $default_infinite;

    // Convert defaults
    $num1 = (float)$default_num1;
    $num2 = (float)$default_num2;
    $large_number = (float)$default_large;
    $infinite_number = (float)$default_infinite;
}

// STEP 3: If form submitted, process calculations
if (isset($_POST['submit'])) {

    // Validate input
    if (!is_numeric($num1_input) || !is_numeric($num2_input) ||
        !is_numeric($large_input) || !is_numeric($infinite_input)) {

        echo "<p style='color:red;'>Error: Please enter valid numeric values.</p>";

    } else {

        echo "<h3>Arithmetic Results</h3>";

        // Arithmetic operations
        $add = $num1 + $num2;
        $sub = $num1 - $num2;
        $mul = $num1 * $num2;
        $div = ($num2 != 0) ? $num1 / $num2 : "Cannot divide by zero";
        $mod = ($num2 != 0) ? $num1 % $num2 : "Cannot compute modulus with zero";

        echo "Addition: $add <br>";
        echo "Subtraction: $sub <br>";
        echo "Multiplication: $mul <br>";
        echo "Division: $div <br>";
        echo "Modulus: $mod <br><br>";

        // Type conversions
        echo "<h3>Type Conversions</h3>";

        $int1 = (int)$num1;
        $float1 = (float)$num1;

        echo "Integer value of num1: $int1 (is_int? " . (is_int($int1) ? "Yes" : "No") . ")<br>";
        echo "Float value of num1: $float1 (is_float? " . (is_float($float1) ? "Yes" : "No") . ")<br><br>";

        // Large & infinite numbers
// Large & infinite numbers
echo "<h3>Large & Infinite Numbers</h3>";

echo "Large number (raw): $large_input<br>";
echo "Large number (processed): $large_number (is_finite? " . (is_finite($large_number) ? "Yes" : "No") . ")<br>";
echo "Large number (processed): $large_number (is_infinite? " . (is_infinite($large_number) ? "Yes" : "No") . ")<br><br>";

echo "Infinite number (raw): $infinite_input<br>";
echo "Infinite number (processed): $infinite_number (is_infinite? " . (is_infinite($infinite_number) ? "Yes" : "No") . ")<br>";
echo "Infinite number (processed): $infinite_number (is_finite? " . (is_finite($infinite_number) ? "Yes" : "No") . ")<br><br>";
        echo "<br>";
    }
}
?>

<!-- STEP 4: HTML Form with 4 input boxes -->
<form method="post">

    <label>Enter first number:</label><br>
    <input type="text" name="num1" value="<?php echo $num1_input; ?>" required><br><br>

    <label>Enter second number:</label><br>
    <input type="text" name="num2" value="<?php echo $num2_input; ?>" required><br><br>

    <label>Enter a large number:</label><br>
    <input type="text" name="large_number" value="<?php echo $large_input; ?>" required><br><br>

    <label>Enter an infinite number (e.g., 1e309):</label><br>
    <input type="text" name="infinite_number" value="<?php echo $infinite_input; ?>" required><br><br>

    <input type="submit" name="submit" value="Calculate">
</form>

</body>
</html>
