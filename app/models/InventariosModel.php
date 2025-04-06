<?php

class InventariosModel
{
    private $db;

    public function __construct()
    {
        $this->db = include(__DIR__ . '/../../config/db.php');

        if (!$this->db) {
            die("Error: Conexión a la base de datos no establecida.");
        }
    }

    public function buscarInventarios($nombre = null)
    {
        $query = "SELECT * FROM inventario WHERE 1=1";
        if ($nombre) {
            $query .= " AND nombre LIKE ?";
        }
        $stmt = $this->db->prepare($query);
        $params = [];
        $types = '';
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
    public function obtenerInventarios()
    {
        $query = "SELECT * FROM inventario";
        $result = $this->db->query($query);
        if ($result) {
            $inventarios = [];
            while ($row = $result->fetch_assoc()) {
                $inventarios[] = $row;
            }
            return $inventarios;
        } else {
            return "Error: " . $this->db->error;
        }
    }

    public function obtenerInventarioPorId($id)
    {
        if (empty($id)) {
            return "El ID del inventario es obligatorio.";
        }

        $query = "SELECT * FROM inventario WHERE id = ?";

        $stmt = $this->db->prepare($query);

        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $inventario = $result->fetch_assoc();

            if ($inventario) {
                return $inventario;
            } else {
                return "Inventario no encontrado.";
            }
        } else {
            return "Error: " . $this->db->error;
        }
    }

    public function agregarInventario($nombre, $descripcion, $cantidad, $fecha)
    {
        $query = "INSERT INTO inventario (nombre, descripcion, cantidad, fechaAdquisicion) VALUES (?, ?, ?, ?)";

        $stmt = $this->db->prepare($query);

        $stmt->bind_param("ssis", $nombre, $descripcion, $cantidad, $fecha);

        if ($stmt->execute()) {
            return "Nuevo inventario agregado exitosamente";
        } else {
            return "Error: " . $this->db->error;
        }
    }

    public function actualizarInventario($id, $nombre, $descripcion, $cantidad, $fecha)
    {
        if (empty($id)) {
            return "El ID del inventario es obligatorio.";
        }

        $query = "UPDATE inventario SET nombre = ?, descripcion = ?, cantidad = ?, fechaAdquisicion = ? WHERE id = ?";

        $stmt = $this->db->prepare($query);

        $stmt->bind_param("ssisi", $nombre, $descripcion, $cantidad, $fecha, $id);

        if ($stmt->execute()) {
            return "Inventario actualizado exitosamente";
        } else {
            return "Error: " . $this->db->error;
        }
    }

    public function eliminarInventario($id)
    {
        if (empty($id)) {
            return "El ID del inventario es obligatorio.";
        }

        $query = "DELETE FROM inventario WHERE id = ?";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            return "Inventario eliminado exitosamente";
        } else {
            return "Error: " . $this->db->error;
        }
    }
}
