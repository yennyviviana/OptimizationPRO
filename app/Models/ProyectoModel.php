<?php
class ProyectoModel {
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

    public function insertarProyecto($nombre_proyecto, $descripcion, $fecha_inicio, $fecha_fin, $estado, $id_usuario, $imagen_proyecto) {
        // Escapar los datos para evitar inyecciones SQL
        $nombre_proyecto = mysqli_real_escape_string($this->conexion, $nombre_proyecto);
        $descripcion = mysqli_real_escape_string($this->conexion, $descripcion);
        $fecha_inicio = mysqli_real_escape_string($this->conexion, $fecha_inicio);
        $fecha_fin = mysqli_real_escape_string($this->conexion, $fecha_fin);
        $estado = mysqli_real_escape_string($this->conexion, $estado);
        $id_usuario = mysqli_real_escape_string($this->conexion, $id_usuario);

        // Verificar si el usuario existe antes de insertar
        $consulta_usuario = "SELECT * FROM usuarios WHERE id_usuario = $id_usuario";
        $resultado_usuario = mysqli_query($this->conexion, $consulta_usuario);
        if (mysqli_num_rows($resultado_usuario) == 0) {
            return false; // El usuario no existe
        }

        // Procesar la imagen si se proporciona
        $nombreArchivo = '';
        if (is_array($imagen_proyecto) && $imagen_proyecto['error'] === UPLOAD_ERR_OK) {
            $nombreArchivo = $this->procesarImagen($imagen_proyecto);
        }

        // Preparar la consulta SQL
        $consulta = "INSERT INTO proyectos (nombre_proyecto, descripcion, fecha_inicio, fecha_fin, estado, id_usuario, imagen_proyecto) 
                     VALUES ('$nombre_proyecto', '$descripcion', '$fecha_inicio', '$fecha_fin', '$estado', '$id_usuario', '$nombreArchivo')";

        // Ejecutar la consulta
        if (mysqli_query($this->conexion, $consulta)) {
            return true; // La inserción fue exitosa
        } else {
            return false; // Hubo un error en la inserción
        }
    }

    private function procesarImagen($imagen) {
        $destino = __DIR__ . '/../public/img/proyecto/';
        $nombreImagen = basename($imagen['name']);
        $rutaImagen = $destino . $nombreImagen;

        // Mover la imagen al destino
        if (move_uploaded_file($imagen['tmp_name'], $rutaImagen)) {
            return $nombreImagen;
        } else {
            return ''; // En caso de error al mover el archivo
        }
    }
}
?>
