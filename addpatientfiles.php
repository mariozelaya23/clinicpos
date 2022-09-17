<?php
  include_once'connectdb.php';
  session_start();

  if($_SESSION['useremail']=="" OR $_SESSION['role']=="Usuario"){  //with this session variable changepassword.php wont open until you login
    header('location:index.php');
  }
  if($_SESSION['role']=="Admin"){
    include_once'header.php';
  }else{
    include_once'headeruser.php';
  }

  try {
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }catch (PDOException $e){
    echo $e->getMessage();
  }

  // getting the patient id from patient list page as well the data from that page
  $id = $_GET['id'];
  $select = $pdo->prepare("SELECT * FROM tbl_paciente WHERE pid=$id");
  $select->execute();
  $row = $select->fetch(PDO::FETCH_ASSOC);

  $id_db = $row['pid'];
  $pnombre_db = $row['pnombre'];
  $papellido_db = $row['papellido'];


?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Administración de Archivos</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Administración de Archivos</li>
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
          <h3 class="card-title">Formulario para la administración de archivos</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form role="form" action="" method="POST">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-4 col-md-4 col-lg-4">   <!-- first section 4 columns -->
                <div class="form-group">
                  <label for="">Nombre del Paciente</label>
                  <input type="text" class="form-control" value="" placeholder="" name="txtname">
                </div>
                <div class="form-group">
                  <label for="">Número de teléfono</label>
                  <input type="email" class="form-control" value="" placeholder="" name="txttel">
                </div>
                <div class="form-group">
                  <label for="">Seleccione un archivo:</label>
                  <input type="file" class="form-control" name="myfile">
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-success" name="btnupload">Subir archivo</button>
                </div>
              </div> <!-- end section 4 columns -->

              <div class="col-sm-8 col-md-8 col-lg-8">  <!-- second section 8 columns  --> 

                <div class="card">  <!-- Users Table starts  -->
                  <div class="card-header">
                    <h3 class="card-title">Usuarios registrados al sistema</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body table-responsive p-0">
                    <table id="tableusuers" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Nombre</th>
                          <th>Correo</th>
                          <th>Contraseña</th>
                          <th>Role</th>
                          <th></th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
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
                                  <button type="submit" value="'.$row->userid.'" class="btn btn-block btn-success btn-xs" name="btnedit">Editar</button>
                                </td>
                                <td>
                                <a href="uregistration.php?id='.$row->userid.'" class="btn btn-block btn-danger btn-xs" role="button" name="btndelete">Eliminar</a>
                                </td>
                              </tr>
                            ';
                          }
                        ?>
                      </tbody>
                    </table>
                  </div>
                  <!-- /.card-body -->
                </div> <!-- Users Table Ends  -->
                <!-- /.card -->  


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

<!-- Call this single function -->
<script>
  jQuery(document).ready( function ($) {
    $('#tableusuers').DataTable();
  } );
</script>

<?php
  include_once 'footer.php';
?>