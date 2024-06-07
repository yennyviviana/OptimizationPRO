<?php
class Sentencia {

    private $sentencia;
    private $resultado;
    private $conexion;
    private $consulta;
    private $tabla;

    public function __construct($consulta, $conexion, $sentencia = null, $resultado = null, $tabla = null) {
        $this->consulta = $consulta;
        $this->conexion = $conexion;
        $this->sentencia = $sentencia;
        $this->resultado = $resultado;
        $this->tabla = $tabla;
    }

    public function ejecutarConsulta() {
        // Asegurémonos de que la conexión no sea nula antes de ejecutar la consulta
        if ($this->conexion !== null) {
            try {
                $this->sentencia = $this->conexion->prepare($this->consulta);
                $this->sentencia->execute();
                $this->resultado = $this->sentencia->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                die('Error al ejecutar la consulta: ' . $e->getMessage());
            }
        } else {
            // Manejar la falta de conexión
            echo "Error: No hay conexión a la base de datos.";
        }
    }

    public function get_result() {
        return $this->resultado;
    }

    public function insertarBdo() {
        // Preparar la consulta SQL
        $stmt = $this->conexion->prepare($this->consulta);
    
        // Verificar si la preparación de la consulta fue exitosa
        if (!$stmt) {
            die('Error al preparar la consulta en la tabla ' . $this->tabla . ': ' . $this->conexion->error);
        }
    
        // Ejecutar la consulta
        $resultado = $stmt->execute();
    
        // Verificar si la ejecución de la consulta fue exitosa
        if (!$resultado) {
            die('Error al ejecutar la operación en la tabla ' . $this->tabla . ': ' . $this->conexion->error);
        }
    }
    

}
?>
