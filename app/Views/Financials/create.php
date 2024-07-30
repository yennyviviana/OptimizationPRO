<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit;
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
    <style>
        body {
            background-color: #000;
        }
        .panel {
            display: flex;
            justify-content: space-between;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 8px;
            background-color: #234DF0;
        }
        .column {
            width: 48%;
        }
        h2, h3 {
            color: whitesmoke;
        }
        h2 {
            text-align: left; /* Alineación del título a la izquierda */
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
            background-color: #fff;
            color: #fff;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .btn-borrar {
            display: inline-block;
            padding: 7px 10px;
            font-size: 14px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            background-color: #0071FA;
            color: #fff;
            transition: background-color 0.3s;
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
            background-color: blue;
            color: #fff;
            transition: background-color 0.3s;
        }
        .btn-editar:hover {
            background-color: #59A3F7;
        }
        .chart-container {
            width: 50%;
            margin: 0 auto; 
        }
        canvas {
            width: 100% !important; /* Asegura que el canvas ocupe todo el ancho del contenedor */
        }
    </style>
</head>
<body>
    <div class="panel">
        <div class="column">
            <h2>Módulo financiero</h2>
            <ul class="nav">
                <li><i class="fas fa-edit icon"></i><a href='insert.php?da=2'>Registro financiero</a></li>
                <li class="nav-item">
                <a class="nav-link" href="/OptimizationPRO/app/main.php">
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
                    <th scope="col">Fecha_transaccion</th>
                    <th scope="col">Monto</th>
                    <th scope="col">Tipo_transaccion</th>
                    <th scope="col">Descripcion</th>
                    <th scope="col">Usuario</th>
                    <th scope="col">Proveedor</th>
                    <th scope="col">Cliente</th>
                    <th scope="col">Pedido</th>
                    <th scope="col">Codigo inventario</th>
                    <th scope="col">Producto</th>
                    <th scope="col">Compra</th>
                    <th scope="col">Proyecto</th>
                    <th scope="col">Acciones</th>
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

                // Establecer juego de caracteres UTF-8
                mysqli_set_charset($mysqli, 'utf8');

                // Consulta utilizando MySQLi
                $consulta = "SELECT * FROM financieras ORDER BY id_transaccion";
                $resultados = $mysqli->query($consulta);

                // Comprobación de errores en la ejecución de la consulta
                if (!$resultados) {
                    die("Error al ejecutar la consulta: " . $mysqli->error);
                }

                $monto = array();
                $fecha = array();
                $tipo_transaccion = array();
                $monto_por_tipo = array();

                // Iterar sobre los resultados y mostrarlos
                while ($financiera = $resultados->fetch_assoc()) {
                    $monto[] = $financiera['monto'];
                    $fecha[] = $financiera['fecha_transaccion'];
                    
                    $tipo = $financiera['tipo_transaccion'];
                    if (!isset($monto_por_tipo[$tipo])) {
                        $monto_por_tipo[$tipo] = 0;
                    }
                    $monto_por_tipo[$tipo] += $financiera['monto'];
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars($financiera['id_transaccion']); ?></td>
                        <td><?php echo htmlspecialchars($financiera['fecha_transaccion']); ?></td>
                        <td>$ <?php echo number_format($financiera['monto'], 2, ',', '.'); ?></td>
                        <td><?php echo htmlspecialchars($financiera['tipo_transaccion']); ?></td>
                        <td><?php echo htmlspecialchars($financiera['descripcion']); ?></td>
                        <td><?php echo htmlspecialchars($financiera['id_usuario']); ?></td>
                        <td><?php echo htmlspecialchars($financiera['id_proveedor']); ?></td>
                        <td><?php echo htmlspecialchars($financiera['id_cliente']); ?></td>
                        <td><?php echo htmlspecialchars($financiera['id_pedido']); ?></td>
                        <td><?php echo htmlspecialchars($financiera['codigo_inventario']); ?></td>
                        <td><?php echo htmlspecialchars($financiera['id_producto']); ?></td>
                        <td><?php echo htmlspecialchars($financiera['id_compra']); ?></td>
                        <td><?php echo htmlspecialchars($financiera['id_proyecto']); ?></td>
                        <td>
                            <a href="edit.php?da=3&lla=<?php echo $financiera['id_transaccion']; ?>" class="btn btn-custom-green btn-editar">
                                <i class="fas fa-edit icon"></i> Editar
                            </a>

                            <a href="#" class="btn btn-danger btn-borrar" onclick="borrarFinanciera(<?php echo $financiera['id_transaccion']; ?>)">
                                <i class="fas fa-trash-alt"></i> Borrar
                            </a>
                        </td>
                    </tr>
                <?php
                }

                // Cerrar la conexión
                $mysqli->close();

                // Preparar los datos para los gráficos
                $tipos = array_keys($monto_por_tipo);
                $monto_tipos = array_values($monto_por_tipo);
                ?>
            </tbody>
        </table>
    </div>

    <div class="container mt-5 chart-container">
        <h3>Gráfico de Monto por Fecha</h3>
        <canvas id="financialChartDoughnut"></canvas>
    </div>

    <div class="container mt-5 chart-container">
        <h3>Gráfico de Monto por Tipo de Transacción</h3>
        <canvas id="financialChartBar"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function borrarFinanciera(id) {
            if (confirm('¿Está seguro de borrar?')) {
                // Realizar una petición AJAX para borrar estado financiero
                var xhr = new XMLHttpRequest();

                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            // Éxito en la eliminación estado financiero
                            alert('Dato Financiero eliminado correctamente.');
                            // Recargar la página para reflejar los cambios
                            location.reload();
                        } else {
                            // Error al eliminar el estado financiero
                            alert('Error al eliminar el estado financiero.');
                        }
                    }
                };

                // Configurar la petición AJAX
                xhr.open('GET', 'delete.php?lla=' + id, true);
                // Enviar la petición
                xhr.send();
            }
        }

        // Gráfico de Doughnut
        var ctxDoughnut = document.getElementById('financialChartDoughnut').getContext('2d');
        var financialChartDoughnut = new Chart(ctxDoughnut, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode($fecha); ?>,
                datasets: [{
                    label: 'Monto',
                    data: <?php echo json_encode($monto); ?>,
                    backgroundColor: [
                        'rgba(0, 123, 255, 0.2)',
                        'rgba(40, 167, 69, 0.2)',
                        'rgba(0, 123, 255, 0.2)',
                        'rgba(40, 167, 69, 0.2)',
                        'rgba(0, 123, 255, 0.2)',
                        'rgba(40, 167, 69, 0.2)'
                    ],
                    borderColor: [
                        'rgba(0, 123, 255, 1)',
                        'rgba(40, 167, 69, 1)',
                        'rgba(0, 123, 255, 1)',
                        'rgba(40, 167, 69, 1)',
                        'rgba(0, 123, 255, 1)',
                        'rgba(40, 167, 69, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': $' + tooltipItem.raw.toLocaleString();
                            }
                        }
                    }
                }
            }
        });

        // Gráfico de Barras
        var ctxBar = document.getElementById('financialChartBar').getContext('2d');
        var financialChartBar = new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($tipos); ?>,
                datasets: [{
                    label: 'Monto por Tipo de Transacción',
                    data: <?php echo json_encode($monto_tipos); ?>,
                    backgroundColor: 'rgba(0, 123, 255, 0.2)',
                    borderColor: 'rgba(0, 123, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': $' + tooltipItem.raw.toLocaleString();
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
