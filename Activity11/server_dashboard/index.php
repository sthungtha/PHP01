<?php
/******************************************************
 * Activity 11.3 – Server Information Dashboard
 * Demonstrates:
 * - $_SERVER
 * - $_ENV
 * - User agent parsing
 * - phpinfo()
 * - Basic security considerations
 ******************************************************/

// -------------------------------
// (1) Parse User Agent Function
// -------------------------------
function parseUserAgent($ua) {
    $browser = "Unknown Browser";
    $platform = "Unknown OS";

    // Detect OS
    if (preg_match('/windows/i', $ua)) $platform = "Windows";
    elseif (preg_match('/linux/i', $ua)) $platform = "Linux";
    elseif (preg_match('/macintosh|mac os x/i', $ua)) $platform = "Mac OS";

    // Detect Browser
    if (preg_match('/chrome/i', $ua)) $browser = "Google Chrome";
    elseif (preg_match('/firefox/i', $ua)) $browser = "Mozilla Firefox";
    elseif (preg_match('/safari/i', $ua)) $browser = "Safari";
    elseif (preg_match('/edge/i', $ua)) $browser = "Microsoft Edge";

    return [
        "browser" => $browser,
        "platform" => $platform
    ];
}

$userAgent = $_SERVER['HTTP_USER_AGENT'] ?? "Unknown";
$parsedUA = parseUserAgent($userAgent);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Server Information Dashboard</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 20px;
        }
        .box {
            background: white;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 0 5px #ccc;
        }
        h2 {
            margin-top: 0;
        }
        pre {
            background: #222;
            color: #0f0;
            padding: 10px;
            border-radius: 5px;
            overflow-x: auto;
        }
    </style>
</head>
<body>

<h1>Server Information Dashboard</h1>

<!-- ============================= -->
<!-- (1) SERVER INFORMATION -->
<!-- ============================= -->
<div class="box">
    <h2>1. Server Information ($_SERVER)</h2>

    <p><strong>Server Software:</strong> <?php echo htmlspecialchars($_SERVER['SERVER_SOFTWARE']); ?></p>
    <p><strong>Server IP:</strong> <?php echo htmlspecialchars($_SERVER['SERVER_ADDR']); ?></p>
    <p><strong>Server Port:</strong> <?php echo htmlspecialchars($_SERVER['SERVER_PORT']); ?></p>
    <p><strong>Script Name:</strong> <?php echo htmlspecialchars($_SERVER['SCRIPT_NAME']); ?></p>
    <p><strong>Script Path:</strong> <?php echo htmlspecialchars($_SERVER['SCRIPT_FILENAME']); ?></p>
    <p><strong>Client IP:</strong> <?php echo htmlspecialchars($_SERVER['REMOTE_ADDR']); ?></p>
    <p><strong>User Agent:</strong> <?php echo htmlspecialchars($userAgent); ?></p>
</div>

<!-- ============================= -->
<!-- (2) PARSED USER AGENT -->
<!-- ============================= -->
<div class="box">
    <h2>2. Parsed User Agent</h2>
    <p><strong>Browser:</strong> <?php echo $parsedUA['browser']; ?></p>
    <p><strong>Operating System:</strong> <?php echo $parsedUA['platform']; ?></p>
</div>

<!-- ============================= -->
<!-- (3) ENVIRONMENT VARIABLES -->
<!-- ============================= -->
<div class="box">
    <h2>3. Environment Variables ($_ENV)</h2>

    <?php if (!empty($_ENV)): ?>
        <pre><?php print_r($_ENV); ?></pre>
    <?php else: ?>
        <p>No environment variables available.</p>
    <?php endif; ?>
</div>

<!-- ============================= -->
<!-- (4) PHP CONFIGURATION -->
<!-- ============================= -->
<div class="box">
    <h2>4. PHP Configuration (phpinfo)</h2>
    <p><strong>Note:</strong> phpinfo() can expose sensitive information.  
    Only enable this on a safe local environment.</p>

    <details>
        <summary>Show phpinfo()</summary>
        <?php phpinfo(); ?>
    </details>
</div>

</body>
</html>
