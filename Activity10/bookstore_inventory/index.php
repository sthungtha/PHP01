<?php
/*
|--------------------------------------------------------------------------
| Activity 10.1: Bookstore Inventory Management
|--------------------------------------------------------------------------
| This script demonstrates:
| - Creating associative arrays
| - Manipulating arrays with functions
| - Sorting arrays by different properties
| - Using print_r() to inspect results
*/

/*
|--------------------------------------------------------------------------
| 1. INITIAL INVENTORY ARRAY
|--------------------------------------------------------------------------
| Each book is represented as an associative array.
| The inventory is an array of books.
*/

$inventory = [
    [
        "title" => "The Great Gatsby",
        "author" => "F. Scott Fitzgerald",
        "price" => 10.99,
        "quantity" => 5
    ],
    [
        "title" => "1984",
        "author" => "George Orwell",
        "price" => 8.50,
        "quantity" => 12
    ],
    [
        "title" => "To Kill a Mockingbird",
        "author" => "Harper Lee",
        "price" => 7.99,
        "quantity" => 3
    ],
    [
        "title" => "Dune",
        "author" => "Frank Herbert",
        "price" => 12.75,
        "quantity" => 7
    ],
    [
        "title" => "The Hobbit",
        "author" => "J.R.R. Tolkien",
        "price" => 9.25,
        "quantity" => 10
    ]
];

/*
|--------------------------------------------------------------------------
| 2. FUNCTION: Add a Book
|--------------------------------------------------------------------------
| Adds a new book to the inventory.
*/

function addBook($inventory, $title, $author, $price, $quantity)
{
    $inventory[] = [
        "title" => $title,
        "author" => $author,
        "price" => $price,
        "quantity" => $quantity
    ];

    return $inventory;
}

/*
|--------------------------------------------------------------------------
| 3. FUNCTION: Remove a Book by Title
|--------------------------------------------------------------------------
*/

function removeBook($inventory, $title)
{
    foreach ($inventory as $index => $book) {
        if (strtolower($book["title"]) === strtolower($title)) {
            unset($inventory[$index]);
            break;
        }
    }

    // Reindex array after removal
    return array_values($inventory);
}

/*
|--------------------------------------------------------------------------
| 4. FUNCTION: Update Quantity
|--------------------------------------------------------------------------
*/

function updateQuantity($inventory, $title, $newQuantity)
{
    foreach ($inventory as &$book) {
        if (strtolower($book["title"]) === strtolower($title)) {
            $book["quantity"] = $newQuantity;
            break;
        }
    }

    return $inventory;
}

/*
|--------------------------------------------------------------------------
| 5. FUNCTION: Sort Inventory by Property
|--------------------------------------------------------------------------
| $sortBy can be: title, author, price, quantity
*/

function sortInventory($inventory, $sortBy)
{
    usort($inventory, function ($a, $b) use ($sortBy) {
        if (is_numeric($a[$sortBy])) {
            return $a[$sortBy] <=> $b[$sortBy];
        }
        return strcasecmp($a[$sortBy], $b[$sortBy]);
    });

    return $inventory;
}


/*
|--------------------------------------------------------------------------
| 6. TESTING THE FUNCTIONS
|--------------------------------------------------------------------------
*/
function displayInventory($inventory, $title = "Inventory") {
    echo "====================\n";
    echo "$title\n";
    echo "====================\n";

    foreach ($inventory as $book) {
        echo "Title:    {$book['title']}\n";
        echo "Author:   {$book['author']}\n";
        echo "Price:    £{$book['price']}\n";
        echo "Quantity: {$book['quantity']}\n";
        echo "--------------------\n";
    }

    echo "\n";
}

echo "<pre>";

displayInventory($inventory, "Initial Inventory");

$inventory = addBook($inventory, "Brave New World", "Aldous Huxley", 11.40, 6);
displayInventory($inventory, "After Adding a Book");

$inventory = removeBook($inventory, "1984");
displayInventory($inventory, "After Removing '1984'");

$inventory = updateQuantity($inventory, "Dune", 20);
displayInventory($inventory, "After Updating Quantity of 'Dune'");

$inventory = sortInventory($inventory, "title");
displayInventory($inventory, "After Sorting by Title");

$inventory = sortInventory($inventory, "price");
displayInventory($inventory, "After Sorting by Price");

echo "</pre>";

?>
