<?php
  include_once'connectdb.php';
  session_start();

  if($_SESSION['useremail']=="" OR $_SESSION['role']=="Usuario"){  //with this session variable changepassword.php wont open until you login
    header('location:index.php');
    exit();
  }
 

  // getting the checkin id from checkin list page as well the data from that page
  $id = $_GET['id'];
  $select = $pdo->prepare("SELECT h.historiaid AS historiaid, CONCAT(p.pnombre,' ',p.papellido) AS pnombre, 
                          h.timestamp AS fecha, h.historia AS historia
                          FROM tbl_historia h
                          INNER JOIN tbl_paciente p ON p.pid = h.pacienteid
                          WHERE h.historiaid=$id");
  $select->execute();
  $row = $select->fetch(PDO::FETCH_ASSOC);

  $id_db = $row['historiaid'];
  $nombrecompleto_db = $row['pnombre'];
  $histfecha_db = $row['fecha'];
  $historia_db = $row['historia'];

  //print_r($row);

  if(isset($_POST['btncupdate'])){
    $histfecha_txt = $_POST['txt_histfecha'];
    $historia_txt = $_POST['txt_historia'];

    $update = $pdo->prepare("UPDATE tbl_historia SET timestamp=:timestamp, historia=:historia
                            WHERE historiaid=$id_db");

    $update->bindParam(':timestamp',$histfecha_txt);
    $update->bindParam(':historia',$historia_txt);

    if($update->execute()){
      echo '<script type="text/javascript">
      jQuery(function validation(){

        swal({
          title: "Historia modificada",
          text: "Historia modificada exitosamente",
          icon: "success",
          button: "Ok",
        });

      })
      </script>';
      header("location:mstories_list.php");
      exit();
    }else{
      echo '<script type="text/javascript">
      jQuery(function validation(){

        swal({
          title: "Error!",
          text: "La historia NO pudo ser modificada",
          icon: "error",
          button: "Ok",
        });

      })
      </script>';
    }

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
            <h1>Modificar Historia</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Modificar Historia</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      
      <div class="card card-info">
        <div class="card-header">
          <h3 class="card-title"><a href="mstories_list.php" class="btn btn-primary" role="button">Lista de Historias</a></h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form role="form" action="" method="POST">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-6 col-md-6 col-lg-6">   <!-- first section 6 columns -->
                <div class="form-group">
                  <label>Nombre del Paciente</label>
                  <input type="text" class="form-control" name="txt_nombre_apellido" value="<?php echo $nombrecompleto_db;?>" required disabled>
                </div>
              </div> <!-- end first section 6 columns -->
              <div class="col-sm-6 col-md-6 col-lg-6">   <!-- second section 6 columns -->
                <div class="form-group">
                  <label>Fecha de la Historia:</label>
                    <input type="datetime-local" class="form-control" data-date-inline-picker="true"  name="txt_histfecha" value="<?php echo $histfecha_db;?>">
                </div>
              </div> <!-- end second section 6 columns -->
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                  <label>Historia</label>
                  <textarea type="text" class="form-control" name="txt_historia" rows="20"><?php echo $historia_db;?></textarea>
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-info" name="btncupdate">Actualizar</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


<?php
  include_once 'footer.php';
?>