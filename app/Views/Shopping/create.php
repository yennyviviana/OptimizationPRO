<?php
session_start();

if(!isset($_SESSION['id_usuario'])){
    header("Location: index.php");
}



define('db_host', 'localhost');
define('db_username', 'root');
define('db_password', '');
define('db_dbname', 'sofware_erp');

// Conectar a MySQL
$mysqli = mysqli_connect(db_host, db_username, db_password, db_dbname);

if (!$mysqli) {
    die('Error al conectarse a MySQL: ' . mysqli_connect_error());
}

mysqli_set_charset($mysqli, 'utf8');


        

// Establecer los valores de paginación
$registros_por_pagina = 10;  // Número de registros por página
$página_actual = isset($_GET['page']) ? (int)$_GET['page'] : 1;  // Página actual
$inicio = ($página_actual - 1) * $registros_por_pagina;  // Calcular el valor de OFFSET

// Consulta SQL para obtener los registros
$consulta = "SELECT * FROM  compras LIMIT $inicio, $registros_por_pagina";
$resultados = $mysqli->query($consulta);

// Verificar si la consulta fue exitosa
if (!$resultados) {
    die("Error al ejecutar la consulta: " . $mysqli->error);
}

// Calcular el número total de registros
$total_registros_query = "SELECT COUNT(*) AS total FROM   compras";
$total_resultados = $mysqli->query($total_registros_query);
$total_registros = $total_resultados->fetch_assoc()['total'];

// Calcular el número total de páginas
$total_paginas = ceil($total_registros / $registros_por_pagina);



        // Consulta utilizando MySQLi
        $consulta = "SELECT * FROM productos ORDER BY id_producto";
        $resultados = $mysqli->query($consulta);

        // Comprobación de errores en la ejecución de la consulta
        if (!$resultados) {
            die("Error al ejecutar la consulta: " . $mysqli->error);
        }


// Obtener el término de búsqueda
$searchQuery = isset($_GET['search-query']) ? $_GET['search-query'] : '';

// Construir la consulta SQL con filtro si hay búsqueda
if (!empty($searchQuery)) {
    $consulta = "SELECT * FROM  compras WHERE 
                 productos_comprados LIKE '%$searchQuery%' OR 
                  detalles_productos LIKE '%$searchQuery%' OR 
                 estado_actual LIKE '%$searchQuery%'
                 ORDER BY id_compra";
} else {
    $consulta = "SELECT * FROM  compras ORDER BY id_compra";
}

$resultados = $mysqli->query($consulta);

if (!$resultados) {
    die("Error al ejecutar la consulta: " . $mysqli->error);
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
        /* Estilos personalizados */
      body {
            background-color: #000;
            color: #f5f5f5;
        }
        .table-container {
    background-color: #f8f9fa; /* Fondo del contenedor */
    padding: 20px;
    border-radius: 10px;
}

.table {
    border: 1px solid #ddd; /* Bordes de la tabla */
    border-radius: 5px;
    overflow: hidden;
}

.table th {
    background-color:hsl(263, 93.20%, 17.30%); /* Color de encabezados */
    color: white;
    text-align: center;
    font-weight: bold;
}

.table tbody tr:nth-child(odd) {
    background-color: #f2f2f2; /* Color alternativo para filas impares */
}

.table tbody tr:hover {
    background-color: #d1ecf1; /* Efecto hover */
}


        .panel {
    display: flex;
    justify-content: space-between;
    border: 1px solid #333;
    padding: 20px;
    border-radius: 8px;
    background-color:hsl(240, 0.90%, 21.00%); 
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


    </style>
</head>

<body>

    <div class="panel">
        <div class="column">
            <h2>Módulo de compras</h2>
            <ul class="nav">
                <li><i class="fas fa-edit icon"></i><a href='insert.php?da=Shopping-2'>Insertar Compras</a></li>
                <li class="nav-item">
                <a class="nav-link" href="/OptimizationPRO/app/main.php">
                                <span data-feather="Home"></span>
                                 Regresar
                            </a>
                        </li>
            </ul>
        </div>
    </div>

    <br>
<div class="container-fluid">
    

    <!-- Formulario de búsqueda.....-->
    <form method="GET" class="d-flex justify-content-center mb-3">
        <input type="text" name="search-query" class="form-control w-50 me-2" 
               placeholder="Buscar compras..." value="<?php echo htmlspecialchars($searchQuery); ?>">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-search"></i> Buscar
        </button>
    </form>

    
    
   
    <table class="table table-bordered table-hover">
    <thead class="bg-primary text-white">
             <tr>
                <th scope="col">Id</th>
                <th scope="col">Productos</th>
                <th scope="col">Detalles</th>
                <th scope="col">Precio unitario</th>
                <th scope="col">Precio compra</th>
                <th scope="col">Total compra</th>
                <th scope="col">Estado actual</th>
                <th scope="col">Metodo compra</th>
                <th scope="col">Fecha de compra</th>
                <th scope="col">Fecha de entrega</th>
                <th scope="col">Codigo inventario</th>
                <th scope="col">Proveedor</th>
                <th scope="col">Usuario</th>
                <th scope="col">Factura</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($compra = $resultados->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($compra['id_compra']); ?></td>
                <td><?php echo htmlspecialchars($compra['productos_comprados']); ?></td>
                <td><?php echo htmlspecialchars($compra['detalles_productos']); ?></td>
                <td><?php echo number_format($compra['precio_unitario']); ?></td>
                <td><?php echo htmlspecialchars($compra['precio_compra']); ?></td>
                <td><?php echo htmlspecialchars($compra['total_compra']); ?></td>
                <td><?php echo htmlspecialchars($compra['estado_actual']); ?></td>
                <td><?php echo htmlspecialchars($compra['metodo_pago']); ?></td>
                <td><?php echo htmlspecialchars($compra['fecha_compra']); ?></td>
                <td><?php echo htmlspecialchars($compra['fecha_entrega']); ?></td>
                <td><?php echo htmlspecialchars($compra['codigo_inventario']); ?></td>
                <td><?php echo htmlspecialchars($compra['id_proveedor']); ?></td>
                <td><?php echo htmlspecialchars($compra['id_usuario']); ?></td>
                <td>
                    <a href="../../public/img/factura-compra/<?php echo htmlspecialchars($compra['factura']); ?>" target="_blank">
                        <img src="../../public/img/factura-compra/<?php echo htmlspecialchars($compra['factura']); ?>" width="100" alt="Factura">
                    </a>
                </td>
                <td>
                    <a href="edit.php?da=Shopping-3&lla=<?php echo $compra['id_compra']; ?>" class="btn btn-editar">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <a href="#" class="btn btn-borrar" onclick="borrarCompra(<?php echo $compra['id_compra']; ?>)">
                        <i class="fas fa-trash-alt"></i> Borrar
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>




 <!-- Paginación -->
 <nav>
        <ul class="pagination">
            <?php if ($página_actual > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=1" aria-label="Primera">
                        <span aria-hidden="true">&laquo;&laquo;</span>
                    </a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $página_actual - 1 ?>" aria-label="Anterior">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                <li class="page-item <?= ($i == $página_actual) ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>

            <?php if ($página_actual < $total_paginas): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $página_actual + 1 ?>" aria-label="Siguiente">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $total_paginas ?>" aria-label="Última">
                        <span aria-hidden="true">&raquo;&raquo;</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>

</div>


<script>
function borrarCompra(id) {
    if (confirm('¿Está seguro de borrar la compra?')) {
        // Realizar una petición AJAX para borrar la compra
        var xhr = new XMLHttpRequest();

        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Éxito en la eliminación de la compra
                    alert('Compra eliminada correctamente.');
                    // Recargar la página para reflejar los cambios
                    location.reload();
                } else {
                    // Error al eliminar la compra
                    alert('Error al eliminar la compra.');
                }
            }
        };

        // Configurar la petición AJAX
        xhr.open('GET', 'delete.php?lla=' + id, true);
        // Enviar la petición
        xhr.send();
    }
}
</script>



<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.querySelector('input[name="search-query"]');
    const resultsTable = document.querySelector('tbody');

    searchInput.addEventListener('input', function () {
        const searchQuery = searchInput.value;

        // Crear una solicitud AJAX
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'search.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onload = function () {
            if (xhr.status === 200) {
                // Actualizar la tabla con los resultados
                resultsTable.innerHTML = xhr.responseText;
            } else {
                console.error('Error al realizar la búsqueda.');
            }
        };

        xhr.send('searchQuery=' + encodeURIComponent(searchQuery));
    });
});
</script>

</body>
</html>
