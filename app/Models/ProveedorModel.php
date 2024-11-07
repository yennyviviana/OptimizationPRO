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

    public function insertarProveedor($nombre_empresa, $direccion, $telefono, $correo_electronico, $lista_productos, $condiciones_pago, $metodo_pago, $descripcion, $archivo) {
        // Escapar los datos para evitar inyecciones SQL
        $nombre_empresa = mysqli_real_escape_string($this->conexion, $nombre_empresa);
        $direccion = mysqli_real_escape_string($this->conexion, $direccion);
        $telefono = mysqli_real_escape_string($this->conexion, $telefono);
        $correo_electronico = mysqli_real_escape_string($this->conexion, $correo_electronico);
        $lista_productos = mysqli_real_escape_string($this->conexion, $lista_productos);
        $condiciones_pago = mysqli_real_escape_string($this->conexion, $condiciones_pago);
        $metodo_pago = mysqli_real_escape_string($this->conexion, $metodo_pago);
        $descripcion = mysqli_real_escape_string($this->conexion, $descripcion);

        // Procesar la imagen
        $nombreArchivo = $this->procesarImagen($archivo);

        // Preparar la consulta SQL
        $consulta = "INSERT INTO proveedores (nombre_empresa, direccion, telefono, correo_electronico, lista_productos, condiciones_pago, metodo_pago, descripcion, archivo) VALUES ('$nombre_empresa', '$direccion', '$telefono', '$correo_electronico', '$lista_productos', '$condiciones_pago', '$metodo_pago', '$descripcion', '$nombreArchivo')";

        // Ejecutar la consulta
        if (mysqli_query($this->conexion, $consulta)) {
            return true; // La inserción fue exitosa
        } else {
            return false; // Hubo un error en la inserción
        }
    }

    public function actualizarProveedor($id_proveedor, $nombre_empresa, $direccion, $telefono, $correo_electronico, $lista_productos, $condiciones_pago, $metodo_pago, $descripcion, $archivo) {
        // Escapar los datos para evitar inyecciones SQL
        $nombre_empresa = mysqli_real_escape_string($this->conexion, $nombre_empresa);
        $direccion = mysqli_real_escape_string($this->conexion, $direccion);
        $telefono = mysqli_real_escape_string($this->conexion, $telefono);
        $correo_electronico = mysqli_real_escape_string($this->conexion, $correo_electronico);
        $lista_productos = mysqli_real_escape_string($this->conexion, $lista_productos);
        $condiciones_pago = mysqli_real_escape_string($this->conexion, $condiciones_pago);
        $metodo_pago = mysqli_real_escape_string($this->conexion, $metodo_pago);
        $descripcion = mysqli_real_escape_string($this->conexion, $descripcion);

        // Procesar la nueva imagen si se proporciona
        if ($archivo['error'] === UPLOAD_ERR_OK) {
            $nombreArchivo = $this->procesarImagen($archivo);
            $consulta = "UPDATE proveedores SET nombre_empresa = '$nombre_empresa', direccion = '$direccion', telefono = '$telefono', correo_electronico = '$correo_electronico', lista_productos = '$lista_productos', condiciones_pago = '$condiciones_pago', metodo_pago = '$metodo_pago', descripcion = '$descripcion', archivo = '$nombreArchivo' WHERE id_proveedor = '$id_proveedor'";
        } else {
            // Actualizar sin cambiar la imagen
            $consulta = "UPDATE proveedores SET nombre_empresa = '$nombre_empresa', direccion = '$direccion', telefono = '$telefono', correo_electronico = '$correo_electronico', lista_productos = '$lista_productos', condiciones_pago = '$condiciones_pago', metodo_pago = '$metodo_pago', descripcion = '$descripcion' WHERE id_proveedor = '$id_proveedor'";
        }

        // Ejecutar la consulta
        if (mysqli_query($this->conexion, $consulta)) {
            return true; // La actualización fue exitosa
        } else {
            return false; // Hubo un error en la actualización
        }
    }

    private function procesarImagen($imagen) {
        $destino = __DIR__ . '/../public/img/proveedores-imagen/';
        $nombreImagen = basename($imagen['name']);
        $rutaImagen = $destino . $nombreImagen;
        move_uploaded_file($imagen['tmp_name'], $rutaImagen);
        return $nombreImagen;
    }
}

