<?php



define('db_host', 'localhost');
define('db_username', 'root');
define('db_password','');
define('db_dbname', 'sofware_erp');



//conectar Mysql y selecciona base de datos.
$mysqli = mysqli_connect(db_host,db_username,db_password,db_dbname);


//verificar que la conexion sea exitosa
if(!$mysqli){
    die('Error al conectarse a MYSQL' . $mysqli_connect_error());
}


//establecer juego de caracteres UTF-8
mysqli_set_charset($mysqli,'utf8')


 
/*$mysqli = new mysqli('localhost', 'root', '', 'sofware_erp');
$mysqli->set_charset("utf8");
if($mysqli->connect_error){
    
    die('Error en la conexion' . $mysqli->connect_error);
    
}
?>*/





?>



