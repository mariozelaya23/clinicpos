<?php
  include_once'connectdb.php';
  session_start();

  if($_SESSION['useremail']=="" OR $_SESSION['role']=="Usuario"){  //with this session variable changepassword.php wont open until you login
    header('location:index.php');
    exit();
  }
 

  // getting the checkin id from checkin list page as well the data from that page
  $id = $_GET['id'];
  $select = $pdo->prepare("SELECT ch.checkid AS checkid, CONCAT(p.pnombre,' ',p.papellido) AS pnombre, 
                          ch.fecha AS fecha, ch.parterial AS parterial, ch.peso AS peso, 
                          ch.estatura AS estatura, ch.temperatura AS temperatura, ch.plan AS plan,
                          ch.diagnostico AS diagnostico, ch.IMC AS IMC, ch.razon AS razon, ch.pulso AS pulso,
                          ch.frec_res AS frec_res, ch.sato2 AS sato2
                          FROM tbl_checkin ch
                          INNER JOIN tbl_paciente p ON p.pid = ch.pacienteid
                          WHERE ch.checkid=$id");
  $select->execute();
  $row = $select->fetch(PDO::FETCH_ASSOC);

  $id_db = $row['checkid'];
  $nombrecompleto_db = $row['pnombre'];
  $citafecha_db = $row['fecha'];
  $parterial_db = $row['parterial'];
  $peso_db = $row['peso'];
  $estatura_db = $row['estatura'];
  $temperatura_db = $row['temperatura'];
  $plan_db = $row['plan'];
  $diagnostico_db = $row['diagnostico'];
  $IMC_db = $row['IMC'];
  $razon_db = $row['razon'];
  $pulso_db = $row['pulso'];
  $frec_res_db = $row['frec_res'];
  $sato2_db = $row['sato2'];

  //print_r($row);

  if(isset($_POST['btncupdate'])){
    $citafecha_txt = $_POST['txt_fecha'];
    $parterial_txt = $_POST['txt_parterial'];
    $peso_txt = $_POST['txt_peso'];
    $estatura_txt = $_POST['txt_estatura'];
    $temperatura_txt = $_POST['txt_temperatura'];
    $plan_txt = $_POST['txt_plan'];
    $diagnostico_txt = $_POST['txt_diagnostico'];
    $IMC_txt = $_POST['txt_imc'];
    $razon_txt = $_POST['txt_razon'];
    $pulso_txt = $_POST['txt_pulso'];
    $frec_res_txt = $_POST['txt_frec_resp'];
    $sato2_txt = $_POST['txt_sato2'];

    $update = $pdo->prepare("UPDATE tbl_checkin SET fecha=:fecha, parterial=:parterial, peso=:peso, estatura=:estatura, temperatura=:temperatura, plan=:plan, diagnostico=:diagnostico,
                            IMC=:IMC, razon=:razon, pulso=:pulso, frec_res=:frec_res, sato2=:sato2 WHERE checkid=$id_db");

    $update->bindParam(':fecha',$citafecha_txt);
    $update->bindParam(':parterial',$parterial_txt);
    $update->bindParam(':peso',$peso_txt);
    $update->bindParam(':estatura',$estatura_txt);
    $update->bindParam(':temperatura',$temperatura_txt);
    $update->bindParam(':plan',$plan_txt);
    $update->bindParam(':diagnostico',$diagnostico_txt);
    $update->bindParam(':IMC',$IMC_txt);
    $update->bindParam(':razon',$razon_txt);
    $update->bindParam(':pulso',$pulso_txt);
    $update->bindParam(':frec_res',$frec_res_txt);
    $update->bindParam(':sato2',$sato2_txt);

    if($update->execute()){
      echo '<script type="text/javascript">
      jQuery(function validation(){

        swal({
          title: "Checkin modificado",
          text: "Checkin modificado exitosamente",
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
          text: "El Checkin NO pudo ser modificado",
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
            <h1>Modificar Checkin</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Modificar Checkin</li>
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
                  <input type="text" class="form-control" name="txt_nombre_apellido" value="<?php echo $nombrecompleto_db;?>" required disabled>
                </div>
              </div> <!-- end first section 6 columns -->
              <div class="col-sm-6 col-md-6 col-lg-6">   <!-- second section 6 columns -->
                <div class="form-group">
                  <label>Fecha del Checkin:</label>
                    <input type="datetime-local" class="form-control" data-date-inline-picker="true"  name="txt_fecha" value="<?php echo $citafecha_db;?>">
                </div>
              </div> <!-- end second section 6 columns -->
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-12 col-lg-12"> <!-- 12 columns section-->
                <div class="form-group">
                  <label>Razon</label>
                  <textarea type="text" class="form-control" name="txt_razon" rows="2"><?php echo $razon_db;?></textarea>
                </div>
              </div> <!-- end 12 columns section-->
            </div>
            <div class="row">
              <div class="col-sm-6 col-md-6 col-lg-6"> <!-- 6 columns section-->
                <div class="form-group">
                  <label>Precion Arterial</label>
                  <input type="text" class="form-control" name="txt_parterial" value="<?php echo $parterial_db;?>">
                </div>
                <div class="form-group">
                  <label>Frecuencia Respiratoria</label>
                  <input type="number" class="form-control" name="txt_frec_resp" value="<?php echo $frec_res_db;?>">
                </div>
                <div class="form-group">
                  <label>Saturacion O2</label>
                  <input type="number" class="form-control" name="txt_sato2" value="<?php echo $sato2_db;?>">
                </div>
                <div class="form-group">
                  <label>Estatura (metros)</label>
                  <input type="number" step="0.01" class="form-control" name="txt_estatura" value="<?php echo $estatura_db;?>">
                </div>
              </div> <!-- end 6 columns section-->
              <div class="col-sm-6 col-md-6 col-lg-6"> <!-- 6 columns section-->
                <div class="form-group">
                  <label>Pulso</label>
                  <input type="number" class="form-control" name="txt_pulso" value="<?php echo $pulso_db;?>">
                </div>
                <div class="form-group">
                  <label>Temperatura</label>
                  <input type="number" step="0.01" class="form-control" name="txt_temperatura" value="<?php echo $temperatura_db?>">
                </div>
                <div class="form-group">
                  <label>Peso</label>
                  <input type="number" step="0.01" class="form-control" name="txt_peso" value="<?php echo $peso_db;?>">
                </div>
                <div class="form-group">
                  <label>IMC</label>
                  <input type="number" step="0.1" class="form-control" name="txt_imc" value="<?php echo $IMC_db;?>">
                </div>
              </div> <!-- end 6 columns section-->
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                  <label>Impresion Diagnostica</label>
                  <textarea type="text" class="form-control" name="txt_diagnostico" rows="6"><?php echo $diagnostico_db;?></textarea>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                  <label>Plan</label>
                  <textarea type="text" class="form-control" name="txt_plan" rows="6"><?php echo $plan_db;?></textarea>
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