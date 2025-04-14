<?php require 'template/head.php' ?>
<?php require 'template/navbar.php' ?>

<section id="hero" class="hero d-flex align-items-center section-bg">
    <div class="container">
        <div class="row justify-content-between gy-5">
            <div
                class="col-lg-5 order-2 order-lg-1 d-flex flex-column justify-content-center align-items-center align-items-lg-start text-center text-lg-start">
                <h2 data-aos="fade-up">Mejora tus Habilidades con Nuestros<br>Cursos Impartidos por Expertos</h2>
                <p data-aos="fade-up" data-aos-delay="100">Domina nuevas habilidades con nuestra amplia gama de cursos. Ya sea
                    que busques avanzar en tu carrera o explorar nuevas pasiones, tenemos algo para todos.</p>
                <div class="d-flex" data-aos="fade-up" data-aos-delay="200">
                    <a href="#cursos" class="btn-book-a-table">Ver Cursos</a>
                    <a href="https://www.youtube.com/watch?v=LXb3EKWsInQ"
                        class="glightbox btn-watch-video d-flex align-items-center"><i class="bi bi-play-circle"></i><span>Ver
                            Video Introductorio</span></a>
                </div>
            </div>

            <div class="col-lg-5 order-1 order-lg-2 text-center text-lg-start">
                <img src="assets/cenefco_grande.png" class="img-fluid" alt="" data-aos="zoom-out" data-aos-delay="300">
            </div>
        </div>
    </div>
</section>

<main id="main">


    <section id="about" class="about">
        <div class="container" data-aos="fade-up">

            <div class="section-header">
                <h2>Sobre Nosotros</h2>
                <p>Conoce Más <span>Sobre Nosotros</span></p>
            </div>

            <div class="row gy-4">
                <div class="col-lg-7 position-relative about-img" style="background-image: url(assets/img/about2.jpg) ;"
                    data-aos="fade-up" data-aos-delay="150">
                    <div class="call-us position-absolute">
                        <h4>Book a Table</h4>
                        <p>+1 5589 55488 55</p>
                    </div>
                </div>
                <div class="col-lg-5 d-flex align-items-end" data-aos="fade-up" data-aos-delay="300">
                    <div class="content ps-0 ps-lg-5">
                        <p class="fst-italic">
                            Nuestros cursos están diseñados para ofrecerte una experiencia de aprendizaje única, donde podrás desarrollar nuevas habilidades y avanzar en tu carrera profesional.
                        </p>
                        <ul>
                            <li><i class="bi bi-check2-all"></i> Aprende de instructores expertos en la materia.</li>
                            <li><i class="bi bi-check2-all"></i> Acceso a recursos educativos de alta calidad.</li>
                            <li><i class="bi bi-check2-all"></i> Cursos flexibles que se adaptan a tu ritmo y horario.</li>
                        </ul>
                        <p>
                            Nuestros programas están diseñados para ofrecerte una formación completa, con contenido actualizado y relevante para el desarrollo profesional. ¡Únete a nuestra comunidad y da el siguiente paso hacia tu éxito!
                        </p>

                        <div class="position-relative mt-4">
                            <img src="assets/img/about-3.jpg" class="img-fluid" alt="Cursos y Aprendizaje">
                            <a href="https://www.youtube.com/watch?v=LXb3EKWsInQ" class="glightbox play-btn"></a>
                        </div>
                    </div>
                </div>

            </div>
    </section>


    <section id="why-us" class="why-us section-bg">
        <div class="container" data-aos="fade-up">

            <div class="row gy-4">

                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="why-box">
                        <h3>¿Por Qué Elegir Nuestros Cursos?</h3>
                        <p>
                            Nuestros cursos están diseñados para ofrecer una formación de alta calidad, impartida por expertos en cada área. Nos enfocamos en brindarte una educación práctica, flexible y accesible, para que puedas avanzar en tu carrera o aprender nuevas habilidades a tu propio ritmo.
                        </p>
                        <div class="text-center">
                            <a href="#courses" class="more-btn">Ver Más <i class="bx bx-chevron-right"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8 d-flex align-items-center">
                    <div class="row gy-4">

                        <div class="col-xl-4" data-aos="fade-up" data-aos-delay="200">
                            <div class="icon-box d-flex flex-column justify-content-center align-items-center">
                                <i class="bi bi-clipboard-data"></i>
                                <h4>Aprendizaje de Calidad</h4>
                                <p>Impartido por instructores expertos con años de experiencia en el campo.</p>
                            </div>
                        </div>

                        <div class="col-xl-4" data-aos="fade-up" data-aos-delay="300">
                            <div class="icon-box d-flex flex-column justify-content-center align-items-center">
                                <i class="bi bi-gem"></i>
                                <h4>Cursos Flexibles</h4>
                                <p>Accede a los cursos en cualquier momento y desde cualquier lugar, adaptados a tu horario.</p>
                            </div>
                        </div>

                        <div class="col-xl-4" data-aos="fade-up" data-aos-delay="400">
                            <div class="icon-box d-flex flex-column justify-content-center align-items-center">
                                <i class="bi bi-inboxes"></i>
                                <h4>Recursos Exclusivos</h4>
                                <p>Accede a materiales de estudio exclusivos, foros de discusión y soporte continuo durante todo el curso.</p>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </section>


    <section id="stats-counter" class="stats-counter">
        <div class="container" data-aos="zoom-out">

            <div class="row gy-4">

                <div class="col-lg-3 col-md-6">
                    <div class="stats-item text-center w-100 h-100">
                        <span data-purecounter-start="0" data-purecounter-end="<?php echo $cantidadEstudiantes ?>" data-purecounter-duration="1" class="purecounter"></span>
                        <p>Estudiantes Inscritos</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="stats-item text-center w-100 h-100">
                        <span data-purecounter-start="0" data-purecounter-end="<?php echo $cantidadCursos ?>" data-purecounter-duration="1" class="purecounter"></span>
                        <p>Cursos Ofrecidos</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="stats-item text-center w-100 h-100">
                        <span data-purecounter-start="0" data-purecounter-end="22000" data-purecounter-duration="1" class="purecounter"></span>
                        <p>Horas de Formación</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="stats-item text-center w-100 h-100">
                        <span data-purecounter-start="0" data-purecounter-end="<?php echo $cantidadDocentes ?>" data-purecounter-duration="1" class="purecounter"></span>
                        <p>Instructores Certificados</p>
                    </div>
                </div>

            </div>

        </div>
    </section>


    <section id="menu" class="menu">
        <div class="container" data-aos="fade-up">

            <div class="section-header">
                <h2>Nuestros Cursos</h2>
                <p>Explora nuestros <span>Impactantes Cursos</span></p>
            </div>

            <!-- Navegación de las categorías -->
            <ul class="nav nav-tabs d-flex justify-content-center" data-aos="fade-up" data-aos-delay="200">
                <?php foreach ($cursosPorCategoria as $categoria => $cursos) : ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($categoria == 'Principiante') ? 'active show' : ''; ?>"
                            data-bs-toggle="tab" data-bs-target="#course-<?php echo strtolower(str_replace(' ', '-', $categoria)); ?>">
                            <h4><?php echo ucfirst($categoria); ?></h4>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>

            <!-- Contenido de los cursos -->
            <div class="tab-content" data-aos="fade-up" data-aos-delay="300">
                <?php foreach ($cursosPorCategoria as $categoria => $cursos) : ?>
                    <div class="tab-pane fade <?php echo ($categoria == 'Principiante') ? 'active show' : ''; ?>"
                        id="course-<?php echo strtolower(str_replace(' ', '-', $categoria)); ?>">
                        <div class="tab-header text-center">
                            <p>Cursos</p>
                            <h3><?php echo ucfirst($categoria); ?></h3>
                        </div>

                        <div class="row gy-5">
                            <?php foreach ($cursos as $curso) : ?>
                                <div class="col-lg-4 course-item">
                                    <a href="/storage/uploads/cursos/<?php echo $curso['imagen']; ?>" class="glightbox">
                                        <img src="/storage/uploads/cursos/<?php echo $curso['imagen']; ?>" class="course-img img-fluid" alt="">
                                    </a>
                                    <h4><?php echo $curso['titulo']; ?></h4>
                                    <p class="details">
                                        <?php echo $curso['descripcion']; ?>
                                    </p>
                                    <p class="price">
                                        $<?php echo number_format($curso['precio'], 2); ?>
                                    </p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>
    </section>

    <section id="testimonios" class="testimonials section-bg">
        <div class="container" data-aos="fade-up">

            <div class="section-header">
                <h2>Testimonios</h2>
                <p>¿Qué <span>Opinan de Nuestros Cursos?</span></p>
            </div>

            <div class="slides-1 swiper" data-aos="fade-up" data-aos-delay="100">
                <div class="swiper-wrapper">

                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <div class="row gy-4 justify-content-center">
                                <div class="col-lg-6">
                                    <div class="testimonial-content">
                                        <p>
                                            <i class="bi bi-quote quote-icon-left"></i>
                                            El curso de desarrollo web cambió completamente mi manera de trabajar. Los contenidos son claros y muy prácticos. Recomiendo totalmente.
                                            <i class="bi bi-quote quote-icon-right"></i>
                                        </p>
                                        <h3>Juan Pérez</h3>
                                        <h4>Desarrollador Web</h4>
                                        <div class="stars">
                                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                                class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 text-center">
                                    <img src="assets/img/testimonials/testimonials-1.jpg" class="img-fluid testimonial-img" alt="">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <div class="row gy-4 justify-content-center">
                                <div class="col-lg-6">
                                    <div class="testimonial-content">
                                        <p>
                                            <i class="bi bi-quote quote-icon-left"></i>
                                            Gracias al curso de marketing digital, pude aplicar estrategias efectivas que aumentaron las ventas de mi negocio online. ¡Muy recomendado!
                                            <i class="bi bi-quote quote-icon-right"></i>
                                        </p>
                                        <h3>Ana González</h3>
                                        <h4>Propietaria de Tienda Online</h4>
                                        <div class="stars">
                                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                                class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 text-center">
                                    <img src="assets/img/testimonials/testimonials-2.jpg" class="img-fluid testimonial-img" alt="">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <div class="row gy-4 justify-content-center">
                                <div class="col-lg-6">
                                    <div class="testimonial-content">
                                        <p>
                                            <i class="bi bi-quote quote-icon-left"></i>
                                            Los cursos de diseño gráfico me ayudaron a mejorar mis habilidades y ahora puedo ofrecer servicios profesionales. ¡Una experiencia increíble!
                                            <i class="bi bi-quote quote-icon-right"></i>
                                        </p>
                                        <h3>Carlos Martínez</h3>
                                        <h4>Diseñador Gráfico Freelance</h4>
                                        <div class="stars">
                                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                                class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 text-center">
                                    <img src="assets/img/testimonials/testimonials-3.jpg" class="img-fluid testimonial-img" alt="">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <div class="row gy-4 justify-content-center">
                                <div class="col-lg-6">
                                    <div class="testimonial-content">
                                        <p>
                                            <i class="bi bi-quote quote-icon-left"></i>
                                            Estoy muy agradecido por el curso de liderazgo. Los conocimientos adquiridos me ayudaron a crecer en mi carrera profesional y personal.
                                            <i class="bi bi-quote quote-icon-right"></i>
                                        </p>
                                        <h3>Pedro López</h3>
                                        <h4>Gerente de Proyecto</h4>
                                        <div class="stars">
                                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                                class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 text-center">
                                    <img src="assets/img/testimonials/testimonials-4.jpg" class="img-fluid testimonial-img" alt="">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="swiper-pagination"></div>
            </div>

        </div>
    </section>


    <section id="events" class="events">
        <div class="container-fluid" data-aos="fade-up">

            <div class="section-header">
                <h2>Eventos</h2>
                <p>Comparte <span>Tu Momento</span> Con Nosotros</p>
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


    <section id="chefs" class="chefs section-bg">
        <div class="container" data-aos="fade-up">

            <div class="section-header">
                <h2>Docentes</h2>
                <p>Nuestros <span>Instructores</span> Profesionales</p>
            </div>

            <div class="row gy-4">

                <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
                    <div class="chef-member">
                        <div class="member-img">
                            <img src="assets/img/chefs/chefs-1.jpg" class="img-fluid" alt="">
                            <div class="social">
                                <a href=""><i class="bi bi-twitter"></i></a>
                                <a href=""><i class="bi bi-facebook"></i></a>
                                <a href=""><i class="bi bi-instagram"></i></a>
                                <a href=""><i class="bi bi-linkedin"></i></a>
                            </div>
                        </div>
                        <div class="member-info">
                            <h4>Walter White</h4>
                            <span>Director Principal</span>
                            <p>Un experto en gastronomía con años de experiencia, especializado en técnicas avanzadas de cocina. Enseña con pasión y dedicación.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="200">
                    <div class="chef-member">
                        <div class="member-img">
                            <img src="assets/img/chefs/chefs-2.jpg" class="img-fluid" alt="">
                            <div class="social">
                                <a href=""><i class="bi bi-twitter"></i></a>
                                <a href=""><i class="bi bi-facebook"></i></a>
                                <a href=""><i class="bi bi-instagram"></i></a>
                                <a href=""><i class="bi bi-linkedin"></i></a>
                            </div>
                        </div>
                        <div class="member-info">
                            <h4>Sarah Jhonson</h4>
                            <span>Desarroladora</span>
                            <p>Especialista con un enfoque en el arte de la tecnologia. Sus clases son creativas y llenas de técnicas innovadoras.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="300">
                    <div class="chef-member">
                        <div class="member-img">
                            <img src="assets/img/chefs/chefs-3.jpg" class="img-fluid" alt="">
                            <div class="social">
                                <a href=""><i class="bi bi-twitter"></i></a>
                                <a href=""><i class="bi bi-facebook"></i></a>
                                <a href=""><i class="bi bi-instagram"></i></a>
                                <a href=""><i class="bi bi-linkedin"></i></a>
                            </div>
                        </div>
                        <div class="member-info">
                            <h4>William Anderson</h4>
                            <span>Base de datos</span>
                            <p>Con una pasión , ofrece clases prácticas que combinan teoría y mucha práctica.</p>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>

<!-- 
    <section id="book-a-table" class="book-a-table">
        <div class="container" data-aos="fade-up">

            <div class="section-header">
                <h2>Reserva con un puesto</h2>
                <p>Reserva <span>un cupo</span> con nosotros</p>
            </div>

            <div class="row g-0">

                <div class="col-lg-4 reservation-img" style="background-image: url(assets/img/reservation.jpg);"
                    data-aos="zoom-out" data-aos-delay="200"></div>

                <div class="col-lg-8 d-flex align-items-center reservation-form-bg">
                    <form action="forms/book-a-table.php" method="post" role="form" class="php-email-form" data-aos="fade-up"
                        data-aos-delay="100">
                        <div class="row gy-4">
                            <div class="col-lg-4 col-md-6">
                                <input type="text" name="name" class="form-control" id="name" placeholder="Your Name"
                                    data-rule="minlen:4" data-msg="Please enter at least 4 chars">
                                <div class="validate"></div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <input type="email" class="form-control" name="email" id="email" placeholder="Your Email"
                                    data-rule="email" data-msg="Please enter a valid email">
                                <div class="validate"></div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <input type="text" class="form-control" name="phone" id="phone" placeholder="Your Phone"
                                    data-rule="minlen:4" data-msg="Please enter at least 4 chars">
                                <div class="validate"></div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <input type="text" name="date" class="form-control" id="date" placeholder="Date" data-rule="minlen:4"
                                    data-msg="Please enter at least 4 chars">
                                <div class="validate"></div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <input type="text" class="form-control" name="time" id="time" placeholder="Time" data-rule="minlen:4"
                                    data-msg="Please enter at least 4 chars">
                                <div class="validate"></div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <input type="number" class="form-control" name="people" id="people" placeholder="# of people"
                                    data-rule="minlen:1" data-msg="Please enter at least 1 chars">
                                <div class="validate"></div>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <textarea class="form-control" name="message" rows="5" placeholder="Message"></textarea>
                            <div class="validate"></div>
                        </div>
                        <div class="mb-3">
                            <div class="loading">Loading</div>
                            <div class="error-message"></div>
                            <div class="sent-message">Your booking request was sent. We will call back or send an Email to confirm
                                your reservation. Thank you!</div>
                        </div>
                        <div class="text-center"><button type="submit">Reserva</button></div>
                    </form>
                </div>

            </div>

        </div>
    </section> -->


    <section id="gallery" class="gallery section-bg">
        <div class="container" data-aos="fade-up">

            <div class="section-header">
                <h2>Estancias</h2>
                <p>Aulas <span>de nuestra institucion</span></p>
            </div>

            <div class="gallery-slider swiper">
                <div class="swiper-wrapper align-items-center">
                    <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery"
                            href="assets/img/gallery/gallery-1.jpg"><img src="assets/img/gallery/gallery-1.jpg" class="img-fluid"
                                alt=""></a></div>
                    <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery"
                            href="assets/img/gallery/gallery-2.jpg"><img src="assets/img/gallery/gallery-2.jpg" class="img-fluid"
                                alt=""></a></div>
                    <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery"
                            href="assets/img/gallery/gallery-3.jpg"><img src="assets/img/gallery/gallery-3.jpg" class="img-fluid"
                                alt=""></a></div>
                    <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery"
                            href="assets/img/gallery/gallery-4.jpg"><img src="assets/img/gallery/gallery-4.jpg" class="img-fluid"
                                alt=""></a></div>
                    <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery"
                            href="assets/img/gallery/gallery-5.jpg"><img src="assets/img/gallery/gallery-5.jpg" class="img-fluid"
                                alt=""></a></div>
                    <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery"
                            href="assets/img/gallery/gallery-6.jpg"><img src="assets/img/gallery/gallery-6.jpg" class="img-fluid"
                                alt=""></a></div>
                    <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery"
                            href="assets/img/gallery/gallery-7.jpg"><img src="assets/img/gallery/gallery-7.jpg" class="img-fluid"
                                alt=""></a></div>
                    <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery"
                            href="assets/img/gallery/gallery-8.jpg"><img src="assets/img/gallery/gallery-8.jpg" class="img-fluid"
                                alt=""></a></div>
                </div>
                <div class="swiper-pagination"></div>
            </div>

        </div>
    </section>


    <section id="contact" class="contact">
        <div class="container" data-aos="fade-up">

            <div class="section-header">
                <h2>Contactanos</h2>
                <p>¿Necesitas ayuda? <span>Contactanos</span></p>
            </div>

            <div class="mb-3">
                <iframe style="border:0; width: 100%; height: 350px;"
                    src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12097.433213460943!2d-74.0062269!3d40.7101282!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xb89d1fe6bc499443!2sDowntown+Conference+Center!5e0!3m2!1smk!2sbg!4v1539943755621"
                    frameborder="0" allowfullscreen></iframe>
            </div>

            <div class="row gy-4">

                <div class="col-md-6">
                    <div class="info-item  d-flex align-items-center">
                        <i class="icon bi bi-map flex-shrink-0"></i>
                        <div>
                            <h3>Direccion</h3>
                            <p>A108 Adam Street, New York, NY 535022</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="info-item d-flex align-items-center">
                        <i class="icon bi bi-envelope flex-shrink-0"></i>
                        <div>
                            <h3>Email </h3>
                            <p>contact@example.com</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="info-item  d-flex align-items-center">
                        <i class="icon bi bi-telephone flex-shrink-0"></i>
                        <div>
                            <h3>Telefono</h3>
                            <p>+1 5589 55488 55</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="info-item  d-flex align-items-center">
                        <i class="icon bi bi-share flex-shrink-0"></i>
                        <div>
                            <h3>Horario de atencion</h3>
                            <div><strong>Lunes-Viernes:</strong> 11AM - 23PM;
                                <strong>Sabado:</strong> Cerrado
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <form action="/home/comentarios" method="POST" role="form" class="php-email-form p-3 p-md-4">
                <div class="row">
                    <div class="col-xl-6 form-group">
                        <input type="text" name="nombre" class="form-control" id="name" placeholder="Your Name" required>
                    </div>
                    <div class="col-xl-6 form-group">
                        <input type="email" class="form-control" name="correo" id="email" placeholder="Your Email" required>
                    </div>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="asunto" id="subject" placeholder="Subject" required>
                </div>
                <div class="form-group">
                    <textarea class="form-control" name="mensaje" rows="5" placeholder="Message" required></textarea>
                </div>
                <div class="my-3">
                    <div class="loading">Loading...</div>
                    <div class="sent-message">Mensaje enviado correctamente. Gracias!</div>
                    <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
                </div>
                <div class="text-center"><button type="submit">Enviar mensaje</button></div>
            </form>


        </div>
    </section>

</main>
<script>

</script>

<?php require 'component/chat.php' ?>
<?php require 'template/foot.php' ?>