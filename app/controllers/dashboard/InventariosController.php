<?php
require_once __DIR__ . '/../../models/InventariosModel.php';

class InventariosController
{
    private $inventariosModel;

    public function __construct()
    {
        $this->inventariosModel = new InventariosModel();
    }
    public function inventario()
    {
        if ($_SESSION['user']['role']) {
        }else{
            header('Location: / ');
            exit();
        }
        $nombre = isset($_GET['nombre']) ? $_GET['nombre'] : null;
        $inventariosModel = new InventariosModel();
        if (empty($nombre)) {
            $inventarios = $inventariosModel->obtenerInventarios();
            return require __DIR__ . '/../../views/dashboard/inventario.php';
        }
        $inventarios = $inventariosModel->buscarInventarios($nombre);
        return require __DIR__ . '/../../views/dashboard/inventario.php';
    }


    public function Guardado()
    {
        $nombre = $_POST['nombre'] ?? '';
        $cantidad = $_POST['cantidad'] ?? '';
        $descripcion = $_POST['descripcion'] ?? '';
        $fechaAdquisicion = $_POST['fechaAdquisicion'] ?? '';

        if (empty($nombre)) {
            echo "El campo de nombre es obligatorio.";
            return;
        }
        if (empty($cantidad)) {
            echo "El campo de cantidad es obligatorio.";
            return;
        }

        $result = $this->inventariosModel->agregarInventario($nombre, $descripcion, $cantidad, $fechaAdquisicion);

        if ($result == "Nuevo inventario agregado exitosamente") {
            header("Location: /dashboard/inventario");
            exit();
        } else {
            echo $result;
        }
    }

    public function Eliminar()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $data['id'] ?? '';

        if (empty($id)) {
            echo "El ID del inventario es obligatorio.";
            return;
        }

        $result = $this->inventariosModel->eliminarInventario($id);

        if ($result == "Inventario eliminado exitosamente") {
            echo json_encode(["message" => "Inventario eliminado exitosamente"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Error al eliminar el inventario"]);
        }
    }

    public function ObtenerInventario($id)
    {
        $inventario = $this->inventariosModel->obtenerInventarioPorId($id);
        echo json_encode($inventario);
    }

    public function Actualizar()
    {
        $id = $_POST['id'] ?? '';
        $nombre = $_POST['nombre'] ?? '';
        $cantidad = $_POST['cantidad'] ?? '';
        $descripcion = $_POST['descripcion'] ?? '';
        $fechaAdquisicion = $_POST['fechaAdquisicion'] ?? '';

        if (empty($id)) {
            echo "El ID del inventario es obligatorio.";
            return;
        }
        if (empty($nombre)) {
            echo "El campo de nombre es obligatorio.";
            return;
        }
        if (empty($cantidad)) {
            echo "El campo de cantidad es obligatorio.";
            return;
        }

        $result = $this->inventariosModel->actualizarInventario($id, $nombre, $descripcion, $cantidad, $fechaAdquisicion);

        if ($result == "Inventario actualizado exitosamente") {
            header("Location: /dashboard/inventario");
            exit();
        } else {
            echo $result;
        }
    }
}
