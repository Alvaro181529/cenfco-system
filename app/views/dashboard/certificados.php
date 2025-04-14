<?php require 'template/head.php' ?>
<?php require 'template/navbar.php' ?>
<main id="main" class="container" data-aos="fade-up">
    <div class="row mb-3">
        <div class="col-12">
            <form class="d-flex" method="get" action="/dashboard/certificados">
                <input class="form-control me-2" type="search" placeholder="Buscar inventario por nombre..." aria-label="Buscar" value="<?php echo htmlspecialchars($_GET['titulo'] ?? ''); ?>" name="titulo">
                <button class="btn btn-outline-success" type="submit">Buscar</button>
            </form>
        </div>
    </div>
    
    <!-- Tabla de resultados -->
    <div class="table-responsive">
        <table class="table table-striped">
            <thead class="text-center">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Titulo</th>
                    <th scope="col">Precio Individual</th>
                    <th scope="col">Precio Curso</th>
                    <th scope="col">Fecha Emision</th>
                    <th scope="col"><button id="agregarCertificadoModal" class="btn btn-success"><i class="bi bi-person-plus-fill"></i></button></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($certificados['certificados'] as $certificado): ?>
                    <tr>
                        <th scope="row"><?php echo str_pad($certificado['id'], 5, '0', STR_PAD_LEFT); ?></th>
                        <td><?php echo $certificado['titulo']; ?></td>
                        <td><?php echo $certificado['precioIndividual']; ?></td>
                        <td><?php echo $certificado['precioCurso']; ?></td>
                        <td><?php echo $certificado['fechaEmision']; ?></td>
                        <td class="gap-4">
                            <a onclick="editarCertificado(<?php echo $certificado['id']; ?>)" data-bs-toggle="tooltip" data-bs-title="Editar" class="text-primary"><i class="bi bi-pencil-fill"></i></a>
                            <form id="deleteForm<?php echo $certificado['id']; ?>" action="/dashboard/certificados/eliminar" method="POST" style="display:inline-block;">
                                <input type="hidden" name="id" value="<?php echo $certificado['id']; ?>" />
                                <a onclick="eliminarCertificado(<?php echo $certificado['id']; ?>)" type="button" data-bs-toggle="tooltip" data-bs-title="Eliminar" class="text-danger"><i class="bi bi-trash3-fill"></i></a>
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
                    if ($certificados['paginaActual'] > 1):
                    ?>
                        <li class="page-item">
                            <a class="page-link" href="?pagina=<?php echo $certificados['paginaActual'] - 1; ?>&titulo=<?php echo htmlspecialchars($_GET['titulo'] ?? ''); ?>">Anterior</a>
                        </li>
                    <?php endif; ?>

                    <?php
                    // Mostrar los enlaces de las páginas
                    for ($i = 1; $i <= $certificados['totalPaginas']; $i++):
                    ?>
                        <li class="page-item <?php echo $i === $certificados['paginaActual'] ? 'active' : ''; ?>">
                            <a class="page-link" href="?pagina=<?php echo $i; ?>&titulo=<?php echo htmlspecialchars($_GET['titulo'] ?? ''); ?>">
                                <?php echo $i; ?>
                            </a>
                        </li>
                    <?php endfor; ?>

                    <?php
                    // Si no estamos en la última página, mostrar el enlace "Siguiente"
                    if ($certificados['paginaActual'] < $certificados['totalPaginas']):
                    ?>
                        <li class="page-item">
                            <a class="page-link" href="?pagina=<?php echo $certificados['paginaActual'] + 1; ?>&titulo=<?php echo htmlspecialchars($_GET['titulo'] ?? ''); ?>">Siguiente</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>
</main>

<dialog id="agregarCertificado">
    <form id="formCertificados" method="post">
        <input type="text" id="id" name="id" hidden>
        <div class="row">
            <div class="mb-3">
                <label for="titulo" class="form-label">Titulo</label>
                <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Nombre">
            </div>
            <div class="row">
                <div class="mb-3 col">
                    <label for="precioIndividual" class="form-label">Precio Individual</label>
                    <input type="number" class="form-control" id="precioIndividual" name="precioIndividual" placeholder="Precio Individual">
                </div>
                <div class="mb-3 col">
                    <label for="precioCurso" class="form-label">Precio Curso</label>
                    <input type="number" class="form-control" id="precioCurso" name="precioCurso" placeholder="Precio Curso">
                </div>
            </div>

            <div class="mb-3">
                <label for="fechaEmision" class="form-label">fecha Emision</label>
                <input type="date" class="form-control" id="fechaEmision" name="fechaEmision" placeholder="fecha Adquisicion">
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripcion</label>
                <textarea class="form-control" id="descripcion" name="descripcion" placeholder="Descripcion"></textarea>
            </div>


        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
        <button type="button" id="cerrarDocenteModal" class="btn btn-danger">Cerrar</button>
    </form>
</dialog>


<script>
    $('#agregarCertificadoModal').addEventListener('click', () => {
        $('#agregarCertificado').showModal()
        $('#formCertificados').setAttribute('action', '/dashboard/certificados');
        $('#formCertificados').reset()
    })
    $('#cerrarDocenteModal').addEventListener('click', () => {
        $('#agregarCertificado').close()
    })

    function editarCertificado(id) {
        $('#formCertificados').setAttribute('action', '/dashboard/certificados/actualizar');
        fetch('/dashboard/certificados/' + id)
            .then(response => {

                if (!response.ok) {
                    throw new Error('Error al obtener el certificado');
                }
                return response.json();
            })
            .then(certificado => {
                $('#id').value = certificado.id;
                $('#titulo').value = certificado.titulo;
                $('#descripcion').value = certificado.descripcion;
                $('#precioIndividual').value = certificado.precioIndividual;
                $('#precioCurso').value = certificado.precioCurso;
                $('#fechaEmision').value = certificado.fechaEmision;
                $('#agregarCertificado').showModal()
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    function eliminarCertificado(id) {
        if (confirm("¿Estás seguro de que deseas eliminar este certificado?")) {
            fetch('/dashboard/certificados/eliminar', {
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
                        throw new Error('Error al eliminar el certificado');
                    }
                    return response.json();
                })
                .then(data => {
                    alert('Curso eliminado exitosamente');
                    window.location.reload();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Hubo un error al eliminar el certificado');
                });
        }
    }
</script>

<?php require 'template/foot.php' ?>