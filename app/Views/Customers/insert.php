<?php
require_once __DIR__ . '/../../Models/ClienteModel.php';
require_once __DIR__ . '/../../Controllers/ClienteController.php';

?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Pedidos</title>
    <!-- Estilos de Bootstrap y Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
  

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Pedidos</title>
    <!-- Estilos de Bootstrap y Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>

        body {
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
       
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
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
    
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Cliente</h1>
        <div class="container">
        <div id="form-background">
            <form action="insert.php?da=Customers-2" method="POST" enctype="multipart/form-data" class="needs-validation"> 
           
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                </div>
                <input type="text" id="nombre" name="nombre" class="form-control" required placeholder="Ingresar nombre">
                <div class="invalid-feedback">Por favor ingrese su nombre.</div>
            </div>

            <div class="form-group">
                <label for="apellido">Apellido</label>
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                </div>
                <input type="text" id="apellido" name="apellido" class="form-control" required placeholder="Ingresar apellido">
                <div class="invalid-feedback">Por favor ingrese su apellido.</div>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                </div>
                <input type="email" id="email" name="email" class="form-control" required placeholder="Ingresar correo electrónico">
                <div class="invalid-feedback">Por favor ingrese su correo electrónico.</div>
            </div>

            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                </div>
                <input type="tel" id="telefono" name="telefono" class="form-control" required placeholder="Ingresar número de teléfono">
                <div class="invalid-feedback">Por favor ingrese su número de teléfono.</div>
            </div>

            <div class="form-group">
                <label for="direccion">Dirección</label>
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                </div>
                <input type="text" id="direccion" name="direccion" class="form-control" required placeholder="Ingresar dirección">
                <div class="invalid-feedback">Por favor ingrese su dirección.</div>
            </div>

            <div class="form-group">
                <label for="ciudad">Ciudad</label>
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-city"></i></span>
                </div>
                <input type="text" id="ciudad" name="ciudad" class="form-control" required placeholder="Ingresar ciudad">
                <div class="invalid-feedback">Por favor ingrese su ciudad.</div>
            </div>

            <div class="form-group">
                <label for="estado">Estado</label>
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-map"></i></span>
                </div>
                <select id="estado" name="estado" class="form-control" required>
                    <option value="">Seleccione una opción</option>
                    <option value="aprobado">Aprobado</option>
                    <option value="cancelado">Cancelado 2</option>
                    <option value="en stock">En stock</option>
                </select>
                <div class="invalid-feedback">Por favor seleccione su estado.</div>
            </div>

            <div class="form-group">
                <label for="codigo_postal">Código Postal</label>
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-mail-bulk"></i></span>
                </div>
                <input type="text" id="codigo_postal" name="codigo_postal" class="form-control" required placeholder="Ingresar código postal">
                <div class="invalid-feedback">Por favor ingrese su código postal.</div>
            </div>

            <div class="form-group">
                <label for="pais">País</label>
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-flag"></i></span>
                </div>
                <select id="pais" name="pais" class="form-control" required>
                    <option value="">Seleccione un país</option>
                    <option value="colombia">Colombia 1</option>
                    <option value="ecuador">Ecuador</option>
                    <option value="brazil">Brazil</option>
                    <option value="estados unidos">Estados Unidos</option>
                    <option value="españa">España</option>
                </select>
                <div class="invalid-feedback">Por favor seleccione su país.</div>
            </div>

            

            <div class="form-group">
                <label for="fecha_creacion">Fecha de Creación</label>
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                </div>
                <input type="date" id="fecha_creacion" name="fecha_creacion" class="form-control" required>
                <div class="invalid-feedback">Por favor ingrese la fecha de creación.</div>
            </div>

            <div class="form-group">
                <label for="fecha_modificacion">Fecha de Modificación</label>
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                </div>
                <input type="date" id="fecha_modificacion" name="fecha_modificacion" class="form-control">
                <div class="invalid-feedback">Por favor ingrese la fecha de modificación.</div>
            </div>

            <button type="submit" name="boton" class="btn btn-primary">Guardar</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>