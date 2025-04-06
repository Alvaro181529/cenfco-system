<?php require 'template/head.php' ?>
<?php require 'template/navbar.php' ?>

<main id="main" class="container">
    <h1><?php echo $total['0']['totalPrecio'] ?></h1>
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
                        <td><?php echo $venta['cursoTitulo']; ?></td>
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
    </div>
</main>

<dialog id="agregarVenta">
    <form id="formVentas" method="post">
        <input type="text" id="id" name="id" hidden>
        <input type="text" id="tipo" name="tipo" value="curso" hidden>
        <input type="text" id="cursoId" name="cursoId" hidden>
        <input type="text" id="estudianteId" name="estudianteId" hidden>

        <div class="row">
            <div class="mb-3">
                <label for="curso" class="form-label">Curso</label>
                <input type="text" list="listCursos" class="form-control" id="curso" name="curso" placeholder="Título">
                <datalist id="listCursos">
                    <?php foreach ($cursos as $curso): ?>
                        <option value="<?php echo $curso['titulo']; ?>" data-id="<?php echo $curso['id']; ?>" data-price="<?php echo $curso['precio']; ?>"></option>
                    <?php endforeach; ?>
                </datalist>
            </div>

            <div class=" mb-3 col">
                <label for="estudiante" class="form-label">Estudiante</label>
                <input type="text" list="listEstudiante" class="form-control" id="estudiante" name="estudiante" placeholder="Nombre">
                <datalist id="listEstudiante">
                    <?php foreach ($estudiantes as $estudiante): ?>
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