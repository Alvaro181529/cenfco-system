<?php require 'template/head.php' ?>
<?php require 'template/navbar.php' ?>

<main id="main" class="container" data-aos="fade-up">
    <h1><?php echo $total['0']['totalPrecio'] ?></h1>
    <button id="ventaCertificado">Reporte</button>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead class="text-center">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Curso</th>
                    <th scope="col">Estudiante</th>
                    <th scope="col">Precio</th>
                    <th scope="col">Usuario</th>
                    <th scope="col">Descripción</th>
                    <th scope="col"><button id="agregarVentaModal" class="btn btn-success"><i class="bi bi-person-plus-fill"></i></button></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ventas as $venta): ?>
                    <tr>
                        <th scope="row"><?php echo str_pad($venta['id'], 5, '0', STR_PAD_LEFT); ?></th>
                        <td><?php echo $venta['certificadoTitulo']; ?></td>
                        <td><?php echo $venta['externoNombre']; ?></td>
                        <td><?php echo $venta['precio']; ?> Bs</td>
                        <td><?php echo $venta['user']; ?></td>
                        <td><?php echo $venta['descripcion']; ?></td>
                        <td class="gap-4">
                            <a onclick="editarVenta(<?php echo $venta['id']; ?>)" data-bs-toggle="tooltip" data-bs-title="Editar" class="text-primary"><i class="bi bi-pencil-fill"></i></a>
                            <form id="deleteForm<?php echo $venta['id']; ?>" action="/dashboard/ventas/eliminar" method="POST" style="display:inline-block;">
                                <input type="hidden" name="id" value="<?php echo $venta['id']; ?>" />
                                <a onclick="eliminarVenta(<?php echo $venta['id']; ?>)" type="button" data-bs-toggle="tooltip" data-bs-title="Eliminar" class="text-danger"><i class="bi bi-trash3-fill"></i></a>
                            </form>
                            <a href="#" data-bs-toggle="tooltip" data-bs-title="Ver" class="text-secondary"><i class="bi bi-eye-fill"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <!-- Paginación -->
        <div class="d-flex justify-content-center">
            <nav>
                <ul class="pagination">
                    <?php
                    // Si estamos en la página 1, no mostrar enlace "Anterior"
                    if ($ventas['paginaActual'] > 1):
                    ?>
                        <li class="page-item">
                            <a class="page-link" href="?pagina=<?php echo $ventas['paginaActual'] - 1; ?>&titulo=<?php echo htmlspecialchars($_GET['titulo'] ?? ''); ?>">Anterior</a>
                        </li>
                    <?php endif; ?>

                    <?php
                    // Mostrar los enlaces de las páginas
                    for ($i = 1; $i <= $ventas['totalPaginas']; $i++):
                    ?>
                        <li class="page-item <?php echo $i === $ventas['paginaActual'] ? 'active' : ''; ?>">
                            <a class="page-link" href="?pagina=<?php echo $i; ?>&titulo=<?php echo htmlspecialchars($_GET['titulo'] ?? ''); ?>">
                                <?php echo $i; ?>
                            </a>
                        </li>
                    <?php endfor; ?>

                    <?php
                    // Si no estamos en la última página, mostrar el enlace "Siguiente"
                    if ($ventas['paginaActual'] < $ventas['totalPaginas']):
                    ?>
                        <li class="page-item">
                            <a class="page-link" href="?pagina=<?php echo $ventas['paginaActual'] + 1; ?>&titulo=<?php echo htmlspecialchars($_GET['titulo'] ?? ''); ?>">Siguiente</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>
</main>
<dialog id="ModalVentaCertificados">
    <div class="d-flex justify-content-between align-items-center position-relative  mb-4" style="z-index: 999;">
        <h5 class="card-title" id="vistaNombre">Reporte ventas</h5>
        <!-- <form action="" method="dialog">
            <button type="submit" class="btn-close" id="closeVentaCertificados" aria-label="Close"></button>
        </form> -->
    </div>
    <form id="reportVentasCertificado" method="GET">
        <div class="row g-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="tipo">Tipo</label>
                    <select disabled id="tipo" name="tipo" class="form-select">
                        <option value="certificado" selected <?php echo ($_GET['tipo'] == 'certificado') ? 'selected' : ''; ?>>certificado</option>
                    </select>

                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="user">Usuarios</label>
                    <select id="user" disabled name="user" class="form-select"
                        value="<?php echo htmlspecialchars($_GET['user'] ?? ''); ?>">
                        <option value="<?php echo $username ?>" selected> <?php echo $username ?></option>
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
<dialog id="agregarVenta">
    <form id="formVentas" method="post">
        <input type="text" id="id" name="id" hidden>
        <input type="text" id="tipo" name="tipo" value="certificado" hidden>
        <input type="text" id="cursoId" name="cursoId" hidden>
        <input type="text" id="estudianteId" name="estudianteId" hidden>

        <div class="row">
            <div class="mb-3">
                <label for="curso" class="form-label">Certificado</label>
                <input type="text" list="listCursos" class="form-control" id="curso" name="curso" placeholder="Título">
                <datalist id="listCursos">
                    <?php foreach ($certificados['certificados'] as $certificado): ?>
                        <option value="<?php echo $certificado['titulo']; ?>" data-id="<?php echo $certificado['id']; ?>" data-price="<?php echo $certificado['precio']; ?>"></option>
                    <?php endforeach; ?>
                </datalist>
            </div>

            <div class=" mb-3 col">
                <label for="estudiante" class="form-label">Estudiante</label>
                <input type="text" list="listEstudiante" class="form-control" id="estudiante" name="estudiante" placeholder="Nombre">
                <datalist id="listEstudiante">
                    <?php foreach ($estudiantes['estudiantes'] as $estudiante): ?>
                        <option value="<?php echo $estudiante['nombres'] . ' ' . $estudiante['apellidos']; ?>" data-es="<?php echo $estudiante['id']; ?>" data-ci="<?php echo $estudiante['carnet']; ?>"><?php echo $estudiante['nombres'] . ' ' . $estudiante['apellidos']; ?></option>
                    <?php endforeach; ?>
                </datalist>
            </div>
            <div class="mb-3 col">
                <label for="carnet" class="form-label">Carnet</label>
                <input class="form-control" id="carnet" name="carnet" placeholder="Carnet">
            </div>


            <div class="mb-3">
                <label for="precio" class="form-label">Precio</label>
                <input type="number" class="form-control" id="precio" name="precio">
            </div>
            <div class="mb-3">
                <label for="comprobante" class="form-label">Comprobante</label>
                <input type="file" class="form-control" id="comprobante" name="comprobante" accept="image/*,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripcion</label>
                <textarea class="form-control" id="descripcion" name="descripcion"></textarea>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
        <button type="button" id="cerrarVentaModal" class="btn btn-danger">Cerrar</button>
    </form>
</dialog>

<script>
    $('#ventaCertificado').addEventListener('click', () => {
        $('#ModalVentaCertificados').showModal()
    })

    $('#certificadosExcelVentas').addEventListener('click', (e) => {
        e.preventDefault();
        const fechaInicio = $('#fechaInicio').value;
        const fechaFin = $('#fechaFin').value;
        const tipo = $('#tipo').value;
        const user = $('#user').value;
        const url = `/dashboard/reportes/ventas-excel?fechaInicio=${fechaInicio}&fechaFin=${fechaFin}&tipo=${tipo}&user=${user}`;
        $('#reportVentasCertificado').setAttribute('action', url);
        $('#reportVentasCertificado').submit();
    })
    $('#certificadosPdfVentas').addEventListener('click', (e) => {
        e.preventDefault();
        const fechaInicio = $('#fechaInicio').value;
        const fechaFin = $('#fechaFin').value;
        const tipo = $('#tipo').value;
        const user = $('#user').value;
        const url = `/dashboard/reportes/ventas-pdf?fechaInicio=${fechaInicio}&fechaFin=${fechaFin}&tipo=${tipo}&user=${user}`;
        $('#reportVentasCertificado').setAttribute('action', url);
        $('#reportVentasCertificado').submit();
    })

    // Mostrar el modal para agregar una venta
    $('#agregarVentaModal').addEventListener('click', () => {
        $('#agregarVenta').showModal();
        $('#formVentas').setAttribute('action', '/dashboard/ventas/cursos');
        $('#formVentas').reset();
    });

    // Cerrar el modal
    $('#cerrarVentaModal').addEventListener('click', () => {
        $('#agregarVenta').close();
    });

    $('#curso').addEventListener('input', function() {
        const cursoTitulo = this.value
        for (const option of $('#listCursos').options) {
            if (option.value === cursoTitulo) {
                // Asignar el ID del curso al campo oculto
                $('#cursoId').value = option.getAttribute('data-id');
                $('#precio').value = option.getAttribute('data-price');
                return;
            }
        }
        $('#cursoId').value = '';
        $('#precio').value = '';
    })
    $('#estudiante').addEventListener('input', function() {
        const estudianteNombre = this.value
        for (const option of $('#listEstudiante').options) {
            if (option.value === estudianteNombre) {
                $('#estudianteId').value = option.getAttribute('data-es');
                $('#carnet').value = option.getAttribute('data-ci');
                return;
            }
        }
        $('#estudianteId').value = '';
        $('#carnet').value = '';
    })

    // Función para editar una venta
    function editarVenta(id) {
        $('#formVentas').setAttribute('action', '/dashboard/ventas/cursos/actualizar');
        fetch('/dashboard/ventas/cursos/' + id)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error al obtener la venta');
                }
                return response.json();
            })
            .then(venta => {
                $('#id').value = venta.id;
                $('#tipo').value = venta.tipo;
                $('#cursoId').value = venta.cursoId;
                $('#estudianteId').value = venta.estudianteId;

                $('#curso').value = venta.cursoTitulo;
                $('#carnet').value = venta.externoCarnet;
                $('#estudiante').value = venta.externoNombre;
                $('#descripcion').value = venta.descripcion;
                $('#precio').value = venta.precio;
                $('#agregarVenta').showModal();
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    // Función para eliminar una venta
    function eliminarVenta(id) {
        if (confirm("¿Estás seguro de que deseas eliminar esta venta?")) {
            fetch('/dashboard/ventas/cursos/eliminar', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        id: id
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error al eliminar la venta');
                    }
                    return response.json();
                })
                .then(data => {
                    alert('Venta eliminada exitosamente');
                    window.location.reload();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Hubo un error al eliminar la venta');
                });
        }
    }
</script>

<?php require 'template/foot.php' ?>