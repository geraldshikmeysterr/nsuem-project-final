<?php
class Comment {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getByArticle(int $articleId): array {
        $stmt = $this->db->prepare("
            SELECT c.*, u.email AS author_email
            FROM comments c
            JOIN users u ON u.id = c.user_id
            WHERE c.article_id = :id AND c.status = 'approved'
            ORDER BY c.created_at ASC
        ");
        $stmt->execute([':id' => $articleId]);
        return $stmt->fetchAll();
    }

    public function getPending(): array {
        return $this->db->query("
            SELECT c.*, u.email AS author_email, a.title AS article_title
            FROM comments c
            JOIN users u ON u.id = c.user_id
            JOIN articles a ON a.id = c.article_id
            WHERE c.status = 'pending'
            ORDER BY c.created_at ASC
        ")->fetchAll();
    }

    public function create(int $articleId, int $userId, string $content): bool {
        $stmt = $this->db->prepare(
            "INSERT INTO comments (article_id, user_id, content) VALUES (:a, :u, :c)"
        );
        return $stmt->execute([':a' => $articleId, ':u' => $userId, ':c' => $content]);
    }

    public function getByUser(int $userId): array {
        $stmt = $this->db->prepare("
            SELECT c.*, a.title AS article_title
            FROM comments c
            JOIN articles a ON a.id = c.article_id
            WHERE c.user_id = :user_id
            ORDER BY c.created_at DESC
        ");
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetchAll();
    }

    public function setStatus(int $id, string $status): bool {
        $stmt = $this->db->prepare("UPDATE comments SET status = :s WHERE id = :id");
        return $stmt->execute([':s' => $status, ':id' => $id]);
    }
}
