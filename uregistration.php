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
            <h1>Registro de Usuarios</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Registro de Usuarios</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- general form elements -->
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Formulario para el registro de usuarios</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form role="form">
          <div class="card-body">

            <div class="row">
              <div class="col-sm-4 col-md-4 col-lg-4">   <!-- first section 4 columns -->
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
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </div> <!-- end section 4 columns -->

              <div class="col-sm-8 col-md-8 col-lg-8">  <!-- second section 8 columns  --> 
                <table class="table table-striped">
                  <thead> <!-- table heading -->  
                    <tr>
                      <th>#</th>
                      <th>Nombre</th>
                      <th>Correo</th>
                      <th>Contraseña</th>
                      <th>Role</th>
                      <th>Eliminar</th>
                    </tr>
                  </thead>
                  <tbody> <!-- table body --> 
                    <?php
                      $select=$pdo->prepare("SELECT * FROM tbl_user ORDER BY userid");
                      $select->execute();
                      
                      while($row=$select->fetch(PDO::FETCH_OBJ)){  //using while to fetch all the data from the database // using FETCH_OBJ because I'm fetching each fild of the database
                        echo '
                          <tr>
                          <td>'.$row->userid.'</td>
                          <td>'.$row->username.'</td>
                          <td>'.$row->useremail.'</td>
                          <td>'.$row->password.'</td>
                          <td>'.$row->role.'</td>
                          <td>
                            <a href="registration.php?id='.$row->userid.'" class="btn btn-danger" role="button" name="btndelete"><span class="glyphicon glyphicon-trash" title="delete"></span></a>
                          </td>
                          </tr>
                        ';
                      }
                    ?>
                  </tbody>
                </table>

              </div> <!-- end section 8 columns  --> 
            </div>  
          
          </div>
          <!-- /.card-body -->
        </form>
      </div>
      <!-- /.card -->


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php
  include_once 'footer.php';
?>