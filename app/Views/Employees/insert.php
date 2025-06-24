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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a2e0e6a0b5.js" crossorigin="anonymous"></script>
    <!-- Incluimos el CSS de CKEditor -->
    <script src="https://cdn.ckeditor.com/4.24.0/standard/ckeditor.js"></script>
    <link href="style.css" type="text/css" rel="stylesheet">
</head>
<body>
         

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD pedidos</title>
    <!-- Agregamos los estilos de Bootstrap para los iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Incluimos el CSS de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a2e0e6a0b5.js" crossorigin="anonymous"></script>
    <!-- Incluimos el CSS de CKEditor -->
    <script src="https://cdn.ckeditor.com/4.24.0/standard/ckeditor.js"></script>
    <link href="style.css" type="text/css" rel="stylesheet">
</head>
<body>



<div class="container py-5">
  <div class="card shadow-lg">
    <div class="card-header bg-dark text-white">
      <h4 class="mb-0"><i class="fas fa-user-tie"></i> Nuevo Empleado</h4>
    </div>
    <div class="card-body">
      <form action="insert.php?da=Employees-2" method="POST"
            enctype="multipart/form-data"
            class="needs-validation" novalidate>
        <div class="row g-3">
          <!-- Columna IZQUIERDA -->
          <div class="col-md-6">
            <!-- Nombre -->
            <div class="mb-3">
              <label for="nombre" class="form-label">Nombre</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
                <input type="text" id="nombre" name="nombre"
                       class="form-control" required
                       placeholder="Ingresar nombre">
                <div class="invalid-feedback">
                  Por favor ingrese el nombre del empleado.
                </div>
              </div>
            </div>
            <!-- Cargo -->
            <div class="mb-3">
              <label for="cargo" class="form-label">Cargo</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                <input type="text" id="cargo" name="cargo"
                       class="form-control" required
                       placeholder="Ingresar cargo">
                <div class="invalid-feedback">
                  Por favor ingrese el cargo del empleado.
                </div>
              </div>
            </div>
        

            <!-- Estado -->
            <div class="mb-3">
              <label for="estado" class="form-label">Estado</label>
              <select id="estado" name="estado"
                      class="form-select" required>
                <option value="">Seleccione un estado</option>
                <option value="activo">Activo</option>
                <option value="inactivo">Inactivo</option>
                <option value="en_licencia">En Licencia</option>
              </select>
              <div class="invalid-feedback">
                Por favor seleccione el estado del empleado.
              </div>
            </div>

            <div class="mb-3">
  <label for="departamento" class="form-label">Departamento</label>
  <select id="departamento" name="departamento" class="form-select" required>
    <option value="">Seleccione un departamento...</option>
    <option value="Administración">Administración</option>
    <option value="Ventas">Ventas</option>
    <option value="Recursos Humanos">Recursos Humanos</option>
    <option value="Producción">Producción</option>
    <option value="Tecnología">Tecnología</option>
  </select>
  <div class="invalid-feedback">Por favor seleccione el departamento.</div>
</div>




            <!-- Tipo de documento -->
            <div class="mb-3">
              <label for="tipo_documento" class="form-label">
                Tipo de documento
              </label>
              <select id="tipo_documento" name="tipo_documento"
                      class="form-select" required>
                <option value="">Seleccione una opción</option>
                <option value="CC">Cédula</option>
                <option value="TI">Tarjeta de identidad</option>
                <option value="PP">Pasaporte</option>
              </select>
              <div class="invalid-feedback">
                Por favor seleccione el tipo de documento.
              </div>
            </div>

            <!-- Documento de identidad -->
            <div class="mb-3">
              <label for="documento_identidad" class="form-label">
                Documento de Identidad
              </label>
              <div class="input-group">
                <span class="input-group-text">
                  <i class="fas fa-id-card"></i>
                </span>
                <input type="number" id="documento_identidad"
                       name="documento_identidad"
                       class="form-control" required
                       placeholder="Documento de identidad">
                <div class="invalid-feedback">
                  Por favor ingrese el documento de identidad.
                </div>
              </div>
            </div>
          </div>

          <!-- Columna DERECHA -->
          <div class="col-md-6">
            <!-- Dirección -->
            <div class="mb-3">
              <label for="direccion" class="form-label">Dirección</label>
              <div class="input-group">
                <span class="input-group-text">
                  <i class="fas fa-map-marker-alt"></i>
                </span>
                <input type="text" id="direccion" name="direccion"
                       class="form-control" required
                       placeholder="Dirección de residencia">
                <div class="invalid-feedback">
                  Por favor ingrese la dirección del empleado.
                </div>
              </div>
            </div>
          
            <!-- Teléfono -->
            <div class="mb-3">
              <label for="telefono" class="form-label">Teléfono</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                <input type="text" id="telefono" name="telefono"
                       class="form-control" required
                       placeholder="Teléfono de contacto">
                <div class="invalid-feedback">
                  Por favor ingrese el teléfono de contacto.
                </div>
              </div>
            </div>
            
           

        <!-- Botón Guardar -->
        <div class="text-end mt-4">
          <button type="submit" name="boton"
                  class="btn btn-success px-4">
            <i class="fas fa-save"></i> Guardar
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Scripts de Bootstrap 5 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Validación personalizada de Bootstrap -->
<script>
  (() => {
    'use strict';
    const forms = document.querySelectorAll('.needs-validation');
    Array.from(forms).forEach(form => {
      form.addEventListener('submit', event => {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      });
    });
  })();
</script>

