<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CENEFCO</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <link href="/assets/Diseño_sin_título_13.png" rel="icon">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
    <!-- Vendor CSS Files -->
    <link href="/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="/assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #0a0a4a;
            --secondary-color: #f8f9fa;
            --accent-color: #ffc107;
            --text-light: #ffffff;
        }

        body {
            font-family: "Poppins", sans-serif;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
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
            border-radius: 10px;
        }

        .login-container {
            max-width: 450px;
            margin: auto;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: var(--primary-color);
            color: white;
            border-radius: 15px 15px 0 0 !important;
            padding: 1.5rem;
        }

        .social-login-btn {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 0.75rem;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.3s;
            margin-bottom: 1rem;
            text-decoration: none;
        }

        .social-login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .google-btn {
            background-color: #ffffff;
            color: #333;
            border: 1px solid #ddd;
        }

        .facebook-btn {
            background-color: #3b5998;
            color: white;
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 1.5rem 0;
        }

        .divider-line {
            flex-grow: 1;
            height: 1px;
            background-color: #ddd;
        }

        .divider-text {
            padding: 0 1rem;
            color: #6c757d;
        }

        .form-floating>label {
            padding-left: 1.25rem;
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .main-content {
            flex: 1;
            display: flex;
            align-items: center;
            padding: 2rem 0;
        }

        footer {
            margin-top: auto;
        }
    </style>
</head>

<body>
    <!-- Login Form -->
    <div class="main-content">
        <div class="container">
            <div class="login-container">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <a href="/" class="me-3"><i class="bi bi-arrow-left-circle-fill text-white fs-4"></i></a>
                            <h4 class="mb-0 mx-auto">Iniciar Sesión</h4>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <!-- Formulario funcional con PHP -->
                        <form method="post" action="/login">
                            <div class="mb-3">
                                <div class="form-floating">
                                    <input
                                        type="email"
                                        class="form-control"
                                        id="correo"
                                        name="correo"
                                        maxlength="50"
                                        placeholder="nombre@ejemplo.com"
                                        required />
                                    <label for="correo">Correo electrónico</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-floating">
                                    <input
                                        type="password"
                                        class="form-control"
                                        id="password"
                                        name="password"
                                        maxlength="50"
                                        placeholder="Contraseña"
                                        required />
                                    <label for="password">Contraseña</label>
                                </div>
                            </div>

                            <!-- Mensajes de error (desde PHP) -->
                            <?php if (!empty($error)) : ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
                                </div>
                            <?php endif; ?>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-custom btn-lg">Iniciar Sesión</button>
                            </div>
                        </form>

                        <div class="text-center mt-3">
                            <p class="mb-0">
                                ¿No tienes una cuenta?
                                <a href="/register" class="text-decoration-none">Regístrate</a>
                            </p>
                            <a href="/forwart-password" class="small text-muted d-block mt-2">¿Olvidaste tu contraseña?</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-custom-dark text-white py-4">
        <div class="container text-center">
            &copy; 2025 CENEFCO. Todos los derechos reservados.
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>