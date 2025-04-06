<?php

class HomeModel
{
    private $db;

    public function __construct()
    {
        $this->db = include(__DIR__ . '/../../config/db.php');
        if (!$this->db) {
            die("Error: Conexión a la base de datos no establecida.");
        }
    }
    public function obtenerEventos()
    {
        $query = "SELECT * FROM eventos WHERE mostrarInicio = '1'";
        $result = $this->db->query($query);
        if ($result) {
            $eventos = [];
            while ($row = $result->fetch_assoc()) {
                $eventos[] = $row;
            }
            return $eventos;
        } else {
            return "Error: " . $this->db->error;
        }
    }
    public function obtenerCursos()
    {
        $query = "SELECT * FROM cursos WHERE mostrarInicio = '1'";
        $result = $this->db->query($query);

        if ($result) {
            $cursos = [];
            while ($row = $result->fetch_assoc()) {
                $cursos[] = $row;
            }
            return $cursos;
        } else {
            return "Error: " . $this->db->error;
        }
    }
    public function obtenerCategorias()
    {
        $query = "SELECT categoria FROM cursos  GROUP by categoria;";
        $result = $this->db->query($query);

        if ($result) {
            $cursos = [];
            while ($row = $result->fetch_assoc()) {
                $cursos[] = $row;
            }
            return $cursos;
        } else {
            return "Error: " . $this->db->error;
        }
    }
}
