<?php
// Initialize default values for the input fields to assist with testing
$filterStartDate = $_POST['start_date'] ?? '2023-10-25';
$filterEndDate   = $_POST['end_date'] ?? '2023-10-26';
$filterLevel     = $_POST['level'] ?? 'ERROR';
$filterSource    = $_POST['source'] ?? 'Database';
$filterKeyword   = $_POST['keyword'] ?? 'timeout';

$parsedLogs = [];
$levelSummary = [];
$errors = [];

// Regular Expression Pattern based on: [YYYY-MM-DD HH:MM:SS] [LOG_LEVEL] [SOURCE] Message
$logPattern = '/^\[(?P<date>\d{4}-\d{2}-\d{2})\s+(?P<time>\d{2}:\d{2}:\d{2})\]\s+\[(?P<level>[A-Z]+)\]\s+\[(?P<source>[^\]]+)\]\s+(?P<message>.*)$/';

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 1. Security & Error Handling for File Upload
    if (isset($_FILES['log_file']) && $_FILES['log_file']['error'] === UPLOAD_ERR_OK) {
        $tmpName = $_FILES['log_file']['tmp_name'];
        
        // Read file line by line
        $lines = file($tmpName, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        if ($lines === false) {
            $errors[] = "Failed to read the uploaded file.";
        } else {
            // 2. Parse the Log File
            foreach ($lines as $line) {
                if (preg_match($logPattern, $line, $matches)) {
                    $entry = [
                        'date'    => $matches['date'],
                        'time'    => $matches['time'],
                        'level'   => $matches['level'],
                        'source'  => $matches['source'],
                        'message' => $matches['message']
                    ];
                    
                    // Count occurrences of each log level
                    $levelSummary[$entry['level']] = ($levelSummary[$entry['level']] ?? 0) + 1;
                    
                    // 3. Apply Filters
                    $keep = true;
                    
                    // Date Filter
                    if (!empty($_POST['start_date']) && $entry['date'] < $_POST['start_date']) $keep = false;
                    if (!empty($_POST['end_date']) && $entry['date'] > $_POST['end_date']) $keep = false;
                    
                    // Level Filter
                    if (!empty($_POST['level']) && stripos($entry['level'], $_POST['level']) === false) $keep = false;
                    
                    // Source Filter
                    if (!empty($_POST['source']) && stripos($entry['source'], $_POST['source']) === false) $keep = false;
                    
                    // Keyword Filter (Search in message)
                    if (!empty($_POST['keyword']) && stripos($entry['message'], $_POST['keyword']) === false) $keep = false;
                    
                    if ($keep) {
                        $parsedLogs[] = $entry;
                    }
                }
            }
        }
    } else {
        $errors[] = "Please upload a valid log file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Log File Analyzer</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #f4f4f9; }
        .container { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #0056b3; color: white; }
        .error { color: red; font-weight: bold; }
        .form-group { margin-bottom: 15px; }
        label { display: inline-block; width: 120px; font-weight: bold; }
        input[type="text"], input[type="date"], input[type="file"] { padding: 5px; width: 200px; }
        button { padding: 8px 15px; background-color: #0056b3; color: white; border: none; cursor: pointer; }
        button:hover { background-color: #003d82; }
    </style>
</head>
<body>

<div class="container">
    <h2>Activity 12.3: Log File Analyzer</h2>
    
    <?php if (!empty($errors)): ?>
        <div class="error">
            <ul>
                <?php foreach ($errors as $error) echo "<li>" . htmlspecialchars($error) . "</li>"; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="index.php" method="POST" enctype="multipart/form-data">
        <fieldset>
            <legend>Upload & Filter Configuration</legend>
            <div class="form-group">
                <label for="log_file">Log File:</label>
                <input type="file" name="log_file" id="log_file" accept=".log,.txt">
            </div>
            
            <p><em>Note: Test values are pre-filled below based on the provided sample.log data.</em></p>
            
            <div class="form-group">
                <label for="start_date">Start Date:</label>
                <input type="date" name="start_date" id="start_date" value="<?php echo htmlspecialchars($filterStartDate); ?>">
            </div>
            <div class="form-group">
                <label for="end_date">End Date:</label>
                <input type="date" name="end_date" id="end_date" value="<?php echo htmlspecialchars($filterEndDate); ?>">
            </div>
            <div class="form-group">
                <label for="level">Log Level:</label>
                <input type="text" name="level" id="level" value="<?php echo htmlspecialchars($filterLevel); ?>" placeholder="e.g., ERROR, INFO">
            </div>
            <div class="form-group">
                <label for="source">Source:</label>
                <input type="text" name="source" id="source" value="<?php echo htmlspecialchars($filterSource); ?>" placeholder="e.g., Database, System">
            </div>
            <div class="form-group">
                <label for="keyword">Search Message:</label>
                <input type="text" name="keyword" id="keyword" value="<?php echo htmlspecialchars($filterKeyword); ?>" placeholder="Keywords...">
            </div>
            <button type="submit">Analyze Log File</button>
            <a href="index.php" style="margin-left: 10px; text-decoration: none; color: #555;">Clear Filters</a>
        </fieldset>
    </form>

    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($errors)): ?>
        
        <h3>Log Level Summary (Entire File)</h3>
        <table>
            <thead>
                <tr>
                    <th>Log Level</th>
                    <th>Count</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($levelSummary as $level => $count): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($level); ?></td>
                        <td><?php echo (int)$count; ?></td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($levelSummary)): ?>
                    <tr><td colspan="2">No valid log entries found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <h3>Filtered Results (<?php echo count($parsedLogs); ?> found)</h3>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Level</th>
                    <th>Source</th>
                    <th>Message</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($parsedLogs as $log): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($log['date']); ?></td>
                        <td><?php echo htmlspecialchars($log['time']); ?></td>
                        <td><?php echo htmlspecialchars($log['level']); ?></td>
                        <td><?php echo htmlspecialchars($log['source']); ?></td>
                        <td><?php echo htmlspecialchars($log['message']); ?></td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($parsedLogs)): ?>
                    <tr><td colspan="5">No log entries matched your filters.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

    <?php endif; ?>
</div>

</body>
</html>