<?php
  include_once'connectdb.php';
  session_start();
  include_once'header.php';

  // when click on update password button we get values from user into variables
  if(isset($_POST['btn_update'])){
    $oldpassword_txt=$_POST['txt_oldpass'];
    $newpassword_txt=$_POST['txt_newpass'];
    $confpassword_txt=$_POST['txt_confpass'];

    //echo $oldpassword_txt." ".$newpassword_txt." ".$confpassword_txt;

    //using of select query we get database record according to useremail
    $email = $_SESSION['useremail'];
    $select = $pdo->prepare("SELECT * FROM tbl_user WHERE useremail='$email'");
    $select->execute();
    $row = $select->fetch(PDO::FETCH_ASSOC);

    echo $row['useremail'];
    echo $row['username'];

  }


?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Actualizar contraseña</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Actualizar contraseña</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Formulario para la actualización de contraseña</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
      <form action="" method="POST">
        <div class="card-body">
          <div class="form-group">
            <label for="exampleInputPassword1">Contraseña antigua</label>
            <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Password" name="txt_oldpass">
          </div>
        </div>
        <div class="card-body">
          <div class="form-group">
            <label for="exampleInputPassword1">Nueva contraseña</label>
            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="txt_newpass">
          </div>
        </div>
        <div class="card-body">
          <div class="form-group">
            <label for="exampleInputPassword1">Confirmar contraseña</label>
            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="txt_confpass">
          </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <button type="submit" class="btn btn-primary" name="btn_update">Actualizar</button>
        </div>
      </form>
    </div>
  </div>
  <!-- /.content-wrapper -->

<?php
  include_once 'footer.php';
?>
