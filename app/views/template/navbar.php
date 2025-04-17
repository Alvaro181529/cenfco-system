<header id="header" class="header fixed-top d-flex align-items-center">
    <div class="container d-flex align-items-center justify-content-between">

        <a href="index.html" class="logo me-auto me-lg-0">
            <img src="assets/logo_cenefco.png" alt="" height="100px" srcset="">
        </a>

        <nav id="navbar" class="navbar">
            <ul>
                <li><a href="#hero">Inicio</a></li>
                <li><a href="#about">Acerca de</a></li>
                <li><a href="#menu">Cursos</a></li>
                <li><a href="#events">Eventos</a></li>
                <li><a href="#chefs">Instructores</a></li>
                <li><a href="#gallery">Galería</a></li>
                <li><a href="#contact">Contacto</a></li>
                <li class="dropdown"><a href="#"><span>Blog</span> <i
                            class="bi bi-chevron-down dropdown-indicator"></i></a>
                    <ul>
                        <?php

                        if (isset($groupedMenus) && !empty($groupedMenus)) {
                            foreach ($groupedMenus as $menuName => $titles) { ?>
                                <li class="dropdown"><a href="#"><span><?php echo ($menuName) ?></span> <i
                                            class="bi bi-chevron-down dropdown-indicator"></i></a>
                                    <ul>
                                        <?php foreach ($titles as $title) { ?>
                                            <li>
                                                <a style="word-wrap: break-word;" href="/blog/<?php echo htmlspecialchars($title['urlShort']); ?>">
                                                    <?php echo htmlspecialchars($title['Title']); ?>
                                                </a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </li>

                            <?php    }
                        } else { ?>
                            <li> <a href="">No hay menús disponibles</a></li>
                        <?php   } ?>

                    </ul>
                </li>
            </ul>
        </nav>
        <?php if (empty($success)) { ?>
            <a class="btn-book-a-table" href="/login">Iniciar Sesion</a>
        <?php } else { ?>
            <a class="btn-book-a-table" href="/dashboard">Dashboard</a>
        <?php } ?>

        <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
        <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>

    </div>
</header>