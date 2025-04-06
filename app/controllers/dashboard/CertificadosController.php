<?php
require_once __DIR__ . '/../../models/CertificadosModel.php';

class CertificadosController
{
    private $certificadosModel;

    public function __construct()
    {
        $this->certificadosModel = new CertificadosModel();
    }

    public function certificados()
    {
        if ($_SESSION['user']['role']) {
        }else{
            header('Location: / ');
            exit();
        }
        $titulo = isset($_GET['titulo']) ? $_GET['titulo'] : null;
        $certificadosModel = new CertificadosModel();
        if (empty($titulo)) {
            $certificados = $certificadosModel->obtenerCertificados();
            return require __DIR__ . '/../../views/dashboard/certificados.php';
        }
        
        $certificados = $certificadosModel->buscarCertificados($titulo);
        return require __DIR__ . '/../../views/dashboard/certificados.php';
    }
    public function Guardado()
    {
        $titulo = $_POST['titulo'] ?? '';
        $precioIndividual = $_POST['precioIndividual'] ?? '';
        $precioCurso = $_POST['precioCurso'] ?? '';
        $descripcion = $_POST['descripcion'] ?? '';
        $fecha = $_POST['fechaEmision'] ?? '';


        if (empty($titulo)) {
            echo "El campo de título es obligatorio.";
            return;
        }


        $result = $this->certificadosModel->agregarCertificado($titulo, $precioIndividual, $precioCurso, $descripcion, $fecha);


        if ($result == "Nuevo certificado agregado exitosamente") {
            header("Location: /dashboard/certificados");
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
            echo "El ID del certificado es obligatorio.";
            return;
        }


        $result = $this->certificadosModel->eliminarCertificado($id);


        if ($result == "Certificado eliminado exitosamente") {
            echo json_encode(["message" => "Curso eliminado exitosamente"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Error al eliminar el curso"]);
        }
    }


    public function ObtenerCertificado($id)
    {
        $certificado = $this->certificadosModel->obtenerCertificadoPorId($id);
        echo json_encode($certificado);
    }


    public function Actualizar()
    {
        $id = $_POST['id'] ?? '';
        $titulo = $_POST['titulo'] ?? '';
        $precioIndividual = $_POST['precioIndividual'] ?? '';
        $precioCurso = $_POST['precioCurso'] ?? '';
        $descripcion = $_POST['descripcion'] ?? '';
        $fecha = $_POST['fechaEmision'] ?? '';


        if (empty($id)) {
            echo "El ID del certificado es obligatorio.";
            return;
        }
        if (empty($titulo)) {
            echo "El campo de título es obligatorio.";
            return;
        }


        $result = $this->certificadosModel->actualizarCertificado($id, $titulo, $precioIndividual, $precioCurso, $descripcion, $fecha);


        if ($result == "Certificado actualizado exitosamente") {
            header("Location: /dashboard/certificados");
            exit();
        } else {
            echo $result;
        }
    }
}
