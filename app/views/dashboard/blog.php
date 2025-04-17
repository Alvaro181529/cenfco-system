<?php require 'template/head.php' ?>
<?php require 'template/navbar.php' ?>

<main id="inicio" class="container">
    <div class="menu" data-aos="fade-up">
        <!-- Navegación de las categorías -->
        <ul class="nav nav-tabs d-flex justify-content-center" data-aos="fade-up" data-aos-delay="200">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" data-bs-target="#resumen">
                    <h4>Resumen</h4>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" data-bs-target="#menu">
                    <h4>Menu</h4>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" data-bs-target="#paginas">
                    <h4>Páginas</h4>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" data-bs-target="#contenidos">
                    <h4>Contenidos</h4>
                </a>
            </li>
        </ul>

        <!-- Contenido de las pestañas -->
        <div class="tab-content" data-aos="fade-up" data-aos-delay="300">
            <div class="tab-pane fade show active" id="resumen">
                <div class="tab-header text-center">
                    <h3>Resumen</h3>
                </div>
                <div class="row gap-4" data-aos="fade-up">
                    <div class="card mb-3 col" style="max-width: 540px;">
                        <div class="row g-0">
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">Total menús</h5>
                                    <p class="card-text"><?php echo $menusCantidad ?></p>
                                    <p class="fs-6 text-muted">Categorías principales de navegación</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3 col" style="max-width: 540px;">
                        <div class="row g-0">
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">Total páginas</h5>
                                    <p class="card-text"><?php echo $pagesCantidad ?></p>
                                    <p class="fs-6 text-muted">Páginas organizadas por menús</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3 col" style="max-width: 540px;">
                        <div class="row g-0">
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">Total post</h5>
                                    <p class="card-text"><?php echo $postsCantidad ?></p>
                                    <p class="fs-6 text-muted">Contenido publicado en páginas</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Menu (Principiante) -->
            <div class="tab-pane fade" id="menu">
                <div class="tab-header text-center">
                    <p>Menú</p>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="text-center">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Titulo</th>
                                <th scope="col">Orden</th>
                                <th scope="col"><button id="agregarMenuModal" class="btn btn-success"><i class="bi bi-person-plus-fill"></i></button></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($menus as $menu): ?>
                                <tr>
                                    <th scope="row"><?php echo str_pad($menu['MenuId'], 5, '0', STR_PAD_LEFT); ?></th>
                                    <td><?php echo $menu['MenuNameEnglish']; ?></td>
                                    <td><?php echo $menu['SortNumber']; ?></td>
                                    <td class="gap-4">
                                        <a onclick="editarMenu(<?php echo $menu['MenuId']; ?>)" data-bs-toggle="tooltip" data-bs-title="Editar" class="text-primary"><i class="bi bi-pencil-fill"></i></a>
                                        <form id="deleteFormMenu<?php echo $menu['MenuId']; ?>" action="/dashboard/menus/eliminar" method="POST" style="display:inline-block;">
                                            <input type="hidden" name="id" value="<?php echo $menu['MenuId']; ?>" />
                                            <a onclick="eliminarMenu(<?php echo $menu['MenuId']; ?>)" type="button" data-bs-toggle="tooltip" data-bs-title="Eliminar" class="text-danger"><i class="bi bi-trash3-fill"></i></a>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Páginas (Intermedio) -->
            <div class="tab-pane fade" id="paginas">
                <div class="tab-header text-center">
                    <p>Paginas</p>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="text-center">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nombre pagina</th>
                                <th scope="col">Orden</th>
                                <th scope="col"><button id="agregarPaginaModal" class="btn btn-success"><i class="bi bi-person-plus-fill"></i></button></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pages as $page): ?>
                                <tr>
                                    <th scope="row"><?php echo str_pad($page['PageId'], 5, '0', STR_PAD_LEFT); ?></th>
                                    <td><?php echo $page['MenuNameEnglish']; ?></td>
                                    <td><?php echo $page['SortNumber']; ?></td>
                                    <td class="gap-4">
                                        <a onclick="editarPagina(<?php echo $page['PageId']; ?>)" data-bs-toggle="tooltip" data-bs-title="Editar" class="text-primary"><i class="bi bi-pencil-fill"></i></a>
                                        <form id="deleteFormPagina<?php echo $page['PageId']; ?>" action="/dashboard/pages/eliminar" method="POST" style="display:inline-block;">
                                            <input type="hidden" name="id" value="<?php echo $page['PageId']; ?>" />
                                            <a onclick="eliminarPagina(<?php echo $page['PageId']; ?>)" type="button" data-bs-toggle="tooltip" data-bs-title="Eliminar" class="text-danger"><i class="bi bi-trash3-fill"></i></a>
                                        </form>
                                        <?php if (empty($page['Title'])) { ?>
                                            <a onclick="agregarBlogs(<?php echo $page['PageId']; ?>)" data-id-page="" id="agregarBlogs" data-bs-toggle="tooltip" data-bs-title="Agregar Blog" class="text-primary">
                                                <i class="bi bi-file-plus"></i>
                                            </a>
                                        <?php }; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Contenidos (Avanzado) -->
            <div class="tab-pane fade" id="contenidos">
                <div class="tab-header text-center">
                    <p>Contenidos</p>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="text-center">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Titulo</th>
                                <th scope="col">Fecha</th>
                                <th scope="col">Usuario</th>
                                <th scope="col">
                                <th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($posts as $post): ?>
                                <tr>
                                    <th scope="row"><?php echo str_pad($post['PostId'], 5, '0', STR_PAD_LEFT); ?></th>
                                    <td><?php echo $post['Title']; ?></td>
                                    <td><?php echo $post['Datetime']; ?></td>
                                    <td><?php echo $post['User']; ?></td>
                                    <td class="gap-4">
                                        <a onclick="editarPost(<?php echo $post['PostId']; ?>)" data-bs-toggle="tooltip" data-bs-title="Editar" class="text-primary"><i class="bi bi-pencil-fill"></i></a>
                                        <form id="deleteFormPost<?php echo $post['PostId']; ?>" action="/dashboard/posts/eliminar" method="POST" style="display:inline-block;">
                                            <input type="hidden" name="id" value="<?php echo $post['PostId']; ?>" />
                                            <a onclick="eliminarPost(<?php echo $post['PostId']; ?>)" type="button" data-bs-toggle="tooltip" data-bs-title="Eliminar" class="text-danger"><i class="bi bi-trash3-fill"></i></a>
                                        </form>
                                        <a href="/dashboard/blog/<?php echo $post['urlShort']; ?>" data-bs-toggle="tooltip" data-bs-title="Ver" class="text-secondary"><i class="bi bi-eye-fill"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div> <!-- fin de tab-content -->
    </div>
</main>
<!-- menu dialog -->
<dialog id="agregarMenu">
    <form id="formMenus" method="post">
        <input type="text" id="id" name="id" hidden>
        <div class="row">
            <div class="mb-3">
                <label for="titulo" class="form-label">Titulo</label>
                <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Nombre">
            </div>
            <div class="mb-3">
                <label for="orden" class="form-label">Orden</label>
                <input class="form-control" id="orden" name="orden" type="number" min="0" placeholder="Orden"></input>
            </div>
        </div>
    </form>
    <div class="row">
        <form method="dialog">
            <button type="submit" form="formMenus" class="btn btn-primary">Guardar</button>
            <button type="submit" class="btn btn-danger">Cerrar</button>
        </form>
    </div>
</dialog>

<dialog id="agregarPages">
    <form id="formPages" method="post">
        <input type="text" id="id_page" name="id_page" hidden>
        <div class="row">
            <div class="mb-3 col">
                <label for="menu" class="form-label">Menu</label>
                <select class="form-select" name="menu" id="menu">
                    <?php foreach ($menus as $menu) { ?>
                        <option value="<?php echo $menu['MenuId'] ?>"><?php echo $menu['MenuNameEnglish'] ?></option>
                    <?php } ?>
                </select>

            </div>
            <div class="mb-3 col">
                <label for="ordenPage" class="form-label">Orden</label>
                <input class="form-control" id="ordenPage" name="ordenPage" type="number" min="0" placeholder="Orden"></input>
            </div>
        </div>
    </form>
    <div class="row">
        <form method="dialog">
            <button type="submit" form="formPages" class="btn btn-primary">Guardar</button>
            <button type="submit" class="btn btn-danger">Cerrar</button>
        </form>
    </div>
</dialog>
<dialog id="agregarBlog" class="dialogMid">
    <form id="formBlogs" method="post">
        <input type="text" id="id_page_blog" name="id_page_blog" hidden>
        <input type="text" id="id_blog" name="id_blog" hidden>
        <div class="row">
            <div class="mb-3">
                <label for="title_blog" class="form-label">Title</label>
                <input type="text" class="form-control" id="title_blog" name="title_blog" placeholder="Ingresa title">
            </div>
            <div class="mb-3">
                <label for="urlShort" class="form-label" hidden>Title</label>
                <input type="text" class="form-control" id="urlShort" name="urlShort" placeholder="Ingresa title" hidden>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <div id="editor" style="height: 200px;"></div>
                <textarea class="form-control" id="content" name="content" rows="4" hidden></textarea>
            </div>
        </div>
    </form>
    <div class="row">
        <form method="dialog">
            <button type="submit" form="formBlogs" class="btn btn-primary">Guardar</button>
            <button type="submit" class="btn btn-danger">Cerrar</button>
        </form>
    </div>
</dialog>

<!-- menu -->
<script>
    $('#agregarMenuModal').addEventListener('click', () => {
        $('#agregarMenu').showModal()
        $('#formMenus').setAttribute('action', '/dashboard/menus');
        $('#formMenus').reset()
    })

    function editarMenu(id) {
        $('#formMenus').setAttribute('action', '/dashboard/menus/actualizar');
        fetch('/dashboard/menus/' + id)
            .then(response => {

                if (!response.ok) {
                    throw new Error('Error al obtener el menu');
                }
                return response.json();
            })
            .then(menu => {
                $('#id').value = menu.MenuId;
                $('#titulo').value = menu.MenuNameEnglish;
                $('#orden').value = menu.SortNumber;
                $('#agregarMenu').showModal()
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    function eliminarMenu(id) {
        if (confirm("¿Estás seguro de que deseas eliminar el menu se eliminara todas las paginas enlazadas al menu?")) {
            fetch('/dashboard/menus/eliminar', {
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
                        throw new Error('Error al eliminar el menu');
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
<!-- page -->
<script>
    $('#agregarPaginaModal').addEventListener('click', () => {
        $('#agregarPages').showModal()
        $('#formPages').setAttribute('action', '/dashboard/pages');
        $('#formPages').reset()
    })

    function editarPagina(id) {
        $('#formPages').setAttribute('action', '/dashboard/pages/actualizar');
        fetch('/dashboard/pages/' + id)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error al obtener la pagina');
                }
                return response.json();
            })
            .then(page => {
                $('#id_page').value = page.PageId;
                $('#menu').value = page.MenuId;
                $('#ordenPage').value = page.SortNumber;
                $('#agregarPages').showModal()
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    function eliminarPagina(id) {
        if (confirm("¿Estás seguro de que deseas eliminar la pagina?")) {
            fetch('/dashboard/pages/eliminar', {
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
                        throw new Error('Error al eliminar la pagina');
                    }
                    return response.json();
                })
                .then(data => {
                    alert('Pagina eliminado exitosamente');
                    window.location.reload();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Hubo un error al elim idinar el certificado');
                });
        }
    }
</script>
<!-- agregar blog -->
<script>
    const quill = new Quill('#editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{
                    header: [1, 2, 3, 4, 5, 6, false]
                }],
                [{
                    'size': ['small', 'normal', 'large', 'huge']
                }],
                [{
                    'list': 'ordered'
                }, {
                    'list': 'bullet'
                }],
                [{
                    'align': []
                }],
                ['bold', 'italic', 'underline', 'strike'],
                [{
                    'color': []
                }, {
                    'background': []
                }],
                ['link', 'image', 'video'],
                ['blockquote', 'code-block'],
                [{
                    'script': 'sub'
                }, {
                    'script': 'super'
                }],
                ['formula'],
            ],
            history: {
                userOnly: true
            },
            clipboard: {
                matchVisual: false,
            },
        }
    });

    function agregarBlogs(id) {
        fetch('/dashboard/pages/' + id)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error al obtener la página');
                }
                return response.json();
            })
            .then(page => {
                $('#id_page_blog').value = page.PageId;
            })
            .catch(error => {
                console.error('Error:', error);
            });

        $('#agregarBlog').showModal();
        $('#formBlogs').reset();
        $('#formBlogs').setAttribute('action', '/dashboard/posts');
    }

    $('#formBlogs').addEventListener('submit', (event) => {
        const content = quill.root.innerHTML;
        const title = $('#title_blog').value
        $('#content').value = content;
        const camelCaseTitle = title
            .replace(/\s+(.)/g, (match, group1) => group1.toUpperCase()).replace(/\s+/g, '').replace(/^(.)/, (match, group1) => group1.toLowerCase());
        $('#urlShort').value = camelCaseTitle;
    });

    function editarPost(id) {
        console.log(id)
        $('#formBlogs').setAttribute('action', '/dashboard/posts/actualizar');
        fetch('/dashboard/posts/' + id)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error al obtener la pagina');
                }
                return response.json();
            })
            .then(post => {
                console.log(post)
                $('#id_blog').value = post.PostId;
                $('#id_page_blog').value = post.PageId;
                $('#title_blog').value = post.Title;
                quill.root.innerHTML = post.Content;
                $('#agregarBlog').showModal()
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
    function eliminarPost(id) {
        if (confirm("¿Estás seguro de que deseas eliminar el blog?")) {
            fetch('/dashboard/posts/eliminar', {
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
                        throw new Error('Error al eliminar el blog');
                    }
                    return response.json();
                })
                .then(data => {
                    alert('Blog eliminado exitosamente');
                    window.location.reload();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Hubo un error al elim idinar el certificado');
                });
        }
    }
</script>

<?php require 'template/foot.php' ?>