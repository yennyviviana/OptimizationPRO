
<?php
class EmpleadoModel {
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
    
    public function insertarEmpleado($nombre, $cargo, $tipo_contrato, $fecha_contratacion, $horas_trabajo, $tarifa_hora, $salario, $estado, $departamento,$tipo_documento, $documento_identidad, $direccion, $ciudad,$pais,  $telefono, $correo, $fecha_nacimiento,$genero, $estado_civil, $documentacion, $descripcion, $fecha_creacion, $fecha_modificacion) {
        // Validar los archivos de imagen y documentación
        if ($Imagen === null || $documentacion === null) {
            echo "Error: Los archivos de imagen y/o documentación no pueden ser nulos.";
            return false;
        }
    
        // Escapar las variables para prevenir inyección SQL
        $nombre = mysqli_real_escape_string($this->conexion, $nombre);
        $cargo = mysqli_real_escape_string($this->conexion, $cargo);
        $estado = mysqli_real_escape_string($this->conexion, $estado);
        $departamento = mysqli_real_escape_string($this->conexion, $departamento);
        $tipo_documento = mysqli_real_escape_string($this->conexion, $tipo_documento);
        $documento_identidad = mysqli_real_escape_string($this->conexion, $documento_identidad);
        $direccion = mysqli_real_escape_string($this->conexion, $direccion);
        $telefono = mysqli_real_escape_string($this->conexion, $telefono);
      
    
      
    
        // Procesar el archivo de documentación
        $nombreArchivoDocumento = $this->procesarArchivo($documento_identidad, 'documento');

    
        // Preparar la consulta SQL para insertar el empleado.......
        $consulta = "INSERT INTO empleados (nombre, cargo, tipo_contrato, fecha_contratacion, horas_trabajo, tarifa_hora, salario, estado, departamento,tipo_documento, documento_identidad, direccion, ciudad,pais, telefono, correo, fecha_nacimiento,genero, estado_civil, documentacion, descripcion, fecha_creacion, fecha_modificacion) 
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
        // Preparar la declaración
        $stmt = $this->conexion->prepare($consulta);
        if (!$stmt) {
            echo "Error en la preparación de la consulta: " . $this->conexion->error;
            return false;
        }
    
        // Vincular los parámetros
        $stmt->bind_param("sssddssssssssssss",$nombre, $cargo, $tipo_contrato, $fecha_contratacion, $horas_trabajo, $tarifa_hora, $salario, $estado, $departamento,$tipo_documento, $documento_identidad, $direccion, $ciudad,$pais,  $telefono, $correo, $fecha_nacimiento,$genero, $estado_civil, $Imagen, $documentacion, $descripcion, $$fecha_creacion, $fecha_modificacion);
    
        // Ejecutar la consulta
        if ($stmt->execute()) {
            return true; // La inserción fue exitosa
        } else {
            // Hubo un error en la inserción, eliminar los archivos subidos
            $this->eliminarArchivos($nombreArchivoImagen, $nombreArchivoDocumento);
            echo "Error al insertar el empleado: " . $stmt->error;
            return false;
        }
    }
    
    private function procesarArchivo($archivo, $tipo) {
        // Verificar que el archivo no sea nulo y contenga las claves necesarias
        if ($archivo === null || !isset($archivo['error']) || !isset($archivo['name']) || !isset($archivo['tmp_name'])) {
            return false; 
        }
    
        $directorioBase = __DIR__ . '/../public/files/uploads/empleados/';
    
        // Crear el directorio si no existe
        if (!is_dir($directorioBase)) {
            mkdir($directorioBase, 0777, true);
        }
    
        $nombreArchivo = '';
        if ($archivo['error'] === UPLOAD_ERR_OK) {
            $extension = pathinfo($archivo['name'], PATHINFO_EXTENSION);
            $nombreArchivo = uniqid('empleado_') . '_' . $tipo . '.' . $extension;
            $rutaArchivo = $directorioBase . $nombreArchivo;
    
            // Mover el archivo al directorio de destino
            if (move_uploaded_file($archivo['tmp_name'], $rutaArchivo)) {
                return $nombreArchivo;
            } else {
                return false; 
            }
        } else {
            return false; 
        }
    }
    
    private function eliminarArchivos($nombreArchivoImagen, $nombreArchivoDocumento) {
        $directorioBase = __DIR__ .'/../public/img/uploads/empleados/';
    
        // Eliminar la imagen de perfil si existe
        if ($nombreArchivoImagen) {
            $rutaImagen = $directorioBase . $nombreArchivoImagen;
            if (file_exists($rutaImagen)) {
                unlink($rutaImagen); 
            }
        }
    
        // Eliminar el archivo de documentación si existe
        if ($nombreArchivoDocumento) {
            $rutaDocumento = $directorioBase . $nombreArchivoDocumento;
            if (file_exists($rutaDocumento)) {
                unlink($rutaDocumento); 
            }
        }
    }
}


 
