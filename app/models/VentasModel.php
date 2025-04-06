<?php

class VentasModel
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

    public function obtenerVentas($user = '', $tipo = '')
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

        // Agregar condición si se pasa el parámetro $user
        if ($user) {
            $query .= " AND ventas.user = ?";
        }

        // Preparar la consulta
        if ($stmt = $this->db->prepare($query)) {
            // Definir los tipos de parámetros a vincular
            if ($user) {
                $stmt->bind_param('ss', $tipo, $user);
            } else {
                $stmt->bind_param('s', $tipo);
            }

            // Ejecutar la consulta
            $stmt->execute();
            $result = $stmt->get_result();

            // Verificar si hay resultados
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
    public function obtenerTotalVentas($user = '', $tipo = '')
    {
        // Prepara la consulta SQL
        $query = "SELECT SUM(ventas.precio) AS totalPrecio FROM ventas LEFT JOIN cursos ON ventas.id_curso = cursos.id LEFT JOIN estudiantes ON ventas.id_estudiante = estudiantes.id LEFT JOIN certificados ON ventas.id_certificado = certificados.id WHERE 1=1";

        // Agregar condición si se pasa el parámetro $user
        if ($user) {
            $query .= " AND ventas.user LIKE ?";
        }
        if ($tipo) {
            $query .= " AND ventas.tipo LIKE ?";
        }

        // Preparar la consulta
        if ($stmt = $this->db->prepare($query)) {
            $params = [];
            $types = '';
            // Definir los tipos de parámetros a vincular
            if ($user) {
                $params[] = $user;
                $types .= 's';
            }
            if ($tipo) {
                $params[] = $tipo;
                $types .= 's';
            }
            if ($params) {
                $stmt->bind_param($types, ...$params);
            }
            // Ejecutar la consulta
            $stmt->execute();
            $result = $stmt->get_result();

            // Verificar si hay resultados
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
        // Verifica que $id sea un número válido
        if (!isset($id) || !is_numeric($id) || $id <= 0) {
            return "El ID de la venta es obligatorio y debe ser un número válido.";
        }

        // Prepara la consulta SQL
        $query = "SELECT 
                    cursos.id AS cursoId, 
                    estudiantes.id AS estudianteId, 
                    certificados.id AS certificadoId, 
                    cursos.titulo AS cursoTitulo, 
                    certificados.titulo AS certificadoTitulo,
                    ventas.id,
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

        // Prepara la consulta
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $venta = $result->fetch_assoc();

            // Verifica si se encontró la venta
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


    public function agregarVentas($id_curso = NULL, $id_certificado = NULL, $id_estudiante = NULL, $externoNombre, $externoCarnet, $precio, $descripcion, $tipo, $user)
    {
        $query2 = 'SET FOREIGN_KEY_CHECKS=0';
        $stmt2 = $this->db->prepare($query2);
        $stmt2->execute();
        error_log(" Curso ID: $id_curso, Certificado ID: $id_certificado, Estudiante ID: $id_estudiante, Nombre: $externoNombre, Carnet: $externoCarnet, Precio: $precio, Descripción: $descripcion, Tipo: $tipo, Usuario: $user");
        $query = "INSERT INTO ventas (id_curso, id_certificado, id_estudiante, externoNombre, externoCarnet, precio, descripcion, tipo, user) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?,?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("iiissdsss", $id_curso, $id_certificado, $id_estudiante, $externoNombre, $externoCarnet, $precio, $descripcion, $tipo, $user);
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
