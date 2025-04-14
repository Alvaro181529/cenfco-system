<?php

class ComentariosModel
{
    private $db;

    public function __construct()
    {
        $this->db = include(__DIR__ . '/../../config/db.php');

        if (!$this->db) {
            die("Error: Conexión a la base de datos no establecida.");
        }
    }

    // Método para buscar comentarios por asunto o nombre, con paginación
    public function obtenerComentarios($asunto = null, $nombre = null, $pagina = 1, $resultadosPorPagina = 10)
    {
        // Calculamos el OFFSET basado en la página actual
        $offset = ($pagina - 1) * $resultadosPorPagina;

        // Consulta base
        $query = "SELECT * FROM comentario WHERE 1=1";

        // Agregar filtros si existen
        if ($asunto) {
            $query .= " AND asunto LIKE ?";
        }
        if ($nombre) {
            $query .= " AND nombre LIKE ?";
        }

        // Agregar los parámetros para LIMIT y OFFSET
        $query .= " LIMIT ? OFFSET ?";

        // Preparar la consulta
        $stmt = $this->db->prepare($query);

        $params = [];
        $types = '';

        // Si hay filtros, agregamos los parámetros
        if ($asunto) {
            $params[] = "%$asunto%";
            $types .= 's';
        }

        if ($nombre) {
            $params[] = "%$nombre%";
            $types .= 's';
        }

        // Agregar los parámetros de LIMIT y OFFSET
        $params[] = $resultadosPorPagina;
        $params[] = $offset;
        $types .= 'ii'; // ii -> Integer para LIMIT y OFFSET

        // Vinculamos los parámetros
        $stmt->bind_param($types, ...$params);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $comentarios = $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return "Error: " . $this->db->error;
        }

        // Obtener el número total de comentarios (sin filtros)
        $queryTotal = "SELECT COUNT(*) AS total FROM comentario WHERE 1=1";
        if ($asunto) {
            $queryTotal .= " AND asunto LIKE ?";
        }
        if ($nombre) {
            $queryTotal .= " AND nombre LIKE ?";
        }

        // Preparar la consulta para obtener el total de comentarios
        $stmtTotal = $this->db->prepare($queryTotal);
        if ($asunto) {
            $asuntoTotal = "%$asunto%";
            $stmtTotal->bind_param('s', $asuntoTotal);
        }
        if ($nombre) {
            $nombreTotal = "%$nombre%";
            $stmtTotal->bind_param('s', $nombreTotal);
        }

        if ($stmtTotal->execute()) {
            $resultTotal = $stmtTotal->get_result();
            $totalComentarios = $resultTotal->fetch_assoc()['total'];
        } else {
            return "Error: " . $this->db->error;
        }

        // Calcular el número total de páginas
        $totalPaginas = ceil($totalComentarios / $resultadosPorPagina);

        // Retornar los resultados y la información de paginación
        return [
            'comentarios' => $comentarios,
            'totalComentarios' => $totalComentarios,
            'totalPaginas' => $totalPaginas,
            'paginaActual' => $pagina
        ];
    }

    // Método para obtener un comentario por ID
    public function obtenerComentarioPorId($id)
    {
        if (empty($id)) {
            return "El ID del comentario es obligatorio.";
        }

        $query = "SELECT * FROM comentario WHERE id = ?";
        $stmt = $this->db->prepare($query);

        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $comentario = $result->fetch_assoc();

            if ($comentario) {
                return $comentario;
            } else {
                return "Comentario no encontrado.";
            }
        } else {
            return "Error: " . $this->db->error;
        }
    }

    // Método para agregar un nuevo comentario
    public function agregarComentario($nombre, $correo, $asunto, $mensaje)
    {
        $query = "INSERT INTO comentario (nombre, correo, asunto, mensaje) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);

        $stmt->bind_param("ssss", $nombre, $correo, $asunto, $mensaje);

        if ($stmt->execute()) {
            return "Nuevo comentario agregado exitosamente";
        } else {
            return "Error: " . $this->db->error;
        }
    }

    // Método para actualizar un comentario
    public function actualizarComentario($id, $nombre, $correo, $asunto, $mensaje)
    {
        if (empty($id)) {
            return "El ID del comentario es obligatorio.";
        }

        $query = "UPDATE comentario SET nombre = ?, correo = ?, asunto = ?, mensaje = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);

        $stmt->bind_param("ssssi", $nombre, $correo, $asunto, $mensaje, $id);

        if ($stmt->execute()) {
            return "Comentario actualizado exitosamente";
        } else {
            return "Error: " . $this->db->error;
        }
    }

    // Método para eliminar un comentario
    public function eliminarComentario($id)
    {
        if (empty($id)) {
            return "El ID del comentario es obligatorio.";
        }

        $query = "DELETE FROM comentario WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            return "Comentario eliminado exitosamente";
        } else {
            return "Error: " . $this->db->error;
        }
    }
}
