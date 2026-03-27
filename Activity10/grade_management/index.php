<?php
/*
|--------------------------------------------------------------------------
| Activity 10.2: Multidimensional Array Challenge
|--------------------------------------------------------------------------
| Grade Management System using multidimensional arrays.
| Includes:
| - Student averages (2 decimals)
| - Top student per subject
| - Class averages (2 decimals)
| - Sorting by overall average (2 decimals)
*/

/*
|--------------------------------------------------------------------------
| 1. MULTIDIMENSIONAL ARRAY OF STUDENTS + GRADES
|--------------------------------------------------------------------------
*/

$studentGrades = [
    "Alice" => ["Math" => 85, "English" => 78, "Science" => 92],
    "Ben"   => ["Math" => 90, "English" => 88, "Science" => 75],
    "Chloe" => ["Math" => 70, "English" => 95, "Science" => 80],
    "David" => ["Math" => 88, "English" => 76, "Science" => 85],
    "Ella"  => ["Math" => 92, "English" => 89, "Science" => 94]
];

/*
|--------------------------------------------------------------------------
| 2. FUNCTION: Calculate a student's average (2 decimals)
|--------------------------------------------------------------------------
*/

function calculateAverage($studentGrades, $student)
{
    if (!isset($studentGrades[$student])) {
        return null;
    }

    $grades = $studentGrades[$student];
    $avg = array_sum($grades) / count($grades);

    return number_format($avg, 2);
}

/*
|--------------------------------------------------------------------------
| 3. FUNCTION: Find top student in a subject
|--------------------------------------------------------------------------
*/

function findTopStudent($studentGrades, $subject)
{
    $topStudent = null;
    $topGrade = -1;

    foreach ($studentGrades as $student => $grades) {
        if ($grades[$subject] > $topGrade) {
            $topGrade = $grades[$subject];
            $topStudent = $student;
        }
    }

    return $topStudent;
}

/*
|--------------------------------------------------------------------------
| 4. FUNCTION: Class average for a subject (2 decimals)
|--------------------------------------------------------------------------
*/

function classAverage($studentGrades, $subject)
{
    $total = 0;
    $count = 0;

    foreach ($studentGrades as $grades) {
        $total += $grades[$subject];
        $count++;
    }

    return number_format($total / $count, 2);
}

/*
|--------------------------------------------------------------------------
| 5. FUNCTION: Sort students by overall average (2 decimals)
|--------------------------------------------------------------------------
*/

function sortStudentsByOverallAverage($studentGrades)
{
    $averages = [];

    foreach ($studentGrades as $student => $grades) {
        $avg = array_sum($grades) / count($grades);
        $averages[$student] = number_format($avg, 2);
    }

    arsort($averages); // highest → lowest

    return $averages;
}

/*
|--------------------------------------------------------------------------
| 6. TESTING THE FUNCTIONS (Browser-friendly)
|--------------------------------------------------------------------------
*/

echo "<pre>";

echo "Student Averages:\n";
foreach ($studentGrades as $student => $grades) {
    echo "$student: " . calculateAverage($studentGrades, $student) . "\n";
}

echo "\nTop Student in Math: " . findTopStudent($studentGrades, "Math") . "\n";
echo "Top Student in English: " . findTopStudent($studentGrades, "English") . "\n";
echo "Top Student in Science: " . findTopStudent($studentGrades, "Science") . "\n";

echo "\nClass Average (Math): " . classAverage($studentGrades, "Math") . "\n";
echo "Class Average (English): " . classAverage($studentGrades, "English") . "\n";
echo "Class Average (Science): " . classAverage($studentGrades, "Science") . "\n";

echo "\nStudents Sorted by Overall Average:\n";
print_r(sortStudentsByOverallAverage($studentGrades));

echo "</pre>";
?>
