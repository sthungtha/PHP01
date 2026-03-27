<?php
/******************************************************
 * STUDENT INFORMATION CARD PROJECT
 * PHP Essentials – Activity: Student Information Card
 * Demonstrates:
 * - Global variables
 * - Functions
 * - Loops
 * - Variable scope
 * - Static keyword
 ******************************************************/

// ----------------------------------------------------
// 1. GLOBAL VARIABLES
// ----------------------------------------------------
$studentNames = ["Alice", "Bob", "Charlie", "Diana"];
$studentAges  = [20, 22, 19, 21];
$studentGrades = ["A", "B+", "A-", "B"];

// ----------------------------------------------------
// 2. FUNCTION: Calculate Average Age
// ----------------------------------------------------
function calculateAverageAge($ages) {
    $total = 0;

    // Loop through ages and sum them
    foreach ($ages as $age) {
        $total += $age;
    }

    // Calculate average
    $average = $total / count($ages);

    return $average;
}

// ----------------------------------------------------
// 3. FUNCTION: Display Student Information
// ----------------------------------------------------
function displayStudentInformation($names, $ages, $grades) {

    // Local variable (scope demonstration)
    $localVariable = "I exist only inside this function.";

    echo "<h2>Student Information</h2>";

    // Loop through arrays and display formatted output
    for ($i = 0; $i < count($names); $i++) {
        echo "Name: {$names[$i]}, Age: {$ages[$i]}, Grade: {$grades[$i]}<br>";
    }

    // Return local variable for demonstration
    return $localVariable;
}

// ----------------------------------------------------
// 4. FUNCTION: Demonstrate static keyword
// ----------------------------------------------------
function incrementCounter() {
    static $counter = 0; // static variable retains value between calls
    $counter++;
    return $counter;
}

// ----------------------------------------------------
// 5. CALL FUNCTIONS AND OUTPUT RESULTS
// ----------------------------------------------------
$averageAge = calculateAverageAge($studentAges);
$scopeDemo = displayStudentInformation($studentNames, $studentAges, $studentGrades);

// ----------------------------------------------------
// 6. OUTPUT RESULTS
// ----------------------------------------------------
echo "<h2>Average Age</h2>";
echo "The average age of the students is: $averageAge<br><br>";

// Demonstrate variable scope
echo "<h2>Variable Scope Demonstration</h2>";
echo "Inside function: $scopeDemo<br>";

// Attempt to access local variable outside function (will cause notice if uncommented)
echo $localVariable; // This will NOT work — variable is out of scope

echo "Outside function: Cannot access \$localVariable here.<br><br>";

// Demonstrate static keyword
echo "<h2>Static Keyword Demonstration</h2>";
echo "Counter Call 1: " . incrementCounter() . "<br>";
echo "Counter Call 2: " . incrementCounter() . "<br>";
echo "Counter Call 3: " . incrementCounter() . "<br>";

?>
