<?php
require_once __DIR__ . '/../Models/ProductoModel.php';
require_once __DIR__ . '/../Config/database.php';

session_start(); // Ensure the session is started

if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit();

}

  

if (isset($_POST['boton'])) {
    // Instantiate the model
    $modelo = new ProductoModel($mysqli);



      // Capture POST data
      if (isset($_POST ['boton'])) {

        $nombre_producto = $_POST ['nombre_producto'];
        $categoria_productos = $_POST ['categoria_productos'];
        $precio = $_POST ['precio'];
        $estado = $_POST ['estado'];
        $detalles = $_POST ['detalles'];
        $archivo = $_FILES['archivo'];
     

          // Inserta el pedido usando el método correspondiente del modelo
   $resultado = $modelo->insertarProducto($nombre_producto, $categoria_productos, $precio, $estado,  $detalles, $archivo);

      
  }
    // Verifica si la inserción fue exitosa
    if ($resultado) {
       // Redirecciona al usuario a la página principal con un mensaje de éxito
       header("Location: create.php?da=2");
       exit();
   } else {
       // En caso de error, muestra un mensaje al usuario
       echo "Error al insertar el proveedor.";
   }
   
   // Cierra la conexión a la base de datos
   mysqli_close($mysqli);
   }
   



   ?>


