<?php

require_once __DIR__ . '/../../Models/ProveedorModel.php';
require_once __DIR__ . '/../../Controllers/ProveedorController.php';

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
    <!-- Incluimos el CSS de CKEditor -->
    <script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>
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
            <form action="insert.php?da=2" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
               
            <div class="form-group">
                    <label for="nombre_empresa">Empresa:</label>
                    <input type="text" id="nombre_empresa" name="nombre_empresa" class="form-control" required placeholder="Ingresar nombre empresa">
                    <div class="invalid-feedback"> nombre de la empresa.</div>
                </div>
    
                <div class="form-group">
                    <label for="direccion">Direccion</label>
                    <input type="text" id="direccion" name="direccion" class="form-control" required placeholder="Ingresar direccion">
                    <div class="invalid-feedback">Por favor ingrese la direccion.</div>
                </div>
    
                <div class="form-group">
                    <label for="direccion">Telefono</label>
                    <input type="text" id="telefono" name="telefono" class="form-control" required placeholder="Ingresar telefono">
                    <div class="invalid-feedback">Por favor ingrese el telefono.</div>
                
    </div>

    <div class="form-group">
                <label for="correo_electronico">* Correo Electrónico:</label>
                <input type="email" name="correo_electronico" class="form-control" id="correo_electronico" required>
            </div>
               

               <label for="lista_productos"><i class="fas fa-users"></i> Productos:</label>
                <select id="lista_productos" name="lista_productos" required class="form-control">
                    <option value="producto 1">Producto 1</option>
                    <option value="producto 2">Producto 2</option>
                    <option value="producto 3">Producto 3</option>
                    <option value="producto 4">Producto 4</option>
                    <option value="producto 5">Producto 5</option>
                  <!--- mas opciones -->
                  <option value="producto 5">Producto 5</option>
                  <option value="producto 6">Producto 6</option>
                  <option value="producto 7">Producto 7</option>
                  <option value="producto 8">Producto 8</option>
                  <option value="producto 9">Producto 9</option>
                  <option value="producto 10">Producto 10</option>
                </select>


                <label for="condiciones_pago"><i class="fas fa-users"></i> Condicion de Pago:</label>
                <select id="condiciones_pago" name="condiciones_pago" required class="form-control">
                    <option value="">Seleccione una opcion</option>
                    <option value="pago por adelantado">Pago por adelantado</option>
                    <option value="pago contra entrega ">Pago contra entrega </option>
                    <option value="pago a crédito ">Pago a crédito </option>
                    <option value="consignación ">Consignación</option>
                  
                </select>


                <label for="metodo_pago"><i class="fas fa-users"></i> Metodo Pago:</label>
                <select id="metodo_pago" name="metodo_pago" required class="form-control">
                    <option value="">Seleccione una opcion</option>
                    <option value="credito">Credito</option>
                    <option value="Paypal">Paypal</option>
                    <option value="transfarencia">Transferencia</option>
                </select>

                
                <div class="form-group">
                    <label for="descripcion">Descripcion</label>
                    <textarea id="descripcion" name="descripcion" class="form-control" required placeholder="Descripcion"></textarea>
                    <div class="invalid-feedback">Por favor ingrese la descripcion.</div>
                </div>



        <div class="form-group">
    <label for="archivos">archivo</label>
    <input type="file" id="archivo" name="archivo" class="form-control-file" required>
    <div class="invalid-feedback"></div>
</div>


<button type="submit" name="boton" class="btn btn-success">Guardar</button>
            </form>
        </div>
    </div>

<script>
        // Inicializamos CKEditor en el textarea con ID "descripcion"
        CKEDITOR.replace('descripcion');
         // Inicializa CKEditor en el textarea con ID "informacion"
         CKEDITOR.replace('informacion');
    </script>