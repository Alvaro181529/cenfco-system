<?php

class MenusModel
{
    private $db;

    public function __construct()
    {
        $this->db = include(__DIR__ . '/../../../config/db.php');

        if (!$this->db) {
            die("Error: Conexión a la base de datos no establecida.");
        }
    }

    public function obtenerMenus()
    {
        $query = "SELECT * FROM menus";
        $result = $this->db->query($query);

        if ($result) {
            $menus = [];
            while ($row = $result->fetch_assoc()) {
                $menus[] = $row;
            }
            return $menus;
        } else {
            return "Error: " . $this->db->error;
        }
    }
    public function cantidadMenus()
    {
        $query = "SELECT COUNT(*) AS cantidad FROM menus";
        $result = $this->db->query($query);

        if ($result) {
            $row = $result->fetch_assoc();
            return $row['cantidad']; // Devuelve el número total de menús
        } else {
            return "Error: " . $this->db->error;
        }
    }


    public function obtenerMenuPorId($id)
    {
        if (empty($id)) {
            return "El ID del menú es obligatorio.";
        }

        $query = "SELECT * FROM menus WHERE MenuId = ?";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $menu = $result->fetch_assoc();

            if ($menu) {
                return $menu;
            } else {
                return "Menú no encontrado.";
            }
        } else {
            return "Error: " . $this->db->error;
        }
    }

    public function agregarMenu($MenuNameEnglish, $SortNumber)
    {
        $query = "INSERT INTO menus (MenuNameEnglish, SortNumber) VALUES (?, ?)";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("si", $MenuNameEnglish, $SortNumber);

        if ($stmt->execute()) {
            return "Nuevo menú agregado exitosamente";
        } else {
            return "Error: " . $this->db->error;
        }
    }

    public function actualizarMenu($id, $MenuNameEnglish, $SortNumber)
    {
        if (empty($id)) {
            return "El ID del menú es obligatorio.";
        }

        $query = "UPDATE menus SET MenuNameEnglish = ?, SortNumber = ? WHERE MenuId = ?";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("sii", $MenuNameEnglish, $SortNumber, $id);

        if ($stmt->execute()) {
            return "Menú actualizado exitosamente";
        } else {
            return "Error: " . $this->db->error;
        }
    }

    public function eliminarMenu($id)
    {
        if (empty($id)) {
            return "El ID del menú es obligatorio.";
        }

        $query = "DELETE FROM menus WHERE MenuId = ?";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            return "Menú eliminado exitosamente";
        } else {
            return "Error: " . $this->db->error;
        }
    }
}
