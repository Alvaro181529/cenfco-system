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
    public function obtenerEventos($titulo = null, $descripcion = null, $categoria = null, $pagina = 1, $resultadosPorPagina = 10)
    {
        // Validar los parámetros de paginación
        if (!is_int($pagina) || $pagina <= 0) {
            return "Error: El parámetro 'pagina' debe ser un número entero mayor que 0.";
        }

        if (!is_int($resultadosPorPagina) || $resultadosPorPagina <= 0) {
            return "Error: El parámetro 'resultadosPorPagina' debe ser un número entero mayor que 0.";
        }

        // Calculamos el offset para la paginación
        $offset = ($pagina - 1) * $resultadosPorPagina;

        // Comenzamos con la consulta base
        $query = "SELECT * FROM eventos WHERE 1=1"; // '1=1' es útil para concatenar condiciones adicionales

        // Agregar condiciones de filtro si se proporcionan
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

        // Crear el array de parámetros y el tipo de datos para enlazar
        $params = [];
        $types = '';

        // Agregar los parámetros de filtro
        if ($titulo) {
            $params[] = "%$titulo%";
            $types .= 's'; // 's' para string
        }
        if ($descripcion) {
            $params[] = "%$descripcion%";
            $types .= 's';
        }
        if ($categoria) {
            $params[] = "%$categoria%";
            $types .= 's';
        }

        // Agregar los parámetros de LIMIT y OFFSET
        $params[] = $resultadosPorPagina;
        $params[] = $offset;
        $types .= 'ii'; // 'ii' para enteros (LIMIT y OFFSET)

        // Enlazar los parámetros
        if ($params) {
            $stmt->bind_param($types, ...$params);
        }

        // Ejecutar la consulta y obtener los resultados
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $eventos = $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return "Error: " . $this->db->error;
        }

        // Obtener el número total de eventos para la paginación
        $queryTotal = "SELECT COUNT(*) AS total FROM eventos WHERE 1=1";
        if ($titulo) {
            $queryTotal .= " AND titulo LIKE ?";
        }
        if ($descripcion) {
            $queryTotal .= " AND descripcion LIKE ?";
        }
        if ($categoria) {
            $queryTotal .= " AND categoria LIKE ?";
        }

        // Preparar la consulta para obtener el total de eventos
        $stmtTotal = $this->db->prepare($queryTotal);

        // Enlazar los parámetros de filtro
        $paramsTotal = [];
        $typesTotal = '';
        if ($titulo) {
            $paramsTotal[] = "%$titulo%";
            $typesTotal .= 's';
        }
        if ($descripcion) {
            $paramsTotal[] = "%$descripcion%";
            $typesTotal .= 's';
        }
        if ($categoria) {
            $paramsTotal[] = "%$categoria%";
            $typesTotal .= 's';
        }

        // Enlazar los parámetros
        if ($paramsTotal) {
            $stmtTotal->bind_param($typesTotal, ...$paramsTotal);
        }

        // Ejecutar la consulta para obtener el total de eventos
        $stmtTotal->execute();
        $resultTotal = $stmtTotal->get_result();

        if ($resultTotal) {
            $totalEventos = $resultTotal->fetch_assoc()['total'];
        } else {
            return "Error al obtener el total de eventos: " . $this->db->error;
        }

        // Calcular el número total de páginas
        $totalPaginas = ceil($totalEventos / $resultadosPorPagina);

        // Devolver los resultados con la paginación
        return [
            'eventos' => $eventos,
            'totalEventos' => $totalEventos,
            'totalPaginas' => $totalPaginas,
            'paginaActual' => $pagina
        ];
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
