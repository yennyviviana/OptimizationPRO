
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
            <h2>Módulo de inventarios.</h2>
            <ul class="nav">
              
                <li><i class="fas fa-edit icon"></i><a href='insert.php?da=2'>Insertar inventarios</a></li>
    
                <li class="nav-item">
                            <a class="nav-link" href="main.php">
                                <span data-feather="Home"></span>
                                 Regresar
                            </a>
                        </li>
            </ul>
        </div>
    </div>

    
    


    <table class="table">
        <thead class="thead-light">
            <tr>
            <th scope="col">Id Producto</th>
            <th scope="col">Nombre Producto</th>
            <th scope="col">Cantidad Stock</th>
            <th scope="col">Precio Unitario</th>
            <th scope="col">Costo Unitario</th>
            <th scope="col">Precio Compra</th>
            <th scope="col">Precio Venta</th>
            <th scope="col">Categoría Productos</th>
            <th scope="col">Descripción</th>
            <th scope="col">Código Barras</th>
            <th scope="col">Ubicación</th>
            <th scope="col">Estado</th>
            <th scope="col">Id Proveedor</th>
            <th scope="col">Id Producto</th>
            <th scope="col">Fecha Adquisición</th>
            <th scope="col">Fecha Vencimiento</th>
            <th scope="col">Tipo Documento</th>
        </tr>
                
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
$consulta = "SELECT * FROM  inventarios ORDER BY  codigo_inventario";
$resultados = $mysqli->query($consulta);


// Comprobación de errores en la ejecución de la consulta
if (!$resultados) {
    die("Error al ejecutar la consulta: " . $mysqli->error);
}

// Iterar sobre los resultados y mostrarlos
while ($inventario = $resultados->fetch_assoc()) {
?>
    
    <td><?php echo htmlspecialchars($inventario['codigo_inventario']); ?></td>
        <td><?php echo htmlspecialchars($inventario['nombre_producto']); ?></td>
        <td><?php echo htmlspecialchars($inventario['cantidad_stock']); ?></td>
        <td>$ <?php echo number_format($inventario['precio_unitario'], 2, ',', '.'); ?></td>
        <td>$ <?php echo number_format($inventario['costo_unitario'], 2, ',', '.'); ?></td>
        <td>$ <?php echo number_format($inventario['precio_compra'], 2, ',', '.'); ?></td>
        <td>$ <?php echo number_format($inventario['precio_venta'], 2, ',', '.'); ?></td>
        <td><?php echo htmlspecialchars($inventario['categoria_productos']); ?></td>
        <td><?php echo htmlspecialchars($inventario['descripcion']); ?></td>
        <td><?php echo htmlspecialchars($inventario['codigo_barras']); ?></td>
        <td><?php echo htmlspecialchars($inventario['ubicacion']); ?></td>
        <td><?php echo htmlspecialchars($inventario['estado']); ?></td>
        <td><?php echo htmlspecialchars($inventario['id_proveedor']); ?></td>
        <td><?php echo htmlspecialchars($inventario['id_producto']); ?></td>
        <td><?php echo htmlspecialchars($inventario['fecha_adquisicion']); ?></td>
        <td><?php echo htmlspecialchars($inventario['fecha_vencimiento']); ?></td>
        <td><img src="../../public/img/TipoDocumento/<?php echo $inventario['tipo_documento']; ?>" width="100" alt=""></td>
    
        
            
        <td>
                <a href="edit.php?da=3&lla=<?php echo $inventario['codigo_inventario']; ?>" class="btn btn-custom-green">
                <i class="fas fa-edit icon"></i> Editar

             <a href="#" class="btn btn-danger" onclick="borrarInventario(<?php echo $inventario['codigo_inventario']; ?>, '<?php echo $inventario['codigo_inventario']; ?>')">
                             <i class="fas fa-trash-alt"></i> Borrar
</a>

<script>
function borrarInventario(id, imagen) {
    if (confirm('¿Está seguro de borrar el  inventario?')) {
        // Realizar una petición AJAX para borrar el inventario
        var xhr = new XMLHttpRequest();

        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Éxito en la eliminación del  inventario
                    alert('Pedido eliminado correctamente.');
                    // Recargar la página para reflejar los cambios
                    location.reload();
                } else {
                    // Error al eliminar el  inventario
                    alert('Error al eliminar el  inventario.');
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