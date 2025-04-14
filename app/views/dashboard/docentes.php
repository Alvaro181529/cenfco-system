<?php require 'template/head.php' ?>
<?php require 'template/navbar.php' ?>
<main id="main" class="container" data-aos="fade-up">
    <!-- Formulario de búsqueda -->
    <div class="row mb-3">
        <div class="col-12">
            <form class="d-flex" method="get" action="/dashboard/docentes">
                <input class="form-control me-2" type="search" placeholder="Buscar docentes por nombre, apellido, correo..." aria-label="Buscar" value="<?php echo htmlspecialchars($_GET['query'] ?? ''); ?>" name="query">
                <button class="btn btn-outline-success" type="submit">Buscar</button>
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead class="text-center">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Correo</th>
                    <th scope="col">Carnet</th>
                    <th scope="col">Telefono</th>
                    <th scope="col">Estado Civil</th>
                    <th scope="col">Universidad</th>
                    <th scope="col">Observación</th>
                    <th scope="col"><button id="agregarDocenteModal" class="btn btn-success" data-bs-toggle="tooltip" data-bs-title="Agregar"><i class="bi bi-person-plus-fill"></i></button></th>
                </tr>

            <tbody>
                <?php if (count($docentes) == 0): ?>
                    <tr>
                        <td colspan="10" class="text-center">No se encontraron docentes con ese término de búsqueda.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($docentes['docentes'] as $docente): ?>
                        <tr>
                            <th scope="row"><?php echo str_pad($docente['id'], 5, '0', STR_PAD_LEFT); ?></th>
                            <td><?php echo $docente['nombres'] .' ' .$docente['apellidos']; ; ?></td>
                            <td><?php echo $docente['correo']; ?></td>
                            <td><?php echo $docente['carnet']; ?></td>
                            <td><?php echo $docente['telefono']; ?></td>
                            <td><?php echo $docente['estadoCivil']; ?></td>
                            <td><?php echo $docente['universidad']; ?></td>
                            <td><?php echo $docente['observacion']; ?></td>
                            <td class="gap-4">
                                <a onclick="editarDocente(<?php echo $docente['id']; ?>)" data-bs-toggle="tooltip" data-bs-title="Editar" class="text-primary"><i class="bi bi-pencil-fill"></i></a>
                                <form id="deleteForm<?php echo $docente['id']; ?>" action="/dashboard/docentes/eliminar" method="POST" style="display:inline-block;">
                                    <input type="hidden" name="id" value="<?php echo $docente['id']; ?>" />
                                    <a onclick="eliminarDocente(<?php echo $docente['id']; ?>)" type="button" data-bs-toggle="tooltip" data-bs-title="Eliminar" class="text-danger"><i class="bi bi-trash3-fill"></i></a>
                                </form>
                                <a onclick="verDocente(<?php echo $docente['id']; ?>)" href="#" data-bs-toggle="tooltip" data-bs-title="Ver" class="text-secondary"><i class="bi bi-eye-fill"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
             <!-- Paginación -->
             <div class="d-flex justify-content-center">
            <nav>
                <ul class="pagination">
                    <?php
                    // Si estamos en la página 1, no mostrar enlace "Anterior"
                    if ($docentes['paginaActual'] > 1):
                    ?>
                        <li class="page-item">
                            <a class="page-link" href="?pagina=<?php echo $docentes['paginaActual'] - 1; ?>&titulo=<?php echo htmlspecialchars($_GET['titulo'] ?? ''); ?>">Anterior</a>
                        </li>
                    <?php endif; ?>

                    <?php
                    // Mostrar los enlaces de las páginas
                    for ($i = 1; $i <= $docentes['totalPaginas']; $i++):
                    ?>
                        <li class="page-item <?php echo $i === $docentes['paginaActual'] ? 'active' : ''; ?>">
                            <a class="page-link" href="?pagina=<?php echo $i; ?>&titulo=<?php echo htmlspecialchars($_GET['titulo'] ?? ''); ?>">
                                <?php echo $i; ?>
                            </a>
                        </li>
                    <?php endfor; ?>

                    <?php
                    // Si no estamos en la última página, mostrar el enlace "Siguiente"
                    if ($docentes['paginaActual'] < $docentes['totalPaginas']):
                    ?>
                        <li class="page-item">
                            <a class="page-link" href="?pagina=<?php echo $docentes['paginaActual'] + 1; ?>&titulo=<?php echo htmlspecialchars($_GET['titulo'] ?? ''); ?>">Siguiente</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>
</main>
<dialog id="agregarDocente">
    <form id="formDocentes" method="post" enctype="multipart/form-data">
        <input type="text" id="id" name="id" hidden>
        <div class="row">
            <div class="mb-3 col-6">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre">
            </div>
            <div class="mb-3 col-6">
                <label for="apellido" class="form-label">Apellido</label>
                <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Apellido">
            </div>
            <div class="mb-3 col-6">
                <label for="carnet" class="form-label">Carnet</label>
                <input type="text" class="form-control" id="carnet" name="carnet" placeholder="Carnet">
            </div>
            <div class="mb-3 col-6">
                <label for="correo" class="form-label">Correo</label>
                <input type="email" class="form-control" id="correo" name="correo" placeholder="Correo">
            </div>
            <div class="mb-3 col-6">
                <label for="estadoCivil" class="form-label">Estado civil</label>
                <select name="estadoCivil" class="form-select" name="estadoCivil" id="estadoCivil">
                    <option value="Soltero">Soltero</option>
                    <option value="Casado">Casado</option>
                    <option value="Divorciado">Divorciado</option>
                    <option value="Viudo">Viudo</option>
                </select>
            </div>

            <div class="mb-3 col-6">
                <label for="telefono" class="form-label">Telefono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Telefono">
            </div>

            <div class="mb-3 col-6">
                <label for="universidad" class="form-label">Universidad</label>
                <input type="text" class="form-control" id="universidad" name="universidad" placeholder="Universidad">
            </div>

            <div class="mb-3 col-6">
                <label for="direccion" class="form-label">Direccion Domicilio</label>
                <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Dirección">
            </div>

            <div class="mb-3 col-12">
                <label for="imagen" class="form-label">Foto</label>
                <input type="file" class="form-control" id="imagen" name="imagen" placeholder="imagen" accept="image/*">
            </div>
            <div class="mb-3 col-12">
                <label for="firma" class="form-label">Firma</label>
                <input type="file" class="form-control" id="firma" name="firma" placeholder="firma" accept="image/*">
            </div>
            <div class="mb-3 col-12">
                <label for="curriculum" class="form-label">Curriculum</label>
                <input type="file" class="form-control" id="curriculum" name="curriculum" placeholder="curriculum" accept="image/*">
            </div>

            <div class="mb-3 col-12">
                <label for="observacion" class="form-label">Observación</label>
                <textarea class="form-control" id="observacion" name="observacion" placeholder="Descripcion"></textarea>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
        <button type="button" id="cerrarDocenteModal" class="btn btn-danger">Cerrar</button>
    </form>
</dialog>

<dialog id="vistaDocente" class="dialogProfile">
    <div class="row g-4">
        <div class="d-flex justify-content-between align-items-center position-relative" style="z-index: 999;">
            <h5 class="card-title mb-0" id="vistaNombre"></h5>
            <button type="button" class="btn-close" id="vistaClose" aria-label="Close"></button>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header text-center text-muted">
                    <div>
                        <img id="vistaFoto" src="" class="rounded-circle mb-3" width="100" height="100" alt="Perfil">
                        <img id="vistaFirma" src="" class="rounded mb-3 ms-5" width="200" height="100" alt="Firma">
                    </div>
                    <div>
                        <div class="d-flex justify-content-center text-muted">
                            <i class="bi bi-envelope me-2"></i>
                            <span id="vistaCorreo"></span>
                        </div>
                        <div class="d-flex justify-content-center text-muted">
                            <i class="bi bi-telephone me-2"></i>
                            <span id="vistaTelefono"></span>
                        </div>
                        <span class="badge text-bg-secondary mt-3" id="vistaEstadoCivil">
                        </span>
                        <a href="#" id="vistaCurriculum" target="_blank" class="badge text-bg-danger mt-3">
                            <i class="bi bi-file-earmark-text me-2"></i> Curriculum
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="mb-3">
                        <h6><i class="bi bi-house-door me-2"></i> Dirección</h6>
                        <p class="text-muted" id="vistaDireccion">Calle Principal 123, Piso 4B, Madrid, España</p>
                    </div>
                    <div class="mb-3">
                        <h6><i class="bi bi-book me-2"></i> Universidad</h6>
                        <p class="text-muted" id="vistaUniversidad">Universidad Complutense de Madrid</p>
                    </div>
                    <div class="mb-3">
                        <h6><i class="bi bi-card-list me-2"></i> Carnet</h6>
                        <p class="text-muted" id="vistaCarnet">X-12345678-Z</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5><i class="bi bi-briefcase me-2"></i> Observación</h5>
                </div>
                <div class="card-body text-muted">
                    <p id="vistaObservacion">Licenciada en Administración de Empresas con 5 años de experiencia en gestión de proyectos. Especializada en optimización de procesos y liderazgo de equipos multidisciplinarios. Experiencia en implementación de metodologías ágiles y desarrollo de estrategias de negocio.</p>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h5><i class="bi bi-file-earmark-text me-2"></i> Información Completa</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <p><strong>ID:</strong> <span id="vistaId">001</span></p>
                            <p><strong>Nombres:</strong> <span id="vistaNombres">María Elena</span></p>
                            <p><strong>Apellidos:</strong> <span id="vistaApellidos">Rodríguez Gómez</span></p>
                        </div>
                        <div class="col-6">
                            <p><strong>Correo:</strong> <span id="vistaCorreoInfo">maria.rodriguez@ejemplo.com</span></p>
                            <p><strong>Teléfono:</strong> <span id="vistaTelefonoInfo">+34 612 345 678</span></p>
                            <p><strong>Estado Civil:</strong> <span id="vistaEstadoCivilInfo">Casada</span></p>
                        </div>
                        <div class="col-6">
                            <p><strong>Dirección:</strong> <span id="vistaDireccionInfo">Calle Principal 123, Piso 4B, Madrid, España</span></p>
                        </div>
                        <div class="col-6">
                            <p><strong>Universidad:</strong> <span id="vistaUniversidadInfo">Universidad Complutense de Madrid</span></p>
                            <p><strong>Carnet:</strong> <span id="vistaCarnetInfo">X-12345678-Z</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</dialog>

<script>
    $('#vistaClose').addEventListener('click', () => {
        $('#vistaDocente').close()
    })
    $('#agregarDocenteModal').addEventListener('click', () => {
        $('#agregarDocente').showModal()
        $('#formDocentes').setAttribute('action', '/dashboard/docentes');
        $('#formDocentes').reset()
    })
    $('#cerrarDocenteModal').addEventListener('click', () => {
        $('#agregarDocente').close()
    })

    function verDocente(id) {
        fetch('/dashboard/docentes/' + id)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error al obtener el docente');
                }
                return response.json();
            })
            .then(docente => {
                // Asignar valores al modal
                $('#vistaNombre').textContent = docente.nombres + ' ' + docente.apellidos;
                $('#vistaCorreo').textContent = docente.correo;
                $('#vistaTelefono').textContent = docente.telefono;
                $('#vistaEstadoCivil').textContent = '' + docente.estadoCivil;
                $('#vistaCurriculum').href = '/storage/uploads/docentes/' + docente.curriculum;
                $('#vistaFirma').src = '/storage/uploads/docentes/' + docente.firma;
                $('#vistaFoto').src = '/storage/uploads/docentes/' + docente.foto;
                $('#vistaDireccion').textContent = docente.direccionDomicilio;
                $('#vistaUniversidad').textContent = docente.universidad;
                $('#vistaCarnet').textContent = docente.carnet;
                $('#vistaObservacion').textContent = docente.observacion;

                // Información completa
                $('#vistaId').textContent = docente.id;
                $('#vistaNombres').textContent = docente.nombres;
                $('#vistaApellidos').textContent = docente.apellidos;
                $('#vistaCorreoInfo').textContent = docente.correo;
                $('#vistaTelefonoInfo').textContent = docente.telefono;
                $('#vistaEstadoCivilInfo').textContent = docente.estadoCivil;
                $('#vistaDireccionInfo').textContent = docente.direccionDomicilio;
                $('#vistaUniversidadInfo').textContent = docente.universidad;
                $('#vistaCarnetInfo').textContent = docente.carnet;

                // Mostrar el modal
                $('#vistaDocente').showModal();
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    function editarDocente(id) {
        $('#formDocentes').setAttribute('action', '/dashboard/docentes/actualizar');
        fetch('/dashboard/docentes/' + id)
            .then(response => {

                if (!response.ok) {
                    throw new Error('Error al obtener el docente');
                }
                return response.json();
            })
            .then(docente => {
                $('#id').value = docente.id;
                $('#nombre').value = docente.nombres;
                $('#apellido').value = docente.apellidos;
                $('#carnet').value = docente.carnet;
                $('#correo').value = docente.correo;
                $('#estadoCivil').value = docente.estadoCivil;
                $('#telefono').value = docente.telefono;
                $('#universidad').value = docente.universidad;
                $('#direccion').value = docente.direccionDomicilio;
                $('#observacion').value = docente.observacion;
                $('#agregarDocente').showModal()
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    function eliminarDocente(id) {
        if (confirm("¿Estás seguro de que deseas eliminar este docente?")) {
            fetch('/dashboard/docentes/eliminar', {
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
                        throw new Error('Error al eliminar el docente');
                    }
                    return response.json();
                })
                .then(data => {
                    alert('Curso eliminado exitosamente');
                    window.location.reload();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Hubo un error al eliminar el docente');
                });
        }
    }
</script>

<?php require 'template/foot.php' ?>