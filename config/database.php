<?php
    $config = include __DIR__ . '/config.php';

    // $conn = new mysqli(
    //     $config['HOST'],
    //     $config['USERNAME'],
    //     $config['PASSWORD'],
    //     $config['DB'],
    //     $config['PORT']
    // );

    $HOST = getenv('HOST');
    $USERNAME = getenv('USERNAME');
    $PASSWORD = getenv('PASSWORD');
    $DB = getenv('DB');
    $PORT = getenv('PORT');

    $conn = new mysqli($HOST, $USERNAME, $PASSWORD, $DB, $PORT);

    //Verificar la conexion
    if($conn->connect_error){
        die("Conexion fallida: " . $conn->connect_error);
    }

    echo "Conexion exitosa";

    $conn->set_charset("utf8");
?>