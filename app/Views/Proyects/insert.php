<?php

require_once __DIR__ . '/../../Models/ProyectoModel.php';
require_once __DIR__ . '/../../Controllers/ProyectoController.php';



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
  
<div class="container py-5">
    <div class="card shadow-lg">
        <div class="card-header bg-dark text-white">
            <h4 class="mb-0"><i class="fas fa-box"></i> Registrar Pedido</h4>
        </div>
        <div class="card-body">
            <form action="insert.php?da=Proyects-2" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                <div class="row g-3">

                    <!-- Columna izquierda -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nombre_proyecto">Nombre_proyecto</label>
                            <input type="text" id="nombre_proyecto" name="nombre_proyecto" class="form-control" required placeholder="Nombre del proyecto">
                            <div class="invalid-feedback">Ingrese el nombre del proyecto.</div>
                        </div>

                       

                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea id="descripcion" name="descripcion" class="form-control" rows="3" required placeholder="Descripción del pedido"></textarea>
                            <div class="invalid-feedback">Ingrese la descripción.</div>
                        </div>
                    </div>

                 
                       

                        <div class="form-group">
                            <label for="fecha_pedido">Fecha de inicio</label>
                            <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="fecha_fin">Fecha fin</label>
                            <input type="date" id="fecha_fin" name="fecha_fin" class="form-control" required>
                        </div>

                     
                        <div class="form-group">
                            <label for="estado">Estado</label>
                            <select id="estado" name="estado" class="form-select" required>
                                <option value="">Seleccione una opción</option>
                                <option value="aprobado">Aprobado</option>
                                <option value="cancelado">Cancelado</option>
                                <option value="en stock">En stock</option>
                                <option value="entregado">Entregado</option>
                            </select>
                            <div class="invalid-feedback">Seleccione el estado del pedido.</div>
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