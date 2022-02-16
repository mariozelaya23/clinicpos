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
            <h1>Lista de Pacientes</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Lista de Pacientes</li>
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
                    <th>F. Nacimiento</th>
                    <th>Ver</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
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
                              <a href="viewpatient.php?id='.$row->pid.'" class="btn btn-block btn-success btn-xs" role="button" name="btnpview">Ver</a>
                            </td>
                            <td>
                              <a href="editpatient.php?id='.$row->pid.'" class="btn btn-block btn-info btn-xs" role="button" name="btnpedit">Editar</a>
                            </td>
                            <td>
                            <a href="deletepatient.php?id='.$row->pid.'" class="btn btn-block btn-danger btn-xs" role="button" name="btnpdelete">Eliminar</a>
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
                    <th>F. Nacimiento</th>
                    <th>Ver</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
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
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  } );
</script>

<!-- <script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script> -->

<?php
  include_once 'footer.php';
?>