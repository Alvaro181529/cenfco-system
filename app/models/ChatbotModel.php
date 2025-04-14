<?php

class ChatbotModel
{
    private $db;

    public function __construct()
    {
        $this->db = include(__DIR__ . '/../../config/db.php');

        if (!$this->db) {
            die("Error: Conexión a la base de datos no establecida.");
        }
    }

    // Obtener todos los mensajes
    public function obtenerMensajes()
    {
        $query = "SELECT * FROM chatbot ORDER BY create_at DESC";
        $result = $this->db->query($query);
        if ($result) {
            $mensajes = [];
            while ($row = $result->fetch_assoc()) {
                $mensajes[] = $row;
            }
            return $mensajes;
        } else {
            return "Error: " . $this->db->error;
        }
    }

    // Buscar mensaje por contenido
    public function buscarMensaje($contenido)
    {
        $query = "SELECT * FROM chatbot WHERE mensaje LIKE ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", "%$contenido%");

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return "Error: " . $this->db->error;
        }
    }
    // Buscar mensaje por contenido
    public function responderMensaje($mensaje)
    {
        $query = "SELECT * FROM chatbot WHERE MATCH(contenido, mensaje) AGAINST(?)";
        $stmt = $this->db->prepare($query);

        // Usamos una variable intermedia para asegurar que se pase por referencia
        $searchTerm = "%$mensaje%";

        // Pasamos la variable intermedia por referencia
        $stmt->bind_param("s", $searchTerm);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return "Error: " . $this->db->error;
        }
    }



    // Agregar un nuevo mensaje
    public function agregarMensaje($mensaje, $contenido)
    {
        $query = "INSERT INTO chatbot (mensaje, contenido) VALUES (?, ?)";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ss", $mensaje, $contenido);

        if ($stmt->execute()) {
            return "Nuevo mensaje agregado exitosamente.";
        } else {
            return "Error: " . $this->db->error;
        }
    }
    public function obtenerChatPorId($id)
    {
        if (empty($id)) {
            return "El ID del chatbot es obligatorio.";
        }

        $query = "SELECT * FROM chatbot WHERE id = ?";

        $stmt = $this->db->prepare($query);

        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $chatbot = $result->fetch_assoc();

            if ($chatbot) {
                return $chatbot;
            } else {
                return "Inventario no encontrado.";
            }
        } else {
            return "Error: " . $this->db->error;
        }
    }


    // Actualizar un mensaje
    public function actualizarMensaje($id, $mensaje, $contenido)
    {
        if (empty($id)) {
            return "El ID del mensaje es obligatorio.";
        }

        $query = "UPDATE chatbot SET mensaje = ?, contenido = ? WHERE id = ?";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ssi", $mensaje, $contenido, $id);

        if ($stmt->execute()) {
            return "Mensaje actualizado exitosamente";
        } else {
            return "Error: " . $this->db->error;
        }
    }

    // Eliminar un mensaje
    public function eliminarMensaje($id)
    {
        if (empty($id)) {
            return "El ID del mensaje es obligatorio.";
        }

        $query = "DELETE FROM chatbot WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            return "Mensaje eliminado exitosamente";
        } else {
            return "Error: " . $this->db->error;
        }
    }
}
