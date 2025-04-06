<?php

class DashboardModel
{
    private $db;

    public function __construct()
    {

        $this->db = include(__DIR__ . '/../../config/db.php');


        if (!$this->db) {
            die("Error: Conexión a la base de datos no establecida.");
        }
    }

    public function cantidadDocentes()
    {
        $query = "SELECT COUNT(*) AS cantidad FROM docentes";
        $result = $this->db->query($query);
        if ($result) {

            $row = $result->fetch_assoc();
            return $row['cantidad'];
        } else {
            return "Error: " . $this->db->error;
        }
    }
    public function cantidadEstudiantes()
    {
        $query = "SELECT COUNT(*) AS cantidad FROM estudiantes";
        $result = $this->db->query($query);

        if ($result) {

            $row = $result->fetch_assoc();
            return $row['cantidad'];
        } else {
            return "Error: " . $this->db->error;
        }
    }
    public function cantidadCursos()
    {
        $query = "SELECT COUNT(*) AS cantidad FROM cursos";
        $result = $this->db->query($query);

        if ($result) {

            $row = $result->fetch_assoc();
            return $row['cantidad'];
        } else {
            return "Error: " . $this->db->error;
        }
    }
    public function cantidadInventario()
    {
        $query = "SELECT COUNT(*) AS cantidad FROM inventario";
        $result = $this->db->query($query);

        if ($result) {

            $row = $result->fetch_assoc();
            return $row['cantidad'];
        } else {
            return "Error: " . $this->db->error;
        }
    }
}
