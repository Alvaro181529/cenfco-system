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
    public function obtenerCertificados($titulo = null, $pagina = 1, $resultadosPorPagina = 10)
    {
        $offset = ($pagina - 1) * $resultadosPorPagina;

        $query = "SELECT * FROM certificados WHERE 1=1";

        if ($titulo) {
            $query .= " AND titulo LIKE ?";
        }

        $query .= " LIMIT ? OFFSET ?";

        $stmt = $this->db->prepare($query);

        $params = [];
        $types = '';

        if ($titulo) {
            $params[] = "%$titulo%";
            $types .= 's';
        }

        $params[] = $resultadosPorPagina;
        $params[] = $offset;
        $types .= 'ii';
        $stmt->bind_param($types, ...$params);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $certificados = $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return "Error: " . $this->db->error;
        }

        $queryTotal = "SELECT COUNT(*) AS total FROM certificados WHERE 1=1";
        if ($titulo) {
            $queryTotal .= " AND titulo LIKE ?";
        }
        
        $stmtTotal = $this->db->prepare($queryTotal);
        
        // Si hay un título, bind_param
        if ($titulo) {
            $likeTitulo = "%$titulo%";
            $stmtTotal->bind_param('s', $likeTitulo);
        }
        
        if ($stmtTotal->execute()) {
            $resultTotal = $stmtTotal->get_result();
            $totalCertificados = $resultTotal->fetch_assoc()['total'];
        } else {
            return "Error: " . $this->db->error;
        }
        
        // Calcular el total de páginas
        $totalPaginas = ceil($totalCertificados / $resultadosPorPagina);
        
        return [
            'certificados' => $certificados,
            'totalCertificados' => $totalCertificados,
            'totalPaginas' => $totalPaginas,
            'paginaActual' => $pagina
        ];
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
                return $certificado;
            } else {
                return "Certificado no encontrado.";
            }
        } else {
            return "Error: " . $this->db->error;
        }
    }

    public function agregarCertificado($titulo, $precioIndividual, $precioCurso, $descripcion, $fecha = null)
    {
        if (empty($fecha)) {
            $fecha = date('Y-m-d');
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
