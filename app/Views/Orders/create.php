<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
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

// Obtener el término de búsqueda
$searchQuery = isset($_GET['search-query']) ? $_GET['search-query'] : '';

// Construir la consulta SQL con filtro si hay búsqueda
if (!empty($searchQuery)) {
    $consulta = "SELECT * FROM pedidos WHERE 
                 nombre_pedido LIKE '%$searchQuery%' OR 
                 estado LIKE '%$searchQuery%' OR 
                 direccion LIKE '%$searchQuery%'
                 ORDER BY id_pedido";
} else {
    $consulta = "SELECT * FROM pedidos ORDER BY id_pedido";
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


    </style>
</head>
<body>

    <div class="panel">
        <div class="column">
            <h2>Módulo de pedidos</h2>
            <ul class="nav">
                <li><i class="fas fa-edit icon"></i><a href='insert.php?da=2'>Insert Pedidos</a></li>
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

    
    
    <div class="container-fluid">
    <div class="table-container">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="thead-light">
                <tr>
                    <th>Id</th>
                    <th>Pedido</th>
                    <th>Precio</th>
                    <th>Estado</th>
                    <th>Dirección</th>
                    <th>Descripción</th>
                    <th>Seguimiento</th>
                    <th>Tiempo Entrega</th>
                    <th>Información</th>
                    <th>Método Pago</th>
                    <th>Archivo</th>
                    <th>Fecha pedido</th>
                    <th>Fecha entrega</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($pedido = $resultados->fetch_assoc()): ?>
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
                        <td><img src="../../public/img/pedidos-imagen/<?php echo $pedido['archivo']; ?>" width="100"></td>
                        <td><?php echo htmlspecialchars($pedido['fecha_pedido']); ?></td>
                        <td><?php echo htmlspecialchars($pedido['fecha_entrega']); ?></td>
                        <td>
                            <a href="edit.php?da=3&lla=<?php echo $pedido['id_pedido']; ?>" class="btn btn-sm btn-primary">Editar</a>
                            <a href="#" class="btn btn-sm btn-danger" onclick="borrarPedido(<?php echo $pedido['id_pedido']; ?>, '<?php echo $pedido['archivo']; ?>')">Borrar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function borrarPedido(id, imagen) {
    if (confirm('¿Está seguro de borrar el pedido?')) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'delete.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (xhr.status === 200) {
                alert('Pedido eliminado correctamente.');
                location.reload();
            } else {
                alert('Error al eliminar el pedido.');
            }
        };
        xhr.send('id_pedido=' + id + '&imagen=' + imagen);
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
