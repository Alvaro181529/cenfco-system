<?php require 'template/head.php' ?>
<?php require 'template/navbar.php' ?>
<main id="main" class="container" data-aos="fade-up">
    <div class="row">
        <div class="col">
            <form action="/dashboard/cursos" method="GET" class="d-flex align-items-center">
                <input type="text" class="form-control me-2" name="titulo" placeholder="Buscar por título" value="<?php echo isset($_GET['titulo']) ? $_GET['titulo'] : ''; ?>">
                <select name="categoria" class="form-select me-2" id="categoria">
                    <option value="">Todo</option>
                    <option value="Ciencias Humanas" <?php echo isset($_GET['categoria']) && $_GET['categoria'] == 'Ciencias Humanas' ? 'selected' : ''; ?>>Ciencias Humanas</option>
                    <option value="Arquitecturas" <?php echo isset($_GET['categoria']) && $_GET['categoria'] == 'Arquitecturas' ? 'selected' : ''; ?>>Arquitecturas</option>
                    <option value="Derecho" <?php echo isset($_GET['categoria']) && $_GET['categoria'] == 'Derecho' ? 'selected' : ''; ?>>Derecho</option>
                    <option value="Tecnologias" <?php echo isset($_GET['categoria']) && $_GET['categoria'] == 'Tecnologias' ? 'selected' : ''; ?>>Tecnologías</option>
                    <option value="Ciencias Empresariales" <?php echo isset($_GET['categoria']) && $_GET['categoria'] == 'Ciencias Empresariales' ? 'selected' : ''; ?>>Ciencias Empresariales</option>
                </select>
                <div class="col-auto">
                    <button class="btn btn-primary" type="submit">Buscar</button>
                    <button id="agregarCursosModal" data-bs-toggle="tooltip" type="button" data-bs-title="Agregar" class="btn btn-success my-4">
                        <i class="bi bi-person-plus"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <?php foreach ($cursos['cursos'] as $curso): ?>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="card">
                    <img class="card-img-top" style="height: 350px;object-fit: cover;" src="<?php echo (!empty($curso['imagen']) ? '/storage/uploads/cursos/' . $curso['imagen'] : '/assets/img/placeholder.svg') ?>" alt="<?php echo $curso['titulo']; ?>" />
                    <div class="card-body">
                        <div class="row">
                            <h4 class="card-title col"><?php echo $curso['titulo']; ?></h4>
                            <h4 class="card-title col text-end text-secondary h5"><?php echo $curso['precio']; ?>Bs</h4>
                        </div>
                        <p class="card-text"><?php echo $curso['descripcion']; ?></p>
                        <div class="text-center">
                            <!-- Botón para editar -->
                            <button onclick="editarCurso(<?php echo $curso['id']; ?>)" data-bs-toggle="tooltip" data-bs-title="Editar" class="btn btn-primary text-white">
                                <i class="bi bi-pencil"></i>
                            </button>

                            <!-- Botón para eliminar -->
                            <form id="deleteForm<?php echo $curso['id']; ?>" action="/dashboard/cursos/eliminar" method="POST" style="display:inline-block;">
                                <input type="hidden" name="id" value="<?php echo $curso['id']; ?>" />
                                <button type="button" class="btn btn-danger text-white" onclick="eliminarCurso(<?php echo $curso['id']; ?>)" data-bs-toggle="tooltip" data-bs-title="Eliminar">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </form>


                            <!-- Botón para ver detalles -->
                            <button onclick="verCurso(<?php echo $curso['id']; ?>)" data-bs-toggle="tooltip" data-bs-title="Ver" class="btn btn-secondary text-white">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

    </div>

        <!-- Paginación -->
        <div class="d-flex justify-content-center">
            <nav>
                <ul class="pagination">
                    <?php
                    // Si estamos en la página 1, no mostrar enlace "Anterior"
                    if ($cursos['paginaActual'] > 1):
                    ?>
                        <li class="page-item">
                            <a class="page-link" href="?pagina=<?php echo $cursos['paginaActual'] - 1; ?>&titulo=<?php echo htmlspecialchars($_GET['titulo'] ?? ''); ?>">Anterior</a>
                        </li>
                    <?php endif; ?>

                    <?php
                    // Mostrar los enlaces de las páginas
                    for ($i = 1; $i <= $cursos['totalPaginas']; $i++):
                    ?>
                        <li class="page-item <?php echo $i === $cursos['paginaActual'] ? 'active' : ''; ?>">
                            <a class="page-link" href="?pagina=<?php echo $i; ?>&titulo=<?php echo htmlspecialchars($_GET['titulo'] ?? ''); ?>">
                                <?php echo $i; ?>
                            </a>
                        </li>
                    <?php endfor; ?>

                    <?php
                    // Si no estamos en la última página, mostrar el enlace "Siguiente"
                    if ($cursos['paginaActual'] < $cursos['totalPaginas']):
                    ?>
                        <li class="page-item">
                            <a class="page-link" href="?pagina=<?php echo $cursos['paginaActual'] + 1; ?>&titulo=<?php echo htmlspecialchars($_GET['titulo'] ?? ''); ?>">Siguiente</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
</main>
<dialog id="agregarCursos" class="dialogMid">
    <form id="formCursos" method="post" enctype="multipart/form-data">
        <input type="text" id="id" name="id" hidden>
        <input type="text" id="imagen_antigua" name="imagen_antigua" hidden>
        <div class="row">
            <div class="mb-3 col">
                <label for="titulo" class="form-label">Titulo</label>
                <input type="text" class="form-control" id="titulo" name="titulo" maxlength="100" placeholder="Titulo" required>
            </div>
            <div class="mb-3 col">
                <label for="titulo" class="form-label">Docente</label>
                <input type="text" list="listaDocente" class="form-select" id="docente" name="docente" placeholder="Docente">
                <datalist id="listaDocente">
                    <?php foreach ($docentes['docentes'] as $docente): ?>
                        <option value="<?php echo $docente['nombres']; ?> <?php echo $docente['apellidos']; ?>"><?php echo $docente['nombres']; ?> <?php echo $docente['apellidos']; ?></option>
                    <?php endforeach; ?>
                </datalist>
            </div>
        </div>
        <div class="mb-3 col">
            <label for="titulo" class="form-label">Grupo Facebook</label>
            <input type="text" class="form-control" id="grupoFacebook" name="grupoFacebook"  maxlength="50" placeholder="Facebook">
        </div>
        <div class="row">
            <div class="mb-3 col">
                <label for="categoria" class="form-label">Categorias</label>
                <select name="categoria" class="form-select" name="categoria" id="categoria">
                    <option value="Ciencias Humanas">Ciencias Humanas</option>
                    <option value="Arquitecturas">Arquitecturas</option>
                    <option value="Derecho">Derecho</option>
                    <option value="Tecnologias">Tecnologias</option>
                    <option value="Ciencias Empresariales">Ciencias Empresariales</option>
                </select>
            </div>
            <div class="mb-3 col">
                <label for="precio" class="form-label">Precio</label>
                <input type="number" min="0.00" step="0.01"  max="1000.00" class="form-control" id="precio" name="precio" placeholder="Precio">
            </div>
        </div>
        <div class="row">
            <div class="mb-3 col">
                <label for="fechaInicio" class="form-label">Fecha Inicio</label>
                <input type="date" class="form-control" id="fechaInicio" name="fechaInicio" required>
            </div>
            <div class="mb-3 col">
                <label for="fechaFin" class="form-label">Fecha Fin</label>
                <input type="date" class="form-control" id="fechaFin" name="fechaFin" required>
            </div>
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripcion</label>
            <textarea id="descripcion" class="form-control" name="descripcion" placeholder="Descripcion"></textarea>
        </div>
        <div class="mb-3">
            <label for="imagen" class="form-label">Foto</label>
            <input type="file" class="form-control" id="imagen" name="imagen" placeholder="Imagen" accept="image/*" required>
        </div>
        <div class="row">
            <div class="mb-3 col">
                <input class="form-check-input" type="checkbox" value="" id="certificado" name="certificado" checked>
                <label class="form-check-label" for="certificado">
                    Certificado
                </label>
            </div>
            <div class="mb-3 col">
                <input class="form-check-input" type="checkbox" value="" id="mostrar" name="mostrar">
                <label class="form-check-label" for="mostrar">
                    Mostrar en el inicio
                </label>
            </div>
            <div class="mb-3" id="precioCertificado">
                <label class="form-label" for="certificadoPrecio">
                    Precio certificado individual
                </label>
                <input class="form-control" type="number" value="" min="0.00" step="0.01" max="1000.00" id="certificadoPrecio" placeholder="Precio">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
        <button type="button" id="cerrarDocenteModal" class="btn btn-danger">Cerrar</button>
    </form>
</dialog>
<dialog id="vistaCurso">

    <div class="d-flex justify-content-between align-items-center position-relative" style="z-index: 999;">
        <h5 class="card-title mb-0"></h5>
        <button type="button" class="btn-close" id="vistaClose" aria-label="Close"></button>
    </div>

    <div class="card">
        <div class="card-header text-center text-muted">
                <img id="vistaFoto" style="height: 350px;object-fit: cover; z-index: -9999;" class="card-img-top mb-3" width="200" alt="Perfil">
            <h5 class="card-title mb-0" id="vistaNombre"></h5>
            <div>
                <div class="d-flex justify-content-center text-muted">
                    <i class="bi bi-bookmark me-2"></i>
                    <span id="vistaCategoria"></span>
                </div>
                <div class="d-flex justify-content-center text-muted">
                    <i class="bi bi-facebook me-2"></i>
                    <span id="vistaFacebook"></span>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="row mb-3">
                <div class="col">
                    <h6><i class="bi bi-tag me-2"></i>Precio</h6>
                    <p class="text-muted" id="vistaPrecio">Calle Principal 123, Piso 4B, Madrid, España</p>
                </div>
                <div class="col">
                    <h6><i class="bi bi-tag me-2"></i>Mostrado en Inicio</h6>
                    <p class="text-muted" id="vistaInicio">Calle Principal 123, Piso 4B, Madrid, España</p>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <h6><i class="bi bi-calendar me-2"></i> Fecha de inicio</h6>
                    <p class="text-muted" id="vistaFechaInicio">Calle Principal 123, Piso 4B, Madrid, España</p>
                </div>
                <div class="col">
                    <h6><i class="bi bi-calendar me-2"></i> Fecha de fin</h6>
                    <p class="text-muted" id="vistaFechaFin">Calle Principal 123, Piso 4B, Madrid, España</p>
                </div>
            </div>
            <div class="mb-3">
                <h6><i class="bi bi-file-person me-2"></i> Docente</h6>
                <p class="text-muted" id="vistaDocente">X-12345678-Z</p>
            </div>
            <div class="mb-3">
                <h6><i class="bi bi-card-list me-2"></i> Descripcion</h6>
                <p class="text-muted" id="vistaDescripcion">X-12345678-Z</p>
            </div>
        </div>
    </div>
</dialog>

<script>
    $('#certificado').addEventListener('change', () => {
        if (!$('#certificado').checked) {
            $('#precioCertificado').setAttribute('hidden', true);
        } else {
            $('#precioCertificado').removeAttribute('hidden');
        }
    });
    $('#agregarCursosModal').addEventListener('click', () => {
        $('#agregarCursos').showModal()
        $('#formCursos').setAttribute('action', '/dashboard/cursos');
        $('#formCursos').reset();
    })
    $('#cerrarDocenteModal').addEventListener('click', () => {
        $('#agregarCursos').close()
    })
    $('#vistaClose').addEventListener('click', () => {
        $('#vistaCurso').close()
    })

    function verCurso(id) {
        fetch('/dashboard/cursos/' + id)
            .then(response => {

                if (!response.ok) {
                    throw new Error('Error al obtener el curso');
                }
                return response.json();
            })
            .then(curso => {
                $('#id').textContent = curso.id;
                $('#vistaFoto').src = curso.imagen?`/storage/uploads/cursos/${curso.imagen}`:'/assets/img/placeholder.svg' ;
                $('#vistaInicio').textContent = curso.mostrarInicio ? 'Se esta mostrando' : 'No se esta mostrando';
                $('#vistaNombre').textContent = curso.titulo ? curso.titulo : 'No tiene titulo';
                $('#vistaDocente').textContent = curso.docente ? curso.docente : 'No tiene docente';
                $('#vistaCategoria').textContent = curso.categoria ? curso.categoria : 'No se le asigno una categoria';
                $('#vistaDescripcion').textContent = curso.descripcion ? curso.descripcion : 'No tiene descripcion';
                $('#vistaPrecio').textContent = curso.precio ? curso.precio +
                    ' Bs' : 'No tiene precio';
                $('#vistaFacebook').textContent = curso.grupoFacebook ? curso.grupoFacebook : 'No tiene grupo';
                $('#vistaFechaInicio').textContent = curso.fechaInicio ? curso.fechaInicio : 'Sin fecha de Inicio';
                $('#vistaFechaFin').textContent = curso.fechaFin ? curso.fechaFin : 'Sin fecha de Fin';
                $('#vistaCurso').showModal()
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    function editarCurso(id) {
        $('#formCursos').setAttribute('action', '/dashboard/cursos/actualizar');
        fetch('/dashboard/cursos/' + id)
            .then(response => {

                if (!response.ok) {
                    throw new Error('Error al obtener el curso');
                }
                return response.json();
            })
            .then(curso => {
                $('#id').value = curso.id;
                $('#imagen_antigua').value = curso.imagen;
                $('#titulo').value = curso.titulo;
                $('#descripcion').value = curso.descripcion;
                $('#precio').value = curso.precio;
                $('#docente').value = curso.docente;
                $('#categoria').value = curso.categoria;
                $('#agregarCursos').showModal();
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    function eliminarCurso(id) {
        if (confirm("¿Estás seguro de que deseas eliminar este curso?")) {
            fetch('/dashboard/cursos/eliminar', {
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
                        throw new Error('Error al eliminar el curso');
                    }
                    return response.json();
                })
                .then(data => {
                    alert('Curso eliminado exitosamente');
                    window.location.reload();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Hubo un error al eliminar el curso');
                });
        }
    }
</script>

<?php require 'template/foot.php' ?>