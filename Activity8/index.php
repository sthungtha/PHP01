<?php
/*
===========================================================
 Activity 8: PHP Loops - Inventory Management System
 FULL EXTENDED VERSION (GitHub-Style Second Pass)
===========================================================
*/

// ---------------------------------------------------------
// 1. INVENTORY DATA
// ---------------------------------------------------------

$inventory = [
    "Apple"  => ["quantity" => 150, "price" => 0.50, "sold" => 120],
    "Banana" => ["quantity" => 200, "price" => 0.30, "sold" => 90],
    "Orange" => ["quantity" => 100, "price" => 0.60, "sold" => 60],
    "Mango"  => ["quantity" => 75,  "price" => 1.20, "sold" => 40],
    "Grape"  => ["quantity" => 80,  "price" => 2.00, "sold" => 70],
];


// ---------------------------------------------------------
// 2. DISPLAY INVENTORY (FOREACH)
// ---------------------------------------------------------

function displayInventory($inventory, $title = "Current Inventory") {
    echo "<h2>$title</h2>";
    echo "------------------------------------------------------<br>";
    echo "Item&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Quantity&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Price&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total Value<br>";
    echo "------------------------------------------------------<br>";

    $totalValue = 0;

    foreach ($inventory as $item => $data) {
        $qty   = $data["quantity"];
        $price = $data["price"];
        $value = $qty * $price;
        $totalValue += $value;

        echo str_pad($item, 12) .
             str_pad($qty, 15) .
             "$" . number_format($price, 2) . str_repeat("&nbsp;", 9) .
             "$" . number_format($value, 2) . "<br>";
    }

    echo "------------------------------------------------------<br>";
    echo "Total Inventory Value: $" . number_format($totalValue, 2) . "<br><br>";
}


// ---------------------------------------------------------
// 3. UPDATE ITEM QUANTITY (FOREACH + BREAK)
// ---------------------------------------------------------

function updateItemQuantity(&$inventory, $itemName, $newQty) {
    if ($newQty < 0) {
        echo "Invalid quantity for $itemName.<br>";
        return;
    }

    $found = false;

    foreach ($inventory as $item => &$data) {
        if ($item === $itemName) {
            $data["quantity"] = $newQty;
            echo "Updated $itemName quantity. New quantity: $newQty<br>";
            $found = true;
            break;
        }
    }

    if (!$found) {
        echo "Item not found in inventory.<br>";
    }
}


// ---------------------------------------------------------
// 4. LOW STOCK ALERT (WHILE LOOP)
// ---------------------------------------------------------

function lowStockAlert($inventory, $threshold) {
    echo "<h3>Checking low stock items...</h3>";
    echo "Items with stock below $threshold:<br>";

    $keys = array_keys($inventory);
    $i = 0;
    $found = false;

    while ($i < count($keys)) {
        $item = $keys[$i];
        $qty  = $inventory[$item]["quantity"];

        if ($qty < $threshold) {
            echo "$item: $qty<br>";
            $found = true;
        }

        $i++;
    }

    if (!$found) {
        echo "No items below threshold.<br>";
    }

    echo "<br>";
}


// ---------------------------------------------------------
// 5. APPLY DISCOUNT (FOR LOOP + CONTINUE)
// ---------------------------------------------------------

function applyDiscount(&$inventory, $percent) {
    echo "<h3>Applying {$percent}% discount to all items:</h3>";

    $keys = array_keys($inventory);

    for ($i = 0; $i < count($keys); $i++) {
        $item = $keys[$i];
        $old  = $inventory[$item]["price"];

        if ($old < 0.10) {
            continue; // skip extremely low prices
        }

        $new = $old * (1 - $percent / 100);
        $inventory[$item]["price"] = $new;

        echo "$item: $" . number_format($old, 2) . " -> $" . number_format($new, 2) . "<br>";
    }

    echo "<br>";
}


// ---------------------------------------------------------
// 6. SAVE / LOAD INVENTORY (OPTIONAL FEATURE)
// ---------------------------------------------------------

function saveInventoryToFile($inventory, $file = "inventory.json") {
    file_put_contents($file, json_encode($inventory, JSON_PRETTY_PRINT));
    echo "Inventory saved to $file<br><br>";
}

function loadInventoryFromFile($file = "inventory.json") {
    if (!file_exists($file)) {
        return null;
    }

    $data = json_decode(file_get_contents($file), true);
    return is_array($data) ? $data : null;
}


// ---------------------------------------------------------
// 7. BEST-SELLING REPORT (DO-WHILE LOOP)
// ---------------------------------------------------------

function bestSellers($inventory, $minSold = 50) {
    echo "<h3>Best-Selling Items (sold >= $minSold):</h3>";

    $keys = array_keys($inventory);
    $i = 0;
    $found = false;

    if (count($keys) === 0) {
        echo "No items in inventory.<br>";
        return;
    }

    do {
        $item = $keys[$i];
        $sold = $inventory[$item]["sold"];

        if ($sold >= $minSold) {
            echo "$item: $sold sold<br>";
            $found = true;
        }

        $i++;
    } while ($i < count($keys));

    if (!$found) {
        echo "No best-selling items.<br>";
    }

    echo "<br>";
}

// ---------------------------------------------------------
//  SIMPLE COMMAND-LINE INTERFACE (OPTIONAL FEATURE)
// ---------------------------------------------------------

if (php_sapi_name() === "cli") {

    echo "\nInventory Management CLI\n";
    echo "--------------------------------------\n";

    while (true) {
        echo "\nChoose an option:\n";
        echo "1. View Inventory\n";
        echo "2. Update Item Quantity\n";
        echo "3. Check Low Stock\n";
        echo "4. Apply Discount\n";
        echo "5. View Best Sellers\n";
        echo "6. Save Inventory\n";
        echo "7. Exit\n";

        $choice = readline("Enter choice (1-7): ");

        switch ($choice) {

            case "1":
                displayInventory($inventory, "Inventory View");
                break;

            case "2":
                $item = readline("Enter item name: ");
                $qty  = readline("Enter new quantity: ");
                updateItemQuantity($inventory, $item, (int)$qty);
                break;

            case "3":
                $threshold = readline("Enter low-stock threshold: ");
                lowStockAlert($inventory, (int)$threshold);
                break;

            case "4":
                $percent = readline("Enter discount percentage: ");
                applyDiscount($inventory, (float)$percent);
                break;

            case "5":
                bestSellers($inventory, 50);
                break;

            case "6":
                saveInventoryToFile($inventory);
                break;

            case "7":
                echo "Exiting system...\n";
                exit;

            default:
                echo "Invalid choice. Try again.\n";
        }
    }
}

// ---------------------------------------------------------
// 8. MAIN PROGRAM FLOW
// ---------------------------------------------------------

echo "<h1>Welcome to the Inventory Management System</h1>";

// Load saved inventory if available
$loaded = loadInventoryFromFile();
if ($loaded) {
    $inventory = $loaded;
}

// Display initial inventory
displayInventory($inventory, "Current Inventory");

// Sample updates (FOR loop)
echo "<h3>Updating inventory...</h3>";

$updates = [
    ["item" => "Apple",  "qty" => 200],
    ["item" => "Banana", "qty" => 170],
    ["item" => "Pear",   "qty" => 50], // not found
];

for ($i = 0; $i < count($updates); $i++) {
    updateItemQuantity($inventory, $updates[$i]["item"], $updates[$i]["qty"]);
}

echo "<br>";

// Low stock alert
lowStockAlert($inventory, 100);

// Apply discount
applyDiscount($inventory, 10);

// Best-selling report
bestSellers($inventory, 50);

// Display final inventory
displayInventory($inventory, "Final Inventory");

// Save updated inventory
saveInventoryToFile($inventory);

?>
