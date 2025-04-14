<?php
require_once __DIR__ . '/../models/HomeModel.php';

class HomeController
{

    private $homeModel;

    public function __construct()
    {
        $this->homeModel = new HomeModel();
    }
    public function index()
    {
        if (isset($_SESSION['user_id'])) {
            $success = "iniciado";
        } else {
            $success = "";
        }
        $dashboardModel = new DashboardModel();
        $cursos = $this->homeModel->obtenerCursos();
        $categorias = $this->homeModel->obtenerCategorias();
        $cursosPorCategoria = [];
        foreach ($categorias as $categoria) {
            $cursosPorCategoria[$categoria['categoria']] = array_filter($cursos, function ($curso) use ($categoria) {
                return $curso['categoria'] === $categoria['categoria'];
            });
        }
        $cantidadEstudiantes = $dashboardModel->cantidadEstudiantes();
        $cantidadDocentes = $dashboardModel->cantidadDocentes();
        $cantidadCursos = $dashboardModel->cantidadCursos();
        $cantidadInventario = $dashboardModel->cantidadInventario();
        $eventos = $this->homeModel->obtenerEventos();
        require __DIR__ . '/../views/home.php';
    }

    public function about()
    {
        require __DIR__ . '/../views/about.php';
    }

    public function user($id)
    {
        echo "Perfil de usuario con ID: $id";
    }
}
