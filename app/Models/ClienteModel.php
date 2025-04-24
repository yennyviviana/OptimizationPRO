<?php
class ClienteModel {
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

    public function insertarCliente($nombre, $apellido, $email, $documento_identidad, $tipo_documento, $telefono, $direccion, $ciudad, $estado, $codigo_postal, $pais, $notas, $fecha_creacion, $fecha_modificacion) {
        $nombre = mysqli_real_escape_string($this->conexion, $nombre);
        $apellido = mysqli_real_escape_string($this->conexion, $apellido);
        $email = mysqli_real_escape_string($this->conexion, $email);
        $documento_identidad = mysqli_real_escape_string($this->conexion, $documento_identidad);
        $tipo_documento = mysqli_real_escape_string($this->conexion, $tipo_documento);
        $telefono = mysqli_real_escape_string($this->conexion, $telefono);
        $direccion = mysqli_real_escape_string($this->conexion, $direccion);
        $ciudad = mysqli_real_escape_string($this->conexion, $ciudad);
        $estado = mysqli_real_escape_string($this->conexion, $estado);
        $codigo_postal = mysqli_real_escape_string($this->conexion, $codigo_postal);
        $pais = mysqli_real_escape_string($this->conexion, $pais);
        $notas = mysqli_real_escape_string($this->conexion, $notas); 
        $fecha_creacion = mysqli_real_escape_string($this->conexion, $fecha_creacion);
        $fecha_modificacion = mysqli_real_escape_string($this->conexion, $fecha_modificacion);

        $consulta = "INSERT INTO clientes (nombre, apellido, email, documento_identidad, tipo_documento, telefono, direccion, ciudad, estado, codigo_postal, pais, notas, fecha_creacion, fecha_modificacion) 
        VALUES ('$nombre', '$apellido', '$email', '$documento_identidad', '$tipo_documento', '$telefono', '$direccion', '$ciudad', '$estado', '$codigo_postal', '$pais', '$notas', '$fecha_creacion', '$fecha_modificacion')";

        if (mysqli_query($this->conexion, $consulta)) {
            return true;
        } else {
            return false;
        }
    }

    public function ActualizarCliente($id_cliente, $nombre, $apellido, $email, $documento_identidad, $tipo_documento, $telefono, $direccion, $ciudad, $estado, $codigo_postal, $pais, $notas, $fecha_creacion, $fecha_modificacion) {
        $nombre = mysqli_real_escape_string($this->conexion, $nombre);
        $apellido = mysqli_real_escape_string($this->conexion, $apellido);
        $email = mysqli_real_escape_string($this->conexion, $email);
        $documento_identidad = mysqli_real_escape_string($this->conexion, $documento_identidad);
        $tipo_documento = mysqli_real_escape_string($this->conexion, $tipo_documento);
        $telefono = mysqli_real_escape_string($this->conexion, $telefono);
        $direccion = mysqli_real_escape_string($this->conexion, $direccion);
        $ciudad = mysqli_real_escape_string($this->conexion, $ciudad);
        $estado = mysqli_real_escape_string($this->conexion, $estado);
        $codigo_postal = mysqli_real_escape_string($this->conexion, $codigo_postal);
        $pais = mysqli_real_escape_string($this->conexion, $pais);
        $notas = mysqli_real_escape_string($this->conexion, $notas); 
        $fecha_creacion = mysqli_real_escape_string($this->conexion, $fecha_creacion);
        $fecha_modificacion = mysqli_real_escape_string($this->conexion, $fecha_modificacion);

        $consulta = "UPDATE clientes SET 
            nombre='$nombre', 
            apellido='$apellido', 
            email='$email', 
            documento_identidad='$documento_identidad', 
            tipo_documento='$tipo_documento', 
            telefono='$telefono', 
            direccion='$direccion', 
            ciudad='$ciudad', 
            estado='$estado', 
            codigo_postal='$codigo_postal', 
            pais='$pais', 
            notas='$notas', 
            fecha_creacion='$fecha_creacion', 
            fecha_modificacion='$fecha_modificacion' 
        WHERE id_cliente='$id_cliente'";

        if (mysqli_query($this->conexion, $consulta)) {
            return true;
        } else {
            return false;
        }
    }
}
