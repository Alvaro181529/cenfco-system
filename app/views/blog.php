<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>CENEFCO</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Favicons -->
    <link href="/assets/cenefco_grande.png" rel="icon">
    <link href="/assets/cenefco_grande.png" rel="apple-touch-icon">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Amatic+SC:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Inter:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="/assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <link href="/assets/css/main.css" rel="stylesheet">

    <script defer src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <style>
        @media (min-width: 768px) {
            .custom-width {
                width: 800px;
            }
        }
    </style>

</head>

<body>
    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">Offcanvas</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div>
                Some text as placeholder. In real life you can have the elements you have chosen. Like, text, images, lists, etc.
            </div>
            <div class="dropdown mt-3">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    Dropdown button
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                </ul>
            </div>
        </div>
    </div>
    <header id="header" class="header fixed-top d-flex align-items-center">
        <div class="container d-flex align-items-center justify-content-between">

            <a href="/" class="logo me-auto me-lg-0">
                <img src="/assets/logo_cenefco.png" alt="" height="100px" srcset="">
            </a>

            <nav id="navbar" class="navbar">
                <ul>
                    <li><a href="/#hero">Inicio</a></li>
                    <li><a href="/#about">Acerca de</a></li>
                    <li><a href="/#benefits">Beneficios</a></li>
                    <li><a href="/#events">Eventos</a></li>
                    <li><a href="/#cursos">Cursos</a></li>
                    <li><a href="/#contact">Contacto</a></li>
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
    <section class="container mx-auto custom-width">
        <div class="my-4">
            <h1 class="display-4 fw-bold mb-2"><?php echo $post['Title'] ?></h1>
            <?php
            $language = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
            if ($language == 'es') {
                setlocale(LC_TIME, 'es_ES.UTF-8');
            } else {
                setlocale(LC_TIME, 'en_US.UTF-8');
            }

            $datetime = new DateTime($post['Datetime']);

            $formattedDate = strftime('%A, %d de %B de %Y, %H:%M', $datetime->getTimestamp());
            ?>
            <h5 class="h6 mt-2 fw-semibold text-muted">
                Publicado el <?php echo $formattedDate; ?>
            </h5>
        </div>
        <hr class="my-4 border-top border-secondary">
        <div>
            <?php echo $post['Content'] ?>
        </div>
    </section>
    <?php require 'component/whats.php' ?>
    <?php require 'component/chat.php' ?>
    <?php require 'template/foot.php' ?>