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
$consulta = "SELECT * FROM proveedores LIMIT $inicio, $registros_por_pagina";
$resultados = $mysqli->query($consulta);

// Verificar si la consulta fue exitosa
if (!$resultados) {
    die("Error al ejecutar la consulta: " . $mysqli->error);
}

// Calcular el número total de registros
$total_registros_query = "SELECT COUNT(*) AS total FROM   proveedores";
$total_resultados = $mysqli->query($total_registros_query);
$total_registros = $total_resultados->fetch_assoc()['total'];

// Calcular el número total de páginas
$total_paginas = ceil($total_registros / $registros_por_pagina);





// Obtener el término de búsqueda
$searchQuery = isset($_GET['search-query']) ? $_GET['search-query'] : '';

// Construir la consulta SQL con filtro si hay búsqueda
if (!empty($searchQuery)) {
    $consulta = "SELECT * FROM proveedores WHERE 
                 nombre_empresa LIKE '%$searchQuery%' OR 
                 direccion LIKE '%$searchQuery%' OR 
                 telefono LIKE '%$searchQuery%'
                 ORDER BY id_proveedor";
} else {
    $consulta = "SELECT * FROM proveedores ORDER BY id_proveedor";
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
    <title>Modulo de proveedores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body>


<style>
/* Estilos personalizados */
body {
    background-color: #000;
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
    max-width: 1200px; 
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
            <h2>Módulo de proveedores</h2>
            <ul class="nav">
                <li><i class="fas fa-edit icon"></i><a href='insert.php?da=Suppliers-2'>Insert Proveedor</a></li>
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
               placeholder="Buscar proveedor..." value="<?php echo htmlspecialchars($searchQuery); ?>">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-search"></i> Buscar
        </button>
    </form>

   

    <div class="table-responsive">
  <table class="table table-bordered table-hover">
    <thead class="bg-primary text-white">
      <tr>
        <th scope="col">Id</th>
        <th scope="col">Producto</th>
        <th scope="col">Empresa</th>
        <th scope="col">Dirección</th>
        <th scope="col">Teléfono</th>
        <th scope="col">Email</th>
        <th scope="col">Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($proveedor = $resultados->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($proveedor['id_proveedor']) ?></td>
          <td><?= htmlspecialchars($proveedor['id_producto']) ?></td>
          <td><?= htmlspecialchars($proveedor['nombre_empresa']) ?></td>
          <td><?= htmlspecialchars($proveedor['direccion']) ?></td>
          <td><?= htmlspecialchars($proveedor['telefono']) ?></td>
          <td><?= htmlspecialchars($proveedor['correo_electronico']) ?></td>
          <td>
            <button class="btn btn-sm btn-info"
              data-bs-toggle="modal"
              data-bs-target="#detalleModal"
              data-condiciones_pago="<?= htmlspecialchars($proveedor['condiciones_pago']) ?>"
              data-metodo_pago="<?= htmlspecialchars($proveedor['metodo_pago']) ?>"
              data-descripcion="<?= htmlspecialchars($proveedor['descripcion']) ?>"
              data-historial_pedidos="<?= htmlspecialchars($proveedor['historial_pedidos']) ?>"
              data-archivo="<?= htmlspecialchars($proveedor['archivo']) ?>"
            >Ver detalles</button>

            <a href="edit.php?da=Suppliers-3&lla=<?= $proveedor['id_proveedor'] ?>" title="Editar">
              <i class="fas fa-edit icono-editar"></i>
            </a>

            <a href="#" title="Borrar" onclick="borrarProveedor(<?= $proveedor['id_proveedor'] ?>, '<?= $proveedor['archivo'] ?>')">
              <i class="fas fa-trash-alt icono-borrar"></i>
            </a>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<!-- Modal Detalles -->
<div class="modal fade" id="detalleModal" tabindex="-1" aria-labelledby="detalleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Detalles del Proveedor</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        
        <p><strong>Condiciones de Pago:</strong> <span id="modal-condiciones_pago"></span></p>
        <p><strong>Método de Pago:</strong> <span id="modal-metodo_pago"></span></p>
        <p><strong>Descripción:</strong> <span id="modal-descripcion"></span></p>
        <p><strong>Historial de Pedidos:</strong> <span id="modal-historial_pedidos"></span></p>
        <p><strong>Archivo:</strong><br><img id="modal-archivo" src="" width="150"></p>
      </div>
    </div>
  </div>
</div>

<!-- Script para llenar el modal con los datos -->
<script>
  const detalleModal = document.getElementById('detalleModal');
  detalleModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
  
    document.getElementById('modal-condiciones_pago').textContent = button.getAttribute('data-condiciones_pago');
    document.getElementById('modal-metodo_pago').textContent = button.getAttribute('data-metodo_pago');
    document.getElementById('modal-descripcion').textContent = button.getAttribute('data-descripcion');
    document.getElementById('modal-historial_pedidos').textContent = button.getAttribute('data-historial_pedidos');
    document.getElementById('modal-archivo').src = '../../public/files/uploads/proveedores/' + button.getAttribute('data-archivo');
  });
</script>

<!-- Función para borrar proveedor -->
<script>
function borrarProveedor(id, imagen) {
  if (confirm('¿Está seguro de borrar el proveedor?')) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'delete.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
      if (xhr.status === 200) {
        alert('Proveedor eliminado correctamente.');
        location.reload();
      } else {
        alert('Error al eliminar el proveedor.');
      }
    };
    xhr.send('id_proveedor=' + id + '&imagen=' + imagen);
  }
}
</script>
