<?php

namespace App\Controllers;

use App\Core\Database;
use App\Models\Project;
use App\Logic\UploadHandler;

class ProjectController
{
    private Project $projectModel;
    private UploadHandler $uploader;

    public function __construct()
    {
        $db = Database::getInstance();
        $this->projectModel = new Project();
        $this->uploader = new UploadHandler($db);
    }


    public function index(): void
    {
        $projects = $this->projectModel->getAll();
        require __DIR__ . '/../Views/dashboard.view.php';
    }


    public function store(array $data, array $files): void
    {
        $ok = $this->projectModel->add(
            $data['title'],
            $data['description'],
            $data['company'] ?? null,
            null,
            $data['link'] ?? null
        );

        if ($ok) {
            $projectId = Database::getInstance()->lastInsertId();

            if (!empty($files['image']['name'])) {
                $path = $this->uploader->upload($files['image'], $data['title'], (int)$projectId);
                if (empty($this->uploader->errors)) {
                    $this->projectModel->updateImage((int)$projectId, $path);
                }
            }
        }

        header('Location: dashboard.php');
        exit;
    }

    public function edit(int $id): void
    {
        $project = $this->projectModel->getById($id);
        if (!$project) {
            header('Location: dashboard.php');
            exit;
        }
        require __DIR__ . '/../Views/edit_project.view.php';
    }

    public function update(int $id, array $data, array $files): void
    {
        $project = $this->projectModel->getById($id);
        $imagePath = $project['image'];

        if (!empty($data['delete_image'])) {
            if ($imagePath && file_exists(__DIR__ . '/../../' . $imagePath)) {
                unlink(__DIR__ . '/../../' . $imagePath);
            }
            $imagePath = null;
        }

        if (isset($files['image']) && $files['image']['error'] !== UPLOAD_ERR_NO_FILE) {
            $newPath = $this->uploader->upload($files['image'], $data['title'], $id);
            if (empty($this->uploader->errors)) {
                // altes Bild entfernen
                if ($imagePath && file_exists(__DIR__ . '/../../' . $imagePath)) {
                    unlink(__DIR__ . '/../../' . $imagePath);
                }
                $imagePath = $newPath;
            }
        }

        $this->projectModel->update(
            $id,
            $data['title'],
            $data['description'],
            $data['company'] ?? null,
            $imagePath,
            $data['link'] ?? null
        );

        header("Location: edit_project.php?id={$id}");
        exit;
    }


    public function destroy(int $id): void
    {
        $this->projectModel->delete($id);
        header('Location: dashboard.php');
        exit;
    }
}
