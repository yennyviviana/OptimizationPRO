<?php

require 'Config/database.php';
require 'Config/session.php';

session_start();


if($_POST)
{

$nombre_usuario = $_POST['nombre_usuario'];
 $contrasena = $_POST['contrasena'];

$sql = "SELECT * FROM usuarios WHERE nombre_usuario='$nombre_usuario'";
//echo $sql;
 $resultado = $mysqli->query($sql);
 $num = $resultado->num_rows;

if($num>0)
 {
 $row = $resultado->fetch_assoc();
 $password_bd = $row['contrasena'];


$password_contrasena = sha1($contrasena);


if($password_bd == $password_contrasena)
 {
 // Establecer variables de sesión
 $_SESSION['id_usuario'] = $row['id_usuario'];
 $_SESSION['nombre_usuario'] = $row['nombre_usuario'];
 $_SESSION['apellido_usuario'] = $row['apellido_usuario'];
 $_SESSION['correo_electronico'] = $row['correo_electronico'];
 $_SESSION['tipo_usuario'] = $row['tipo_usuario'];

if($row['tipo_usuario']==9)
 {
 
header("Location: main.php");
 }
 elseif($row['tipo_usuario']==2)
 {
 header("Location: main.php");
 }
 elseif($row['tipo_usuario']==3)
 {
 header("Location: main.php");
 }
 elseif($row['tipo_usuario']==4)
 {
 header("Location: main.php");
 }
 elseif($row['tipo_usuario']==5)
 {
 header("Location: main.php");
 }
 elseif($row['tipo_usuario']==6)
 {
 header("Location: main.php");
 }
 else
 {
 
header("Location: index.php");
 }
 }else
 {
 echo "La contraseña no coincide";
 }
 }else
 {
 echo "NO existe usuario";
 }
}
?> 
