<?php

class ReportesModel
{
    private $db;

    public function __construct()
    {
        $this->db = include(__DIR__ . '/../../config/db.php');

        if (!$this->db) {
            die("Error: Conexión a la base de datos no establecida.");
        }
    }

    public function certificadosReportes($fechaInicio, $fechaFin)
    {
        $query = "SELECT * FROM certificados WHERE 1=1";

        if ($fechaInicio && $fechaFin) {
            $query .= " AND create_at BETWEEN ? AND ?";
        }

        $stmt = $this->db->prepare($query);
        $params = [];
        $types = '';

        if ($fechaInicio && $fechaFin) {
            $params[] = $fechaInicio;
            $params[] = $fechaFin;
            $types .= 'ss';
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
    public function inventariosReportes($fechaInicio = null, $fechaFin = null)
    {
        $query = "SELECT * FROM inventario WHERE 1=1";

        if ($fechaInicio && $fechaFin) {
            $query .= " AND create_at BETWEEN ? AND ?";
        }

        $stmt = $this->db->prepare($query);
        $params = [];
        $types = '';

        if ($fechaInicio && $fechaFin) {
            $params[] = $fechaInicio;
            $params[] = $fechaFin;
            $types .= 'ss';
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
    public function estudiantesReportes($fechaInicio = null, $fechaFin = null)
    {
        $query = "SELECT * FROM estudiantes WHERE 1=1";

        if ($fechaInicio && $fechaFin) {
            $query .= " AND create_at BETWEEN ? AND ?";
        }

        $stmt = $this->db->prepare($query);
        $params = [];
        $types = '';

        if ($fechaInicio && $fechaFin) {
            $params[] = $fechaInicio;
            $params[] = $fechaFin;
            $types .= 'ss';
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
    public function cursosReportes($fechaInicio = null, $fechaFin = null)
    {
        $query = "SELECT * FROM cursos WHERE 1=1";

        if ($fechaInicio && $fechaFin) {
            $query .= " AND create_at BETWEEN ? AND ?";
        }

        $stmt = $this->db->prepare($query);
        $params = [];
        $types = '';

        if ($fechaInicio && $fechaFin) {
            $params[] = $fechaInicio;
            $params[] = $fechaFin;
            $types .= 'ss';
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
    public function docentesReportes($fechaInicio = null, $fechaFin = null)
    {
        $query = "SELECT * FROM docentes WHERE 1=1";

        if ($fechaInicio && $fechaFin) {
            $query .= " AND create_at BETWEEN ? AND ?";
        }

        $stmt = $this->db->prepare($query);
        $params = [];
        $types = '';

        if ($fechaInicio && $fechaFin) {
            $params[] = $fechaInicio;
            $params[] = $fechaFin;
            $types .= 'ss';
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
    public function ventasReportes($fechaInicio, $fechaFin, $tipo = null, $user = null)
    {
        $query = "SELECT * FROM ventas WHERE 1=1";
        $params = [];
        $types = '';

        // Orden: primero user
        if ($user) {
            $query .= " AND user LIKE ?";
            $params[] = "%" . $user . "%";
            $types .= 's';
        }

        // Luego tipo
        if ($tipo) {
            $query .= " AND tipo LIKE ?";
            $params[] = "%" . $tipo . "%";
            $types .= 's';
        }

        // Luego fechas
        if ($fechaInicio && $fechaFin) {
            $query .= " AND created_at BETWEEN ? AND ?";
            $params[] = $fechaInicio;
            $params[] = $fechaFin;
            $types .= 'ss';
        }

        $stmt = $this->db->prepare($query);

        if ($params) {
            $stmt->bind_param($types, ...$params);
        }

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $ventas = [];

            while ($row = $result->fetch_assoc()) {
                $ventas[] = $row;
            }

            return $ventas;
        } else {
            return "Error: " . $this->db->error;
        }
    }

    public function obtenerReportesVenta()
    {
        $query = "SELECT * FROM ventas";
        $result = $this->db->query($query);
        if ($result) {
            $certificados = [];
            while ($row = $result->fetch_assoc()) {
                $certificados[] = $row;
            }
            return $certificados;
        } else {
            return "Error: " . $this->db->error;
        }
    }
}
