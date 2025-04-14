<?php

class DocentesModel
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
    public function obtenerDocentes($query = null, $pagina = 1, $resultadosPorPagina = 10)
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

        // Consulta base de búsqueda con filtros (si hay query) o todos los docentes
        $sql = "SELECT * FROM docentes";
        if ($query) {
            $sql .= " WHERE nombres LIKE ? OR apellidos LIKE ? OR correo LIKE ?";
        }
        $sql .= " LIMIT ? OFFSET ?";

        // Prepara la consulta
        $stmt = $this->db->prepare($sql);
        if ($stmt === false) {
            die('Error en la preparación de la consulta: ' . $this->db->error);
        }

        // Enlazamos los parámetros
        if ($query) {
            $queryParam = '%' . $query . '%'; // Para permitir la búsqueda parcial
            $stmt->bind_param('sssii', $queryParam, $queryParam, $queryParam, $resultadosPorPagina, $offset);
        } else {
            // Si no hay búsqueda, solo aplicamos paginación
            $stmt->bind_param('ii', $resultadosPorPagina, $offset);
        }

        // Ejecutamos la consulta
        $stmt->execute();

        // Obtener los resultados
        $result = $stmt->get_result();

        // Procesar los resultados
        $docentes = [];
        while ($docente = $result->fetch_assoc()) {
            $docentes[] = $docente;
        }

        // Cerrar el statement
        $stmt->close();

        // Obtener el número total de docentes para la paginación (si hay búsqueda o no)
        if ($query) {
            $sqlTotal = "SELECT COUNT(*) AS total FROM docentes WHERE nombres LIKE ? OR apellidos LIKE ? OR correo LIKE ?";
            $stmtTotal = $this->db->prepare($sqlTotal);
            $stmtTotal->bind_param('sss', $queryParam, $queryParam, $queryParam);
        } else {
            $sqlTotal = "SELECT COUNT(*) AS total FROM docentes";
            $stmtTotal = $this->db->prepare($sqlTotal);
        }

        // Ejecutar la consulta total
        $stmtTotal->execute();
        $resultTotal = $stmtTotal->get_result();

        if ($resultTotal) {
            $totalDocentes = $resultTotal->fetch_assoc()['total'];
        } else {
            return "Error al obtener el total de docentes: " . $this->db->error;
        }

        // Calcular el número total de páginas
        $totalPaginas = ceil($totalDocentes / $resultadosPorPagina);

        // Devolver los resultados con la paginación
        return [
            'docentes' => $docentes,
            'totalDocentes' => $totalDocentes,
            'totalPaginas' => $totalPaginas,
            'paginaActual' => $pagina
        ];
    }

    public function obtenerDocentePorId($id)
    {
        // Verificar que el ID no esté vacío
        if (empty($id)) {
            return "El ID del docente es obligatorio.";
        }

        // Consulta para obtener los detalles de un docente por su ID
        $query = "SELECT * FROM docentes WHERE id = ?";

        // Preparar la consulta
        $stmt = $this->db->prepare($query);

        // Enlazar el parámetro con la consulta preparada
        $stmt->bind_param("i", $id);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $docente = $result->fetch_assoc();

            // Verificar si se encontró un docente
            if ($docente) {
                return $docente; // Retornar los detalles del docente
            } else {
                return "Docente no encontrado.";
            }
        } else {
            return "Error: " . $this->db->error;
        }
    }

    public function agregarDocente($nombre, $apellido, $correo, $carnet, $telefono, $estadoCivil, $universidad, $observacion, $direccion, $imagen, $firma, $pdf)
    {
        // Consulta para insertar los datos en la base de datos
        $query = "INSERT INTO docentes (nombres, apellidos, correo, carnet, telefono, estadoCivil, universidad, observacion, direccionDomicilio, foto, firma, curriculum) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Preparar la consulta
        $stmt = $this->db->prepare($query);

        // Enlazar los parámetros con la consulta preparada
        $stmt->bind_param("ssssssssssss", $nombre, $apellido, $correo, $carnet, $telefono, $estadoCivil, $universidad, $observacion, $direccion, $imagen, $firma, $pdf);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            return "Nuevo docente agregado exitosamente";
        } else {
            return "Error: " . $this->db->error;
        }
    }

    public function actualizarDocente($id, $nombre, $apellido, $correo, $carnet, $telefono, $estadoCivil, $universidad, $observacion, $direccion, $imagen, $firma, $pdf)
    {
        // Verificar que el ID no esté vacío
        if (empty($id)) {
            return "El ID del docente es obligatorio.";
        }

        // Consulta para actualizar los datos del docente
        $query = "UPDATE docentes SET nombres = ?, apellidos = ?, correo = ?, carnet = ?, telefono = ?, estadoCivil = ?, universidad = ?, observacion = ?, direccionDomicilio = ?, foto = ?, firma = ?, curriculum = ? WHERE id = ?";

        // Preparar la consulta
        $stmt = $this->db->prepare($query);

        // Enlazar los parámetros con la consulta preparada
        $stmt->bind_param("ssssssssssssi", $nombre, $apellido, $correo, $carnet, $telefono, $estadoCivil, $universidad, $observacion, $direccion, $imagen, $firma, $pdf, $id);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            return "Docente actualizado exitosamente";
        } else {
            return "Error: " . $this->db->error;
        }
    }

    public function eliminarDocente($id)
    {
        // Verificar que el ID no esté vacío
        if (empty($id)) {
            return "El ID del docente es obligatorio.";
        }

        $query = "DELETE FROM docentes WHERE id = ?";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            return "Docente eliminado exitosamente";
        } else {
            return "Error: " . $this->db->error;
        }
    }
}
