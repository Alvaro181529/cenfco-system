<?php
require 'vendor/autoload.php';
require_once 'app/controllers/HomeController.php';
require_once 'app/controllers/DashboardController.php';
require_once 'app/controllers/AuthController.php';
require_once 'app/controllers/dashboard/DocentesController.php';
require_once 'app/controllers/dashboard/EstudiantesController.php';
require_once 'app/controllers/dashboard/CursosController.php';
require_once 'app/controllers/dashboard/EventosController.php';
require_once 'app/controllers/dashboard/CertificadosController.php';
require_once 'app/controllers/dashboard/InventariosController.php';
require_once 'app/controllers/dashboard/UsuariosController.php';
require_once 'app/controllers/dashboard/VentasController.php';
require_once 'app/controllers/dashboard/ReportesController.php';
require_once 'app/controllers/dashboard/ComentarioController.php';
require_once 'app/lib/chatbot.php';

$router = new AltoRouter();

//
$homeController = new HomeController();
$DashboardController = new DashboardController();
$AuthController = new AuthController();
$chat = new Chatbot();

//Dashboard controller
$UsuariosController = new UsuariosController();
$DocentesController = new DocentesController();
$EstudiantesController = new EstudiantesController();
$CursosController = new CursosController();
$EventosController = new EventosController();
$CertificadosController = new CertificadosController();
$InventariosController = new InventariosController();
$VentasController = new VentasController();
$ReportesController = new ReportesController();
$ComentariosController = new ComentariosController();

//Auth
$router->map('GET', '/login', [$AuthController, 'login']);
$router->map('POST', '/login', [$AuthController, 'login']);
$router->map('GET', '/register', [$AuthController, 'register']);
$router->map('POST', '/register', [$AuthController, 'register']);
$router->map('GET', '/logout', [$AuthController, 'logout']);


//Home
$router->map('GET', '/', [$homeController, 'index']);
$router->map('GET', '/about', [$homeController, 'about']);
$router->map('GET', '/user/[i:id]', [$homeController, 'user']);
$router->map('POST', '/chatbot', [$chat, 'chat']);

//Dashboard rutas
$router->map('GET', '/dashboard', [$DashboardController, 'dashboard']);
$router->map('GET', '/dashboard/preguntas', [$DashboardController, 'preguntas']);
$router->map('GET', '/dashboard/blog', [$DashboardController, 'blog']);
$router->map('GET', '/dashboard/chatbot', [$DashboardController, 'chatbot']);

//Reportes
$router->map('GET', '/dashboard/reportes', [$ReportesController, 'Reportes']);
$router->map('GET', '/dashboard/reportes/certificados-excel', [$ReportesController, 'descargarExcelCertificados']);
$router->map('GET', '/dashboard/reportes/certificados-pdf', [$ReportesController, 'descargarPdfCertificados']);
$router->map('GET', '/dashboard/reportes/ventas-excel', [$ReportesController, 'descargarExcelVenta']);
$router->map('GET', '/dashboard/reportes/ventas-pdf', [$ReportesController, 'descargarPdfVenta']);
$router->map('GET', '/dashboard/reportes/inventario-excel', [$ReportesController, 'descargarExcelInventario']);
$router->map('GET', '/dashboard/reportes/inventario-pdf', [$ReportesController, 'descargarPdfInventario']);
$router->map('GET', '/dashboard/reportes/docentes-excel', [$ReportesController, 'descargarExcelDocentes']);
$router->map('GET', '/dashboard/reportes/docentes-pdf', [$ReportesController, 'descargarPdfDocentes']);
$router->map('GET', '/dashboard/reportes/estudiantes-excel', [$ReportesController, 'descargarExcelEstudiantes']);
$router->map('GET', '/dashboard/reportes/estudiantes-pdf', [$ReportesController, 'descargarPdfEstudiantes']);
$router->map('GET', '/dashboard/reportes/cursos-excel', [$ReportesController, 'descargarExcelCursos']);
$router->map('GET', '/dashboard/reportes/cursos-pdf', [$ReportesController, 'descargarPdfCursos']);

//Usuarios
$router->map('GET', '/dashboard/usuarios', [$UsuariosController, 'usuarios']);
$router->map('GET', '/dashboard/usuarios/[i:id]', [$UsuariosController, 'ObtenerUsuarios']);
$router->map('POST', '/dashboard/usuarios', [$UsuariosController, 'Guardado']);
$router->map('POST', '/dashboard/usuarios/actualizar', [$UsuariosController, 'Actualizar']);
$router->map('DELETE', '/dashboard/usuarios/eliminar', [$UsuariosController, 'Eliminar']);

//Ventas
$router->map('GET', '/dashboard/ventas/certificados', [$VentasController, 'ventasCertificados']);
$router->map('GET', '/dashboard/ventas/cursos', [$VentasController, 'ventasCursos']);
//cursos
$router->map('GET', '/dashboard/ventas/cursos/[i:id]', [$VentasController, 'ObtenerVenta']);
$router->map('POST', '/dashboard/ventas/cursos', [$VentasController, 'Guardado']);
$router->map('POST', '/dashboard/ventas/cursos/actualizar', [$VentasController, 'Actualizar']);
$router->map('DELETE', '/dashboard/ventas/cursos/eliminar', [$VentasController, 'Eliminar']);
//cursos
$router->map('GET', '/dashboard/ventas/certificados/[i:id]', [$VentasController, 'ObtenerVenta']);
$router->map('POST', '/dashboard/ventas/certificados', [$VentasController, 'Guardado']);
$router->map('POST', '/dashboard/ventas/certificados/actualizar', [$VentasController, 'Actualizar']);
$router->map('DELETE', '/dashboard/ventas/certificados/eliminar', [$VentasController, 'Eliminar']);

//Docentes
$router->map('GET', '/dashboard/docentes', [$DocentesController, 'docentes']);
$router->map('GET', '/dashboard/docentes/[i:id]', [$DocentesController, 'ObtenerDocente']);
$router->map('POST', '/dashboard/docentes', [$DocentesController, 'Guardado']);
$router->map('POST', '/dashboard/docentes/actualizar', [$DocentesController, 'Actualizar']);
$router->map('DELETE', '/dashboard/docentes/eliminar', [$DocentesController, 'Eliminar']);

//Estudiantes
$router->map('GET', '/dashboard/estudiantes', [$EstudiantesController, 'estudiantes']);
$router->map('GET', '/dashboard/estudiantes/[i:id]', [$EstudiantesController, 'ObtenerEstudiante']);
$router->map('POST', '/dashboard/estudiantes', [$EstudiantesController, 'Guardado']);
$router->map('POST', '/dashboard/estudiantes/actualizar', [$EstudiantesController, 'Actualizar']);
$router->map('DELETE', '/dashboard/estudiantes/eliminar', [$EstudiantesController, 'Eliminar']);

//Cursos
$router->map('GET', '/dashboard/cursos', [$CursosController, 'cursos']);
$router->map('GET', '/dashboard/cursos/[i:id]', [$CursosController, 'ObtenerCurso']);
$router->map('POST', '/dashboard/cursos', [$CursosController, 'Guardado']);
$router->map('POST', '/dashboard/cursos/actualizar', [$CursosController, 'Actualizar']);
$router->map('DELETE', '/dashboard/cursos/eliminar', [$CursosController, 'Eliminar']);

//Eventos
$router->map('GET', '/dashboard/eventos', [$EventosController, 'eventos']);
$router->map('GET', '/dashboard/eventos/[i:id]', [$EventosController, 'ObtenerCurso']);
$router->map('POST', '/dashboard/eventos', [$EventosController, 'Guardado']);
$router->map('POST', '/dashboard/eventos/actualizar', [$EventosController, 'Actualizar']);
$router->map('DELETE', '/dashboard/eventos/eliminar', [$EventosController, 'Eliminar']);

//Certificado
$router->map('GET', '/dashboard/certificados', [$CertificadosController, 'certificados']);
$router->map('GET', '/dashboard/certificados/[i:id]', [$CertificadosController, 'ObtenerCertificado']);
$router->map('POST', '/dashboard/certificados', [$CertificadosController, 'Guardado']);
$router->map('POST', '/dashboard/certificados/actualizar', [$CertificadosController, 'Actualizar']);
$router->map('DELETE', '/dashboard/certificados/eliminar', [$CertificadosController, 'Eliminar']);

//Comentarios
$router->map('GET', '/dashboard/comentarios', [$ComentariosController, 'comentarios']);
$router->map('GET', '/dashboard/comentarios/[i:id]', [$ComentariosController, 'ObtenerComentario']);
$router->map('POST', '/dashboard/comentarios', [$ComentariosController, 'Guardado']);
$router->map('POST', '/home/comentarios', [$ComentariosController, 'GuardadoHome']);
$router->map('POST', '/dashboard/comentarios/actualizar', [$ComentariosController, 'Actualizar']);
$router->map('DELETE', '/dashboard/comentarios/eliminar', [$ComentariosController, 'Eliminar']);

//Inventario
$router->map('GET', '/dashboard/inventario', [$InventariosController, 'inventario']);
$router->map('GET', '/dashboard/inventario/[i:id]', [$InventariosController, 'ObtenerInventario']);
$router->map('POST', '/dashboard/inventario', [$InventariosController, 'Guardado']);
$router->map('POST', '/dashboard/inventario/actualizar', [$InventariosController, 'Actualizar']);
$router->map('DELETE', '/dashboard/inventario/eliminar', [$InventariosController, 'Eliminar']);

$match = $router->match();

if ($match) {
    call_user_func_array($match['target'], $match['params']);
} else {

    echo 'Página no encontrada';
}
