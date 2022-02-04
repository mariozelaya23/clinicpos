<?php
  include_once'connectdb.php';
  session_start();

  if($_SESSION['useremail']=="" OR $_SESSION['role']=="User"){  //with this session variable changepassword.php wont open until you login
    header('location:index.php');
  }

  include_once'header.php';

?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Registro de Usuarios</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Registro de Usuarios</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Formulario para el registro de usuarios</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
      <form>
        <div class="card-body">
          <div class="col-md-4"> <!-- first section 4 columns -->  
            <div class="form-group">
              <label for="exampleInputEmail1">Nombre y Apellido</label>
              <input type="text" class="form-control" placeholder="Ingrese nombres y apellidos" name="">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Correo Electrónico</label>
              <input type="email" class="form-control" placeholder="Ingrese el correo electrónico" name="">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Contraseña</label>
              <input type="password" class="form-control"  placeholder="Ingrese la contraseña" name="">
            </div>
            <label>Role</label>
            <div class="form-group">
              <select class="custom-select form-control-border" id="exampleSelectBorder">
                <option>Usuario</option>
                <option>Administrador</option>
                <option>Value 3</option>
              </select>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </div>
          <div class="col-md-8"> <!-- second section 8 columns  --> 


          </div>
      </form>
    </div>
    <!-- /.card -->
  </div>
  <!-- /.content-wrapper -->

<?php
  include_once 'footer.php';
?>
