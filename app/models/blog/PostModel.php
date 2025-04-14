<?php

class PostsModel
{
    private $db;

    public function __construct()
    {
        $this->db = include(__DIR__ . '/../../../config/db.php');

        if (!$this->db) {
            die("Error: Conexión a la base de datos no establecida.");
        }
    }

    public function obtenerPosts()
    {
        $query = "SELECT * FROM posts";
        $result = $this->db->query($query);

        if ($result) {
            $posts = [];
            while ($row = $result->fetch_assoc()) {
                $posts[] = $row;
            }
            return $posts;
        } else {
            return "Error: " . $this->db->error;
        }
    }

    public function cantidadPosts()
    {
        $query = "SELECT COUNT(*) AS cantidad FROM posts";
        $result = $this->db->query($query);

        if ($result) {
            $row = $result->fetch_assoc();
            return $row['cantidad']; // Devuelve el número total de posts
        } else {
            return "Error: " . $this->db->error;
        }
    }

    public function obtenerPostPorId($id)
    {
        if (empty($id)) {
            return "El ID del post es obligatorio.";
        }

        $query = "SELECT * FROM posts WHERE PostId = ?";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $post = $result->fetch_assoc();

            if ($post) {
                return $post;
            } else {
                return "Post no encontrado.";
            }
        } else {
            return "Error: " . $this->db->error;
        }
    }

    public function agregarPost($PageId, $Title, $Content, $Datetime, $User, $ContentBinary)
    {
        $query = "INSERT INTO posts (PageId, Title, Content, Datetime, User, ContentBinary) VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("isssss", $PageId, $Title, $Content, $Datetime, $User, $ContentBinary);

        if ($stmt->execute()) {
            return "Nuevo post agregado exitosamente";
        } else {
            return "Error: " . $this->db->error;
        }
    }

    public function actualizarPost($id, $PageId, $Title, $Content, $Datetime, $User, $ContentBinary)
    {
        if (empty($id)) {
            return "El ID del post es obligatorio.";
        }

        $query = "UPDATE posts SET PageId = ?, Title = ?, Content = ?, Datetime = ?, User = ?, ContentBinary = ? WHERE PostId = ?";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("isssssi", $PageId, $Title, $Content, $Datetime, $User, $ContentBinary, $id);

        if ($stmt->execute()) {
            return "Post actualizado exitosamente";
        } else {
            return "Error: " . $this->db->error;
        }
    }

    public function eliminarPost($id)
    {
        if (empty($id)) {
            return "El ID del post es obligatorio.";
        }

        $query = "DELETE FROM posts WHERE PostId = ?";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            return "Post eliminado exitosamente";
        } else {
            return "Error: " . $this->db->error;
        }
    }
}
