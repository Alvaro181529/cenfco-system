<?php
require_once __DIR__ . '/../models/ChatbotModel.php';

class ChatbotController
{
    private $chatbotModel;

    public function __construct()
    {
        $this->chatbotModel = new ChatbotModel();
    }

    // Buscar mensajes por contenido
    public function chatbot()
    {
        if ($_SESSION['user']['role']) {
        } else {
            header('Location: / ');
            exit();
        }
        $contenido = isset($_GET['contenido']) ? $_GET['contenido'] : null;
        if (empty($contenido)) {
            $mensajes = $this->chatbotModel->obtenerMensajes();
        } else {
            $mensajes = $this->chatbotModel->buscarMensaje($contenido);
        }
        return require __DIR__ . '/../views/dashboard/chatbot.php';
    }
    public function ObtenerChatbot($id)
    {
        $inventario = $this->chatbotModel->obtenerChatPorId($id);
        echo json_encode($inventario);
    }

    // Agregar un mensaje
    public function guardar()
    {
        $mensaje = $_POST['mensaje'] ?? '';
        $contenido = $_POST['contenido'] ?? '';

        if (empty($mensaje) || empty($contenido)) {
            echo "Ambos campos (mensaje y contenido) son obligatorios.";
            return;
        }

        $result = $this->chatbotModel->agregarMensaje($mensaje, $contenido);

        if ($result == "Nuevo mensaje agregado exitosamente.") {
            header("Location: /dashboard/chatbot");
            exit();
        } else {
            echo $result;
        }
    }

    // Eliminar un mensaje
    public function eliminar()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $data['id'] ?? '';

        if (empty($id)) {
            echo "El ID del mensaje es obligatorio.";
            return;
        }

        $result = $this->chatbotModel->eliminarMensaje($id);

        if ($result == "Mensaje eliminado exitosamente") {
            echo json_encode(["message" => "Mensaje eliminado exitosamente"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Error al eliminar el mensaje"]);
        }
    }

    // Actualizar un mensaje
    public function actualizar()
    {
        $id = $_POST['id'] ?? '';
        $mensaje = $_POST['mensaje'] ?? '';
        $contenido = $_POST['contenido'] ?? '';

        if (empty($id) || empty($mensaje) || empty($contenido)) {
            echo "El ID, mensaje y contenido son obligatorios.";
            return;
        }

        $result = $this->chatbotModel->actualizarMensaje($id, $mensaje, $contenido);

        if ($result == "Mensaje actualizado exitosamente") {
            header("Location: /dashboard/chatbot");
            exit();
        } else {
            echo $result;
        }
    }
}
