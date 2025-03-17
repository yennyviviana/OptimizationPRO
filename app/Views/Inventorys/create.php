
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
$consulta = "SELECT * FROM  inventarios LIMIT $inicio, $registros_por_pagina";
$resultados = $mysqli->query($consulta);

// Verificar si la consulta fue exitosa
if (!$resultados) {
    die("Error al ejecutar la consulta: " . $mysqli->error);
}

// Calcular el número total de registros
$total_registros_query = "SELECT COUNT(*) AS total FROM  inventarios";
$total_resultados = $mysqli->query($total_registros_query);
$total_registros = $total_resultados->fetch_assoc()['total'];

// Calcular el número total de páginas
$total_paginas = ceil($total_registros / $registros_por_pagina);



// Obtener el término de búsqueda
$searchQuery = isset($_GET['search-query']) ? $_GET['search-query'] : '';

// Construir la consulta SQL con filtro si hay búsqueda
if (!empty($searchQuery)) {
    $consulta = "SELECT * FROM  inventarios WHERE 
                 nombre_producto LIKE '%$searchQuery%' OR 
                 descripcion LIKE '%$searchQuery%' OR 
                 categoria_productos LIKE '%$searchQuery%'
                 ORDER BY  codigo_inventario";
} else {
    $consulta = "SELECT * FROM inventarios ORDER BY  codigo_inventario";
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
    <title>Módulo de pedidos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        /* Estilos personalizados */
        body {
            background-color: #000;
            color: #f5f5f5;
        }
        .table th, .table td {
            color: #fff;
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
            <h2>Módulo de inventarios</h2>
            <ul class="nav">
                <li><i class="fas fa-edit icon"></i><a href='insert.php?da=Inventorys-2'>Insert inventory</a></li>
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
               placeholder="Buscar pedidos..." value="<?php echo htmlspecialchars($searchQuery); ?>">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-search"></i> Buscar
        </button>
    </form>






    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>


           

   
<table class="table table-bordered table-hover">
    <thead class="bg-primary text-white">
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
            <th scope="col">Acciones</th>
        </tr>
                
    </thead>
    <tbody>
    <?php while ($inventario = $resultados->fetch_assoc()): ?>


        <tr>
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
                            <a href="edit.php?da=3&lla=<?php echo $inventario['codigo_inventario']; ?>" class="btn btn-custom-green btn-editar">
                                <i class="fas fa-edit icon"></i> Editar
                            </a>

                            <a href="#" class="btn btn-danger btn-borrar" onclick="borrarInventario(<?php echo $inventario['codigo_inventario']; ?>)">
                                <i class="fas fa-trash-alt"></i> Borrar
                            </a>
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
