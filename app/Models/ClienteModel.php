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

    public function insertarCliente($nombre, $apellido, $email, $telefono, $direccion, $ciudad, $estado, $codigo_postal, $pais, $fecha_creacion, $fecha_modificacion) {
        // Escapa las variables para prevenir inyección SQL....
        $nombre = mysqli_real_escape_string($this->conexion, $nombre);
        $apellido = mysqli_real_escape_string($this->conexion, $apellido);
        $email = mysqli_real_escape_string($this->conexion, $email);
        $telefono = mysqli_real_escape_string($this->conexion, $telefono);
        $direccion = mysqli_real_escape_string($this->conexion, $direccion);
        $ciudad = mysqli_real_escape_string($this->conexion, $ciudad);
        $estado = mysqli_real_escape_string($this->conexion, $estado);
        $codigo_postal = mysqli_real_escape_string($this->conexion, $codigo_postal);
        $pais = mysqli_real_escape_string($this->conexion, $pais);
        $fecha_creacion = mysqli_real_escape_string($this->conexion, $fecha_creacion);
        $fecha_modificacion = mysqli_real_escape_string($this->conexion, $fecha_modificacion);

        // Preparar la consulta SQL.......
        $consulta = "INSERT INTO clientes (nombre, apellido, email, telefono, direccion, ciudad, estado, codigo_postal, pais, fecha_creacion, fecha_modificacion) 
                     VALUES ('$nombre', '$apellido', '$email', '$telefono', '$direccion', '$ciudad', '$estado', '$codigo_postal', '$pais', '$fecha_creacion', '$fecha_modificacion')";

        // Ejecutar la consulta.....
        if (mysqli_query($this->conexion, $consulta)) {
            return true; // La inserción fue exitosa
        } else {
            return false; // Hubo un error en la inserción......
        }
    }


    public function ActualizarCliente($id_cliente,$nombre, $apellido, $email, $telefono, 
    $direccion, $ciudad, $estado, $codigo_postal, $pais, $fecha_creacion, $fecha_modificacion) {
        // Escapa las variables para prevenir inyección SQL.....
        $nombre = mysqli_real_escape_string($this->conexion, $nombre);
        $apellido = mysqli_real_escape_string($this->conexion, $apellido);
        $email = mysqli_real_escape_string($this->conexion, $email);
        $telefono = mysqli_real_escape_string($this->conexion, $telefono);
        $direccion = mysqli_real_escape_string($this->conexion, $direccion);
        $ciudad = mysqli_real_escape_string($this->conexion, $ciudad);
        $estado = mysqli_real_escape_string($this->conexion, $estado);
        $codigo_postal = mysqli_real_escape_string($this->conexion, $codigo_postal);
        $pais = mysqli_real_escape_string($this->conexion, $pais);
        $fecha_creacion = mysqli_real_escape_string($this->conexion, $fecha_creacion);
        $fecha_modificacion = mysqli_real_escape_string($this->conexion, $fecha_modificacion);

 

        // Actualiza sin manejar imágenes o archivos......
 $consulta = "UPDATE clientes SET nombre= '$nombre', apellido = '$apellido', email= '$email',telefono = 
'$telefono', direccion = '$direccion',  ciudad = '$ciudad', estado = '$estado', codigo_postal = 
'$codigo_postal', pais = '$pais', fecha_creacion= '$fecha_creacion, fecha_modificacion= 
'$fecha_modificacion WHERE id_cliente = '$id_cliente'";

// Ejecutar la consulta
if (mysqli_query($this->conexion, $consulta)) {
    return true; 
} else {
    return false; 
}


}
}

    

