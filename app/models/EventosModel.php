<?php

class EventosModel
{
    private $db;

    public function __construct()
    {
        $this->db = include(__DIR__ . '/../../config/db.php');
        if (!$this->db) {
            die("Error: Conexión a la base de datos no establecida.");
        }
    }

    public function obtenerEventos()
    {
        $query = "SELECT * FROM eventos";
        $result = $this->db->query($query);

        if ($result) {
            $eventos = [];
            while ($row = $result->fetch_assoc()) {
                $eventos[] = $row;
            }
            return $eventos;
        } else {
            return "Error: " . $this->db->error;
        }
    }
    public function obtenerEventoPorId($id)
    {

        $query = "SELECT * FROM eventos WHERE id = ?";
        $stmt = $this->db->prepare($query);
        if ($stmt) {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                return $result->fetch_assoc();
            } else {
                return "No se encontró el curso.";
            }
        } else {
            return "Error: " . $this->db->error;
        }
    }

    public function buscarEventos($titulo = null, $descripcion = null, $categoria = null)
    {
        $query = "SELECT * FROM eventos WHERE 1=1";
        if ($titulo) {
            $query .= " AND titulo LIKE ?";
        }
        if ($descripcion) {
            $query .= " AND descripcion LIKE ?";
        }
        if ($categoria) {
            $query .= " AND categoria LIKE ?";
        }

        $stmt = $this->db->prepare($query);

        $params = [];
        $types = '';
        if ($titulo) {
            $params[] = "%$titulo%";
            $types .= 's';
        }
        if ($descripcion) {
            $params[] = "%$descripcion%";
            $types .= 's';
        }
        if ($categoria) {
            $params[] = "%$categoria%";
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


    public function agregarEventos($titulo, $descripcion, $precio, $docente, $imagen, $categoria, $fechaInicio, $fechaFin, $mostrarInicio = 0)
    {
        $query = "INSERT INTO eventos (titulo, descripcion, precio,imagen, docente, categoria,fechaInicio, fechaFin, mostrarInicio) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ssssssssi", $titulo, $descripcion, $precio, $imagen, $docente, $categoria, $fechaInicio, $fechaFin, $mostrarInicio);
        if ($stmt->execute()) {
            return "Nuevo curso agregado exitosamente";
        } else {
            return "Error: " . $this->db->error;
        }
    }


    public function actualizarEvento($id, $titulo, $descripcion, $precio, $docente, $categoria, $newImagen, $fechaInicio, $fechaFin, $mostrarInicio)
    {

        $query = "UPDATE eventos SET titulo = ?, descripcion = ?, precio = ?, imagen = ?, docente = ?, categoria = ?,fechaInicio = ?,fechaFin = ?,mostrarInicio = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ssssssssss", $titulo, $descripcion, $precio, $newImagen, $docente, $categoria, $fechaInicio, $fechaFin, $mostrarInicio, $id);
        if ($stmt->execute()) {
            return "Evento actualizado exitosamente";
        } else {
            return "Error: " . $this->db->error;
        }
    }


    public function eliminarEvento($id)
    {
        $query = "DELETE FROM eventos WHERE id = ?";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            return "Evento eliminado exitosamente";
        } else {
            return "Error: " . $this->db->error;
        }
    }
    public function obtenetCategorias()
    {

        $query = "SELECT categoria
                    FROM eventos GROUP BY categoria;";
        $stmt = $this->db->prepare($query);
        if ($stmt) {
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                return $result->fetch_assoc();
            } else {
                return "No se encontró el curso.";
            }
        } else {
            return "Error: " . $this->db->error;
        }
    }
}
