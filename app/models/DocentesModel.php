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
    public function buscarDocentes($query)
    {
        $sql = "SELECT * FROM docentes WHERE nombres LIKE ? OR apellidos LIKE ? OR correo LIKE ?";

        // Prepara la consulta
        $stmt = $this->db->prepare($sql);
        if ($stmt === false) {
            die('Error en la preparación de la consulta: ' . $this->db->error);
        }

        // Preparamos el parámetro para la consulta
        $queryParam = '%' . $query . '%'; // Para permitir la búsqueda parcial

        // Enlaza los parámetros
        $stmt->bind_param('sss', $queryParam, $queryParam, $queryParam);

        // Ejecuta la consulta
        $stmt->execute();

        // Obtiene los resultados
        $result = $stmt->get_result();

        // Procesa los resultados
        $docentes = [];
        while ($docente = $result->fetch_assoc()) {
            $docentes[] = $docente;
        }

        // Cierra el statement y devuelve los resultados
        $stmt->close();
        return $docentes;
    }

    public function obtenerDocentes()
    {
        $query = "SELECT * FROM docentes";
        $result = $this->db->query($query);  // Aquí ahora puedes usar $this->db

        if ($result) {
            $docentes = [];
            while ($row = $result->fetch_assoc()) {
                $docentes[] = $row;
            }
            return $docentes;
        } else {
            return "Error: " . $this->db->error;
        }
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
