<?php

require_once __DIR__ . '/../../Models/PedidoModel.php';
require_once __DIR__ . '/../../Controllers/PedidoController.php';

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a2e0e6a0b5.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
                            <label for="referencia">Referencia</label>
                            <input type="number" id="referencia" name="referencia" class="form-control" required placeholder="Referencia">
                            <div class="invalid-feedback">Ingrese la referencia.</div>
                        </div>

                        <div class="form-group">
                            <label for="total">Total</label>
                            <input type="number" id="total" name="total" class="form-control" required placeholder="Total del pedido">
                            <div class="invalid-feedback">Ingrese el total.</div>
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
                            <label for="direccion_entrega">Dirección de entrega</label>
                            <input type="text" id="direccion_entrega" name="direccion_entrega" class="form-control" required placeholder="Dirección de entrega">
                            <div class="invalid-feedback">Ingrese la dirección de entrega.</div>
                        </div>

                        <div class="form-group">
                            <label for="observaciones">Observaciones</label>
                            <textarea id="observaciones" name="observaciones" class="form-control" rows="3" required placeholder="Observaciones del pedido"></textarea>
                            <div class="invalid-feedback">Ingrese las observaciones.</div>
                        </div>
                    </div>

                    <!-- Columna derecha -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tracking">Tracking</label>
                            <input type="number" id="tracking" name="tracking" class="form-control" required placeholder="Número de seguimiento">
                            <div class="invalid-feedback">Ingrese el número de seguimiento.</div>
                        </div>

                        <div class="form-group">
                            <label for="tiempo_estimado_horas">Tiempo Estimado (Horas)</label>
                            <input type="number" readonly class="form-control bg-light" id="tiempo_estimado_horas_visible" placeholder="Calculado automáticamente">
                            <input type="hidden" name="tiempo_estimado_horas" id="tiempo_estimado_horas">
                        </div>

                        <div class="form-group">
                            <label for="detalles">Detalles</label>
                            <textarea id="detalles" name="detalles" class="form-control" rows="3" required placeholder="Detalles del pedido"></textarea>
                            <div class="invalid-feedback">Ingrese los detalles del pedido.</div>
                        </div>

                        <div class="form-group">
                            <label for="id_usuario">Usuario</label>
                            <select class="form-select" id="id_usuario" name="id_usuario" required>
                                <option value="">Seleccione el usuario</option>
                                <?php foreach ($usuarios as $usuario): ?>
                                    <option value="<?php echo $usuario['id_usuario']; ?>">
                                        <?php echo $usuario['id_usuario']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">Seleccione el usuario.</div>
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
                            <label for="archivo_adjunto">Archivo Adjunto</label>
                            <input type="file" id="archivo_adjunto" name="archivo_adjunto" class="form-control" required>
                            <div class="invalid-feedback">Adjunte un archivo.</div>
                        </div>

                        <div class="form-group">
                            <label for="fecha_pedido">Fecha del Pedido</label>
                            <input type="date" id="fecha_pedido" name="fecha_pedido" class="form-control" required>
                            <div class="invalid-feedback">Seleccione la fecha del pedido.</div>
                        </div>

                        <div class="form-group">
                            <label for="fecha_entrega">Fecha de Entrega</label>
                            <input type="date" id="fecha_entrega" name="fecha_entrega" class="form-control" required>
                            <div class="invalid-feedback">Seleccione la fecha de entrega.</div>
                        </div>
                    </div>

                    <div class="text-end mt-4">
                        <button type="submit" name="boton" class="btn btn-success px-4">
                            <i class="fas fa-save"></i> Guardar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script>
    CKEDITOR.replace('detalles');

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
    const tiempoEntrega = document.getElementById('tiempo_estimado_hora');
    const tiempoHidden = document.getElementById('tiempo_estimado_hora_valor');

    function calcularTiempo() {
        if (fechaPedido.value && fechaEntrega.value) {
            const start = new Date(fechaPedido.value);
            const end = new Date(fechaEntrega.value);
            const diff = end - start;
            if (diff >= 0) {
                const dias = Math.floor(diff / (1000 * 60 * 60 * 24));
                const horas = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const texto = `${dias} días y ${horas} horas`;
                tiempoEstimado.value = texto;
                tiempoHidden.value = texto;
            } else {
                tiempoEstimado.value = "Fechas inválidas";
                tiempoHidden.value = "";
            }
        }
    }

    fechaPedido.addEventListener('change', calcularTiempo);
    fechaEntrega.addEventListener('change', calcularTiempo);
</script>

 

</body>
</html>