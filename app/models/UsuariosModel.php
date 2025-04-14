<?php

class UsuariosModel
{
    private $db;

    public function __construct()
    {
        $this->db = include(__DIR__ . '/../../config/db.php');

        if (!$this->db) {
            die("Error: Conexión a la base de datos no establecida.");
        }
    }
    public function obtenerUsuarios($searchTerm = null, $pagina = 1, $resultadosPorPagina = 10)
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
        $query = "SELECT * FROM users WHERE 1=1"; // '1=1' es útil para concatenar condiciones adicionales

        // Agregar condiciones de filtro si se proporciona el término de búsqueda
        if ($searchTerm) {
            $query .= " AND (username LIKE ? OR correo LIKE ?)";
        }

        // Agregar LIMIT y OFFSET para la paginación
        $query .= " LIMIT ? OFFSET ?";

        // Preparar la consulta
        $stmt = $this->db->prepare($query);

        // Crear el array de parámetros y el tipo de datos para enlazar
        $params = [];
        $types = '';

        // Agregar el término de búsqueda si existe
        if ($searchTerm) {
            $searchTerm = "%" . $searchTerm . "%";
            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $types .= 'ss'; // 'ss' para dos strings
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
            $usuarios = $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return "Error: " . $this->db->error;
        }

        // Obtener el número total de usuarios para la paginación
        $queryTotal = "SELECT COUNT(*) AS total FROM users WHERE 1=1";
        if ($searchTerm) {
            $queryTotal .= " AND (username LIKE ? OR correo LIKE ?)";
        }

        // Preparar la consulta para obtener el total de usuarios
        $stmtTotal = $this->db->prepare($queryTotal);

        // Enlazar los parámetros de filtro
        $paramsTotal = [];
        $typesTotal = '';
        if ($searchTerm) {
            $paramsTotal[] = $searchTerm;
            $paramsTotal[] = $searchTerm;
            $typesTotal .= 'ss';
        }

        // Enlazar los parámetros
        if ($paramsTotal) {
            $stmtTotal->bind_param($typesTotal, ...$paramsTotal);
        }

        // Ejecutar la consulta para obtener el total de usuarios
        $stmtTotal->execute();
        $resultTotal = $stmtTotal->get_result();

        if ($resultTotal) {
            $totalUsuarios = $resultTotal->fetch_assoc()['total'];
        } else {
            return "Error al obtener el total de usuarios: " . $this->db->error;
        }

        // Calcular el número total de páginas
        $totalPaginas = ceil($totalUsuarios / $resultadosPorPagina);

        // Devolver los resultados con la paginación
        return [
            'usuarios' => $usuarios,
            'totalUsuarios' => $totalUsuarios,
            'totalPaginas' => $totalPaginas,
            'paginaActual' => $pagina
        ];
    }
    public function obtenerUsuariosPorId($id)
    {
        if (empty($id)) {
            return "El ID del usuarios es obligatorio.";
        }

        $query = "SELECT * FROM users WHERE id = ?";

        $stmt = $this->db->prepare($query);

        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $usuarios = $result->fetch_assoc();
            if ($usuarios) {
                return $usuarios;
            } else {
                return "Usuarios no encontrado.";
            }
        } else {
            return "Error: " . $this->db->error;
        }
    }

    public function agregarUsuarios($username, $correo, $rol, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO users (username, correo,password, role) VALUES (?, ?,?, ?)";

        $stmt = $this->db->prepare($query);

        $stmt->bind_param("ssss", $username, $correo,$hashedPassword, $rol);

        if ($stmt->execute()) {
            return "Nuevo usuarios agregado exitosamente";
        } else {
            return "Error: " . $this->db->error;
        }
    }

    public function actualizarUsuarios($id, $username, $correo, $rol)
    {
        if (empty($id)) {
            return "El ID del usuarios es obligatorio.";
        }

        $query = "UPDATE users SET username = ?, correo = ?, role = ? WHERE id = ?";

        $stmt = $this->db->prepare($query);

        $stmt->bind_param("sssi", $username, $correo, $rol, $id);

        if ($stmt->execute()) {
            return "Usuarios actualizado exitosamente";
        } else {
            return "Error: " . $this->db->error;
        }
    }

    public function eliminarUsuarios($id)
    {
        if (empty($id)) {
            return "El ID del usuarios es obligatorio.";
        }

        $query = "DELETE FROM users WHERE id = ?";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            return "Usuarios eliminado exitosamente";
        } else {
            return "Error: " . $this->db->error;
        }
    }
}
