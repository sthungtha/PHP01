<?php
require_once "models/Activity.php";
define("UPLOAD_DIR", dirname(__DIR__) . "/uploads/");

class ProjectController {

    public function index() { /* unchanged */ 
        if (!isLoggedIn()) redirect("index.php?controller=auth&action=login");
        global $pdo;
        $search = $_GET["search"] ?? "";
        $stmt = $pdo->prepare("SELECT p.*, u.username as created_by_name FROM projects p LEFT JOIN users u ON p.created_by = u.id WHERE p.name LIKE ? OR p.description LIKE ? ORDER BY p.created_at DESC");
        $stmt->execute(["%$search%", "%$search%"]);
        $projects = $stmt->fetchAll();
        require "views/projects/index.php";
    }

    public function create() { /* unchanged */ 
        if (!isLoggedIn()) redirect("index.php?controller=auth&action=login");
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            validateCSRF($_POST["csrf_token"] ?? "");
            global $pdo;
            $name = sanitize($_POST["name"]);
            $description = sanitize($_POST["description"]);
            $stmt = $pdo->prepare("INSERT INTO projects (name, description, created_by) VALUES (?, ?, ?)");
            $stmt->execute([$name, $description, $_SESSION["user_id"]]);
            $_SESSION["success"] = "Project created successfully!";
            redirect("index.php?controller=project&action=index");
        }
        require "views/projects/create.php";
    }

    public function board() { /* unchanged */ 
        if (!isLoggedIn()) redirect("index.php?controller=auth&action=login");
        $projectId = (int)($_GET["id"] ?? 0);
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ?"); $stmt->execute([$projectId]); $project = $stmt->fetch();
        $stmt = $pdo->prepare("SELECT t.*, u.username as assigned_name FROM tasks t LEFT JOIN users u ON t.assigned_to = u.id WHERE t.project_id = ? ORDER BY FIELD(t.status, 'todo','inprogress','done'), t.created_at");
        $stmt->execute([$projectId]); $tasks = $stmt->fetchAll();
        require "views/projects/board.php";
    }

    public function calendar() { /* unchanged */ 
        if (!isLoggedIn()) redirect("index.php?controller=auth&action=login");
        global $pdo;
        $stmt = $pdo->prepare("SELECT t.*, p.name as project_name, u.username as assigned_name FROM tasks t LEFT JOIN projects p ON t.project_id = p.id LEFT JOIN users u ON t.assigned_to = u.id WHERE t.due_date IS NOT NULL ORDER BY t.due_date");
        $stmt->execute(); $tasks = $stmt->fetchAll();
        require "views/projects/calendar.php";
    }

    public function reports() { /* unchanged */ 
        if (!isLoggedIn()) redirect("index.php?controller=auth&action=login");
        global $pdo;
        $overdue = $pdo->query("SELECT COUNT(*) FROM tasks WHERE due_date < CURDATE() AND status != 'done'")->fetchColumn();
        $completed = $pdo->query("SELECT COUNT(*) FROM tasks WHERE status = 'done'")->fetchColumn();
        require "views/projects/reports.php";
    }

    public function exportCSV() { /* unchanged */ 
        if (!isLoggedIn()) redirect("index.php?controller=auth&action=login");
        global $pdo;
        header("Content-Type: text/csv");
        header("Content-Disposition: attachment; filename=\"tasks_export.csv\"");
        $output = fopen("php://output", "w");
        fputcsv($output, ["Task ID", "Project", "Title", "Status", "Priority", "Assigned To", "Due Date"]);
        $stmt = $pdo->query("SELECT t.id, p.name as project_name, t.title, t.status, t.priority, u.username as assigned_name, t.due_date FROM tasks t LEFT JOIN projects p ON t.project_id = p.id LEFT JOIN users u ON t.assigned_to = u.id");
        while ($row = $stmt->fetch()) fputcsv($output, $row);
        fclose($output); exit;
    }

    /* NEW: Simple form for creating new task from board */
    public function createTaskForm() {
        if (!isLoggedIn()) redirect("index.php?controller=auth&action=login");
        $projectId = (int)($_GET["id"] ?? 0);
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
        $stmt->execute([$projectId]);
        $project = $stmt->fetch();
        $usersStmt = $pdo->query("SELECT id, username FROM users ORDER BY username");
        $users = $usersStmt->fetchAll();
        require "views/tasks/create.php";
    }

    public function createTask() {
        if (!isLoggedIn()) redirect("index.php?controller=auth&action=login");
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            validateCSRF($_POST["csrf_token"] ?? "");
            global $pdo;
            $projectId = (int)$_POST["project_id"];
            $title = sanitize($_POST["title"]);
            $description = sanitize($_POST["description"]);
            $status = $_POST["status"] ?? "todo";
            $priority = $_POST["priority"] ?? "medium";
            $assigned_to = !empty($_POST["assigned_to"]) ? (int)$_POST["assigned_to"] : null;
            $due_date = !empty($_POST["due_date"]) ? $_POST["due_date"] : null;

            $attachment = null;
            if (isset($_FILES["attachment"]) && $_FILES["attachment"]["error"] == 0) {
                $filename = time() . "_" . basename($_FILES["attachment"]["name"]);
                $target = UPLOAD_DIR . $filename;
                if (move_uploaded_file($_FILES["attachment"]["tmp_name"], $target)) $attachment = $filename;
            }

            $stmt = $pdo->prepare("INSERT INTO tasks (project_id, title, description, status, priority, assigned_to, due_date, created_by, attachment) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$projectId, $title, $description, $status, $priority, $assigned_to, $due_date, $_SESSION["user_id"], $attachment]);

            $activity = new Activity();
            $activity->add($pdo->lastInsertId(), $_SESSION["user_id"], "Task created: " . $title);

            $_SESSION["success"] = "Task created successfully!";
            redirect("index.php?controller=project&action=board&id=" . $projectId);
        }
    }

    public function taskDetail() { /* unchanged */ 
        if (!isLoggedIn()) redirect("index.php?controller=auth&action=login");
        $taskId = (int)($_GET["id"] ?? 0);
        global $pdo;
        $stmt = $pdo->prepare("SELECT t.*, p.name as project_name, u.username as assigned_name FROM tasks t LEFT JOIN projects p ON t.project_id = p.id LEFT JOIN users u ON t.assigned_to = u.id WHERE t.id = ?");
        $stmt->execute([$taskId]);
        $task = $stmt->fetch();
        $usersStmt = $pdo->query("SELECT id, username FROM users ORDER BY username");
        $users = $usersStmt->fetchAll();
        $commentModel = new Comment();
        $comments = $commentModel->getByTask($taskId);
        $activityModel = new Activity();
        $activities = $activityModel->getByTask($taskId);
        require "views/tasks/detail.php";
    }

    public function updateTask() { /* your working version */ 
        if (!isLoggedIn()) redirect("index.php?controller=auth&action=login");
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            validateCSRF($_POST["csrf_token"] ?? "");
            global $pdo;
            $taskId = (int)$_POST["task_id"];
            $title = sanitize($_POST["title"]);
            $description = sanitize($_POST["description"]);
            $status = $_POST["status"];
            $priority = $_POST["priority"];
            $assigned_to = !empty($_POST["assigned_to"]) ? (int)$_POST["assigned_to"] : null;
            $due_date = !empty($_POST["due_date"]) ? $_POST["due_date"] : null;

            $existingStmt = $pdo->prepare("SELECT attachment FROM tasks WHERE id = ?");
            $existingStmt->execute([$taskId]);
            $existing = $existingStmt->fetch();
            $attachment = $existing["attachment"];

            if (isset($_FILES["attachment"]) && $_FILES["attachment"]["error"] == UPLOAD_ERR_OK) {
                $uploadDir = UPLOAD_DIR;
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
                $filename = time() . "_" . basename($_FILES["attachment"]["name"]);
                $target = $uploadDir . $filename;
                if (move_uploaded_file($_FILES["attachment"]["tmp_name"], $target)) $attachment = $filename;
            }

            $stmt = $pdo->prepare("UPDATE tasks SET title=?, description=?, status=?, priority=?, assigned_to=?, due_date=?, attachment=? WHERE id=?");
            $stmt->execute([$title, $description, $status, $priority, $assigned_to, $due_date, $attachment, $taskId]);

            $activity = new Activity();
            $activity->add($taskId, $_SESSION["user_id"], "Task updated");
            $_SESSION["success"] = "Task updated successfully!";
            redirect("index.php?controller=project&action=taskDetail&id=" . $taskId);
        }
    }

    public function updateTaskStatus() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            validateCSRF($_POST["csrf_token"] ?? "");
            global $pdo;
            $taskId = (int)($_POST["task_id"] ?? 0);
            $status = $_POST["status"] ?? "todo";
            $allowed = ["todo", "inprogress", "done"];
            if (!in_array($status, $allowed)) $status = "todo";

            $stmt = $pdo->prepare("UPDATE tasks SET status = ? WHERE id = ?");
            $stmt->execute([$status, $taskId]);

            $activity = new Activity();
            $activity->add($taskId, $_SESSION["user_id"] ?? 0, "Status changed to " . ucfirst($status));

            header("Content-Type: application/json");
            echo json_encode(["success" => true]);
            exit;
        }
    }

    public function addComment() { /* unchanged */ 
        if (!isLoggedIn()) redirect("index.php?controller=auth&action=login");
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            validateCSRF($_POST["csrf_token"] ?? "");
            global $pdo;
            $taskId = (int)$_POST["task_id"];
            $commentText = sanitize($_POST["comment"]);
            $commentModel = new Comment();
            if ($commentModel->add($taskId, $_SESSION["user_id"], $commentText)) {
                $activity = new Activity();
                $activity->add($taskId, $_SESSION["user_id"], "Comment added");
                $_SESSION["success"] = "Comment posted!";
            }
            redirect("index.php?controller=project&action=taskDetail&id=" . $taskId);
        }
    }

    public function deleteTask() { /* unchanged */ 
        if (!isLoggedIn()) redirect("index.php?controller=auth&action=login");
        $taskId = (int)($_GET["id"] ?? 0);
        global $pdo;
        $stmt = $pdo->prepare("SELECT project_id FROM tasks WHERE id = ?");
        $stmt->execute([$taskId]);
        $projectId = $stmt->fetchColumn();
        $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ?");
        $stmt->execute([$taskId]);
        $_SESSION["success"] = "Task deleted!";
        redirect("index.php?controller=project&action=board&id=" . $projectId);
    }

    public function deleteProject() { /* unchanged */ 
        if (!isLoggedIn()) redirect("index.php?controller=auth&action=login");
        $projectId = (int)($_GET["id"] ?? 0);
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM tasks WHERE project_id = ?"); $stmt->execute([$projectId]);
        $stmt = $pdo->prepare("DELETE FROM projects WHERE id = ?"); $stmt->execute([$projectId]);
        $_SESSION["success"] = "Project deleted!";
        redirect("index.php?controller=project&action=index");
    }
}
?>
