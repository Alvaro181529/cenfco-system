<?php
require_once __DIR__ . '/../../models/ComentarioModel.php';

class ComentariosController
{
    private $comentariosModel;

    public function __construct()
    {
        $this->comentariosModel = new ComentariosModel();
    }

    // Método para mostrar todos los comentarios o filtrarlos por asunto
    public function comentarios()
    {
        // Verifica si el usuario tiene el rol adecuado
        if ($_SESSION['user']['role']) {
            // Obtenemos los parámetros de búsqueda desde la URL
            $asunto = isset($_GET['asunto']) ? $_GET['asunto'] : null;
            $nombre = isset($_GET['nombre']) ? $_GET['nombre'] : null;
            $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1; // Si no se pasa página, se asume página 1

    
            // Llamamos al modelo para buscar los comentarios con los filtros de asunto y nombre y la paginación
            $comentarios = $this->comentariosModel->obtenerComentarios($asunto, $nombre, $pagina);
            // Pasamos los datos a la vista
            return require __DIR__ . '/../../views/dashboard/comentarios.php';
        } else {
            // Si el usuario no tiene rol adecuado, lo redirigimos a la página principal
            header('Location: /');
            exit();
        }
    }
    
    // Método para guardar un nuevo comentario
    public function Guardado()
    {
        $nombre = $_POST['nombre'] ?? '';
        $correo = $_POST['correo'] ?? '';
        $asunto = $_POST['asunto'] ?? '';
        $mensaje = $_POST['mensaje'] ?? '';

        if (empty($nombre) || empty($correo) || empty($asunto) || empty($mensaje)) {
            echo "Todos los campos son obligatorios.";
            return;
        }

        $result = $this->comentariosModel->agregarComentario($nombre, $correo, $asunto, $mensaje);

        if ($result == "Nuevo comentario agregado exitosamente") {
            header("Location: /dashboard/comentarios");
            exit();
        } else {
            echo $result;
        }
    }
    public function GuardadoHome()
    {
        $nombre = $_POST['nombre'] ?? '';
        $correo = $_POST['correo'] ?? '';
        $asunto = $_POST['asunto'] ?? '';
        $mensaje = $_POST['mensaje'] ?? '';
        $error = '';

        if (empty($nombre) || empty($correo) || empty($asunto) || empty($mensaje)) {
            echo "Todos los campos son obligatorios.";
            return;
        }

        $result = $this->comentariosModel->agregarComentario($nombre, $correo, $asunto, $mensaje);

        if ($result == "Nuevo comentario agregado exitosamente") {
            echo 'OK';
            exit();
        } else {
            echo 'No se pudo enviar el mensaje';
        }
    }

    // Método para eliminar un comentario
    public function Eliminar()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $data['id'] ?? '';

        if (empty($id)) {
            echo "El ID del comentario es obligatorio.";
            return;
        }

        $result = $this->comentariosModel->eliminarComentario($id);

        if ($result == "Comentario eliminado exitosamente") {
            echo json_encode(["message" => "Comentario eliminado exitosamente"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Error al eliminar el comentario"]);
        }
    }

    // Método para obtener un comentario por su ID
    public function ObtenerComentario($id)
    {
        $comentario = $this->comentariosModel->obtenerComentarioPorId($id);
        echo json_encode($comentario);
    }

    // Método para actualizar un comentario
    public function Actualizar()
    {
        $id = $_POST['id'] ?? '';
        $nombre = $_POST['nombre'] ?? '';
        $correo = $_POST['correo'] ?? '';
        $asunto = $_POST['asunto'] ?? '';
        $mensaje = $_POST['mensaje'] ?? '';

        if (empty($id)) {
            echo "El ID del comentario es obligatorio.";
            return;
        }
        if (empty($nombre) || empty($correo) || empty($asunto) || empty($mensaje)) {
            echo "Todos los campos son obligatorios.";
            return;
        }

        $result = $this->comentariosModel->actualizarComentario($id, $nombre, $correo, $asunto, $mensaje);

        if ($result == "Comentario actualizado exitosamente") {
            header("Location: /dashboard/comentarios");
            exit();
        } else {
            echo $result;
        }
    }
}
