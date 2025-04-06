<?php
require_once __DIR__ . '/../../models/DocentesModel.php';

class DocentesController
{
    private $docentesModel;

    public function __construct()
    {
        $this->docentesModel = new DocentesModel();
    }
    public function docentes()
    {
        if ($_SESSION['user']['role']) {
        }else{
            header('Location: / ');
            exit();
        }
        $docentesModel = new DocentesModel();
        $docentes = $docentesModel->obtenerDocentes();
        $query = $_GET['query'] ?? '';
        if (empty($query)) {
            return require __DIR__ . '/../../views/dashboard/docentes.php';
        }
        $docentes = $this->docentesModel->buscarDocentes($query);
        return require __DIR__ . '/../../views/dashboard/docentes.php';
    }

    public function Guardado()
    {
        $nombre = $_POST['nombre'] ?? '';
        $apellido = $_POST['apellido'] ?? '';
        $correo = $_POST['correo'] ?? '';
        $carnet = $_POST['carnet'] ?? '';
        $telefono = $_POST['telefono'] ?? '';
        $estadoCivil = $_POST['estadoCivil'] ?? '';
        $universidad = $_POST['universidad'] ?? '';
        $observacion = $_POST['observacion'] ?? '';
        $direccion = $_POST['direccion'] ?? '';

        $upload_dir = 'storage/uploads/docentes/';

        if (empty($nombre) || empty($apellido) || empty($correo)) {
            echo "Los campos Nombre, Apellido y Correo son obligatorios.";
            return;
        }

        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
            $valid_types = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($_FILES['imagen']['type'], $valid_types)) {
                echo "El archivo debe ser una imagen JPG, PNG o GIF.";
                return;
            }
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            $extension = pathinfo(basename($_FILES['imagen']['name']), PATHINFO_EXTENSION);
            $image_name = 'Foto_' . $carnet . '_' . $nombre . '_' . $apellido . '.' . $extension;
            $image_path = $upload_dir . $image_name;

            if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $image_path)) {
                echo "Error al subir la imagen.";
                return;
            }
        }

        if (isset($_FILES['firma']) && $_FILES['firma']['error'] == 0) {
            $valid_image_types = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($_FILES['firma']['type'], $valid_image_types)) {
                echo "La firma debe ser una imagen JPG, PNG o GIF.";
                return;
            }

            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            $extension = pathinfo(basename($_FILES['firma']['name']), PATHINFO_EXTENSION);
            $firma_name = 'Firma_' . $carnet . '_' . $nombre . '_' . $apellido . '.' . $extension;
            $firma_path = $upload_dir . $firma_name;

            if (!move_uploaded_file($_FILES['firma']['tmp_name'], $firma_path)) {
                echo "Error al subir la firma.";
                return;
            }
        }

        if (isset($_FILES['curriculum']) && $_FILES['curriculum']['error'] == 0) {
            $valid_pdf_types = ['application/pdf'];
            if (!in_array($_FILES['curriculum']['type'], $valid_pdf_types)) {
                echo "El archivo debe ser un PDF.";
                return;
            }

            $pdf_extension = pathinfo(basename($_FILES['curriculum']['name']), PATHINFO_EXTENSION);
            $pdf_name = 'Curriculum_' . $carnet . '_' . $nombre . '_' . $apellido . '.' . $pdf_extension;
            $pdf_path = $upload_dir . $pdf_name;

            if (!move_uploaded_file($_FILES['curriculum']['tmp_name'], $pdf_path)) {
                echo "Error al subir el curriculum.";
                return;
            }
        }

        $result = $this->docentesModel->agregarDocente($nombre, $apellido, $correo, $carnet, $telefono, $estadoCivil, $universidad, $observacion, $direccion, $image_name, $firma_name, $pdf_name);

        if ($result == "Nuevo docente agregado exitosamente") {
            header("Location: /dashboard/docentes");
            exit();
        } else {
            echo $result;
        }
    }

    public function ObtenerDocente($id)
    {
        $docente = $this->docentesModel->obtenerDocentePorId($id);
        echo json_encode($docente);
    }

    public function Eliminar()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $data['id'] ?? '';

        if (empty($id)) {
            echo "El ID del docente es obligatorio.";
            return;
        }

        $docente = $this->docentesModel->obtenerDocentePorId($id);

        if (is_array($docente)) {
            $upload_dir = 'storage/uploads/docentes/';
            $imagePath = $upload_dir . $docente['foto'];
            $firmaPath = $upload_dir . $docente['firma'];
            $pdfPath = $upload_dir . $docente['curriculum'];

            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            if (file_exists($firmaPath)) {
                unlink($firmaPath);
            }
            if (file_exists($pdfPath)) {
                unlink($pdfPath);
            }
        }

        $result = $this->docentesModel->eliminarDocente($id);

        if ($result == "Docente eliminado exitosamente") {
            echo json_encode(["message" => "Docente y sus archivos eliminados exitosamente"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Error al eliminar el docente"]);
        }
    }

    public function Actualizar()
    {
        $id = $_POST['id'] ?? '';
        $nombre = $_POST['nombre'] ?? '';
        $apellido = $_POST['apellido'] ?? '';
        $correo = $_POST['correo'] ?? '';
        $carnet = $_POST['carnet'] ?? '';
        $telefono = $_POST['telefono'] ?? '';
        $estadoCivil = $_POST['estadoCivil'] ?? '';
        $universidad = $_POST['universidad'] ?? '';
        $observacion = $_POST['observacion'] ?? '';
        $direccion = $_POST['direccion'] ?? '';

        $upload_dir = 'storage/uploads/docentes/';

        if (empty($id)) {
            echo "El ID del docente es obligatorio.";
            return;
        }
        if (empty($nombre) || empty($apellido) || empty($correo)) {
            echo "Los campos Nombre, Apellido y Correo son obligatorios.";
            return;
        }

        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
            $valid_types = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($_FILES['imagen']['type'], $valid_types)) {
                echo "El archivo debe ser una imagen JPG, PNG o GIF.";
                return;
            }
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            $extension = pathinfo(basename($_FILES['imagen']['name']), PATHINFO_EXTENSION);
            $image_name = 'Foto_' . $carnet . '_' . $nombre . '_' . $apellido . '.' . $extension;
            $image_path = $upload_dir . $image_name;

            if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $image_path)) {
                echo "Error al subir la imagen.";
                return;
            }
        }

        if (isset($_FILES['firma']) && $_FILES['firma']['error'] == 0) {
            $valid_image_types = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($_FILES['firma']['type'], $valid_image_types)) {
                echo "La firma debe ser una imagen JPG, PNG o GIF.";
                return;
            }

            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            $extension = pathinfo(basename($_FILES['firma']['name']), PATHINFO_EXTENSION);
            $firma_name = 'Firma_' . $carnet . '_' . $nombre . '_' . $apellido . '.' . $extension;
            $firma_path = $upload_dir . $firma_name;

            if (!move_uploaded_file($_FILES['firma']['tmp_name'], $firma_path)) {
                echo "Error al subir la firma.";
                return;
            }
        }

        if (isset($_FILES['curriculum']) && $_FILES['curriculum']['error'] == 0) {
            $valid_pdf_types = ['application/pdf'];
            if (!in_array($_FILES['curriculum']['type'], $valid_pdf_types)) {
                echo "El archivo debe ser un PDF.";
                return;
            }

            $pdf_extension = pathinfo(basename($_FILES['curriculum']['name']), PATHINFO_EXTENSION);
            $pdf_name = 'Curriculum_' . $carnet . '_' . $nombre . '_' . $apellido . '.' . $pdf_extension;
            $pdf_path = $upload_dir . $pdf_name;

            if (!move_uploaded_file($_FILES['curriculum']['tmp_name'], $pdf_path)) {
                echo "Error al subir el curriculum.";
                return;
            }
        }

        $result = $this->docentesModel->actualizarDocente($id, $nombre, $apellido, $correo, $carnet, $telefono, $estadoCivil, $universidad, $observacion, $direccion, $image_name ?? null, $firma_name ?? null, $pdf_name ?? null);

        if ($result == "Docente actualizado exitosamente") {
            header("Location: /dashboard/docentes");
            exit();
        } else {
            echo $result;
        }
    }
}
