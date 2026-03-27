<?php
/* 
===========================================================
 Activity 6: PHP Constants - Configuration Manager
 Full Solution + Optional Extensions
===========================================================
*/

// ---------------------------------------------------------
// 1. BASIC CONSTANTS (Database + App Info)
// ---------------------------------------------------------

define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "password123");
define("DB_NAME", "myapp_db");

define("APP_NAME", "MyPHPApp");
define("APP_VERSION", "1.0.0");
define("DEBUG_MODE", true);


// ---------------------------------------------------------
// 2. ARRAY CONSTANT (Supported Languages)
// ---------------------------------------------------------

define("SUPPORTED_LANGUAGES", [
    "en" => "English",
    "es" => "Spanish",
    "fr" => "French"
]);


// ---------------------------------------------------------
// 3. OPTIONAL EXTENSION: MULTI-DIMENSIONAL CONFIG CONSTANT
// ---------------------------------------------------------

define("APP_CONFIG", [
    "database" => [
        "host" => DB_HOST,
        "user" => DB_USER,
        "name" => DB_NAME
    ],
    "app" => [
        "name" => APP_NAME,
        "version" => APP_VERSION,
        "debug" => DEBUG_MODE
    ],
    "features" => [
        "logging" => true,
        "cache" => false,
        "api_enabled" => true
    ]
]);


// ---------------------------------------------------------
// 4. DISPLAY FUNCTIONS
// ---------------------------------------------------------

function showDatabaseConfig() {
    echo "<h3>Database Configuration:</h3>";
    echo "Host: " . DB_HOST . "<br>";
    echo "User: " . DB_USER . "<br>";
    echo "Database: " . DB_NAME . "<br><br>";
}

function showAppInfo() {
    echo "<h3>App Information:</h3>";
    echo "Name: " . APP_NAME . "<br>";
    echo "Version: " . APP_VERSION . "<br>";
    echo "Debug Mode: " . (DEBUG_MODE ? "Enabled" : "Disabled") . "<br><br>";
}

function showLanguages() {
    echo "<h3>Supported Languages:</h3>";
    foreach (SUPPORTED_LANGUAGES as $code => $language) {
        echo "$code: $language<br>";
    }
    echo "<br>";
}


// ---------------------------------------------------------
// 5. OPTIONAL EXTENSION: FUNCTION USING MULTI-DIMENSIONAL CONFIG
// ---------------------------------------------------------

function configureApplication() {
    echo "<h3>Application Configuration Summary:</h3>";

    echo "App Name: " . APP_CONFIG["app"]["name"] . "<br>";
    echo "Version: " . APP_CONFIG["app"]["version"] . "<br>";
    echo "Debug Mode: " . (APP_CONFIG["app"]["debug"] ? "Enabled" : "Disabled") . "<br>";

    echo "Logging Enabled: " . (APP_CONFIG["features"]["logging"] ? "Yes" : "No") . "<br>";
    echo "Cache Enabled: " . (APP_CONFIG["features"]["cache"] ? "Yes" : "No") . "<br>";
    echo "API Enabled: " . (APP_CONFIG["features"]["api_enabled"] ? "Yes" : "No") . "<br><br>";
}


// ---------------------------------------------------------
// 6. CASE-SENSITIVITY DEMONSTRATION
// ---------------------------------------------------------

function caseSensitivityDemo() {
    echo "<h3>Case-Insensitivity Demonstration:</h3>";
    echo "APP_NAME: " . APP_NAME . "<br>";

    // Attempt incorrect case
    echo "app_name: ";
    echo defined("app_name") ? app_name : "Not accessible (case-sensitive)";
    echo "<br><br>";
}


// ---------------------------------------------------------
// 7. GLOBAL SCOPE DEMONSTRATION
// ---------------------------------------------------------

function testScope() {
    echo "<h3>Testing Constant Scope in Function:</h3>";
    echo "APP_NAME is a constant inside this function which returns the value of APP_NAME: " . APP_NAME . "<br><br>";
}


// ---------------------------------------------------------
// 8. ERROR HANDLING (Attempt to redefine constant)
// ---------------------------------------------------------

function redefineConstantDemo() {
    echo "<h3>Error Handling Demonstration:</h3>";

    try {
        define("APP_NAME", "NewName"); // This will throw an error
    } catch (Error $e) {
        echo "Error: " . $e->getMessage() . "<br><br>";
    }
}


// ---------------------------------------------------------
// 9. MAIN EXECUTION
// ---------------------------------------------------------

echo "<h2>PHP Constants - Configuration Manager</h2>";

showDatabaseConfig();
showAppInfo();
showLanguages();
configureApplication();
caseSensitivityDemo();
testScope();
redefineConstantDemo();

?>
