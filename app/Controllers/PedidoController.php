<?php

include_once __DIR__ . '/../Models/PedidoModel.php';

session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST['boton'])) {

    
    $mysqli = mysqli_connect('localhost', 'root', '', 'sofware_erp');

    if (!$mysqli) {
        die('Error al conectar MySQL: ' . mysqli_connect_error());
    }

    mysqli_set_charset($mysqli, 'utf8');

    
    $modelo = new PedidoModel($mysqli);

    
    $estado              = $_POST['estado'];
    $direccion           = $_POST['direccion'];
    $descripcion         = $_POST['descripcion'] ?? '';
    $informacion_pedido  = $_POST['informacion_pedido'] ?? '';
    $numero_seguimiento  = $_POST['numero_seguimiento'] ?? null;
    $fecha_pedido = date('Y-m-d H:i:s');
    $fecha_entrega       = $_POST['fecha_entrega'] ?? null;
    $id_usuario          = $_SESSION['id_usuario'];
    $tiempo_entrega_horas = $_POST['tiempo_entrega_horas'] ?? null;

              
    $subtotal = 0;

    if (!empty($_POST['cantidad']) && !empty($_POST['precio'])) {
        for ($i = 0; $i < count($_POST['cantidad']); $i++) {
            $subtotal += (int)$_POST['cantidad'][$i] * (float)$_POST['precio'][$i];
        }
    }

    $impuestos = $subtotal * 0.19;
    $total     = $subtotal + $impuestos;

    
    $tiempo_entrega_horas = filter_input(
    INPUT_POST,
    'tiempo_entrega_horas',
    FILTER_VALIDATE_INT
);

    
    $resultado = $modelo->insertarPedido(
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

    if ($resultado) {
        header("Location: create.php?da=2");
        exit();
    } else {
        echo " Error al insertar el pedido";
    }

    mysqli_close($mysqli);
}
