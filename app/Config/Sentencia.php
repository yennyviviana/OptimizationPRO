<?php

class  Sentencia{

	public  $sentencia;
    public  $conexion;
	public  $tabla;
	public  $resultado;

	function __construct($sentencia, $conexion, $resultado,$tabla) {
	
		$this->sentencia = $sentencia;
		$this->conexion = $conexion;
		$this->tabla = $tabla;
		$this->resultado = $resultado;
	
	}
	
	//ejecuta la consulta sql......
	public function con() {
		$this->resultado = mysqli_query($this->conexion, $this->sentencia) or die('No se ejecuto la consulta a la tabla '. $this->tabla);
	}
	
	//insertar, editar y borrar
	/*public function insertarBdo() {
		mysqli_query($this->conexion, $this->sentencia) or die('no se inserto en la tabla'. $this->tabla);	
	}*/

}
