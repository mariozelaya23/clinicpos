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
  $tel_db = $row['pnumerotel'];

  if(isset($_POST['btnupload'])){
    $f_name = $_FILES['myfile']['name'];
    $f_tmp = $_FILES['myfile']['tmp_name'];
    $f_size = $_FILES['myfile']['size'];
    $f_extension = explode('.',$f_name);
    $f_extension = strtolower(end($f_extension));
    // $f_newfile = uniqid().'-'.$f_name.'.'. $f_extension;
    $f_newfile = uniqid().'-'. $f_name;
    // $f_newfile = uniqid().'.'. $f_extension;
    // $f_newfile = $f_name.'.'. $f_extension;
    

    // $store = "patientfiles/".$f_name;
    $store = "patientfiles/".$f_newfile;

    if ($f_extension == 'jpg' || $f_extension == 'jpeg' || $f_extension == 'png' || $f_extension == 'gif' || $f_extension == 'pdf'){
      if ($f_size >= 5000000){
        $error = '<script type="text/javascript">
        jQuery(function validation(){
  
          swal({
            title: "Error!",
            text: "El archivo no puede pesar mas de 5MB",
            icon: "warning",
            button: "Ok",
          });
  
        })
        </script>';
        echo $error;
      } else {
        if (move_uploaded_file($f_tmp,$store)){
          // $patientfile=$f_name;

          if (!isset($errorr)){
            $insert = $pdo->prepare("INSERT INTO tbl_parchivos(parchivonombre,parchivoext,pacienteid) 
                                    VALUES(:parchivonombre,:parchivoext,:pacienteid)");
            
            // $insert->bindParam(':parchivonombre',$patientfile);
            $insert->bindParam(':parchivonombre',$f_newfile);
            $insert->bindParam(':parchivoext',$f_extension);
            $insert->bindParam(':pacienteid',$id_db);

            if($insert->execute()){
              echo '<script type="text/javascript">
              jQuery(function validation(){
        
                swal({
                  title: "Archivo subido",
                  text: "Archivo subido exitosamente",
                  icon: "success",
                  button: "Ok",
                });
        
              }, 5000);
              </script>';
            }else{
              echo '<script type="text/javascript">
              jQuery(function validation(){
        
                swal({
                  title: "ERROR!",
                  text: "El Archivo no pudo ser subido",
                  icon: "error",
                  button: "Ok",
                });
        
              })
              </script>';
            }

          }
      
        }
      }
    } else {
      echo '<script type="text/javascript">
      jQuery(function validation(){

        swal({
          title: "Warning!",
          text: "Archivo incorrecto, solo puede subir archivos jpg, jpeg, png, gif or pdf",
          icon: "error",
          button: "Ok",
        });

      })
      </script>';
    }

  }
  


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
        <form role="form" action="" method="POST" enctype="multipart/form-data">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-4 col-md-4 col-lg-4">   <!-- first section 4 columns -->
                <div class="form-group">
                  <label for="">Nombre del Paciente</label>
                  <input type="text" class="form-control" value="<?php echo $pnombre_db.' '.$papellido_db;?>" placeholder="" name="txtname" disabled>
                </div>
                <div class="form-group">
                  <label for="">Número de teléfono</label>
                  <input type="email" class="form-control" value="<?php echo $tel_db;?>" placeholder="" name="txttel" disabled>
                </div>
                <div class="form-group">
                  <label for="">Seleccione un archivo:</label>
                  <input type="file" class="input-group" name="myfile" required>
                  <p>Subir archivo</p>
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-success" name="btnupload">Subir archivo</button>
                </div>
              </div> <!-- end section 4 columns -->

              <div class="col-sm-8 col-md-8 col-lg-8">  <!-- second section 8 columns  --> 

                <div class="card">  <!-- Users Table starts  -->
                  <div class="card-header">
                    <h3 class="card-title">Lista de archivos del Paciente</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body table-responsive p-0">
                    <table id="tableusuers" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Archivo</th>
                          <th>Tipo</th>
                          <th>Fecha</th>
                          <th>Descargar</th>
                          <th>Eliminar</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                          $select=$pdo->prepare("SELECT * FROM tbl_parchivos WHERE pacienteid=$id");
                          $select->execute();

                          while($row=$select->fetch(PDO::FETCH_OBJ)){  //using while to fetch all the data from the database // using FETCH_OBJ because I'm fetching each fild of the database
                            echo '
                              <tr>
                                <td>'.$row->parchivosid.'</td>
                                <td>'.$row->parchivonombre.'</td>
                                <td>'.$row->parchivoext.'</td>
                                <td>'.$row->timestamp.'</td>
                                <td>
                                  
                                </td>
                                <td>
                                  <button id='.$row->parchivosid.' class="btn btn-block btn-danger btn-xs btnarchivodelete">Eliminar</button>
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