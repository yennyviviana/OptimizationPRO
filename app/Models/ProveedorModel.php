<?php

class ProveedorModel {
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

    public function insertarProveedor($nombre_empresa, $direccion, $telefono, $correo_electronico, $condiciones_pago, $metodo_pago, $descripcion,$historial_pedidos,$id_producto, $archivo) {
        // Escapar los datos para evitar inyecciones SQL
        $nombre_empresa = mysqli_real_escape_string($this->conexion, $nombre_empresa);
        $direccion = mysqli_real_escape_string($this->conexion, $direccion);
        $telefono = mysqli_real_escape_string($this->conexion, $telefono);
        $correo_electronico = mysqli_real_escape_string($this->conexion, $correo_electronico);
        $condiciones_pago = mysqli_real_escape_string($this->conexion, $condiciones_pago);
        $metodo_pago = mysqli_real_escape_string($this->conexion, $metodo_pago);
        $descripcion = mysqli_real_escape_string($this->conexion, $descripcion);
        $historial_pedidos = mysqli_real_escape_string($this->conexion, $historial_pedidos);
        
        

       //Verificar si el  producto existe antes de insertar el producto
        $consulta_producto = "SELECT * FROM  productos WHERE id_producto = $id_producto";
        $resultado_producto = mysqli_query($this->conexion, $consulta_producto);
        if (mysqli_num_rows($resultado_producto) == 0) {
            // si el producto no existe, retorna falso.....
            return false;
        }

        
        
        // Procesar la imagen......
        $nombreArchivo = $this->procesarImagen($archivo);

        // Preparar la consulta SQL
        $consulta = "INSERT INTO proveedores (nombre_empresa, direccion, telefono, correo_electronico, condiciones_pago, metodo_pago, descripcion,historial_pedidos, archivo) VALUES ('$nombre_empresa', '$direccion', '$telefono', '$correo_electronico', '$condiciones_pago', '$metodo_pago', '$descripcion',  '$historial_pedidos', '$nombreArchivo')";

        // Ejecutar la consulta
        if (mysqli_query($this->conexion, $consulta)) {
            return true; 
        } else {
            return false; 
        }
    }

    public function actualizarProveedor($id_proveedor, $nombre_empresa, $direccion, $telefono, $correo_electronico, $condiciones_pago, $metodo_pago, $descripcion,$historial_pedidos,$id_producto, $archivo) {
        // Escapar los datos para evitar inyecciones SQL
        $nombre_empresa = mysqli_real_escape_string($this->conexion, $nombre_empresa);
        $direccion = mysqli_real_escape_string($this->conexion, $direccion);
        $telefono = mysqli_real_escape_string($this->conexion, $telefono);
        $correo_electronico = mysqli_real_escape_string($this->conexion, $correo_electronico);
        $condiciones_pago = mysqli_real_escape_string($this->conexion, $condiciones_pago);
        $metodo_pago = mysqli_real_escape_string($this->conexion, $metodo_pago);
        $descripcion = mysqli_real_escape_string($this->conexion, $descripcion);
        $historial_pedidos = mysqli_real_escape_string($this->conexion, $historial_pedidos);


        
// Verificar si el producto  existe antes de insertar el proveedor....
        $consulta_producto = "SELECT * FROM  productos WHERE id_producto = $id_producto";
        $resultado_producto = mysqli_query($this->conexion, $consulta_producto);
        if (mysqli_num_rows($resultado_producto) == 0) {
            // si el producto no existe, retorna falso.....
            return false;
        }


        // Procesar la nueva imagen si se proporciona
        if ($archivo['error'] === UPLOAD_ERR_OK) {
            $nombreArchivo = $this->procesarImagen($archivo);
            $consulta = "UPDATE proveedores SET nombre_empresa = '$nombre_empresa', direccion = '$direccion', telefono = '$telefono', correo_electronico = '$correo_electronico',  condiciones_pago = '$condiciones_pago', metodo_pago = '$metodo_pago', descripcion = '$descripcion', historial_pedidos = '$historial_pedidos', id_producto = '$id_producto',  archivo = '$nombreArchivo' WHERE id_proveedor = '$id_proveedor'";
        } else {
            // Actualizar sin cambiar la imagen
            $consulta = "UPDATE proveedores SET nombre_empresa = '$nombre_empresa', direccion = '$direccion', telefono = '$telefono', correo_electronico = '$correo_electronico', condiciones_pago = '$condiciones_pago', metodo_pago = '$metodo_pago', descripcion = '$descripcion',historial_pedidos = '$historial_pedidos', id_producto = '$id_producto',  WHERE id_proveedor = '$id_proveedor'";
        }

        // Ejecutar la consulta
        if (mysqli_query($this->conexion, $consulta)) {
            return true; 
        } else {
            return false; 
        }
    }

    private function procesarImagen($imagen) {
        $destino = __DIR__ . '/../public/files/uploads/proveedores/';
        $nombreImagen = basename($imagen['name']);
        $rutaImagen = $destino . $nombreImagen;
        move_uploaded_file($imagen['tmp_name'], $rutaImagen);
        return $nombreImagen;
    }
}


var_dump($_POST);