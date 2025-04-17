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
    public function obtenerMenu()
    {
        $query = "SELECT 
                        m.MenuNameEnglish, 
                        p.Title,
                        p.urlShort
                    FROM 
                        menus m
                    JOIN 
                        pages pg ON m.MenuId = pg.MenuId
                    JOIN 
                        posts p ON pg.PageId = p.PageId;";
        $result = $this->db->query($query);

        if ($result) {
            $menus = [];
            while ($row = $result->fetch_assoc()) {
                $menus[] = $row;
            }
            return $menus;
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
