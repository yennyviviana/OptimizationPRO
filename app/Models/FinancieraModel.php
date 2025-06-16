<?php
class FinancieraModel {
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

    public function insertarFinanciera($fecha_transaccion, $monto, $tipo_transaccion, $descripcion, $id_usuario, $id_proveedor, $id_cliente, $id_pedido, $codigo_inventario, $id_producto, $id_compra, $id_proyecto) {
        // Escapar los datos para evitar inyecciones SQL
        $fecha_transaccion = mysqli_real_escape_string($this->conexion, $fecha_transaccion);
        $monto = mysqli_real_escape_string($this->conexion, $monto);
        $tipo_transaccion = mysqli_real_escape_string($this->conexion, $tipo_transaccion);
        $descripcion = mysqli_real_escape_string($this->conexion, $descripcion);

        // Verificar si el usuario existe antes de insertar
        $consulta_usuario = "SELECT * FROM usuarios WHERE id_usuario = $id_usuario";
        $resultado_usuario = mysqli_query($this->conexion, $consulta_usuario);
        if (mysqli_num_rows($resultado_usuario) == 0) {
            return false; // El usuario no existe
        }

        // Verificar si el proveedor existe antes de insertar
        $consulta_proveedor = "SELECT * FROM proveedores WHERE id_proveedor = '$id_proveedor'";
        $resultado_proveedor = mysqli_query($this->conexion, $consulta_proveedor);
        if (mysqli_num_rows($resultado_proveedor) == 0) {
            return false; // El proveedor no existe
        }

        // Verificar si el código de inventario existe antes de insertar
        $consulta_inventario = "SELECT * FROM inventarios WHERE codigo_inventario = '$codigo_inventario'";
        $resultado_inventario = mysqli_query($this->conexion, $consulta_inventario);
        if (mysqli_num_rows($resultado_inventario) == 0) {
            return false; // El código de inventario no existe
        }

        // Preparar la consulta SQL
        $consulta = "INSERT INTO financieras (fecha_transaccion, monto, tipo_transaccion, descripcion, id_usuario, id_proveedor, id_cliente, id_pedido, codigo_inventario, id_producto, id_compra, id_proyecto) 
                     VALUES ('$fecha_transaccion', '$monto', '$tipo_transaccion', '$descripcion', '$id_usuario', '$id_proveedor', '$id_cliente', '$id_pedido', '$codigo_inventario', '$id_producto', '$id_compra', '$id_proyecto')";

        // Ejecutar la consulta
        if (mysqli_query($this->conexion, $consulta)) {
            return true; // La inserción fue exitosa
        } else {
            echo "Error al insertar el registro: " . mysqli_error($this->conexion);
            return false; // Hubo un error en la inserción
        }
    }

    public function actualizarFinanciera($id_transaccion, $fecha_transaccion, $monto, $tipo_transaccion, $descripcion, $id_usuario, $id_proveedor, $id_cliente, $id_pedido, $codigo_inventario, $id_producto, $id_compra, $id_proyecto) {
        // Escapar los datos para evitar inyecciones SQL
        $fecha_transaccion = mysqli_real_escape_string($this->conexion, $fecha_transaccion);
        $monto = mysqli_real_escape_string($this->conexion, $monto);
        $tipo_transaccion = mysqli_real_escape_string($this->conexion, $tipo_transaccion);
        $descripcion = mysqli_real_escape_string($this->conexion, $descripcion);
        $id_usuario = mysqli_real_escape_string($this->conexion, $id_usuario);
        $id_proveedor = mysqli_real_escape_string($this->conexion, $id_proveedor);
        $id_cliente = mysqli_real_escape_string($this->conexion, $id_cliente);
        $id_pedido = mysqli_real_escape_string($this->conexion, $id_pedido);
        $codigo_inventario = mysqli_real_escape_string($this->conexion, $codigo_inventario);
        $id_producto = mysqli_real_escape_string($this->conexion, $id_producto);
        $id_compra = mysqli_real_escape_string($this->conexion, $id_compra);
        $id_proyecto = mysqli_real_escape_string($this->conexion, $id_proyecto);
    
        // Preparar la consulta SQL
        $consulta = "UPDATE financieras SET 
                        fecha_transaccion = '$fecha_transaccion', 
                        monto = '$monto', 
                        tipo_transaccion = '$tipo_transaccion',
                        descripcion = '$descripcion',
                        id_usuario = '$id_usuario',
                        id_proveedor = '$id_proveedor',
                        id_cliente = '$id_cliente',
                        id_pedido = '$id_pedido',
                        codigo_inventario = '$codigo_inventario',
                        id_producto = '$id_producto',
                        id_compra = '$id_compra',
                        id_proyecto = '$id_proyecto'
                     WHERE id_transaccion = '$id_transaccion'";
    
        // Ejecutar la consulta
        $resultado = mysqli_query($this->conexion, $consulta);
    
        // Verificar si la actualización fue exitosa
        if ($resultado) {
            return true; 
        } else {
            return false; 
        }
    }

}
