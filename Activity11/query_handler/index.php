<?php
/******************************************************
 * Activity 11.2 – Dynamic Query Parameter Handler
 * Demonstrates:
 * - Retrieving all query parameters using $_GET
 * - Displaying parameter names and values
 * - Handling no-parameter cases
 * - Sanitizing input
 * - Basic error handling
 ******************************************************/

// Retrieve all GET parameters
$params = $_GET;

// Sanitize all values
$cleanParams = [];
foreach ($params as $key => $value) {
    $cleanParams[htmlspecialchars($key)] = htmlspecialchars($value);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Query Parameter Handler</title>
</head>
<body>

<h1>Dynamic Query Parameter Handler</h1>

<!-- (1) Display all query parameters -->
<h2>1. Received Query Parameters</h2>

<?php if (empty($cleanParams)): ?>
    <p>No query parameters were provided.</p>
<?php else: ?>
    <ul>
        <?php foreach ($cleanParams as $key => $value): ?>
            <li><strong><?php echo $key; ?>:</strong> <?php echo $value; ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<hr>

<!-- (2) Error Handling -->
<h2>2. Error Handling</h2>
<?php
// Example: require "id" parameter
if (!isset($params['id'])) {
    echo "<p style='color:red;'>Warning: 'id' parameter is missing.</p>";
} else {
    echo "<p>'id' parameter received successfully.</p>";
}
?>

<hr>

<!-- (3) Optional JavaScript Parameter Builder -->
<h2>3. Add / Remove Query Parameters (Optional)</h2>

<p>Build your own query string dynamically:</p>

<div id="param-container">
    <!-- Pre-filled example row -->
    <div class="param-row">
        <input type="text" placeholder="key" value="id">
        <input type="text" placeholder="value" value="123">
        <button onclick="removeRow(this)">Remove</button>
    </div>

    <div class="param-row">
        <input type="text" placeholder="key" value="name">
        <input type="text" placeholder="value" value="S">
        <button onclick="removeRow(this)">Remove</button>
    </div>
</div>

<button onclick="addRow()">Add Parameter</button>
<button onclick="go()">Go</button>

<script>
function addRow() {
    const container = document.getElementById('param-container');
    const row = document.createElement('div');
    row.className = 'param-row';
    row.innerHTML = `
        <input type="text" placeholder="key">
        <input type="text" placeholder="value">
        <button onclick="removeRow(this)">Remove</button>
    `;
    container.appendChild(row);
}

function removeRow(btn) {
    btn.parentElement.remove();
}
function go() {
    const rows = document.querySelectorAll('.param-row');
    let query = [];

    rows.forEach(row => {
        const key = row.children[0].value.trim();
        const value = row.children[1].value.trim();
        if (key !== "") {
            query.push(encodeURIComponent(key) + "=" + encodeURIComponent(value));
        }
    });

    // If no parameters, reload without query
    if (query.length === 0) {
        window.location = "query_handler.php";
    } else {
window.location = "index.php?" + query.join("&");
    }
}

</script>

</body>
</html>
