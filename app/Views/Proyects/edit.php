<?php

require_once __DIR__ . '/../../Models/ProyectoModel.php';
require_once __DIR__ . '/../../Config/database.php';


session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit();
}

// Validar y obtener el valor de 'da' y 'lla' de $_GET
$llave = isset($_GET['lla']) ? intval($_GET['lla']) : 0;
if ($llave <= 0) {
    exit("Error: 'lla' debe ser un valor numérico válido.");
}

// Conectar a MySQL y seleccionar la base de datos.
$mysqli = mysqli_connect(db_host, db_username, db_password, db_dbname);

// Verificar que la conexión sea exitosa
if (!$mysqli) {
    die('Error al conectarse a MySQL: ' . mysqli_connect_error());
}

// Establecer juego de caracteres UTF-8
mysqli_set_charset($mysqli, 'utf8');

// Inicializar la variable $pedido
$proyecto= null;


/// Verificar si se ha enviado un formulario para actualizar el proyecto
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Captura y valida los datos del formulario
    $nombre_proyecto = isset($_POST['nombre_proyecto']) ? $_POST['nombre_proyecto'] : '';
    $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : '';
    $fecha_inicio = isset($_POST['fecha_inicio']) ? $_POST['fecha_inicio'] : date('Y-m-d H:i:s');
    $fecha_fin = isset($_POST['fecha_fin']) ? $_POST['fecha_fin'] : date('Y-m-d H:i:s');
    $estado = isset($_POST['estado']) ? $_POST['estado'] : '';
    $id_usuario = isset($_POST['id_usuario']) ? $_POST['id_usuario'] : $_SESSION['id_usuario'];
    $imagen_proyecto = isset($_FILES['imagen_proyecto']) ? $_FILES['imagen_proyecto'] : null;


 // Crear una instancia del modelo de proveedor
 $proyectoModel = new ProyectoModel($mysqli);

 try {
       // Actualizar el pedido en la base de datos
       $resultado = $proyectoModel->actualizarProyecto($llave,$nombre_proyecto, $descripcion, $fecha_inicio, $fecha_fin, $estado, $id_usuario, $imagen_proyecto);
       if ($resultado) {
        echo "Proyecto actualizado correctamente.";
    } else {
        echo "Error al actualizar el proyecto.";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
} else {
// Obtener los datos del pedido para mostrar en el formulario
$query = "SELECT * FROM proyectos WHERE id_proyecto = ?";
$stmt = $mysqli->prepare($query);

if ($stmt) {
    // Vincular el parámetro de 'id_proyecto' a la consulta preparada
    $stmt->bind_param("i", $llave);

    // Ejecutar la consulta preparada
    $stmt->execute();

    // Obtener el resultado de la consulta
    $result = $stmt->get_result();

    if ($result) {
        // Recuperar los datos del pedido como un array asociativo
        $proyecto = $result->fetch_assoc();

        // Cerrar la consulta preparada
        $stmt->close();
    } else {
        // Manejar el caso en que no se pudo obtener el resultado de la consulta
        exit("Error al ejecutar la consulta.");
    }
} else {
    // Manejar el caso en que la consulta preparada no se pudo preparar
    exit("Error al preparar la consulta.");
}
}



?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD pedidos</title>
    <!-- Agregamos los estilos de Bootstrap para los iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Incluimos el CSS de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        #form-background {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        /* Ajuste de estilos para el editor CKEditor */
        .ck-editor__editable {
            min-height: 150px;
        }
    </style>
</head>
<body>
  

<div class="container">
        <div id="form-background">
            <?php if ($proyecto): ?>
            <form action="edit.php?lla=<?php echo $llave; ?>" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>

            <div class="form-group">
                    <label for="">Nombre proyecto</label>
                    <textarea id="nombre_proyecto" name="nombre_proyecto"  value="<?php echo htmlspecialchars($proyecto['nombre_proyecto']); ?>" class="form-control" required placeholder="nombre_proyecto"></textarea>
                    <div class="invalid-feedback">Por favor ingrese  el nombre proyecto.</div>
                </div>


                <div class="form-group">
                    <label for="descripcion">Descripcion</label>
                    <textarea id="descripcion" name="descripcion" class="form-control" required placeholder="Descripcion"><?php echo htmlspecialchars($proyecto['descripcion']); ?></textarea>
                    <div class="invalid-feedback">Por favor ingrese la descripcion.</div>
                </div>



                <div class="form-group">
        <label for="fecha_adquisicion">Fecha inicio:</label>
        <input type="date" id="fecha_inicio" name="fecha_inicio" value="<?php echo htmlspecialchars($producto['fecha_inicio']); ?>"class="form-control" min="0" required>
    </div>

          
    <div class="form-group">
        <label for="fecha_fin">Fecha fin:</label>
        <input type="date" id="fecha_fin" name="fecha_fin" value="<?php echo htmlspecialchars($proyecto['fecha_fin']); ?>"class="form-control" min="0" required>
    </div>


    <div class="form-group">
                
                  
            <label for="estado"><i class="fas fa-users"></i> Estado:</label>
                <select id="estado" name="estado" required class="form-control">
                    <option value="pendiente" <?php if ($proyecto['estado'] == 'pendiente') echo 'selected'; ?>>Pendiente</option>
                    <option value="en progreso" <?php if ($proyecto['estado'] == 'en progreso') echo 'selected'; ?>>En progreso</option>
                    <option value="completado" <?php if ($proyecto['estado'] == 'completado') echo 'selected'; ?>>Completado</option>
                </select>
                
            </div>


            <div class="form-group">
    <label for="archivos">Imagen</label>
    <input type="file" id="imagen_proyecto" name="imagen_proyecto" class="form-control-file" required>
    <div class="invalid-feedback">Por favor seleccione al menos una imagen proyecto.</div>
</div>


    
    <button type="submit" name="boton" class="btn btn-primary">Guardar</button>
            </form>

            </form>
            <?php else: ?>
              
            <?php endif; ?>
        </div>
    </div>

    <script>
        // Inicializamos CKEditor en el textarea con ID "descripcion"
        CKEDITOR.replace('descripcion');
    </script>
</body>
</html>
<?php
// Cierra la conexión a la base de datos
mysqli_close($mysqli);
?>
       
