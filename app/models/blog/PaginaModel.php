<?php

class PaginasModel
{
    private $db;

    public function __construct()
    {
        $this->db = include(__DIR__ . '/../../../config/db.php');

        if (!$this->db) {
            die("Error: Conexión a la base de datos no establecida.");
        }
    }

    public function obtenerPages()
    {
        $query = "SELECT * FROM pages";
        $result = $this->db->query($query);

        if ($result) {
            $pages = [];
            while ($row = $result->fetch_assoc()) {
                $pages[] = $row;
            }
            return $pages;
        } else {
            return "Error: " . $this->db->error;
        }
    }

    public function cantidadPages()
    {
        $query = "SELECT COUNT(*) AS cantidad FROM pages";
        $result = $this->db->query($query);

        if ($result) {
            $row = $result->fetch_assoc();
            return $row['cantidad']; // Devuelve el número total de páginas
        } else {
            return "Error: " . $this->db->error;
        }
    }


    public function obtenerPagePorId($id)
    {
        if (empty($id)) {
            return "El ID de la página es obligatorio.";
        }

        $query = "SELECT * FROM pages WHERE PageId = ?";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $page = $result->fetch_assoc();

            if ($page) {
                return $page;
            } else {
                return "Página no encontrada.";
            }
        } else {
            return "Error: " . $this->db->error;
        }
    }

    public function agregarPage($MenuId, $SortNumber)
    {
        $query = "INSERT INTO pages (MenuId, SortNumber) VALUES (?, ?)";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ii", $MenuId, $SortNumber);

        if ($stmt->execute()) {
            return "Nueva página agregada exitosamente";
        } else {
            return "Error: " . $this->db->error;
        }
    }

    public function actualizarPage($id, $MenuId, $SortNumber)
    {
        if (empty($id)) {
            return "El ID de la página es obligatorio.";
        }

        $query = "UPDATE pages SET MenuId = ?, SortNumber = ? WHERE PageId = ?";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("iii", $MenuId, $SortNumber, $id);

        if ($stmt->execute()) {
            return "Página actualizada exitosamente";
        } else {
            return "Error: " . $this->db->error;
        }
    }

    public function eliminarPage($id)
    {
        if (empty($id)) {
            return "El ID de la página es obligatorio.";
        }

        $query = "DELETE FROM pages WHERE PageId = ?";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            return "Página eliminada exitosamente";
        } else {
            return "Error: " . $this->db->error;
        }
    }
}
