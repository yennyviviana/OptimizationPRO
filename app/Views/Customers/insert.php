<?php
require_once __DIR__ . '/../../Models/ClienteModel.php';
require_once __DIR__ . '/../../Controllers/ClienteController.php';

?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
    <!-- Estilos de Bootstrap y Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
  

<div class="container py-5">
  <div class="card shadow-lg">
    <div class="card-header bg-dark text-white">
      <h4 class="mb-0"><i class="fas fa-user-plus"></i> Registrar Cliente</h4>
    </div>
    <div class="card-body">
      <form action="insert.php?da=Customers-2" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
        <div class="row g-3">
          <!-- Columna izquierda -->
          <div class="col-md-6">

            <div class="form-group">
              <label for="nombre">Nombre</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
                <input type="text" id="nombre" name="nombre" class="form-control" required placeholder="Ingresar nombre">
                <div class="invalid-feedback">Por favor ingrese su nombre.</div>
              </div>
            </div>

            <div class="form-group">
              <label for="apellido">Apellido</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
                <input type="text" id="apellido" name="apellido" class="form-control" required placeholder="Ingresar apellido">
                <div class="invalid-feedback">Por favor ingrese su apellido.</div>
              </div>
            </div>

            <div class="form-group">
              <label for="email">Email</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                <input type="email" id="email" name="email" class="form-control" required placeholder="Ingresar correo electrónico">
                <div class="invalid-feedback">Por favor ingrese su correo electrónico.</div>
              </div>
            </div>


            <div class="form-group">
              <label for="documento_identidad">documento_identidad</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                <input type="number" id="documento_identidad" name="documento_identidad" class="form-control" required placeholder="Ingresar número de teléfono">
                <div class="invalid-feedback">Por favor ingrese  el documento de identidad.</div>
              </div>
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

            <div class="form-group">
              <label for="direccion">Dirección</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                <input type="text" id="direccion" name="direccion" class="form-control" required placeholder="Ingresar dirección">
                <div class="invalid-feedback">Por favor ingrese su dirección.</div>
              </div>
            </div>

            <div class="form-group">
              <label for="telefono">Teléfono</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                <input type="tel" id="telefono" name="telefono" class="form-control" required placeholder="Ingresar número de teléfono">
                <div class="invalid-feedback">Por favor ingrese su número de teléfono.</div>
              </div>
            </div>

           

            <div class="form-group">
              <label for="ciudad">Ciudad</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-city"></i></span>
                <input type="text" id="ciudad" name="ciudad" class="form-control" required placeholder="Ingresar ciudad">
                <div class="invalid-feedback">Por favor ingrese su ciudad.</div>
              </div>
            </div>

          </div>

          <!-- Columna derecha -->
          <div class="col-md-6">

            <div class="form-group">
              <label for="estado">Estado</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-map"></i></span>
                <select id="estado" name="estado" class="form-select" required>
                  <option value="">Seleccione una opción</option>
                  <option value="aprobado">Aprobado</option>
                  <option value="cancelado">Cancelado</option>
                  <option value="en stock">En stock</option>
                </select>
                <div class="invalid-feedback">Por favor seleccione su estado.</div>
              </div>
            </div>

            <div class="form-group">
              <label for="codigo_postal">Código Postal</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-mail-bulk"></i></span>
                <input type="text" id="codigo_postal" name="codigo_postal" class="form-control" required placeholder="Ingresar código postal">
                <div class="invalid-feedback">Por favor ingrese su código postal.</div>
              </div>
            </div>

            <div class="form-group">
              <label for="pais">País</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-flag"></i></span>
                <select id="pais" name="pais" class="form-select" required>
                  <option value="">Seleccione un país</option>
                  <option value="colombia">Colombia</option>
                  <option value="ecuador">Ecuador</option>
                  <option value="brazil">Brasil</option>
                  <option value="estados unidos">Estados Unidos</option>
                  <option value="españa">España</option>
                </select>
                <div class="invalid-feedback">Por favor seleccione su país.</div>
              </div>
            </div>


            <div class="form-group">
                            <label for="notas">Notas</label>
                            <textarea id="notas" name="notas" class="form-control" rows="3" required placeholder="notas"></textarea>
                            <div class="invalid-feedback">Ingrese la  nota.</div>
                        </div>
                    </div>

            <div class="form-group">
              <label for="fecha_creacion">Fecha de Creación</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                <input type="date" id="fecha_creacion" name="fecha_creacion" class="form-control" required>
                <div class="invalid-feedback">Por favor ingrese la fecha de creación.</div>
              </div>
            </div>

            <div class="form-group">
              <label for="fecha_modificacion">Fecha de Modificación</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                <input type="date" id="fecha_modificacion" name="fecha_modificacion" class="form-control">
                <div class="invalid-feedback">Por favor ingrese la fecha de modificación.</div>
              </div>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
