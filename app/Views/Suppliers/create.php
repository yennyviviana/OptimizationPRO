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


.btn-borrar {
    display: inline-block;
    padding: 7px 10px; /* Ajusta el relleno para hacerlo más pequeño */
    font-size: 14px; /* Ajusta el tamaño de la fuente para hacerlo más pequeño */
    border: none;
    border-radius: 4px;
    cursor: pointer;
    background-color: #000; /* Cambiado a color rojo */
    color: #fff;
    transition: background-color 0.3s; /* Agregado transición suave */
}

.btn-borrar:hover {
    background-color: #c82333; /* Cambiado a tono más oscuro de rojo en hover */
}


.btn-editar {
    display: inline-block;
    padding: 7px 10px; /* Ajusta el relleno para hacerlo más pequeño */
    font-size: 14px; /* Ajusta el tamaño de la fuente para hacerlo más pequeño */
    border: none;
    border-radius: 4px;
    cursor: pointer;
    background-color:  green; /* Cambiado a color rojo */
    color: #fff;
    transition: background-color 0.3s; /* Agregado transición suave */
}

.btn-editar:hover {
    background-color: #A0CD60; /* Cambiado a tono más oscuro de rojo en hover */
}

    </style>
</head>
<body>

           

    <div class="panel">
        <div class="column">
            <h2>Módulo de proveedores</h2>
            <ul class="nav">
              
                <li><i class="fas fa-edit icon"></i><a href='insert.php?da=2'>Insert Supplier</a></li>
    

            </ul>
        </div>
    </div>

    
    
    <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Empresa</th>
                <th scope="col">Direccion</th>
                <th scope="col">Telefono</th>
                <th scope="col">Email</th>
                <th scope="col">lista productos</th>
                <th scope="col">Condiciones de pago</th>
                <th scope="col">metodo de pago</th>
                <th scope="col">Descripcion</th>
                <th scope="col">archivo</th>
                
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

// Establecer juego de caracteres UTF-8zvc 
mysqli_set_charset($mysqli, 'utf8');

// Consulta utilizando MySQLi
$consulta = "SELECT * FROM proveedores ORDER BY id_proveedor";
$resultados = $mysqli->query($consulta);

$resultados = $mysqli->query($consulta);


// Comprobación de errores en la ejecución de la consulta
if (!$resultados) {
    die("Error al ejecutar la consulta: " . $mysqli->error);
}

// Iterar sobre los resultados y mostrarlos
while ($proveedor = $resultados->fetch_assoc()) {
?>


<tr>
        <td><?php echo htmlspecialchars($proveedor['id_proveedor']); ?></td>
        <td><?php echo htmlspecialchars($proveedor['nombre_empresa']); ?></td>
        <td><?php echo htmlspecialchars($proveedor['direccion']); ?></td>
        <td><?php echo htmlspecialchars($proveedor['telefono']); ?></td>
        <td><?php echo htmlspecialchars($proveedor['correo_electronico']); ?></td>
        <td><?php echo htmlspecialchars($proveedor['lista_productos']); ?></td>
        <td><?php echo htmlspecialchars($proveedor['condiciones_pago']); ?></td>
        <td><?php echo htmlspecialchars($proveedor['metodo_pago']); ?></td>
        <td><?php echo htmlspecialchars($proveedor['descripcion']); ?></td>
        <td><img src="../../public/img/proveedores-imagen/<?php echo $proveedor['archivo']; ?>" width="100" alt=""></td>
       
            
        <td>
              
                <!-- Botón para editar -->  
                <a href="edit.php?da=3&lla=<?php echo $proveedor['id_proveedor']; ?>" class="btn btn-custom-green btn-editar">
                <i class="fas fa-edit icon"></i> Editar

           <!-- Espacio entre los botones -->
         <span style="margin-right: 10px;"></span>
                <!-- Botón de Borrar -->
<a href="#"  class="btn btn-danger btn-borrar" onclick="borrarProveedor(<?php echo $proveedor['id_proveedor']; ?>, '<?php echo $proveedor['archivo']; ?>')">
    <i class="fas fa-trash-alt"></i> Borrar

</a>


<script>
function borrarProveedor(id, imagen) {
    if (confirm('¿Está seguro de borrar el proveedor?')) {
        // Realizar una petición AJAX para borrar el pedido
        var xhr = new XMLHttpRequest();

        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Éxito en la eliminación del pedido
                    alert('Proveedor eliminado correctamente.');
                    // Recargar la página para reflejar los cambios
                    location.reload();
                } else {
                    // Error al eliminar el pedido
                    alert('Error al eliminar el proveedor.');
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