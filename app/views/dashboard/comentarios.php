<?php require 'template/head.php' ?>
<?php require 'template/navbar.php' ?>
<main id="main" class="container">
    <div class="row mb-3">
        <div class="col-12">
            <form class="d-flex" method="get" action="/dashboard/comentarios">
                <input class="form-control me-2" type="search" placeholder="Buscar comentarios por asunto..." aria-label="Buscar" value="<?php echo htmlspecialchars($_GET['asunto'] ?? ''); ?>" name="asunto">
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
                    <th scope="col">Asunto</th>
                    <th scope="col">Mensaje</th>
                    <th scope="col"><button id="agregarComentarioModal" class="btn btn-success"><i class="bi bi-person-plus-fill"></i></button></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($comentarios as $comentario): ?>
                    <tr>
                        <th scope="row"><?php echo str_pad($comentario['id'], 5, '0', STR_PAD_LEFT); ?></th>
                        <td><?php echo $comentario['nombre']; ?></td>
                        <td><?php echo $comentario['correo']; ?></td>
                        <td><?php echo $comentario['asunto']; ?></td>
                        <td><?php echo $comentario['mensaje']; ?></td>
                        <td class="gap-4">
                            <a onclick="editarComentario(<?php echo $comentario['id']; ?>)" data-bs-toggle="tooltip" data-bs-title="Editar" class="text-primary"><i class="bi bi-pencil-fill"></i></a>
                            <form id="deleteForm<?php echo $comentario['id']; ?>" action="/dashboard/comentarios/eliminar" method="POST" style="display:inline-block;">
                                <input type="hidden" name="id" value="<?php echo $comentario['id']; ?>" />
                                <a onclick="eliminarComentario(<?php echo $comentario['id']; ?>)" type="button" data-bs-toggle="tooltip" data-bs-title="Eliminar" class="text-danger"><i class="bi bi-trash3-fill"></i></a>
                            </form>
                            <a href="#" data-bs-toggle="tooltip" data-bs-title="Ver" class="text-secondary"><i class="bi bi-eye-fill"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>

<dialog id="agregarComentario">
    <form id="formComentarios" method="post">
        <input type="text" id="id" name="id" hidden>
        <div class="row">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre">
            </div>
            <div class="mb-3">
                <label for="correo" class="form-label">Correo</label>
                <input type="email" class="form-control" id="correo" name="correo" placeholder="Correo electrónico">
            </div>
            <div class="mb-3">
                <label for="asunto" class="form-label">Asunto</label>
                <input type="text" class="form-control" id="asunto" name="asunto" placeholder="Asunto del comentario">
            </div>
            <div class="mb-3">
                <label for="mensaje" class="form-label">Mensaje</label>
                <textarea class="form-control" id="mensaje" name="mensaje" placeholder="Escribe tu mensaje"></textarea>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
        <button type="button" id="cerrarComentarioModal" class="btn btn-danger">Cerrar</button>
    </form>
</dialog>

<script>
    $('#agregarComentarioModal').addEventListener('click', () => {
        $('#agregarComentario').showModal();
        $('#formComentarios').setAttribute('action', '/dashboard/comentarios');
        $('#formComentarios').reset();
    });

    $('#cerrarComentarioModal').addEventListener('click', () => {
        $('#agregarComentario').close();
    });

    function editarComentario(id) {
        $('#formComentarios').setAttribute('action', '/dashboard/comentarios/actualizar');
        fetch('/dashboard/comentarios/' + id)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error al obtener el comentario');
                }
                return response.json();
            })
            .then(comentario => {
                $('#id').value = comentario.id;
                $('#nombre').value = comentario.nombre;
                $('#correo').value = comentario.correo;
                $('#asunto').value = comentario.asunto;
                $('#mensaje').value = comentario.mensaje;
                $('#agregarComentario').showModal();
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    function eliminarComentario(id) {
        if (confirm("¿Estás seguro de que deseas eliminar este comentario?")) {
            fetch('/dashboard/comentarios/eliminar', {
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
                    throw new Error('Error al eliminar el comentario');
                }
                return response.json();
            })
            .then(data => {
                alert('Comentario eliminado exitosamente');
                window.location.reload();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Hubo un error al eliminar el comentario');
            });
        }
    }
</script>

<?php require 'template/foot.php' ?>
