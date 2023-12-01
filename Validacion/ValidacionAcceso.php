<?php

session_start();
include_once 'Database.php';

$response = array('status' => '', 'message' => '', 'rol_id' => '');

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $db = new Database();
    $query = $db->connect()->prepare('SELECT * FROM user WHERE Correo = :email AND Password = :password');
    $query->execute([':email' => $email, ':password' => $password]);

    $row = $query->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $rol = $row['rol'];
        $_SESSION['rol'] = $rol;
    
        switch ($_SESSION['rol']) {
            case 1:
                $response['status'] = 'success';
                $response['message'] = 'Se inició sesión correctamente como administrador.';
    
                // Agregar una variable para indicar que se debe esperar
                $response['wait_for_ok'] = true;
    
                break;
    
            case 2:
                $response['status'] = 'success';
                $response['message'] = 'Se inició sesión correctamente como usuario.';
                $response['rol_id'] = 2;
                break;
    
            default:
                // Handle other roles or redirect to a default page
                break;
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'El usuario o contraseña son incorrectos.';
    }
    
   echo json_encode($response); 
}


?>