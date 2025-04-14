<?php

class InventariosModel
{
    private $db;

    public function __construct()
    {
        $this->db = include(__DIR__ . '/../../config/db.php');

        if (!$this->db) {
            die("Error: Conexión a la base de datos no establecida.");
        }
    }

    public function obtenerInventarios($nombre = null, $pagina = 1, $resultadosPorPagina = 10)
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
        $query = "SELECT * FROM inventario WHERE 1=1"; // '1=1' es útil para concatenar condiciones adicionales

        // Agregar condiciones de filtro si se proporcionan
        if ($nombre) {
            $query .= " AND nombre LIKE ?";
        }

        // Agregar LIMIT y OFFSET para la paginación
        $query .= " LIMIT ? OFFSET ?";

        // Preparar la consulta
        $stmt = $this->db->prepare($query);

        // Crear el array de parámetros y el tipo de datos para enlazar
        $params = [];
        $types = '';

        // Agregar los parámetros de filtro
        if ($nombre) {
            $params[] = "%$nombre%";
            $types .= 's'; // 's' para string
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
            $inventarios = $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return "Error: " . $this->db->error;
        }

        // Obtener el número total de inventarios para la paginación
        $queryTotal = "SELECT COUNT(*) AS total FROM inventario WHERE 1=1";
        if ($nombre) {
            $queryTotal .= " AND nombre LIKE ?";
        }

        // Preparar la consulta para obtener el total de inventarios
        $stmtTotal = $this->db->prepare($queryTotal);

        // Enlazar los parámetros de filtro
        $paramsTotal = [];
        $typesTotal = '';
        if ($nombre) {
            $paramsTotal[] = "%$nombre%";
            $typesTotal .= 's';
        }

        // Enlazar los parámetros
        if ($paramsTotal) {
            $stmtTotal->bind_param($typesTotal, ...$paramsTotal);
        }

        // Ejecutar la consulta para obtener el total de inventarios
        $stmtTotal->execute();
        $resultTotal = $stmtTotal->get_result();

        if ($resultTotal) {
            $totalInventarios = $resultTotal->fetch_assoc()['total'];
        } else {
            return "Error al obtener el total de inventarios: " . $this->db->error;
        }

        // Calcular el número total de páginas
        $totalPaginas = ceil($totalInventarios / $resultadosPorPagina);

        // Devolver los resultados con la paginación
        return [
            'inventarios' => $inventarios,
            'totalInventarios' => $totalInventarios,
            'totalPaginas' => $totalPaginas,
            'paginaActual' => $pagina
        ];
    }

    public function obtenerInventarioPorId($id)
    {
        if (empty($id)) {
            return "El ID del inventario es obligatorio.";
        }

        $query = "SELECT * FROM inventario WHERE id = ?";

        $stmt = $this->db->prepare($query);

        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $inventario = $result->fetch_assoc();

            if ($inventario) {
                return $inventario;
            } else {
                return "Inventario no encontrado.";
            }
        } else {
            return "Error: " . $this->db->error;
        }
    }

    public function agregarInventario($nombre, $descripcion, $cantidad, $fecha)
    {
        $query = "INSERT INTO inventario (nombre, descripcion, cantidad, fechaAdquisicion) VALUES (?, ?, ?, ?)";

        $stmt = $this->db->prepare($query);

        $stmt->bind_param("ssis", $nombre, $descripcion, $cantidad, $fecha);

        if ($stmt->execute()) {
            return "Nuevo inventario agregado exitosamente";
        } else {
            return "Error: " . $this->db->error;
        }
    }

    public function actualizarInventario($id, $nombre, $descripcion, $cantidad, $fecha)
    {
        if (empty($id)) {
            return "El ID del inventario es obligatorio.";
        }

        $query = "UPDATE inventario SET nombre = ?, descripcion = ?, cantidad = ?, fechaAdquisicion = ? WHERE id = ?";

        $stmt = $this->db->prepare($query);

        $stmt->bind_param("ssisi", $nombre, $descripcion, $cantidad, $fecha, $id);

        if ($stmt->execute()) {
            return "Inventario actualizado exitosamente";
        } else {
            return "Error: " . $this->db->error;
        }
    }

    public function eliminarInventario($id)
    {
        if (empty($id)) {
            return "El ID del inventario es obligatorio.";
        }

        $query = "DELETE FROM inventario WHERE id = ?";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            return "Inventario eliminado exitosamente";
        } else {
            return "Error: " . $this->db->error;
        }
    }
}
