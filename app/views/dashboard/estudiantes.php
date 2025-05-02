<?php require 'template/head.php' ?>
<?php require 'template/navbar.php' ?>
<main id="main" class="container" data-aos="fade-up">
    <div class="row my-4">
        <div class="col">
            <form action="/dashboard/estudiantes" method="GET" class="d-flex">
                <input type="text" class="form-control me-2" name="nombre" placeholder="Buscar por nombre" value="<?php echo isset($_GET['nombre']) ? $_GET['nombre'] : ''; ?>">
                <input type="text" class="form-control me-2" name="apellido" placeholder="Buscar por apellido" value="<?php echo isset($_GET['apellido']) ? $_GET['apellido'] : ''; ?>">
                <input type="text" class="form-control me-2" name="carnet" placeholder="Buscar por carnet" value="<?php echo isset($_GET['carnet']) ? $_GET['carnet'] : ''; ?>">
                <button class="btn btn-primary" type="submit">Buscar</button>
            </form>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead class="text-center">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombres</th>
                    <th scope="col">Apellidos</th>
                    <th scope="col">Correo</th>
                    <th scope="col">Carnet</th>
                    <th scope="col">Celular</th>
                    <th scope="col">Dirección</th>
                    <th scope="col"><button id="agregarEstudianteModal" class="btn btn-success" data-bs-toggle="tooltip" data-bs-title="Agregar"><i class="bi bi-person-plus-fill"></i></button></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($estudiantes['estudiantes'] as $estudiante): ?>
                    <tr>
                        <th scope="row"><?php echo str_pad($estudiante['id'], 5, '0', STR_PAD_LEFT); ?></th>
                        <td><?php echo $estudiante['nombres']; ?></td>
                        <td><?php echo $estudiante['apellidos']; ?></td>
                        <td><?php echo $estudiante['correo']; ?></td>
                        <td><?php echo $estudiante['carnet']; ?></td>
                        <td><?php echo $estudiante['telefono']; ?></td>
                        <td><?php echo $estudiante['direccionDomicilio']; ?></td>
                        <td class="gap-4">
                            <a onclick="editarEstudiante(<?php echo $estudiante['id']; ?>)" data-bs-toggle="tooltip" data-bs-title="Editar" class="text-primary"><i class="bi bi-pencil-fill"></i></a>
                            <form id="deleteForm<?php echo $estudiante['id']; ?>" action="/dashboard/estudiantes/eliminar" method="POST" style="display:inline-block;">
                                <input type="hidden" name="id" value="<?php echo $estudiante['id']; ?>" />
                                <a onclick="eliminarEstudiante(<?php echo $estudiante['id']; ?>)" type="button" data-bs-toggle="tooltip" data-bs-title="Eliminar" class="text-danger"><i class="bi bi-trash3-fill"></i></a>
                            </form>
                            <a href="#" onclick="verEstudiante(<?php echo $estudiante['id']; ?>)" data-bs-toggle="tooltip" data-bs-title="Ver" class="text-secondary"><i class="bi bi-eye-fill"></i></a>
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
                    if ($estudiantes['paginaActual'] > 1):
                    ?>
                        <li class="page-item">
                            <a class="page-link" href="?pagina=<?php echo $estudiantes['paginaActual'] - 1; ?>&titulo=<?php echo htmlspecialchars($_GET['titulo'] ?? ''); ?>">Anterior</a>
                        </li>
                    <?php endif; ?>

                    <?php
                    // Mostrar los enlaces de las páginas
                    for ($i = 1; $i <= $estudiantes['totalPaginas']; $i++):
                    ?>
                        <li class="page-item <?php echo $i === $estudiantes['paginaActual'] ? 'active' : ''; ?>">
                            <a class="page-link" href="?pagina=<?php echo $i; ?>&titulo=<?php echo htmlspecialchars($_GET['titulo'] ?? ''); ?>">
                                <?php echo $i; ?>
                            </a>
                        </li>
                    <?php endfor; ?>

                    <?php
                    // Si no estamos en la última página, mostrar el enlace "Siguiente"
                    if ($estudiantes['paginaActual'] < $estudiantes['totalPaginas']):
                    ?>
                        <li class="page-item">
                            <a class="page-link" href="?pagina=<?php echo $estudiantes['paginaActual'] + 1; ?>&titulo=<?php echo htmlspecialchars($_GET['titulo'] ?? ''); ?>">Siguiente</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>
</main>
<dialog id="agregarEstudiante">
    <form id="formEstudiantes" method="post" enctype="multipart/form-data">
        <div class="row">
            <input type="text" id="id" name="id" hidden>
            <div class="mb-3 col-6">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" required>
            </div>
            <div class="mb-3 col-6">
                <label for="apellido" class="form-label">Apellido</label>
                <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Apellido" required>
            </div>
            <div class="mb-3 col-6">
                <div class="row g-1">
                    <div class="col-8">
                        <label for="carnet" class="form-label">Carnet</label>
                        <input type="number" min="5" class="form-control" id="carnet" name="carnet" placeholder="Carnet" required>
                    </div>
                    <div class="col-4">
                        <label for="carnet" class="form-label">Expedido</label>
                        <select name="expedido" class="form-select" id="expedido" required>
                            <option value="LP">LP</option>
                            <option value="OR">OR</option>
                            <option value="CB">CB</option>
                            <option value="SC">SC</option>
                            <option value="CH">CH</option>
                            <option value="PT">PT</option>
                            <option value="TJ">TJ</option>
                            <option value="BN">BN</option>
                            <option value="PD">PD</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="mb-3 col-6">
                <label for="correo" class="form-label">Correo</label>
                <input type="email" class="form-control" id="correo" name="correo" placeholder="Correo">
            </div>

            <div class="mb-3 col-6">
                <label for="telefono" class="form-label">Celular</label>
                <input type="number" class="form-control" id="telefono" name="telefono" placeholder="Telefono">
            </div>

            <div class="mb-3 col-6">
                <label for="direccion" class="form-label">Direccion Domicilio</label>
                <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Dirección">
            </div>
            <div class="mb-3 col-12">
                <label for="foto" class="form-label">Foto</label>
                <input type="file" class="form-control" id="foto" name="foto" placeholder="Observación">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
        <button type="button" id="cerrarEstudianteModal" class="btn btn-danger">Cerrar</button>
    </form>
</dialog>


<dialog id="vistaEstudiante">

    <div class="d-flex justify-content-between align-items-center position-relative" style="z-index: 999;">
        <h5 class="card-title mb-0"></h5>
        <button type="button" class="btn-close" id="vistaClose" aria-label="Close"></button>
    </div>

    <div class="card">
        <div class="card-header text-center text-muted">
            <div>
                <img id="vistaFoto" src="" class="rounded-circle mb-3" width="100" height="100" alt="Perfil">
            </div>
            <h5 class="card-title mb-0" id="vistaNombre"></h5>
            <div>
                <div class="d-flex justify-content-center text-muted">
                    <i class="bi bi-envelope me-2"></i>
                    <span id="vistaCorreo"></span>
                </div>
                <div class="d-flex justify-content-center text-muted">
                    <i class="bi bi-telephone me-2"></i>
                    <span id="vistaTelefono"></span>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="mb-3">
                <h6><i class="bi bi-house-door me-2"></i> Dirección</h6>
                <p class="text-muted" id="vistaDireccion">Calle Principal 123, Piso 4B, Madrid, España</p>
            </div>
            <div class="mb-3">
                <h6><i class="bi bi-card-list me-2"></i> Carnet</h6>
                <p class="text-muted" id="vistaCarnet">X-12345678-Z</p>
            </div>
        </div>
    </div>
</dialog>
<script>
    $('#vistaClose').addEventListener('click', () => {
        $('#vistaEstudiante').close()
    })
    $('#agregarEstudianteModal').addEventListener('click', () => {
        $('#agregarEstudiante').showModal()
        $('#formEstudiantes').setAttribute('action', '/dashboard/estudiantes');
        $('#formEstudiantes').reset()
    })
    $('#cerrarEstudianteModal').addEventListener('click', () => {
        $('#agregarEstudiante').close()
    })

    function verEstudiante(id) {
        fetch('/dashboard/estudiantes/' + id)
            .then(response => {

                if (!response.ok) {
                    throw new Error('Error al obtener el estudiante');
                }
                return response.json();
            })
            .then(estudiante => {
                $('#id').textContent = estudiante.id;
                $('#vistaFoto').src = estudiante.foto ? `/storage/uploads/estudiantes/${estudiante.foto}` : '/assets/img/placeholder.svg';
                $('#vistaNombre').textContent = estudiante.nombres + ' ' + estudiante.apellidos;
                $('#vistaCarnet').textContent = estudiante.carnet;
                $('#vistaCorreo').textContent = estudiante.correo;
                $('#vistaTelefono').textContent = estudiante.telefono;
                $('#vistaDireccion').textContent = estudiante.direccionDomicilio;
                $('#vistaEstudiante').showModal()
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    function editarEstudiante(id) {
        $('#formEstudiantes').setAttribute('action', '/dashboard/estudiantes/actualizar');
        fetch('/dashboard/estudiantes/' + id)
            .then(response => {

                if (!response.ok) {
                    throw new Error('Error al obtener el estudiante');
                }
                return response.json();
            })
            .then(estudiante => {
                const [numeroCI, expedido] = estudiante.carnet.split('-');
                $('#id').value = estudiante.id;
                $('#nombre').value = estudiante.nombres;
                $('#apellido').value = estudiante.apellidos;
                $('#carnet').value = numeroCI;
                $('#expedido').value = expedido;
                $('#correo').value = estudiante.correo;
                $('#telefono').value = estudiante.telefono;
                $('#direccion').value = estudiante.direccionDomicilio;
                $('#agregarEstudiante').showModal()
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    function eliminarEstudiante(id) {
        if (confirm("¿Estás seguro de que deseas eliminar este estudiante?")) {
            fetch('/dashboard/estudiantes/eliminar', {
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
                        throw new Error('Error al eliminar el estudiante');
                    }
                    return response.json();
                })
                .then(data => {
                    alert('Curso eliminado exitosamente');
                    window.location.reload();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Hubo un error al eliminar el estudiante');
                });
        }
    }
</script>

<?php require 'template/foot.php' ?>