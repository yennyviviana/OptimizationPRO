<?php
require 'Config/database.php';
session_start();



if($_POST)
{

  $nombre_usuario = $_POST['nombre_usuario'];
  $contrasena = $_POST['contrasena'];

  $sql = "SELECT * FROM usuarios WHERE  nombre_usuario='$nombre_usuario'";
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
         
          header("Location: dashboard.php");
        }
        elseif($row['tipo_usuario']==2)
        {
          header("Location: dashboard.php");
        }
        elseif($row['tipo_usuario']==3)
        {
          header("Location: dashboard.php");
        }
        elseif($row['tipo_usuario']==4)
        {
          header("Location: dashboard.php");
        }
        elseif($row['tipo_usuario']==5)
        {
          header("Location: dashboard.php");
        }
        elseif($row['tipo_usuario']==6)
        {
          header("Location: dashboard.php");
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


<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
   integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
   <title>Tu Página</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link href="public/css/style.css" type="text/css" rel="stylesheet">
    </head>
    <body>

        <div class="container">
    

    <div class="logo-container">
        <img src="public/img/1.jpg" width="1000" alt="imagen de de la ERP">
    </div>
      
    
			<form method="POST"  class="form-background  action="<?php echo $_SERVER['PHP_SELF']; ?>">
			
    
        <h2><i class="fa fa-sign-in-alt"></i><h2>Iniciar session</h2>

        <label for="nombre_usuario"><i class="fa fa-envelope"></i>Usuario:</label>
        <input type="text" id="nombre_usuario" name="nombre_usuario" required placeholder="usuario">

        <label for="contrasena"><i class="fa fa-lock"></i>Contraseña:</label>
        <input type="password" id="contrasena" name="contrasena" required placeholder="ingrese contraseña">

        <input type="submit" name="submit_login" value="Entrar">


<br>

        <!-- Enlace para recuperar contraseña -->
        <a href=""><i class="fa fa-question-circle"></i>¿Olvidaste tu contraseña?</a>

        <!-- Enlace para mostrar el formulario de registro -->
        <p>¿No tienes una cuenta? <a href="register.php" id="showRegister"><i class="fa fa-user-plus"></i>Regístrate aquí</a></p>
    </form>
</div>

  

    </body>
</html>