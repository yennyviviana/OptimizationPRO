<?php

include_once __DIR__ . '/../Models/PedidoModel.php';

session_start(); 
if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit();
}

// Verifica si se ha presionado el botón de guardar
if (isset($_POST['boton'])) {

define('db_host', 'localhost');
define('db_username', 'root');
define('db_password', '');
define('db_dbname', 'sofware_erp');

// Conectar a MySQL y seleccionar la base de datos.
$mysqli = mysqli_connect(db_host, db_username, db_password, db_dbname);

// Verificar que la conexión sea exitosa
if (!$mysqli) {
    die('Error al conectarse a MySQL: ' . mysqli_connect_error());
}

// Establecer juego de caracteres UTF-8zvc c
mysqli_set_charset($mysqli, 'utf8');

    // Crea una instancia del modelo
    $modelo = new PedidoModel($mysqli);

    // Capturar los datos enviados POST
    $referencia = $_POST['referencia'];
    $total = $_POST['total'];
    $estado = $_POST['estado'];
    $direccion_entrega = $_POST['direccion_entrega'];
    $observaciones = $_POST['observaciones'];
    $tracking = $_POST['tracking'];
    $tiempo_estimado_horas = $_POST['tiempo_estimado_horas'];
    $detalles = $_POST['detalles'];
    $metodo_pago = $_POST['metodo_pago'];
    $metodo_pago = $_POST['metodo_pago'];
    $archivo_adjunto =$_FILES['archivo_adjunto'];
    $fecha_pedido = $_POST['fecha_pedido'];
    $fecha_entrega = $_POST['fecha_entrega'];
    $id_usuario = $_SESSION['id_usuario'];

    // Capturar la fecha de entrega proporcionada por el usuario.....
    $fecha_pedido = date('Y-m-d h:i:s');
    $fecha_entrega = $_POST['fecha_entrega'];

    // Convertir las fechas a objetos DateTime
    $fecha_pedido_objeto = new DateTime($fecha_pedido);
    $fecha_entrega_objeto = new DateTime($fecha_entrega);

    // Calcular la diferencia entre las fechas
    $diferencia = $fecha_pedido_objeto->diff($fecha_entrega_objeto);

    // Formatear la diferencia en días y horas
    $tiempo_estimado_horas  = $diferencia->format('%d días y %h horas');

    // Inserta el pedido usando el método correspondiente del modelo......
    $resultado = $modelo->insertarPedido($referencia, $total, $estado, $direccion_entrega, $observaciones, $tracking, $tiempo_estimado_horas,$detalles,$metodo_pago, $archivo_adjunto, $fecha_pedido, $fecha_entrega, $id_usuario);

   
    if ($resultado) {
       
        header("Location: create.php?da=2");
        exit();
    } else {
        echo "Error al insertar el pedido.";
    }

    // Cierra la conexión a la base de datos
    mysqli_close($mysqli);
}
