<?php require 'template/head.php'; ?>
<?php require 'template/navbar.php'; ?>

<main id="main" class="container">
    <div class="row gap-4">
        <div class="card mb-3 col" style="max-width: 540px;" id="certificado">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="/assets/cenefco_grande.png" class="img-fluid rounded-start" alt="...">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">Certificados</h5>
                        <p class="card-text"><?php echo $cantidadDocentes ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-3 col" style="max-width: 540px;" id="docente">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="/assets/cenefco_grande.png" class="img-fluid rounded-start" alt="...">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">Docentes</h5>
                        <p class="card-text"><?php echo $cantidadDocentes ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-3 col" style="max-width: 540px;" id="ventaCertificado">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="/assets/cenefco_grande.png" class="img-fluid rounded-start" alt="...">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">Reporte Ventas</h5>
                        <p class="card-text"><?php echo $cantidadDocentes ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row gap-4">

        <div class="card mb-3 col" style="max-width: 540px;" id="estudiantes">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="/assets/cenefco_grande.png" class="img-fluid rounded-start" alt="...">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">Estudiantes</h5>
                        <p class="card-text"><?php echo $cantidadEstudiantes ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-3 col" style="max-width: 540px;" id="cursos">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="/assets/cenefco_grande.png" class="img-fluid rounded-start" alt="...">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">Cursos</h5>
                        <p class="card-text"><?php echo $cantidadCursos ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-3 col" style="max-width: 540px;" id="inventario">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="/assets/cenefco_grande.png" class="img-fluid rounded-start" alt="...">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">Inventario</h5>
                        <p class="card-text"><?php echo $cantidadInventario ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <dialog id="ModalDocentes">
        <div class="d-flex justify-content-between align-items-center position-relative  mb-4" style="z-index: 999;">
            <h5 class="card-title" id="vistaNombre">Reporte Docentes</h5>
            <button type="button" class="btn-close" id="closeDocente" aria-label="Close"></button>
        </div>
        <form id="reportDocentes" method="GET">
            <div class="row gap-4">
                <div class="form-group col">
                    <label for="fechaInicio">Fecha de inicio</label>
                    <input type="date" id="fechaInicio" name="fechaInicio" class="form-control me-2"
                        value="<?php echo htmlspecialchars($_GET['fechaInicio'] ?? ''); ?>">
                </div>

                <div class="form-group col">
                    <label for="fechaFin">Fecha de fin</label>
                    <input type="date" id="fechaFin" name="fechaFin" class="form-control me-2"
                        value="<?php echo htmlspecialchars($_GET['fechaFin'] ?? ''); ?>">
                </div>
                <div>
                    <button type="submit" class="mt-1 btn btn-success col" id="certificadosExcelDocentes">Descargar Reporte Excel</button>
                    <button type="submit" class="mt-1 btn btn-danger col" id="certificadosPdfDocentes">Descargar Reporte pdf</button>
                </div>
            </div>
        </form>
    </dialog>
    <dialog id="ModalVentaCertificados">
        <div class="d-flex justify-content-between align-items-center position-relative  mb-4" style="z-index: 999;">
            <h5 class="card-title" id="vistaNombre">Reporte certificado</h5>
            <button type="button" class="btn-close" id="closeVentaCertificados" aria-label="Close"></button>
        </div>
        <form id="reportVentasCertificado" method="GET">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tipo">Tipo</label>
                        <select id="tipo" name="tipo" class="form-select">
                            <option value="">Todo</option>
                            <option value="certificado" <?php echo ($_GET['tipo'] == 'certificado') ? 'selected' : ''; ?>>Certificado</option>
                            <option value="curso" <?php echo ($_GET['tipo'] == 'curso') ? 'selected' : ''; ?>>Curso</option>
                        </select>

                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="user">Usuarios</label>
                        <select id="user" name="user" class="form-select"
                            value="<?php echo htmlspecialchars($_GET['user'] ?? ''); ?>">
                            <option value="" <?php echo (empty($_GET['user'])) ? 'selected' : ''; ?>>Todos los usuarios</option>
                            <?php foreach ($usuarios as $usuario): ?>
                                <option value="<?php echo $usuario['username'] ?>"><?php echo $usuario['username'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="fechaInicio">Fecha de inicio</label>
                        <input type="date" id="fechaInicio" name="fechaInicio" class="form-control"
                            value="<?php echo htmlspecialchars($_GET['fechaInicio'] ?? ''); ?>">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="fechaFin">Fecha de fin</label>
                        <input type="date" id="fechaFin" name="fechaFin" class="form-control"
                            value="<?php echo htmlspecialchars($_GET['fechaFin'] ?? ''); ?>">
                    </div>
                </div>

                <div class="d-flex justify-content-between gap-2 col-12">
                    <button type="submit" class="btn btn-primary" id="certificadosExcelVentas">Descargar Reporte Excel</button>
                    <button type="submit" class="btn btn-danger" id="certificadosPdfVentas">Descargar Reporte PDF</button>
                </div>
            </div>
        </form>

    </dialog>
    <dialog id="ModalCertificados">
        <div class="d-flex justify-content-between align-items-center position-relative  mb-4" style="z-index: 999;">
            <h5 class="card-title" id="vistaNombre">Reporte certificado</h5>
            <button type="button" class="btn-close" id="closeCertificados" aria-label="Close"></button>
        </div>
        <form id="reportCertificado" method="GET">
            <div class="row gap-4">
                <div class="form-group col">
                    <label for="fechaInicio">Fecha de inicio</label>
                    <input type="date" id="fechaInicio" name="fechaInicio" class="form-control me-2"
                        value="<?php echo htmlspecialchars($_GET['fechaInicio'] ?? ''); ?>">
                </div>

                <div class="form-group col">
                    <label for="fechaFin">Fecha de fin</label>
                    <input type="date" id="fechaFin" name="fechaFin" class="form-control me-2"
                        value="<?php echo htmlspecialchars($_GET['fechaFin'] ?? ''); ?>">
                </div>
                <div>
                    <button type="submit" class="mt-1 btn btn-success col" id="certificadosExcel">Descargar Reporte excel</button>
                    <button type="submit" class="mt-1 btn btn-danger col" id="certificadosPdf">Descargar Reporte pdf</button>
                </div>
            </div>
        </form>
    </dialog>
    <dialog id="ModalEstudiantes">
        <div class="d-flex justify-content-between align-items-center position-relative  mb-4" style="z-index: 999;">
            <h5 class="card-title" id="vistaNombre">Reporte Estudiantes</h5>
            <button type="button" class="btn-close" id="closeEstudiantes" aria-label="Close"></button>
        </div>
        <form id="reportEstudiantes" method="GET">
            <div class="row gap-4">
                <div class="form-group col">
                    <label for="fechaInicio">Fecha de inicio</label>
                    <input type="date" id="fechaInicio" name="fechaInicio" class="form-control me-2"
                        value="<?php echo htmlspecialchars($_GET['fechaInicio'] ?? ''); ?>">
                </div>

                <div class="form-group col">
                    <label for="fechaFin">Fecha de fin</label>
                    <input type="date" id="fechaFin" name="fechaFin" class="form-control me-2"
                        value="<?php echo htmlspecialchars($_GET['fechaFin'] ?? ''); ?>">
                </div>
                <div>
                    <button type="submit" class="mt-1 btn btn-success col" id="certificadosExcelEstudiantes">Descargar Reporte Excel</button>
                    <button type="submit" class="mt-1 btn btn-danger col" id="certificadosPdfEstudiantes">Descargar Reporte pdf</button>
                </div>
            </div>
        </form>
    </dialog>
    <dialog id="ModalInventarios">
        <div class="d-flex justify-content-between align-items-center position-relative  mb-4" style="z-index: 999;">
            <h5 class="card-title" id="vistaNombre">Reporte Inventarios</h5>
            <button type="button" class="btn-close" id="closeInventarios" aria-label="Close"></button>
        </div>
        <form id="reportInventarios" method="GET">
            <div class="row gap-4">
                <div class="form-group col">
                    <label for="fechaInicio">Fecha de inicio</label>
                    <input type="date" id="fechaInicio" name="fechaInicio" class="form-control me-2"
                        value="<?php echo htmlspecialchars($_GET['fechaInicio'] ?? ''); ?>">
                </div>

                <div class="form-group col">
                    <label for="fechaFin">Fecha de fin</label>
                    <input type="date" id="fechaFin" name="fechaFin" class="form-control me-2"
                        value="<?php echo htmlspecialchars($_GET['fechaFin'] ?? ''); ?>">
                </div>
                <div>
                    <button type="submit" class="mt-1 btn btn-success col" id="certificadosExcelInventarios">Descargar ReporteExcel</button>
                    <button type="submit" class="mt-1 btn btn-danger col" id="certificadosPdfInventarios">Descargar Reporte pdf</button>
                </div>
            </div>
        </form>
    </dialog>
    <dialog id="ModalCursos">
        <div class="d-flex justify-content-between align-items-center position-relative  mb-4" style="z-index: 999;">
            <h5 class="card-title" id="vistaNombre">Reporte Cursos</h5>
            <button type="button" class="btn-close" id="closeCursos" aria-label="Close"></button>
        </div>
        <form id="reportCursos" method="GET">
            <div class="row gap-4">
                <div class="form-group col">
                    <label for="fechaInicio">Fecha de inicio</label>
                    <input type="date" id="fechaInicio" name="fechaInicio" class="form-control me-2"
                        value="<?php echo htmlspecialchars($_GET['fechaInicio'] ?? ''); ?>">
                </div>

                <div class="form-group col">
                    <label for="fechaFin">Fecha de fin</label>
                    <input type="date" id="fechaFin" name="fechaFin" class="form-control me-2"
                        value="<?php echo htmlspecialchars($_GET['fechaFin'] ?? ''); ?>">
                </div>
                <div>
                    <button type="submit" class="mt-1 btn btn-success col" id="certificadosExcelCursos">Descargar Reporte Excel</button>
                    <button type="submit" class="mt-1 btn btn-danger col" id="certificadosPdfCursos">Descargar Reporte pdf</button>
                </div>
            </div>
        </form>
    </dialog>
</main>
<script>
    //open
    $('#certificado').addEventListener('click', () => {
        $('#ModalCertificados').showModal()
    })
    $('#docente').addEventListener('click', () => {
        $('#ModalDocentes').showModal()
    })
    $('#estudiantes').addEventListener('click', () => {
        $('#ModalEstudiantes').showModal()
    })
    $('#inventario').addEventListener('click', () => {
        $('#ModalInventarios').showModal()
    })
    $('#ventaCertificado').addEventListener('click', () => {
        $('#ModalVentaCertificados').showModal()
    })
    $('#cursos').addEventListener('click', () => {
        $('#ModalCursos').showModal()
    })
    //close
    $('#closeCertificados').addEventListener('click', () => {
        $('#ModalCertificados').close()
    })
    $('#closeInventarios').addEventListener('click', () => {
        $('#ModalInventarios').close()
    })
    $('#closeCursos').addEventListener('click', () => {
        $('#ModalCursos').close()
    })
    $('#closeEstudiantes').addEventListener('click', () => {
        $('#ModalEstudiantes').close()
    })
    $('#closeVentaCertificados').addEventListener('click', () => {
        $('#ModalVentaCertificados').close()
    })
    $('#closeDocente').addEventListener('click', () => {
        $('#ModalDocentes').close()
    })
    //certificados
    $('#certificadosExcel').addEventListener('click', () => {
        $('#reportCertificado').setAttribute('action', '/dashboard/reportes/certificados-excel');
    })
    $('#certificadosPdf').addEventListener('click', () => {
        $('#reportCertificado').setAttribute('action', '/dashboard/reportes/certificados-pdf');
    })
    $('#certificadosExcelVentas').addEventListener('click', () => {
        $('#reportVentasCertificado').setAttribute('action', '/dashboard/reportes/ventas-excel');
    })
    $('#certificadosPdfVentas').addEventListener('click', () => {
        $('#reportVentasCertificado').setAttribute('action', '/dashboard/reportes/ventas-pdf');
    })
    $('#certificadosExcelInventarios').addEventListener('click', () => {
        $('#reportInventarios').setAttribute('action', '/dashboard/reportes/inventario-excel');
    })
    $('#certificadosPdfInventarios').addEventListener('click', () => {
        $('#reportInventarios').setAttribute('action', '/dashboard/reportes/inventario-pdf');
    })
    $('#certificadosExcelDocentes').addEventListener('click', () => {
        $('#reportDocentes').setAttribute('action', '/dashboard/reportes/docentes-excel');
    })
    $('#certificadosPdfDocentes').addEventListener('click', () => {
        $('#reportDocentes').setAttribute('action', '/dashboard/reportes/docentes-pdf');
    })
    $('#certificadosExcelCursos').addEventListener('click', () => {
        $('#reportCursos').setAttribute('action', '/dashboard/reportes/cursos-excel');
    })
    $('#certificadosPdfCursos').addEventListener('click', () => {
        $('#reportCursos').setAttribute('action', '/dashboard/reportes/cursos-pdf');
    })
</script>
<?php require 'template/foot.php'; ?>