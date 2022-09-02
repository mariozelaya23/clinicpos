<?php
  include_once'connectdb.php';
  session_start();

  if($_SESSION['useremail']=="" OR $_SESSION['role']=="Usuario"){  //with this session variable changepassword.php wont open until you login
    header('location:index.php');
    exit();
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
            <h1>Ver Checkin</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Ver Checkin</li>
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
              <?php 
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
                while($row=$select->fetch(PDO::FETCH_OBJ)){
                  echo '
                  <div class="col-sm-6 col-md-6 col-lg-6">   <!-- first section 6 columns -->
                    <div class="form-group">
                      <label>Nombre del Paciente</label>
                      <input type="text" class="form-control" name="txt_nombre_apellido" value="'.$row->pnombre.'" disabled>
                    </div>
                  </div> <!-- end first section 6 columns -->
                  <div class="col-sm-6 col-md-6 col-lg-6">   <!-- second section 6 columns -->
                    <div class="form-group">
                      <label>Fecha del Checkin:</label>
                      <input type="datetime-local" class="form-control" name="txt_fecha" value="'.$row->fecha.'" disabled>
                    </div>
                  </div> <!-- end second section 6 columns -->
                  <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group">
                      <label>Razon</label>
                      <textarea type="text" class="form-control" name="txt_razon" rows="2" disabled>'.$row->razon.'</textarea>
                    </div>
                  </div>
                  <div class="col-sm-6 col-md-6 col-lg-6">   <!-- first section 6 columns -->
                    <div class="form-group">
                      <label>Precion Arterial</label>
                      <input type="text" class="form-control" name="txt_parterial" value="'.$row->parterial.'" disabled>
                    </div>
                    <div class="form-group">
                      <label>Frecuencia Respiratoria</label>
                      <input type="text" class="form-control" name="txt_frec_resp" value="'.$row->frec_res.'" disabled>
                    </div>
                    <div class="form-group">
                    <label>Saturacion O2</label>
                      <input type="text" class="form-control" name="txt_sato2" value="'.$row->sato2.'" disabled>
                    </div>
                    <div class="form-group">
                      <label>Estatura</label>
                      <input type="text" class="form-control" name="txt_estatura" value="'.$row->estatura.'" disabled>
                    </div>
                  </div>
                  <div class="col-sm-6 col-md-6 col-lg-6">   <!-- second section 6 columns -->
                    <div class="form-group">
                      <label>Pulso</label>
                      <input type="text" class="form-control" name="txt_pulso" value="'.$row->pulso.'" disabled>
                    </div>
                    <div class="form-group"> 
                      <label>Temperatura</label>
                      <input type="text" class="form-control" name="txt_temperatura" value="'.$row->temperatura.'" disabled>
                    </div>
                    <div class="form-group">
                      <label>Peso</label>
                      <input type="text" class="form-control" name="txt_peso" value="'.$row->peso.'" disabled>
                    </div>
                    <div class="form-group">
                      <label>IMC</label>
                      <input type="text" class="form-control" name="txt_imc" value="'.$row->IMC.'" disabled>
                    </div>
                  </div> <!-- end second section 6 columns -->
                  <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group">
                      <label>Impresion Diagnostica</label>
                      <textarea type="text" class="form-control" name="txt_diagnostico" rows="6" disabled>'.$row->diagnostico.'</textarea>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group">
                      <label>Plan</label>
                      <textarea type="text" class="form-control" name="txt_plan" rows="6" disabled>'.$row->plan.'</textarea>
                    </div> 
                  </div>

                  ';
                }
              ?>
              <?php
                $id = $_GET['id'];
                $select = $pdo->prepare("SELECT h.historia AS historia
                                        FROM tbl_checkin ch
                                        JOIN tbl_paciente p ON p.pid = ch.pacienteid
                                        JOIN tbl_historia h ON p.pid = h.pacienteid
                                        WHERE ch.checkid=$id");
                $select->execute();
                while($row=$select->fetch(PDO::FETCH_OBJ)){
                  echo '
                    <div class="col-sm-12 col-md-12 col-lg-12">
                      <div class="form-group">
                        <label>Historia</label>
                        <textarea type="text" class="form-control" name="txt_historia" rows="6" disabled>'.$row->historia.'</textarea>
                      </div>
                    </div>
                  ';
                }
              ?>
            </div>
          </div>
        </form>
        <!-- /.card-body -->
      </div>


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


<?php
  include_once 'footer.php';
?>