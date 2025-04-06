<?php

class UsuariosModel
{
    private $db;

    public function __construct()
    {
        $this->db = include(__DIR__ . '/../../config/db.php');

        if (!$this->db) {
            die("Error: Conexión a la base de datos no establecida.");
        }
    }
    public function buscarUsuarios($searchTerm)
    {
        // Evitar SQL Injection usando preparación de sentencias
        $query = "SELECT * FROM users WHERE username LIKE ? OR correo LIKE ?";
        $stmt = $this->db->prepare($query);

        // Escapar el término de búsqueda para agregarlo en la consulta LIKE
        $searchTerm = "%" . $searchTerm . "%";
        $stmt->bind_param("ss", $searchTerm, $searchTerm);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $usuarios = [];
            while ($row = $result->fetch_assoc()) {
                $usuarios[] = $row;
            }
            return $usuarios; // Devuelve un array de usuarios que coinciden con la búsqueda
        } else {
            return "Error: " . $this->db->error;
        }
    }
    public function obtenerUsuarios()
    {
        $query = "SELECT * FROM users";
        $result = $this->db->query($query);
        if ($result) {
            $usuarios = [];
            while ($row = $result->fetch_assoc()) {
                $usuarios[] = $row;
            }
            return $usuarios;
        } else {
            return "Error: " . $this->db->error;
        }
    }

    public function obtenerUsuariosPorId($id)
    {
        if (empty($id)) {
            return "El ID del usuarios es obligatorio.";
        }

        $query = "SELECT * FROM users WHERE id = ?";

        $stmt = $this->db->prepare($query);

        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $usuarios = $result->fetch_assoc();
            if ($usuarios) {
                return $usuarios;
            } else {
                return "Usuarios no encontrado.";
            }
        } else {
            return "Error: " . $this->db->error;
        }
    }

    public function agregarUsuarios($username, $correo, $rol, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO users (username, correo,password, role) VALUES (?, ?,?, ?)";

        $stmt = $this->db->prepare($query);

        $stmt->bind_param("ssss", $username, $correo,$hashedPassword, $rol);

        if ($stmt->execute()) {
            return "Nuevo usuarios agregado exitosamente";
        } else {
            return "Error: " . $this->db->error;
        }
    }

    public function actualizarUsuarios($id, $username, $correo, $rol)
    {
        if (empty($id)) {
            return "El ID del usuarios es obligatorio.";
        }

        $query = "UPDATE users SET username = ?, correo = ?, role = ? WHERE id = ?";

        $stmt = $this->db->prepare($query);

        $stmt->bind_param("sssi", $username, $correo, $rol, $id);

        if ($stmt->execute()) {
            return "Usuarios actualizado exitosamente";
        } else {
            return "Error: " . $this->db->error;
        }
    }

    public function eliminarUsuarios($id)
    {
        if (empty($id)) {
            return "El ID del usuarios es obligatorio.";
        }

        $query = "DELETE FROM users WHERE id = ?";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            return "Usuarios eliminado exitosamente";
        } else {
            return "Error: " . $this->db->error;
        }
    }
}
