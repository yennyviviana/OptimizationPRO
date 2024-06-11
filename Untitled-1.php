<?php
require_once('../../Config/Sentencia.php');
session_start();


// pregunta si el boton se presiono................
if (isset($_POST['submit'])) {

    // Verifica si el usuario ha iniciado sesión
    if (!isset($_SESSION['id_usuario'])) {



         //capturar los datos enviados POST.............
        
         $nombre_pedido = $_POST['nombre_pedido	'];
         $Tipo_pedido = $_POST['Tipo_pedido']; 
         $direccion = $_POST['direccion']; 
         $ciudad = $_POST['ciudad']; 
         $estado_provincia = $_POST['estado_provincia']; 
         $codigo_postal = $_POST['codigo_postal']; 
         $pais = $_POST['pais']; 
         $estado_pedido = $_POST['estado_pedido']; 
         $descripcion_producto = $_POST['descripcion_producto']; 
         $cantidad = $_POST['cantidad']; 
        // $nombre_pedido = $_POST['id_producto']; 
         $precio_unitario = $_POST['precio_unitario']; 
         $subtotal = $_POST['subtotal']; 
         $total_producto = $_POST['total_producto']; 
         $metodo_pago = $_POST['metodo_pago']; 
         $estado_pago =  $_POST['estado_pago'];
        /// $nombre_pedido = $_POST['id_cliente']; 
        // $nombre_pedido = $_POST['id_envio'];
         $metodo_envio = $_POST['metodo_envio'];
         $fecha_estimada_entrega =  date('Y-m-d h:i:s');
         $numero_rastreo = $_POST['numero_rastreo'];
         $tipo_descuento = $_POST['tipo_descuento'];
         $monto_descuento = $_POST['monto_descuento'];
         $tipo_impuesto = $_POST['tipo_impuesto'];
         $monto_impuesto = $_POST['monto_impuesto'];
         $fecha_ultima_actualizacion =   date('Y-m-d h:i:s');
         $archivo =  $_POST['archivo'];


         $insertar = "INSERT INTO pedidos (nombre_pedido, Tipo_pedido, direccion, ciudad, estado_provincia, codigo_postal, pais, estado_pedido, descripcion_producto, cantidad, id_producto, precio_unitario, subtotal, total_producto, metodo_pago, estado_pago, fecha_pedido, fecha_pago, id_cliente, id_envio, metodo_envio, fecha_estimada_entrega, numero_rastreo, tipo_descuento, monto_descuento, tipo_impuesto, monto_impuesto, fecha_ultima_actualizacion, archivo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";



       // Verificar si las constantes ya están definidas antes de definirlas
       if (!defined('db_host')) {
        define('db_host', 'localhost');
    }
    if (!defined('db_username')) {
        define('db_username', 'root');
    }
    if (!defined('db_password')) {
        define('db_password', '');
    }
    if (!defined('db_dbname')) {
        define('db_dbname', 'tareas');
    }
    
    try {
        /// Conectar a MySQL y seleccionar la base de datos
        $mysqli = mysqli_connect(db_host, db_username, db_password, db_dbname);
    
    
    // Verificar que la conexión sea exitosa
    if (!$mysqli) {
        die('Error al conectarse a MySQL: ' . mysqli_connect_error());
    }
    
    // Establecer juego de caracteres UTF-8
    mysqli_set_charset($mysqli, 'utf8');
    
    // Realizar la consulta a la base de datos
    $consulta = "SELECT * FROM pedidos ORDER BY  id_pedido";
    $resultado = $mysqli->query($consulta);
    
    // Verificar que la consulta sea exitosa
    if (!$resultado) {
        die('Error en la consulta: ' . $mysqli->error);
    }

      
        
            // echo "Conexión exitosa usando PDO";

            // Asumiendo que $conexion es una conexión PDO, ajusta según sea necesario
            $ins = new Sentencia($insertarTarea, $conexion);
            $ins->insertarBdo();
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
        }
    }
}
?>


    
    
      



    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
     integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!--<link href="../../public/css/style.css" type="text/css" rel="stylesheet">-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
     <title>Pedidos</title>
     <script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>
</head>
  
<body>
<div class="container">
    <h1>Formulario de Pedido</h1>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre_pedido" name="nombre_pedido" class="form-control">
        </div>
        
        <div class="form-group">
            <label for="tipo_pedido">* Tipo :</label>
            <select name="tipo_pedido" id="tipo_pedido" class="form-control" required>
                <option value="normal">Normal</option>
                <option value="urgente">Urgente</option>
                <option value="internacional">Internacional</option>
                <option value="local">Local</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="direccion">Dirección:</label>
            <input type="text" id="direccion" name="direccion" class="form-control">
        </div>
        
        <div class="form-group">
            <label for="ciudad">Ciudad:</label>
            <select name="ciudad" id="ciudad" class="form-control">
                <option value="ciudad1">Ciudad 1</option>
                <option value="ciudad2">Ciudad 2</option>
                <option value="ciudad3">Ciudad 3</option>
                <!-- Agrega más opciones según tus necesidades -->
            </select>
        </div>
        
        <div class="form-group">
            <label for="provincia">Provincia:</label>
            <select name="estado_provincia" id="estado_provincia" class="form-control">
                <option value="provincia1">Provincia 1</option>
                <option value="provincia2">Provincia 2</option>
                <option value="provincia3">Provincia 3</option>
                <!-- Agrega más opciones según tus necesidades -->
            </select>
        </div>
        
        <div class="form-group">
            <label for="codigo_postal">Código Postal:</label>
            <input type="text" id="codigo_postal" name="codigo_postal" class="form-control">
        </div>
        
        <div class="form-group">
            <label for="pais">País:</label>
            <select name="pais" id="pais" class="form-control">
                <option value="pais1">País 1</option>
                <option value="pais2">País 2</option>
                <option value="pais3">País 3</option>
                <!-- Agrega más opciones según tus necesidades -->
            </select>
        </div>
        
        <div class="form-group">
            <label for="estado_pedido">* Estado Pedido :</label>
            <select name="estado_pedido" id="estado_pedido" class="form-control" required>
                <option value="pendiente">Pendiente</option>
                <option value="procesado">Procesado</option>
                <option value="enviado">Enviado</option>
                <option value="entregado">Entregado</option>
                <!-- Agrega más opciones según tus necesidades -->
            </select>
        </div>
        
        <div class="form-group">
            <label for="descripcion_producto">Descripción:</label>
            <input type="text" id="descripcion_producto" name="descripcion_producto" class="form-control">
        </div>
        
        <div class="form-group">
            <label for="cantidad">Cantidad:</label>
            <input type="number" id="cantidad" name="cantidad" class="form-control">
        </div>
        
        <div class="form-group">
            <label for="precio_unitario">Precio Unitario:</label>
            <input type="number" step="0.01" id="precio_unitario" name="precio_unitario" class="form-control">
        </div>
        
        <div class="form-group">
            <label for="subtotal">Subtotal:</label>
            <input type="number" step="0.01" id="subtotal" name="subtotal" class="form-control">
        </div>
        
        <div class="form-group">
            <label for="total_producto">Total Producto:</label>
            <input type="number" step="0.01" id="total_producto" name="total_producto" class="form-control">
        </div>
        
        <div class="form-group">
            <label for="metodo_pago">Método Pago:</label>
            <select name="metodo_pago" id="metodo_pago" class="form-control">
                <option value="tarjeta">Tarjeta</option>
                <option value="paypal">PayPal</option>
                <option value="transferencia">Transferencia</option>
                <!-- Agrega más opciones según tus necesidades -->
            </select>
        </div>
        
        <div class="form-group">
            <label for="estado_pago">Estado Pago:</label>
            <select name="estado_pago" id="estado_pago" class="form-control">
                <option value="pendiente">Pendiente</option>
                <option value="completado">Completado</option>
                <option value="fallido">Fallido</option>
                <!-- Agrega más opciones según tus necesidades -->
            </select>
        </div>
        
        <div class="form-group">
            <label for="fecha_pedido">Fecha Pedido:</label>
            <input type="date" id="fecha_pedido" name="fecha_pedido" class="form-control">
        </div>
        
        <div class="form-group">
            <label for="fecha_pago">Fecha Pago:</label>
            <input type="date" id="fecha_pago" name="fecha_pago" class="form-control">
        </div>
        
        <div class="form-group">
            <label for="envio">Envío:</label>
            <select name="envio" id="envio" class="form-control">
                <option value="estandar">Estándar</option>
                <option value="rapido">Rápido</option>
                <option value="express">Express</option>
                <!-- Agrega más opciones según tus necesidades -->
            </select>
        </div>
        
        <div class="form-group">
            <label for="fecha_entrega">Fecha Entrega:</label>
            <input type="date" id="fecha_entrega" name="fecha_entrega" class="form-control">
        </div>
        
        <div class="form-group">
            <label for="rastreo">Rastreo:</label>
            <input type="text" id="rastreo" name="rastreo" class="form-control">
        </div>
        
        <div class="form-group">
            <label for="descuento">Descuento:</label>
            <input type="text" id="descuento" name="descuento" class="form-control">
        </div>
        
        <div class="form-group">
            <label for="monto_descuento">Monto Descuento:</label>
            <input type="number" step="0.01" id="monto_descuento" name="monto_descuento" class="form-control">
        </div>
        
        <div class="form-group">
            <label for="tipo_impuesto">Tipo Impuesto:</label>
            <select name="tipo_impuesto" id="tipo_impuesto" class="form-control">
                <option value="iva">IVA</option>
                <option value="igv">IGV</option>
                <option value="isr">ISR</option>
                <!-- Agrega más opciones según tus necesidades -->
            </select>
        </div>
        
        <div class="form-group">
            <label for="monto_impuesto">Monto Impuesto:</label>
            <input type="number" step="0.01" id="monto_impuesto" name="monto_impuesto" class="form-control">
        </div>
        
        <div class="form-group">
            <label for="fecha_actualizacion">Fecha Actualización:</label>
            <input type="date" id="fecha_actualizacion" name="fecha_actualizacion" class="form-control">
        </div>

        <div class="form-group">
                    <label for="archivo">Archivo</label>
                    <input type="file" id="archivo" name="archivo" class="form-control-file" required>
                    <div class="invalid-feedback">Por favor seleccione el archivo.</div>
                </div>

                <button type="submit" name="boton" class="btn btn-primary">Guardar</button>
        
       
    </form>
</div>


</body>
</html>




<?php

// Conectar a MySQL y seleccionar la base de datos
$mysqli = new mysqli('localhost', 'root', '', 'sofware_erp');

// Verificar que la conexión sea exitosa
if ($mysqli->connect_errno) {
    die('Error al conectarse a MySQL: ' . $mysqli->connect_error);
}

// Realizar la consulta a la base de datos
$consulta = "SELECT * FROM  pedidos ORDER BY   id_pedido";
$resultado = $mysqli->query($consulta);

// Verificar que la consulta sea exitosa
if ($resultado) {
    

    ?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
     integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!--<link href="../../public/css/style.css" type="text/css" rel="stylesheet">-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
     <title>Pedidos</title>

</head>
<body>
    

<button name="boton-create" type="button" onclick="location.href='insert.php?da=2'">
       New Order
    </button>


    <table class="table">
        <thead class="thead-light">
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Nombre</th>
                <th scope="col">Tipo</th>
                <th scope="col">Direccion</th>
                <th scope="col">Ciudad</th>
                <th scope="col">Provincia</th>
                <th scope="col">Codigo Postal</th>
                <th scope="col">Pais</th>
                <th scope="col">Estado Pedido</th>
                <th scope="col">Descripcion</th>
                <th scope="col">Cantidad</th>
                <th scope="col">Id producto</th>
                <th scope="col">Precio Unitario</th>
                <th scope="col">Subtotal</th>
                <th scope="col">Total Producto</th>
                <th scope="col">Metodo Pago</th>
                <th scope="col">Estado Pago</th>
                <th scope="col">Fecha Pedido</th>
                <th scope="col">Fecha Pedido</th>
                <th scope="col">Fecha Pago</th>
                <th scope="col">Id cliente</th>
                <th scope="col">Id envio </th>
                <th scope="col">envio </th>
                <th scope="col">Fecha Entrega</th>
                <th scope="col">Rastreo</th>
                <th scope="col">Descuento</th>
                <th scope="col">Monto Descuento</th>
                <th scope="col">Tipo impuesto</th>
                <th scope="col">Monto impuesto</th>
                <th scope="col">Fecha Actualizacion</th>
                <th scope="col">Archivo</th>
        </tr>
        </thead>
        <tbody>
            <?php
            while ($pedido = $resultado->fetch_assoc()) {
                ?>
                <tr>
                    <td><?php echo $pedido['id_pedido']; ?></td>
                    <td><?php echo $pedido['nombre_pedido	']; ?></td>
                    <td><?php echo $pedido['Tipo_pedido']; ?></td>
                    <td><?php echo $pedido['direccion']; ?></td>
                    <td><?php echo $pedido['ciudad']; ?></td>
                    <td><?php echo $pedido['estado_provincia']; ?></td>
                    <td><?php echo $pedido['codigo_postal']; ?></td>
                    <td><?php echo $pedido['pais']; ?></td>
                    <td><?php echo $pedido['estado_pedido']; ?></td>
                    <td><?php echo $pedido['descripcion_producto']; ?></td>
                    <td><?php echo $pedido['cantidad']; ?></td>
                    <td><?php echo $pedido['id_producto']; ?></td>
                    <td><?php echo $pedido['precio_unitario']; ?></td>
                    <td><?php echo $pedido['subtotal']; ?></td>
                    <td><?php echo $pedido['total_producto']; ?></td>
                    <td><?php echo $pedido['metodo_pago']; ?></td>
                    <td><?php echo $pedido['estado_pago']; ?></td>
                    <td><?php echo $pedido['fecha_pedido']; ?></td>
                    <td><?php echo $pedido['fecha_pago']; ?></td>
                    <td><?php echo $pedido['id_cliente']; ?></td>
                    <td><?php echo $pedido['id_envio']; ?></td>
                    <td><?php echo $pedido['metodo_envio']; ?></td>
                    <td><?php echo $pedido['fecha_estimada_entrega']; ?></td>
                    <td><?php echo $pedido['numero_rastreo']; ?></td>
                    <td><?php echo $pedido['tipo_descuento']; ?></td>
                    <td><?php echo $pedido['monto_descuento']; ?></td>
                    <td><?php echo $pedido['tipo_impuesto']; ?></td>
                    <td><?php echo $pedido['monto_impuesto']; ?></td>
                    <td><?php echo $pedido['fecha_ultima_actualizacion']; ?></td>
                    <td><img src="../../public/img/pedidos-imagen/<?php echo $pedido['archivo']; ?>" width="100" alt=""></td>
                 
<a href="main.php?da=3&lla=<?php echo $pedido['id_pedido']; ?>" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Editar</a> 
<a href="#" onclick="borrar(<?php echo $pedido['id_pedido']; ?>)" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Borrar</a>

                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>

    
<script>
function borrar(id) {
    if (confirm('¿Está seguro de borrar el contacto?')) {
        // Realizar una petición AJAX para borrar el contacto
        var xhr = new XMLHttpRequest();
        
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Éxito en la eliminación del pedido
                    alert(' contacto eliminado correctamente.');
                    // Recargar la página para reflejar los cambios
                    location.reload();
                } else {
                    // Error al eliminar el proveedor
                    alert('Error al eliminar el contacto.');
                }
            }
        };
        
        // Configurar la petición AJAX
        xhr.open('GET', 'delete.php?da=4&lla=' + id, true);
        // Enviar la petición
        xhr.send();
    }
}
</script>


    </body>
    </html>
    <?php
} else {
    die('Error en la consulta: ' . $mysqli->error);
}

// Cerrar la conexión
$mysqli->close();
?>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>


</body>
</html>

