<?php
class ProductoModel {
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

    public function insertarProducto($nombre_producto, $precio, $cantidad_stock, $categoria_productos, $estado, $fecha_adquisicion, $fecha_vencimiento, $id_proveedor, $detalles, $archivo, $codigo_barras) {
        // Escapar los datos para evitar inyecciones SQL
        $nombre_producto = mysqli_real_escape_string($this->conexion, $nombre_producto);
        $precio = mysqli_real_escape_string($this->conexion, $precio);
        $cantidad_stock = mysqli_real_escape_string($this->conexion, $cantidad_stock);
        $categoria_productos = mysqli_real_escape_string($this->conexion, $categoria_productos);
        $estado = mysqli_real_escape_string($this->conexion, $estado);
        $fecha_adquisicion = mysqli_real_escape_string($this->conexion, $fecha_adquisicion);
        $fecha_vencimiento = mysqli_real_escape_string($this->conexion, $fecha_vencimiento);
        $codigo_barras = mysqli_real_escape_string($this->conexion, $codigo_barras);
        $detalles = mysqli_real_escape_string($this->conexion, $detalles);

        // Verificar si el proveedor existe antes de insertar el producto
        $consulta_proveedor = "SELECT * FROM proveedores WHERE id_proveedor = '$id_proveedor'";
        $resultado_proveedor = mysqli_query($this->conexion, $consulta_proveedor);
        if (mysqli_num_rows($resultado_proveedor) == 0) {
            // El proveedor no existe, retorna falso
            return false;
        }

        // Procesar la imagen
        $nombreArchivo = $this->procesarImagen($archivo);
        if ($nombreArchivo === false) {
            return false; // Hubo un error procesando la imagen
        }

        // Preparar la consulta SQL
        $consulta = "INSERT INTO productos (nombre_producto, precio, cantidad_stock, categoria_productos, estado, fecha_adquisicion, fecha_vencimiento, id_proveedor, detalles, archivo, codigo_barras) VALUES ('$nombre_producto', '$precio', '$cantidad_stock', '$categoria_productos', '$estado', '$fecha_adquisicion', '$fecha_vencimiento', '$id_proveedor', '$detalles', '$nombreArchivo', '$codigo_barras')";

        // Ejecutar la consulta
        if (mysqli_query($this->conexion, $consulta)) {
            return true; // La inserción fue exitosa
        } else {
            echo "Error al insertar el producto: " . mysqli_error($this->conexion);
            return false; // Hubo un error en la inserción
        }
    }

    public function actualizarProducto($id_producto, $nombre_producto, $precio, $cantidad_stock, $categoria_productos, $estado, $fecha_adquisicion, $fecha_vencimiento, $id_proveedor, $detalles, $archivo, $codigo_barras) {
        // Escapar los datos para evitar inyecciones SQL
        $nombre_producto = mysqli_real_escape_string($this->conexion, $nombre_producto);
        $precio = mysqli_real_escape_string($this->conexion, $precio);
        $cantidad_stock = mysqli_real_escape_string($this->conexion, $cantidad_stock);
        $categoria_productos = mysqli_real_escape_string($this->conexion, $categoria_productos);
        $estado = mysqli_real_escape_string($this->conexion, $estado);
        $fecha_adquisicion = mysqli_real_escape_string($this->conexion, $fecha_adquisicion);
        $fecha_vencimiento = mysqli_real_escape_string($this->conexion, $fecha_vencimiento);
        $codigo_barras = mysqli_real_escape_string($this->conexion, $codigo_barras);
        $detalles = mysqli_real_escape_string($this->conexion, $detalles);

        // Verificar si el proveedor existe antes de actualizar el producto
        $consulta_proveedor = "SELECT * FROM proveedores WHERE id_proveedor = '$id_proveedor'";
        $resultado_proveedor = mysqli_query($this->conexion, $consulta_proveedor);
        if (mysqli_num_rows($resultado_proveedor) == 0) {
            // El proveedor no existe, retorna falso
            return false;
        }

        // Procesar la imagen si es necesario
        $nombreArchivo = $this->procesarImagen($archivo);
        if ($nombreArchivo === false) {
            return false; // Hubo un error procesando la imagen
        }

        // Preparar la consulta SQL
        $consulta = "UPDATE productos SET 
                        nombre_producto = '$nombre_producto', 
                        precio = '$precio', 
                        cantidad_stock = '$cantidad_stock', 
                        categoria_productos = '$categoria_productos', 
                        estado = '$estado', 
                        fecha_adquisicion = '$fecha_adquisicion', 
                        fecha_vencimiento = '$fecha_vencimiento', 
                        id_proveedor = '$id_proveedor', 
                        detalles = '$detalles', 
                        archivo = '$nombreArchivo', 
                        codigo_barras = '$codigo_barras' 
                     WHERE id_producto = '$id_producto'";

        // Ejecutar la consulta
        if (mysqli_query($this->conexion, $consulta)) {
            return true; // La actualización fue exitosa
        } else {
            echo "Error al actualizar el producto: " . mysqli_error($this->conexion);
            return false; // Hubo un error en la actualización
        }
    }

    private function procesarImagen($imagen) {
        $destino = __DIR__ . '/../public/img/Catalogo/';
        $nombreImagen = basename($imagen['name']);
        $rutaImagen = $destino . $nombreImagen;
        move_uploaded_file($imagen['tmp_name'], $rutaImagen);
        return $nombreImagen;
    }
}

//var_dump($_POST);
?>
