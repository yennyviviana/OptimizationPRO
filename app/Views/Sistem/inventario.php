<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
   integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
   <title>Panel Inventario</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.css">
   <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
  <script src="https://unpkg.com/feather-icons"></script>
    
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
        background-color: #007bff;
        color: #fff;
        border-color: #007bff;
        font-weight: bold;
      }
      .table th, .table td {
        border-color: #dee2e6;
        padding: 12px;
        vertical-align: middle;
      }
      .table tbody tr:nth-child(even) {
        background-color: #f2f2f2;
      }
      .table tbody tr:hover {
        background-color: #e9ecef;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Inventarios</h1>
        </div>
  
        <div class="row">
          <div class="col-md-6">
            <form class="mb-4">
              <div class="form-row">
                <div class="col-md-6 mb-3">
                  <label for="producto">Producto</label>
                  <input type="text" class="form-control" id="producto" placeholder="Ingrese el nombre del producto" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="cantidad">Stock</label>
                  <input type="number" class="form-control" id="cantidad" placeholder="Ingrese el stock disponible" required>
                </div>
              </div>
              <div class="form-row">
                <div class="col-md-12 mb-3">
                  <label for="descripcion">Descripción</label>
                  <textarea class="form-control" id="descripcion" placeholder="Ingrese una descripción del producto"></textarea>
                </div>
              </div>
              <button class="btn btn-primary" type="submit">Registrar Producto</button>
            </form>
          </div>
  
          <div class="col-md-6">
            <h2>Listado de Inventarios</h2>
            <table class="table mt-4">
              <thead>
                <tr>
                  <th>Código</th>
                  <th>Producto</th>
                  <th>Cantidad</th>
                  <th>Descripción</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>001</td>
                  <td>Inventarios 001</td>
                  <td>50</td>
                  <td>Descripción del producto</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </main>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>
    <script>
      feather.replace();
    </script>
    <footer></footer>
  </body>
  </html>
 
