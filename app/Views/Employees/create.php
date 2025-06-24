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
$consulta = "SELECT * FROM  empleados LIMIT $inicio, $registros_por_pagina";
$resultados = $mysqli->query($consulta);

// Verificar si la consulta fue exitosa
if (!$resultados) {
    die("Error al ejecutar la consulta: " . $mysqli->error);
}

// Calcular el número total de registros
$total_registros_query = "SELECT COUNT(*) AS total FROM  empleados";
$total_resultados = $mysqli->query($total_registros_query);
$total_registros = $total_resultados->fetch_assoc()['total'];

// Calcular el número total de páginas
$total_paginas = ceil($total_registros / $registros_por_pagina);




// Obtener el término de búsqueda
$searchQuery = isset($_GET['search-query']) ? $_GET['search-query'] : '';

// Construir la consulta SQL con filtro si hay búsqueda
if (!empty($searchQuery)) {
    $consulta = "SELECT * FROM  empleados WHERE 
                 nombre_completo LIKE '%$searchQuery%' OR 
                 cargo LIKE '%$searchQuery%' OR 
                 direccion LIKE '%$searchQuery%'
                 ORDER BY id_empleado";
} else {
    $consulta = "SELECT * FROM  empleados ORDER BY id_empleado";
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
    <link href="style.css" type="text/css" rel="stylesheet"> 
</head>
<body>

    <div class="panel">
        <div class="column">
            <h2>Módulo de  empleados</h2>
            <ul class="nav">
                <li><i class="fas fa-edit icon"></i><a href='insert.php?da=Employees-2'>Insertar  empleados</a></li>
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

    
    
    <table class="table table-bordered table-hover">
    <thead class="bg-primary text-white">
            <tr>
            <tr>
  <th scope="col">Id</th>
  <th scope="col">Nombre</th>
  <th scope="col">Cargo</th>
  <th scope="col">Estado</th>
  <th scope="col">Departamento</th>
  <th scope="col">Tipo Documento</th>
  <th scope="col">Documento Identidad</th>
  <th scope="col">Dirección</th>
  <th scope="col">Teléfono</th>
  <th scope="col">Acciones</th>
    </thead>
    <tbody>
    <?php while ($empleado = $resultados->fetch_assoc()): ?>  


    
    <tr>
    <td><?php echo htmlspecialchars($empleado['id_empleado']); ?></td>
        <td><?php echo htmlspecialchars($empleado['nombre_completo']); ?></td>
        <td><?php echo htmlspecialchars($empleado['cargo']); ?></td>
        <td><?php echo htmlspecialchars($empleado['estado']); ?></td>
        <td><?php echo htmlspecialchars($empleado['departamento']); ?></td>
        <td><?php echo htmlspecialchars($empleado['tipo_documento']); ?></td>
        <td><?php echo htmlspecialchars($empleado['documento_identidad']); ?></td>
        <td><?php echo htmlspecialchars($empleado['direccion']); ?></td>
        <td><?php echo htmlspecialchars($empleado['telefono']); ?></td>
        

<td><img src="../../public/img/empleados/<?php echo $empleado['documento_identidad']; ?>" width="100" alt=""></td>

        <td>
              
                  <!-- Botón para editar -->  
                <a href="edit.php?da=Employees-3&lla=<?php echo $empleado['id_empleado']; ?>"  class="btn btn-custom-green btn-editar">
                <i class="fas fa-edit icon"></i> Editar

<!-- Botón de Borrar -->
<a href="#" class="btn btn-danger btn-borrar" onclick="borrarEmpleado(<?php echo $empleado['id_empleado']; ?>,  '<?php echo $empleado['documento_identidad']; ?>')">
    <i class="fas fa-trash-alt"></i> Borrar
</a>
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
function borrarEmpleado(id, imagen, documentacionArchivo) {
    if (confirm('¿Está seguro de borrar el empleado?')) {
        // Realizar una petición AJAX para borrar el pedido
        var xhr = new XMLHttpRequest();

        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Éxito en la eliminación del pedido
                    alert('Empleado eliminado correctamente.');
                    // Recargar la página para reflejar los cambios
                    location.reload();
                } else {
                    // Error al eliminar el pedido
                    alert('Error al eliminar el empleado.');
                }
            }
        };

        // Configurar la URL de la petición AJAX
        var url = 'delete.php?lla=' + encodeURIComponent(id) + 
                  '&imagen=' + encodeURIComponent(imagen) + 
                  '&documentacion_archivo=' + encodeURIComponent(documentacionArchivo);

        // Configurar la petición AJAX
        xhr.open('GET', url, true);
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