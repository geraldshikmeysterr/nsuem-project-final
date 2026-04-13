<?php
class Article {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getAll(): array {
        $rows = $this->db->query("
            SELECT a.*, u.email AS author_email,
                   GROUP_CONCAT(t.name ORDER BY t.name SEPARATOR ',') AS tags
            FROM articles a
            JOIN users u ON u.id = a.author_id
            LEFT JOIN article_tags at2 ON at2.article_id = a.id
            LEFT JOIN tags t ON t.id = at2.tag_id
            WHERE a.status = 'published'
            GROUP BY a.id
            ORDER BY a.created_at DESC
        ")->fetchAll();

        foreach ($rows as &$row) {
            $row['tags'] = $row['tags'] ? explode(',', $row['tags']) : [];
        }
        return $rows;
    }

    public function getById(int $id): ?array {
        $stmt = $this->db->prepare("
            SELECT a.*, u.email AS author_email,
                   GROUP_CONCAT(t.name ORDER BY t.name SEPARATOR ',') AS tags
            FROM articles a
            JOIN users u ON u.id = a.author_id
            LEFT JOIN article_tags at2 ON at2.article_id = a.id
            LEFT JOIN tags t ON t.id = at2.tag_id
            WHERE a.id = :id
            GROUP BY a.id
        ");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        if (!$row) { return null; }
        $row['tags'] = $row['tags'] ? explode(',', $row['tags']) : [];
        return $row;
    }

    public function create(string $title, string $content, int $authorId, array $tags): int {
        $stmt = $this->db->prepare(
            "INSERT INTO articles (title, content, author_id) VALUES (:title, :content, :author_id)"
        );
        $stmt->execute([':title' => $title, ':content' => $content, ':author_id' => $authorId]);
        $articleId = (int)$this->db->lastInsertId();

        foreach ($tags as $tagName) {
            $tagName = trim($tagName);
            if ($tagName === '') { continue; }
            $this->db->prepare("INSERT IGNORE INTO tags (name) VALUES (:name)")
                     ->execute([':name' => $tagName]);
            $tag = $this->db->prepare("SELECT id FROM tags WHERE name = :name");
            $tag->execute([':name' => $tagName]);
            $tagId = $tag->fetchColumn();
            $this->db->prepare("INSERT IGNORE INTO article_tags (article_id, tag_id) VALUES (:a, :t)")
                     ->execute([':a' => $articleId, ':t' => $tagId]);
        }

        return $articleId;
    }
}
