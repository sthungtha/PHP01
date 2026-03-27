<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shopping Cart Calculator</title>
</head>
<body>

<h2>Activity 5: Extended Shopping Cart Calculator</h2>

<?php
// -------------------------------------------------------------
// EXTENDED SHOPPING CART CALCULATOR
// Includes:
// - More products
// - Tax calculation function
// - Loop for multiple customers
// -------------------------------------------------------------

// Function: Calculate total price for a product
function calculateProductTotal($price, $quantity) {
    return $price * $quantity;
}

// Function: Apply discount
function applyDiscount($total, $threshold, $rate) {
    if ($total > $threshold) {
        return $total * (1 - $rate);
    }
    return $total;
}

// Function: Calculate tax
function calculateTax($amount, $taxRate) {
    return $amount * $taxRate;
}

// Product list (extended)
$products = [
    "Apple"   => 0.50,
    "Banana"  => 0.30,
    "Orange"  => 0.60,
    "Grapes"  => 1.20,
    "Mango"   => 1.50
];

// Discount settings
$discountThreshold = 20;
$discountRate = 0.10; // 10%

// Tax settings
$taxRate = 0.05; // 5%

// Loop for multiple customers
for ($customer = 1; $customer <= 2; $customer++) {

    echo "<h3>Customer $customer</h3>";

    // Example quantities (you can replace with form input later)
    $quantities = [
        "Apple"  => rand(1, 5),
        "Banana" => rand(1, 5),
        "Orange" => rand(1, 5),
        "Grapes" => rand(1, 5),
        "Mango"  => rand(1, 5)
    ];

    $cartTotals = [];

    // Calculate totals for each product
    foreach ($products as $name => $price) {
        $qty = $quantities[$name];
        $cartTotals[$name] = calculateProductTotal($price, $qty);
    }

    // Subtotal
    $subtotal = array_sum($cartTotals);

    // Discount
    $discountAmount = $subtotal - applyDiscount($subtotal, $discountThreshold, $discountRate);
    $afterDiscount = applyDiscount($subtotal, $discountThreshold, $discountRate);

    // Tax
    $taxAmount = calculateTax($afterDiscount, $taxRate);

    // Final total
    $finalTotal = $afterDiscount + $taxAmount;

    // Math functions
    $highest_price = max($products);
    $lowest_price  = min($products);
    $order_number  = rand(10000, 99999);

    // Display results
    echo "Order Number: $order_number<br><br>";

    echo "<strong>Itemized Bill:</strong><br>";
    foreach ($cartTotals as $name => $total) {
        echo "$name: $" . number_format($total, 2) . 
             " (" . $quantities[$name] . " @ $" . number_format($products[$name], 2) . " each)<br>";
    }

    echo "<br>Subtotal: $" . number_format($subtotal, 2) . "<br>";
    echo "Discount: $" . number_format($discountAmount, 2) . "<br>";
    echo "After Discount: $" . number_format($afterDiscount, 2) . "<br>";
    echo "Tax (5%): $" . number_format($taxAmount, 2) . "<br>";
    echo "<strong>Final Total: $" . number_format($finalTotal, 2) . "</strong><br><br>";

    echo "<strong>Math Function Results:</strong><br>";
    echo "Highest priced item: $" . number_format($highest_price, 2) . "<br>";
    echo "Lowest priced item: $" . number_format($lowest_price, 2) . "<br><br>";

    echo "<hr>";
}
?>

</body>
</html>
