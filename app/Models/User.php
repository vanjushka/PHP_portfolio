<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class User
{
    // Store PDO connection
    private PDO $db;

    // Constructor
    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    // Register new user with hashed pw

    public function register(string $username, string $email, string $password): bool
    {
        // Securely hash password
        $hash = password_hash($password, PASSWORD_DEFAULT);

        //SQL insert Statement
        $stmt = $this->db->prepare("INSERT INTO users_login (username, email, password) VALUES (:username, :email, :password)");

        // Execute
        return $stmt->execute([
            'username' => $username,
            'email' => $email,
            'password' => $hash
        ]);
    }

    // FInd user by email
    public function findByEmail(string $email): ?array
    {
        // Prepare and execute
        $stmt = $this->db->prepare("SELECT * FROM users_login WHERE email = :email");
        $stmt->execute(['email' => $email]);

        // Fetch user data
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        // return null if not found
        return $user ?: null;
    }

    // Check if passwords match
    public function verifyPassword(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }
}

