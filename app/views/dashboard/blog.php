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
                                <th scope="col">Menu</th>
                                <th scope="col">Orden</th>
                                <th scope="col"><button id="agregarPaginaModal" class="btn btn-success"><i class="bi bi-person-plus-fill"></i></button></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pages as $page): ?>
                                <tr>
                                    <th scope="row"><?php echo str_pad($page['PageId'], 5, '0', STR_PAD_LEFT); ?></th>
                                    <td><?php echo $page['MenuId']; ?></td>
                                    <td><?php echo $page['SortNumber']; ?></td>
                                    <td class="gap-4">
                                        <a onclick="editarPagina(<?php echo $page['PageId']; ?>)" data-bs-toggle="tooltip" data-bs-title="Editar" class="text-primary"><i class="bi bi-pencil-fill"></i></a>
                                        <form id="deleteFormPagina<?php echo $page['PageId']; ?>" action="/dashboard/pages/eliminar" method="POST" style="display:inline-block;">
                                            <input type="hidden" name="id" value="<?php echo $page['PageId']; ?>" />
                                            <a onclick="eliminarPagina(<?php echo $page['PageId']; ?>)" type="button" data-bs-toggle="tooltip" data-bs-title="Eliminar" class="text-danger"><i class="bi bi-trash3-fill"></i></a>
                                        </form>
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
                                <th scope="col"><button id="agregarPostModal" class="btn btn-success"><i class="bi bi-person-plus-fill"></i></button></th>
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
                                        <a href="#" data-bs-toggle="tooltip" data-bs-title="Ver" class="text-secondary"><i class="bi bi-eye-fill"></i></a>
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

<?php require 'template/foot.php' ?>