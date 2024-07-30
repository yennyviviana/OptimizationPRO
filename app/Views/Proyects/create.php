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
    </head>
    <body>
<style>
    body {
    background-color: #000;
    color: #f5f5f5; 
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

.table-container {
    width: 100%;
    margin: 0 auto;
}

.table {
    width: 100%;
    table-layout: auto;
    word-wrap: break-word;
    color: #fff; 
    background-color: #818274; 
}

.table th, .table td {
    border: 1px solid #444;
    padding: 1rem;
    font-size: 1.1rem;
    text-align: center;
}
.table th {
    background-color: #000000;
    color:  #65D8DB; 
    font-weight: bold;
    border-bottom: 3px solid #ff6f61;
}

.table tbody tr {
    background-color: #000;
}

.table tbody tr:nth-of-type(odd) {
    background-color:  #fff; 
    color:  #000;
}



.table-responsive {
    margin-top: 1.5rem;
    overflow-x: auto;
}



    </style>
</head>

<body>
    <div class="panel">
        <div class="column">
            <h2>Módulo de proyectos</h2>
            <ul class="nav">
                <li><i class="fas fa-edit icon"></i><a href='insert.php?da=2'>Insertar proyectos</a></li>
                <li class="nav-item">
                <a class="nav-link" href="/OptimizationPRO/app/main.php">
                                <span data-feather="Home"></span>
                                 Regresar
                            </a>
                        </li>
            </ul>
        </div>
    </div>

    

    <div class="container-fluid">
    <div class="table-container">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="thead-light">
 <tr>
                <th scope="col">Id</th>
                <th scope="col">Nombre proyecto</th>
                <th scope="col">Descripcion</th>
                <th scope="col">Fecha inicio</th>
                <th scope="col">Fecha fin</th>
                <th scope="col">Estado</th>
                <th scope="col">Usuario</th>
                <th scope="col">Imagen</th>
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
        $consulta = "SELECT * FROM proyectos ORDER BY id_proyecto";
        $resultados = $mysqli->query($consulta);

        // Comprobación de errores en la ejecución de la consulta
        if (!$resultados) {
            die("Error al ejecutar la consulta: " . $mysqli->error);
        }

        // Iterar sobre los resultados y mostrarlos
        while ($proyecto = $resultados->fetch_assoc()) {
        ?>
            <tr>
                <td><?php echo htmlspecialchars($proyecto['id_proyecto']); ?></td>
                <td><?php echo htmlspecialchars($proyecto['nombre_proyecto']); ?></td>
                <td><?php echo htmlspecialchars($proyecto['descripcion']); ?></td>
                <td><?php echo htmlspecialchars($proyecto['fecha_inicio']); ?></td>
                <td><?php echo htmlspecialchars($proyecto['fecha_fin']); ?></td>
                <td><?php echo htmlspecialchars($proyecto['estado']); ?></td>
                <td><?php echo htmlspecialchars($proyecto['id_usuario']); ?></td>
                <td><img src="../../public/img/proyecto/<?php echo htmlspecialchars($proyecto['imagen_proyecto']); ?>" width="100" alt=""></td>
                <td>
                    <a href="edit.php?da=3&lla=<?php echo $proyecto['id_proyecto']; ?>" class="btn btn-custom-green btn-editar">
                        <i class="fas fa-edit icon"></i> Editar
                    </a>
                    <a href="#" class="btn btn-danger btn-borrar" onclick="borrarProyecto(<?php echo $proyecto['id_proyecto']; ?>, '<?php echo $proyecto['imagen_proyecto']; ?>')">
                        <i class="fas fa-trash-alt"></i> Borrar
                    </a>
                </td>
            </tr>
        <?php
        }

        // Cerrar la conexión
        $mysqli->close();
        ?>
        </tbody>
    </table>

    <script>
        function borrarProyecto(id, imagen) {
            if (confirm('¿Está seguro de borrar  ?')) {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            alert('Proyecto eliminado correctamente.');
                            location.reload();
                        } else {
                            alert('Error al eliminar el estado financiero.');
                        }
                    }
                };
                xhr.open('GET', 'delete.php?lla=' + id + '&imagen=' + imagen, true);
                xhr.send();
            }
        }
    </script>
</body>
</html>