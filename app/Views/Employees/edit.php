<?php

require_once __DIR__ . '/../../Models/EmpleadoModel.php';
require_once __DIR__ . '/../../Config/database.php';
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit();
}

// Validar y obtener el valor de 'lla' de $_GET
$llave = isset($_GET['lla']) ? intval($_GET['lla']) : 0;
if ($llave <= 0) {
    exit("Error: 'lla' debe ser un valor numérico válido.");
}

$mysqli = new mysqli('localhost', 'root', '', 'sofware_erp');
$mysqli->set_charset("utf8");
if ($mysqli->connect_error) {
    die('Error en la conexion' . $mysqli->connect_error);
}



// Verifica si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Captura los datos del formulario
    $nombre_completo = $_POST['nombre_completo'] ?? '';
    $cargo = $_POST['cargo'] ?? '';
    $fecha_contratacion = date('Y-m-d h:i:s');
    $numero_horas = $_POST['numero_horas'] ?? 0;
    $precio_hora = $_POST['precio_hora'] ?? 0;
    $salario = $_POST['salario'] ?? 0;
    $estado = $_POST['estado'] ?? '';
    $departamento = $_POST['departamento'] ?? '';
    $documento_identidad = $_POST['documento_identidad'] ?? '';
    $direccion = $_POST['direccion'] ?? '';
    $ciudad = $_POST['ciudad'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $pais = $_POST['pais'] ?? '';
    $imagen = $_FILES['imagen'] ?? null;
    $documentacion_archivo = $_FILES['documentacion_archivo'] ?? null;
    $fecha_creacion = date('Y-m-d H:i:s');
    $descripcion_profesional = $_POST['descripcion_profesional'] ?? '';
    

    // Escapar las variables para prevenir inyección SQL
    $nombre_completo = mysqli_real_escape_string($this->conexion, $nombre_completo);
    $cargo = mysqli_real_escape_string($this->conexion, $cargo);
    $fecha_contratacion = mysqli_real_escape_string($this->conexion, $fecha_contratacion);
    $numero_horas = mysqli_real_escape_string($this->conexion, $numero_horas);
    $precio_hora = mysqli_real_escape_string($this->conexion, $precio_hora);
    $salario = mysqli_real_escape_string($this->conexion, $salario);
    $estado = mysqli_real_escape_string($this->conexion, $estado);
    $departamento = mysqli_real_escape_string($this->conexion, $departamento);
    $documento_identidad = mysqli_real_escape_string($this->conexion, $documento_identidad);
    $direccion = mysqli_real_escape_string($this->conexion, $direccion);
    $ciudad = mysqli_real_escape_string($this->conexion, $ciudad);
    $telefono = mysqli_real_escape_string($this->conexion, $telefono);
    $pais = mysqli_real_escape_string($this->conexion, $pais);
    $fecha_creacion = mysqli_real_escape_string($this->conexion, $fecha_creacion);
    $descripcion_profesional = mysqli_real_escape_string($this->conexion, $descripcion_profesional);

 // Crear una instancia del modelo de proveedor
 $empleadoModel = new  EmpleadoModel($mysqli);

 try {
     // Actualizar el clienten la base de datos
     $consulta = "UPDATE empleados SET nombre_completo='$nombre_completo', cargo='$cargo',   fecha_contratacion='$fecha_contratacion', numero_horas,='$numero_horas,', precio_hora, ='$precio_hora, ', salario='$salario', estado='$estado', departamento='$departamento', documento_identidad='$documento_identidad',direccion='$direccion', ciudad='$ciudad', telefono= '$telefono', pais='$pais', fecha_creacion='$fecha_creacion', fecha_modificacion='$fecha_modificacion', descripcion_profesional ='$descripcion_profesional' WHERE id_empleado='$llave'";
     $resultado = $mysqli->query($consulta);
     
     if ($resultado) {
         echo "Empleado actualizado correctamente.";
     } else {
         echo "Error al actualizar el empleado.";
     }
 } catch (Exception $e) {
     echo "Error: " . $e->getMessage();
 }
} else {
 // Obtener los datos del empleado para mostrar en el formulario
 $query = "SELECT * FROM empleados WHERE id_empleado = ?";
 $stmt = $mysqli->prepare($query);

 if ($stmt) {
     // Vincular el parámetro de 'id_cliente' a la consulta preparada
     $stmt->bind_param("i", $llave);

     // Ejecutar la consulta preparada
     $stmt->execute();

     // Obtener el resultado de la consulta
     $result = $stmt->get_result();

     if ($result) {
         // Recuperar los datos del cliente como un array asociativo
         $empleado = $result->fetch_assoc();

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
    <!-- Incluimos el CSS de CKEditor -->
    <script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>
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

        #camera-container {
            display: none;
            text-align: center;
        }
        #camera-preview {
            max-width: 100%;
            height: auto;
            display: none;
        }
        #captured-image {
            max-width: 100%;
            height: auto;
            display: none;
            margin-top: 10px;
        }
        #delete-photo {
            display: none;
            margin-top: 10px;
        }
    </style>
</head>
<body>
  
<div class="container">
    <div id="form-background">
        <form action="insert.php" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>

            <h1>Nuevo empleado</h1>

            <div class="form-group">
                <label for="nombre_completo">Empleado:</label>
                <input type="text" id="nombre_completo" name="nombre_completo"  value="<?php echo htmlspecialchars($empleado['nombre_completo'] ?? ''); ?>" class="form-control" required placeholder="Ingresar empleado">
                <div class="invalid-feedback">Por favor ingrese el nombre del empleado.</div>
            </div>

            <div class="form-group">
                <label for="cargo">Cargo</label>
                <input type="text" id="cargo" name="cargo"  value="<?php echo htmlspecialchars($empleado['cargo'] ?? ''); ?>"class="form-control" required placeholder="Ingresar cargo">
                <div class="invalid-feedback">Por favor ingrese el cargo del empleado.</div>
            </div>

            <div class="form-group">
                <label for="fecha_contratacion">Fecha de Contratación</label>
                <input type="date" id="fecha_contratacion" name="fecha_contratacion"  value="<?php echo htmlspecialchars($empleado['fecha_contratacion'] ?? ''); ?>" class="form-control" required>
                <div class="invalid-feedback">Por favor ingrese la fecha de contratación.</div>
            </div>

            <div class="form-group">
                <label for="numero_horas">Número de Horas (Días y Horas)</label>
                <input type="number" id="numero_horas" name="numero_horas" value="<?php echo htmlspecialchars($empleado['numero_horas'] ?? ''); ?>" class="form-control" required>
                <div class="invalid-feedback">Por favor ingrese las horas trabajadas.</div>
            </div>

            <div class="form-group">
                <label for="precio_hora">Precio Hora</label>
                <input type="number" id="precio_hora" name="precio_hora" value="<?php echo htmlspecialchars($empleado['precio_hora'] ?? ''); ?>" class="form-control" required placeholder="Precio por hora">
                <div class="invalid-feedback">Por favor ingrese el precio por hora.</div>
            </div>

            <div class="form-group">
                <label for="salario">Salario</label>
                <input type="number" id="salario" name="salario"  value="<?php echo htmlspecialchars($empleado['salario'] ?? ''); ?>" class="form-control" required placeholder="Salario del empleado">
                <div class="invalid-feedback">Por favor ingrese el salario del empleado.</div>
            </div>

            
            <label for="estado"><i class="fas fa-users"></i> Estado:</label>
                <select id="estado" name="estado" required class="form-control">
                    <option value="activo" <?php if ($empleado['estado'] == 'activo') echo 'selected'; ?>>Activo</option>
                    <option value="inactivo" <?php if ($empleado['estado'] == 'inactivo') echo 'selected'; ?>>Inactivo</option>
                    <option value=" en licencia" <?php if ($empleado['estado'] == 'en licencia') echo 'selected'; ?>>En licencia</option>
                </select>

            <div class="form-group">
                <label for="departamento">Departamento</label>
                <select id="departamento" name="departamento" required class="form-control">
                <option value="antioquia" <?php if ($empleado['departamento'] == 'antioquia') echo 'selected'; ?>>Antioquia</option>
                    <option value="risaralda" <?php if ($empleado['departamento'] == 'risaralda') echo 'selected'; ?>>Risaralda</option>
                    <option value="bogota" <?php if ($empleado['departamento'] == 'bogota') echo 'selected'; ?>>Bogota</option>
                    <option value="valle del cauca" <?php if ($empleado['departamento'] == 'Valle del cauca') echo 'selected'; ?>>Valle del cauca</option>
                    <option value="cauca" <?php if ($empleado['departamento'] == 'cauca') echo 'selected'; ?>>Cauca</option>
                    
                </select>
                <div class="invalid-feedback">Por favor seleccione el departamento del empleado.</div>
            </div>



            <div class="form-group">
                <label for="documento_identidad">Documento de Identidad</label>
                <input type="text" id="documento_identidad" name="documento_identidad" class="form-control" required placeholder="Documento de identidad">
                <div class="invalid-feedback">Por favor ingrese el documento de identidad del empleado.</div>
            </div>


            <div class="form-group">
                <label for="direccion">Dirección</label>
                <input type="text" id="direccion" name="direccion" class="form-control" required placeholder="Dirección de residencia">
                <div class="invalid-feedback">Por favor ingrese la dirección del empleado.</div>
            </div>
            
           

            <div class="form-group">
                <label for="ciudad">Ciudad</label>
                <input type="text" id="ciudad" name="ciudad" class="form-control" required placeholder="Ciudad de residencia">
                <div class="invalid-feedback">Por favor ingrese la ciudad de residencia del empleado.</div>
            </div>

            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" id="telefono" name="telefono" class="form-control" required placeholder="Teléfono de contacto">
                <div class="invalid-feedback">Por favor ingrese el teléfono de contacto.</div>
            </div>


    

   


            <div class="form-group">
                <label for="pais">País</label>
                <select id="pais" name="pais" class="form-control" required>
                    <option value="">Seleccione un país</option>
                    <option value="colombia">Colombia</option>
                    <option value="ecuador">Ecuador</option>
                    <option value="brazil">Brazil</option>
                    <option value="estados_unidos">Estados Unidos</option>
                    <option value="espana">España</option>
                </select>
                <div class="invalid-feedback">Por favor seleccione el país del empleado.</div>
            </div>

            <label for="pais"><i class="fas fa-users"></i> Pais:</label>
                <select id="estado" name="estado" required class="form-control">
                    <option value="colombia" <?php if ($empleado['pais'] == 'colombia') echo 'selected'; ?>>Colombia</option>
                    <option value="ecuador" <?php if ($empleado['pais'] == 'ecuador') echo 'selected'; ?>>Colombia</option>
                    <option value="brazil" <?php if ($empleado['pais'] == 'brazil') echo 'selected'; ?>>Brazil</option>
                    <option value="estados unidos" <?php if ($empleado['pais'] == 'estados unidos') echo 'selected'; ?>>Estados Unidos</option>
                    <option value="España" <?php if ($empleado['pais'] == 'españa') echo 'selected'; ?>>España</option>
                    



            <div class="form-group">
                <label for="documentacion_archivo">Documentación</label>
                <input type="file" id="documentacion_archivo" name="documentacion_archivo" class="form-control-file" required>
                <div class="invalid-feedback">Por favor seleccione un archivo de documentación.</div>
            </div>

            <div class="form-group">
                <label for="descripcion_profesional">Descripción Profesional</label>
                <textarea id="descripcion_profesional" name="descripcion_profesional" class="form-control" required placeholder="Descripción Profesional"></textarea>
                <div class="invalid-feedback">Por favor ingrese la descripción profesional del empleado.</div>
            </div>

            <div class="form-group">
                <label for="fecha_creacion">Fecha de Creación</label>
                <input type="date" id="fecha_creacion" name="fecha_creacion" class="form-control" required>
                <div class="invalid-feedback">Por favor ingrese la fecha de creación.</div>
            </div>

           
            
<div class="form-group">
    <label for="imagen">Imagen de Perfil</label>
    <div id="camera-container" style="display: none;">
        <video id="camera-preview" autoplay></video>
        <canvas id="camera-canvas" style="display: none;"></canvas>
    </div>
    <img id="captured-image" src="#" alt="Captured Image" style="display: none;">
    <button type="button" class="btn btn-secondary" id="toggle-camera">Tomar Foto</button>
    <button type="button" class="btn btn-danger" id="delete-photo" style="display: none;">Eliminar Foto</button>
    <input type="hidden" id="imagen" name="imagen">
</div>



<div class="form-group">
    <input type="file" accept="image/*" capture="camera" id="imagen" name="imagen" class="form-control-file" required>
</div>
<button type="submit" name="boton" class="btn btn-success">Guardar</button>
            

    </form>
</div>
</div>

    
<script>
        // Inicializamos CKEditor en el textarea con ID "descripcion"
        CKEDITOR.replace('descripcion_profesional');
       
    </script>

</body>
</html>