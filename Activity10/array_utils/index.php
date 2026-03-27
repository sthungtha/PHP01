<?php
/*
|--------------------------------------------------------------------------
| Activity 10.3: Array Function Exploration
|--------------------------------------------------------------------------
| This file contains utility functions that demonstrate:
| - array_intersect()
| - array_unique()
| - array_filter()
| - usort()
| - implode()
| Each function includes comments explaining how it works.
*/


/*
|--------------------------------------------------------------------------
| Helper: Pretty Browser Output (print_r version)
|--------------------------------------------------------------------------
*/
function showArray($label, $array) {
    echo "<h3>$label</h3>";
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}


/*
|--------------------------------------------------------------------------
| 1. findCommonElements()
|--------------------------------------------------------------------------
| Returns an array of values that appear in BOTH arrays.
| Uses: array_intersect()
*/
function findCommonElements($array1, $array2)
{
    return array_intersect($array1, $array2);
}


/*
|--------------------------------------------------------------------------
| 2. removeDuplicates()
|--------------------------------------------------------------------------
| Removes duplicate values from an array.
| Uses: array_unique()
*/
function removeDuplicates($array)
{
    return array_unique($array);
}


/*
|--------------------------------------------------------------------------
| 3. filterByType()
|--------------------------------------------------------------------------
| Filters an array to return only elements of a specific type.
| Uses: array_filter()
*/
function filterByType($array, $type)
{
    return array_filter($array, function($item) use ($type) {
        return gettype($item) === $type;
    });
}


/*
|--------------------------------------------------------------------------
| 4. customSort()
|--------------------------------------------------------------------------
| Sorts an array in ascending or descending order.
| Uses: usort()
*/
function customSort($array, $order)
{
    usort($array, function($a, $b) use ($order) {
        if ($order === 'asc') {
            return $a <=> $b;   // ascending
        } else {
            return $b <=> $a;   // descending
        }
    });

    return $array;
}


/*
|--------------------------------------------------------------------------
| 5. arrayToString()
|--------------------------------------------------------------------------
| Converts an array into a string separated by a custom separator.
| Uses: implode()
*/
function arrayToString($array, $separator)
{
    return implode($separator, $array);
}


/*
|--------------------------------------------------------------------------
| 6. TESTING THE FUNCTIONS
|--------------------------------------------------------------------------
| Uses the SAME example arrays for all tests.
|--------------------------------------------------------------------------
*/

echo "<h2>Array Function Tests</h2>";

$arrayA = [1, 2, 3, 4, 5, 5, "hello", "world"];
$arrayB = [3, 4, 5, 6, 7, "hello"];

/* Show original arrays */
showArray("Original Array A", $arrayA);
showArray("Original Array B", $arrayB);

/* Test 1: Common elements */
showArray("Common Elements (A ∩ B)", findCommonElements($arrayA, $arrayB));

/* Test 2: Remove duplicates */
showArray("Remove Duplicates (Array A)", removeDuplicates($arrayA));

/* Test 3: Filter by type */
showArray("Filter Only Strings (Array A)", filterByType($arrayA, "string"));

/* Test 4: Custom sort using SAME array */
showArray("Custom Sort (Ascending)", customSort($arrayA, "asc"));
showArray("Custom Sort (Descending)", customSort($arrayA, "desc"));

/* Test 5: Array to string */
echo "<h3>Array to String (Array A)</h3>";
echo "<pre>";
echo arrayToString($arrayA, ", ");
echo "</pre>";

?>
