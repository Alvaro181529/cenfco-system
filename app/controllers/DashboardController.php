<?php
session_start();

require_once __DIR__ . '/../models/DocentesModel.php';
require_once __DIR__ . '/../models/EstudiantesModel.php';
require_once __DIR__ . '/../models/CursosModel.php';
require_once __DIR__ . '/../models/InventariosModel.php';
require_once __DIR__ . '/../models/CertificadosModel.php';
require_once __DIR__ . '/../models/DashboardModel.php';
require_once __DIR__ . '/../models/UsuariosModel.php';
require_once __DIR__ . '/../models/VentasModel.php';
require_once __DIR__ . '/../lib/checkRol.php';

class DashboardController
{
    public function dashboard()
    {
        if ($_SESSION['user']['role']) {
        }else{
            header('Location: / ');
            exit();
        }
        $dashboardModel = new DashboardModel();
        $cantidadEstudiantes = $dashboardModel->cantidadEstudiantes();
        $cantidadDocentes = $dashboardModel->cantidadDocentes();
        $cantidadCursos = $dashboardModel->cantidadCursos();
        $cantidadInventario = $dashboardModel->cantidadInventario();
        $checkRol = new CheckLib();

        require __DIR__ . '/../views/dashboard/home.php';
    }
    public function preguntas()
    {
        require __DIR__ . '/../views/dashboard/preguntas.php';
    }
    public function blog()
    {
        require __DIR__ . '/../views/dashboard/blog.php';
    }
    public function chatbot()
    {
        require __DIR__ . '/../views/dashboard/chatbot.php';
    }
}
