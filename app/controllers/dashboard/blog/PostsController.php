<?php
require_once __DIR__ . '/../../../models/blog/PostModel.php';

class PostsController
{
    private $postsModel;

    public function __construct()
    {
        $this->postsModel = new PostsModel();
    }

    public function posts()
    {
        if ($_SESSION['user']['role']) {
            // Aquí puedes agregar lógica adicional para los permisos
        } else {
            header('Location: /');
            exit();
        }

        $posts = $this->postsModel->obtenerPosts();
        return $posts;
    }

    public function guardar()
    {
        $PageId = $_POST['id_page_blog'] ?? '';
        $Title = $_POST['title_blog'] ?? '';
        $Content = $_POST['content'] ?? '';
        $urlShort = $_POST['urlShort'] ?? '';
        $Datetime = new DateTime();
        $DatetimeString = $Datetime->format('Y-m-d H:i:s');
        $User = $_SESSION['user']['username'] ?? '';
        if (empty($PageId)) {
            echo "El ID de la página es obligatorio.";
            return;
        }

        $result = $this->postsModel->agregarPost($PageId, $Title, $Content, $DatetimeString, $User, NULL, $urlShort);

        if ($result == "Nuevo post agregado exitosamente") {
            header("Location: /dashboard/blog");
            exit();
        } else {
            echo $result;
        }
    }

    public function eliminar()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $data['id'] ?? '';

        if (empty($id)) {
            echo "El ID del post es obligatorio.";
            return;
        }

        $result = $this->postsModel->eliminarPost($id);

        if ($result == "Post eliminado exitosamente") {
            echo json_encode(["message" => "Post eliminado exitosamente"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Error al eliminar el post"]);
        }
    }

    public function obtenerPost($id)
    {
        $post = $this->postsModel->obtenerPostPorId($id);
        echo json_encode($post);
    }
    public function obtenerBlog($title)
    {
        if (isset($_SESSION['user_id'])) {
            $success = "iniciado";
        } else {
            $success = "";
        }

        $homeModel = new HomeModel();
        $homeController = new HomeController();
        $menus = $homeModel->obtenerMenu();
        $groupedMenus = [];
        foreach ($menus as $menu) {

            if (!isset($groupedMenus[$menu['MenuNameEnglish']])) {
                $groupedMenus[$menu['MenuNameEnglish']] = [];
            }
            $groupedMenus[$menu['MenuNameEnglish']][] = [
                'Title' => $homeController->limit_words($menu['Title']),
                'urlShort' => $menu['urlShort']
            ];
        }

        $cursos = $homeModel->obtenerCursos();
        $categorias = $homeModel->obtenerCategorias();
        $cursosPorCategoria = [];
        foreach ($categorias as $categoria) {
            $cursosPorCategoria[$categoria['categoria']] = array_filter($cursos, function ($curso) use ($categoria) {
                return $curso['categoria'] === $categoria['categoria'];
            });
        }
        $post = $this->postsModel->obtenerPostPorTitle($title);
        require __DIR__ . '/../../../views/blog.php';
    }
    public function obtenerBlogDashboard($title)
    {
        if (isset($_SESSION['user_id'])) {
            $success = "iniciado";
        } else {
            $success = "";
        }

        $homeModel = new HomeModel();
        $homeController = new HomeController();
        $menus = $homeModel->obtenerMenu();
        $groupedMenus = [];
        foreach ($menus as $menu) {

            if (!isset($groupedMenus[$menu['MenuNameEnglish']])) {
                $groupedMenus[$menu['MenuNameEnglish']] = [];
            }
            $groupedMenus[$menu['MenuNameEnglish']][] = [
                'Title' => $homeController->limit_words($menu['Title']),
                'urlShort' => $menu['urlShort']
            ];
        }

        $cursos = $homeModel->obtenerCursos();
        $categorias = $homeModel->obtenerCategorias();
        $cursosPorCategoria = [];
        foreach ($categorias as $categoria) {
            $cursosPorCategoria[$categoria['categoria']] = array_filter($cursos, function ($curso) use ($categoria) {
                return $curso['categoria'] === $categoria['categoria'];
            });
        }
        $post = $this->postsModel->obtenerPostPorTitle($title);
        require __DIR__ . '/../../../views/dashboard/blogPage.php';
    }
    public function actualizar()
    {
        $id = $_POST['id_blog'] ?? '';
        $PageId = $_POST['id_page_blog'] ?? '';
        $Title = $_POST['title_blog'] ?? '';
        $Content = $_POST['content'] ?? '';
        $urlShort = $_POST['urlShort'] ?? '';
        $Datetime = new DateTime();
        $DatetimeString = $Datetime->format('Y-m-d H:i:s');
        $User = $_SESSION['user']['username'] ?? '';
        $ContentBinary = $_POST['ContentBinary'] ?? '';
        if (empty($id)) {
            echo "El ID del post es obligatorio.";
            return;
        }

        if (empty($PageId)) {
            echo "El ID de la página es obligatorio.";
            return;
        }

        $result = $this->postsModel->actualizarPost($id, $PageId, $Title, $Content, $DatetimeString, $User, $ContentBinary, $urlShort);

        if ($result == "Post actualizado exitosamente") {
            header("Location: /dashboard/blog");
            exit();
        } else {
            echo $result;
        }
    }
}
