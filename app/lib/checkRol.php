<?php
class CheckLib
{
    public function checkRol($requiredRole)
    {
        // Verificar si el usuario está logueado y tiene el rol adecuado
        if (isset($_SESSION['user'])) {
            $userRole = $_SESSION['user']['role']; // Obtener el rol desde la sesión
            if ($userRole === $requiredRole) {
                return true; // El usuario tiene el rol adecuado
            }
        }
        return false; // El usuario no tiene el rol adecuado o no está logueado
    }
}
