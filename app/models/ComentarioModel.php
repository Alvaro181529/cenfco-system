<?php

class ComentariosModel
{
    private $db;

    public function __construct()
    {
        $this->db = include(__DIR__ . '/../../config/db.php');

        if (!$this->db) {
            die("Error: Conexión a la base de datos no establecida.");
        }
    }

    // Método para buscar comentarios por asunto o por nombre
    public function buscarComentarios($asunto = null, $nombre = null)
    {
        $query = "SELECT * FROM comentario WHERE 1=1";
        if ($asunto) {
            $query .= " AND asunto LIKE ?";
        }
        if ($nombre) {
            $query .= " AND nombre LIKE ?";
        }

        $stmt = $this->db->prepare($query);
        $params = [];
        $types = '';

        if ($asunto) {
            $params[] = "%$asunto%";
            $types .= 's';
        }

        if ($nombre) {
            $params[] = "%$nombre%";
            $types .= 's';
        }

        if ($params) {
            $stmt->bind_param($types, ...$params);
        }

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return "Error: " . $this->db->error;
        }
    }

    // Método para obtener todos los comentarios
    public function obtenerComentarios()
    {
        $query = "SELECT * FROM comentario";
        $result = $this->db->query($query);

        if ($result) {
            $comentarios = [];
            while ($row = $result->fetch_assoc()) {
                $comentarios[] = $row;
            }
            return $comentarios;
        } else {
            return "Error: " . $this->db->error;
        }
    }

    // Método para obtener un comentario por ID
    public function obtenerComentarioPorId($id)
    {
        if (empty($id)) {
            return "El ID del comentario es obligatorio.";
        }

        $query = "SELECT * FROM comentario WHERE id = ?";
        $stmt = $this->db->prepare($query);

        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $comentario = $result->fetch_assoc();

            if ($comentario) {
                return $comentario;
            } else {
                return "Comentario no encontrado.";
            }
        } else {
            return "Error: " . $this->db->error;
        }
    }

    // Método para agregar un nuevo comentario
    public function agregarComentario($nombre, $correo, $asunto, $mensaje)
    {
        $query = "INSERT INTO comentario (nombre, correo, asunto, mensaje) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);

        $stmt->bind_param("ssss", $nombre, $correo, $asunto, $mensaje);

        if ($stmt->execute()) {
            return "Nuevo comentario agregado exitosamente";
        } else {
            return "Error: " . $this->db->error;
        }
    }

    // Método para actualizar un comentario
    public function actualizarComentario($id, $nombre, $correo, $asunto, $mensaje)
    {
        if (empty($id)) {
            return "El ID del comentario es obligatorio.";
        }

        $query = "UPDATE comentario SET nombre = ?, correo = ?, asunto = ?, mensaje = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);

        $stmt->bind_param("ssssi", $nombre, $correo, $asunto, $mensaje, $id);

        if ($stmt->execute()) {
            return "Comentario actualizado exitosamente";
        } else {
            return "Error: " . $this->db->error;
        }
    }

    // Método para eliminar un comentario
    public function eliminarComentario($id)
    {
        if (empty($id)) {
            return "El ID del comentario es obligatorio.";
        }

        $query = "DELETE FROM comentario WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            return "Comentario eliminado exitosamente";
        } else {
            return "Error: " . $this->db->error;
        }
    }
}
