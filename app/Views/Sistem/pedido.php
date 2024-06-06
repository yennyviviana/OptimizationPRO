<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
   integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
   <title>Panel Pedido</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.css">
   <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
  <script src="https://unpkg.com/feather-icons"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body {
      padding-top: 20px;
      background-color: #f8f9fa;
    }
    .container {
      max-width: 1000px;
      margin: 0 auto;
    }
    .form-control {
      border-radius: 0;
    }
    .btn-primary {
      border-radius: 0;
    }
    .table {
      border-radius: 5px;
      overflow: hidden;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
      margin-bottom: 20px;
    }
    .table thead th {
      background-color: hsl(0, 0%, 4%);
      color: #fff;
      border-color: #007bff;
      font-weight: bold;
      white-space: nowrap;
    }
    .table th, .table td {
      border-color: #dee2e6;
      padding: 12px;
      vertical-align: middle;
      white-space: nowrap;
    }
    .table tbody tr:nth-child(even) {
      background-color: #f2f2f2;
    }
    .table tbody tr:hover {
      background-color: #e9ecef;
    }
    .table td.details {
      white-space: normal;
      max-width: 250px;
      overflow: hidden;
      text-overflow: ellipsis;
    }
    @media (max-width: 768px) {
      .table td.details {
        white-space: normal;
        max-width: none;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="card">
      <div class="card-header">
        <h1 class="h3 m-0">Gestión de Pedidos</h1>
      </div>
      <div class="card-body">
        <form>
          <div class="form-row">
            <div class="col-md-6 mb-3">
              <label for="producto">Nombre del Producto</label>
              <input type="text" class="form-control" id="producto" placeholder="Ingrese el nombre del producto">
            </div>
            <div class="col-md-6 mb-3">
              <label for="cantidad">Cantidad en Stock</label>
              <input type="number" class="form-control" id="cantidad" placeholder="Ingrese la cantidad disponible en stock">
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-3">
              <label for="metodo-pago">Método de Pago</label>
              <select class="custom-select" id="metodo-pago">
                <option selected disabled>Seleccione el método de pago</option>
                <option value="efectivo">Efectivo</option>
                <option value="tarjeta">Tarjeta de Crédito/Débito</option>
                <option value="transferencia">Transferencia Bancaria</option>
              </select>
            </div>
          </div>
          <button class="btn btn-primary" type="submit">Buscar</button>
        </form>
      </div>
    </div>

    <div class="card">
      <div class="card-body">
        <h2 class="h4">Listado de Pedidos Detallado</h2>
        <div class="table-responsive">
          <table class="table mt-4">
            <thead>
              <tr>
                <th>ID</th>
                <th>Nombre del Pedido</th>
                <th>Precio</th>
                <th>Estado</th>
                <th>Dirección</th>
                <th class="details">Descripción</th>
                <th>Número de Seguimiento</th>
                <th>Tiempo de Entrega (horas)</th>
                <th class="details">Información del Pedido</th>
                <th>Método de Pago</th>
              </tr>
            </thead>
            <tbody>
              <!-- Aquí se mostrarán los datos detallados de los pedidos -->
              <tr>
                <td>1</td>
                <td>Pedido 001</td>
                <td>$50.00</td>
                <td>En progreso</td>
                <td>Calle 123, Ciudad, País</td>
                <td class="details">Producto de alta calidad, Producto de alta calidad, Producto de alta calidad</td>
                <td>123456789</td>
                <td>24</td>
                <td class="details">Detalles adicionales del pedido, Detalles adicionales del pedido, Detalles adicionales del pedido</td>
                <td>Efectivo</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- Bootstrap JS (opcional, si necesitas funcionalidad adicional de Bootstrap) -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>