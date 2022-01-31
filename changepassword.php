<?php
  include_once'connectdb.php';
  session_start();
  include_once'header.php';
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
      <form>
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
