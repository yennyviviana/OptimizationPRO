<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit;
}


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

        // Establecer juego de caracteres UTF-8
        mysqli_set_charset($mysqli, 'utf8');


        

// Establecer los valores de paginación
$registros_por_pagina = 10;  // Número de registros por página
$página_actual = isset($_GET['page']) ? (int)$_GET['page'] : 1;  // Página actual
$inicio = ($página_actual - 1) * $registros_por_pagina;  // Calcular el valor de OFFSET

// Consulta SQL para obtener los registros
$consulta = "SELECT * FROM  productos LIMIT $inicio, $registros_por_pagina";
$resultados = $mysqli->query($consulta);

// Verificar si la consulta fue exitosa
if (!$resultados) {
    die("Error al ejecutar la consulta: " . $mysqli->error);
}

// Calcular el número total de registros
$total_registros_query = "SELECT COUNT(*) AS total FROM   productos";
$total_resultados = $mysqli->query($total_registros_query);
$total_registros = $total_resultados->fetch_assoc()['total'];

// Calcular el número total de páginas
$total_paginas = ceil($total_registros / $registros_por_pagina);



        // Consulta utilizando MySQLi.......
        $consulta = "SELECT * FROM productos ORDER BY id_producto";
        $resultados = $mysqli->query($consulta);

        // Comprobación de errores en la ejecución de la consulta
        if (!$resultados) {
            die("Error al ejecutar la consulta: " . $mysqli->error);
        }

// Obtener el término de búsqueda
$searchQuery = isset($_GET['search-query']) ? $_GET['search-query'] : '';

// Construir la consulta SQL con filtro si hay búsqueda..........
if (!empty($searchQuery)) {
    $consulta = "SELECT * FROM productos WHERE 
                 nombre_producto LIKE '%$searchQuery%' OR 
                 estado LIKE '%$searchQuery%' OR 
                 detalles LIKE '%$searchQuery%'
                 ORDER BY id_producto";
} else {
    $consulta = "SELECT * FROM productos ORDER BY id_producto";
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
        <link href="style.css" type="text/css" rel="stylesheet"> 
    </head>
    <body>


    <div class="panel">
        <div class="column">
            <h2>Módulo de productos</h2>
            <ul class="nav">
                <li><i class="fas fa-edit icon"></i><a href='insert.php?da=Products-2'>Insert Products</a></li>
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
               placeholder="Buscar productos..." value="<?php echo htmlspecialchars($searchQuery); ?>">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-search"></i> Buscar
        </button>
    </form>


               
    <table class="table table-bordered table-hover">
    <thead class="bg-primary text-white">
             
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Producto</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Cantidad stock</th>
                        <th scope="col">Categoria</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Fecha adquisición</th>
                        <th scope="col">Fecha de vencimiento</th>
                        <th scope="col">Proveedor</th>
                        <th scope="col">Detalles</th>
                        <th scope="col">Archivo</th>
                        <th scope="col">Código Barras</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
</tr>

        <tbody>
        <?php
        

        // Iterar sobre los resultados y mostrarlos
        while ($producto = $resultados->fetch_assoc()) {
        ?>
            <tr>
                <td><?php echo htmlspecialchars($producto['id_producto']); ?></td>
                <td><?php echo htmlspecialchars($producto['nombre_producto']); ?></td>
                <td>$ <?php echo number_format($producto['precio'], 2, ',', '.'); ?></td>
                <td><?php echo htmlspecialchars($producto['cantidad_stock']); ?></td>
                <td><?php echo htmlspecialchars($producto['categoria_productos']); ?></td>
                <td><?php echo htmlspecialchars($producto['estado']); ?></td>
                <td><?php echo htmlspecialchars($producto['fecha_adquisicion']); ?></td>
                <td><?php echo htmlspecialchars($producto['fecha_vencimiento']); ?></td>
                <td><?php echo htmlspecialchars($producto['id_proveedor']); ?></td>
                <td><?php echo htmlspecialchars($producto['detalles']); ?></td>
                <td><img src="../../public/img/Catalogo/<?php echo $producto['archivo']; ?>" width="100" alt=""></td>
                <td><?php echo htmlspecialchars($producto['codigo_barras']); ?></td>
                
                
                <td> 
                   <!-- Botón para editar -->  
                   <a href="edit.php?da=Products-3&lla=<?php echo $producto['id_producto']; ?>"  class="btn btn-custom-green btn-editar">
                <i class="fas fa-edit icon"></i> Editar

<!-- Botón de Borrar -->
<a href="#" class="btn btn-danger btn-borrar" onclick="borrarProducto(<?php echo $producto['id_producto']; ?>, '<?php echo $producto['archivo'];  ?>')">
    <i class="fas fa-trash-alt"></i> Borrar
</a>
            </tr>
        <?php
        }

        // Cerrar la conexión
        $mysqli->close();
        ?>
        </tbody>
    </table>

   



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
    function borrarProducto(id, imagen) {
        if (confirm('¿Está seguro de borrar el producto?')) {
            // Realizar una petición AJAX para borrar el producto
            var xhr = new XMLHttpRequest();

            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Éxito en la eliminación del producto
                        alert('Producto eliminado correctamente.');
                        // Recargar la página para reflejar los cambios
                        location.reload();
                    } else {
                        // Error al eliminar el producto
                        alert('Error al eliminar el producto.');
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

