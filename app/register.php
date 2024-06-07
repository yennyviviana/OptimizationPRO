<?php

date_default_timezone_set("America/Bogota");
require_once('Config/database.php');


// If form submitted, insert values into the database
if (isset($_REQUEST['nombre_usuario'])){
    $nombre_usuario = stripslashes($_POST['nombre_usuario']); // removes backslashes
    $apellido_usuario = stripslashes($_POST['apellido_usuario']);
    $correo_electronico = stripslashes($_POST['correo_electronico']);
    $contrasena = stripslashes($_POST['contrasena']);
    $tipo_usuario = 9;


    // Escapar caracteres especiales para evitar SQL Injection
    if (isset($_REQUEST['nombre_usuario'])){
    $nombre_usuario = mysqli_real_escape_string($mysqli, $nombre_usuario);
    $apellido_usuario = mysqli_real_escape_string($mysqli, $apellido_usuario);
    $correo_electronico = mysqli_real_escape_string($mysqli, $correo_electronico);
    $contrasena = mysqli_real_escape_string($mysqli, $contrasena);
    $tipo_usuario = 9;

    

    // Check if the username already exists in the database
    $check_query = "SELECT * FROM usuarios WHERE nombre_usuario = '$nombre_usuario'";
    $check_result = mysqli_query($mysqli, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
      // If the username already exists, show a message
      echo "<center><p style='border-radius: 20px;box-shadow: 10px 10px 5px #c68615; font-size: 23px; font-weight: bold;'>El usuario ya está registrado. Por favor, elija otro nombre de usuario.</p></center>";
  } else {
      // If the username doesn't exist, proceed with the registration
      $query = "INSERT INTO `usuarios` (nombre_usuario, apellido_usuario, correo_electronico, contrasena, tipo_usuario) VALUES ('$nombre_usuario', '$apellido_usuario', '$correo_electronico',  '"  .  sha1($contrasena) ."',  '$tipo_usuario')";
      $result = mysqli_query($mysqli, $query);

  }

    }
} else {

?>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registro de Usuario</title>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome CSS -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        <link href="fontawesome/css/all.css" rel="stylesheet">
        <script src="https://kit.fontawesome.com/fed2435e21.js" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <!-- Custom CSS -->
        <link href="public/css/style.css" type="text/css" rel="stylesheet">
        <style>
        .responsive {
            max-width: 100%;
            height: auto;
        }
    </style>
    <script>
        function ordenarSelect(id_componente)
        {
            var selectToSort = jQuery('#' + id_componente);
            var optionActual = selectToSort.val();
            selectToSort.html(selectToSort.children('option').sort(function (a, b) {
                return a.text === b.text ? 0 : a.text < b.text ? -1 : 1;
            })).val(optionActual);
        }
        $(document).ready(function () {
            ordenarSelect('selectIE');
        });
    </script>
    </head>
    <body>

    <form action="" method="POST">

        <h1><i class="fas fa-users"></i> NUEVO USUARIO</h1>
            <p><b><font size="3" color="#c68615">*Datos obligatorios</font></b></p>
            
                   
                        <label for="nombre_usuario">* Nombre:</label>
                        <input type="text" name="nombre_usuario" class="form-control" id="nombre_usuario" required>
                    </div>
                </div>
                <div class="form-group">
                <label for="apellido_usuario">* Apellido:</label>
                <input type="text" name="apellido_usuario" class="form-control" id="apellido_usuario" required>
            </div>
               </div>
            

            <div class="form-group">
                <label for="correo_electronico">* Correo Electrónico:</label>
                <input type="email" name="correo_electronico" class="form-control" id="correo_electronico" required>
            </div>
               </div>
               <div class="form-group">
                <label for="contrasena">* Contrasena:</label>
                <input type="password" name="contrasena" class="form-control" id="contrasena" required>
            </div>
               </div>
            </div>
            <div class="form-group">
                <label for="tipo_usuario">* Tipo de Usuario:</label>
                <select name="tipo_usuario" id="tipo_usuario" class="form-control" required>
                    <option value="9">Administrador</option>
                    <option value="2">Cliente</option>
                    <option value="3">Usuario</option>
                </select>
            </div>

            <button type="submit" class="btn btn-warning">
                <span class="spinner-border spinner-border-sm"></span>
                REGISTRAR USUARIO
            </button>
            <button type="reset" class="btn btn-dark" onclick="history.back();">
                <img src="public/img/atras.png" width="27" height="27"> REGRESAR
            </button>
        </form>
    </div>
    </div>

   
    </body>
    </html>

    <?php
    }
?>
