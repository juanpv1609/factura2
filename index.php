<?php
include('includes/conexion.php');
   include('includes/sesion.php');
    if ($_SESSION['user_name']) {
        header('location: menu_p.php');
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="assets/bootstrap4/css/bootstrap.min.css">
   <link href="assets/styles/signin.css" rel="stylesheet">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
      integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA=="
      crossorigin="anonymous" />
   <title>Facturacion Electronica</title>
   <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
</head>
<body class="text-center">
   <form class="form-signin" action="functions/login.php" method="post" role="form" >
  <i class="fas fa-lock fa-7x"></i><br><br>
  <h2>Iniciar Sesión</h2>
  <label for="inputEmail" class="sr-only">Usuario</label>
  <input type="text" id="user_name" name="user_name" class="form-control" placeholder="Ingrese su nombre de usuario" required autofocus>
  <label for="inputPassword" class="sr-only">Contraseña</label>
  <input type="password" id="user_password" name="user_password" class="form-control" placeholder="Ingrese su contraseña" required>
  <!-- <div class="checkbox mb-3">
    <label>
      <input type="checkbox" value="remember-me"> Remember me
    </label>
  </div> -->
  <button class="btn btn-lg btn-primary btn-block" type="submit" name="login">Ingresar</button>
  <p class="mt-5 mb-3 text-muted">Stalin Ochoa&copy; 2020</p>
</form>

   <script src="assets/jquery/jquery-3.5.1.slim.min.js"></script>
   <script src="assets/popper/popper.min.js"></script>
   <script src="assets/bootstrap4/js/bootstrap.bundle.min.js"></script>
</body>
</html>
