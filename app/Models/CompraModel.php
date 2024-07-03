<?php
class  CompraModel {
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


    //insertando base datos tabla pedidos
    public function insertarCompra($productos_comprados,$detalles,$precio_unitario,$precio_compra,$total_compra,$estado_actual,$fecha_compra,$fecha_entrega,$factura,$id_producto,$id_proveedor,$id_usuario) {
        // Escapar los datos para evitar inyecciones SQL
        $productos_comprados = mysqli_real_escape_string($this->conexion, $productos_comprados);
        $detalles = mysqli_real_escape_string($this->conexion, $detalles);
        $precio_unitario = mysqli_real_escape_string($this->conexion, $precio_unitario);
        $precio_compra = mysqli_real_escape_string($this->conexion, $precio_compra);
        $total_compra = mysqli_real_escape_string($this->conexion, $total_compra);
        $estado_actual = mysqli_real_escape_string($this->conexion, $estado_actual);
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


           // Verificar si el producto existe antes de insertar la compra
     $consulta_producto = "SELECT * FROM productos WHERE id_producto = '$id_producto'";
     $resultado_producto = mysqli_query($this->conexion, $consulta_producto);
     if (mysqli_num_rows($resultado_producto) == 0) {
         // El producto no existe, retorna false
         return false;

          // Procesar la imagen
          $nombreArchivo = $this->procesarImagen($factura);
       
          // Preparar la consulta SQL
          $consulta = "INSERT INTO  compras (productos_comprados,detalles,precio_unitario,precio_compra,total_compra,estado_actual,fecha_compra,fecha_entrega,factura,id_producto,id_proveedor,id_usuario) VALUES ('$productos_comprados', '$detalles', '$precio_unitario', '$precio_compra', '$total_compra', '$estado_actual', '$fecha_compra', '$fecha_entrega',  '$nombreArchivo', '$id_producto', '$id_proveedor','$id_usuario' )";
      
          // Ejecutar la consulta
          if (mysqli_query($this->conexion, $consulta)) {
              return true; // La inserción fue exitosa
          } else {
              return false; // Hubo un error en la inserción
          }
        }
    }
}
  

      public function actualizarCompra($id_compra,$productos_comprados,$detalles,$precio_unitario,$precio_compra,$total_compra,$estado_actual,$fecha_compra,$fecha_entrega,$factura,$id_producto,$id_proveedor,$id_usuario) {
        // Escapar los datos para evitar inyecciones SQL
        $productos_comprados = mysqli_real_escape_string($this->conexion, $productos_comprados);
        $detalles = mysqli_real_escape_string($this->conexion, $detalles);
        $precio_unitario = mysqli_real_escape_string($this->conexion, $precio_unitario);
        $precio_compra = mysqli_real_escape_string($this->conexion, $precio_compra);
        $total_compra = mysqli_real_escape_string($this->conexion, $total_compra);
        $estado_actual = mysqli_real_escape_string($this->conexion, $estado_actual);
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


     // Verificar si el producto existe antes de insertar la compra
$consulta_producto = "SELECT * FROM productos WHERE id_producto = '$id_producto'";
$resultado_producto = mysqli_query($this->conexion, $consulta_producto);
if (mysqli_num_rows($resultado_producto) == 0) {
   // El producto no existe, retorna false
   return false;
}

    
        // Procesar la nueva imagen si se proporciona
        if ($factura['error'] === UPLOAD_ERR_OK) {
            $nombreArchivo = $this->procesarImagen($factura);
            $consulta =  $consulta = "UPDATE compras SET  productos_comprados = '$productos_comprados', detalles = '$detalles', precio_unitario = '$precio_unitario',  precio_compra = '$precio_compra',  total_compra = '$total_compra', estado_actual = '$estado_actual', fecha_compra = '$fecha_compra',  factura = '$nombreArchivo',  id_producto = '$id_producto', id_proveedor ='$id_proveedor', id_usuario = '$id_usuario' WHERE id_compra = '$id_compra'";
        } else {
            // Aquí estaba faltando el signo de igual antes de la cadena de consulta
            $consulta = "UPDATE compras SET  productos_comprados = '$productos_comprados', detalles = '$detalles', precio_unitario = '$precio_unitario',  precio_compra = '$precio_compra',  total_compra = '$total_compra', estado_actual = '$estado_actual', fecha_compra = '$fecha_compra',  id_producto = '$id_producto', id_proveedor ='$id_proveedor', id_usuario = '$id_usuario' WHERE id_compra = '$id_compra'";
        }
    
        // Ejecutar la consulta
        if (mysqli_query($this->conexion, $consulta)) {
            return true; // La actualización fue exitosa
        } else {
            return false; // Hubo un error en la actualización
        }
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