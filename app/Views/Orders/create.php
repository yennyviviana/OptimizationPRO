
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
    </head>
    <body>
<style>
    body {
    background-color: #000;
    color: #f5f5f5; 
}

.panel {
    display: flex;
    justify-content: space-between;
    border: 1px solid #333;
    padding: 20px;
    border-radius: 8px;
    background-color: #234DF0; 
}

.column {
    width: 48%;
}

h2 {
    color: whitesmoke; 
}

.nav {
    display: flex;
    align-items: center;
    float: left;
    margin-left: 20px;
}

.nav a {
    color: whitesmoke; 
    text-decoration: none;
    padding: 10px;
    font-size: 16px;
    margin-left: 10px;
}

.nav a:hover {
    background-color: darkblue;
    color: #000; 
}
.nav .active {
    color: #ff6f61;
}

.btn {
    display: inline-block;
    padding: 10px 20px;
    font-size: 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    background-color: #333;
    color: #ff6f61; 
}

.btn:hover {
    background-color: #ff6f61;
    color: #fff; 
}


.btn-borrar {
    display: inline-block;
    padding: 7px 10px;
    font-size: 14px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    background-color: #ff4d4d; 
    color: #fff;
}

.btn-borrar:hover {
    background-color: #c82333;
}

.btn-editar {
    display: inline-block;
    padding: 7px 10px;
    font-size: 14px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    background-color:  blue;
    color: #fff;
}

.btn-editar:hover {
    background-color:  #0B1CDB;
}

.table-container {
    width: 100%;
    margin: 0 auto;
}

.table {
    width: 100%;
    table-layout: auto;
    word-wrap: break-word;
    color: #fff; 
    background-color: #818274; 
}

.table th, .table td {
    border: 1px solid #444;
    padding: 1rem;
    font-size: 1.1rem;
    text-align: center;
}
.table th {
    background-color: #000000;
    color:  #65D8DB; 
    font-weight: bold;
    border-bottom: 3px solid #ff6f61;
}

.table tbody tr {
    background-color: #000;
}

.table tbody tr:nth-of-type(odd) {
    background-color:  #fff; 
    color:  #000;
}



.table-responsive {
    margin-top: 1.5rem;
    overflow-x: auto;
}




    </style>

</head>
<body>


<div class="panel">
    <div class="column">
        <h2>Módulo de pedidos</h2>
        <ul class="nav">
            <li><i class="fas fa-edit icon"></i><a href='insert.php?da=2'>Insertar Pedidos</a></li>
            <li class="nav-item">
                <a class="nav-link" href="/OptimizationPRO/app/main.php">
                    <span data-feather="Home"></span>
                    Regresar
                </a>
            </li>
        </ul>
    </div>
    
    
    <!-- Contenedor de Búsqueda -->
<div id="search" class="d-flex justify-content-center my-3">
    <div class="input-group">
        <!-- Campo de texto -->
        <input type="text" 
               id="search-query" 
               class="form-control" 
               placeholder="Ingrese datos a buscar" 
               aria-label="Buscar">
    </div>
</div>

<!-- Resultados de la búsqueda -->
<div id="results" class="mt-3">
    <!-- Aquí se mostrarán los resultados en tiempo real -->
</div>


</form>


</div>





    <div class="container-fluid">
    <div class="table-container">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="thead-light">
                    
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
                <th scope="col">Acciones</th>
                <th scope="col">Acciones</th>
                
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
                  
                   <a href="edit.php?da=3&lla=<?php echo $pedido['id_pedido']; ?>"  class="btn btn-custom-green btn-editar">
                <i class="fas fa-edit icon"></i> Editar
</td>

<td>
<a href="#" class="btn btn-danger btn-borrar" onclick="borrarPedido(<?php echo $pedido['id_pedido']; ?>, '<?php echo $pedido['archivo'];  ?>')">
    <i class="fas fa-trash-alt"></i> Borrar
</a>
</td>

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


<script>
// Capturar elementos
const searchQuery = document.getElementById("search-query");
const resultsDiv = document.getElementById("results");

// Escuchar el evento 'input' en el campo de texto
searchQuery.addEventListener("input", function () {
    const query = searchQuery.value.trim(); // Obtener el valor ingresado

    if (query.length > 2) { // Realizar búsqueda solo si hay más de 2 caracteres
        fetch("search.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: `query=${encodeURIComponent(query)}`,
        })
            .then(response => response.text()) // Procesar la respuesta como texto
            .then(data => {
                resultsDiv.innerHTML = data; // Mostrar resultados
            })
            .catch(error => {
                console.error("Error en la búsqueda:", error);
                resultsDiv.innerHTML = "<p>Error al cargar los resultados.</p>";
            });
    } else {
        resultsDiv.innerHTML = ""; // Limpiar resultados si no hay suficiente texto
    }
});

</script>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

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