<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class AboutSection
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAll(): array
    {
        $stmt = $this->db->query(
            "SELECT *
               FROM about_sections
           ORDER BY sort_order ASC, created_at ASC"
        );
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById(int $id): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM about_sections WHERE id = :id"
        );
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public function add(string $title, string $content, ?string $image, int $sortOrder = 0): bool
    {
        $stmt = $this->db->prepare(
            "INSERT INTO about_sections (title, content, image, sort_order)
             VALUES (:title, :content, :image, :sort_order)"
        );
        return $stmt->execute([
            ':title' => $title,
            ':content' => $content,
            ':image' => $image,
            ':sort_order' => $sortOrder,
        ]);
    }

    public function update(int $id, string $title, string $content, ?string $image, int $sortOrder): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE about_sections
                SET title      = :title,
                    content    = :content,
                    image      = :image,
                    sort_order = :sort_order
              WHERE id = :id"
        );
        return $stmt->execute([
            ':id' => $id,
            ':title' => $title,
            ':content' => $content,
            ':image' => $image,
            ':sort_order' => $sortOrder,
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare(
            "DELETE FROM about_sections WHERE id = :id"
        );
        return $stmt->execute([':id' => $id]);
    }

    public function updateSortOrder(int $id, int $sort): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE about_sections
                SET sort_order = :sort
              WHERE id = :id"
        );
        return $stmt->execute([
            ':sort' => $sort,
            ':id' => $id,
        ]);
    }
}
