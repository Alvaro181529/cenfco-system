<?php
require_once __DIR__ . '/../../../models/blog/PaginaModel.php';

class PaginasController
{
    private $pagesModel;

    public function __construct()
    {
        $this->pagesModel = new PaginasModel();
    }

    public function pages()
    {
        if ($_SESSION['user']['role']) {
            // Aquí puedes agregar lógica adicional para los permisos
        } else {
            header('Location: /');
            exit();
        }

        $pages = $this->pagesModel->obtenerPages();
        return $pages;
    }

    public function guardar()
    {
        $MenuId = $_POST['MenuId'] ?? '';
        $SortNumber = $_POST['SortNumber'] ?? '';

        if (empty($MenuId)) {
            echo "El ID del menú es obligatorio.";
            return;
        }

        $result = $this->pagesModel->agregarPage($MenuId, $SortNumber);

        if ($result == "Nueva página agregada exitosamente") {
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
            echo "El ID de la página es obligatorio.";
            return;
        }

        $result = $this->pagesModel->eliminarPage($id);

        if ($result == "Página eliminada exitosamente") {
            echo json_encode(["message" => "Página eliminada exitosamente"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Error al eliminar la página"]);
        }
    }

    public function obtenerPage($id)
    {
        $page = $this->pagesModel->obtenerPagePorId($id);
        echo json_encode($page);
    }

    public function actualizar()
    {
        $id = $_POST['id'] ?? '';
        $MenuId = $_POST['MenuId'] ?? '';
        $SortNumber = $_POST['SortNumber'] ?? '';

        if (empty($id)) {
            echo "El ID de la página es obligatorio.";
            return;
        }

        if (empty($MenuId)) {
            echo "El ID del menú es obligatorio.";
            return;
        }

        $result = $this->pagesModel->actualizarPage($id, $MenuId, $SortNumber);

        if ($result == "Página actualizada exitosamente") {
            header("Location: /dashboard/blog");
            exit();
        } else {
            echo $result;
        }
    }
}
