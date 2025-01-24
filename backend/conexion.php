<?php
// Establecer encabezado de contenido como JSON (opcional)
header('Content-Type: application/json');

// Intentar obtener la URL de conexión desde las variables de entorno
$mysql_url = getenv("MYSQL_URL");

if ($mysql_url) {
    // Si la variable MYSQL_URL está definida (entorno de producción)
    $db_url = parse_url($mysql_url);

    // Variables de conexión para producción (Railway)
    $servername = $db_url['host'];
    $username = $db_url['user'];
    $password = $db_url['pass'];
    $dbname = ltrim($db_url['path'], '/'); // Quitar la barra inicial del nombre de la base de datos
} else {
    // Si la variable MYSQL_URL no está definida (entorno de desarrollo)
    $servername = "127.0.0.1";  // Dirección del servidor (localhost)
    $username = "root";         // Nombre de usuario de la base de datos
    $password = "";             // Contraseña (en blanco por defecto en XAMPP)
    $dbname = "cafeteria";      // Nombre de la base de datos
}

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    echo json_encode(array("status" => "error", "message" => "Conexión fallida: " . $conn->connect_error));
    exit();
}

// Retornar la conexión para usarla en otros scripts
return $conn;
?>
