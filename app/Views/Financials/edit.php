<?php

require_once __DIR__ . '/../../Models/ProyectoModel.php';
require_once __DIR__ . '/../../Controllers/ProyectoController.php';



?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>CRUD Proyectos</title>
  <!-- Bootstrap & Font Awesome -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <div class="container my-5">
    <div class="card shadow p-4 rounded-lg" id="form-background">
      <h3 class="mb-4"><i class="fas fa-folder-plus mr-2"></i>Registrar Proyecto</h3>
      <form action="insert.php?da=Financials-2" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
        
        <div class="form-group">
          <label for="nombre_proyecto">Nombre del Proyecto</label>
          <textarea id="nombre_proyecto" name="nombre_proyecto" class="form-control" required placeholder="Nombre del proyecto"></textarea>
          <div class="invalid-feedback">Por favor ingrese el nombre del proyecto.</div>
        </div>

        <div class="form-group">
          <label for="descripcion">Descripción</label>
          <textarea id="descripcion" name="descripcion" class="form-control" required placeholder="Descripción del proyecto"></textarea>
          <div class="invalid-feedback">Por favor ingrese la descripción.</div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="fecha_inicio">Fecha de Inicio</label>
            <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" required />
          </div>
          <div class="form-group col-md-6">
            <label for="fecha_fin">Fecha de Finalización</label>
            <input type="date" id="fecha_fin" name="fecha_fin" class="form-control" required />
          </div>
        </div>

        <div class="form-group">
          <label for="estado"><i class="fas fa-toggle-on mr-1"></i>Estado del Proyecto</label>
          <select id="estado" name="estado" class="form-control" required>
            <option value="">Seleccione un estado</option>
            <option value="pendiente">Pendiente</option>
            <option value="en progreso">En progreso</option>
            <option value="completado">Completado</option>
          </select>
        </div>

        <div class="form-group">
          <label for="imagen_proyecto"><i class="fas fa-image mr-1"></i>Imagen del Proyecto</label>
          <input type="file" id="imagen_proyecto" name="imagen_proyecto" class="form-control-file" required />
          <div class="invalid-feedback">Por favor seleccione al menos una imagen del proyecto.</div>
        </div>

        <button type="submit" name="boton" class="btn btn-primary btn-block">
          <i class="fas fa-save mr-1"></i>Guardar Proyecto
        </button>
      </form>
    </div>
  </div>

  <script>
    // Validación personalizada Bootstrap
    (function () {
      'use strict';
      window.addEventListener('load', function () {
        var forms = document.getElementsByClassName('needs-validation');
        Array.prototype.forEach.call(forms, function (form) {
          form.addEventListener('submit', function (event) {
            if (form.checkValidity() === false) {
              event.preventDefault();
              event.stopPropagation();
            }
            form.classList.add('was-validated');
          }, false);
        });
      }, false);
    })();
  </script>
</body>
</html>
