<?php
require_once __DIR__ . '/../../Models/EmpleadoModel.php';
require_once __DIR__ . '/../../Controllers/EmpleadoController.php';

?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Nuevo Empleado</title>
  <!-- Bootstrap 5 y Font Awesome -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <!-- CKEditor -->
  <script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>
  <link href="style.css" type="text/css" rel="stylesheet">
</head>
<body>

<div class="container py-5">
  <div class="card shadow-lg">
    <div class="card-header bg-dark text-white">
      <h4 class="mb-0"><i class="fas fa-user-tie"></i> Nuevo Empleado</h4>
    </div>
    <div class="card-body">
      <form action="insert.php?da=Employees-2" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
        <div class="row g-3">
          <!-- Columna izquierda -->
          <div class="col-md-6">
            <div class="mb-3">
              <label for="nombre_completo" class="form-label">Empleado:</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
                <input type="text" id="nombre_completo" name="nombre_completo" class="form-control" required placeholder="Ingresar empleado">
              </div>
              <div class="invalid-feedback">Por favor ingrese el nombre del empleado.</div>
            </div>

            <div class="mb-3">
              <label for="cargo" class="form-label">Cargo</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                <input type="text" id="cargo" name="cargo" class="form-control" required placeholder="Ingresar cargo">
              </div>
              <div class="invalid-feedback">Por favor ingrese el cargo del empleado.</div>
            </div>

            <div class="mb-3">
              <label for="fecha_contratacion" class="form-label">Fecha de Contratación</label>
              <input type="date" id="fecha_contratacion" name="fecha_contratacion" class="form-control" required>
              <div class="invalid-feedback">Por favor ingrese la fecha de contratación.</div>
            </div>

            <div class="mb-3">
              <label for="numero_horas" class="form-label">Número de Horas</label>
              <input type="number" id="numero_horas" name="numero_horas" class="form-control" required placeholder="Días u horas trabajadas">
              <div class="invalid-feedback">Por favor ingrese las horas trabajadas.</div>
            </div>

            <div class="mb-3">
              <label for="precio_hora" class="form-label">Precio Hora</label>
              <input type="number" id="precio_hora" name="precio_hora" class="form-control" required placeholder="Precio por hora">
              <div class="invalid-feedback">Por favor ingrese el precio por hora.</div>
            </div>

            <div class="mb-3">
              <label for="salario" class="form-label">Salario</label>
              <input type="number" id="salario" name="salario" class="form-control" required placeholder="Salario del empleado">
              <div class="invalid-feedback">Por favor ingrese el salario del empleado.</div>
            </div>

            <div class="mb-3">
              <label for="estado" class="form-label">Estado</label>
              <select id="estado" name="estado" required class="form-select">
                <option value="">Seleccione un estado</option>
                <option value="activo">Activo</option>
                <option value="inactivo">Inactivo</option>
                <option value="en_licencia">En Licencia</option>
              </select>
              <div class="invalid-feedback">Por favor seleccione el estado del empleado.</div>
            </div>

            <div class="mb-3">
              <label for="departamento" class="form-label">Departamento</label>
              <select id="departamento" name="departamento" required class="form-select">
                <option value="">Seleccione un departamento</option>
                <option value="valle_del_cauca">Valle del Cauca</option>
                <option value="risaralda">Risaralda</option>
                <option value="arauca">Arauca</option>
                <option value="bogota">Bogotá</option>
              </select>
              <div class="invalid-feedback">Por favor seleccione el departamento del empleado.</div>
            </div>

            <div class="mb-3">
              <label for="documento_identidad" class="form-label">Documento de Identidad</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                <input type="text" id="documento_identidad" name="documento_identidad" class="form-control" required placeholder="Documento de identidad">
              </div>
              <div class="invalid-feedback">Por favor ingrese el documento de identidad.</div>
            </div>

            <div class="mb-3">
              <label for="fecha_creacion" class="form-label">Fecha de Creación</label>
              <input type="date" id="fecha_creacion" name="fecha_creacion" class="form-control" required>
              <div class="invalid-feedback">Por favor ingrese la fecha de creación.</div>
            </div>
          </div>

          <!-- Columna derecha -->
          <div class="col-md-6">
            <div class="mb-3">
              <label for="direccion" class="form-label">Dirección</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                <input type="text" id="direccion" name="direccion" class="form-control" required placeholder="Dirección de residencia">
              </div>
              <div class="invalid-feedback">Por favor ingrese la dirección del empleado.</div>
            </div>

            <div class="mb-3">
              <label for="ciudad" class="form-label">Ciudad</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-city"></i></span>
                <input type="text" id="ciudad" name="ciudad" class="form-control" required placeholder="Ciudad de residencia">
              </div>
              <div class="invalid-feedback">Por favor ingrese la ciudad de residencia.</div>
            </div>

            <div class="mb-3">
              <label for="telefono" class="form-label">Teléfono</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                <input type="text" id="telefono" name="telefono" class="form-control" required placeholder="Teléfono de contacto">
              </div>
              <div class="invalid-feedback">Por favor ingrese el teléfono de contacto.</div>
            </div>

            <div class="mb-3">
              <label for="pais" class="form-label">País</label>
              <select id="pais" name="pais" class="form-select" required>
                <option value="">Seleccione un país</option>
                <option value="colombia">Colombia</option>
                <option value="ecuador">Ecuador</option>
                <option value="brazil">Brazil</option>
                <option value="estados_unidos">Estados Unidos</option>
                <option value="espana">España</option>
              </select>
              <div class="invalid-feedback">Por favor seleccione el país del empleado.</div>
            </div>

            <div class="mb-3">
              <label for="documentacion_archivo" class="form-label">Documentación</label>
              <input type="file" id="documentacion_archivo" name="documentacion_archivo" class="form-control" required>
              <div class="invalid-feedback">Por favor seleccione un archivo de documentación.</div>
            </div>

            <div class="mb-3">
              <label for="descripcion_profesional" class="form-label">Descripción Profesional</label>
              <textarea id="descripcion_profesional" name="descripcion_profesional" class="form-control" required placeholder="Descripción profesional"></textarea>
              <div class="invalid-feedback">Por favor ingrese la descripción profesional.</div>
            </div>

            <div class="mb-3">
              <label for="imagen" class="form-label">Imagen</label>
              <input type="file" accept="image/*" capture="camera" id="imagen" name="imagen" class="form-control" required>
              <div class="invalid-feedback">Por favor seleccione una imagen.</div>
            </div>
          </div>
        </div>

        <div class="text-end mt-4">
          <button type="submit" name="boton" class="btn btn-success px-4">
            <i class="fas fa-save"></i> Guardar
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Scripts de Bootstrap 5 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Inicializamos CKEditor para el textarea de descripción -->
<script>
  CKEDITOR.replace('descripcion_profesional');
</script>
</body>
</html>

