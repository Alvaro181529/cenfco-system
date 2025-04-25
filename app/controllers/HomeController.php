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
        $menus = $this->homeModel->obtenerMenu();
        $groupedMenus = [];
        foreach ($menus as $menu) {

            if (!isset($groupedMenus[$menu['MenuNameEnglish']])) {
                $groupedMenus[$menu['MenuNameEnglish']] = [];
            }
            $groupedMenus[$menu['MenuNameEnglish']][] = [
                'Title' => $this->limit_words($menu['Title']),
                'urlShort' => $menu['urlShort']
            ];
        }

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

        require __DIR__ . '/../views/index.php';
    }
    function prueba()
    {
        require __DIR__ . '/../views/home.php';
    }

    function limit_words($text, $num_words = 2, $more = '...')
    {
        $words = explode(' ', $text, $num_words + 1);
        if (count($words) > $num_words) {
            array_pop($words);
            return implode(' ', $words) . $more;
        }
        return implode(' ', $words);
    }
    public function cursos()
    {
        $titulo = isset($_GET['titulo']) ? $_GET['titulo'] : null;

        // error_log(var_export($titulo, true));
        // Obtener parámetros de paginación
        $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;  // Página por defecto es 1
        $resultadosPorPagina = isset($_GET['total']) ? (int)$_GET['total'] : 10;  // 10 resultados por página por defecto

        error_log("titulo");
        error_log($resultadosPorPagina);
        if (isset($_SESSION['user_id'])) {
            $success = "iniciado";
        } else {
            $success = "";
        }
        $menus = $this->homeModel->obtenerMenu();
        $groupedMenus = [];
        foreach ($menus as $menu) {

            if (!isset($groupedMenus[$menu['MenuNameEnglish']])) {
                $groupedMenus[$menu['MenuNameEnglish']] = [];
            }
            $groupedMenus[$menu['MenuNameEnglish']][] = [
                'Title' => $this->limit_words($menu['Title']),
                'urlShort' => $menu['urlShort']
            ];
        }
        $cursos = $this->homeModel->obtenerCursos(null, $titulo, null, $pagina, $resultadosPorPagina);
        require __DIR__ . '/../views/cursos.php';
    }

    public function user($id)
    {
        echo "Perfil de usuario con ID: $id";
    }
}
