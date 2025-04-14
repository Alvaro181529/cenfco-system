<header id="header" class="header d-flex align-items-center">
    <div class="container d-flex align-items-center justify-content-between">

        <a href="/" class="logo me-auto me-lg-0">
            <img src="/assets/logo_cenefco.png" alt="" height="100px" srcset="">
        </a>
        <nav id="navbar" class="navbar">
            <ul>
                <li><a href="/dashboard">Inicio</a></li>
                <?php if ($_SESSION['user']['role'] == 'Administrador') { ?>
                    <li><a href="/dashboard/chatbot">Chatbot</a></li>
                    <li class="dropdown"><a href="#"><span>Registros</span> <i
                                class="bi bi-chevron-down dropdown-indicator"></i></a>
                        <ul>
                            <li><a href="/dashboard/usuarios">Usuarios</a></li>
                            <li><a href="/dashboard/docentes">Docentes</a></li>
                            <li><a href="/dashboard/estudiantes">Estudiantes</a></li>
                            <li><a href="/dashboard/cursos">Cursos</a></li>
                            <li><a href="/dashboard/eventos">Eventos</a></li>
                            <li><a href="/dashboard/certificados">Certificados</a></li>
                        </ul>
                    </li>
                <?php } ?>
                <?php if (in_array($_SESSION['user']['role'], ['Administrador', 'Vendedor'])) { ?>
                    <li class="dropdown"><a href="#"><span>Ventas</span> <i
                                class="bi bi-chevron-down dropdown-indicator"></i></a>
                        <ul>
                            <li><a href="/dashboard/ventas/cursos">Cursos</a></li>
                            <li><a href="/dashboard/ventas/certificados">Certificados</a></li>
                        </ul>
                    </li>
                <?php } ?>
                <?php if (in_array($_SESSION['user']['role'], ['Administrador', 'Vendedor'])) { ?>
                    <li class="dropdown"><a href="#"><span>Recursos</span> <i
                                class="bi bi-chevron-down dropdown-indicator"></i></a>
                        <ul>
                            <li><a href="/dashboard/inventario">Inventario</a></li>
                            <li><a href="/dashboard/comentarios">Comentarios</a></li>
                            <li><a href="/dashboard/preguntas">Preguntas Frecuentes</a></li>
                            <li><a href="/dashboard/blog">Blogs Educativos</a></li>
                        </ul>
                    </li>
                <?php } ?>
                <?php if ($_SESSION['user']['role'] == 'Administrador') { ?>
                    <li><a href="/dashboard/reportes">Reportes</a></li>
                <?php } ?>
            </ul>
        </nav>
        <a class="btn-book-a-table" href="/logout">Cerrar Sesión</a>

        <a type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
            <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
        </a>
        <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>

    </div>
</header>