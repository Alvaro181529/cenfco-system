<?php

class CursosModel
{
    private $db;

    public function __construct()
    {
        $this->db = include(__DIR__ . '/../../config/db.php');
        if (!$this->db) {
            die("Error: Conexión a la base de datos no establecida.");
        }
    }
    public function obtenerCursos($titulo = null, $descripcion = null, $categoria = null, $pagina = 1, $resultadosPorPagina = 10)
    {
        // Validación de parámetros para la paginación
        if (!is_int($pagina) || $pagina <= 0) {
            return "Error: El parámetro 'pagina' debe ser un número entero mayor que 0.";
        }
    
        if (!is_int($resultadosPorPagina) || $resultadosPorPagina <= 0) {
            return "Error: El parámetro 'resultadosPorPagina' debe ser un número entero mayor que 0.";
        }
    
        // Calculamos el offset para la paginación
        $offset = ($pagina - 1) * $resultadosPorPagina;
    
        // Iniciar la consulta base
        $query = "SELECT * FROM cursos WHERE 1=1";
    
        // Agregar los filtros de búsqueda si se proporcionan
        if ($titulo) {
            $query .= " AND titulo LIKE ?";
        }
        if ($descripcion) {
            $query .= " AND descripcion LIKE ?";
        }
        if ($categoria) {
            $query .= " AND categoria LIKE ?";
        }
    
        // Agregar LIMIT y OFFSET para la paginación
        $query .= " LIMIT ? OFFSET ?";
    
        // Preparar la consulta
        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            return "Error de preparación: " . $this->db->error;
        }
    
        // Inicializar los parámetros y tipos
        $params = [];
        $types = '';
    
        // Agregar los parámetros de búsqueda
        if ($titulo) {
            $params[] = "%$titulo%";
            $types .= 's';  // 's' para string
        }
        if ($descripcion) {
            $params[] = "%$descripcion%";
            $types .= 's';  // 's' para string
        }
        if ($categoria) {
            $params[] = "%$categoria%";
            $types .= 's';  // 's' para string
        }
    
        // Agregar los parámetros para LIMIT y OFFSET
        $params[] = $resultadosPorPagina;
        $params[] = $offset;
        $types .= 'ii'; // 'ii' para enteros
    
        // Crear un array de referencias para bind_param
        $paramsRef = [];
        foreach ($params as $key => $param) {
            $paramsRef[$key] = &$params[$key];
        }
    
        // Vinculamos los parámetros por referencia
        $stmt->bind_param($types, ...$paramsRef);
    
        // Ejecutamos la consulta
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $cursos = $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return "Error al ejecutar la consulta: " . $stmt->error;
        }
    
        // Obtener el número total de cursos (para la paginación)
        $queryTotal = "SELECT COUNT(*) AS total FROM cursos WHERE 1=1";
        if ($titulo) {
            $queryTotal .= " AND titulo LIKE ?";
        }
        if ($descripcion) {
            $queryTotal .= " AND descripcion LIKE ?";
        }
        if ($categoria) {
            $queryTotal .= " AND categoria LIKE ?";
        }
    
        // Preparar la consulta para contar el total de registros
        $stmtTotal = $this->db->prepare($queryTotal);
        if (!$stmtTotal) {
            return "Error de preparación para total: " . $this->db->error;
        }
    
        // Preparar los parámetros para contar el total
        $paramsTotal = [];
        if ($titulo) {
            $paramsTotal[] = "%$titulo%";
        }
        if ($descripcion) {
            $paramsTotal[] = "%$descripcion%";
        }
        if ($categoria) {
            $paramsTotal[] = "%$categoria%";
        }
    
        // Crear un array de referencias para bind_param
        $paramsRefTotal = [];
        foreach ($paramsTotal as $key => $param) {
            $paramsRefTotal[$key] = &$paramsTotal[$key];
        }
    
        // Vinculamos los parámetros por referencia para la consulta de total
        if ($paramsTotal) {
            $stmtTotal->bind_param(str_repeat('s', count($paramsTotal)), ...$paramsRefTotal);
        }
    
        // Ejecutamos la consulta para obtener el total de cursos
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
    
    public function obtenerCursoPorId($id)
    {

        $query = "SELECT * FROM cursos WHERE id = ?";
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


    public function agregarCursos($titulo, $descripcion, $precio, $docente, $imagen, $categoria, $fechaInicio, $fechaFin, $mostrarInicio = 0)
    {
        $query = "INSERT INTO cursos (titulo, descripcion, precio,imagen, docente, categoria,fechaInicio, fechaFin, mostrarInicio) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ssssssssi", $titulo, $descripcion, $precio, $imagen, $docente, $categoria, $fechaInicio, $fechaFin, $mostrarInicio);
        if ($stmt->execute()) {
            return "Nuevo curso agregado exitosamente";
        } else {
            return "Error: " . $this->db->error;
        }
    }


    public function actualizarCurso($id, $titulo, $descripcion, $precio, $docente, $categoria, $newImagen, $fechaInicio, $fechaFin, $mostrarInicio)
    {

        $query = "UPDATE cursos SET titulo = ?, descripcion = ?, precio = ?, imagen = ?, docente = ?, categoria = ?,fechaInicio = ?,fechaFin = ?,mostrarInicio = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ssssssssss", $titulo, $descripcion, $precio, $newImagen, $docente, $categoria, $fechaInicio, $fechaFin, $mostrarInicio, $id);
        if ($stmt->execute()) {
            return "Curso actualizado exitosamente";
        } else {
            return "Error: " . $this->db->error;
        }
    }


    public function eliminarCurso($id)
    {
        $query = "DELETE FROM cursos WHERE id = ?";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            return "Curso eliminado exitosamente";
        } else {
            return "Error: " . $this->db->error;
        }
    }
    public function obtenetCategorias()
    {

        $query = "SELECT categoria
                    FROM cursos GROUP BY categoria;";
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
