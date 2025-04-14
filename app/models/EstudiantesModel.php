<?php

class EstudiantesModel
{
    private $db;

    public function __construct()
    {
        // Cargar la conexión desde db.php
        $this->db = include(__DIR__ . '/../../config/db.php');

        // Verificar si la conexión es válida
        if (!$this->db) {
            die("Error: Conexión a la base de datos no establecida.");
        }
    }
    // Obtener todos los estudiantes o buscar con filtros y aplicar paginación
    public function obtenerEstudiantes($nombre = null, $apellido = null, $carnet = null, $pagina = 1, $resultadosPorPagina = 10)
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

        // Comenzamos con la consulta base
        $query = "SELECT * FROM estudiantes WHERE 1=1"; // '1=1' es una condición siempre verdadera, útil para concatenar condiciones adicionales

        if ($nombre) {
            $query .= " AND nombres LIKE ?";
        }
        if ($apellido) {
            $query .= " AND apellidos LIKE ?";
        }
        if ($carnet) {
            $query .= " AND carnet LIKE ?";
        }

        // Agregamos los parámetros de LIMIT y OFFSET para la paginación
        $query .= " LIMIT ? OFFSET ?";

        // Preparamos la consulta
        $stmt = $this->db->prepare($query);

        // Creamos el array de parámetros y el tipo de datos para enlazar
        $params = [];
        $types = '';

        if ($nombre) {
            $params[] = "%$nombre%";
            $types .= 's'; // 's' para string
        }
        if ($apellido) {
            $params[] = "%$apellido%";
            $types .= 's';
        }
        if ($carnet) {
            $params[] = "%$carnet%";
            $types .= 's';
        }

        // Agregamos los parámetros para LIMIT y OFFSET
        $params[] = $resultadosPorPagina;
        $params[] = $offset;
        $types .= 'ii'; // 'ii' para enteros (LIMIT y OFFSET)

        // Enlazamos los parámetros si existen
        if ($params) {
            $stmt->bind_param($types, ...$params);
        }

        // Ejecutamos la consulta y obtenemos los resultados
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $estudiantes = $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return "Error: " . $this->db->error;
        }

        // Obtener el número total de estudiantes para la paginación
        $queryTotal = "SELECT COUNT(*) AS total FROM estudiantes WHERE 1=1";
        if ($nombre) {
            $queryTotal .= " AND nombres LIKE ?";
        }
        if ($apellido) {
            $queryTotal .= " AND apellidos LIKE ?";
        }
        if ($carnet) {
            $queryTotal .= " AND carnet LIKE ?";
        }

        // Preparamos la consulta para obtener el total de estudiantes
        $stmtTotal = $this->db->prepare($queryTotal);

        if ($nombre) {
            $nombreTotal = "%$nombre%";
            $stmtTotal->bind_param('s',$nombreTotal);
        }
        if ($apellido) {
            $apellidoTotal = "%$apellido%";
            $stmtTotal->bind_param('s', $apellidoTotal);
        }
        if ($carnet) {
            $carnetTotal = "%$carnet%";
            $stmtTotal->bind_param('s', $carnetTotal);
        }

        // Ejecutamos la consulta total
        $stmtTotal->execute();
        $resultTotal = $stmtTotal->get_result();
        
        if ($resultTotal) {
            $totalEstudiantes = $resultTotal->fetch_assoc()['total'];
        } else {
            return "Error al obtener el total de estudiantes: " . $this->db->error;
        }

        // Calcular el número total de páginas
        $totalPaginas = ceil($totalEstudiantes / $resultadosPorPagina);

        // Devolvemos los resultados con la paginación
        return [
            'estudiantes' => $estudiantes,
            'totalEstudiantes' => $totalEstudiantes,
            'totalPaginas' => $totalPaginas,
            'paginaActual' => $pagina
        ];
    }

    // Obtener estudiante por ID
    public function obtenerEstudiantePorId($id)
    {
        // Verificar que el ID no esté vacío
        if (empty($id)) {
            return "El ID del estudiante es obligatorio.";
        }

        // Consulta para obtener los detalles de un estudiante por su ID
        $query = "SELECT * FROM estudiantes WHERE id = ?";

        // Preparar la consulta
        $stmt = $this->db->prepare($query);

        // Enlazar el parámetro con la consulta preparada
        $stmt->bind_param("i", $id);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $estudiante = $result->fetch_assoc();

            // Verificar si se encontró un estudiante
            if ($estudiante) {
                return $estudiante; // Retornar los detalles del estudiante
            } else {
                return "Estudiante no encontrado.";
            }
        } else {
            return "Error: " . $this->db->error;
        }
    }

    // Agregar un nuevo estudiante
    public function agregarEstudiante($nombre, $apellido, $correo, $carnet, $telefono, $direccion, $foto)
    {
        // Consulta para insertar los datos en la base de datos
        $query = "INSERT INTO estudiantes (nombres, apellidos, correo, carnet, telefono, direccionDomicilio, foto) VALUES (?, ?, ?, ?, ?, ?,?)";

        // Preparar la consulta
        $stmt = $this->db->prepare($query);

        // Enlazar los parámetros con la consulta preparada
        $stmt->bind_param("sssssss", $nombre, $apellido, $correo, $carnet, $telefono, $direccion, $foto);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            return "Nuevo estudiante agregado exitosamente";
        } else {
            return "Error: " . $this->db->error;
        }
    }

    // Actualizar los datos de un estudiante
    public function actualizarEstudiante($id, $nombre, $apellido, $correo, $carnet, $telefono, $direccion, $foto)
    {
        // Verificar que el ID no esté vacío
        if (empty($id)) {
            return "El ID del estudiante es obligatorio.";
        }

        // Consulta para actualizar los datos del estudiante
        $query = "UPDATE estudiantes SET nombres = ?, apellidos = ?, correo = ?, carnet = ?, telefono = ?, direccionDomicilio = ? , foto= ? WHERE id = ?";

        // Preparar la consulta
        $stmt = $this->db->prepare($query);

        // Enlazar los parámetros con la consulta preparada
        $stmt->bind_param("sssssssi", $nombre, $apellido, $correo, $carnet, $telefono, $direccion, $foto, $id);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            return "Estudiante actualizado exitosamente";
        } else {
            return "Error: " . $this->db->error;
        }
    }

    // Eliminar un estudiante
    public function eliminarEstudiante($id)
    {
        // Verificar que el ID no esté vacío
        if (empty($id)) {
            return "El ID del estudiante es obligatorio.";
        }

        $query = "DELETE FROM estudiantes WHERE id = ?";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            return "Estudiante eliminado exitosamente";
        } else {
            return "Error: " . $this->db->error;
        }
    }
}
