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


    //insertando base datos tabla pedidos......
    public function insertarPedido($referencia, $total, $estado, $direccion_entrega, $observaciones, $tracking, $tiempo_estimado_horas,$detalles,$metodo_pago, $archivo_adjunto, $fecha_pedido, $fecha_entrega, $id_usuario){
        // Escapar los datos para evitar inyecciones SQL
        $referencia = mysqli_real_escape_string($this->conexion, $referencia);
        $total = mysqli_real_escape_string($this->conexion, $total);
        $estado = mysqli_real_escape_string($this->conexion, $estado);
        $direccion_entrega = mysqli_real_escape_string($this->conexion, $direccion_entrega);
        $observaciones = mysqli_real_escape_string($this->conexion, $observaciones);
        $tracking = mysqli_real_escape_string($this->conexion, $tracking);
        $tiempo_estimado_horas	 = mysqli_real_escape_string($this->conexion, $tiempo_estimado_horas);
        $detalles = mysqli_real_escape_string($this->conexion, $detalles);
        $metodo_pago = mysqli_real_escape_string($this->conexion, $metodo_pago);
        $fecha_pedido = mysqli_real_escape_string($this->conexion, $fecha_pedido);
        $fecha_entrega = mysqli_real_escape_string($this->conexion, $fecha_entrega);
      
    
        // Verificar si el usuario existe antes de insertar el pedido
        $consulta_usuario = "SELECT * FROM usuarios WHERE id_usuario = $id_usuario";
        $resultado_usuario = mysqli_query($this->conexion, $consulta_usuario);
        if (mysqli_num_rows($resultado_usuario) == 0) {
            // El usuario no existe, retorna falso.....
            return false;
        }
        

          // Procesar la imagen
          $nombreArchivo = $this->procesarArchivo($archivo_adjunto);
       
          // Preparar la consulta SQL
          $consulta = "INSERT INTO pedidos(referencia,total, estado, direccion_entrega, observaciones, tracking, tiempo_estimado_horas,detalles, metodo_pago, archivo_adjunto, fecha_pedido, fecha_entrega, id_usuario) VALUES ( '$referencia', '$total', '$estado', '$direccion_entrega', '$observaciones', '$tracking', '$tiempo_estimado_horas','$detalles','$metodo_pago','$archivo_adjunto', '$fecha_pedido', '$fecha_entrega', '$id_usuario')";
      
          // Ejecutar la consulta
          if (mysqli_query($this->conexion, $consulta)) {
              return true; // La inserción fue exitosa
          } else {
              return false; // Hubo un error en la inserción
          }
      }
  

      public function actualizarPedido($id_pedido,$referencia, $total, $estado, $direccion_entrega, $observaciones, $tracking, $tiempo_estimado_horas,$detalles,$metodo_pago, $archivo_adjunto, $fecha_pedido, $fecha_entrega, $id_usuario) {
        // Escapar los datos para evitar inyecciones SQL.....
        $referencia = mysqli_real_escape_string($this->conexion, $referencia);
        $total = mysqli_real_escape_string($this->conexion, $total);
        $estado = mysqli_real_escape_string($this->conexion, $estado);
        $direccion_entrega = mysqli_real_escape_string($this->conexion, $direccion_entrega);
        $observaciones = mysqli_real_escape_string($this->conexion, $observaciones);
        $tracking = mysqli_real_escape_string($this->conexion, $tracking);
        $tiempo_estimado_horas	 = mysqli_real_escape_string($this->conexion, $tiempo_estimado_horas);
        $detalles = mysqli_real_escape_string($this->conexion, $detalles);
        $metodo_pago = mysqli_real_escape_string($this->conexion, $metodo_pago);
        $fecha_pedido = mysqli_real_escape_string($this->conexion, $fecha_pedido);
        $fecha_entrega = mysqli_real_escape_string($this->conexion, $fecha_entrega);
      
    
    
        // Verificar si el usuario existe antes de insertar el pedido
        $consulta_usuario = "SELECT * FROM usuarios WHERE id_usuario = $id_usuario";
        $resultado_usuario = mysqli_query($this->conexion, $consulta_usuario);
        if (mysqli_num_rows($resultado_usuario) == 0) {
            return false; // El usuario no existe
        }
    
        // Obtener el nombre del archivo anterior
        $consulta_anterior = "SELECT archivo_adjunto FROM pedidos WHERE id_pedido = '$id_pedido'";
        $resultado_anterior = mysqli_query($this->conexion, $consulta_anterior);
        $fila_anterior = mysqli_fetch_assoc($resultado_anterior);
        $nombreArchivo = $fila_anterior['archivo_adjunto']; // Valor por defecto
    
        // Procesar la nuevo archivo si se proporciona
        if ($archivo_adjunto['error'] === UPLOAD_ERR_OK) {
            $nombreArchivo = $this->procesarImagen($archivo_adjunto); // Procesar nueva imagen
        }
    
        // Construir la consulta de actualización......                                                                                                                                                                                                                                                       
        $consulta = "UPDATE pedidos SET  referencia ='$referencia', total = '$total', estado = '$estado', direccion_entrega = '$direccion_entrega', observaciones = '$observaciones', tracking = '$tracking', tiempo_estimado_horas = '$tiempo_estimado_horas', detalles ='$detalles', metodo_pago = '$metodo_pago', archivo_adjunto = '$nombreArchivo', fecha_pedido = '$fecha_pedido', fecha_entrega = '$fecha_entrega', id_usuario = '$id_usuario' WHERE id_pedido = '$id_pedido'";
    
        // Ejecutar la consulta
        if (mysqli_query($this->conexion, $consulta)) {
            return true; // La actualización fue exitosa
        } else {
            return false; // error en la actualización
        }
    }
    
/*private function procesarImagen($imagen) {
    $destino = __DIR__ . "../../public/img/uploads/pedidos/";
    $nombreImagen = basename($imagen['name']);
    $rutaImagen = $destino . $nombreImagen;
    move_uploaded_file($imagen['tmp_name'], $rutaImagen);
    return $nombreImagen;*/


    private function procesarArchivo($archivo_adjunto) {
        $destino = __DIR__ . "/../../public/files/uploads/pedidos/";
        
        // Crear carpeta si no existe
        if (!file_exists($destino)) {
            mkdir($destino, 0777, true);
        }
    
        $nombreArchivo = basename($archivo_adjunto['name']);
        $rutaArchivo = $destino . $nombreArchivo;
    
        // Validar tipo MIME (opcional pero recomendado)
        $permitidos = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
        if (!in_array($archivo_adjunto['type'], $permitidos)) {
            throw new Exception("Tipo de archivo no permitido.");
        }
    
        if (!move_uploaded_file($archivo_adjunto['tmp_name'], $rutaArchivo)) {
            throw new Exception("No se pudo mover el archivo.");
        }
    
        return $nombreArchivo;
    }
    
}

//var_dump($_POST);
