<?php

class VentasModel
{
    private $db;

    public function __construct()
    {

        $this->db = include(__DIR__ . '/../../config/db.php');


        if (!$this->db) {
            die("Error: Conexión a la base de datos no establecida.");
        }
    }
    public function obtenerVentas($user = '', $tipo = '', $anio = NULL, $month = NULL)
    {
        // Prepara la consulta SQL
        $query = "SELECT 
                cursos.titulo AS cursoTitulo, 
                certificados.titulo AS certificadoTitulo,
                ventas.id,
                ventas.externoNombre,
                ventas.externoCarnet,
                ventas.precio,
                ventas.descripcion,
                ventas.user
              FROM ventas
              LEFT JOIN cursos ON ventas.id_curso = cursos.id
              LEFT JOIN estudiantes ON ventas.id_estudiante = estudiantes.id
              LEFT JOIN certificados ON ventas.id_certificado = certificados.id
              WHERE ventas.tipo = ?";

        // Agregar condiciones según los parámetros
        if ($user) {
            $query .= " AND ventas.user = ?";
        }
        if ($anio) {
            $query .= " AND YEAR(ventas.createt_at) = ?";
        }
        if ($month) {
            $query .= " AND MONTH(ventas.createt_at) = ?";
        }

        // Preparar la consulta
        if ($stmt = $this->db->prepare($query)) {
            // Establecer los tipos de los parámetros
            $types = 's'; // Al menos el tipo de 'tipo' será string
            $params = [$tipo]; // Empezamos con el tipo como primer parámetro

            // Si se pasa un usuario, añadir a los parámetros
            if ($user) {
                $types .= 's';
                $params[] = $user;
            }
            // Si se pasa un año, añadir a los parámetros
            if ($anio) {
                $types .= 's';
                $params[] = $anio;
            }
            // Si se pasa un mes, añadir a los parámetros
            if ($month) {
                $types .= 's';
                $params[] = $month;
            }

            // Vincular los parámetros correctamente
            $stmt->bind_param($types, ...$params);

            // Ejecutar la consulta
            $stmt->execute();
            $result = $stmt->get_result();

            // Verificar si hay resultados
            if ($result->num_rows > 0) {
                $ventas = [];
                while ($row = $result->fetch_assoc()) {
                    $ventas[] = $row;
                }
                $stmt->close();
                return $ventas;
            } else {
                $stmt->close();
                return [];
            }
        } else {
            return "Error: " . $this->db->error;
        }
    }

    public function obtenerTotalVentas($user = '', $tipo = '', $anio = NULL, $month = NULL)
    {

        $query = "SELECT SUM(ventas.precio) AS totalPrecio FROM ventas LEFT JOIN cursos ON ventas.id_curso = cursos.id LEFT JOIN estudiantes ON ventas.id_estudiante = estudiantes.id LEFT JOIN certificados ON ventas.id_certificado = certificados.id WHERE 1=1";


        if ($user) {
            $query .= " AND ventas.user LIKE ?";
        }
        if ($tipo) {
            $query .= " AND ventas.tipo LIKE ?";
        }
        if ($anio) {
            $query .= " AND YEAR(ventas.createt_at) = ?";
        }
        if ($month) {
            $query .= " AND MONTH(ventas.createt_at) = ?";
        }

        if ($stmt = $this->db->prepare($query)) {
            $params = [];
            $types = '';

            if ($user) {
                $params[] = $user;
                $types .= 's';
            }
            if ($tipo) {
                $params[] = $tipo;
                $types .= 's';
            }
            // Si se pasa un año, añadir a los parámetros
            if ($anio) {
                $types .= 's';
                $params[] = $anio;
            }
            // Si se pasa un mes, añadir a los parámetros
            if ($month) {
                $types .= 's';
                $params[] = $month;
            }

            if ($params) {
                $stmt->bind_param($types, ...$params);
            }

            $stmt->execute();
            $result = $stmt->get_result();


            if ($result) {
                $ventas = [];
                while ($row = $result->fetch_assoc()) {
                    $ventas[] = $row;
                }
                $stmt->close();
                return $ventas;
            } else {
                $stmt->close();
                return "Error: No se encontraron resultados.";
            }
        } else {
            return "Error: " . $this->db->error;
        }
    }


    public function obtenerVentasPorId($id)
    {

        if (!isset($id) || !is_numeric($id) || $id <= 0) {
            return "El ID de la venta es obligatorio y debe ser un número válido.";
        }


        $query = "SELECT 
                    cursos.id AS cursoId, 
                    estudiantes.id AS estudianteId, 
                    certificados.id AS certificadoId, 
                    cursos.titulo AS cursoTitulo, 
                    certificados.titulo AS certificadoTitulo,
                    ventas.id,
                    ventas.comprobante,
                    ventas.externoNombre,
                    ventas.externoCarnet,
                    ventas.precio,
                    ventas.descripcion,
                    ventas.tipo,
                    ventas.user 
                FROM ventas
                LEFT JOIN cursos ON ventas.id_curso = cursos.id
                LEFT JOIN estudiantes ON ventas.id_estudiante = estudiantes.id
                LEFT JOIN certificados ON ventas.id_certificado = certificados.id 
                WHERE ventas.id = ?";


        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $venta = $result->fetch_assoc();


            if ($venta) {
                $stmt->close();
                return $venta;
            } else {
                $stmt->close();
                return "Venta no encontrada.";
            }
        } else {
            $stmt->close();
            return "Error: " . $this->db->error;
        }
    }


    public function agregarVentas($id_curso = NULL, $id_certificado = NULL, $id_estudiante = NULL, $externoNombre, $externoCarnet, $precio, $descripcion, $tipo, $user, $comprobante)
    {
        $query2 = 'SET FOREIGN_KEY_CHECKS=0';
        $stmt2 = $this->db->prepare($query2);
        $stmt2->execute();
        $query = "INSERT INTO ventas (id_curso, id_certificado, id_estudiante, externoNombre, externoCarnet, precio, descripcion, tipo, user, comprobante) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("iiissdssss", $id_curso, $id_certificado, $id_estudiante, $externoNombre, $externoCarnet, $precio, $descripcion, $tipo, $user, $comprobante);
        if ($stmt->execute()) {
            $query2 = 'SET FOREIGN_KEY_CHECKS=1';
            $stmt2 = $this->db->prepare($query2);
            $stmt2->execute();
            return "Venta agregada exitosamente";
        } else {
            return "Error: " . $this->db->error;
        }
    }

    public function actualizarVentas($id, $id_curso = NULL, $id_certificado = NULL, $id_estudiante = NULL, $externoNombre, $externoCarnet, $precio, $descripcion, $tipo, $user)
    {
        $query2 = 'SET FOREIGN_KEY_CHECKS=0';
        $stmt2 = $this->db->prepare($query2);
        $stmt2->execute();
        if (empty($id)) {
            return "El ID de la venta es obligatorio.";
        }

        $query = "UPDATE ventas SET id_curso = ?, id_certificado = ?, id_estudiante = ?, externoNombre = ?, externoCarnet = ?, precio = ?, descripcion = ?, tipo = ?, user= ? WHERE id = ?";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("iiissssssi", $id_curso, $id_certificado, $id_estudiante, $externoNombre, $externoCarnet, $precio, $descripcion, $tipo, $user, $id);

        if ($stmt->execute()) {
            $query2 = 'SET FOREIGN_KEY_CHECKS=1';
            $stmt2 = $this->db->prepare($query2);
            $stmt2->execute();
            return "Venta actualizada exitosamente";
        } else {
            return "Error: " . $this->db->error;
        }
    }

    public function eliminarVentas($id)
    {
        if (empty($id)) {
            return "El ID de la venta es obligatorio.";
        }

        $query = "DELETE FROM ventas WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            return "Venta eliminada exitosamente";
        } else {
            return "Error: " . $this->db->error;
        }
    }
}
