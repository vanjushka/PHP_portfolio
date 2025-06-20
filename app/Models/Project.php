<?php
// app/Models/Project.php
namespace App\Models;

use App\Core\Database;
use PDO;

class Project
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    // Create a new project
    public function add(
        string  $title,
        string  $description,
        ?string $company = null,
        ?string $image = null,
        ?string $link = null
    ): bool
    {
        $stmt = $this->db->prepare(
            'INSERT INTO projects (title, description, company, image, link)
             VALUES (:title, :description, :company, :image, :link)'
        );
        return $stmt->execute([
            ':title' => $title,
            ':description' => $description,
            ':company' => $company,
            ':image' => $image,
            ':link' => $link,
        ]);
    }

    // Fetch all projects
    public function getAll(): array
    {
        $stmt = $this->db->query(
            'SELECT * FROM projects
             ORDER BY created_at DESC'
        );
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch a single project by ID
    public function getById(int $id): ?array
    {
        $stmt = $this->db->prepare(
            'SELECT * FROM projects WHERE id = :id'
        );
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    // Update project details
    public function update(
        int     $id,
        string  $title,
        string  $description,
        ?string $company = null,
        ?string $image = null,
        ?string $link = null
    ): bool
    {
        $stmt = $this->db->prepare(
            'UPDATE projects
                SET title       = :title,
                    description = :description,
                    company     = :company,
                    image       = :image,
                    link        = :link
              WHERE id = :id'
        );
        return $stmt->execute([
            ':title' => $title,
            ':description' => $description,
            ':company' => $company,
            ':image' => $image,
            ':link' => $link,
            ':id' => $id,
        ]);
    }

    // Get all images
    public function getImages(int $projectId): array
    {
        $stmt = $this->db->prepare(
            'SELECT * FROM images
             WHERE project_id = :project_id
             ORDER BY id DESC'
        );
        $stmt->execute([':project_id' => $projectId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update only img field
    public function updateImage(int $projectId, ?string $imagePath): bool
    {
        $stmt = $this->db->prepare(
            'UPDATE projects
                SET image = :image
              WHERE id    = :id'
        );
        return $stmt->execute([
            ':image' => $imagePath,
            ':id' => $projectId,
        ]);
    }

    // Delete a project
    public function delete(int $id): bool
    {
        $this->db
            ->prepare('DELETE FROM images WHERE project_id = :id')
            ->execute([':id' => $id]);

        $stmt = $this->db->prepare(
            'DELETE FROM projects WHERE id = :id'
        );
        return $stmt->execute([':id' => $id]);
    }
}
