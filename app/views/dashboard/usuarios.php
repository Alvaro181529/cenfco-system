<?php require 'template/head.php' ?>
<?php require 'template/navbar.php' ?>

<main id="main" class="container" data-aos="fade-up">
    <div class="row mb-3">
        <div class="col-12">
            <form class="d-flex" method="GET" action="/dashboard/usuarios">
                <input type="text" class="form-control me-2" name="search" placeholder="Buscar por nombre o correo" value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
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
                    <th scope="col">Roles</th>
                    <th scope="col">Fecha creacion</th>
                    <th scope="col"><button id="agregarUserModal" class="btn btn-success" data-bs-toggle="tooltip" data-bs-title="Agregar"><i class="bi bi-person-plus-fill"></i></button></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios['usuarios'] as $usuario): ?>
                    <tr>
                        <th scope="row"><?php echo str_pad($usuario['id'], 5, '0', STR_PAD_LEFT); ?></th>
                        <td><?php echo $usuario['username']; ?></td>
                        <td><?php echo $usuario['correo']; ?></td>
                        <td><?php echo $usuario['role']; ?></td>
                        <td><?php echo $usuario['created_at']; ?></td>
                        <td class="gap-4">
                            <a onclick="editarUser(<?php echo $usuario['id']; ?>)" data-bs-toggle="tooltip" data-bs-title="Editar" class="text-primary"><i class="bi bi-pencil-fill"></i></a>
                            <form id="deleteForm<?php echo $usuario['id']; ?>" action="/dashboard/usuario/eliminar" method="POST" style="display:inline-block;">
                                <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>" />
                                <a onclick="eliminarUser(<?php echo $usuario['id']; ?>)" type="button" data-bs-toggle="tooltip" data-bs-title="Eliminar" class="text-danger"><i class="bi bi-trash3-fill"></i></a>
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
                    if ($usuarios['paginaActual'] > 1):
                    ?>
                        <li class="page-item">
                            <a class="page-link" href="?pagina=<?php echo $usuarios['paginaActual'] - 1; ?>&titulo=<?php echo htmlspecialchars($_GET['titulo'] ?? ''); ?>">Anterior</a>
                        </li>
                    <?php endif; ?>

                    <?php
                    // Mostrar los enlaces de las páginas
                    for ($i = 1; $i <= $usuarios['totalPaginas']; $i++):
                    ?>
                        <li class="page-item <?php echo $i === $usuarios['paginaActual'] ? 'active' : ''; ?>">
                            <a class="page-link" href="?pagina=<?php echo $i; ?>&titulo=<?php echo htmlspecialchars($_GET['titulo'] ?? ''); ?>">
                                <?php echo $i; ?>
                            </a>
                        </li>
                    <?php endfor; ?>

                    <?php
                    // Si no estamos en la última página, mostrar el enlace "Siguiente"
                    if ($usuarios['paginaActual'] < $usuarios['totalPaginas']):
                    ?>
                        <li class="page-item">
                            <a class="page-link" href="?pagina=<?php echo $usuarios['paginaActual'] + 1; ?>&titulo=<?php echo htmlspecialchars($_GET['titulo'] ?? ''); ?>">Siguiente</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>
</main>

<dialog id="agregarUser">
    <form id="formUsers" method="post">
        <input type="text" id="id" name="id" hidden>
        <div class="row">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre">
            </div>
            <div class="mb-3">
                <label for="correo" class="form-label">Correo</label>
                <input type="email" class="form-control" id="correo" name="correo" placeholder="Correo">
            </div>
            <div class="mb-3" id="cajaPass">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña">
            </div>
            <div class="mb-3">
                <label for="rol" class="form-label">Roles</label>
                <select class="form-select" id="rol" name="rol">
                    <option value="Administrador">Administrador</option>
                    <option value="Vendedor">Vendedor</option>
                    <option value="Contador">Contador</option>
                    <option value="Usuario">Usuario</option>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
        <button type="button" id="cerrarUserModal" class="btn btn-danger">Cerrar</button>
    </form>
</dialog>

<script>
    // Mostrar el modal para agregar un nuevo usuario
    $('#agregarUserModal').addEventListener('click', () => {
        $('#agregarUser').showModal();
        $('#formUsers').setAttribute('action', '/dashboard/usuarios');
        $('#cajaPass').removeAttribute('hidden');
        $('#formUsers').reset();
    });

    // Cerrar el modal
    $('#cerrarUserModal').addEventListener('click', () => {
        $('#agregarUser').close();
    });

    // Función para editar un usuario
    function editarUser(id) {
        $('#formUsers').setAttribute('action', '/dashboard/usuarios/actualizar');
        fetch('/dashboard/usuarios/' + id)
            .then(response => response.json())
            .then(usuario => {
                $('#id').value = usuario.id;
                $('#nombre').value = usuario.username;
                $('#correo').value = usuario.correo;
                $('#rol').value = usuario.role;
                $('#agregarUser').showModal();
                $('#cajaPass').setAttribute('hidden', true)
            })
            .catch(error => console.error('Error al obtener el usuario:', error));
    }

    // Función para eliminar un usuario
    function eliminarUser(id) {
        if (confirm("¿Estás seguro de que deseas eliminar este usuario?")) {
            fetch('/dashboard/usuarios/eliminar', {
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
                        throw new Error('Error al eliminar el usuario');
                    }
                    return response.json();
                })
                .then(data => {
                    alert('User eliminado exitosamente');
                    window.location.reload();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Hubo un error al eliminar el usuario');
                });
        }
    }
</script>

<?php require 'template/foot.php' ?>