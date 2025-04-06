<?php

class AuthModel
{
    private $db;

    public function __construct()
    {
        $this->db = include(__DIR__ . '/../../config/db.php');
        if (!$this->db) {
            die("Error: Conexión a la base de datos no establecida.");
        }
    }

    public function loginUser($correo, $password)
    {
        $user = $this->getUserByEmail($correo);
        if ($user && password_verify($password,  $user['password'])) {
            $_SESSION['user'] = $user;
            return $user;
        } else {
            return false;
        }

        return false;
    }

    public function getUserByEmail($correo)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE correo = ?");

        if (!$stmt) {
            error_log("Error al preparar la consulta: " . $this->db->error);
            return false;
        }
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 0) {
            return false;
        }
        return $result->fetch_assoc();
    }

    public function registerUser($username, $password, $correo, $role = 'user')
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO users (username, password,correo, role) VALUES (?, ?, ?,?)");
        $stmt->bind_param("ssss", $username, $hashedPassword, $correo, $role);
        return $stmt->execute();
    }
}
