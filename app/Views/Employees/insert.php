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
            <!-- Tipo de contrato -->
            <div class="mb-3">
              <label for="tipo_contrato" class="form-label">
                Tipo de contrato
              </label>
              <select id="tipo_contrato" name="tipo_contrato"
                      class="form-select" required>
                <option value="">Seleccione tipo de contrato</option>
                <option value="indefinido">Indefinido</option>
                <option value="prestacion de servicios">
                  Prestación de servicios
                </option>
                <option value="fijo">Fijo</option>
                <option value="aprendizaje">Aprendizaje</option>
                <option value="obra_o_labor">
                  Contrato de obra o labor
                </option>
              </select>
              <div class="invalid-feedback">
                Por favor seleccione el tipo de contrato.
              </div>
            </div>

            <!-- Fecha de contratación -->
            <div class="mb-3">
              <label for="fecha_contratacion" class="form-label">
                Fecha de Contratación
              </label>
              <input type="date" id="fecha_contratacion"
                     name="fecha_contratacion"
                     class="form-control" required>
              <div class="invalid-feedback">
                Por favor ingrese la fecha de contratación.
              </div>
            </div>

            <!-- Horas de trabajo -->
            <div class="mb-3">
              <label for="horas_trabajo" class="form-label">
                Horas de trabajo
              </label>
              <input type="number" id="horas_trabajo"
                     name="horas_trabajo"
                     class="form-control" required
                     placeholder="Días u horas trabajadas">
              <div class="invalid-feedback">
                Por favor ingrese las horas de trabajo.
              </div>
            </div>

            <!-- Tarifa por hora -->
            <div class="mb-3">
              <label for="tarifa_hora" class="form-label">
                Tarifa por hora
              </label>
              <input type="number" id="tarifa_hora"
                     name="tarifa_hora"
                     class="form-control" required
                     placeholder="Tarifa hora">
              <div class="invalid-feedback">
                Por favor ingrese el precio por hora.
              </div>
            </div>

            <!-- Salario -->
            <div class="mb-3">
              <label for="salario" class="form-label">Salario</label>
              <input type="number" id="salario" name="salario"
                     class="form-control" required
                     placeholder="Salario del empleado">
              <div class="invalid-feedback">
                Por favor ingrese el salario del empleado.
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

            <!-- Departamento -->
            <div class="mb-3">
              <label for="departamento" class="form-label">
                Departamento
              </label>
              <select id="departamento" name="departamento"
                      class="form-select" required>
                <option value="">Seleccione un departamento</option>
                <option value="valle_del_cauca">Valle del Cauca</option>
                <option value="risaralda">Risaralda</option>
                <option value="arauca">Arauca</option>
                <option value="bogota">Bogotá</option>
              </select>
              <div class="invalid-feedback">
                Por favor seleccione el departamento del empleado.
              </div>
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
            <!-- Ciudad -->
            <div class="mb-3">
              <label for="ciudad" class="form-label">Ciudad</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-city"></i></span>
                <input type="text" id="ciudad" name="ciudad"
                       class="form-control" required
                       placeholder="Ciudad de residencia">
                <div class="invalid-feedback">
                  Por favor ingrese la ciudad de residencia.
                </div>
              </div>
            </div>
            <!-- País de origen (texto) -->
            <div class="mb-3">
              <label for="pais_origen" class="form-label">
                País de origen
              </label>
              <input type="text" id="pais_origen" name="pais_origen"
                     class="form-control" required
                     placeholder="País de origen">
              <div class="invalid-feedback">
                Por favor ingrese el país de origen.
              </div>
            </div>
            <!-- País de residencia (select) -->
            <div class="mb-3">
              <label for="pais_residencia" class="form-label">
                País de residencia
              </label>
              <select id="pais_residencia" name="pais_residencia"
                      class="form-select" required>
                <option value="">Seleccione un país</option>
                <option value="colombia">Colombia</option>
                <option value="ecuador">Ecuador</option>
                <option value="brasil">Brasil</option>
                <option value="estados_unidos">Estados Unidos</option>
                <option value="espana">España</option>
              </select>
              <div class="invalid-feedback">
                Por favor seleccione el país de residencia.
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
            <!-- Correo -->
            <div class="mb-3">
              <label for="email" class="form-label">Correo</label>
              <div class="input-group">
                <span class="input-group-text">
                  <i class="fas fa-envelope"></i>
                </span>
                <input type="email" id="email" name="correo"
                       class="form-control" required
                       placeholder="Ingresar correo">
                <div class="invalid-feedback">
                  Por favor ingrese su correo electrónico.
                </div>
              </div>
            </div>
            <!-- Fecha de nacimiento -->
            <div class="mb-3">
              <label for="fecha_nacimiento" class="form-label">
                Fecha de Nacimiento
              </label>
              <input type="date" id="fecha_nacimiento"
                     name="fecha_nacimiento"
                     class="form-control" required>
              <div class="invalid-feedback">
                Por favor ingrese la fecha de nacimiento.
              </div>
            </div>
            <!-- Género -->
            <div class="mb-3">
              <label for="genero" class="form-label">Género</label>
              <select id="genero" name="genero"
                      class="form-select" required>
                <option value="">Seleccione un género</option>
                <option value="femenino">Femenino</option>
                <option value="masculino">Masculino</option>
                <option value="otro">Prefiero no decir</option>
              </select>
              <div class="invalid-feedback">
                Por favor seleccione el género.
              </div>
            </div>
            <!-- Estado civil -->
            <div class="mb-3">
              <label for="estado_civil" class="form-label">
                Estado civil
              </label>
              <select id="estado_civil" name="estado_civil"
                      class="form-select" required>
                <option value="">Seleccione un estado civil</option>
                <option value="soltero">Soltero</option>
                <option value="casado">Casado</option>
                <option value="divorciado">Divorciado</option>
                <option value="otro">Prefiero no decir</option>
              </select>
              <div class="invalid-feedback">
                Por favor seleccione el estado civil.
              </div>
            </div>
            <!-- Imagen -->
            <div class="mb-3">
              <label for="Imagen" class="form-label">Imagen</label>
              <input type="file" accept="image/*" capture="camera"
                     id="Imagen" name="Imagen"
                     class="form-control" required>
              <div class="invalid-feedback">
                Por favor seleccione una imagen.
              </div>
            </div>
            <!-- Documentación -->
            <div class="mb-3">
              <label for="documentacion" class="form-label">
                Documentación
              </label>
              <input type="file" id="documentacion"
                     name="documentacion"
                     class="form-control" required>
              <div class="invalid-feedback">
                Por favor seleccione un archivo de documentación.
              </div>
            </div>
            <!-- Descripción profesional -->
            <div class="mb-3">
              <label for="descripcion" class="form-label">
                Descripción profesional
              </label>
              <textarea id="descripcion" name="descripcion"
                        class="form-control" required
                        placeholder="Descripción"></textarea>
              <div class="invalid-feedback">
                Por favor ingrese la descripción profesional.
              </div>
            </div>
            <!-- Fecha creación -->
            <div class="mb-3">
              <label for="fecha_creacion" class="form-label">
                Fecha de Creación
              </label>
              <input type="date" id="fecha_creacion"
                     name="fecha_creacion"
                     class="form-control" required>
              <div class="invalid-feedback">
                Por favor ingrese la fecha de creación.
              </div>
            </div>
            <!-- Fecha modificación -->
            <div class="mb-3">
              <label for="fecha_modificacion" class="form-label">
                Fecha de Modificación
              </label>
              <input type="date" id="fecha_modificacion"
                     name="fecha_modificacion"
                     class="form-control" required>
              <div class="invalid-feedback">
                Por favor ingrese la fecha de modificación.
              </div>
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
<!-- Inicializamos CKEditor -->
<script src="https://cdn.ckeditor.com/4.20.2/standard/ckeditor.js"></script>
<script>
  CKEDITOR.replace('descripcion');
</script>
