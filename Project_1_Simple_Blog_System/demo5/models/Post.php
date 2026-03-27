<?php
class Post {
    private $pdo;

    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }

    public function create($title, $content, $userId, $image = null) {
        $stmt = $this->pdo->prepare("INSERT INTO posts (title, content, featured_image, user_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([$title, $content, $image, $userId]);
        return $this->pdo->lastInsertId();
    }

    public function getAll($limit = 6, $offset = 0, $categoryId = null, $search = null) {
        $sql = "SELECT p.*, u.username FROM posts p 
                JOIN users u ON p.user_id = u.id 
                WHERE p.status = 'published'";

        $params = [];
        $types = []; // For explicit INT binding

        if ($categoryId !== null) {
            $sql .= " AND p.id IN (SELECT post_id FROM post_categories WHERE category_id = ?)";
            $params[] = (int)$categoryId;
            $types[] = PDO::PARAM_INT;
        }

        if ($search) {
            $sql .= " AND (p.title LIKE ? OR p.content LIKE ?)";
            $params[] = "%$search%";
            $params[] = "%$search%";
            $types[] = PDO::PARAM_STR;
            $types[] = PDO::PARAM_STR;
        }

        $sql .= " ORDER BY p.created_at DESC LIMIT ? OFFSET ?";
        $params[] = (int)$limit;
        $params[] = (int)$offset;
        $types[] = PDO::PARAM_INT;
        $types[] = PDO::PARAM_INT;

        $stmt = $this->pdo->prepare($sql);
        
        // Bind parameters with correct types
        foreach ($params as $key => $value) {
            $stmt->bindValue($key + 1, $value, $types[$key]);
        }

        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT p.*, u.username FROM posts p 
                                     JOIN users u ON p.user_id = u.id 
                                     WHERE p.id = ?");
        $stmt->execute([(int)$id]);
        return $stmt->fetch();
    }

    public function update($id, $title, $content, $image = null) {
        $id = (int)$id;
        if ($image) {
            $stmt = $this->pdo->prepare("UPDATE posts SET title = ?, content = ?, featured_image = ? WHERE id = ?");
            $stmt->execute([$title, $content, $image, $id]);
        } else {
            $stmt = $this->pdo->prepare("UPDATE posts SET title = ?, content = ? WHERE id = ?");
            $stmt->execute([$title, $content, $id]);
        }
        return true;
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM posts WHERE id = ?");
        return $stmt->execute([(int)$id]);
    }

    public function assignCategories($postId, $categoryIds) {
        $postId = (int)$postId;
        $this->pdo->prepare("DELETE FROM post_categories WHERE post_id = ?")->execute([$postId]);
        
        $stmt = $this->pdo->prepare("INSERT INTO post_categories (post_id, category_id) VALUES (?, ?)");
        foreach ($categoryIds as $catId) {
            $stmt->execute([$postId, (int)$catId]);
        }
    }

    public function getTotalPosts($search = null) {
        $sql = "SELECT COUNT(*) FROM posts WHERE status = 'published'";
        if ($search) {
            $sql .= " AND (title LIKE ? OR content LIKE ?)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(["%$search%", "%$search%"]);
        } else {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
        }
        return $stmt->fetchColumn();
    }
}
?>