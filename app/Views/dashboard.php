<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit; // Asegúrate de salir después de redirigir
}

$nombre_usuario = $_SESSION['nombre_usuario'];
$correo_electronico = $_SESSION['correo_electronico'];
$tipo_usuario = $_SESSION['tipo_usuario'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.css">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <title>Panel ERP</title>
    <style>
        body {
            background-color: #F5F5F5;   
        }
        body.dark-theme {
            background-color: #080808;
            color: #fff;
        }
        body.dark-theme h1 {
            color: #ffa500; 
        }
        body.dark-theme .btn {
            background-color: hsl(239, 88%, 16%); 
            color: #fff; 
        }
        .main-content {
            margin-left: 250px; 
            padding: 20px;
        }
        .main-content .container {
            max-width: 1200px;
        }
        #calendar {
            max-width: 800px;
            margin: 20px auto; 
            padding: 10px;
        }
        .chart-container {
            max-width: 400px;
            margin: 20px auto;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="/">
                            <span data-feather="home"></span>
                            Home<span class="sr-only">(current)</span>
                        </a>
                    </li>

                    <!-- Menú de Admin -->
                    <?php if ($tipo_usuario == 9) { ?>
                        <li class="nav-item"><a class="nav-link" href="/OptimizationPRO/app/Views/Orders/create.php"><span data-feather="shopping-cart"></span>Área de pedidos</a></li>
                        <li class="nav-item"><a class="nav-link" href="/OptimizationPRO/app/Views/Suppliers/create.php"><span data-feather="users"></span>Proveedores</a></li>
                        <li class="nav-item"><a class="nav-link" href="/OptimizationPRO/app/Views/Shopping/create.php"><span data-feather="shopping-cart"></span>Área de Compras</a></li>
                        <li class="nav-item"><a class="nav-link" href="/OptimizationPRO/app/Views/Customers/create.php"><span data-feather="user-check"></span>Clientes</a></li>
                        <li class="nav-item"><a class="nav-link" href="/OptimizationPRO/app/Views/Employees/create.php"><span data-feather="user-plus"></span>Recursos Humanos</a></li>
                        <li class="nav-item"><a class="nav-link" href="/OptimizationPRO/app/Views/Products/create.php"><span data-feather="package"></span>Productos</a></li>
                        <li class="nav-item"><a class="nav-link" href="/OptimizationPRO/app/Views/Financials/create.php"><span data-feather="dollar-sign"></span>Financiera</a></li>
                        <li class="nav-item"><a class="nav-link" href="/OptimizationPRO/app/Views/Inventorys/create.php"><span data-feather="archive"></span>Inventarios</a></li>
                        <li class="nav-item"><a class="nav-link" href="/OptimizationPRO/app/Views/Proyects/create.php"><span data-feather="briefcase"></span>Proyectos</a></li>
                    <?php } ?>

                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>Usuario</span>
                        <a class="d-flex align-items-center text-muted" href="perfil.php"><span data-feather="settings"></span></a>
                    </h6>
                    <ul class="nav flex-column mb-2">
                        <li class="nav-item"><a class="nav-link" href="perfil.php"><span data-feather="user"></span>Perfil</a></li>
                        <li class="nav-item"><a class="nav-link" href="index.php"><span data-feather="log-out"></span>Cerrar Sesión</a></li>
                    </ul>
                </ul>
            </div>
        </nav>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">OptimizationPro</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group mr-2">
                        <button class="btn btn-sm btn-outline-secondary" id="addElement">Agregar Elemento</button>
                    </div>
                    <div class="btn-group mr-2">
                        <button class="btn btn-sm btn-outline-secondary" id="deleteElement">Eliminar</button>
                        <button class="btn btn-sm btn-outline-secondary" id="exportPdf">Exportar Pdf</button>
                        <button class="btn btn-sm btn-outline-secondary" id="help">Ayuda</button>
                    </div>
                </div>

                <button class="btn btn-sm btn-outline-secondary" id="toggle-theme">
                    <span data-feather="moon"></span> Cambiar Tema
                </button>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div id="calendar"></div>
                </div>
                <div class="col-md-6">
                    <div class="chart-container">
                        <canvas id="graficoBarra" width="400" height="400"></canvas>
                    </div>
                    <div class="chart-container">
                        <canvas id="graficoDona" width="400" height="400"></canvas>
                    </div>
                </div>
            </div>

        </main>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://unpkg.com/feather-icons"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        feather.replace();

        const toggleButton = document.getElementById('toggle-theme');
        const body = document.body;
        toggleButton.addEventListener('click', () => body.classList.toggle('dark-theme'));

        let calendarEl = document.getElementById('calendar');
        let calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'es',
            events: 'cargar_eventos.php',
            editable: true,
            selectable: true,
            dateClick: function(info) {
                alert('Fecha: ' + info.dateStr);
            }
        });
        calendar.render();

        // Gráficos
        const ctxBarra = document.getElementById('graficoBarra').getContext('2d');
        const graficoBarra = new Chart(ctxBarra, {
            type: 'bar',
            data: {
                labels: ['verde', 'Azul', 'Amarillo'],
                datasets: [{
                    label: '# de Votos',
                    data: [12, 19, 3],
                    backgroundColor: ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)'],
                    borderColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)'],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const ctxDona = document.getElementById('graficoDona').getContext('2d');
        const graficoDona = new Chart(ctxDona, {
            type: 'doughnut',
            data: {
                labels: ['Rojo', 'Azul', 'Amarillo'],
                datasets: [{
                    label: '# de Votos',
                    data: [12, 19, 3],
                    backgroundColor: ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)'],
                    borderColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true
            }
        });
    });
</script>
</body>
</html>