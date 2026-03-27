<?php
function isLoggedIn() { return isset($_SESSION["user_id"]); }
function isAdmin() { return isset($_SESSION["role"]) && $_SESSION["role"] === "admin"; }
function redirect($url) { header("Location: " . BASE_URL . $url); exit; }
function sanitize($data) { return htmlspecialchars(trim($data), ENT_QUOTES, "UTF-8"); }
function generateCSRFToken() {
    if (empty($_SESSION["csrf_token"])) { $_SESSION["csrf_token"] = bin2hex(random_bytes(32)); }
    return $_SESSION["csrf_token"];
}
function validateCSRF($token) {
    if (!isset($_SESSION["csrf_token"]) || $token !== $_SESSION["csrf_token"]) { 
        die("CSRF validation failed. Please try again."); 
    }
}
function uploadImage($file) {
    $uploadDir = UPLOAD_DIR;
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
    $fileName = time() . "_" . basename($file["name"]);
    $targetFile = $uploadDir . $fileName;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    $check = getimagesize($file["tmp_name"]);
    if ($check === false || $file["size"] > 5000000 || !in_array($imageFileType, ["jpg","jpeg","png","gif"])) {
        return false;
    }
    if (move_uploaded_file($file["tmp_name"], $targetFile)) {
        createThumbnail($targetFile, $uploadDir . "thumb_" . $fileName, 300);
        return "uploads/" . $fileName;
    }
    return false;
}
function createThumbnail($source, $dest, $thumbWidth) {
    list($width, $height) = getimagesize($source);
    $ratio = $thumbWidth / $width;
    $newHeight = (int)($height * $ratio);
    $thumb = imagecreatetruecolor($thumbWidth, $newHeight);
    $sourceImg = imagecreatefromstring(file_get_contents($source));
    imagecopyresampled($thumb, $sourceImg, 0, 0, 0, 0, $thumbWidth, $newHeight, $width, $height);
    imagejpeg($thumb, $dest, 80);
    imagedestroy($thumb); imagedestroy($sourceImg);
}
function getSearchHighlight($text, $searchTerm) {
    if (empty($searchTerm)) return $text;
    return preg_replace("/(" . preg_quote($searchTerm, "/") . ")/i", "<mark>$1</mark>", $text);
}
?>
