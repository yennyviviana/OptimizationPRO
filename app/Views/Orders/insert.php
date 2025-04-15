<?php

require_once __DIR__ . '/../../Models/OrderModel.php';
require_once __DIR__ . '/../../Controllers/OrderController.php';

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
            <form action="insert.php?da=Orders-2" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                <div class="row g-3">

                    <!-- Columna izquierda -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nombre_pedido">Nombre del Pedido</label>
                            <input type="text" id="nombre_pedido" name="nombre_pedido" class="form-control" required placeholder="Nombre del pedido">
                            <div class="invalid-feedback">Ingrese el nombre del pedido.</div>
                        </div>

                        <div class="form-group">
                            <label for="precio">Precio</label>
                            <input type="number" id="precio" name="precio" class="form-control" required placeholder="Precio">
                            <div class="invalid-feedback">Ingrese el precio.</div>
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

                        <div class="form-group">
                            <label for="direccion">Dirección</label>
                            <input type="text" id="direccion" name="direccion" class="form-control" required placeholder="Dirección">
                            <div class="invalid-feedback">Ingrese la dirección.</div>
                        </div>

                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea id="descripcion" name="descripcion" class="form-control" rows="3" required placeholder="Descripción del pedido"></textarea>
                            <div class="invalid-feedback">Ingrese la descripción.</div>
                        </div>
                    </div>

                    <!-- Columna derecha -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="numero_seguimiento">Número de Seguimiento</label>
                            <input type="number" id="numero_seguimiento" name="numero_seguimiento" class="form-control" required placeholder="Número de seguimiento">
                            <div class="invalid-feedback">Ingrese el número de seguimiento.</div>
                        </div>

                        <div class="form-group">
                            <label for="metodo_pago">Método de Pago</label>
                            <select id="metodo_pago" name="metodo_pago" class="form-select" required>
                                <option value="">Seleccione una opción</option>
                                <option value="credito">Crédito</option>
                                <option value="Paypal">Paypal</option>
                                <option value="transferencia">Transferencia</option>
                            </select>
                            <div class="invalid-feedback">Seleccione el método de pago.</div>
                        </div>

                        <div class="form-group">
                            <label for="archivo">Archivo</label>
                            <input type="file" id="archivo" name="archivo" class="form-control" required>
                            <div class="invalid-feedback">Seleccione al menos un archivo.</div>
                        </div>

                        <div class="form-group">
                            <label for="fecha_pedido">Fecha del Pedido</label>
                            <input type="date" id="fecha_pedido" name="fecha_pedido" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="fecha_entrega">Fecha de Entrega</label>
                            <input type="date" id="fecha_entrega" name="fecha_entrega" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Tiempo Transcurrido</label>
                            <input type="text" readonly class="form-control bg-light" id="tiempo_entrega_horas">
                            <input type="hidden" name="tiempo_entrega_horas" id="tiempo_entrega_horas_valor">
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


<script>
    // Validación visual Bootstrap
    (() => {
        'use strict';
        const forms = document.querySelectorAll('.needs-validation');
        forms.forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            });
        });
    })();

    // Cálculo del tiempo entre fechas
    const fechaPedido = document.getElementById('fecha_pedido');
    const fechaEntrega = document.getElementById('fecha_entrega');
    const tiempoEntrega = document.getElementById('tiempo_entrega_horas');
    const tiempoHidden = document.getElementById('tiempo_entrega_horas_valor');

    function calcularTiempo() {
        if (fechaPedido.value && fechaEntrega.value) {
            const start = new Date(fechaPedido.value);
            const end = new Date(fechaEntrega.value);
            const diff = end - start;
            if (diff >= 0) {
                const dias = Math.floor(diff / (1000 * 60 * 60 * 24));
                const horas = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const texto = `${dias} días y ${horas} horas`;
                tiempoEntrega.value = texto;
                tiempoHidden.value = texto;
            } else {
                tiempoEntrega.value = "Fechas inválidas";
                tiempoHidden.value = "";
            }
        }
    }

    fechaPedido.addEventListener('change', calcularTiempo);
    fechaEntrega.addEventListener('change', calcularTiempo);
</script>

 

</body>
</html>