<?php

require_once __DIR__ . '/../../Models/ProductoModel.php';
require_once __DIR__ . '/../../Controllers/ProductoController.php';



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
                <label for="nombre_producto"><i class="fas fa-users"></i> Categoria:</label>
                <select id="nombre_producto" name="nombre_producto" required class="form-control">
                <option value="Televisor LED">Televisor LED</option>
        <option value="Lavadora automática">Lavadora automática</option>
        <option value="Smartphone de última generación">Smartphone de última generación</option>
        <option value="Ordenador portátil ultradelgado">Ordenador portátil ultradelgado</option>
        <option value="Auriculares inalámbricos">Auriculares inalámbricos</option>
        <option value="Cámara digital profesional">Cámara digital profesional</option>
        <option value="Consola de videojuegos de nueva generación">Consola de videojuegos de nueva generación</option>
        <option value="Altavoces Bluetooth impermeables">Altavoces Bluetooth impermeables</option>
        <option value="Tableta digital para diseño gráfico">Tableta digital para diseño gráfico</option>
        <option value="Impresora multifunción a color">Impresora multifunción a color</option>
                </select>
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
                <option value="entregado">Entregado</option>
                </select>
    </div>
                  
               

                <div class="form-group">
                    <label for="descripcion">Descripcion detallada</label>
                    <textarea id="detalles" name="detalles" class="form-control" required placeholder="detalles"></textarea>
                    <div class="invalid-feedback">Por favor ingrese la descripcion.</div>
                </div>


    
                <label for="categoria_productos"><i class="fas fa-users"></i> Categoria:</label>
                <select id="categoria_productos" name="categoria_productos" required class="form-control">
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

                <div class="form-group">
    <label for="archivos">Archivos</label>
    <input type="file" id="archivo" name="archivo" class="form-control-file" multiple required>
    <div class="invalid-feedback">Por favor seleccione al menos un archivo.</div>
</div>

                
<label for="id_proveedor">Proveedor:</label>
    <select name="id_proveedor" required>
        <?php foreach ($providers as $provider) { ?>
            <option value="<?php echo $provider['id_proveedor']; ?>">
                <?php echo $provider['nombre_empresa']; ?>
            </option>
        <?php } ?>
    </select><br>
    
    <button type="submit" name="boton" class="btn btn-primary">Guardar</button>
            </form>
        </div>
    </div>

    <script>
        // Inicializamos CKEditor en el textarea con ID "descripcion"
        CKEDITOR.replace('detalles');
       
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
