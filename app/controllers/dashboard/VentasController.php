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
        }else{
            header('Location: / ');
            exit();
        }
        $username = $_SESSION['user']['username'];
        $certificadosModel = new CertificadosModel();
        $estudiantesModel = new EstudiantesModel();
        $estudiantes = $estudiantesModel->obtenerEstudiantes();
        $certificados = $certificadosModel->obtenerCertificados();
        if ($_SESSION['user']['role'] == "Administrador") {
            $ventas = $this->ventasModel->obtenerVentas('', 'certificado');
            $total = $this->ventasModel->obtenerTotalVentas('', 'certificado');
        } else {
            $total = $this->ventasModel->obtenerVentas($username, 'certificado');
            $ventas = $this->ventasModel->obtenerTotalVentas($username, 'certificado');
        }
        require __DIR__ . '/../../views/dashboard/ventasCertificados.php';
    }
    public function ventasCursos()
    {
        if ($_SESSION['user']['role']) {
        }else{
            header('Location: / ');
            exit();
        }
        $username = $_SESSION['user']['username'];
        $cursosModel = new CursosModel();
        $estudiantesModel = new EstudiantesModel();
        $estudiantes = $estudiantesModel->obtenerEstudiantes();
        $cursos = $cursosModel->obtenerCursos();
        if ($_SESSION['user']['role'] == "Administrador") {
            $ventas = $this->ventasModel->obtenerVentas('', 'curso');
            $total = $this->ventasModel->obtenerTotalVentas('', 'curso');
        } else {
            $ventas = $this->ventasModel->obtenerVentas($username, 'curso');
            $total = $this->ventasModel->obtenerTotalVentas($username, 'curso');
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
        error_log($id_estudiante);
        if (empty($precio) || empty($tipo)) {
            echo "Todos los campos son obligatorios.";
            return;
        }

        $result = $this->ventasModel->agregarVentas($id_curso, $id_certificado, $id_estudiante, $externoNombre, $externoCarnet, $precio, $descripcion, $tipo, $username);

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
