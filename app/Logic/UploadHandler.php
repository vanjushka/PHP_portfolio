<?php
// app/Logic/UploadHandler.php

namespace App\Logic;

use PDO;
use Exception;

class UploadHandler
{
    private PDO $db;
    public array $errors = [];

    private array $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
    private int $maxSize = 2 * 1024 * 1024; // 2 MB

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    // Handle a file upload
    public function upload(array $file, string $altText, ?int $projectId = null): string
    {
        if (!isset($file['tmp_name'], $file['name'], $file['error'], $file['size'])) {
            $this->errors[] = 'Missing file data.';
            return '';
        }

        $valid = $this->checkUploadError($file['error'])
            & $this->validateAltText($altText);

        if ($file['error'] === UPLOAD_ERR_OK) {
            $valid &= $this->validateMime($file['tmp_name'])
                & $this->validateSize($file['size']);
        }

        if (!$valid) {
            return '';
        }

        try {
            $relativePath = $this->moveFile($file);
            $this->saveToDatabase($relativePath, $altText, $projectId);
            return $relativePath;
        } catch (Exception $e) {
            $this->errors[] = 'Error while saving the file.';
            return '';
        }
    }

    // Fetch all uploaded imgs
    public function getAllImages(): array
    {
        $stmt = $this->db->query('SELECT * FROM images ORDER BY id DESC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function validateAltText(string $text): bool
    {
        if (strlen(trim($text)) === 0 || mb_strlen($text) > 255) {
            $this->errors[] = 'Alt text must be 1–255 characters.';
            return false;
        }
        return true;
    }

    private function checkUploadError(int $code): bool
    {
        return match ($code) {
            UPLOAD_ERR_OK => true,
            UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE => $this->fail('Image too large.'),
            UPLOAD_ERR_NO_FILE => $this->fail('No file uploaded.'),
            default => $this->fail("Upload error code $code."),
        };
    }

    private function validateMime(string $tmpPath): bool
    {
        $mime = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $tmpPath);
        if (!in_array($mime, $this->allowedTypes, true)) {
            $this->errors[] = 'Invalid file type.';
            return false;
        }
        return true;
    }

    private function validateSize(int $size): bool
    {
        if ($size > $this->maxSize) {
            $this->errors[] = 'File exceeds 2 MB.';
            return false;
        }
        return true;
    }

    private function moveFile(array $file): string
    {
        $datePath = date('Y/m/d');
        $root = dirname(__DIR__, 2); // project root
        $uploadDir = "$root/uploads/$datePath";

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0775, true);
        }

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $name = uniqid('', true) . ".$ext";
        $fullPath = "$uploadDir/$name";

        if (!move_uploaded_file($file['tmp_name'], $fullPath)) {
            throw new Exception('Failed to move uploaded file.');
        }

        return "uploads/$datePath/$name"; // relative path
    }

    private function saveToDatabase(string $path, string $alt, ?int $projectId): void
    {
        $stmt = $this->db->prepare(
            'INSERT INTO images (path, alt, project_id)
             VALUES (:path, :alt, :project_id)'
        );
        $stmt->execute([
            ':path' => $path,
            ':alt' => htmlspecialchars($alt, ENT_QUOTES, 'UTF-8'),
            ':project_id' => $projectId,
        ]);
    }

    // Helper to log an error and return false
    private function fail(string $msg): bool
    {
        $this->errors[] = $msg;
        return false;
    }
}
