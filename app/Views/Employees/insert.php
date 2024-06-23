<?php
require_once __DIR__ . '/../../Models/EmpleadoModel.php';
require_once __DIR__ . '/../../Controllers/EmpleadoController.php';

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
    </style>
</head>
<body>
  
<div class="container">
    <div id="form-background">
        <form action="insert.php?da=2" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>

            <h1>Nuevo empleado</h1>

            <div class="form-group">
                <label for="nombre_completo">Empleado:</label>
                <input type="text" id="nombre_completo" name="nombre_completo" class="form-control" required placeholder="Ingresar empleado">
                <div class="invalid-feedback">Por favor ingrese el nombre del empleado.</div>
            </div>

            <div class="form-group">
                <label for="cargo">Cargo</label>
                <input type="text" id="cargo" name="cargo" class="form-control" required placeholder="Ingresar cargo">
                <div class="invalid-feedback">Por favor ingrese el cargo del empleado.</div>
            </div>

            <div class="form-group">
                <label for="fecha_contratacion">Fecha de Contratación</label>
                <input type="date" id="fecha_contratacion" name="fecha_contratacion" class="form-control" required>
                <div class="invalid-feedback">Por favor ingrese la fecha de contratación.</div>
            </div>

            <div class="form-group">
                <label for="numero_horas">Número de Horas (Días y Horas)</label>
                <input type="number" id="numero_horas" name="numero_horas" class="form-control" required>
                <div class="invalid-feedback">Por favor ingrese las horas trabajadas.</div>
            </div>

            <div class="form-group">
                <label for="precio_hora">Precio Hora</label>
                <input type="number" id="precio_hora" name="precio_hora" class="form-control" required placeholder="Precio por hora">
                <div class="invalid-feedback">Por favor ingrese el precio por hora.</div>
            </div>

            <div class="form-group">
                <label for="salario">Salario</label>
                <input type="number" id="salario" name="salario" class="form-control" required placeholder="Salario del empleado">
                <div class="invalid-feedback">Por favor ingrese el salario del empleado.</div>
            </div>

            <div class="form-group">
                <label for="estado">Estado</label>
                <select id="estado" name="estado" required class="form-control">
                    <option value="">Seleccione un estado</option>
                    <option value="activo">Activo</option>
                    <option value="inactivo">Inactivo</option>
                    <option value="en_licencia">En Licencia</option>
                </select>
                <div class="invalid-feedback">Por favor seleccione el estado del empleado.</div>
            </div>

            <div class="form-group">
                <label for="departamento">Departamento</label>
                <select id="departamento" name="departamento" required class="form-control">
                    <option value="">Seleccione un departamento</option>
                    <option value="valle_del_cauca">Valle del Cauca</option>
                    <option value="risaralda">Risaralda</option>
                    <option value="arauca">Arauca</option>
                    <option value="bogota">Bogotá</option>
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
    <input type="file" accept="image/*" capture="camera" id="imagen" name="imagen" class="form-control-file" required>
</div>


            <button type="submit" name="boton" class="btn btn-primary">Guardar</button>
        </form>
    </div>
</div>
    </div>
<script>
        // Inicializamos CKEditor en el textarea con ID "descripcion"
        CKEDITOR.replace('descripcion_profesional');
       
    </script>





</body>
</html>