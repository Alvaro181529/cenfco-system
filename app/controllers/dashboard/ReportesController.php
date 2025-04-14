<?php
require_once __DIR__ . '/../../models/ReportesModel.php';
require_once __DIR__ . '/../../models/VentasModel.php';

require_once __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/../../models/UsuariosModel.php';

require_once __DIR__ . '/../../models/DashboardModel.php';


use Box\Spout\Writer\Common\Creator\WriterEntityFactory;

class ReportesController
{
    private $reportesModel;

    public function __construct()
    {
        $this->reportesModel = new ReportesModel();
    }


    public function Reportes()
    {
        if ($_SESSION['user']['role']) {
        } else {
            header('Location: / ');
            exit();
        }
        $dashboardModel = new DashboardModel();
        $usuariosModel = new UsuariosModel();
        $usuarios = $usuariosModel->obtenerUsuarios();

        $cantidadEstudiantes = $dashboardModel->cantidadEstudiantes();
        $cantidadDocentes = $dashboardModel->cantidadDocentes();
        $cantidadCursos = $dashboardModel->cantidadCursos();
        $cantidadInventario = $dashboardModel->cantidadInventario();
        $usuers =
            require __DIR__ . '/../../views/dashboard/reportes.php';
    }
    //certificados
    public function descargarExcelCertificados()
    {
        $fechaInicio = isset($_GET['fechaInicio']) ? $_GET['fechaInicio'] : null;
        $fechaFin = isset($_GET['fechaFin']) ? $_GET['fechaFin'] : null;
        $reportes = $this->reportesModel->certificadosReportes($fechaInicio, $fechaFin);
        $writer = WriterEntityFactory::createXLSXWriter();
        $writer->openToBrowser('reporte_certificados.xlsx');
        $headerCells = [
            WriterEntityFactory::createCell('#'),
            WriterEntityFactory::createCell('Titulo'),
            WriterEntityFactory::createCell('Fecha'),
        ];

        $headerRow = WriterEntityFactory::createRow($headerCells);
        $writer->addRow($headerRow);
        foreach ($reportes as $reporte) {
            $rowCells = [
                WriterEntityFactory::createCell($reporte['id']),
                WriterEntityFactory::createCell($reporte['titulo']),
                WriterEntityFactory::createCell($reporte['create_at']),
            ];

            $row = WriterEntityFactory::createRow($rowCells);
            $writer->addRow($row);
        }

        $writer->close();
        echo "<script type='text/javascript'>window.location.href = '/dashboard/docentes';</script>";
    }

    public function descargarPdfCertificados()
    {
        $fechaInicio = isset($_GET['fechaInicio']) ? $_GET['fechaInicio'] : null;
        $fechaFin = isset($_GET['fechaFin']) ? $_GET['fechaFin'] : null;

        $reportes = $this->reportesModel->certificadosReportes($fechaInicio, $fechaFin);

        if (empty($reportes)) {
            echo "No se encontraron reportes para las fechas seleccionadas.";
            exit;
        }

        $pdf = new TCPDF();
        $pdf->setMargins(10, 20, 10);

        $pdf->SetTitle('Reporte de Certificados');
        $pdf->SetHeaderData('', 0, 'Reporte de Certificados', 'Generado el: ' . date('d/m/Y'));
        $pdf->setHeaderFont(['helvetica', '', 12]);
        $pdf->setFooterFont(['helvetica', '', 8]);
        $pdf->AddPage('P', 'LETTER');

        $pdf->SetFont('helvetica', '', 12);

        $html = '<table border="1" cellpadding="5">
                <thead>
                    <tr>
                        <th><strong>#</strong></th>
                        <th><strong>Título</strong></th>
                        <th><strong>Fecha</strong></th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($reportes as $reporte) {
            $html .= '<tr>
                    <td>' . $reporte['id'] . '</td>
                    <td>' . $reporte['titulo'] . '</td>
                    <td>' . $reporte['create_at'] . '</td>
                </tr>';
        }

        $html .= '</tbody></table>';

        $pdf->writeHTML($html, true, false, false, false, '');
        if ($fechaFin) {
            $pdf->Output('reporte_certificados_' . $fechaFin . '.pdf', 'D');
        } else {
            $pdf->Output('reporte_certificados_' .  date('d-m-Y') . '.pdf', 'D');
        }
        echo "<script type='text/javascript'>window.location.href = '/dashboard/reportes';</script>";
    }

    public function descargarPdfInventario()
    {
        $fechaInicio = isset($_GET['fechaInicio']) ? $_GET['fechaInicio'] : null;
        $fechaFin = isset($_GET['fechaFin']) ? $_GET['fechaFin'] : null;


        $reportes = $this->reportesModel->inventariosReportes($fechaInicio, $fechaFin);

        if (empty($reportes)) {
            echo "No se encontraron reportes para las fechas seleccionadas.";
            exit;
        }

        $pdf = new TCPDF();
        $pdf->setMargins(10, 20, 10);

        $pdf->SetTitle('Reporte Inventario');

        $pdf->SetHeaderData('', 0, 'Reporte de Inventario ', 'Generado el: ' . date('d/m/Y'));
        $pdf->setHeaderFont(['helvetica', '', 12]);
        $pdf->setFooterFont(['helvetica', '', 8]);
        $pdf->AddPage('P', 'LETTER');

        $pdf->SetFont('helvetica', '', 12);

        $html = '<table border="1" cellpadding="5">
                <thead>
                    <tr>
                        <th><strong>#</strong></th>
                        <th><strong>Nombre</strong></th>
                        <th><strong>Cantidad</strong></th>
                        <th><strong>Fecha de Adquisicion</strong></th>
                        <th><strong>Descripcion</strong></th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($reportes as $reporte) {
            $html .= '<tr>
                    <td>' . $reporte['id'] . '</td>
                    <td>' . $reporte['nombre'] . '</td>
                    <td>' . $reporte['cantidad'] . '</td>
                    <td>' . $reporte['fechaAdquisicion'] . '</td>
                    <td>' . $reporte['descripcion'] . '</td>
                </tr>';
        }

        $html .= '</tbody></table>';
        $html .= '<hr/>';

        $pdf->writeHTML($html, true, false, false, false, '');

        if ($fechaFin) {
            $pdf->Output('reporte_inventario_' . $fechaFin . '.pdf', 'D');
        } else {
            $pdf->Output('reporte_inventario_'  .  date('d-m-Y') . '.pdf', 'D');
        }
        echo "<script type='text/javascript'>window.location.href = '/dashboard/reportes';</script>";
    }
    public function descargarPdfDocentes()
    {
        $fechaInicio = isset($_GET['fechaInicio']) ? $_GET['fechaInicio'] : null;
        $fechaFin = isset($_GET['fechaFin']) ? $_GET['fechaFin'] : null;


        $reportes = $this->reportesModel->docentesReportes($fechaInicio, $fechaFin);

        if (empty($reportes)) {
            echo "No se encontraron reportes para las fechas seleccionadas.";
            exit;
        }

        $pdf = new TCPDF();
        $pdf->setMargins(10, 20, 10);

        $pdf->SetTitle('Reporte Docentes');

        $pdf->SetHeaderData('', 0, 'Reporte de Docentes ', 'Generado el: ' . date('d/m/Y'));
        $pdf->setHeaderFont(['helvetica', '', 12]);
        $pdf->setFooterFont(['helvetica', '', 8]);
        $pdf->AddPage('P', 'LETTER');

        $pdf->SetFont('helvetica', '', 12);

        $html = '<table border="1" cellpadding="5">
                <thead>
                    <tr>
                        <th><strong>#</strong></th>
                        <th><strong>Nombre</strong></th>
                        <th><strong>Correo</strong></th>
                        <th><strong>Carnet</strong></th>
                        <th><strong>Telefono</strong></th>
                        <th><strong>Estado Civil</strong></th>
                        <th><strong>Direccion Domicilio</strong></th>
                        <th><strong>Universidad</strong></th>
                        <th><strong>Observacion</strong></th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($reportes as $reporte) {
            $html .= '<tr>
                    <td>' . $reporte['id'] . '</td>
                    <td>' . $reporte['nombres'] . ' ' . $reporte['apellidos'] . '</td>
                    <td>' . $reporte['correo'] . '</td>
                    <td>' . $reporte['carnet'] . '</td>
                    <td>' . $reporte['telefono'] . '</td>
                    <td>' . $reporte['estadoCivil'] . '</td>
                    <td>' . $reporte['direccionDomicilio'] . '</td>
                    <td>' . $reporte['universidad'] . '</td>
                    <td>' . $reporte['observacion'] . '</td>
                </tr>';
        }

        $html .= '</tbody></table>';
        $html .= '<hr/>';

        $pdf->writeHTML($html, true, false, false, false, '');

        if ($fechaFin) {
            $pdf->Output('reporte_docentes_' . $fechaFin . '.pdf', 'D');
        } else {
            $pdf->Output('reporte_docentes_'  .  date('d-m-Y') . '.pdf', 'D');
        }
        echo "<script type='text/javascript'>window.location.href = '/dashboard/reportes';</script>";
    }
    public function descargarPdfVenta()
    {
        $fechaInicio = isset($_GET['fechaInicio']) ? $_GET['fechaInicio'] : (isset($_POST['fechaInicio']) ? $_POST['fechaInicio'] : null);
        $fechaFin = isset($_GET['fechaFin']) ? $_GET['fechaFin'] : (isset($_POST['fechaFin']) ? $_POST['fechaFin'] : null);
        $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : (isset($_POST['tipo']) ? $_POST['tipo'] : null);
        $user = isset($_GET['user']) ? $_GET['user'] : (isset($_POST['user']) ? $_POST['user'] : null);

        $ventasModel = new VentasModel();

        if (empty($fechaFin) && empty($fechaInicio) && empty($tipo) && empty($user)) {
            $total = $ventasModel->obtenerTotalVentas($user, $tipo);
            error_log($user);
            error_log($tipo);
            $reportes = $this->reportesModel->obtenerReportesVenta();
        } else {
            error_log("jsdksam");
            error_log($user);
            error_log($tipo);
            $total = $ventasModel->obtenerTotalVentas($user, $tipo);
            $reportes = $this->reportesModel->ventasReportes($fechaInicio, $fechaFin, $tipo, $user);
        }

        if (empty($reportes)) {
            echo "No se encontraron reportes para las fechas seleccionadas.";
            exit;
        }

        $pdf = new TCPDF();
        $pdf->setMargins(10, 20, 10);

        if ($tipo) {
            $pdf->SetTitle('Reporte de ' . $tipo);
        } else {
            $pdf->SetTitle('Reporte General');
        }
        if ($tipo) {
            $pdf->SetHeaderData('', 0, 'Reporte de ' . $tipo, 'Generado el: ' . date('d/m/Y'));
        } else {
            $pdf->SetHeaderData('', 0, 'Reporte General ', 'Generado el: ' . date('d/m/Y'));
        }
        $pdf->setHeaderFont(['helvetica', '', 12]);
        $pdf->setFooterFont(['helvetica', '', 8]);
        $pdf->AddPage('P', 'LETTER');

        $pdf->SetFont('helvetica', '', 12);

        $html = '<table border="1" cellpadding="5">
                <thead>
                    <tr>
                        <th><strong>#</strong></th>
                        <th><strong>Nombre</strong></th>
                        <th><strong>Fecha</strong></th>
                        <th><strong>Precio</strong></th>
                        <th><strong>Usuario</strong></th>
                        <th><strong>Tipo</strong></th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($reportes as $reporte) {
            $html .= '<tr>
                    <td>' . $reporte['id'] . '</td>
                    <td>' . $reporte['externoNombre'] . '</td>
                    <td>' . $reporte['createt_at'] . '</td>
                    <td>' . $reporte['precio'] . '</td>
                    <td>' . $reporte['user'] . '</td>
                    <td>' . $reporte['tipo'] . '</td>
                </tr>';
        }

        $html .= '</tbody></table>';
        $html .= '<hr/>';
        $html .= '</h3> Total: ' . $total['0']['totalPrecio'] . '</h3>';

        $pdf->writeHTML($html, true, false, false, false, '');

        if ($fechaFin) {
            $pdf->Output('reporte_venta_' . $tipo . '_' . $fechaFin . '.pdf', 'D');
        } else {
            $pdf->Output('reporte_venta_' . $tipo . '_' .  date('d-m-Y') . '.pdf', 'D');
        }
        echo "<script type='text/javascript'>window.location.href = '/dashboard/reportes';</script>";
    }
    public function descargarPdfEstudiantes()
    {
        $fechaInicio = isset($_GET['fechaInicio']) ? $_GET['fechaInicio'] : null;
        $fechaFin = isset($_GET['fechaFin']) ? $_GET['fechaFin'] : null;

        $ventasModel = new VentasModel();

        $reportes = $this->reportesModel->estudiantesReportes($fechaInicio, $fechaFin);

        if (empty($reportes)) {
            echo "No se encontraron reportes para las fechas seleccionadas.";
            exit;
        }

        $pdf = new TCPDF();
        $pdf->setMargins(10, 20, 10);


        $pdf->SetTitle('Reporte Estudiantes');
        $pdf->SetHeaderData('', 0, 'Reporte estudiantes ', 'Generado el: ' . date('d/m/Y'));

        $pdf->setHeaderFont(['helvetica', '', 12]);
        $pdf->setFooterFont(['helvetica', '', 8]);
        $pdf->AddPage('P', 'LETTER');

        $pdf->SetFont('helvetica', '', 12);

        $html = '<table border="1" cellpadding="5">
                <thead>
                    <tr>
                        <th><strong>#</strong></th>
                        <th><strong>Nombre</strong></th>
                        <th><strong>Carnet</strong></th>
                        <th><strong>Correo</strong></th>
                        <th><strong>Telefono</strong></th>
                        <th><strong>Direccion domicilio</strong></th>
                        <th><strong>Fecha</strong></th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($reportes as $reporte) {
            $html .= '<tr>
                    <td>' . $reporte['id'] . '</td>
                    <td>' . $reporte['nombres'] . $reporte['apellidos'] . '</td>
                    <td>' . $reporte['carnet'] . '</td>
                    <td>' . $reporte['correo'] . '</td>
                    <td>' . $reporte['telefono'] . '</td>
                    <td>' . $reporte['direccionDomicilio'] . '</td>
                    <td>' . $reporte['create_at'] . '</td>
                </tr>';
        }

        $html .= '</tbody></table>';
        $html .= '<hr/>';
        $pdf->writeHTML($html, true, false, false, false, '');

        if ($fechaFin) {
            $pdf->Output('reporte_venta_' . $fechaFin . '.pdf', 'D');
        } else {
            $pdf->Output('reporte_venta_'  .  date('d-m-Y') . '.pdf', 'D');
        }
        echo "<script type='text/javascript'>window.location.href = '/dashboard/reportes';</script>";
    }
    public function descargarPdfCursos()
    {
        $fechaInicio = isset($_GET['fechaInicio']) ? $_GET['fechaInicio'] : null;
        $fechaFin = isset($_GET['fechaFin']) ? $_GET['fechaFin'] : null;

        $ventasModel = new VentasModel();

        $reportes = $this->reportesModel->cursosReportes($fechaInicio, $fechaFin);

        if (empty($reportes)) {
            echo "No se encontraron reportes para las fechas seleccionadas.";
            exit;
        }

        $pdf = new TCPDF();
        $pdf->setMargins(10, 20, 10);


        $pdf->SetTitle('Reporte Cursos');
        $pdf->SetHeaderData('', 0, 'Reporte cursos ', 'Generado el: ' . date('d/m/Y'));

        $pdf->setHeaderFont(['helvetica', '', 12]);
        $pdf->setFooterFont(['helvetica', '', 8]);
        $pdf->AddPage('P', 'LETTER');

        $pdf->SetFont('helvetica', '', 12);

        $html = '<table border="1" cellpadding="5">
                <thead>
                    <tr>
                        <th><strong>#</strong></th>
                        <th><strong>Titulo</strong></th>
                        <th><strong>Docente</strong></th>
                        <th><strong>Categoria</strong></th>
                        <th><strong>Descripcion</strong></th>
                        <th><strong>Precio</strong></th>
                        <th><strong>Fecha Inicio</strong></th>
                        <th><strong>Fecha Fin</strong></th>
                        <th><strong>Grupo Facebook</strong></th>
                        <th><strong>Fecha cracion</strong></th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($reportes as $reporte) {
            $html .= '<tr>
                    <td>' . $reporte['id'] . '</td>
                    <td>' . $reporte['titulo'] . $reporte['apellidos'] . '</td>
                    <td>' . $reporte['docente'] . '</td>
                    <td>' . $reporte['categoria'] . '</td>
                    <td>' . $reporte['descripcion'] . '</td>
                    <td>' . $reporte['precio'] . '</td>
                    <td>' . $reporte['fechaInicio'] . '</td>
                    <td>' . $reporte['fechaFin'] . '</td>
                    <td>' . $reporte['grupoFacebook'] . '</td>
                    <td>' . $reporte['create_at'] . '</td>
                </tr>';
        }

        $html .= '</tbody></table>';
        $html .= '<hr/>';
        $pdf->writeHTML($html, true, false, false, false, '');

        if ($fechaFin) {
            $pdf->Output('reporte_venta_' . $fechaFin . '.pdf', 'D');
        } else {
            $pdf->Output('reporte_venta_'  .  date('d-m-Y') . '.pdf', 'D');
        }
        echo "<script type='text/javascript'>window.location.href = '/dashboard/reportes';</script>";
    }
}
