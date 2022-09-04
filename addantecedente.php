<?php
  include_once'connectdb.php';
  session_start();

  if($_SESSION['useremail']=="" OR $_SESSION['role']=="Usuario"){  //with this session variable changepassword.php wont open until you login
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

  if(isset($_POST['btnadd_ante'])){
    $antecedentes = $_POST['txt_antecedentes'];

    // $insert = $pdo->prepare("INSERT INTO tbl_historia(historia,pacienteid,timestamp) VALUES(:historia,:pacienteid,:timestamp)");

    $insert = $pdo->prepare("INSERT INTO tbl_antecedente(antecedentes,pacienteid) 
                            SELECT :antecedentes,:pacienteid FROM DUAL
                            WHERE NOT EXISTS (SELECT * FROM tbl_antecedente
                                              WHERE antecedentes = :antecedentes OR pacienteid = :pacienteid LIMIT 1)");

    $insert->bindParam(':pacienteid',$id_db);
    $insert->bindParam(':antecedentes',$antecedentes);

    if($insert->execute()){
      echo '<script type="text/javascript">
      jQuery(function validation(){

        swal({
          title: "Antecedentes Agregados",
          text: "Antecedentes Agregados exitosamente",
          icon: "success",
          button: "Ok",
        });

      })
      </script>';
      header("location:antecedentes_list.php");
      exit();
    }else{
      echo '<script type="text/javascript">
      jQuery(function validation(){

        swal({
          title: "Error!",
          text: "Los Antecedentes NO pudieron ser Agregados",
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
            <h1>Agregar Antecedentes</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Agregar Antecedentes</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      
      <div class="card card-info">
        <div class="card-header">
          <h3 class="card-title"><a href="mstories_list.php" class="btn btn-primary" role="button">Lista de Antecedentes</a></h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form role="form" action="" method="POST">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-6 col-md-6 col-lg-6">   <!-- first section 6 columns -->
                <div class="form-group">
                  <label>Nombre del Paciente</label>
                  <input type="text" class="form-control" name="txt_nombre_apellido" value="<?php echo $pnombre_db.' '.$papellido_db;?>" required disabled>
                </div>
              </div> <!-- end first section 6 columns -->
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                  <label>Antecedentes</label>
                  <textarea type="text" class="form-control" name="txt_antecedentes" rows="20"></textarea>
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-info" name="btnadd_ante">Agregar</button>
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