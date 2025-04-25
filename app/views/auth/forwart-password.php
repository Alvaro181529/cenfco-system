<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña - EduPlataforma</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
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

        .forgot-password-container {
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

        .form-floating>label {
            padding-left: 1.25rem;
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

        .icon-large {
            font-size: 4rem;
            color: var(--accent-color);
            margin-bottom: 1rem;
        }

        .success-message {
            display: none;
        }
    </style>
</head>

<body>


    <!-- Forgot Password Form -->
    <div class="main-content">
        <div class="container">
            <div class="forgot-password-container">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <a href="javascript:history.back()" class="me-3"><i class="bi bi-arrow-left-circle-fill text-white fs-4"></i></a>
                            <h4 class="mb-0 mx-auto">Recuperar Contraseña</h4>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <!-- Form Section -->
                        <div id="requestForm">
                            <p class="text-muted mb-4">Ingresa tu correo electrónico y te enviaremos instrucciones para restablecer tu contraseña.</p>

                            <form id="forgotPasswordForm">
                                <div class="mb-4">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" id="email" placeholder="nombre@ejemplo.com" required>
                                        <label for="email">Correo electrónico</label>
                                    </div>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-custom btn-lg" onclick="showSuccessMessage(event)">Enviar instrucciones</button>
                                </div>
                            </form>
                        </div>

                        <!-- Success Message Section -->
                        <div id="successMessage" class="success-message text-center">
                            <div class="icon-large">
                                <i class="fas fa-envelope-open-text"></i>
                            </div>
                            <h5 class="mb-3">¡Correo enviado!</h5>
                            <p class="text-muted mb-4">Hemos enviado las instrucciones para restablecer tu contraseña a tu correo electrónico. Por favor, revisa tu bandeja de entrada y sigue los pasos indicados.</p>
                            <p class="mb-4">¿No recibiste el correo? <a href="#" class="text-decoration-none" onclick="resetForm(event)">Intentar nuevamente</a></p>
                        </div>

                        <!-- Login Link -->
                        <div class="text-center mt-4">
                            <p class="mb-0">¿Recordaste tu contraseña? <a href="/login" class="text-decoration-none">Iniciar sesión</a></p>
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

    <!-- Custom JS -->
    <script>
        function showSuccessMessage(event) {
            event.preventDefault();
            setInterval(() => {
                document.getElementById('requestForm').style.display = 'none';
                document.getElementById('successMessage').style.display = 'block';
            }, 2000)
        }

        function resetForm(event) {
            event.preventDefault();
            document.getElementById('forgotPasswordForm').reset();
            document.getElementById('requestForm').style.display = 'block';
            document.getElementById('successMessage').style.display = 'none';
        }
    </script>
</body>

</html>