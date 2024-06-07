<?php

    session_start();


    if(!isset($_SESSION['id_usuario'])){
        header("Location: index.php");
    }
    
    $nombre_usuario     = $_SESSION['nombre_usuario'];
    $correo_electronico     = $_SESSION['correo_electronico'];
    $tipo_usuario     = $_SESSION['tipo_usuario'];

  
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
   integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
   <title>Panel Erp</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.css">
   <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
  <script src="https://unpkg.com/feather-icons"></script>
    </head>
    <body>
<style>
    body{
      background: rgb(245, 238, 238);
    } 
body.dark-theme {
    background-color: #080808;
    color: #fff;
    .dark-theme h1 {
    color: #ffa500; 
  .dark-theme .btn {
    background-color: hsl(239, 88%, 16%); 
    color: #fff; 
  }
}
}
</style>


    <div class="container">

      <div class="container-fluid">
        <div class="row">
          <nav class="col-md-2 d-none d-md-block sidebar">
            <div class="sidebar-sticky">
              <ul class="nav flex-column">
                <li class="nav-item">
                  <a class="nav-link active" href="dashboard.html">
                    <span data-feather="home"></span>
                    Home<span class="sr-only">(current)</span>
                  </a>
                </li>

                <!--************************INICIA MENÚ ADMINISTRADOR************************-->

              <?php if($tipo_usuario == 9) { ?>
                <nav>
  <div class="sidebar">
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link" href="/Sistem_ERP/app/Views/Orders/create.php">
          <span data-feather="shopping-cart"></span>
          Pedidos
        </a>
      </li>
    </ul>
  </div>

      <li class="nav-item">
        <a class="nav-link" href="/Sistem_ERP/app/Views/">
          <span data-feather="box"></span>
          Inventarios
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/ERP_maquetacion/app/Views/Sistema/administracion.html">
          <span data-feather="settings"></span>
          Administracion
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/ERP_maquetacion/app/Views/Sistema/financiero.html">
          <span data-feather="bar-chart-2"></span>
          Financiero
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/ERP_maquetacion/app/Views/Sistema/compra.html">
          <span data-feather="shopping-bag"></span>
          Compras
        </a>
      </li>
    </ul>

    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
      <span>Usuario</span>
      <a class="d-flex align-items-center text-muted" href="#">
        <span data-feather="settings"></span>
      </a>
    </h6>
    <ul class="nav flex-column mb-2">
      <li class="nav-item">
        <a class="nav-link" href="#">
          <span data-feather="user"></span>
          Perfil
        </a>
      </li>
    </ul>
  </div>
</nav>

          <?php } ?>

          

<!--************************MENÚ************************-->
    <?php if($tipo_usuario == 2) { ?>
   
   <?php } ?>

<!--************************MENÚ VENTANILLA - NUEVA - MOVIMIENTOS************************-->

   <?php if($tipo_usuario == 3) { ?>
  
   <?php } ?>


          <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
              <h1 class="h2">Sistema Empresarial</h1>
              <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group mr-2">
               <button class="btn btn-sm btn-outline-secondary">Agregar Elemento</button>
                </div>
              

                <button class="btn btn-sm btn-outline-secondary" id="toggle-theme">
                  <span data-feather="moon"></span> Cambiar Tema
                </button>
        </div>
    </div>
              </div>
            </div>
      
            <div class="row">
              <div class="col-md-6">
                <canvas id="graficoBarra" width="400" height="400"></canvas>
              </div>
              <div class="col-md-6">
                <canvas id="graficoDona" width="400" height="400"></canvas>
              </div>
            </div>
      
            <div class="table-responsive">
              <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Descripción</th>
                    <th scope="col">Precio</th>
                  </tr>
                </thead>
                <tbody id="miTabla">
                  <tr>
                    <th scope="row">1</th>
                    <td>Producto 1</td>
                    <td>Descripción del producto 1</td>
                    <td>$20.00</td>
                  </tr>
                  <tr>
                    <th scope="row">2</th>
                    <td>Producto 2</td>
                    <td>Descripción del producto 2</td>
                    <td>$25900.00</td>
                  </tr>
                  <tr>
                    <th scope="row">3</th>
                    <td>Producto 3</td>
                    <td>Descripción del producto 3</td>
                    <td>$2587.00</td>
                  </tr>
                  <tr>
                    <th scope="row">4</th>
                    <td>Producto 4</td>
                    <td>Descripción del producto 4</td>
                    <td>$259.00</td>
                  </tr>
                </tbody>
              </table>
            </div>            
          </main>
        </div>
      </div>
      
      <!-- script al final para carga mas rapida-->
      <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
      
      <script>
        document.addEventListener('DOMContentLoaded', function() {
          feather.replace(); // Inicializando feather-icons.......
      
          // Gráfico de barras
          var ctxBar = document.getElementById('graficoBarra').getContext('2d');
          var barChart = new Chart(ctxBar, {
            type: 'bar',
            data: {
              labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo'],
              datasets: [{
                label: 'Ventas',
                data: [12, 19, 3, 5, 2],
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
              }]
            },
            options: {
              scales: {
                y: {
                  beginAtZero: true
                }
              }
            }
          });
      
          // Gráfico circular...
          var ctxDoughnut = document.getElementById('graficoDona').getContext('2d');
          var doughnutChart = new Chart(ctxDoughnut, {
            type: 'doughnut',
            data: {
              labels: ['Rojo', 'Verde', 'Azul'],
              datasets: [{
                data: [30, 40, 30],
                backgroundColor: ['#ff6384', '#36a2eb', '#ffce56']
              }]
            }
          });
      
          // vamos a colocar tabla con datos dinámicos....
      
        });
      </script>
      

      <script>
      const toggleButton = document.getElementById('toggle-theme');
          const body = document.body;

         toggleButton.addEventListener('click', () => {
    body.classList.toggle('dark-theme');
  });
    </script>



<footer>Copright@ yenny bibiana 2024</footer>


</body>
</html>
