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



// Establecer los valores de paginación......
$registros_por_pagina = 10;  // Número de registros por página
$página_actual = isset($_GET['page']) ? (int)$_GET['page'] : 1;  // Página actual
$inicio = ($página_actual - 1) * $registros_por_pagina;  // Calcular el valor de OFFSET

// Consulta SQL para obtener los registros
$consulta = "SELECT * FROM  clientes LIMIT $inicio, $registros_por_pagina";
$resultados = $mysqli->query($consulta);

// Verificar si la consulta fue exitosa
if (!$resultados) {
    die("Error al ejecutar la consulta: " . $mysqli->error);
}

// Calcular el número total de registros
$total_registros_query = "SELECT COUNT(*) AS total FROM  clientes";
$total_resultados = $mysqli->query($total_registros_query);
$total_registros = $total_resultados->fetch_assoc()['total'];

// Calcular el número total de páginas
$total_paginas = ceil($total_registros / $registros_por_pagina);


// Obtener el término de búsqueda
$searchQuery = isset($_GET['search-query']) ? $_GET['search-query'] : '';

// Construir la consulta SQL con filtro si hay búsqueda....
if (!empty($searchQuery)) {
    $consulta = "SELECT * FROM  clientes WHERE 
                 nombre LIKE '%$searchQuery%' OR 
                 estado LIKE '%$searchQuery%' OR 
                 direccion LIKE '%$searchQuery%'
                 ORDER BY id_cliente";
} else {
    $consulta = "SELECT * FROM  clientes ORDER BY id_cliente";
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
    <title>Módulo de  clientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="style.css" type="text/css" rel="stylesheet"> 
</head>
<body>

    <div class="panel">
        <div class="column">
            <h2>Módulo  clientes</h2>
            <ul class="nav">
                <li><i class="fas fa-edit icon"></i><a href='insert.php?da=2'>Insert cliente</a></li>
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
               placeholder="Buscar  clientes..." value="<?php echo htmlspecialchars($searchQuery); ?>">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-search"></i> Buscar
        </button>
    </form>

    
    
   
    <table class="table table-bordered table-hover">
    <thead class="bg-primary text-white">
             
                        
            <tr>
            <th scope="col">Id</th>
            <th scope="col">Nombre</th>
            <th scope="col">Apellido</th>
           <th scope="col">Email</th>
           <th scope="col">Tipo Documento</th>
          <th scope="col">Documento Identidad</th>
         <th scope="col">Telefono</th>
         <th scope="col">Direccion</th>
         <th scope="col">Ciudad</th>
        <th scope="col">Estado</th>
        <th scope="col">Codigo Postal</th>
        <th scope="col">Pais</th>
        <th scope="col">Notas</th>
        <th scope="col">Fecha Creacion</th>
        <th scope="col">Fecha Modificacion</th>
        <th scope="col">Acciones</th>

    </thead>
    <tbody>     
    <?php while ($cliente = $resultados->fetch_assoc()): ?>

    
    <tr>
    <td><?php echo htmlspecialchars($cliente['id_cliente']); ?></td>
        <td><?php echo htmlspecialchars($cliente['nombre']); ?></td>
        <td><?php echo htmlspecialchars($cliente['apellido']); ?></td>
        <td><?php echo htmlspecialchars($cliente['email']); ?></td>
 <td><img src="../../public/files/uploads/clientes/<?php echo $pedido['documento_identidad']; ?>" width="100"></td>
        
    <td><?php echo htmlspecialchars($cliente['tipo_documento']); ?></td>
        <td><?php echo htmlspecialchars($cliente['telefono']); ?></td>
        <td><?php echo htmlspecialchars($cliente['direccion']); ?></td>
        <td><?php echo htmlspecialchars($cliente['ciudad']); ?></td>
        <td><?php echo htmlspecialchars($cliente['estado']); ?></td>
        <td><?php echo htmlspecialchars($cliente['codigo_postal']); ?></td>
        <td><?php echo htmlspecialchars($cliente['pais']); ?></td>
        <td><?php echo htmlspecialchars($cliente['notas']); ?></td>
        <td><?php echo htmlspecialchars($cliente['fecha_creacion']); ?></td>
        <td><?php echo htmlspecialchars($cliente['fecha_modificacion']); ?></td>
       
        <td>
              
                <a href="edit.php?da=Customers-3&lla=<?php echo $cliente['id_cliente']; ?>"  class="btn btn-custom-green btn-editar">
                <i class="fas fa-edit icon"></i> Editar


    <a href="#" class="btn btn-danger btn-borrar" onclick="borrarCliente(<?php echo $cliente['id_cliente']; ?>)">
    <i class="fas fa-trash-alt"></i> Borrar
</a>
</td>
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
function borrarCliente(id, imagen) {
    if (confirm('¿Está seguro de borrar  ?')) {
        // Realizar una petición AJAX para borrar el cliente
        var xhr = new XMLHttpRequest();

        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Éxito en la eliminación estado financiero
                    alert('Dato cliente eliminado correctamente.');
                    // Recargar la página para reflejar los cambios
                    location.reload();
                } else {
                    // Error al eliminar el  cliente
                    alert('Error al eliminar el  estado finananciero.');
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

</tr>
            <?php
        

        // Cerrar la conexión
        $mysqli->close();
        ?>
    </tbody>
</table>



</body>
</html>