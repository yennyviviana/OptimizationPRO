<?php

require_once __DIR__ . '/../../Models/ProyectoModel.php';
require_once __DIR__ . '/../../Controllers/ProyectoController.php';



?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD pedidos</title>
    <!-- Agregamos los estilos de Bootstrap para los iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Incluimos el CSS de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        #form-background {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        /* Ajuste de estilos para el editor CKEditor */
        .ck-editor__editable {
            min-height: 150px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div id="form-background">
            <form action="insert.php?da=Financials-2" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
               

            <div class="form-group">
                    <label for="">Nombre proyecto</label>
                    <textarea id="nombre_proyecto" name="nombre_proyecto" class="form-control" required placeholder="nombre_proyecto"></textarea>
                    <div class="invalid-feedback">Por favor ingrese  el nombre proyecto.</div>
                </div>


                <div class="form-group">
                    <label for="descripcion">Descripcion</label>
                    <textarea id="descripcion" name="descripcion" class="form-control" required placeholder="descripcion"></textarea>
                    <div class="invalid-feedback">Por favor ingrese la descripcion.</div>
                </div>



                <div class="form-group">
        <label for="fecha_adquisicion">Fecha inicio:</label>
        <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" min="0" required>
    </div>

          
    <div class="form-group">
        <label for="fecha_fin">Fecha fin:</label>
        <input type="date" id="fecha_fin" name="fecha_fin" class="form-control" min="0" required>
    </div>


    <div class="form-group">
                <label for="estado"><i class="fas fa-toggle-on"></i> Estado:</label>
                <select id="estado" name="estado" required class="form-control">
                    <option value="pendiente">Pediente</option>
                    <option value="en progreso">En progreso</option>
                    <option value="completado">Completado</option>
                </select>
            </div>
                  


            <div class="form-group">
    <label for="archivos">Imagen</label>
    <input type="file" id="imagen_proyecto" name="imagen_proyecto" class="form-control-file" required>
    <div class="invalid-feedback">Por favor seleccione al menos una imagen proyecto.</div>
</div>


    
    <button type="submit" name="boton" class="btn btn-primary">Guardar</button>
            </form>
        </div>
    </div>

   


</body>
</html>
