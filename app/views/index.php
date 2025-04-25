<?php require 'template/head.php' ?>
<?php require 'template/navbar.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link type="text/css" rel="stylesheet" href="style.css" />
</head>

<style>
    body {
        font-family: 'Poppins', sans-serif;
    }

    .bg-custom-dark {
        background-color: var(--primary-color);
        color: var(--text-light);
    }

    .hero-section {
        padding: 5rem 0;
        /* background: linear-gradient(135deg, #0a0a4a 0%, #1a1a8a 100%); */
        background: linear-gradient(135deg, #c4971d 0%, #1a1a8a 100%);
    }

    .category-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 1rem;
        transition: transform 0.3s;
    }

    .category-card:hover .category-icon {
        transform: scale(1.1);
    }

    .category-card {
        border-radius: 15px;
        overflow: hidden;
        transition: all 0.3s;
        height: 100%;
    }

    .category-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }

    .search-container {
        max-width: 800px;
        margin: 2rem auto;
    }

    .benefits-section {
        background-color: var(--secondary-color);
    }

    .benefit-icon {
        font-size: 3rem;
        color: var(--primary-color);
        margin-bottom: 1rem;
    }

    .certificate-img {
        max-width: 100%;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        border-radius: 10px;
        transition: transform 0.3s;
    }

    .certificate-img:hover {
        transform: scale(1.03);
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

    .form-section {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 4rem 0;
    }

    .form-control {
        padding: 0.75rem 1.25rem;
        border-radius: 10px;
    }

    .category-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background-color: var(--accent-color);
        color: var(--primary-color);
        font-weight: bold;
        padding: 0.5rem 1rem;
        border-radius: 20px;
    }
</style>

<body>
    <!-- Hero Section -->
    <section style="padding-top: calc(40vh - 90px);" id="hero"  class="hero-section bg-custom-dark text-center">
        <div class="container" data-aos="zoom-out" data-aos-delay="300">
            <div class="row justify-content-between">
                <div class="col-lg-5  order-2 order-lg-1 d-flex flex-column justify-content-center align-items-center align-items-lg-start text-center text-lg-start">
                    <h1 data-aos="fade-up" class="display-4 fw-bold mb-4">¡Aprovecha nuestras ofertas y descuentos hoy!</h1>
                    <h2 data-aos="fade-up" class="h2 mb-5">Inscríbete a nuestros cursos en diferentes áreas</h2>
                    <a href="#cursos" class="btn btn-custom btn-lg text-white">Ver Cursos Disponibles</a>
                </div>
                <div class="col-lg-5  order-1 order-lg-2 text-center text-lg-start">
                    <img src="assets/cenefco_grande.png" class="img-fluid" alt="" data-aos="zoom-out" data-aos-delay="300">
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="py-5" id="cursos">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4 col-lg-2 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="card category-card text-center h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="category-icon text-center">
                                <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M100 20L180 70V150L100 200L20 150V70L100 20Z" fill="#d946ef" />
                                    <path d="M100 80L140 100V140L100 160L60 140V100L100 80Z" fill="none" stroke="white" stroke-width="4" />
                                </svg>
                            </div>
                            <h5 class="card-title">Ciencias Humanas</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-lg-2 mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="card category-card text-center h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="category-icon text-center">
                                <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M100 20L180 70V150L100 200L20 150V70L100 20Z" fill="#d4be98" />
                                    <path d="M100 80L140 100V140L100 160L60 140V100L100 80Z" fill="none" stroke="white" stroke-width="4" />
                                </svg>
                            </div>
                            <h5 class="card-title">Arquitectura</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-lg-2 mb-4">
                    <div class="card category-card text-center h-100 border-0 shadow-sm" data-aos="fade-up" data-aos-delay="300">
                        <div class="card-body">
                            <div class="category-icon text-center">
                                <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M100 20L180 70V150L100 200L20 150V70L100 20Z" fill="#f97316" />
                                    <path d="M100 80L140 100V140L100 160L60 140V100L100 80Z" fill="none" stroke="white" stroke-width="4" />
                                </svg>
                            </div>
                            <h5 class="card-title">Derecho</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-lg-2 mb-4" data-aos="fade-up" data-aos-delay="400">
                    <div class="card category-card text-center h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="category-icon text-center">
                                <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M100 20L180 70V150L100 200L20 150V70L100 20Z" fill="#10b981" />
                                    <path d="M100 80L140 100V140L100 160L60 140V100L100 80Z" fill="none" stroke="white" stroke-width="4" />
                                </svg>
                            </div>
                            <h5 class="card-title">Tecnología</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-lg-2 mb-4" data-aos="fade-up" data-aos-delay="500">
                    <div class="card category-card text-center h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="category-icon text-center">
                                <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M100 20L180 70V150L100 200L20 150V70L100 20Z" fill="#0ea5e9" />
                                    <path d="M100 80L140 100V140L100 160L60 140V100L100 80Z" fill="none" stroke="white" stroke-width="4" />
                                </svg>
                            </div>
                            <h5 class="card-title">Ciencias Empresariales</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-lg-2 mb-4" data-aos="fade-up" data-aos-delay="600">
                    <div class="card category-card text-center h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="category-icon text-center">
                                <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M100 20L180 70V150L100 200L20 150V70L100 20Z" fill="#8b5cf6" />
                                    <path d="M100 80L140 100V140L100 160L60 140V100L100 80Z" fill="none" stroke="white" stroke-width="4" />
                                </svg>
                            </div>
                            <h5 class="card-title">Idiomas</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Search Section -->
    <!-- <section class="py-4 bg-light" data-aos="fade-right" data-aos-delay="300">
        <div class="container">
            <div class="search-container">
                <div class="input-group">
                    <input type="text" class="form-control form-control-lg text-white" placeholder="Buscar cursos" aria-label="Buscar cursos">
                    <button class="btn btn-custom text-white" type="button">
                        <i class="fas fa-search me-2"></i> Buscar
                    </button>
                </div>
            </div>
        </div>
    </section> -->

    <section id="about" class="why-us section-bg">
        <div class="container" data-aos="fade-up">

            <div class="row gy-4">

                <div class="col-lg-1" ></div>
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="why-box">
                        <h3>NUESTRA HISTORIA</h3>
                        <p>
                            El Centro Nacional de Educación y Formación Continua (CENEFCO) fue fundado en agosto de 2020 por el Lic. Paolo Condori Lecoña, como respuesta a la pandemia del COVID-19. Es una empresa dedicada a la educación digital, enfocada en ofrecer cursos y capacitaciones virtuales especializadas. Surgió para satisfacer la creciente necesidad de formación a distancia y se ha consolidado como una entidad comprometida con los valores, el desarrollo educativo y el servicio a la sociedad.
                        </p>
                    </div>
                </div>
                
                <div class="col-lg-6 d-flex align-items-center">
                    <div class="row gy-4">
                        
                        <div class="col-xl-6" data-aos="fade-up" data-aos-delay="200">
                            <div class="icon-box d-flex flex-column justify-content-center align-items-center">
                                <i class="bi bi-clipboard-data"></i>
                                <h4>Misíon</h4>
                                <p>Somos una empresa encargada de ofrecer y generar cursos de capacitación continua, mediante el uso de tecnología, todo esto para potenciar las habilidades de los estudiantes.</p>
                            </div>
                        </div>
                        
                        <div class="col-xl-6" data-aos="fade-up" data-aos-delay="300">
                            <div class="icon-box d-flex flex-column justify-content-center align-items-center">
                                <i class="bi bi-eye"></i>
                                <h4>Visión</h4>
                                <p>Ser una empresa con pleno reconocimiento en el ámbito educativo, ampliando nuestro servicio nacional e internacional mediante la innovación de programas y capacitación continua.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-1" ></div>

            </div>

        </div>
    </section>

    <!-- Certificate Section -->
    <section class="py-5 bg-custom-dark">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="position-relative">
                        <img src="assets/img/cenefco/certificado-ALpnG2nbqnUGrbNa.avif" alt="Certificado de curso" class="certificate-img img-fluid" data-aos="zoom-out" data-aos-delay="300">
                        <span class="badge bg-danger position-absolute top-0 end-0 mt-3 me-3" data-aos="zoom-out" data-aos-delay="400">Certificado Oficial</span>
                    </div>
                </div>
                <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-up" data-aos-delay="200">
                    <h2 class="display-6 fw-bold mb-4">Avalen tu conocimiento</h2>
                    <p class="lead mb-4">Obtén certificaciones reconocidas que potenciarán tu carrera profesional y validarán tus habilidades en el mercado laboral.</p>
                    <a href="#" class="btn btn-custom btn-lg text-white">Ver Certificaciones</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="benefits-section py-5" id="benefits">
        <div class="container">
            <h2 class="text-center mb-5" data-aos="fade-left" data-aos-delay="300">Beneficios de nuestros cursos</h2>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="card h-100 border-0 shadow-sm text-center p-4">
                        <div class="card-body">
                            <div class="benefit-icon mb-3">
                                <i class="fas fa-chalkboard-teacher"></i>
                            </div>
                            <h4 class="card-title h5">Docentes altamente calificados</h4>
                            <p class="card-text">Aprende con los mejores profesionales del sector con amplia experiencia.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="card h-100 border-0 shadow-sm text-center p-4">
                        <div class="card-body">
                            <div class="benefit-icon mb-3">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <h4 class="card-title h5">Confiable y seguro para tu educación</h4>
                            <p class="card-text">Plataforma segura con contenido verificado y de alta calidad.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 mb-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="card h-100 border-0 shadow-sm text-center p-4">
                        <div class="card-body">
                            <div class="benefit-icon mb-3">
                                <i class="fas fa-certificate"></i>
                            </div>
                            <h4 class="card-title h5">Obtendrás un certificado que avale tu conocimiento</h4>
                            <p class="card-text">Certificaciones reconocidas que potenciarán tu carrera profesional.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 mb-4" data-aos="fade-up" data-aos-delay="400">
                    <div class="card h-100 border-0 shadow-sm text-center p-4">
                        <div class="card-body">
                            <div class="benefit-icon mb-3">
                                <i class="fas fa-laptop-house"></i>
                            </div>
                            <h4 class="card-title h5">Aprende a tu ritmo con los cursos online</h4>
                            <p class="card-text">Accede al contenido cuando quieras y desde donde quieras.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="events" class="events">
        <div class="container-fluid" data-aos="fade-up">

            <div class="text-center mb-5">
                <h2>Eventos</h2>
            </div>

            <div class="slides-3 swiper" data-aos="fade-up" data-aos-delay="100">
                <div class="swiper-wrapper">
                    <?php foreach ($eventos as $evento) : ?>
                        <div class="swiper-slide event-item d-flex flex-column justify-content-end"
                            style="background-image: url(/storage/uploads/eventos/ <?php echo $evento['imagen'] ?>)">
                            <h3><?php echo $evento['titulo'] ?></h3>
                            <div class="price align-self-start">$<?php echo isset($evento['precio']) ? $evento['precio'] : 'N/A'; ?></div>
                            <p class="description">
                                <?php echo $evento['descripcion'] ?>
                            </p>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="swiper-pagination"></div>
            </div>

        </div>
    </section>
    <!-- Featured Courses -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-5" data-aos="fade-right" data-aos-delay="300">Cursos destacados</h2>
            <div class="row g-4">
                <div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="position-relative">
                            <img src="assets/img/menu/menu-item-5.jpg" class="card-img-top" alt="Curso de Diseño Web">
                            <span class="category-badge text-white">Tecnología</span>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Diseño Web Profesional</h5>
                            <p class="card-text">Aprende a crear sitios web modernos y responsivos con HTML, CSS y JavaScript.</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-primary fw-bold">$49.99</span>
                                <span class="text-decoration-line-through text-muted">$99.99</span>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-0">
                            <div class="d-grid">
                                <a href="#" class="btn btn-custom text-white">Inscribirse</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="position-relative">
                            <img src="assets/img/menu/menu-item-5.jpg" class="card-img-top" alt="Curso de Marketing Digital">
                            <span class="category-badge text-white">Ciencias Empresariales</span>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Marketing Digital Avanzado</h5>
                            <p class="card-text">Estrategias efectivas para posicionar tu marca en el mundo digital.</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-primary fw-bold">$59.99</span>
                                <span class="text-decoration-line-through text-muted">$119.99</span>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-0">
                            <div class="d-grid">
                                <a href="#" class="btn btn-custom text-white">Inscribirse</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="position-relative">
                            <img src="assets/img/menu/menu-item-5.jpg" class="card-img-top" alt="Curso de Arquitectura Sostenible">
                            <span class="category-badge text-white">Arquitectura</span>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Arquitectura Sostenible</h5>
                            <p class="card-text">Diseño de edificaciones eco-amigables y eficientes energéticamente.</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-primary fw-bold">$69.99</span>
                                <span class="text-decoration-line-through text-muted">$139.99</span>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-0">
                            <div class="d-grid">
                                <a href="#" class="btn btn-custom text-white">Inscribirse</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4" data-aos="fade-up" data-aos-delay="100">
                <a href="#" class="btn btn-outline-primary btn-lg">Ver todos los cursos</a>
            </div>
        </div>
    </section>

    <!-- Registration Form -->
    <section class="contact form-section" id="contact" data-aos="fade-up" data-aos-delay="200">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card border-0 shadow">
                        <div class="card-body p-5">
                            <h3 class="card-title text-center mb-4" data-aos="fade-right" data-aos-delay="100">Regístrate para recibir más información</h3>

                            <form action="/home/comentarios" method="POST" role="form" class="php-email-form p-3 p-md-4">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Nombre completo*</label>
                                        <input type="text" class="form-control" id="name" name="nombre" placeholder="Tu nombre" required>
                                    </div>
                                    <div class="col-md-6">
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

                                    <!-- Estado del envío -->
                                    <div class="col-12 my-3">
                                        <div class="loading">Cargando...</div>
                                        <div class="sent-message">Mensaje enviado correctamente. ¡Gracias!</div>
                                        <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
                                    </div>

                                    <div class="col-12 text-center">
                                        <button type="submit" class="btn btn-custom btn-lg mt-3 text-white">Enviar solicitud</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5" data-aos="fade-left" data-aos-delay="100">Lo que dicen nuestros estudiantes</h2>
            <div class="row g-4" data-aos="flip-right" data-aos-delay="100">
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="d-flex mb-3">
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                            </div>
                            <p class="card-text">"Los cursos son excelentes, con contenido actualizado y profesores que realmente dominan los temas. La plataforma es muy intuitiva y fácil de usar."</p>
                            <div class="d-flex align-items-center mt-3">
                                <div class="flex-shrink-0">
                                    <img src="/placeholder.svg?height=50&width=50" class="rounded-circle" alt="Estudiante" width="50" height="50">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0">María González</h6>
                                    <small class="text-muted">Estudiante de Arquitectura</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="d-flex mb-3">
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                            </div>
                            <p class="card-text">"La flexibilidad de los cursos online me permitió estudiar mientras trabajaba. El certificado me ayudó a conseguir un mejor empleo. ¡Totalmente recomendado!"</p>
                            <div class="d-flex align-items-center mt-3">
                                <div class="flex-shrink-0">
                                    <img src="/placeholder.svg?height=50&width=50" class="rounded-circle" alt="Estudiante" width="50" height="50">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0">Carlos Rodríguez</h6>
                                    <small class="text-muted">Estudiante de Tecnología</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="d-flex mb-3">
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star-half-alt text-warning"></i>
                            </div>
                            <p class="card-text">"La calidad del contenido es excepcional. Los profesores explican de manera clara y concisa. El soporte técnico siempre está disponible para resolver dudas."</p>
                            <div class="d-flex align-items-center mt-3">
                                <div class="flex-shrink-0">
                                    <img src="/placeholder.svg?height=50&width=50" class="rounded-circle" alt="Estudiante" width="50" height="50">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0">Ana Martínez</h6>
                                    <small class="text-muted">Estudiante de Derecho</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php require 'component/chat.php' ?>
<?php require 'template/foot.php' ?>