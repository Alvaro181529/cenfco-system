<?php

class HomeModel
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
        $query = "SELECT * FROM eventos WHERE mostrarInicio = '1'";
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
    public function obtenerMenu()
    {
        $query = "SELECT 
                        m.MenuNameEnglish, 
                        p.Title,
                        p.urlShort
                    FROM 
                        menus m
                    JOIN 
                        pages pg ON m.MenuId = pg.MenuId
                    JOIN 
                        posts p ON pg.PageId = p.PageId;";
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
    public function obtenerCursos($categoria = null, $titulo = null, $precio = null, $pagina = 1, $resultadosPorPagina = 10)
    {
        // Validación de parámetros para la paginación
        if (!is_int($pagina) || $pagina <= 0) {
            return "Error: El parámetro 'pagina' debe ser un número entero mayor que 0.";
        }

        if (!is_int($resultadosPorPagina) || $resultadosPorPagina <= 0) {
            return "Error: El parámetro 'resultadosPorPagina' debe ser un número entero mayor que 0.";
        }

        $offset = ($pagina - 1) * $resultadosPorPagina;

        // Consulta de cursos
        $query = "SELECT * FROM cursos WHERE mostrarInicio = '1'";

        // Agregar los filtros de búsqueda si se proporcionan
        if ($titulo) {
            $query .= " AND titulo LIKE ?";
        }
        if ($precio) {
            $query .= " AND descripcion LIKE ?";
        }
        if ($categoria) {
            $query .= " AND categoria LIKE ?";
        }

        // Agregar LIMIT y OFFSET
        $query .= " LIMIT ? OFFSET ?";

        // Preparar la consulta
        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            return "Error de preparación para cursos: " . $this->db->error;
        }

        // Crear los parámetros para bind_param
        $params = [];
        $types = '';

        if ($titulo) {
            $params[] = "%$titulo%";
            $types .= 's';
        }
        if ($precio) {
            $params[] = "%$precio%";
            $types .= 's';
        }
        if ($categoria) {
            $params[] = "%$categoria%";
            $types .= 's';
        }

        // Agregar los parámetros para LIMIT y OFFSET
        $params[] = $resultadosPorPagina;
        $params[] = $offset;
        $types .= 'ii'; // 'ii' para enteros

        // Vinculamos los parámetros por referencia
        $stmt->bind_param($types, ...$params);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $cursos = [];
            while ($row = $result->fetch_assoc()) {
                $cursos[] = $row;
            }
        } else {
            return "Error al ejecutar la consulta de cursos: " . $stmt->error;
        }

        // Consulta total de cursos
        $queryTotal = "SELECT COUNT(*) AS total FROM cursos WHERE mostrarInicio = '1'";

        // Agregar filtros de búsqueda para el conteo total
        if ($titulo) {
            $queryTotal .= " AND titulo LIKE ?";
        }
        if ($precio) {
            $queryTotal .= " AND precio LIKE ?";
        }
        if ($categoria) {
            $queryTotal .= " AND categoria LIKE ?";
        }

        // Preparar la consulta para contar el total de registros
        $stmtTotal = $this->db->prepare($queryTotal);
        if (!$stmtTotal) {
            return "Error de preparación para total: " . $this->db->error;
        }

        // Crear los parámetros para bind_param
        $paramsTotal = [];
        if ($titulo) {
            $paramsTotal[] = "%$titulo%";
        }
        if ($precio) {
            $paramsTotal[] = "%$precio%";
        }
        if ($categoria) {
            $paramsTotal[] = "%$categoria%";
        }

        // Vincular los parámetros para la consulta de total
        if ($paramsTotal) {
            $stmtTotal->bind_param(str_repeat('s', count($paramsTotal)), ...$paramsTotal);
        }

        // Ejecutar la consulta para obtener el total de cursos
        if ($stmtTotal->execute()) {
            $resultTotal = $stmtTotal->get_result();
            $totalCursos = $resultTotal->fetch_assoc()['total'];
        } else {
            return "Error al ejecutar la consulta de total: " . $stmtTotal->error;
        }

        // Calcular el número total de páginas
        $totalPaginas = ceil($totalCursos / $resultadosPorPagina);

        // Retornar los resultados y la información de la paginación
        return [
            'cursos' => $cursos,
            'totalCursos' => $totalCursos,
            'totalPaginas' => $totalPaginas,
            'paginaActual' => $pagina
        ];
    }

    public function obtenerCategorias()
    {
        $query = "SELECT categoria FROM cursos  GROUP by categoria;";
        $result = $this->db->query($query);

        if ($result) {
            $cursos = [];
            while ($row = $result->fetch_assoc()) {
                $cursos[] = $row;
            }
            return $cursos;
        } else {
            return "Error: " . $this->db->error;
        }
    }
}
