<?php

// Recibir datos del formulario
$dni = $_POST['dni'];
$nombres = $_POST['nombres'];
$apellidos = $_POST['apellidos'];
$fechaNacimiento = $_POST['fechaNacimiento'];
$direccion = $_POST['direccion'];
$correo = $_POST['correo'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Encriptar la contraseña

try {
    // Conexión a la base de datos
    $dsn = "mysql:host=localhost;dbname=bdveterinaria_wampo;charset=utf8";
    $usuario = "root";
    $contrasena = "";
    $opciones = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    $conexion = new PDO($dsn, $usuario, $contrasena, $opciones);

    // Insertar datos en la base de datos
    $sql = "INSERT INTO registro_user (Dni, Nombres, Apellidos, Fecha_Nacimiento, Direccion, Correo_Electronico, Contrasena) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([$dni, $nombres, $apellidos, $fechaNacimiento, $direccion, $correo, $password]);

    // Cerrar la conexión
    $conexion = null;

    // Mostrar mensaje de éxito
    echo "Registro exitoso. ¡Bienvenido!";
} catch (PDOException $e) {
    // Manejar errores de la base de datos
    echo "Error en la conexión o en el registro: " . $e->getMessage();
}
?>