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
            <h2>Módulo de  empleados</h2>
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
                <th scope="col">Id</th>
                <th scope="col">Nombre</th>
                <th scope="col">Cargo</th>
                <th scope="col">contratacion</th>
                <th scope="col"> Horas</th>
                <th scope="col">Precio</th>
                <th scope="col">Salario</th>
                <th scope="col">Estado</th>
                <th scope="col">Departamento</th>
                <th scope="col">identidad</th>
                <th scope="col">Direccion</th>
                <th scope="col">Ciudad</th>
                <th scope="col">Telefono</th>
                <th scope="col">Pais</th>
                <th scope="col">Imagen</th>
                <th scope="col">Documentacion</th>
                <th scope="col">Creacion</th>
                <th scope="col">Descripcion</th>
                <th scope="col">Acciones</th>
    </thead>
    <tbody>
    <?php while ($empleado = $resultados->fetch_assoc()): ?>  


    
    <tr>
    <td><?php echo htmlspecialchars($empleado['id_empleado']); ?></td>
        <td><?php echo htmlspecialchars($empleado['nombre_completo']); ?></td>
        <td><?php echo htmlspecialchars($empleado['cargo']); ?></td>
        <td><?php echo htmlspecialchars($empleado['fecha_contratacion']); ?></td>
        <td><?php echo htmlspecialchars($empleado['numero_horas']); ?></td>
        <td><?php echo htmlspecialchars($empleado['precio_hora']); ?></td>
        <td><?php echo htmlspecialchars($empleado['salario']); ?></td>
        <td><?php echo htmlspecialchars($empleado['estado']); ?></td>
        <td><?php echo htmlspecialchars($empleado['departamento']); ?></td>
        <td><?php echo htmlspecialchars($empleado['documento_identidad']); ?></td>
        <td><?php echo htmlspecialchars($empleado['direccion']); ?></td>
        <td><?php echo htmlspecialchars($empleado['ciudad']); ?></td>
        <td><?php echo htmlspecialchars($empleado['telefono']); ?></td>
        <td><?php echo htmlspecialchars($empleado['pais']); ?></td>
<td><img src="../../public/img/empleados/<?php echo $empleado['imagen']; ?>" width="100" alt=""></td>
<td><img src="../../public/img/empleados/<?php echo $empleado['documentacion_archivo']; ?>" width="100" alt=""></td>
<td><?php echo htmlspecialchars($empleado['fecha_creacion']); ?></td>
<td><?php echo htmlspecialchars($empleado['descripcion_profesional']); ?></td>
        <td>
              
                  <!-- Botón para editar -->  
                <a href="edit.php?da=3&lla=<?php echo $empleado['id_empleado']; ?>"  class="btn btn-custom-green btn-editar">
                <i class="fas fa-edit icon"></i> Editar

<!-- Botón de Borrar -->
<a href="#" class="btn btn-danger btn-borrar" onclick="borrarEmpleado(<?php echo $empleado['id_empleado']; ?>, '<?php echo $empleado['imagen']; ?>', '<?php echo $empleado['documentacion_archivo']; ?>')">
    <i class="fas fa-trash-alt"></i> Borrar
</a>
</tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
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