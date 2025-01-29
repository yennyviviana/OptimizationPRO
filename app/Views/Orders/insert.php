<?php

require_once __DIR__ . '/../../Models/PedidoModel.php';
require_once __DIR__ . '/../../Controllers/PedidoController.php';



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
    <script src="https://cdn.ckeditor.com/4.24.0/standard/ckeditor.js"></script>
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
            <form action="insert.php?da=Orders-2" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                <div class="form-group">
                    <label for="nombre_pedido">Nombre</label>
                    <input type="text" id="nombre_pedido" name="nombre_pedido" class="form-control" required placeholder="Ingresar nombre pedido">
                    <div class="invalid-feedback"> nombre del pedido.</div>
                </div>


                <div class="form-group">
                    <label for="precio">Precio</label>
                    <input type="number" id="precio" name="precio" class="form-control" required placeholder="Precio">
                    <div class="invalid-feedback">Por favor ingrese el precio</div>
                </div>

                <label for="estado"><i class="fas fa-users"></i> Estado:</label>
                <select id="estado" name="estado" required class="form-control">
                    <option value="">Seleccione una opcion</option>
                    <option value="aprobado">Aprobado</option>
                    <option value="cancelado">Cancelado</option>
                    <option value="en stock">en stock</option>
                    option value="entregado">Entregado</option>

                  
                    <div class="form-group">
                    <label for="direccion">Direccion</label>
                    <input type="text" id="direccion" name="direccion" class="form-control" required placeholder="Ingresar direccion">
                    <div class="invalid-feedback">Por favor ingrese la direccion.</div>
                </div>


                <div class="form-group">
                    <label for="descripcion">Descripcion</label>
                    <textarea id="descripcion" name="descripcion" class="form-control" required placeholder="Descripcion"></textarea>
                    <div class="invalid-feedback">Por favor ingrese la descripcion.</div>
                </div>


    
                <div class="form-group">
                    <label for="direccion">Numero seguimiento</label>
                    <input type="number" id="numero_seguimiento" name="numero_seguimiento" class="form-control" required placeholder="Ingresar numero seguimiento">
                    <div class="invalid-feedback">Numero de seguimiento.</div>
                </div>



    <div class="form-group">
            <label for="informacion_pedido">Información:</label>
            <!-- Agrega el textarea para la información adicional -->
            <textarea id="informacion_pedido" name="informacion_pedido" class="form-control" required placeholder="Información"></textarea>
            <div class="invalid-feedback">Por favor ingrese información.</div>



            <label for="metodo_pago"><i class="fas fa-users"></i> Metodo Pago:</label>
                <select id="metodo_pago" name="metodo_pago" required class="form-control">
                    <option value="">Seleccione una opcion</option>
                    <option value="credito">Credito</option>
                    <option value="Paypal">Paypal</option>
                    <option value="transfarencia">Transferencia</option>
                </select>

            

                <div class="form-group">
    <label for="archivos">Archivos</label>
    <input type="file" id="archivo" name="archivo" class="form-control-file" required>
    <div class="invalid-feedback">Por favor seleccione al menos un archivo.</div>
</div>

                
                <div class="form-group">
        <label for="fecha_pedido">Fecha del pedido:</label>
        <input type="date" id="fecha_pedido" name="fecha_pedido" class="form-control" min="0" required>
    </div>

          
    <div class="form-group">
        <label for="fecha_entrega">Fecha de entrega:</label>
        <input type="date" id="fecha_entrega" name="fecha_entrega" class="form-control" min="0" required>
    </div>

    <div class="form-group">
    <label>Tiempo transcurrido (Días y Horas):</label>
    <span id="tiempo_entrega_horas" name="tiempo_entrega_horas" class="form-control"></span>
</div>
    
    <button type="submit" name="boton" class="btn btn-primary">Guardar</button>
            </form>
        </div>
    </div>

    <script>
        // Inicializamos CKEditor en el textarea con ID "descripcion"
        CKEDITOR.replace('descripcion');
       
    </script>


<script>
   document.getElementById('fecha_entrega').addEventListener('change', function() {
    var fechaEntrega = new Date(this.value); // Obtener la fecha de entrega seleccionada
    var fechaPedido = new Date(); // Obtener la fecha actual
    var  tiempo_entrega_horas = fechaEntrega - fechaPedido; // Calcular la diferencia en milisegundos

    // Convertir la diferencia de milisegundos a días y horas
    var dias = Math.floor(tiempo_entrega_horas / (1000 * 60 * 60 * 24));
    var horas = Math.floor((tiempo_entrega_horas % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));

    // Mostrar el tiempo transcurrido en el span correspondiente
    document.getElementById('tiempo_entrega_horas').textContent = dias + " días y " + horas + " horas";
});

</script>
 

</body>
</html>
