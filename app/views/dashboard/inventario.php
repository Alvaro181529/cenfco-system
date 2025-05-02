<?php require 'template/head.php' ?>
<?php require 'template/navbar.php' ?>

<main id="main" class="container" data-aos="fade-up">
    <div class="row mb-3">
        <div class="col-12">
            <form class="d-flex" method="get" action="/dashboard/inventario">
                <input class="form-control me-2" type="search" placeholder="Buscar inventario por nombre..." aria-label="Buscar" value="<?php echo htmlspecialchars($_GET['nombre'] ?? ''); ?>" name="nombre">
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
                    <th scope="col">Descripción</th>
                    <th scope="col">Cantidad</th>
                    <th scope="col">Fecha Adquisición</th>
                    <th scope="col"><button id="agregarInventarioModal" class="btn btn-success" data-bs-toggle="tooltip" data-bs-title="Agregar"><i class="bi bi-person-plus-fill"></i></button></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($inventarios['inventarios'] as $inventario): ?>
                    <tr>
                        <th scope="row"><?php echo str_pad($inventario['id'], 5, '0', STR_PAD_LEFT); ?></th>
                        <td><?php echo $inventario['nombre']; ?></td>
                        <td><?php echo $inventario['descripcion']; ?></td>
                        <td><?php echo $inventario['cantidad']; ?></td>
                        <td><?php echo $inventario['fechaAdquisicion']; ?></td>
                        <td class="gap-4">
                            <a onclick="editarInventario(<?php echo $inventario['id']; ?>)" data-bs-toggle="tooltip" data-bs-title="Editar" class="text-primary"><i class="bi bi-pencil-fill"></i></a>
                            <form id="deleteForm<?php echo $inventario['id']; ?>" action="/dashboard/inventario/eliminar" method="POST" style="display:inline-block;">
                                <input type="hidden" name="id" value="<?php echo $inventario['id']; ?>" />
                                <a onclick="eliminarInventario(<?php echo $inventario['id']; ?>)" type="button" data-bs-toggle="tooltip" data-bs-title="Eliminar" class="text-danger"><i class="bi bi-trash3-fill"></i></a>
                            </form>
                            <a onclick="verInventario(<?php echo $inventario['id']; ?>)" data-bs-toggle="tooltip" data-bs-title="Ver" class="text-secondary"><i class="bi bi-eye-fill"></i></a>
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
                    if ($inventarios['paginaActual'] > 1):
                    ?>
                        <li class="page-item">
                            <a class="page-link" href="?pagina=<?php echo $inventarios['paginaActual'] - 1; ?>&titulo=<?php echo htmlspecialchars($_GET['titulo'] ?? ''); ?>">Anterior</a>
                        </li>
                    <?php endif; ?>

                    <?php
                    // Mostrar los enlaces de las páginas
                    for ($i = 1; $i <= $inventarios['totalPaginas']; $i++):
                    ?>
                        <li class="page-item <?php echo $i === $inventarios['paginaActual'] ? 'active' : ''; ?>">
                            <a class="page-link" href="?pagina=<?php echo $i; ?>&titulo=<?php echo htmlspecialchars($_GET['titulo'] ?? ''); ?>">
                                <?php echo $i; ?>
                            </a>
                        </li>
                    <?php endfor; ?>

                    <?php
                    // Si no estamos en la última página, mostrar el enlace "Siguiente"
                    if ($inventarios['paginaActual'] < $inventarios['totalPaginas']):
                    ?>
                        <li class="page-item">
                            <a class="page-link" href="?pagina=<?php echo $inventarios['paginaActual'] + 1; ?>&titulo=<?php echo htmlspecialchars($_GET['titulo'] ?? ''); ?>">Siguiente</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>
</main>

<dialog id="agregarInventario">
    <form id="formInventarios" method="post">
        <input type="text" id="id" name="id" hidden>
        <div class="row">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" maxlength="50" placeholder="Nombre" required>
            </div>
            <div class="row">
                <div class="mb-3 col">
                    <label for="cantidad" class="form-label">Cantidad</label>
                    <input type="number" class="form-control" id="cantidad" name="cantidad" placeholder="Cantidad">
                </div>
                <div class="mb-3 col">
                    <label for="fechaAdquisicion" class="form-label">Fecha Adquisición</label>
                    <input type="date" class="form-control" id="fechaAdquisicion" name="fechaAdquisicion" placeholder="Fecha Adquisición">
                </div>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea type="text" class="form-control" id="descripcion" name="descripcion" placeholder="Descripción"></textarea>
            </div>
        </div>
        <button type="submit" id="guardarBoton" class="btn btn-primary">Guardar</button>
        <button type="button" id="cerrarInventarioModal" class="btn btn-danger">Cerrar</button>
    </form>
</dialog>

<script>
    // Mostrar el modal para agregar un nuevo inventario
    $('#agregarInventarioModal').addEventListener('click', () => {
        $('#agregarInventario').showModal();
        $('#formInventarios').setAttribute('action', '/dashboard/inventario');
        $('#formInventarios').reset();
        $('#guardarBoton').removeAttribute('hidden')
        $('#id').disabled = false
        $('#nombre').disabled = false
        $('#descripcion').disabled = false
        $('#cantidad').disabled = false
        $('#fechaAdquisicion').disabled = false
    });

    // Cerrar el modal
    $('#cerrarInventarioModal').addEventListener('click', () => {
        $('#agregarInventario').close();
    });

    // Función para editar un inventario
    function editarInventario(id) {
        $('#formInventarios').setAttribute('action', '/dashboard/inventario/actualizar');
        $('#guardarBoton').removeAttribute('hidden')
        $('#id').disabled = false
        $('#nombre').disabled = false
        $('#descripcion').disabled = false
        $('#cantidad').disabled = false
        $('#fechaAdquisicion').disabled = false

        fetch('/dashboard/inventario/' + id)
            .then(response => response.json())
            .then(inventario => {
                $('#id').value = inventario.id;
                $('#nombre').value = inventario.nombre;
                $('#descripcion').value = inventario.descripcion;
                $('#cantidad').value = inventario.cantidad;
                $('#fechaAdquisicion').value = inventario.fechaAdquisicion;
                $('#agregarInventario').showModal();
            })
            .catch(error => console.error('Error al obtener el inventario:', error));
    }
    // Función para ver un inventario
    function verInventario(id) {
        $('#formInventarios').setAttribute('action', '/dashboard/inventario/actualizar');
        fetch('/dashboard/inventario/' + id)
            .then(response => response.json())
            .then(inventario => {
                $('#id').value = inventario.id;
                $('#nombre').value = inventario.nombre;
                $('#descripcion').value = inventario.descripcion;
                $('#cantidad').value = inventario.cantidad;
                $('#fechaAdquisicion').value = inventario.fechaAdquisicion;
                if (id) {
                    $('#id').disabled = true
                    $('#nombre').disabled = true
                    $('#descripcion').disabled = true
                    $('#cantidad').disabled = true
                    $('#fechaAdquisicion').disabled = true
                }
                $('#guardarBoton').setAttribute('hidden', true)
                $('#agregarInventario').showModal();
            })
            .catch(error => console.error('Error al obtener el inventario:', error));
    }

    // Función para eliminar un inventario
    function eliminarInventario(id) {
        if (confirm("¿Estás seguro de que deseas eliminar este inventario?")) {
            fetch('/dashboard/inventario/eliminar', {
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
                        throw new Error('Error al eliminar el inventario');
                    }
                    return response.json();
                })
                .then(data => {
                    alert('Inventario eliminado exitosamente');
                    window.location.reload();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Hubo un error al eliminar el inventario');
                });
        }
    }
</script>

<?php require 'template/foot.php' ?>