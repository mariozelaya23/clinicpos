<?php
  include_once'connectdb.php';
  session_start();

  if($_SESSION['useremail']=="" OR $_SESSION['role']=="User"){  //with this session variable changepassword.php wont open until you login
    header('location:index.php');
    exit();
  }
 

  // getting the patient id from patient list page as well the data from that page
  $id = $_GET['id'];
  $select = $pdo->prepare("SELECT * FROM tbl_paciente WHERE pid=$id");
  $select->execute();
  $row = $select->fetch(PDO::FETCH_ASSOC);

  $id_db = $row['pid'];
  $pnombre_db = $row['pnombre'];
  $papellido_db = $row['papellido'];

  //print_r($row);

  if(isset($_POST['btnadd_hist'])){
    $histfecha = $_POST['txt_histfecha'];
    $historia = $_POST['txt_historia'];

    $insert = $pdo->prepare("INSERT INTO tbl_historia(historia,timestamp) VALUES(:historia,:timestamp)");

    $insert->bindParam(':timestamp',$histfecha);
    $insert->bindParam(':historia',$historia);

    if($update->execute()){
      echo '<script type="text/javascript">
      jQuery(function validation(){

        swal({
          title: "Historia Agregada",
          text: "Historia Agregada exitosamente",
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
          text: "La historia NO pudo ser Agregada",
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
            <h1>Agregar Historia</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Agregar Historia</li>
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
                  <input type="text" class="form-control" name="txt_nombre_apellido" value="<?php $pnombre_db.' '.$papellido_db;?>" required disabled>
                </div>
              </div> <!-- end first section 6 columns -->
              <div class="col-sm-6 col-md-6 col-lg-6">   <!-- second section 6 columns -->
                <div class="form-group">
                  <label>Fecha de la Historia:</label>
                    <input type="datetime-local" class="form-control" data-date-inline-picker="true"  name="txt_histfecha" value="<?php echo $histfecha;?>">
                </div>
              </div> <!-- end second section 6 columns -->
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                  <label>Historia</label>
                  <textarea type="text" class="form-control" name="txt_historia" rows="20"><?php echo $historia;?></textarea>
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-info" name="btnadd_hist">Agregar</button>
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