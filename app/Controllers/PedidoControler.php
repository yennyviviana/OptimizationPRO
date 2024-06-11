<?php

require_once __DIR__ . '/../Models/PedidoModel.php';
require_once __DIR__ . '/../Config/database.php';


if(!isset($_SESSION['id_usuario'])){
    header("Location: index.php");
}



// Verifica si se ha presionado el botón de guardar
if(isset($_POST['boton'])) {
  

    
    $mysqli = mysqli_connect(db_host, db_username, db_password, db_dbname);
    
    // Verificar que la conexión sea exitosa
    if (!$mysqli) {
        die('Error al conectarse a MySQL: ' . mysqli_connect_error());
    }
    
    // Establecer juego de caracteres UTF-8
    mysqli_set_charset($mysqli, 'utf8');
    

    // Crea una instancia del modelo
    $modelo = new PedidoModel($mysqli);

  
    //capturar los datos enviados POST................
    $nombre_pedido        = $_POST['nombre_pedido'];
    $precio               = $_POST['precio'];
    $estado               =  $_POST['estado'];
    $direccion            =  $_POST['direccion'];
    $descripcion          =  $_POST['descripcion'];
    $numero_seguimiento   =  $_POST['numero_seguimiento'];
    $informacion_pedido   =  $_POST['informacion_pedido'];
    $metodo_pago          = $_POST['metodo_pago'];
    $archivo              = $_FILES['archivo'];
   $id_usuario           =   $_SESSION['id_usuario'];


   // Capturar la fecha de entrega proporcionada por el usuario
   $fecha_pedido =date('Y-m-d h:i:s');
   $fecha_entrega = $_POST['fecha_entrega'];

// Convertir las fechas a objetos DateTime
$fecha_pedido_objeto = new DateTime($fecha_pedido);
$fecha_entrega_objeto = new DateTime($fecha_entrega);

// Calcular la diferencia entre las fechas
$diferencia = $fecha_pedido_objeto->diff($fecha_entrega_objeto);

// Formatear la diferencia en días y horas
$tiempo_entrega_horas = $diferencia->format('%d días y %h horas');

 
    // Inserta el proveedor usando el método correspondiente del modelo
    $resultado = $modelo->insertarPedido($nombre_pedido, $precio, $estado, $direccion, $descripcion, $numero_seguimiento, $tiempo_entrega_horas, $informacion_pedido, $metodo_pago,$archivo,$fecha_pedido,$fecha_entrega,$id_usuario);

    // Verifica si la inserción fue exitosa
    if ($resultado) {
        // Redirecciona al usuario a la página principal con un mensaje de éxito
        header("Location: create.php?da=2");
    } else {
        // En caso de error, muestra un mensaje al usuario
        echo "Error al insertar el pedido.";
    }

    // Cierra la conexión a la base de datos
    mysqli_close($mysqli);
}
?>