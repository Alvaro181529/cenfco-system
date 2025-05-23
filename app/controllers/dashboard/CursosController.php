<?php
require_once __DIR__ . '/../../models/CursosModel.php';
require_once __DIR__ . '/../../models/CertificadosModel.php';
require_once __DIR__ . '/../../models/DocentesModel.php';

class CursosController
{
    private $cursosModel;
    private $certificadosModel;

    public function __construct()
    {
        $this->cursosModel = new CursosModel();
        $this->certificadosModel = new CertificadosModel();
    }

    public function cursos()
    {
        // Verificación de rol
        if (!isset($_SESSION['user']['role'])) {
            header('Location: /');
            exit();
        }

        // Obtener los filtros de la URL
        $titulo = isset($_GET['titulo']) ? $_GET['titulo'] : null;
        $descripcion = isset($_GET['descripcion']) ? $_GET['descripcion'] : null;
        $categoria = isset($_GET['categoria']) ? $_GET['categoria'] : null;

        // Obtener parámetros de paginación
        $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;  // Página por defecto es 1
        $resultadosPorPagina = isset($_GET['resultadosPorPagina']) ? (int)$_GET['resultadosPorPagina'] : 10;  // 10 resultados por página por defecto

        // Instanciar modelos
        $docentesModel = new DocentesModel();
        $cursosModel = new CursosModel();

        // Obtener docentes
        $docentes = $docentesModel->obtenerDocentes();

        // Buscar cursos con los filtros
        $cursos = $cursosModel->obtenerCursos($titulo, $descripcion, $categoria, $pagina, $resultadosPorPagina);

        // Pasar los resultados y la información de paginación a la vista
        return require __DIR__ . '/../../views/dashboard/cursos.php';
    }


    public function Guardado()
    {
        $titulo = $_POST['titulo'] ?? '';
        $descripcion = $_POST['descripcion'] ?? '';
        $precio = $_POST['precio'] ?? '';
        $docente = $_POST['docente'] ?? '';
        $categoria = $_POST['categoria'] ?? '';
        $fechaInicio = $_POST['fechaInicio'] ?? '';
        $fechaFin = $_POST['fechaFin'] ?? '';
        $mostrar = isset($_POST['mostrar']) ? true : false;

        $certificado = isset($_POST['certificado']) ? true : false;
        $certificadoPrecio = $_POST['certificadoPrecio'] ?? 0;

        if (empty($titulo)  || empty($precio)) {
            $error = "Los campos titulo y precio son obligatorios.";
            return;
        }
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
            $valid_types = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($_FILES['imagen']['type'], $valid_types)) {
                $error = "El archivo debe ser una imagen JPG, PNG o GIF.";
                return;
            }
            $upload_dir = 'storage/uploads/cursos/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            $extension = pathinfo(basename($_FILES['imagen']['name']), PATHINFO_EXTENSION);
            $image_name = $titulo . uniqid() . '.' . $extension;
            $image_path = $upload_dir . $image_name;


            if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $image_path)) {
                $error = "Error al subir la imagen.";
                return;
            }
        } else {
            $error = "Por favor, suba una imagen.";
        }
        if ($certificado) {
            $resultCertificado = $this->certificadosModel->agregarCertificado($titulo, $certificadoPrecio, $precio, $descripcion);
        }

        $result = $this->cursosModel->agregarCursos($titulo, $descripcion, $precio, $docente, $image_name, $categoria, $fechaInicio, $fechaFin, $mostrar);
        if ($resultCertificado == "Nuevo certificado agregado exitosamente") {
            header("Location: /dashboard/cursos");
            exit();
        } else {
            echo $resultCertificado;
        }
        if ($result == "Nuevo curso agregado exitosamente") {
            header("Location: /dashboard/cursos");
            exit();
        } else {
            $error = $result;
        }
    }

    public function ObtenerCurso($id)
    {
        $curso = $this->cursosModel->obtenerCursoPorId($id);
        echo json_encode($curso);
    }

    public function Actualizar()
    {
        $id = $_POST['id'] ?? '';
        $titulo = $_POST['titulo'] ?? '';
        $descripcion = $_POST['descripcion'] ?? '';
        $precio = $_POST['precio'] ?? '';
        $docente = $_POST['docente'] ?? '';
        $categoria = $_POST['categoria'] ?? '';
        $fechaInicio = $_POST['fechaInicio'] ?? '';
        $fechaFin = $_POST['fechaFin'] ?? '';
        $mostrar = isset($_POST['mostrar']) ? true : false;

        $imagen_antigua = $_POST['imagen_antigua'] ?? '';

        if (empty($id) || empty($titulo) || empty($precio)) {
            $error = "El ID, título y precio son obligatorios.";
            return;
        }


        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
            $valid_types = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($_FILES['imagen']['type'], $valid_types)) {
                $error = "El archivo debe ser una imagen JPG, PNG o GIF.";
                return;
            }


            if (!empty($imagen_antigua) && file_exists('storage/uploads/cursos/' . $imagen_antigua)) {
                unlink('storage/uploads/cursos/' . $imagen_antigua);
            }


            $upload_dir = 'storage/uploads/cursos/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            $extension = pathinfo(basename($_FILES['imagen']['name']), PATHINFO_EXTENSION);
            $new_image_name = $titulo . uniqid() . '.' . $extension;
            $new_image_path = $upload_dir . $new_image_name;

            if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $new_image_path)) {
                $error = "Error al subir la imagen.";
                return;
            }
        }


        $result = $this->cursosModel->actualizarCurso($id, $titulo, $descripcion, $precio, $docente, $categoria, $new_image_name, $fechaInicio, $fechaFin, $mostrar);

        if ($result == "Curso actualizado exitosamente") {
            header("Location: /dashboard/cursos");
            exit();
        } else {
            $error = $result;
        }
    }


    public function Eliminar()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $data['id'] ?? '';

        if (empty($id)) {
            http_response_code(400);
            echo json_encode(["error" => "El ID del curso es obligatorio."]);
            return;
        }
        $curso = $this->cursosModel->obtenerCursoPorId($id);
        if (empty($curso)) {
            http_response_code(404);
            echo json_encode(["error" => "Curso no encontrado."]);
            return;
        }
        $image_path = 'storage/uploads/cursos/' . $curso['imagen'];
        if (file_exists($image_path)) {
            if (!unlink($image_path)) {
                http_response_code(500);
                echo json_encode(["error" => "No se pudo eliminar la imagen."]);
                return;
            }
        }
        $result = $this->cursosModel->eliminarCurso($id);
        if ($result == "Curso eliminado exitosamente") {
            echo json_encode(["message" => "Curso eliminado exitosamente"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Error al eliminar el curso"]);
        }
    }
}
