<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CENEFCO</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <link href="/assets/Diseño_sin_título_13.png" rel="icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <meta name="robots" content="noindex, nofollow">

    <style>
        :root {
            --primary-color: #0a0a4a;
            --secondary-color: #f8f9fa;
            --accent-color: #ffc107;
            --text-light: #ffffff;
        }

        body {
            font-family: 'Poppins', sans-serif;
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

        .register-container {
            max-width: 600px;
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

        .password-requirements {
            font-size: 0.85rem;
            color: #6c757d;
        }

        .password-requirements ul {
            padding-left: 1.2rem;
            margin-bottom: 0;
        }
    </style>
</head>

<body>

    <!-- Register Form -->
    <div class="main-content">
        <div class="container">
            <div class="register-container">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <a href="javascript:history.back()" class="me-3"><i class="bi bi-arrow-left-circle-fill text-white fs-4"></i></a>
                            <h4 class="mb-0 mx-auto">Crear una cuenta</h4>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="/register">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="username" maxlength="50" name="username" placeholder="Nombre Completo" required>
                                        <label for="username">Nombre Completo</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" id="correo" maxlength="50" name="correo" placeholder="correo@ejemplo.com" required>
                                        <label for="correo">Correo Electrónico</label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="form-floating">
                                    <input type="password" class="form-control" id="password" title="La contraseña debe tener al menos 8 caracteres, incluyendo una letra, un número y un carácter especial." pattern="^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$" maxlength="50" name="password" placeholder="Contraseña" required>
                                    <label for="password">Contraseña</label>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="form-floating">
                                    <input type="password" class="form-control" id="passwordConfirmed" pattern="^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$" maxlength="50" name="passwordConfirmed" placeholder="Confirmar contraseña" required>
                                    <label for="passwordConfirmed">Confirmar contraseña</label>
                                </div>
                            </div>

                            <?php if (!empty($error)) : ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
                                </div>
                            <?php endif; ?>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-custom btn-lg">Registrar cuenta</button>
                            </div>

                            <div class="text-center mt-4">
                                <p class="mb-0">¿Ya tienes una cuenta? <a href="/login" class="text-decoration-none">Iniciar sesión</a></p>
                            </div>
                        </form>


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