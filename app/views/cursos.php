<?php require 'template/head.php' ?>
<?php require 'template/navbar.php' ?>

<body>
    <style>
        :root {
            --primary-color: #0a0a4a;
            --secondary-color: #f8f9fa;
            --accent-color: #ffc107;
            --text-light: #ffffff;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--secondary-color);
        }

        .bg-custom-dark {
            background-color: var(--primary-color);
            color: var(--text-light);
        }

        .btn-custom {
            background-color: var(--accent-color);
            border: none;
            color: var(--primary-color);
            font-weight: bold;
            padding: 0.75rem 2rem;
            border-radius: 30px;
            transition: all 0.3s;
        }

        .btn-custom:hover {
            background-color: #e0a800;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .form-control {
            padding: 0.75rem 1.25rem;
            border-radius: 30px;
        }

        .search-container {
            max-width: 800px;
            margin: 0 auto;
        }

        .search-input {
            border-radius: 30px 0 0 30px;
            border: 2px solid var(--accent-color);
            border-right: none;
        }

        .search-button {
            border-radius: 0 30px 30px 0;
            background-color: var(--accent-color);
            color: var(--primary-color);
            font-weight: bold;
            border: 2px solid var(--accent-color);
        }

        .category-filter {
            margin-top: 2rem;
            margin-bottom: 2rem;
        }

        .category-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.85rem;
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
            color: white;
        }

        .badge-derecho {
            background-color: #ffc107;
            color: #000;
        }

        .badge-ciencias-humanas {
            background-color: #6c757d;
        }

        .badge-arquitectura {
            background-color: #fd7e14;
        }

        .badge-tecnologia {
            background-color: #20c997;
        }

        .badge-ciencias-empresariales {
            background-color: #0d6efd;
        }

        .badge-medicina {
            background-color: #dc3545;
        }

        .badge-idiomas {
            background-color: #6f42c1;
        }

        .course-card {
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.3s;
            height: 100%;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .course-image {
            height: 180px;
            object-fit: cover;
        }

        .course-category {
            position: absolute;
            top: 15px;
            right: 15px;
            padding: 0.4rem 1rem;
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.75rem;
        }

        .course-price {
            font-weight: bold;
            font-size: 1.25rem;
            color: var(--primary-color);
        }

        .course-original-price {
            text-decoration: line-through;
            color: #6c757d;
            font-size: 0.9rem;
        }

        .instructor-info {
            display: flex;
            align-items: center;
            margin-top: 1rem;
        }

        .instructor-image {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 0.75rem;
        }

        .instructor-name {
            font-size: 0.9rem;
            margin-bottom: 0;
            font-weight: 500;
        }

        .instructor-title {
            font-size: 0.8rem;
            color: #6c757d;
            margin-bottom: 0;
        }

        .filter-checkbox {
            margin-right: 0.5rem;
        }

        .filter-label {
            display: inline-flex;
            align-items: center;
            margin-right: 1.5rem;
            font-weight: 500;
            cursor: pointer;
        }

        .pagination .page-item .page-link {
            color: var(--primary-color);
            border-radius: 50%;
            margin: 0 0.25rem;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .pagination .page-item.active .page-link {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .course-rating {
            color: #ffc107;
        }

        .course-students {
            font-size: 0.85rem;
            color: #6c757d;
        }

        .course-level {
            font-size: 0.85rem;
            color: #6c757d;
        }

        .course-duration {
            font-size: 0.85rem;
            color: #6c757d;
        }

        .filter-section {
            background-color: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 2rem;
        }

        .filter-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--primary-color);
        }

        .price-range {
            margin-top: 1rem;
        }

        .range-slider {
            width: 100%;
        }

        .filter-divider {
            margin: 1.5rem 0;
            border-color: #e9ecef;
        }

        .filter-reset {
            color: #dc3545;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .filter-reset:hover {
            text-decoration: underline;
        }

        .sort-select {
            border-radius: 20px;
            padding: 0.5rem 1rem;
            border: 1px solid #ced4da;
            font-size: 0.9rem;
        }

        .header-banner {
            background: linear-gradient(135deg, #0a0a4a 0%, #1a1a8a 100%);
            padding: 3rem 0;
            margin-bottom: 2rem;
        }

        .breadcrumb-item a {
            color: var(--accent-color);
            text-decoration: none;
        }

        .breadcrumb-item.active {
            color: rgba(255, 255, 255, 0.7);
        }

        .breadcrumb-item+.breadcrumb-item::before {
            color: rgba(255, 255, 255, 0.5);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: #0d0d6b;
            border-color: #0d0d6b;
        }

        .filter-mobile-sticky-header {
            position: sticky;
            top: 0;
            z-index: 1020;
        }

        .active-filters .badge {
            font-weight: normal;
            cursor: pointer;
        }

        .active-filters .badge i {
            cursor: pointer;
        }

        .active-filters .badge:hover {
            background-color: #e2e3e5 !important;
        }

        @media (max-width: 991.98px) {
            .offcanvas {
                width: 300px;
            }
        }
    </style>

    <!-- Header Banner -->
    <section style="padding-top: calc(40vh - 90px); height: 80vh;" class="header-banner text-white text-center">
        <div class="container">
            <h1 class="display-5 fw-bold mb-5">Explora Nuestros Cursos</h1>

            <!-- Search Bar -->
            <div class="search-container mt-5">
                <div class="input-group">
                    <input type="text" class="form-control search-input" placeholder="Buscar cursos..." aria-label="Buscar cursos">
                    <button class="btn btn-warning search-button" type="button">
                        <i class="fas fa-search me-2"></i> Buscar
                    </button>
                </div>
            </div>
            <div class="mt-5">
                <a href="#cursos" class="btn btn-warning">Explorar Cursos</a>
                <button class="btn btn-light" id="contactenos">Contáctenos</button>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <div class="container py-5" id="cursos">
        <div class="row">
            <!-- Mobile Filter Button - Only visible on small screens -->
            <div class="col-12 d-lg-none mb-4">
                <button class="btn btn-primary w-100" type="button" data-bs-toggle="offcanvas" data-bs-target="#filterOffcanvas">
                    <i class="fas fa-filter me-2"></i> Mostrar Filtros
                </button>
            </div>

            <!-- Sidebar Filters - Only visible on large screens -->
            <div class="col-lg-3 mb-4 d-none d-lg-block">
                <div class="filter-section">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="filter-title mb-0">Filtros</h5>
                        <a href="#" class="filter-reset">Restablecer</a>
                    </div>

                    <div class="mb-3">
                        <h6 class="mb-2">Categorías</h6>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="category1">
                            <label class="form-check-label" for="category1">
                                Ciencias Humanas
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="category2">
                            <label class="form-check-label" for="category2">
                                Arquitectura
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="category3">
                            <label class="form-check-label" for="category3">
                                Derecho
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="category4">
                            <label class="form-check-label" for="category4">
                                Tecnología
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="category5">
                            <label class="form-check-label" for="category5">
                                Ciencias Empresariales
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="category6">
                            <label class="form-check-label" for="category6">
                                Medicina
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="category7">
                            <label class="form-check-label" for="category7">
                                Idiomas
                            </label>
                        </div>
                    </div>


                    <hr class="filter-divider">

                    <div class="mb-3">
                        <h6 class="mb-2">Precio</h6>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="price1">
                            <label class="form-check-label" for="price1">
                                Gratis
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="price2">
                            <label class="form-check-label" for="price2">
                                De pago
                            </label>
                        </div>
                        <div class="price-range">
                            <label for="priceRange" class="form-label d-flex justify-content-between">
                                <span>Rango de precio:</span>
                                <span>$0 - $200</span>
                            </label>
                            <input type="range" class="form-range range-slider" min="0" max="200" step="10" id="priceRange">
                        </div>
                    </div>


                    <div class="d-grid mt-4">
                        <button class="btn btn-custom">Aplicar Filtros</button>
                    </div>
                </div>
            </div>

            <!-- Course Listings -->
            <div class="col-lg-9">
                <!-- Sort and Filter Bar -->
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
                    <p class="mb-3 mb-md-0"><strong>Mostrando 12</strong> de 42 cursos</p>
                </div>

                <!-- Active Filters Display -->
                <div class="active-filters mb-4">
                    <div class="d-flex flex-wrap gap-2">
                        <span class="badge rounded-pill bg-light text-dark p-2">
                            Tecnología <i class="fas fa-times-circle ms-1"></i>
                        </span>
                        <span class="badge rounded-pill bg-light text-dark p-2">
                            Principiante <i class="fas fa-times-circle ms-1"></i>
                        </span>
                        <span class="badge rounded-pill bg-light text-dark p-2">
                            Menos de $50 <i class="fas fa-times-circle ms-1"></i>
                        </span>
                    </div>
                </div>

                <!-- Course Grid -->
                <div class="row g-4">
                    <!-- Course 1 -->
                    <?php foreach ($cursos as $curso): ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="card course-card">
                                <div class="position-relative">
                                    <img src="/storage/uploads/cursos/<?php echo $curso['imagen'] ?>" class="card-img-top course-image" alt="Diseño Web Profesional">
                                    <span class="badge course-category badge-tecnologia"><?php echo $curso['categoria'] ?></span>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $curso['titulo'] ?></h5>
                                    <p class="card-text"><?php echo $curso['descripcion'] ?></p>
                                    <div class="instructor-info">
                                        <img src="/placeholder.svg?height=40&width=40" alt="Instructor" class="instructor-image">
                                        <div>
                                            <p class="instructor-name"><?php echo $curso['docente'] ?></p>
                                            <!-- <p class="instructor-title">Desarrollador Web Senior</p> -->
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="course-price">$<?php echo $curso['precio'] ?></span>
                                            <!-- <span class="course-original-price ms-2">$99.99</span> -->
                                        </div>
                                        <!-- <span class="badge bg-danger">50% dto.</span> -->
                                    </div>
                                </div>
                                <!-- <div class="card-footer bg-white border-0 pb-3">
                                    <div class="d-grid">
                                        <a href="#" class="btn btn-custom">Inscribirse</a>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    <?php endforeach ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card course-card">
                            <div class="position-relative">
                                <img src="/assets/img/menu/menu-item-5.jpg" class="card-img-top course-image" alt="Diseño Web Profesional">
                                <span class="badge course-category badge-tecnologia">Tecnología</span>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">Diseño Web Profesional</h5>
                                <p class="card-text">Aprende a crear sitios web modernos y responsivos con HTML, CSS y JavaScript.</p>
                                <div class="instructor-info">
                                    <img src="/placeholder.svg?height=40&width=40" alt="Instructor" class="instructor-image">
                                    <div>
                                        <p class="instructor-name">Carlos Rodríguez</p>
                                        <p class="instructor-title">Desarrollador Web Senior</p>
                                    </div>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="course-price">$49.99</span>
                                        <span class="course-original-price ms-2">$99.99</span>
                                    </div>
                                    <span class="badge bg-danger">50% dto.</span>
                                </div>
                            </div>
                            <!-- <div class="card-footer bg-white border-0 pb-3">
                                <div class="d-grid">
                                    <a href="#" class="btn btn-custom">Inscribirse</a>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                <nav aria-label="Course pagination" class="mt-5">
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">4</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-custom-dark text-white py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 mb-4">
                    <h5 class="mb-4">Sobre Nosotros</h5>
                    <p>Somos una plataforma educativa comprometida con ofrecer cursos de alta calidad que te ayudarán a desarrollar nuevas habilidades y avanzar en tu carrera profesional. Nuestro objetivo es hacer la educación accesible para todos.</p>
                </div>
                <div class="col-lg-2 mb-4">
                    <h5 class="mb-4">Enlaces Rápidos</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="index.html" class="text-white text-decoration-none">Inicio</a></li>
                        <li class="mb-2"><a href="courses.html" class="text-white text-decoration-none">Cursos</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Certificaciones</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Blog</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Contacto</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 mb-4">
                    <h5 class="mb-4">Categorías</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Ciencias Humanas</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Arquitectura</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Derecho</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Tecnología</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Ciencias Empresariales</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 mb-4">
                    <h5 class="mb-4">Contáctanos</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> Av. Principal #123, Ciudad</li>
                        <li class="mb-2"><i class="fas fa-phone me-2"></i> +123 456 7890</li>
                        <li class="mb-2"><i class="fas fa-envelope me-2"></i> info@eduplataforma.com</li>
                    </ul>
                    <div class="mt-4">
                        <a href="#" class="text-white me-3 fs-5"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-white me-3 fs-5"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-white me-3 fs-5"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-white me-3 fs-5"><i class="fab fa-linkedin"></i></a>
                        <a href="#" class="text-white me-3 fs-5"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
            <hr class="my-4 bg-light">
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0">&copy; 2025 EduPlataforma. Todos los derechos reservados.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <a href="#" class="text-white text-decoration-none me-3">Términos y Condiciones</a>
                    <a href="#" class="text-white text-decoration-none">Política de Privacidad</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Mobile Filters Offcanvas -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="filterOffcanvas" aria-labelledby="filterOffcanvasLabel">
        <div class="offcanvas-header bg-custom-dark text-white">
            <h5 class="offcanvas-title" id="filterOffcanvasLabel">Filtros</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-0">
            <div class="filter-mobile-sticky-header p-3 bg-light border-bottom">
                <div class="d-flex justify-content-between align-items-center">
                    <a href="#" class="filter-reset text-decoration-none">
                        <i class="fas fa-undo-alt me-1"></i> Restablecer
                    </a>
                    <button class="btn btn-custom btn-sm" data-bs-dismiss="offcanvas">
                        Ver resultados
                    </button>
                </div>
            </div>

            <div class="p-3">
                <div class="mb-4">
                    <h6 class="mb-3 fw-bold">Categorías</h6>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="mCategory1">
                        <label class="form-check-label" for="mCategory1">
                            Ciencias Humanas
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="mCategory2">
                        <label class="form-check-label" for="mCategory2">
                            Arquitectura
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="mCategory3">
                        <label class="form-check-label" for="mCategory3">
                            Derecho
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="mCategory4">
                        <label class="form-check-label" for="mCategory4">
                            Tecnología
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="mCategory5">
                        <label class="form-check-label" for="mCategory5">
                            Ciencias Empresariales
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="mCategory6">
                        <label class="form-check-label" for="mCategory6">
                            Medicina
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="mCategory7">
                        <label class="form-check-label" for="mCategory7">
                            Idiomas
                        </label>
                    </div>
                </div>

                <hr>

                <div class="mb-4">
                    <h6 class="mb-3 fw-bold">Precio</h6>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="mPrice1">
                        <label class="form-check-label" for="mPrice1">
                            Gratis
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="mPrice2">
                        <label class="form-check-label" for="mPrice2">
                            De pago
                        </label>
                    </div>
                    <div class="price-range mt-3">
                        <label for="mPriceRange" class="form-label d-flex justify-content-between">
                            <span>Rango de precio:</span>
                            <span>$0 - $200</span>
                        </label>
                        <input type="range" class="form-range range-slider" min="0" max="200" step="10" id="mPriceRange">
                    </div>
                </div>

                <div class="d-grid mt-4 mb-4">
                    <button class="btn btn-custom" data-bs-dismiss="offcanvas">Aplicar Filtros</button>
                </div>
            </div>
        </div>
    </div>
    <dialog id="dialog-form" class="form-section" id="contact" data-aos="fade-up" data-aos-delay="200">
        <form method="dialog">
            <div class="d-flex justify-content-between align-items-center position-relative" style="z-index: 999;">
                <h5 class="card-title" id="vistaNombre">Contactenos</h5>
                <button type="submit" class="btn-close" id="closeVentaCertificados" aria-label="Close"></button>
            </div>
        </form>

        <div class="row justify-content-center">
            <div class="col-lg-12">
                <form action="/home/comentarios" method="POST" role="form" class="php-email-form p-3 p-md-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="name" class="form-label">Nombre completo*</label>
                            <input type="text" class="form-control" id="name" name="nombre" placeholder="Tu nombre" required>
                        </div>
                        <div class="col-12">
                            <label for="email" class="form-label">Correo electrónico*</label>
                            <input type="email" class="form-control" id="email" name="correo" placeholder="Tu correo" required>
                        </div>
                        <div class="col-12">
                            <label for="subject" class="form-label">Asunto*</label>
                            <input type="text" class="form-control" id="subject" name="asunto" placeholder="Asunto del mensaje" required>
                        </div>
                        <div class="col-12">
                            <label for="mensaje" class="form-label">Mensaje*</label>
                            <textarea class="form-control" id="mensaje" name="mensaje" rows="5" placeholder="Escribe tu mensaje aquí" required></textarea>
                        </div>
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-custom btn-lg mt-3 text-white">Enviar solicitud</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </dialog>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<script>
    const $ = ($) => document.querySelector($)
    $('#contactenos').addEventListener('click', () => {
        $('#dialog-form').showModal()
    })
</script>
<?php require 'component/chat.php' ?>
<?php require 'template/foot.php' ?>