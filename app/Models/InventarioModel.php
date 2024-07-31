<?php
class InventarioModel {
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

    public function insertarInventario($nombre_producto, $cantidad_stock, $precio_unitario, $costo_unitario, $precio_compra, $precio_venta, $categoria_productos, $descripcion, $codigo_barras, $ubicacion, $estado, $id_producto, $id_proveedor, $fecha_adquisicion, $fecha_vencimiento, $tipo_documento) {
        
        // Escapar los datos para evitar inyecciones SQL
        $nombre_producto = mysqli_real_escape_string($this->conexion, $nombre_producto);
        $cantidad_stock = mysqli_real_escape_string($this->conexion, $cantidad_stock);
        $precio_unitario = mysqli_real_escape_string($this->conexion, $precio_unitario);
        $costo_unitario = mysqli_real_escape_string($this->conexion, $costo_unitario);
        $precio_compra = mysqli_real_escape_string($this->conexion, $precio_compra);
        $precio_venta = mysqli_real_escape_string($this->conexion, $precio_venta);
        $categoria_productos = mysqli_real_escape_string($this->conexion, $categoria_productos);
        $descripcion = mysqli_real_escape_string($this->conexion, $descripcion);
        $codigo_barras = mysqli_real_escape_string($this->conexion, $codigo_barras);
        $ubicacion = mysqli_real_escape_string($this->conexion, $ubicacion);
        $estado = mysqli_real_escape_string($this->conexion, $estado);
        $fecha_adquisicion = mysqli_real_escape_string($this->conexion, $fecha_adquisicion);
        $fecha_vencimiento = mysqli_real_escape_string($this->conexion, $fecha_vencimiento);


        // Verificar si el proveedor existe antes de insertar el producto.......
        $consulta_proveedor = "SELECT * FROM proveedores WHERE id_proveedor = '$id_proveedor'";
        $resultado_proveedor = mysqli_query($this->conexion, $consulta_proveedor);
        if (mysqli_num_rows($resultado_proveedor) == 0) {
            // El proveedor no existe, retorna falso
            return false;
        }


        // Verificar si el producto existe antes de insertar el inventario
        $consulta_producto = "SELECT * FROM productos WHERE id_producto = '$id_producto'";
        $resultado_producto = mysqli_query($this->conexion, $consulta_producto);
        if (mysqli_num_rows($resultado_producto) == 0) {
            // El producto no existe, retorna falso
            return false;
        }



        // Procesar la imagen
        $nombreArchivo = $this->procesarImagen($tipo_documento);
        if ($nombreArchivo === false) {
            return false; // Hubo un error procesando la imagen
        }

        // Preparar la consulta SQL
        $consulta = "INSERT INTO inventarios (nombre_producto, cantidad_stock, precio_unitario, costo_unitario, precio_compra, precio_venta, categoria_productos, descripcion, codigo_barras, ubicacion, estado, id_producto, id_proveedor, fecha_adquisicion, fecha_vencimiento, tipo_documento) VALUES ('$nombre_producto', '$cantidad_stock', '$precio_unitario', '$costo_unitario', '$precio_compra', '$precio_venta', '$categoria_productos', '$descripcion', '$codigo_barras', '$ubicacion', '$estado', '$id_producto', '$id_proveedor', '$fecha_adquisicion', '$fecha_vencimiento', '$nombreArchivo')";

        // Ejecutar la consulta
        if (mysqli_query($this->conexion, $consulta)) {
            return true; // La inserción fue exitosa.....
        } else {
            echo "Error al insertar el inventario: " . mysqli_error($this->conexion);
            return false; // Hubo un error en la inserción........
        }
    }

    private function procesarImagen($imagen) {
        $destino = __DIR__ . '/../public/img/TipoDocumento/';
        $nombreImagen = basename($imagen['name']);
        $rutaImagen = $destino . $nombreImagen;
        if (move_uploaded_file($imagen['tmp_name'], $rutaImagen)) {
            return $nombreImagen;
        } else {
            return false;
        }
    }
}


//var_dump($_POST);
?>
