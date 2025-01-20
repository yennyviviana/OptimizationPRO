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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/core/main.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid/main.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<!-- Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JS (con Popper.js) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/js/bootstrap.min.js"></script>

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


        .toast {
    transition: opacity 0.3s ease;
}

.toast.show {
    opacity: 1 !important;
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

                    <!-- Menú de Admin..... -->
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
                        <a class="d-flex align-items-center text-muted" href="/OptimizationPRO/app/Views/Users_config/perfil.php"><span data-feather="settings"></span></a>
                    </h6>
                    <ul class="nav flex-column mb-2">
                        <li class="nav-item"><a class="nav-link" href="/OptimizationPRO/app/Views/Users_config/perfil.php"><span data-feather="user"></span>Perfil</a></li>
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
        <!-- Botón para abrir el modal de ayuda -->
        <button class="btn btn-sm btn-outline-secondary" id="help">Ayuda</button>
    </div>
</div>

<!-- Modal de Ayuda -->
<div class="modal" id="helpModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ayuda</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Escoge opcion.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>


                <button class="btn btn-sm btn-outline-secondary" id="toggle-theme">
          <i data-feather="moon"></i> Cambiar Tema......
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://unpkg.com/feather-icons"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>


<div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="eventForm">
      <div class="modal-header">
  <h5 class="modal-title" id="eventModalLabel">Gestionar Evento</h5>
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

        <div class="modal-body">
          <div class="mb-3">
            <label for="title" class="form-label">Título del Evento</label>
            <input type="text" class="form-control" id="title" name="title" required>
          </div>
          <div class="mb-3">
            <label for="start" class="form-label">Fecha y Hora de Inicio</label>
            <input type="datetime-local" class="form-control" id="start" name="start" required>
          </div>
          <div class="mb-3">
            <label for="end" class="form-label">Fecha y Hora de Fin</label>
            <input type="datetime-local" class="form-control" id="end" name="end">
          </div>
        </div>
        <div class="modal-footer">
          <!-- Botones dinámicos -->
          <button type="button" id="saveEventButton" class="btn btn-primary">Crear</button>
          <button type="button" id="editEventButton" class="btn btn-success" style="display: none;">Guardar Cambios</button>
          <button type="button" id="deleteEventButton" class="btn btn-danger" style="display: none;">Eliminar</button>
          <button type="button" class="btn btn-secondary" id="closeModalButton">Cerrar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');
    const modalEl = document.getElementById('eventModal');
    const modalBootstrap = new bootstrap.Modal(modalEl);
    let selectedEventId = null; 

    const events = [ // Ejemplo de eventos
        { title: 'Evento 1', start: '2025-01-20T10:00:00', end: '2025-01-20T12:00:00', id: 1 },
        { title: 'Evento 2', start: '2025-01-20T14:00:00', end: '2025-01-20T16:00:00', id: 2 },
    ];

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        editable: true,
        selectable: true,
        events: events,
        dateClick: function (info) {
            // Limpiar formulario para Crear
            document.getElementById('eventForm').reset();
            document.getElementById('start').value = info.dateStr + "T09:00";
            document.getElementById('end').value = info.dateStr + "T10:00";

            selectedEventId = null;
            modalBootstrap.show();

            // Mostrar solo el botón Crear
            toggleButtons({ save: true });
        },
        eventClick: function (info) {
            const event = info.event;
            document.getElementById('title').value = event.title;
            document.getElementById('start').value = event.start.toISOString().slice(0, 16);
            document.getElementById('end').value = event.end ? event.end.toISOString().slice(0, 16) : '';

            selectedEventId = event.id;
            modalBootstrap.show();

            // Mostrar los botones Editar y Eliminar
            toggleButtons({ edit: true, delete: true });
        }
    });

    calendar.render();

    // Botón Crear
    document.getElementById('saveEventButton').addEventListener('click', function () {
        const title = document.getElementById('title').value;
        const start = document.getElementById('start').value;
        const end = document.getElementById('end').value;

        fetch('Views/eventos.php', {
            method: 'POST',
            body: new URLSearchParams({ title, start, end, action: 'create' }),
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                calendar.addEvent({ title, start, end, id: data.eventId });
                modalBootstrap.hide();
            } else {
                alert('Error al crear el evento.');
            }
        });
    });

    // Botón Editar
    document.getElementById('editEventButton').addEventListener('click', function () {
        const title = document.getElementById('title').value;
        const start = document.getElementById('start').value;
        const end = document.getElementById('end').value;

        fetch('Views/eventos.php', {
            method: 'POST',
            body: new URLSearchParams({ id: selectedEventId, title, start, end, action: 'edit' }),
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const event = calendar.getEventById(selectedEventId);
                event.setProp('title', title);
                event.setStart(start);
                event.setEnd(end);
                modalBootstrap.hide();
            } else {
                alert('Error al editar el evento.');
            }
        });
    });

    // Botón Eliminar
    document.getElementById('deleteEventButton').addEventListener('click', function () {
        fetch('Views/eventos.php', {
            method: 'POST',
            body: new URLSearchParams({ id: selectedEventId, action: 'delete' }),
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const event = calendar.getEventById(selectedEventId);
                event.remove();
                modalBootstrap.hide();
            } else {
                alert('Error al eliminar el evento.');
            }
        });
    });

    // Botón Cerrar (cerrar el modal con JavaScript)
    document.getElementById('closeModalButton').addEventListener('click', function () {
        modalBootstrap.hide(); // Cerrar el modal programáticamente
    });
    // Función para alternar botones según la acción
    function toggleButtons({ save = false, edit = false, delete: del = false }) {
        document.getElementById('saveEventButton').style.display = save ? 'block' : 'none';
        document.getElementById('editEventButton').style.display = edit ? 'block' : 'none';
        document.getElementById('deleteEventButton').style.display = del ? 'block' : 'none';
    }
});

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
    


    document.addEventListener('DOMContentLoaded', function () {
    // Inicializamos Feather Icons para renderizar el ícono
    feather.replace();

    // Función para cambiar el tema
    const toggleThemeButton = document.getElementById('toggle-theme');
    const body = document.body;

    // Si ya hay un tema oscuro en la sesión (en caso de recargar la página), lo aplicamos
    if (localStorage.getItem('dark-theme') === 'true') {
        body.classList.add('dark-theme');
        feather.replace(); // Vuelve a cargar el ícono si es necesario
    }

    toggleThemeButton.addEventListener('click', function () {
        body.classList.toggle('dark-theme');

        // Guardamos la preferencia del tema en el almacenamiento local para futuras visitas
        const isDarkTheme = body.classList.contains('dark-theme');
        localStorage.setItem('dark-theme', isDarkTheme);

        // Cambiar el ícono de luna a sol dependiendo del tema
        if (isDarkTheme) {
            toggleThemeButton.innerHTML = '<i data-feather="sun"></i> Cambiar Tema'; // Muestra el ícono de sol
        } else {
            toggleThemeButton.innerHTML = '<i data-feather="moon"></i> Cambiar Tema'; // Vuelve a mostrar la luna
        }

        feather.replace(); // Vuelve a cargar los íconos después del cambio
    });
});


document.getElementById('addElement').addEventListener('click', function (e) {
    e.preventDefault(); // Evitar el comportamiento por defecto (si es necesario)
    alert('Elemento agregado con éxito');
    // Puedes agregar elementos dinámicamente aquí, por ejemplo:
    const newElement = document.createElement('div');
    newElement.textContent = 'Nuevo Elemento';
    document.body.appendChild(newElement); // Lo agrega al body (puedes elegir otro contenedor)
});


document.getElementById('deleteElement').addEventListener('click', function (e) {
    e.preventDefault();
    alert('Elemento eliminado con éxito');
    // Ejemplo: eliminar el último elemento de un contenedor
    const container = document.body; // Cambia a un contenedor específico
    if (container.lastChild) {
        container.removeChild(container.lastChild);
    } else {
        alert('No hay más elementos para eliminar');
    }
});

document.getElementById('exportPdf').addEventListener('click', function (e) {
    e.preventDefault();
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();
    doc.text("Este es un PDF generado con jsPDF", 10, 10);
    doc.save('documento.pdf');
});

document.getElementById('help').addEventListener('click', function (e) {
    e.preventDefault();
    const helpModal = new bootstrap.Modal(document.getElementById('helpModal'));
    helpModal.show();
});


</script>
</body>
</html>