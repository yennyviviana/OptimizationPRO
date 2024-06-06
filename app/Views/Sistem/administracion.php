<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
   integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
   <title>Panel Administracion</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.css">
   <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
  <script src="https://unpkg.com/feather-icons"></script>
    <link href="public/css/style.css" type="text/css" rel="stylesheet">
    </head>
    <body>

  

<div class="container-fluid">
  <div class="row">
    <nav class="col-md-2 d-none d-md-block bg-light sidebar">
      <div class="sidebar-sticky">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link active" href="#">
              <span data-feather="shopping-cart"></span>
              Pedidos
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="box"></span>
              Inventarios
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="message-circle"></span>
              Mensajes
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="users"></span>
              Usuarios
            </a>
          </li>
        </ul>
      </div>
    </nav>

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Administración</h1>
      </div>


      <form class="mb-4">
        <div class="form-row">
          <div class="col-md-6 mb-3">
            <label for="producto">Producto</label>
            <input type="text" class="form-control" id="producto" placeholder="Ingrese el nombre del producto">
          </div>
          <div class="col-md-6 mb-3">
            <label for="cantidad">Cantidad</label>
            <input type="number" class="form-control" id="cantidad" placeholder="Ingrese la cantidad">
          </div>
        </div>
        <button class="btn btn-primary" type="submit">Buscar</button>
      </form>
    </main>
  </div>
</div>

<div class="container mt-5">
  <!-- Sección de Inventarios -->
  <div class="mb-5">
    <h2 class="text-primary text-center mb-4">Inventarios</h2>
    <div class="row justify-content-center">
      <div class="col-md-4 mb-4">
        <div class="card bg-light border-primary">
          <div class="card-body">
            <h5 class="card-title text-primary">Producto X</h5>
            <p class="card-text">Unidades en stock: 50</p>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="card bg-light border-primary">
          <div class="card-body">
            <h5 class="card-title text-primary">Producto Y</h5>
            <p class="card-text">Unidades en stock: 30</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Sección de Cola de Mensajes -->
  <div class="mb-5">
    <h2 class="text-primary text-center mb-4">Cola de Mensajes</h2>
    <ul class="list-group mx-auto col-md-6">
      <li class="list-group-item bg-light border-primary"><strong>Mensaje 1:</strong> Consulta de cliente</li>
      <li class="list-group-item bg-light border-primary"><strong>Mensaje 2:</strong> Solicitud de información</li>
    </ul>
  </div>

  <!-- Sección de Gestión de Usuarios -->
  <div class="mb-5">
    <h2 class="text-primary text-center mb-4">Gestión de Usuarios</h2>
    <div class="row justify-content-center">
      <div class="col-md-4 mb-4">
        <div class="card bg-light border-primary">
          <div class="card-body">
            <h5 class="card-title text-primary">Administrador</h5>
            <p class="card-text">Eumir Pulido - Rol: Administrador</p>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="card bg-light border-primary">
          <div class="card-body">
            <h5 class="card-title text-primary">Cliente</h5>
            <p class="card-text">Bibiana - Rol: Cliente</p>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="card bg-light border-primary">
          <div class="card-body">
            <h5 class="card-title text-primary">Usuario</h5>
            <p class="card-text">Pepito Perez - Rol: Usuario</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


     
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <script src="https://unpkg.com/feather-icons"></script>

  <script>
    feather.replace();
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