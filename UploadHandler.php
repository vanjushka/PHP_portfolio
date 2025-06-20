<?php

class UploadHandler
{
    private $db;
    public array $errors = [];

    private array $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
    private int $maxSize = 2 * 1024 * 1024; // 2 MB

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function upload(array $file, string $altText, ?int $projectId = null): string
    {
        if (!isset($file['tmp_name'], $file['name'], $file['error'], $file['size'])) {
            $this->errors[] = "Missing file data.";
            return '';
        }

        $valid = true;
        $valid &= $this->checkUploadError($file['error']);
        $valid &= $this->validateAltText($altText);

        if ($file['error'] === UPLOAD_ERR_OK) {
            $valid &= $this->validateMime($file['tmp_name']);
            $valid &= $this->validateSize($file['size']);
        }

        if (!$valid) {
            return '';
        }

        try {
            $relativePath = $this->moveFile($file);
            $this->saveToDatabase($relativePath, $altText, $projectId);  // Pass projectId here
            return $relativePath;
        } catch (Exception $e) {
            $this->errors[] = "Error while saving the file.";
            return '';
        }
    }

    public function getAllImages(): array
    {
        $stmt = $this->db->query("SELECT * FROM images ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function validateAltText(string $text): bool
    {
        if (!is_string($text)) {
            $this->errors[] = "Alt text must be a string.";
            return false;
        }

        if (empty(trim($text)) || strlen($text) > 255) {
            $this->errors[] = "Alt text is either empty or too long (max 255 characters).";
            return false;
        }

        return true;
    }

    private function checkUploadError(int $errorCode): bool
    {
        switch ($errorCode) {
            case UPLOAD_ERR_OK:
                return true;
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                $this->errors[] = "Image too large. Maximum 2MB allowed.";
                return false;
            case UPLOAD_ERR_NO_FILE:
                $this->errors[] = "No file was uploaded.";
                return false;
            default:
                $this->errors[] = "Unknown upload error (code: $errorCode).";
                return false;
        }
    }

    private function validateMime(string $tmpPath): bool
    {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $tmpPath);
        finfo_close($finfo);

        if (!in_array($mime, $this->allowedTypes)) {
            $this->errors[] = "Invalid file type. Only JPG, PNG, and WebP are allowed.";
            return false;
        }

        return true;
    }

    private function validateSize(int $size): bool
    {
        if ($size > $this->maxSize) {
            $this->errors[] = "File is too large. Maximum 2MB allowed.";
            return false;
        }

        return true;
    }

    private function moveFile(array $file): string
    {
        $datePath = date('Y/m/d');
        $uploadDir = __DIR__ . "/uploads/$datePath";

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0775, true);
        }

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $safeName = uniqid('', true) . '.' . strtolower($extension);
        $targetPath = "$uploadDir/$safeName";

        if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
            throw new Exception("Error while moving the uploaded file.");
        }

        return "uploads/$datePath/$safeName";
    }

    private function saveToDatabase(string $path, string $alt, ?int $projectId): void
    {
        $stmt = $this->db->prepare("INSERT INTO images (path, alt, project_id) VALUES (:path, :alt, :project_id)");
        $stmt->execute([
            ':path' => $path,
            ':alt' => htmlspecialchars($alt, ENT_QUOTES, 'UTF-8'),
            ':project_id' => $projectId,
        ]);
    }
}
