<?php
  include_once'connectdb.php';
  session_start();

  if($_SESSION['useremail']=="" OR $_SESSION['role']=="User"){  //with this session variable changepassword.php wont open until you login
    header('location:index.php');
  }

  if($_SESSION['role']=="Admin"){
    include_once'header.php';
  }else{
    include_once'headeruser.php';
  }

?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Agregar Paciente</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Agregar Paciente</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      
      <div class="card card-info">
        <div class="card-header">
          <h3 class="card-title"><a href="patientlist.php" class="btn btn-primary" role="button">Lista de pacientes</a></h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form role="form" action="" method="POST">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-6 col-md-6 col-lg-6">   <!-- first section 6 columns -->
                <div class="form-group">
                  <label for="exampleInputPassword1">Nombre</label>
                  <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Ingrese el nombre" name="txt_nombre" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Apellido</label>
                  <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Ingrese el apellido" name="txt_apellido" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Domicilio</label>
                  <textarea type="text" class="form-control" id="exampleInputPassword1" placeholder="Ingrese el domicilio" name="txt_domicilio" rows="2" required></textarea>
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-info" name="btnupdate">Agregar</button>
                </div>
              </div> <!-- end first section 6 columns -->
              <div class="col-sm-6 col-md-6 col-lg-6">   <!-- second section 6 columns -->
                <div class="form-group">
                    <label for="exampleInputPassword1">Correo electrónico</label>
                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Ingrese el correo electrónico" name="txt_telefono">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Número de teléfono</label>
                  <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Ingrese el número de teléfono" name="txt_telefono" required>
                </div>
                <div class="form-group">
                  <label>Fecha de nacimiento:</label>
                    <input type="date" class="form-control" data-date-inline-picker="true"  name="txt_fnac"/>
                    </div>
                </div>
              </div> <!-- end second section 6 columns -->
            </div>
          </div>
        </form>
        <!-- /.card-body -->
      </div>


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


<?php
  include_once 'footer.php';
?>