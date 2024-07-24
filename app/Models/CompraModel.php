<?php
class CompraModel {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;

        if (!$this->conexion) {
            die("Conexión fallida: " . mysqli_connect_error());
        }

        if (!mysqli_select_db($this->conexion, 'sofware_erp')) {
            die("Selección de base de datos fallida: " . mysqli_error($this->conexion));
        }
    }

    // Insertando datos en la tabla compras
    public function insertarCompra($productos_comprados, $detalles_productos, $precio_unitario, $precio_compra, $total_compra, $estado_actual, $metodo_pago, $fecha_compra, $fecha_entrega, $codigo_inventario, $id_proveedor, $id_usuario, $factura) {
        // Escapar los datos para evitar inyecciones SQL
        $productos_comprados = mysqli_real_escape_string($this->conexion, $productos_comprados);
        $detalles_productos = mysqli_real_escape_string($this->conexion, $detalles_productos);
        $precio_unitario = mysqli_real_escape_string($this->conexion, $precio_unitario);
        $precio_compra = mysqli_real_escape_string($this->conexion, $precio_compra);
        $total_compra = mysqli_real_escape_string($this->conexion, $total_compra);
        $estado_actual = mysqli_real_escape_string($this->conexion, $estado_actual);
        $metodo_pago = mysqli_real_escape_string($this->conexion, $metodo_pago);
        $fecha_compra = mysqli_real_escape_string($this->conexion, $fecha_compra);
        $fecha_entrega = mysqli_real_escape_string($this->conexion, $fecha_entrega);
      
        // Verificar si el usuario existe antes de insertar la compra
        $consulta_usuario = "SELECT * FROM usuarios WHERE id_usuario = $id_usuario";
        $resultado_usuario = mysqli_query($this->conexion, $consulta_usuario);
        if (mysqli_num_rows($resultado_usuario) == 0) {
            // El usuario no existe, retorna falso
            return false;
        }

        // Verificar si el proveedor existe antes de insertar la compra
        $consulta_proveedor = "SELECT * FROM proveedores WHERE id_proveedor = '$id_proveedor'";
        $resultado_proveedor = mysqli_query($this->conexion, $consulta_proveedor);
        if (mysqli_num_rows($resultado_proveedor) == 0) {
            // El proveedor no existe, retorna falso
            return false;
        }


          // Verificar si el proveedor existe antes de insertar la compra
          $consulta_inventario = "SELECT * FROM  inventarios WHERE  codigo_inventario = '$codigo_inventario'";
          $resultado_inventario = mysqli_query($this->conexion, $consulta_inventario);
          if (mysqli_num_rows($resultado_inventario) == 0) {
              // El proveedor no existe, retorna falso
              return false;
          }


        // Procesar la imagen
        $nombreArchivo = $this->procesarImagen($factura);

        // Preparar la consulta SQL
        $consulta = "INSERT INTO compras (productos_comprados, detalles_productos, precio_unitario, precio_compra, total_compra, estado_actual, metodo_pago, fecha_compra, fecha_entrega, codigo_inventario, id_proveedor, id_usuario, factura) 
                     VALUES ('$productos_comprados', '$detalles_productos', '$precio_unitario', '$precio_compra', '$total_compra', '$estado_actual', '$metodo_pago', '$fecha_compra', '$fecha_entrega', '$codigo_inventario', '$id_proveedor', '$id_usuario', '$nombreArchivo')";

        // Ejecutar la consulta
        if (mysqli_query($this->conexion, $consulta)) {
            return true; // La inserción fue exitosa
        } else {
            return false; // Hubo un error en la inserción
        }
    }

    // Actualizando datos en la tabla compras
    public function actualizarCompra($id_compra, $productos_comprados, $detalles_productos, $precio_unitario, $precio_compra, $total_compra, $estado_actual, $metodo_pago, $fecha_compra, $fecha_entrega, $codigo_inventario, $id_proveedor, $id_usuario, $factura) {
        // Escapar los datos para evitar inyecciones SQL
        $productos_comprados = mysqli_real_escape_string($this->conexion, $productos_comprados);
        $detalles_productos = mysqli_real_escape_string($this->conexion, $detalles_productos);
        $precio_unitario = mysqli_real_escape_string($this->conexion, $precio_unitario);
        $precio_compra = mysqli_real_escape_string($this->conexion, $precio_compra);
        $total_compra = mysqli_real_escape_string($this->conexion, $total_compra);
        $estado_actual = mysqli_real_escape_string($this->conexion, $estado_actual);
        $metodo_pago = mysqli_real_escape_string($this->conexion, $metodo_pago);
        $fecha_compra = mysqli_real_escape_string($this->conexion, $fecha_compra);
        $fecha_entrega = mysqli_real_escape_string($this->conexion, $fecha_entrega);
       
  // Verificar si el usuario existe antes de insertar la compra
  $consulta_usuario = "SELECT * FROM usuarios WHERE id_usuario = $id_usuario";
  $resultado_usuario = mysqli_query($this->conexion, $consulta_usuario);
  if (mysqli_num_rows($resultado_usuario) == 0) {
      // El usuario no existe, retorna falso
      return false;
  }

  // Verificar si el proveedor existe antes de insertar la compra
  $consulta_proveedor = "SELECT * FROM proveedores WHERE id_proveedor = '$id_proveedor'";
  $resultado_proveedor = mysqli_query($this->conexion, $consulta_proveedor);
  if (mysqli_num_rows($resultado_proveedor) == 0) {
      // El proveedor no existe, retorna falso
      return false;
  }


    // Verificar si el proveedor existe antes de insertar la compra
    $consulta_inventario = "SELECT * FROM  inventarios WHERE  codigo_inventario = '$codigo_inventario'";
    $resultado_inventario = mysqli_query($this->conexion, $consulta_inventario);
    if (mysqli_num_rows($resultado_inventario) == 0) {
        // El proveedor no existe, retorna falso
        return false;
    }


  // Procesar la imagen
  $nombreArchivo = $this->procesarImagen($factura);

  // Preparar la consulta SQL
  $consulta = "INSERT INTO compras (productos_comprados, detalles_productos, precio_unitario, precio_compra, total_compra, estado_actual, metodo_pago, fecha_compra, fecha_entrega, codigo_inventario, id_proveedor, id_usuario, factura) 
               VALUES ('$productos_comprados', '$detalles_productos', '$precio_unitario', '$precio_compra', '$total_compra', '$estado_actual', '$metodo_pago', '$fecha_compra', '$fecha_entrega', '$codigo_inventario', '$id_proveedor', '$id_usuario', '$nombreArchivo')";

  // Ejecutar la consulta
  if (mysqli_query($this->conexion, $consulta)) {
      return true; // La inserción fue exitosa
  } else {
      return false; // Hubo un error en la inserción
  }
}




    private function procesarImagen($imagen) {
        $destino = __DIR__ . '/../public/img/factura-compra/';
        $nombreImagen = basename($imagen['name']);
        $rutaImagen = $destino . $nombreImagen;
        move_uploaded_file($imagen['tmp_name'], $rutaImagen);
        return $nombreImagen;
    }


}
var_dump($_POST);
?>
