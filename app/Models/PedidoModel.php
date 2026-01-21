<?php

class PedidoModel {

    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;

        if (!$this->conexion) {
            die("Conexión fallida: " . mysqli_connect_error());
        }
    }

    
    public function insertarPedido(
        $total,
        $estado,
        $direccion,
        $descripcion,
        $numero_seguimiento,
        $tiempo_entrega_horas,
        $informacion_pedido,
        $subtotal,
        $impuestos,
        $fecha_pedido,
        $fecha_entrega,
        $id_usuario
    ) {

        
        $total                 = mysqli_real_escape_string($this->conexion, $total);
        $estado                = mysqli_real_escape_string($this->conexion, $estado);
        $direccion             = mysqli_real_escape_string($this->conexion, $direccion);
        $descripcion           = mysqli_real_escape_string($this->conexion, $descripcion);
        $numero_seguimiento    = mysqli_real_escape_string($this->conexion, $numero_seguimiento);
        $tiempo_entrega_horas  = mysqli_real_escape_string($this->conexion, $tiempo_entrega_horas);
        $informacion_pedido    = mysqli_real_escape_string($this->conexion, $informacion_pedido);
        $subtotal              = mysqli_real_escape_string($this->conexion, $subtotal);
        $impuestos             = mysqli_real_escape_string($this->conexion, $impuestos);
        $fecha_pedido          = mysqli_real_escape_string($this->conexion, $fecha_pedido);
        $fecha_entrega         = mysqli_real_escape_string($this->conexion, $fecha_entrega);
        $id_usuario            = mysqli_real_escape_string($this->conexion, $id_usuario);

        
        $check = mysqli_query(
            $this->conexion,
            "SELECT id_usuario FROM usuarios WHERE id_usuario = '$id_usuario'"
        );

        if (mysqli_num_rows($check) == 0) {
            return false;
        }

       
        $sql = "
            INSERT INTO pedidos (
                total,
                estado,
                direccion,
                descripcion,
                numero_seguimiento,
                tiempo_entrega_horas,
                informacion_pedido,
                subtotal,
                impuestos,
                fecha_pedido,
                fecha_entrega,
                id_usuario
            ) VALUES (
                '$total',
                '$estado',
                '$direccion',
                '$descripcion',
                '$numero_seguimiento',
                '$tiempo_entrega_horas',
                '$informacion_pedido',
                '$subtotal',
                '$impuestos',
                '$fecha_pedido',
                '$fecha_entrega',
                '$id_usuario'
            )
        ";

        if (!mysqli_query($this->conexion, $sql)) {
            echo " MySQL Error: " . mysqli_error($this->conexion);
            return false;
        }

        return true;
    }
}
