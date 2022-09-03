<?php
  include_once'connectdb.php';
  session_start();

  if($_SESSION['useremail']=="" OR $_SESSION['role']=="Usuario"){  //with this session variable changepassword.php wont open until you login
    header('location:index.php');
    exit();
  }

  // if($_SESSION['role']=="Admin"){
  //   include_once'header.php';
  // }else{
  //   include_once'headeruser.php';
  // }

  // getting the patient id from patient list page as well the data from that page
  $id = $_GET['id'];
  $select = $pdo->prepare("SELECT * FROM tbl_paciente WHERE pid=$id");

  $select->execute();
  $row = $select->fetch(PDO::FETCH_ASSOC);

  $id_db = $row['pid'];
  $pnombre_db = $row['pnombre'];
  $papellido_db = $row['papellido'];


  $select = $pdo->prepare("SELECT historia FROM tbl_historia WHERE pacienteid=$id");
  $select->execute();


  $row = $select->fetch(PDO::FETCH_ASSOC);
  if(empty($row)){
    $historia_db = '';
  } else {
    $historia_db = $row['historia'];
  }
  

  //print_r($row);

  if(isset($_POST['btnadd_app'])){
    $fecha = $_POST['txt_fecha'];
    $razon = $_POST['txt_razon'];
    $historia = $_POST['txt_historia'];
    $parterial = $_POST['txt_parterial'];
    $pulso = $_POST['txt_pulso'];
    $frec_res = $_POST['txt_frec_resp'];
    $peso = $_POST['txt_peso'];
    $estatura = $_POST['txt_estatura'];
    $sato2 = $_POST['txt_sato2'];
    $temperatura = $_POST['txt_temperatura'];
    $plan = $_POST['txt_plan'];
    $exploracion = $_POST['txt_exploracion'];
    $diagnostico = $_POST['txt_diagnostico'];
    $IMC = $_POST['txt_imc'];

    $insert = $pdo->prepare("INSERT INTO tbl_checkin(fecha,razon,parterial,peso,estatura,temperatura,plan,diagnostico,
    IMC,pacienteid,pulso,frec_res,sato2,historia,exploracion) VALUES(:fecha,:razon,:parterial,:peso,:estatura,:temperatura,:plan,:diagnostico,
    :IMC,:pacienteid,:pulso,:frec_res,:sato2,:historia,:exploracion)");

    $insert->bindParam(':fecha',$fecha);
    $insert->bindParam(':razon',$razon);
    $insert->bindParam(':parterial',$parterial);
    $insert->bindParam(':peso',$peso);
    $insert->bindParam(':estatura',$estatura);
    $insert->bindParam(':temperatura',$temperatura);
    $insert->bindParam(':plan',$plan);
    $insert->bindParam(':diagnostico',$diagnostico);
    $insert->bindParam(':IMC',$IMC);
    $insert->bindParam(':pacienteid',$id_db);
    $insert->bindParam(':pulso',$pulso);
    $insert->bindParam(':frec_res',$frec_res);
    $insert->bindParam(':sato2',$sato2);
    $insert->bindParam(':historia',$historia);
    $insert->bindParam(':exploracion',$exploracion);

    if($insert->execute()){
      echo '<script type="text/javascript">
      jQuery(function validation(){

        swal({
          title: "Checkin agreado",
          text: "Checkin agreado exitosamente",
          icon: "success",
          button: "Ok",
        });

      })
      </script>';
      header("location:checkin_list.php");
      exit();
    }else{
      echo '<script type="text/javascript">
      jQuery(function validation(){

        swal({
          title: "Error!",
          text: "El Checkin NO pudo ser agregado",
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
            <h1>Generar Checkin</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Nuevo Checkin</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      
      <div class="card card-info">
        <div class="card-header">
          <h3 class="card-title"><a href="checkin_list.php" class="btn btn-primary" role="button">Lista de Checkins</a></h3>
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
              <div class="col-sm-6 col-md-6 col-lg-6">   <!-- second section 6 columns -->
                <div class="form-group">
                  <label>Fecha del Checkin:</label>
                    <input type="datetime-local" class="form-control" data-date-inline-picker="true"  name="txt_fecha" required>
                </div>
              </div> <!-- end second section 6 columns -->
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-12 col-lg-12"> <!-- 12 columns section-->
                <div class="form-group">
                  <label>Razón</label>
                  <textarea type="text" class="form-control" name="txt_razon" rows="2"></textarea>
                </div>
              </div> <!-- end 12 columns section-->
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-12 col-lg-12"> <!-- 12 columns section-->
                <div class="form-group">
                  <label>Historia</label>
                  <textarea type="text" class="form-control" name="txt_historia" rows="3"></textarea>
                </div>
              </div> <!-- end 12 columns section-->
            </div>
            <div class="row">
              <div class="col-sm-6 col-md-6 col-lg-6"> <!-- 6 columns section-->
                <div class="form-group">
                  <label>Presión Arterial</label>
                  <input type="text" class="form-control" name="txt_parterial">
                </div>
                <div class="form-group">
                  <label>Frecuencia Respiratoria</label>
                  <input type="number" class="form-control" name="txt_frec_resp">
                </div>
                <div class="form-group">
                  <label>Saturación O2</label>
                  <input type="number" class="form-control" name="txt_sato2">
                </div>
                <div class="form-group">
                  <label>Estatura (metros)</label>
                  <input type="number" step="0.01" class="form-control" name="txt_estatura">
                </div>
              </div> <!-- end 6 columns section-->
              <div class="col-sm-6 col-md-6 col-lg-6"> <!-- 6 columns section-->
                <div class="form-group">
                  <label>Pulso</label>
                  <input type="number" class="form-control" name="txt_pulso">
                </div>
                <div class="form-group">
                  <label>Temperatura</label>
                  <input type="number" step="0.01" class="form-control" name="txt_temperatura">
                </div>
                <div class="form-group">
                  <label>Peso</label>
                  <input type="number" step="0.01" class="form-control" name="txt_peso">
                </div>
                <div class="form-group">
                  <label>IMC</label>
                  <input type="number" step="0.1" class="form-control" name="txt_imc">
                </div>
              </div> <!-- end 6 columns section-->
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                  <label>Exploración</label>
                  <textarea type="text" class="form-control" name="txt_exploracion" rows="4"></textarea>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                  <label>Impresión Diagnostica</label>
                  <textarea type="text" class="form-control" name="txt_diagnostico" rows="6"></textarea>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                  <label>Plan</label>
                  <textarea type="text" class="form-control" name="txt_plan" rows="6"></textarea>
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-info" name="btnadd_app">Agregar</button>
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