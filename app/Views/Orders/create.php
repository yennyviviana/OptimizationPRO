
<?php

session_start();


if(!isset($_SESSION['id_usuario'])){
    header("Location: index.php");
}

?>
<!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <title>Tu Página</title>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
        <link href="public/css/style.css" type="text/css" rel="stylesheet">
    </head>
    <body>
<style>
.panel {
            display: flex;
            justify-content: space-between;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 8px;
            background-color: #f9f9f9;
        }

        .column {
            width: 48%;
        }

        
     
.nav {
    display: flex;
    align-items: center;
    float: left;
    margin-left: 20px; 
    text-align: none;
}

.nav a {
    color: rgb(33, 138, 170);
    text-decoration: none;
    padding: 10px;
    font-size: 16px;
    margin-left: 10px;
}

.nav a:hover {
    background-color: rgb(10, 18, 125);
    color: #f7f0f0;
}

.nav .active {
    color: #0f6146;
}



        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            background-color: #007bff;
            color: #fff;
        }

        .btn:hover {
            background-color: #0056b3;
        }

    </style>
</head>
<body>

           

    <div class="panel">
        <div class="column">
            <h2>Módulo de pedidos</h2>
            <ul class="nav">
              
                <li><i class="fas fa-edit icon"></i><a href='insert.php?da=2'>Insert Orders</a></li>
    
                <li class="nav-item">
                            <a class="nav-link" href="main.php">
                                <span data-feather="Home"></span>
                                 Regresar
                            </a>
                        </li>
            </ul>
        </div>
    </div>

    
    <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                    
            <tr>
                <th scope="col">Id</th>
                <th scope="col">pedido</th>
                <th scope="col">Precio</th>
                <th scope="col">Estado</th>
                <th scope="col">Direccion</th>
                <th scope="col">Descripcion</th>
                <th scope="col">Seguimiento</th>
                <th scope="col">Tiempo Entrega</th>
                <th scope="col">Informacion</th>
                <th scope="col">Metodo Pago</th>
                <th scope="col">Archivo</th>
                <th scope="col">Fecha pedido</th>
                <th scope="col">Fecha entrega</th>
                <th scope="col">Id</th>
                
    </thead>
    <tbody>
    <?php      
define('db_host', 'localhost');
define('db_username', 'root');
define('db_password', '');
define('db_dbname', 'sofware_erp');

// Conectar a MySQL y seleccionar la base de datos.
$mysqli = mysqli_connect(db_host, db_username, db_password, db_dbname);



// Verificar que la conexión sea exitosa
if (!$mysqli) {
    die('Error al conectarse a MySQL: ' . mysqli_connect_error());
}

// Establecer juego de caracteres UTF-8zvc c
mysqli_set_charset($mysqli, 'utf8');

// Consulta utilizando MySQLi
$consulta = "SELECT * FROM pedidos ORDER BY id_pedido";
$resultados = $mysqli->query($consulta);


// Comprobación de errores en la ejecución de la consulta
if (!$resultados) {
    die("Error al ejecutar la consulta: " . $mysqli->error);
}

// Iterar sobre los resultados y mostrarlos
while ($pedido = $resultados->fetch_assoc()) {
?>
    <tr>
        <td><?php echo htmlspecialchars($pedido['id_pedido']); ?></td>
        <td><?php echo htmlspecialchars($pedido['nombre_pedido']); ?></td>
        <td>$ <?php echo number_format($pedido['precio'], 2, ',', '.'); ?></td>
        <td><?php echo htmlspecialchars($pedido['estado']); ?></td>
        <td><?php echo htmlspecialchars($pedido['direccion']); ?></td>
        <td><?php echo htmlspecialchars($pedido['descripcion']); ?></td>
        <td><?php echo htmlspecialchars($pedido['numero_seguimiento']); ?></td>
        <td><?php echo htmlspecialchars($pedido['tiempo_entrega_horas']); ?></td>
        <td><?php echo htmlspecialchars($pedido['informacion_pedido']); ?></td>
        <td><?php echo htmlspecialchars($pedido['metodo_pago']); ?></td>
        <td><img src="../../public/img/pedidos-imagen/<?php echo $pedido['archivo']; ?>" width="100" alt=""></td>
        <td><?php echo htmlspecialchars($pedido['fecha_pedido']); ?></td>
        <td><?php echo htmlspecialchars($pedido['fecha_entrega']); ?></td>
        <td><?php echo htmlspecialchars($pedido['id_usuario']); ?></td>
       
        
            
        <td>
              
                  <!-- Botón para editar -->  
                <a href="edit.php?da=3&lla=<?php echo $pedido['id_pedido']; ?>" class="btn btn-custom-green">
                <i class="fas fa-edit icon"></i> Editar


                <!-- Botón de Borrar -->
<a href="#" class="btn btn-danger" onclick="borrarPedido(<?php echo $pedido['id_pedido']; ?>, '<?php echo $pedido['archivo']; ?>')">
    <i class="fas fa-trash-alt"></i> Borrar
</a>

<script>
function borrarPedido(id, imagen) {
    if (confirm('¿Está seguro de borrar el pedido?')) {
        // Realizar una petición AJAX para borrar el pedido
        var xhr = new XMLHttpRequest();

        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Éxito en la eliminación del pedido
                    alert('Pedido eliminado correctamente.');
                    // Recargar la página para reflejar los cambios
                    location.reload();
                } else {
                    // Error al eliminar el pedido
                    alert('Error al eliminar el pedido.');
                }
            }
        };

        // Configurar la petición AJAX
        xhr.open('GET', 'delete.php?lla=' + id + '&imagen=' + imagen, true);
        // Enviar la petición
        xhr.send();
    }
}
</script>


</tr>
            <?php
        }

        // Cerrar la conexión
        $mysqli->close();
        ?>
    </tbody>
</table>



</body>
</html>