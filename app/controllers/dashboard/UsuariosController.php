<?php
require_once __DIR__ . '/../../models/UsuariosModel.php';

class UsuariosController
{
    private $usuariosModel;

    public function __construct()
    {
        $this->usuariosModel = new UsuariosModel();
    }
    
    public function usuarios()
    {
        if ($_SESSION['user']['role']) {
        }else{
            header('Location: / ');
            exit();
        }
        $searchTerm = $_GET['search'] ?? '';
        $usuariosModel = new UsuariosModel();
        if (empty($searchTerm)) {
            $usuarios = $usuariosModel->obtenerUsuarios();
            return require __DIR__ . '/../../views/dashboard/usuarios.php';
        }
        $usuarios = $usuariosModel->buscarUsuarios($searchTerm);
        return require __DIR__ . '/../../views/dashboard/usuarios.php';
    }
    public function Guardado()
    {
        $nombre = $_POST['nombre'] ?? '';
        $correo = $_POST['correo'] ?? '';
        $password = $_POST['password'] ?? '';
        $rol = $_POST['rol'] ?? '';

        if (empty($nombre)) {
            echo "El campo de nombre es obligatorio.";
            return;
        }
        if (empty($correo)) {
            echo "El campo de correo es obligatorio.";
            return;
        }

        $result = $this->usuariosModel->agregarUsuarios($nombre, $correo, $rol, $password);

        if ($result == "Nuevo usuarios agregado exitosamente") {
            header("Location: /dashboard/usuarios");
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
            echo "El ID del usuario es obligatorio.";
            return;
        }

        $result = $this->usuariosModel->eliminarUsuarios($id);

        if ($result == "Usuarios eliminado exitosamente") {
            echo json_encode(["message" => "Usuarios eliminado exitosamente"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Error al eliminar el usuario"]);
        }
    }

    public function ObtenerUsuarios($id)
    {
        $usuario = $this->usuariosModel->obtenerUsuariosPorId($id);
        echo json_encode($usuario);
    }

    public function Actualizar()
    {
        $id = $_POST['id'] ?? '';
        $nombre = $_POST['nombre'] ?? '';
        $correo = $_POST['correo'] ?? '';
        $rol = $_POST['rol'] ?? '';

        if (empty($id)) {
            echo "El ID del usuario es obligatorio.";
            return;
        }
        if (empty($nombre)) {
            echo "El campo de nombre es obligatorio.";
            return;
        }
        if (empty($correo)) {
            echo "El campo de correo es obligatorio.";
            return;
        }

        $result = $this->usuariosModel->actualizarUsuarios($id, $nombre, $correo, $rol);

        if ($result == "Usuarios actualizado exitosamente") {
            header("Location: /dashboard/usuarios");
            exit();
        } else {
            echo $result;
        }
    }
}
