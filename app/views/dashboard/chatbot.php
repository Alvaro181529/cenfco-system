<?php require 'template/head.php' ?>
<?php require 'template/navbar.php' ?>

<main id="main" class="container" data-aos="fade-up">
    <div class="row mb-3">
        <div class="col-12">
            <form class="d-flex" method="get" action="/dashboard/chatbot">
                <input class="form-control me-2" type="search" placeholder="Buscar chatbot por nombre..." aria-label="Buscar" value="<?php echo htmlspecialchars($_GET['nombre'] ?? ''); ?>" name="nombre">
                <button class="btn btn-outline-success" type="submit">Buscar</button>
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead class="text-center">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Mensaje</th>
                    <th scope="col">Respuesta</th>
                    <th scope="col">Fecha Adquisición</th>
                    <th scope="col"><button id="agregarChatbotModal" class="btn btn-success" data-bs-toggle="tooltip" data-bs-title="Agregar"><i class="bi bi-person-plus-fill"></i></button></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($mensajes as $chatbot): ?>
                    <tr>
                        <th scope="row"><?php echo str_pad($chatbot['id'], 5, '0', STR_PAD_LEFT); ?></th>
                        <td><?php echo $chatbot['mensaje']; ?></td>
                        <td><?php echo $chatbot['contenido']; ?></td>
                        <td><?php echo $chatbot['create_at']; ?></td>
                        <td class="gap-4">
                            <a onclick="editarChatbot(<?php echo $chatbot['id']; ?>)" data-bs-toggle="tooltip" data-bs-title="Editar" class="text-primary"><i class="bi bi-pencil-fill"></i></a>
                            <form id="deleteForm<?php echo $chatbot['id']; ?>" action="/dashboard/chatbot/eliminar" method="POST" style="display:inline-block;">
                                <input type="hidden" name="id" value="<?php echo $chatbot['id']; ?>" />
                                <a onclick="eliminarChatbot(<?php echo $chatbot['id']; ?>)" type="button" data-bs-toggle="tooltip" data-bs-title="Eliminar" class="text-danger"><i class="bi bi-trash3-fill"></i></a>
                            </form>
                            <a onclick="verChatbot(<?php echo $chatbot['id']; ?>)" data-bs-toggle="tooltip" data-bs-title="Ver" class="text-secondary"><i class="bi bi-eye-fill"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>

<dialog id="agregarChatbot">
    <form id="formChatbots" method="post">
        <input type="text" id="id" name="id" hidden>
        <div class="row">
            <div class="mb-3">
                <label for="mensaje" class="form-label">Mensaje</label>
                <input type="text" class="form-control" id="mensaje" name="mensaje" placeholder="Mensaje">
            </div>
            <div class="mb-3">
                <label for="contenido" class="form-label">Mensaje</label>
                <textarea type="text" class="form-control" id="contenido" name="contenido" placeholder="Contenido"></textarea>
            </div>
        </div>
        <button type="submit" id="guardarBoton" class="btn btn-primary">Guardar</button>
        <button type="button" id="cerrarChatbotModal" class="btn btn-danger">Cerrar</button>
    </form>
</dialog>

<script>
    // Mostrar el modal para agregar un nuevo chatbot
    $('#agregarChatbotModal').addEventListener('click', () => {
        $('#agregarChatbot').showModal();
        $('#formChatbots').setAttribute('action', '/dashboard/chatbot');
        $('#formChatbots').reset();
        $('#guardarBoton').removeAttribute('hidden')
        $('#id').disabled = false
        $('#nombre').disabled = false
        $('#descripcion').disabled = false
        $('#cantidad').disabled = false
        $('#fechaAdquisicion').disabled = false
    });

    // Cerrar el modal
    $('#cerrarChatbotModal').addEventListener('click', () => {
        $('#agregarChatbot').close();
    });

    // Función para editar un chatbot
    function editarChatbot(id) {
        $('#formChatbots').setAttribute('action', '/dashboard/chatbot/actualizar');
        $('#guardarBoton').removeAttribute('hidden')
        $('#id').disabled = false
        $('#nombre').disabled = false
        $('#descripcion').disabled = false
        $('#cantidad').disabled = false
        $('#fechaAdquisicion').disabled = false

        fetch('/dashboard/chatbot/' + id)
            .then(response => response.json())
            .then(chatbot => {
                $('#id').value = chatbot.id;
                $('#nombre').value = chatbot.nombre;
                $('#descripcion').value = chatbot.descripcion;
                $('#cantidad').value = chatbot.cantidad;
                $('#fechaAdquisicion').value = chatbot.fechaAdquisicion;
                $('#agregarChatbot').showModal();
            })
            .catch(error => console.error('Error al obtener el chatbot:', error));
    }
    // Función para ver un chatbot
    function verChatbot(id) {
        $('#formChatbots').setAttribute('action', '/dashboard/chatbot/actualizar');
        fetch('/dashboard/chatbot/' + id)
            .then(response => response.json())
            .then(chatbot => {
                $('#id').value = chatbot.id;
                $('#nombre').value = chatbot.nombre;
                $('#descripcion').value = chatbot.descripcion;
                $('#cantidad').value = chatbot.cantidad;
                $('#fechaAdquisicion').value = chatbot.fechaAdquisicion;
                if (id) {
                    $('#id').disabled = true
                    $('#nombre').disabled = true
                    $('#descripcion').disabled = true
                    $('#cantidad').disabled = true
                    $('#fechaAdquisicion').disabled = true
                }
                $('#guardarBoton').setAttribute('hidden', true)
                $('#agregarChatbot').showModal();
            })
            .catch(error => console.error('Error al obtener el chatbot:', error));
    }

    // Función para eliminar un chatbot
    function eliminarChatbot(id) {
        if (confirm("¿Estás seguro de que deseas eliminar este chatbot?")) {
            fetch('/dashboard/chatbot/eliminar', {
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
                        throw new Error('Error al eliminar el chatbot');
                    }
                    return response.json();
                })
                .then(data => {
                    alert('Chatbot eliminado exitosamente');
                    window.location.reload();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Hubo un error al eliminar el chatbot');
                });
        }
    }
</script>

<?php require 'template/foot.php' ?>