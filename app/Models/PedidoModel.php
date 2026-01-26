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

    /* =========================
       INSERTAR PEDIDO
    ========================= */
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
        $sql = "INSERT INTO pedidos (
                    total, estado, direccion, descripcion,
                    numero_seguimiento, tiempo_entrega_horas,
                    informacion_pedido, subtotal, impuestos,
                    fecha_pedido, fecha_entrega, id_usuario
                )
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param(
            "dssssisdsssi",
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
        );

        return $stmt->execute();
    }

    /* =========================
       OBTENER PEDIDO POR ID
    ========================= */
    public function getPedidoById($id_pedido) {
        $sql = "SELECT * FROM pedidos WHERE id_pedido = ?";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) return false;

        $stmt->bind_param("i", $id_pedido);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_assoc();
    }

    /* =========================
       ACTUALIZAR PEDIDO
    ========================= */
    public function updatePedido($id_pedido, $data) {
        $sql = "UPDATE pedidos SET
                    estado = ?,
                    direccion = ?,
                    descripcion = ?,
                    informacion_pedido = ?,
                    subtotal = ?,
                    impuestos = ?,
                    total = ?,
                    fecha_entrega = ?
                WHERE id_pedido = ?";

        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) return false;

        $stmt->bind_param(
            "ssssddssi",
            $data['estado'],
            $data['direccion'],
            $data['descripcion'],
            $data['informacion_pedido'],
            $data['subtotal'],
            $data['impuestos'],
            $data['total'],
            $data['fecha_entrega'],
            $id_pedido
        );

        return $stmt->execute();
    }

    /* =========================
       OBTENER TODOS LOS USUARIOS
    ========================= */
    public function getUsuarios() {
        $sql = "SELECT id_usuario, nombre_usuario FROM usuarios";
        $result = $this->conexion->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
