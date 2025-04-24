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
              <label for="nombre" class="form-label">Nombre::</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
                <input type="text" id="nombre" name="nombre" class="form-control" required placeholder="Ingresar nombre">
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
              <label for="tipo_contrato" class="form-label">Tipo de contrato</label>
              <select id="tipo_contrato" name ="tipo_contrato"</option>
                <option value="indefinido">Indefinido</option>
                <option value="prestacion de servicios">prestacion de servicios</option>
                <option value="fijo">Fijo</option>
                <option value="aprendizaje">aprendizaje</option>
                <option value="contrato de obra o labor">Contrato de obra o labor</option>
              </select>
              <div class="invalid-feedback">Por favor seleccione el tipo de contrato.</div>
            </div>

            <div class="mb-3">
              <label for="fecha_contratacion" class="form-label">Fecha de Contratación</label>
              <input type="date" id="fecha_contratacion" name="fecha_contratacion" class="form-control" required>
              <div class="invalid-feedback">Por favor ingrese la fecha de contratación.</div>
            </div>

            <div class="mb-3">
              <label for="horas_trabajo" class="form-label"> Horas de trabajo</label>
              <input type="number" id="horas_trabajo" name="horas_trabajo" class="form-control" required placeholder="Días u horas trabajadas">
              <div class="invalid-feedback">Por favor ingrese las horas trabajo.</div>
            </div>

            <div class="mb-3">
              <label for="tarifa_hora" class="form-label">tarifa</label>
              <input type="number" id="tarifa_hora" name="tarifa_hora" class="form-control" required placeholder="Tarifa hora">
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

            <div class="form-group">
              <label for="tipo_documento">tipo documento</label>
                <select id="tipo_documento" name="tipo_documento" class="form-select" required>
                  <option value="">Seleccione una opción</option>
                  <option value="CC">Cedula</option>
                  <option value="TI">Tarjeta de identidad</option>
                  <option value="Passaporte">Passaporte</option>
                </select>
                <div class="invalid-feedback">Por favor seleccione su  tipo de documento.</div>
              </div>
            </div>

            <div class="mb-3">
              <label for="documento_identidad" class="form-label">Documento de Identidad</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                <input type="number" id="documento_identidad" name="documento_identidad" class="form-control" required placeholder="Documento de identidad">
              </div>
              <div class="invalid-feedback">Por favor ingrese el documento de identidad.</div>
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
              <label for="pais" class="form-label">Pais</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-city"></i></span>
                <input type="text" id="ciudad" name="pais" class="form-control" required placeholder="Pais">
              </div>
              <div class="invalid-feedback">Por favor ingrese el pais de residencia.</div>
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
              <label for="telefono" class="form-label">Teléfono</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                <input type="text" id="telefono" name="telefono" class="form-control" required placeholder="Teléfono de contacto">
              </div>
              <div class="invalid-feedback">Por favor ingrese el teléfono de contacto.</div>
            </div>


            <div class="form-group">
              <label for="correo">Correo</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                <input type="email" id="email" name="correo" class="form-control" required placeholder="Ingresar correo">
                <div class="invalid-feedback">Por favor ingrese su correo electrónico.</div>
              </div>
            </div>

            <div class="mb-3">
              <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
              <input type="date" id="ha_nacimiento" name="fecha_nacimiento" class="form-control" required>
              <div class="invalid-feedback">Por favor ingrese la fecha de nacimiento.</div>
            </div>
          </div>


          
          <div class="mb-3">
              <label for="genero" class="form-label">Genero</label>
              <select id="genero" name="genero" class="form-select" required>
                <option value="">Seleccione un genero</option>
                <option value="femenino">Femenino</option>
                <option value="femenino">Masculino</option>
                <option value="prefiero no decir">Prefiero no decir</option>
                
              </select>
              <div class="invalid-feedback">Por favor seleccione el genero.</div>
            </div>


            <div class="mb-3">
              <label for="estado_civil" class="form-label">Estado civil</label>
              <select id="estado_civil" name="genero" class="form-select" required>
              <option value="">Seleccione un estado civil...</option>
                <option value="">Soltero</option>
                <option value="femenino">Casado</option>
                <option value="femenino">Divorciado</option>
                <option value="Prefiero no decir">Prefiero no decir</option>
                
              </select>
              <div class="invalid-feedback">Por favor seleccione el genero.</div>
            </div>


            <div class="mb-3">
              <label for="Imagen" class="form-label">Imagen</label>
              <input type="file" accept="image/*" capture="camera" id="Imagen" name="Imagen" class="form-control" required>
              <div class="invalid-feedback">Por favor seleccione una imagen.</div>
            </div>
          </div>
        </div>


            <div class="mb-3">
              <label for="documentacion_archivo" class="form-label">Documentación</label>
              <input type="file" id="documentacion" name="documentacion" class="form-control" required>
              <div class="invalid-feedback">Por favor seleccione un archivo de documentación.</div>
            </div>

            <div class="mb-3">
              <label for="descripcion" class="form-label">Descripción</label>
              <textarea id="descripcion" name="descripcion" class="form-control" required placeholder="Descripción"></textarea>
              <div class="invalid-feedback">Por favor ingrese la descripción profesional.</div>
            </div>


            <div class="mb-3">
              <label for="fecha_creacion" class="form-label">Fecha de Creación</label>
              <input type="date" id="fecha_creacion" name="fecha_creacion" class="form-control" required>
              <div class="invalid-feedback">Por favor ingrese la fecha de creación.</div>
            </div>
          </div>

          <div class="mb-3">
              <label for="fecha_modificacion" class="form-label">fecha de modificacion</label>
              <input type="date" id="fecha_modificacion" name="fecha_modificacion" class="form-control" required>
              <div class="invalid-feedback">Por favor ingrese la fecha de modificacion.</div>
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

