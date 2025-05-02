<?php
require_once __DIR__ . '/../../models/EstudiantesModel.php';

class EstudiantesController
{
    private $estudiantesModel;

    public function __construct()
    {
        $this->estudiantesModel = new EstudiantesModel();
    }
    public function estudiantes()
    {
        $nombre = isset($_GET['nombre']) ? $_GET['nombre'] : null;
        $apellido = isset($_GET['apellido']) ? $_GET['apellido'] : null;
        $carnet = isset($_GET['carnet']) ? $_GET['carnet'] : null;
        $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $resultadosPorPagina = isset($_GET['resultadosPorPagina']) ? (int)$_GET['resultadosPorPagina'] : 10;
        
        $estudiantesModel = new EstudiantesModel();
        $estudiantes = $estudiantesModel->obtenerEstudiantes($nombre, $apellido, $carnet, $pagina, $resultadosPorPagina);
        return require __DIR__ . '/../../views/dashboard/estudiantes.php';
    }

    public function Guardado()
    {
        $expedido = $_POST['expedido'] ?? '';
        $nombre = $_POST['nombre'] ?? '';
        $apellido = $_POST['apellido'] ?? '';
        $correo = $_POST['correo'] ?? '';
        $carnet = $_POST['carnet'] ?? '';
        $telefono = $_POST['telefono'] ?? '';
        $direccion = $_POST['direccion'] ?? '';
        $carnetExpedido = $carnet . '-' . $expedido;

        $upload_dir = 'storage/uploads/estudiantes/';
        if (empty($nombre) || empty($apellido) || empty($correo)) {
            echo "Los campos Nombre, Apellido y Correo son obligatorios.";
            return;
        }
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
            $valid_types = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($_FILES['foto']['type'], $valid_types)) {
                $error = "El archivo debe ser una foto JPG, PNG o GIF.";
                return;
            }
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            $extension = pathinfo(basename($_FILES['foto']['name']), PATHINFO_EXTENSION);
            $image_name = 'Foto_' . $carnet . '_' . $nombre . '_' . $apellido . '.' . $extension;
            $image_path = $upload_dir . $image_name;


            if (!move_uploaded_file($_FILES['foto']['tmp_name'], $image_path)) {
                $error = "Error al subir la foto.";
                return;
            }
        } else {
            $error = "Por favor, suba una foto.";
        }
        $result = $this->estudiantesModel->agregarEstudiante($nombre, $apellido, $correo, $carnetExpedido, $telefono, $direccion, $image_name);

        if ($result == "Nuevo estudiante agregado exitosamente") {
            header("Location: /dashboard/estudiantes");
            exit();
        } else {
            echo $result;
        }
    }
    public function ObtenerEstudiante($id)
    {
        $estudiante = $this->estudiantesModel->obtenerEstudiantePorId($id);
        echo json_encode($estudiante);
    }


    public function Eliminar()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $data['id'] ?? '';

        if (empty($id)) {
            echo "El ID del estudiante es obligatorio.";
            return;
        }

        $estudiante = $this->estudiantesModel->obtenerEstudiantePorId($id);

        if (is_array($estudiante)) {
            $fotoPath = 'storage/uploads/estudiantes/' . $estudiante['foto'];

            if (file_exists($fotoPath)) {
                unlink($fotoPath);
            }
        }

        $result = $this->estudiantesModel->eliminarEstudiante($id);

        if ($result == "Estudiante eliminado exitosamente") {
            echo json_encode(["message" => "Estudiante y sus archivos eliminados exitosamente"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Error al eliminar el estudiante"]);
        }
    }

    public function Actualizar()
    {
        $id = $_POST['id'] ?? '';
        $expedido = $_POST['expedido'] ?? '';
        $nombre = $_POST['nombre'] ?? '';
        $apellido = $_POST['apellido'] ?? '';
        $correo = $_POST['correo'] ?? '';
        $carnet = $_POST['carnet'] ?? '';
        $telefono = $_POST['telefono'] ?? '';
        $direccion = $_POST['direccion'] ?? '';
        $carnetExpedido = $carnet . '-' . $expedido;

        $upload_dir = 'storage/uploads/estudiantes/';

        if (empty($id)) {
            echo "El ID del estudiante es obligatorio.";
            return;
        }

        if (empty($nombre) || empty($apellido) || empty($correo)) {
            echo "Los campos Nombre, Apellido y Correo son obligatorios.";
            return;
        }
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
            $valid_types = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($_FILES['foto']['type'], $valid_types)) {
                $error = "El archivo debe ser una foto JPG, PNG o GIF.";
                return;
            }
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            $extension = pathinfo(basename($_FILES['foto']['name']), PATHINFO_EXTENSION);
            $image_name = 'Foto_' . $carnet . '_' . $nombre . '_' . $apellido . '.' . $extension;
            $image_path = $upload_dir . $image_name;


            if (!move_uploaded_file($_FILES['foto']['tmp_name'], $image_path)) {
                $error = "Error al subir la foto.";
                return;
            }
        } else {
            $error = "Por favor, suba una foto.";
        }
        $result = $this->estudiantesModel->actualizarEstudiante($id, $nombre, $apellido, $correo, $carnetExpedido, $telefono, $direccion, $image_name);

        if ($result == "Estudiante actualizado exitosamente") {
            header("Location: /dashboard/estudiantes");
            exit();
        } else {
            echo $result;
        }
    }
}
