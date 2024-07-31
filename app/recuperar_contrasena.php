
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
   integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
   <title>OptimizacionPro</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link href="public/css/style.css" type="text/css" rel="stylesheet">
    </head>
    <body>

        <div class="container">
    

    <div class="logo-container">
        <img src="public/img/logo.png" width="1000" height="600" alt="imagen de de la ERP">
    </div>
      
    
			<form method="POST"  class="form-background  action="<?php echo $_SERVER['PHP_SELF']; ?>">
			
    
        <h2><i class="fa fa-sign-in-alt"></i><h2>Iniciar session</h2>

        <label for="correo_electronico"><i class="fa fa-envelope"></i>correo electronico:</label>
        <input type="email" id="correo_electronico" name="correo_electronico" required placeholder="email">

        <label for="contrasena"><i class="fa fa-lock"></i>Contraseña:</label>
        <input type="password" id="contrasena" name="contrasena" required placeholder="ingrese contraseña">

        <input type="submit" name="submit_login" value="Entrar">

