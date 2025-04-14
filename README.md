# Sistema de Gestión de Estudiantes, Docentes y Cursos - CENEFCO

Este proyecto es un sistema desarrollado en PHP y MySQL para la gestión de estudiantes, docentes y cursos en la institución CENEFCO. El sistema permite registrar, actualizar y consultar información relevante de estudiantes, docentes y cursos, facilitando así la administración interna de la institución.

## Características

- Registro de estudiantes, docentes y cursos.
- Consultas y edición de la información.
- Gestión de la asignación de cursos a docentes.
- Administración de los estudiantes inscritos en los cursos.
- Soporte para múltiples usuarios (administradores y otros roles por definir).
  
## Tecnologías Utilizadas

- **PHP**: Lenguaje de programación del servidor.
- **MySQL**: Sistema de gestión de bases de datos.
- **HTML/CSS**: Para la interfaz de usuario.
- **JavaScript**: Para interactividad del lado del cliente.

## Requisitos del Sistema

- **Servidor Web** (Apache, Nginx o algun hosting).
- **PHP 7.4 o superior**.
- **MySQL 5.6 o superior**.
- **XAMPP o LAMP/WAMP** (opcional, para facilidad de desarrollo local).
  
## Instalación

1. **Configura la base de datos**:

   - Crea una base de datos en MySQL llamada `cenefco_system`.

   - Ejecuta los scripts SQL proporcionados en el directorio `/sql/` para crear las tablas necesarias. Estos scripts incluirán las tablas básicas para almacenar la información de estudiantes, docentes, cursos y demás datos relacionados.

2. **Configuración del entorno PHP**:

   - Modifica el archivo `config.php` con las credenciales de tu base de datos. En este archivo, encontrarás las siguientes constantes que deberás ajustar según tu configuración:

     ```php
    $host = 'localhost'; 
    $user = 'tu_usuario';
    $password = 'tu_contraseña';
    $dbname = 'tu_base_de_datos';
     ```

     Asegúrate de reemplazar `tu_contraseña` con la contraseña real de tu base de datos MySQL. Si usas un servidor remoto, también deberás ajustar `DB_HOST` con la IP o URL del servidor.

3. **Sube el código al servidor**:

   - Si estás trabajando en un servidor web, sube todo el contenido del proyecto al directorio adecuado de tu servidor web (por ejemplo, `htdocs` si usas XAMPP).

4. **Accede al sistema**:

   - Abre el navegador y accede a la URL donde has subido el sistema (por ejemplo, `http://localhost/cenefco_system`).
   - Si todo está correctamente configurado, deberías ver la página de inicio del sistema. Desde ahí podrás acceder a las diferentes funcionalidades de gestión de estudiantes, docentes y cursos.
   - Si es la primera vez que usas el sistema, puedes iniciar sesión como administrador o crear un nuevo usuario con privilegios de administrador desde la interfaz de administración.
