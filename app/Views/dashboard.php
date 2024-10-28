<?php
session_start();
if(!isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit; // Asegúrate de salir después de redirigir para evitar ejecución adicional no deseada
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Panel ERP</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
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
            margin-left: 250px; /* Dejar espacio para el menú */
            padding: 20px;
        }
        .main-content .container {
            max-width: 1200px;
        }
        .dark-theme {
            background-color: #080808;
            color: #fff;
        }
        #calendar {
            max-width: 800px;
            margin: 20px auto; /* Espacio alrededor del calendario */
            padding: 10px;
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

                    <!-- Admin Menu -->
                    <?php if ($tipo_usuario == 9) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/OptimizationPRO/app/Views/Orders/create.php">
                                <span data-feather="shopping-cart"></span>
                                Area de pedidos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/OptimizationPRO/app/Views/Suppliers/create.php">
                                <span data-feather="users"></span>
                                Proveedores
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/OptimizationPRO/app/Views/Shopping/create.php">
                                <span data-feather="shopping-cart"></span>
                                Área de Compras
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/OptimizationPRO/app/Views/Customers/create.php">
                                <span data-feather="user-check"></span>
                                Clientes
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/OptimizationPRO/app/Views/Employees/create.php">
                                <span data-feather="user-plus"></span>
                                Recursos Humanos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/OptimizationPRO/app/Views/Products/create.php">
                                <span data-feather="package"></span>
                                Productos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/OptimizationPRO/app/Views/Financials/create.php">
                                <span data-feather="dollar-sign"></span>
                                Financiera
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/OptimizationPRO/app/Views/Inventorys/create.php">
                                <span data-feather="archive"></span>
                                Inventarios
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/OptimizationPRO/app/Views/Proyects/create.php">
                                <span data-feather="briefcase"></span>
                                Proyectos
                            </a>
                        </li>
                    <?php } ?>

                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>Usuario</span>
                        <a class="d-flex align-items-center text-muted" href="perfil.php">
                            <span data-feather="settings"></span>
                        </a>
                    </h6>
                    <ul class="nav flex-column mb-2">
                        <li class="nav-item">
                            <a class="nav-link" href="perfil.php">
                                <span data-feather="user"></span>
                                Perfil
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">
                                <span data-feather="log-out"></span>
                                Cerrar Sesión
                            </a>
                        </li>
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

                <!-- Div para mostrar resultados de las acciones -->
                <div id="results"></div>

                <button class="btn btn-sm btn-outline-secondary" id="toggle-theme">
                    <span data-feather="moon"></span> Cambiar Tema
                </button>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <canvas id="graficoBarra" width="400" height="400"></canvas>
                </div>
                <div class="col-md-6">
                    <canvas id="graficoDona" width="400" height="400"></canvas>
                </div>
            </div>

            <!-- Aquí se agrega el calendario -->
            <div id="calendar"></div>

        </main>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        feather.replace(); // Inicializando feather-icons

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
            dateClick: function (info) {
                let titulo = prompt('Introduce el título del evento:');
                if (titulo) {
                    fetch('guardar_evento.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ fecha: info.dateStr, titulo: titulo }),
                    })
                    .then(response => {
                        if (response.ok) {
                            calendar.addEvent({ title: titulo, start: info.dateStr });
                        } else {
                            alert('Error al guardar el evento');
                        }
                    });
                }
            },
            eventClick: function(info) {
                if (confirm('¿Eliminar este evento?')) {
                    fetch('eliminar_evento.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ id: info.event.id }),
                    })
                    .then(response => {
                        if (response.ok) {
                            info.event.remove();
                        } else {
                            alert('Error al eliminar el evento');
                        }
                    });
                }
            }
        });
        calendar.render();
    });
</script>
<script>

document.getElementById('addElement').addEventListener('click', function() {
    // Código para agregar un elemento
    const resultsDiv = document.getElementById('results');
    const newElement = document.createElement('div');
    newElement.textContent = 'Nuevo elemento agregado';
    resultsDiv.appendChild(newElement);
});

document.getElementById('deleteElement').addEventListener('click', function() {
    // Código para eliminar un elemento
    const resultsDiv = document.getElementById('results');
    if (resultsDiv.lastChild) {
        resultsDiv.removeChild(resultsDiv.lastChild);
    }
});

document.getElementById('exportPdf').addEventListener('click', function() {
    // Código para exportar a PDF
    alert('Funcionalidad de exportar a PDF no implementada.');
});

document.getElementById('help').addEventListener('click', function() {
    // Código para mostrar ayuda
    alert('Ayuda no disponible.');
});
</script>


</body>
</html>
