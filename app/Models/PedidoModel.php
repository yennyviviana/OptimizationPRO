<?php
class PedidoModel {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    
    mysqli_select_db($this->conexion, 'sofware_erp');
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
        
     

        // Procesar la imagen
        $nombreArchivo = $this->procesarImagen($archivo);

        // Preparar la consulta SQL
        $consulta = "INSERT INTO pedidos (nombre_pedido, precio, estado, direccion, descripcion, numero_seguimiento, tiempo_entrega_horas, informacion_pedido, metodo_pago, archivo, fecha_pedido, fecha_entrega, id_usuario) VALUES ('$nombre_pedido', '$precio', '$estado', '$direccion', '$descripcion', '$numero_seguimiento', '$tiempo_entrega_horas', '$informacion_pedido', '$metodo_pago',  '$fecha_pedido', '$fecha_entrega', '$id_usuario','$nombreArchivo')";


        // Ejecutar la consulta
        if (mysqli_query($this->conexion, $consulta)) {
            return true; // La inserción fue exitosa
        } else {
            return false; // Hubo un error en la inserción
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

  
