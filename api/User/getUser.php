<?php
require_once '../service/UserService.php';
header("Content-Type: application/json; charset=UTF-8");

$userService = new UserService();

$httpMethod = $_SERVER['REQUEST_METHOD'];   //Obtener el metodo HTTP (GET, POST, PUT, DELETE)
$pathRequest = $_SERVER['PATH_INFO'];       //Obtener la ruta de la peticion (Ejemplo -> /users)


if ($httpMethod == 'GET' && preg_match('/^\/user\/id\/([^\/]+)$/', $pathRequest, $matches)) {
    //Obtener los datos enviados en la URL de la peticion
    $email = urldecode($matches[1]);

    $id = $userService->getUserId($email);
    
    echo json_encode(['id' => $id]);
}
?>