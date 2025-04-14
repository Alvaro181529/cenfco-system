<?php
require_once __DIR__ . '/../../../models/blog/MenusModel.php';

class MenusController
{
    private $menusModel;

    public function __construct()
    {
        $this->menusModel = new MenusModel();
    }

    public function menus()
    {
        if ($_SESSION['user']['role']) {
            // Aquí puedes agregar lógica adicional para los permisos
        } else {
            header('Location: /');
            exit();
        }

        $menus = $this->menusModel->obtenerMenus();
        return $menus;
    }

    public function guardar()
    {
        $MenuNameEnglish = $_POST['MenuNameEnglish'] ?? '';
        $SortNumber = $_POST['SortNumber'] ?? '';

        if (empty($MenuNameEnglish)) {
            echo "El nombre del menú es obligatorio.";
            return;
        }

        $result = $this->menusModel->agregarMenu($MenuNameEnglish, $SortNumber);

        if ($result == "Nuevo menú agregado exitosamente") {
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
            echo "El ID del menú es obligatorio.";
            return;
        }

        $result = $this->menusModel->eliminarMenu($id);

        if ($result == "Menú eliminado exitosamente") {
            echo json_encode(["message" => "Menú eliminado exitosamente"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Error al eliminar el menú"]);
        }
    }

    public function obtenerMenu($id)
    {
        $menu = $this->menusModel->obtenerMenuPorId($id);
        echo json_encode($menu);
    }

    public function actualizar()
    {
        $id = $_POST['id'] ?? '';
        $MenuNameEnglish = $_POST['MenuNameEnglish'] ?? '';
        $SortNumber = $_POST['SortNumber'] ?? '';

        if (empty($id)) {
            echo "El ID del menú es obligatorio.";
            return;
        }

        if (empty($MenuNameEnglish)) {
            echo "El nombre del menú es obligatorio.";
            return;
        }

        $result = $this->menusModel->actualizarMenu($id, $MenuNameEnglish, $SortNumber);

        if ($result == "Menú actualizado exitosamente") {
            header("Location: /dashboard/blog");
            exit();
        } else {
            echo $result;
        }
    }
}
