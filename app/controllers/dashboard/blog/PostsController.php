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
        $PageId = $_POST['PageId'] ?? '';
        $Title = $_POST['Title'] ?? '';
        $Content = $_POST['Content'] ?? '';
        $Datetime = $_POST['Datetime'] ?? '';
        $User = $_POST['User'] ?? '';
        $ContentBinary = $_POST['ContentBinary'] ?? '';

        if (empty($PageId)) {
            echo "El ID de la página es obligatorio.";
            return;
        }

        $result = $this->postsModel->agregarPost($PageId, $Title, $Content, $Datetime, $User, $ContentBinary);

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

    public function actualizar()
    {
        $id = $_POST['id'] ?? '';
        $PageId = $_POST['PageId'] ?? '';
        $Title = $_POST['Title'] ?? '';
        $Content = $_POST['Content'] ?? '';
        $Datetime = $_POST['Datetime'] ?? '';
        $User = $_POST['User'] ?? '';
        $ContentBinary = $_POST['ContentBinary'] ?? '';

        if (empty($id)) {
            echo "El ID del post es obligatorio.";
            return;
        }

        if (empty($PageId)) {
            echo "El ID de la página es obligatorio.";
            return;
        }

        $result = $this->postsModel->actualizarPost($id, $PageId, $Title, $Content, $Datetime, $User, $ContentBinary);

        if ($result == "Post actualizado exitosamente") {
            header("Location: /dashboard/blog");
            exit();
        } else {
            echo $result;
        }
    }
}
