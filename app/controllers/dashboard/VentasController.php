<?php
require_once __DIR__ . '/../../models/VentasModel.php';

class VentasController
{
    private $ventasModel;

    public function __construct()
    {
        $this->ventasModel = new VentasModel();
    }
    public function ventasCertificados()
    {
        if ($_SESSION['user']['role']) {
        } else {
            header('Location: / ');
            exit();
        }
        $mes = isset($_GET['mes']) ? (int)$_GET['mes'] : date('m');
        $anio = isset($_GET['anio']) ? (int)$_GET['anio'] : date('Y');
        $certificadosModel = new CertificadosModel();
        $estudiantesModel = new EstudiantesModel();

        $estudiantes = $estudiantesModel->obtenerEstudiantes(null, null, null, 1, 1000);
        $certificados = $certificadosModel->obtenerCertificados(null, 1, 1000);
        $username = $_SESSION['user']['username'];

        if ($_SESSION['user']['role'] == "Administrador") {
            $ventas = $this->ventasModel->obtenerVentas('', 'certificado', $anio, $mes);
            $total = $this->ventasModel->obtenerTotalVentas('', 'certificado', $anio, $mes);
        } else {
            $ventas = $this->ventasModel->obtenerVentas($username, 'certificado', $anio, $mes);
            $total = $this->ventasModel->obtenerTotalVentas($username, 'certificado', $anio, $mes);
        }
        require __DIR__ . '/../../views/dashboard/ventasCertificados.php';
    }
    public function ventasCursos()
    {
        if ($_SESSION['user']['role']) {
        } else {
            header('Location: / ');
            exit();
        }
        $username = $_SESSION['user']['username'];
        $mes = isset($_GET['mes']) ? (int)$_GET['mes'] : date('m');
        $anio = isset($_GET['anio']) ? (int)$_GET['anio'] : date('Y');
        $cursosModel = new CursosModel();
        $estudiantesModel = new EstudiantesModel();
        $estudiantes = $estudiantesModel->obtenerEstudiantes(null, null, null, 1, 1000);
        $cursos = $cursosModel->obtenerCursos(null, null, null, 1, 1000);
        if ($_SESSION['user']['role'] == "Administrador") {
            $ventas = $this->ventasModel->obtenerVentas('', 'curso', $anio, $mes);
            $total = $this->ventasModel->obtenerTotalVentas('', 'curso', $anio, $mes);
        } else {
            $ventas = $this->ventasModel->obtenerVentas($username, 'curso', $anio, $mes);
            $total = $this->ventasModel->obtenerTotalVentas($username, 'curso', $anio, $mes);
        }
        require __DIR__ . '/../../views/dashboard/ventasCursos.php';
    }

    public function Guardado()
    {
        $username = $_SESSION['user']['username'];
        if (!$username) {
            $error = 'iniciar sesion';
            header('Location: / ');
        }
        $id_curso = isset($_POST['cursoId']) ? $_POST['cursoId'] : NULL;
        $id_certificado = isset($_POST['certificadoId']) ? $_POST['certificadoId'] : NULL;
        $id_estudiante = isset($_POST['estudianteId']) ? $_POST['estudianteId'] : NULL;
        $externoNombre = $_POST['estudiante'] ?? '';
        $externoCarnet = $_POST['carnet'] ?? '';
        $precio = $_POST['precio'] ?? '';
        $descripcion = $_POST['descripcion'] ?? '';
        $tipo = $_POST['tipo'] ?? '';

        if (empty($precio) || empty($tipo)) {
            echo "Todos los campos son obligatorios.";
            return;
        }
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
            $valid_types = ['image/jpeg', 'image/png', 'image/gif', 'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
            if (!in_array($_FILES['imagen']['type'], $valid_types)) {
                $error = "El archivo debe ser una imagen JPG, PNG o GIF.";
                return;
            }
            $upload_dir = 'storage/uploads/comprobante/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            $extension = pathinfo(basename($_FILES['imagen']['name']), PATHINFO_EXTENSION);
            $image_name = $tipo . '-' . $externoCarnet . uniqid() . '.' . $extension;
            $image_path = $upload_dir . $image_name;


            if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $image_path)) {
                $error = "Error al subir la imagen.";
                return;
            }
            error_log($image_name);
            $result = $this->ventasModel->agregarVentas($id_curso, $id_certificado, $id_estudiante, $externoNombre, $externoCarnet, $precio, $descripcion, $tipo, $username, $image_name);
            error_log($result);
            if ($result == "Venta agregada exitosamente") {
                if ($tipo == "curso") {
                    header("Location: /dashboard/ventas/cursos");
                } else {
                    header("Location: /dashboard/ventas/certificados");
                }
                exit();
            } else {
                echo $result;
            }
        } else {
            error_log('Aca no hay imagen');
            $error = "Por favor, suba una imagen.";
        }
    }
    public function Eliminar()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $data['id'] ?? '';
        if (empty($id)) {
            echo "El ID de la venta es obligatorio.";
            return;
        }

        $result = $this->ventasModel->eliminarVentas($id);

        if ($result == "Venta eliminada exitosamente") {
            echo json_encode(["message" => "Venta eliminada exitosamente"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Error al eliminar la venta"]);
        }
    }

    public function ObtenerVenta($id)
    {
        $venta = $this->ventasModel->obtenerVentasPorId($id);
        echo json_encode($venta);
    }

    public function Actualizar()
    {
        $username = $_SESSION['user']['username'];
        if (!$username) {
            $error = 'iniciar sesion';
            header('Location: / ');
        }
        $id = $_POST['id'] ?? '';
        $id_curso = isset($_POST['cursoId']) ? $_POST['cursoId'] : NULL;
        $id_certificado = isset($_POST['certificadoId']) ? $_POST['certificadoId'] : NULL;
        $id_estudiante = isset($_POST['estudianteId']) ? $_POST['estudianteId'] : NULL;
        $externoNombre = $_POST['estudiante'] ?? '';
        $externoCarnet = $_POST['carnet'] ?? '';
        $precio = $_POST['precio'] ?? '';
        $descripcion = $_POST['descripcion'] ?? '';
        $tipo = $_POST['tipo'] ?? '';

        if (empty($id)) {
            echo "El ID de la venta es obligatorio.";
            return;
        }
        if (empty($precio) || empty($tipo)) {
            echo "Todos los campos son obligatorios.";
            return;
        }

        $result = $this->ventasModel->actualizarVentas($id, $id_curso, $id_certificado, $id_estudiante, $externoNombre, $externoCarnet, $precio, $descripcion, $tipo, $username);

        if ($result == "Venta actualizada exitosamente") {
            if ($tipo == "curso") {
                header("Location: /dashboard/ventas/cursos");
            } else {
                header("Location: /dashboard/ventas/certificados");
            }
            exit();
        } else {
            echo $result;
        }
    }
}
