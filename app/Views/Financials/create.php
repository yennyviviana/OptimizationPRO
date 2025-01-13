<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit;
}

define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DBNAME', 'sofware_erp');

// Conectar a MySQL
$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DBNAME);

if ($mysqli->connect_error) {
    die('Error al conectarse a MySQL: ' . $mysqli->connect_error);
}

$mysqli->set_charset('utf8');

// Obtener el término de búsqueda
$searchQuery = isset($_GET['search-query']) ? $_GET['search-query'] : '';

// Construir la consulta SQL
$consulta = "SELECT * FROM financieras ";
if (!empty($searchQuery)) {
    $consulta .= "WHERE 
                    fecha_transaccion LIKE '%$searchQuery%' OR 
                    monto LIKE '%$searchQuery%' OR 
                    tipo_transaccion LIKE '%$searchQuery%'";
}
$consulta .= " ORDER BY id_transaccion";

$resultados = $mysqli->query($consulta);

if (!$resultados) {
    die("Error al ejecutar la consulta: " . $mysqli->error);
}

// Preparar datos para gráficos
$monto = [];
$fecha = [];
$monto_por_tipo = [];
while ($financiera = $resultados->fetch_assoc()) {
    $monto[] = $financiera['monto'];
    $fecha[] = $financiera['fecha_transaccion'];
    $tipo = $financiera['tipo_transaccion'];
    $monto_por_tipo[$tipo] = ($monto_por_tipo[$tipo] ?? 0) + $financiera['monto'];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Módulo financiero</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #000; color: #f5f5f5; }
        .table th, .table td { color: #fff; }
        .btn-borrar:hover { background-color: #c82333; }
        .btn-editar:hover { background-color: #0B1CDB; }


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
            <h2>Módulo  Financiero</h2>
            <ul class="nav">
                <li><i class="fas fa-edit icon"></i><a href='insert.php?da=2'>Insert registro</a></li>
                <li class="nav-item">
                <a class="nav-link" href="/OptimizationPRO/app/main.php">
                                <span data-feather="Home"></span>
                                 Regresar
                            </a>
                        </li>
            </ul>
        </div>
    </div>

    


    <form method="GET" class="d-flex justify-content-center mt-4 mb-3">
        <input type="text" name="search-query" class="form-control w-50 me-2" 
               placeholder="Buscar pedidos..." value="<?= htmlspecialchars($searchQuery) ?>">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-search"></i> Buscar
        </button>
    </form>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead class="thead-light">
                <tr>
                    <th>Id</th>
                    <th>Fecha</th>
                    <th>Monto</th>
                    <th>Tipo</th>
                    <th>Descripción</th>
                    <th>Usuario</th>
                    <th>Proveedor</th>
                    <th>Cliente</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php $resultados->data_seek(0); // Reiniciar puntero ?>
                <?php while ($financiera = $resultados->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($financiera['id_transaccion']) ?></td>
                        <td><?= htmlspecialchars($financiera['fecha_transaccion']) ?></td>
                        <td>$ <?= number_format($financiera['monto'], 2, ',', '.') ?></td>
                        <td><?= htmlspecialchars($financiera['tipo_transaccion']) ?></td>
                        <td><?= htmlspecialchars($financiera['descripcion']) ?></td>
                        <td><?= htmlspecialchars($financiera['id_usuario']) ?></td>
                        <td><?= htmlspecialchars($financiera['id_proveedor']) ?></td>
                        <td><?= htmlspecialchars($financiera['id_cliente']) ?></td>
                        <td>
                            <a href="edit.php?lla=<?= $financiera['id_transaccion'] ?>" class="btn btn-primary btn-editar">Editar</a>
                            <button class="btn btn-danger btn-borrar" onclick="borrarFinanciera(<?= $financiera['id_transaccion'] ?>)">Borrar</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
  

    const doughnutCtx = document.getElementById('financialChartDoughnut').getContext('2d');
    const barCtx = document.getElementById('financialChartBar').getContext('2d');

    new Chart(doughnutCtx, {
        type: 'doughnut',
        data: {
            labels: <?= json_encode(array_keys($monto_por_tipo)) ?>,
            datasets: [{
                data: <?= json_encode(array_values($monto_por_tipo)) ?>,
                backgroundColor: ['#007BFF', '#28A745', '#FF5733']
            }]
        }
    });

    new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($fecha) ?>,
            datasets: [{
                label: 'Monto',
                data: <?= json_encode($monto) ?>,
                backgroundColor: '#007BFF'
            }]
        }
    });
</script>


<script>
function borrarFinanciera(id) {
    if (confirm('¿Está seguro de borrar el registro?')) {
        // Realizar una petición AJAX para borrar la compra
        var xhr = new XMLHttpRequest();

        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Éxito en la eliminación de el registro financiero
                    alert('Financiero eliminada correctamente.');
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

</body>
</html>
