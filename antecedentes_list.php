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
            <h1>Lista de Antecedentes</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Antecedentes</li>
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
                    <th>Telefono</th>
                    <th>F.Nac</th>         
                    <th>F.Antecedente</th>
                    <th>Ver</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                      $select = $pdo->prepare("SELECT a.antecedentesid AS antecedentesid, CONCAT(p.pnombre,' ',p.papellido) AS pnombre, 
                                                a.timestamp AS fecha, p.pnumerotel AS ptel, p.pfnac AS fnac 
                                                FROM tbl_antecedente a
                                                INNER JOIN tbl_paciente p
                                                ON p.pid = a.pacienteid");
                      $select->execute();
                      while($row=$select->fetch(PDO::FETCH_OBJ)){
                        echo '
                          <tr>
                            <td>'.$row->antecedentesid.'</td>
                            <td>'.$row->pnombre.'</td>
                            <td>'.$row->ptel.'</td>
                            <td>'.$row->fnac.'</td>
                            <td>'.$row->fecha.'</td>
                            <td>
                              <a href="viewantecedente.php?id='.$row->antecedentesid.'" class="btn btn-block btn-success btn-xs" role="button" name="btnaview">Ver</a>
                            </td>
                            <td>
                              <a href="editantecedente.php?id='.$row->antecedentesid.'" class="btn btn-block btn-info btn-xs" role="button" name="btnaedit">Editar</a>
                            </td>
                            <td>
                            <button id='.$row->antecedentesid.' class="btn btn-block btn-danger btn-xs btnadelete">Eliminar</button>
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
                    <th>Telefono</th>
                    <th>F.Nac</th>         
                    <th>Fecha Historia</th>
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
      "responsive": true, "lengthChange": false, "autoWidth": false
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  } );
</script>

<!-- DELETE BUTTON AJAX CODE -->
<script>
  $(document).ready(function(){
    $(document).on('click','.btnadelete',function(e){
      //alert('Test');
      var btn = $(e.currentTarget);
      var tdh = btn;
      var id = btn.attr("id");
      //alert(id);
      //sweet alert
      swal({
        title: "¿Está seguro de desea eliminar el este Antecedente?",
        text: "¡Una vez eliminado el Antecedente no se puede recuperar este registro!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) { //ajax code
          $.ajax({
            url:'deleteantecedente.php',
            type:'POST',
            data:{
              antecedentesidd:id
            },
            success:function(data){
              tdh.parents('tr').hide();
            }
          })
          swal("¡El Antecedente ha sido eliminado exitosamente!", {
            icon: "success",
          });
        } else {
          swal("¡El Antecedente no fue eliminado");
        }
      });
    });
  });

</script>

<?php
  include_once 'footer.php';
?>