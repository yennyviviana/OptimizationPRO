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


// Establecer los valores de paginación
$registros_por_pagina = 10;  // Número de registros por página
$página_actual = isset($_GET['page']) ? (int)$_GET['page'] : 1;  // Página actual
$inicio = ($página_actual - 1) * $registros_por_pagina;  // Calcular el valor de OFFSET

// Consulta SQL para obtener los registros
$consulta = "SELECT * FROM  pedidos LIMIT $inicio, $registros_por_pagina";
$resultados = $mysqli->query($consulta);

// Verificar si la consulta fue exitosa
if (!$resultados) {
    die("Error al ejecutar la consulta: " . $mysqli->error);
}

// Calcular el número total de registros
$total_registros_query = "SELECT COUNT(*) AS total FROM  pedidos";
$total_resultados = $mysqli->query($total_registros_query);
$total_registros = $total_resultados->fetch_assoc()['total'];

// Calcular el número total de páginas
$total_paginas = ceil($total_registros / $registros_por_pagina);



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
    <title>Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<!-- Bootstrap 5 CSS (en <head>) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap 5 JS + Popper.js (al final del body) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body>


<style>
/* Estilos personalizados */
body {
    background-color: #fff;
    color: #f5f5f5;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.table-container {
    background-color: #1a1a1a; 
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0,0,0,0.4);
}


.table {
    max-width: 1200px; /* puedes reducir a 1000 o 900px si es muy ancha */
    margin: 0 auto; /* centra horizontalmente */
    overflow-x: auto; /* para que en móviles haya scroll horizontal */
    background-color: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 12px rgba(0,0,0,0.1);
}



.table th {
    background-color: hsl(263, 93.20%, 17.30%);
    color: white;
    text-align: center;
    font-weight: bold;
    padding: 12px;
}

.table td {
    padding: 10px;
    color: #333;
}

.table tbody tr:nth-child(odd) {
    background-color: #f2f2f2;
}

.table tbody tr:hover {
    background-color: #d1ecf1;
    transition: background-color 0.3s;
}

.panel {
    display: flex;
    justify-content: space-between;
    border: 1px solid #333;
    padding: 20px;
    border-radius: 8px;
    background-color: hsl(240, 0.90%, 21.00%);
    box-shadow: 0 0 10px rgba(0,0,0,0.3);
    flex-wrap: wrap;
    gap: 15px;
}

.column {
    width: 48%;
}

h2 {
    color: whitesmoke;
    margin-bottom: 15px;
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
    border-radius: 4px;
    transition: all 0.2s ease-in-out;
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
    transition: background-color 0.3s, color 0.3s;
}

.btn:hover {
    background-color: #ff6f61;
    color: #fff;
}

.icono-editar {
  color: #007bff; /* azul Bootstrap */
  font-size: 20px;
  transition: 0.3s;
}

.icono-editar:hover {
  color: #0056b3;
}

.icono-borrar {
  color: #dc3545; /* rojo Bootstrap */
  font-size: 20px;
  transition: 0.3s;
}

.icono-borrar:hover {
  color: #a71d2a;
}

  .mi-estilo-modal {
    border: 3px solid #007bff;
    border-radius: 15px;
    box-shadow: 0 0 15px rgba(0,0,0,0.4);
  }

  .modal-body {
    font-size: 16px;
    color: #333;
  }

  .modal-body p span {
    font-weight: bold;
    color: #0066cc;
  }


  .modal-title{
    color: #000;
  }
/* Ajuste de estilos para el editor CKEditor */
.ck-editor__editable {
    min-height: 150px;
}
</style>
    <div class="panel">
        <div class="column">
            <h2>Orders Module</h2>
            <ul class="nav">
                <li><i class="fas fa-edit icon"></i><a href='insert.php?da=Orders-2'>Order Insert</a></li>
                <li class="nav-item">
                <a class="nav-link" href="/OptimizationPRO/app/main.php">
                                <span data-feather="Home"></span>
                                Go back
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
               placeholder="Search orders..." value="<?php echo htmlspecialchars($searchQuery); ?>">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-search"></i>Search
        </button>
    </form>


    
  <!-- Tabla principal -->
<div class="table">
  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th>ID</th>
        <th>Referencia</th>
        <th>Total</th>
        <th>Estado</th>
        <th>Fecha Entrega</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($pedido = $resultados->fetch_assoc()): ?>
      <tr>
        <td><?= htmlspecialchars($pedido['id_pedido']) ?></td>
        <td><?= htmlspecialchars($pedido['referencia']) ?></td>
        <td>$ <?= number_format($pedido['total'], 2, ',', '.') ?></td>
        <td><?= htmlspecialchars($pedido['estado']) ?></td>
        <td><?= htmlspecialchars($pedido['fecha_entrega']) ?></td>
        <td>
          <button class="btn btn-sm btn-info" 
            data-bs-toggle="modal" 
            data-bs-target="#detalleModal"
            data-id="<?= $pedido['id_pedido'] ?>"
            data-referencia="<?= htmlspecialchars($pedido['referencia']) ?>"
            data-direccion="<?= htmlspecialchars($pedido['direccion_entrega']) ?>"
            data-observaciones="<?= htmlspecialchars($pedido['observaciones']) ?>"
            data-tracking="<?= htmlspecialchars($pedido['tracking']) ?>"
            data-tiempo="<?= htmlspecialchars($pedido['tiempo_estimado_horas']) ?>"
            data-usuario="<?= htmlspecialchars($pedido['id_usuario']) ?>"
            data-metodo="<?= htmlspecialchars($pedido['metodo_pago']) ?>"
            data-archivo="<?= $pedido['archivo_adjunto'] ?>"
            data-fecha_pedido="<?= htmlspecialchars($pedido['fecha_pedido']) ?>"
            data-detalles="<?= htmlspecialchars($pedido['detalles']) ?>"
          >Ver detalles</button>
          <a href="edit.php?da=Orders-3&lla=<?= $pedido['id_pedido'] ?>" title="Editar">
            <i class="fas fa-edit icono-editar"></i>
          </a>
          
          <a href="#" title="Borrar" onclick="borrarPedido(<?= $pedido['id_pedido'] ?>, '<?= $pedido['archivo_adjunto'] ?>')">
            <i class="fas fa-trash-alt icono-borrar"></i>
          </a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<!-- Modal Detalles -->
      <div class="modal-header bg-primary text-white">
<div class="modal fade" id="detalleModal" tabindex="-1" aria-labelledby="detalleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detalles del Pedido</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <p><strong>Referencia:</strong> <span id="modal-referencia"></span></p>
        <p><strong>Dirección:</strong> <span id="modal-direccion"></span></p>
        <p><strong>Observaciones:</strong> <span id="modal-observaciones"></span></p>
        <p><strong>Tracking:</strong> <span id="modal-tracking"></span></p>
        <p><strong>Tiempo estimado:</strong> <span id="modal-tiempo"></span> horas</p>
        <p><strong>Usuario:</strong> <span id="modal-usuario"></span></p>
        <p><strong>Método de pago:</strong> <span id="modal-metodo"></span></p>
        <p><strong>Archivo:</strong><br><img id="modal-archivo" src="" width="150"></p>
        <p><strong>Fecha pedido:</strong> <span id="modal-fecha-pedido"></span></p>
        <p><strong>Detalles:</strong> <span id="modal-detalles"></span></p>
      </div>
    </div>
  </div>
</div>

<!-- Script para llenar el modal -->
<script>
  const detalleModal = document.getElementById('detalleModal');
  detalleModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    document.getElementById('modal-referencia').textContent = button.getAttribute('data-referencia');
    document.getElementById('modal-direccion').textContent = button.getAttribute('data-direccion');
    document.getElementById('modal-observaciones').textContent = button.getAttribute('data-observaciones');
    document.getElementById('modal-tracking').textContent = button.getAttribute('data-tracking');
    document.getElementById('modal-tiempo').textContent = button.getAttribute('data-tiempo');
    document.getElementById('modal-usuario').textContent = button.getAttribute('data-usuario');
    document.getElementById('modal-metodo').textContent = button.getAttribute('data-metodo');
    document.getElementById('modal-fecha-pedido').textContent = button.getAttribute('data-fecha_pedido');
    document.getElementById('modal-detalles').textContent = button.getAttribute('data-detalles');
    const archivo = button.getAttribute('data-archivo');
    document.getElementById('modal-archivo').src = '../../public/files/uploads/pedidos/' + archivo;
  });
</script>


 <!-- Paginación....... -->
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
                // Actualizar la tabla con los resultados......
                resultsTable.innerHTML = xhr.responseText;
            } else {
                console.error('Error al realizar la búsqueda.');
            }
        };

        xhr.send('searchQuery=' + encodeURIComponent(searchQuery));
    });
});
</script>


<script>
    
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