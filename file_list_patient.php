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

?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Agregar Nuevo Archivo</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Nuevo Archivo</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

    <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Domicilio</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>F.Nac</th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                      $select = $pdo->prepare("SELECT * FROM tbl_paciente ORDER BY pid");
                      $select->execute();
                      while($row=$select->fetch(PDO::FETCH_OBJ)){
                        echo '
                          <tr>
                            <td>'.$row->pid.'</td>
                            <td>'.$row->pnombre.'</td>
                            <td>'.$row->papellido.'</td>
                            <td>'.$row->pdomicilio.'</td>
                            <td>'.$row->pemail.'</td>
                            <td>'.$row->pnumerotel.'</td>
                            <td>'.$row->pfnac.'</td>
                            <td>
                              <a href="addpatientfiles.php?id='.$row->pid.'" class="btn btn-block btn-warning btn-xs" role="button" name="btnfadd">Administrar Archivos</a>
                            </td>
                          </tr>
                        ';
                      }
                    ?>
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Domicilio</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>F.Nac</th>
                    <th></th>
                  </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
      


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<!-- Call this single function -->
<!-- <script>
  jQuery(document).ready( function ($) {
    $('#tableusuers').DataTable();
  } );
</script> -->

<script>
  jQuery(document).ready( function ($) {
    $('#example1').DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  } );
</script>

<?php
  include_once 'footer.php';
?>