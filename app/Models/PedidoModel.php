<?php
class PedidoModel {
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

    public function insertarPedido($nombre_pedido, $precio, $estado, $direccion, $descripcion, $numero_seguimiento, $tiempo_entrega_horas, $informacion_pedido, $metodo_pago, $archivo, $fecha_pedido, $fecha_entrega, $id_usuario) {
        // Escapar los datos para evitar inyecciones SQL
        $nombre_pedido = mysqli_real_escape_string($this->conexion, $nombre_pedido);
        $precio = mysqli_real_escape_string($this->conexion, $precio);
        $estado = mysqli_real_escape_string($this->conexion, $estado);
        $direccion = mysqli_real_escape_string($this->conexion, $direccion);
        $descripcion = mysqli_real_escape_string($this->conexion, $descripcion);
        $numero_seguimiento = mysqli_real_escape_string($this->conexion, $numero_seguimiento);
        $tiempo_entrega_horas = mysqli_real_escape_string($this->conexion, $tiempo_entrega_horas);
        $informacion_pedido = mysqli_real_escape_string($this->conexion, $informacion_pedido);
        $metodo_pago = mysqli_real_escape_string($this->conexion, $metodo_pago);
        $fecha_pedido = mysqli_real_escape_string($this->conexion, $fecha_pedido);
        $fecha_entrega = mysqli_real_escape_string($this->conexion, $fecha_entrega);
    
        // Verificar si el usuario existe antes de insertar el pedido
        $consulta_usuario = "SELECT * FROM usuarios WHERE id_usuario = $id_usuario";
        $resultado_usuario = mysqli_query($this->conexion, $consulta_usuario);
        if (mysqli_num_rows($resultado_usuario) == 0) {
            // El usuario no existe, retorna falso
            return false;
        }
        

          // Procesar la imagen
          $nombreArchivo = $this->procesarImagen($archivo);
       
          // Preparar la consulta SQL
          $consulta = "INSERT INTO pedidos (nombre_pedido, precio, estado, direccion, descripcion, numero_seguimiento, tiempo_entrega_horas, informacion_pedido, metodo_pago, archivo, fecha_pedido, fecha_entrega, id_usuario) VALUES ('$nombre_pedido', '$precio', '$estado', '$direccion', '$descripcion', '$numero_seguimiento', '$tiempo_entrega_horas', '$informacion_pedido', '$metodo_pago', '$nombreArchivo', '$fecha_pedido', '$fecha_entrega', '$id_usuario')";
      
          // Ejecutar la consulta
          if (mysqli_query($this->conexion, $consulta)) {
              return true; // La inserción fue exitosa
          } else {
              return false; // Hubo un error en la inserción
          }
      }
  

      public function actualizarPedido($id_pedido, $nombre_pedido, $precio, $estado, $direccion, $descripcion, $numero_seguimiento, $tiempo_entrega_horas, $informacion_pedido, $metodo_pago, $archivo, $fecha_pedido, $fecha_entrega, $id_usuario) {
        // Escapar los datos para evitar inyecciones SQL
        $nombre_pedido = mysqli_real_escape_string($this->conexion, $nombre_pedido);
        $precio = mysqli_real_escape_string($this->conexion, $precio);
        $estado = mysqli_real_escape_string($this->conexion, $estado);
        $direccion = mysqli_real_escape_string($this->conexion, $direccion);
        $descripcion = mysqli_real_escape_string($this->conexion, $descripcion);
        $numero_seguimiento = mysqli_real_escape_string($this->conexion, $numero_seguimiento);
        $tiempo_entrega_horas = mysqli_real_escape_string($this->conexion, $tiempo_entrega_horas);
        $informacion_pedido = mysqli_real_escape_string($this->conexion, $informacion_pedido);
        $metodo_pago = mysqli_real_escape_string($this->conexion, $metodo_pago);
        $fecha_pedido = mysqli_real_escape_string($this->conexion, $fecha_pedido);
        $fecha_entrega = mysqli_real_escape_string($this->conexion, $fecha_entrega);
    
        // Verificar si el usuario existe antes de insertar el pedido
        $consulta_usuario = "SELECT * FROM usuarios WHERE id_usuario = $id_usuario";
        $resultado_usuario = mysqli_query($this->conexion, $consulta_usuario);
        if (mysqli_num_rows($resultado_usuario) == 0) {
            // El usuario no existe, retorna falso
            return false;
        }
    
        // Procesar la nueva imagen si se proporciona
        if ($archivo['error'] === UPLOAD_ERR_OK) {
            $nombreArchivo = $this->procesarImagen($archivo);
            $consulta = "UPDATE pedidos SET nombre_pedido = '$nombre_pedido', precio = '$precio', estado = '$estado', direccion = '$direccion', descripcion = '$descripcion', numero_seguimiento = '$numero_seguimiento', tiempo_entrega_horas = '$tiempo_entrega_horas', informacion_pedido = '$informacion_pedido', metodo_pago = '$metodo_pago', archivo = '$nombreArchivo', fecha_pedido = '$fecha_pedido', fecha_entrega = '$fecha_entrega', id_usuario = '$id_usuario' WHERE id_pedido = '$id_pedido'";
        } else {
            // Aquí estaba faltando el signo de igual antes de la cadena de consulta
            $consulta = "UPDATE pedidos SET nombre_pedido = '$nombre_pedido', precio = '$precio', estado = '$estado', direccion = '$direccion', descripcion = '$descripcion', numero_seguimiento = '$numero_seguimiento', tiempo_entrega_horas = '$tiempo_entrega_horas', informacion_pedido = '$informacion_pedido', metodo_pago = '$metodo_pago', fecha_pedido = '$fecha_pedido', fecha_entrega = '$fecha_entrega', id_usuario = '$id_usuario' WHERE id_pedido = '$id_pedido'";
        }
    
        // Ejecutar la consulta
        if (mysqli_query($this->conexion, $consulta)) {
            return true; // La actualización fue exitosa
        } else {
            return false; // Hubo un error en la actualización
        }
    }

private function procesarImagen($imagen) {
    $destino = __DIR__ . '/../public/img/pedidos-imagen/';
    $nombreImagen = basename($imagen['name']);
    $rutaImagen = $destino . $nombreImagen;
    move_uploaded_file($imagen['tmp_name'], $rutaImagen);
    return $nombreImagen;
}
}


?>