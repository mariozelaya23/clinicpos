<?php ob_start(); session_start();?>

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- Sweetalert2 -->
<script src="plugins/sweetalert/sweetalert.js"></script>

<?php
  error_reporting(0); 
  include_once 'connectdb.php';
  session_start();

  if(isset($_POST['btn_login'])){  //if btn_login button is pressed
    $useremail = $_POST['txt_useremail'];  //store in variable useremail input from txt_useremail
    $password = $_POST['txt_password'];  //store in variable password input from txt_password
    
    //echo $useremail." ".$password;

    //getting email and password from database where input variables $username and $password
    $select = $pdo->prepare("SELECT * FROM tbl_user WHERE useremail='$useremail' AND password='$password'");
    $select->execute();
    $row = $select->fetch(PDO::FETCH_ASSOC); // we store the query in row variable

    //comparing if input variables are equal to useremail and password database filds | also checks if admin role will redirect to dashboard if not to user
    if($row['useremail']==$useremail AND $row['password']==$password AND $row['role']=="Admin"){
      //blocking to access admin dashboard without typing the credentials, adding session variables and storing user info on those variables, 
      //you need to get this variables on dashboard.php
      $_SESSION['userid'] = $row['userid'];
      $_SESSION['username'] = $row['username'];
      $_SESSION['useremail'] = $row['useremail'];
      $_SESSION['role'] = $row['role'];

      // success alert login for admin
      echo '<script type="text/javascript">
      jQuery(function validation(){

        swal({
          title: "Good job!'." ".$_SESSION['username'].'",
          text: "Welcome!'." ".$_SESSION['role'].'",
          icon: "success",
          button: "Loading...",
        });

      })

      </script>';
      header('refresh:2;dashboard.php');
    }else if ($row['useremail']==$useremail AND $row['password']==$password AND $row['role']=="Usuario"){
      $_SESSION['userid'] = $row['userid'];
      $_SESSION['username'] = $row['username'];
      $_SESSION['useremail'] = $row['useremail'];
      $_SESSION['role'] = $row['role'];
      
      // success alert login for user
      echo '<script type="text/javascript">
      jQuery(function validation(){

        swal({
          title: "Good job!'." ".$_SESSION['username'].'",
          text: "Welcome!'." ".$_SESSION['role'].'",
          icon: "success",
          button: "Loading...",
        });

      })

      </script>';
      header('refresh:2;user.php');
    }else{
      echo '<script type="text/javascript">
      jQuery(function validation(){

        swal({
          title: "Error!",
          text: "Correo o contraseña no validos!!",
          icon: "error",
          button: "Ok",
        });

      })

      </script>';
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SAC | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="index.php" class="h1"><b>SAC</b></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Ingrese sus credenciales para iniciar sesión</p>

      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email" name="txt_useremail" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="txt_password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <a href="#" onclick="swal('Para cambio de contraseña ','Por favor contacte al administrador','error')">Olvide mi contraseña</a>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block" name="btn_login">Log In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <p class="mb-1">
        
      </p>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->


</body>
</html>
