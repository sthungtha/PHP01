<?php
/*
===========================================================
 Activity 7: PHP Conditional Statements - User Profile System
 FULL SOLUTION + OPTIONAL EXTENSIONS
===========================================================
*/

// ---------------------------------------------------------
// 1. TIME-BASED GREETING FUNCTIONS
// ---------------------------------------------------------

function getCurrentHour() {
    return (int) date("G");
}

function getGreeting($hour) {
    if ($hour >= 5 && $hour < 12) {
        return "Good morning";
    } elseif ($hour >= 12 && $hour < 17) {
        return "Good afternoon";
    } elseif ($hour >= 17 && $hour < 21) {
        return "Good evening";
    } else {
        return "Good night";
    }
}


// ---------------------------------------------------------
// 2. AGE VERIFICATION SYSTEM
// ---------------------------------------------------------

function getAgeMessage($age) {
    if ($age < 0) {
        return "Invalid age entered.";
    } elseif ($age < 13) {
        return "You are a minor.";
    } elseif ($age < 20) {
        return "You are a teenager.";
    } elseif ($age < 60) {
        return "Welcome, adult user!";
    } else {
        return "Greetings, senior user!";
    }
}


// ---------------------------------------------------------
// 3. USER TYPE CLASSIFICATION (SWITCH)
// ---------------------------------------------------------

function getUserType($loginCount) {
    switch (true) {
        case ($loginCount === 0):
            return "New User";
        case ($loginCount >= 1 && $loginCount <= 5):
            return "Beginner";
        case ($loginCount >= 6 && $loginCount <= 20):
            return "Regular User";
        case ($loginCount > 20):
            return "Expert User";
        default:
            return "Unknown User Type";
    }
}


// ---------------------------------------------------------
// 4. ADDITIONAL CONDITIONAL FEATURE
// ---------------------------------------------------------

function getMotivationalMessage($userType, $loginCount) {
    if ($userType === "Expert User") {
        return "Amazing! You're at the top level!";
    } elseif ($userType === "Regular User") {
        $remaining = 21 - $loginCount;
        return "Keep logging in! You need $remaining more logins to become an Expert User.";
    } elseif ($userType === "Beginner") {
        return "You're off to a great start!";
    } elseif ($userType === "New User") {
        return "Welcome! Start exploring and level up!";
    } else {
        return "Keep going!";
    }
}


// ---------------------------------------------------------
// 5. OPTIONAL EXTENSION: MORE USER ATTRIBUTES
// ---------------------------------------------------------

function getAccessLevel($role) {
    if ($role === "admin") {
        return "Full system access granted.";
    } elseif ($role === "editor") {
        return "Content editing enabled.";
    } elseif ($role === "viewer") {
        return "Read-only access.";
    } else {
        return "Unknown role.";
    }
}


// ---------------------------------------------------------
// 6. OPTIONAL EXTENSION: SIMPLE LOGIN SYSTEM
// ---------------------------------------------------------

function simulateLogin(&$loginCount) {
    $loginCount++; // Increase login count each time script runs
    return $loginCount;
}


// ---------------------------------------------------------
// 7. OPTIONAL EXTENSION: PROGRESS BAR VISUALIZATION
// ---------------------------------------------------------

function getProgressBar($loginCount) {
    $progress = min(($loginCount / 21) * 100, 100);
    return "
        <div style='width:300px; background:#ddd; border-radius:5px;'>
            <div style='width:{$progress}%; background:#4CAF50; padding:5px; color:white; border-radius:5px;'>
                " . round($progress) . "% to Expert
            </div>
        </div><br>
    ";
}


// ---------------------------------------------------------
// 8. SIMULATED USER DATA
// ---------------------------------------------------------

$name = "John Doe";
$age = 25;
$loginCount = 10;
$role = "editor"; // new attribute


// ---------------------------------------------------------
// 9. ERROR HANDLING
// ---------------------------------------------------------

try {
    if ($age < 0) {
        throw new Exception("Age cannot be negative.");
    }
    if ($loginCount < 0) {
        throw new Exception("Login count cannot be negative.");
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit;
}


// ---------------------------------------------------------
// 10. MAIN EXECUTION
// ---------------------------------------------------------

$currentHour = getCurrentHour();
$greeting = getGreeting($currentHour);
$ageMessage = getAgeMessage($age);

// Simulate login update
$newLoginCount = simulateLogin($loginCount);

$userType = getUserType($newLoginCount);
$motivation = getMotivationalMessage($userType, $newLoginCount);
$accessLevel = getAccessLevel($role);
$progressBar = getProgressBar($newLoginCount);


// ---------------------------------------------------------
// 11. OUTPUT
// ---------------------------------------------------------

echo "<h2>User Profile</h2>";
echo "{$greeting}, {$name}!<br>";
echo "Current Time: " . date("h:i A") . "<br><br>";

echo "<strong>Age:</strong> {$age}<br>";
echo "<strong>Message:</strong> {$ageMessage}<br><br>";

echo "<strong>User Type:</strong> {$userType}<br>";
echo "<strong>Login Count:</strong> {$newLoginCount}<br>";
echo "<strong>Motivation:</strong> {$motivation}<br><br>";

echo "<strong>User Role:</strong> {$role}<br>";
echo "<strong>Access Level:</strong> {$accessLevel}<br><br>";

echo "<h3>Progress Toward Expert User:</h3>";
echo $progressBar;
?>
