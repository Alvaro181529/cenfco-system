<?php

class CertificadosModel
{
    private $db;

    public function __construct()
    {
        $this->db = include(__DIR__ . '/../../config/db.php');

        if (!$this->db) {
            die("Error: Conexión a la base de datos no establecida.");
        }
    }

    public function buscarCertificados($titulo = null)
    {
        $query = "SELECT * FROM certificados WHERE 1=1";
        if ($titulo) {
            $query .= " AND titulo LIKE ?";
        }
        $stmt = $this->db->prepare($query);
        $params = [];
        $types = '';
        if ($titulo) {
            $params[] = "%$titulo%";
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
    public function obtenerCertificados()
    {
        $query = "SELECT * FROM certificados";
        $result = $this->db->query($query);  // Aquí ahora puedes usar $this->db

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
    public function obtenerCertificadoPorId($id)
    {
        if (empty($id)) {
            return "El ID del certificado es obligatorio.";
        }

        $query = "SELECT * FROM certificados WHERE id = ?";

        $stmt = $this->db->prepare($query);

        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $certificado = $result->fetch_assoc();

            if ($certificado) {
                return $certificado; // Retornar los detalles del certificado
            } else {
                return "Certificado no encontrado.";
            }
        } else {
            return "Error: " . $this->db->error;
        }
    }

    public function agregarCertificado($titulo, $precioIndividual, $precioCurso, $descripcion, $fecha = null)
    {
        error_log("esto es nuevo certificado");
        if (empty($fecha)) {
            $fecha = date('Y-m-d'); // Esto devuelve la fecha actual en formato '2025-03-06' (por ejemplo)
        }
        $query = "INSERT INTO certificados (titulo, precioIndividual, precioCurso, descripcion, fechaEmision) VALUES (?, ?, ?, ?,?)";

        $stmt = $this->db->prepare($query);

        $stmt->bind_param("sssss", $titulo, $precioIndividual, $precioCurso, $descripcion, $fecha);

        if ($stmt->execute()) {
            return "Nuevo certificado agregado exitosamente";
        } else {
            return "Error: " . $this->db->error;
        }
    }
    public function actualizarCertificado($id, $titulo, $precioIndividual, $precioCurso, $descripcion, $fecha)
    {
        if (empty($id)) {
            return "El ID del certificado es obligatorio.";
        }

        $query = "UPDATE certificados SET titulo = ?, precioIndividual = ?, precioCurso = ?, descripcion = ?, fechaEmision = ? WHERE id = ?";

        $stmt = $this->db->prepare($query);

        $stmt->bind_param("sssssi", $titulo, $precioIndividual, $precioCurso, $descripcion, $fecha, $id);

        if ($stmt->execute()) {
            return "Certificado actualizado exitosamente";
        } else {
            return "Error: " . $this->db->error;
        }
    }

    public function eliminarCertificado($id)
    {
        if (empty($id)) {
            return "El ID del certificado es obligatorio.";
        }

        $query = "DELETE FROM certificados WHERE id = ?";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            return "Certificado eliminado exitosamente";
        } else {
            return "Error: " . $this->db->error;
        }
    }
}
