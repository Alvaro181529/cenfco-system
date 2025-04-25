<?php
require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../models/AuthModel.php';

class AuthController
{
    public function login()
    {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $correo = $_POST['correo'] ?? '';
            $password = $_POST['password'] ?? '';

            $authModel = new AuthModel();
            $user = $authModel->loginUser($correo, $password);

            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['correo'] = $user['correo'];
                $_SESSION['role'] = $user['rol'];

                header('Location: /dashboard');
                exit;
            } else {
                $error = 'Credenciales incorrectas.';
            }
        }

        require __DIR__ . '/../views/auth/login.php';
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $correo = $_POST['correo'] ?? '';
            $password = $_POST['password'] ?? '';
            $passwordConfirmed = $_POST['passwordConfirmed'] ?? '';
            $role = $_POST['role'] ?? 'user';

            $pattern = '/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';

            // Validaciones
            $errors = [];

            if (!preg_match($pattern, $password)) {
                $errors[] = "La contraseña debe tener al menos 8 caracteres, incluir una letra, un número y un carácter especial.";
            }

            if ($password !== $passwordConfirmed) {
                $errors[] = "Las contraseñas no coinciden.";
            }
            
            if ($password !== $passwordConfirmed) {
                $error = "Las contraseñas no coinciden.";
            } elseif (empty($username) || empty($password) || empty($passwordConfirmed)) {
                $error = "Por favor, ingrese ambos campos.";
            } else {

                $authModel = new AuthModel();
                $register = $authModel->registerUser($username, $password, $correo, $role);
                if ($register) {
                    $success = "Usuario registrado con éxito!";
                    header('Location: /login ');
                } else {
                    $error = "Error al registrar el usuario.";
                }
            }
        }
        require __DIR__ . '/../views/auth/register.php';
    }
    public function forwartPassword()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['email'] ?? '';
        }
        require __DIR__ . '/../views/auth/forwart-password.php';
    }
    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        header("Location: /");
        exit;
    }
}
