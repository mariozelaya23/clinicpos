<?php
  include_once'connectdb.php';
  session_start();

  if($_SESSION['useremail']=="" OR $_SESSION['role']=="User"){  //with this session variable changepassword.php wont open until you login
    header('location:index.php');
    exit();
  }

  // getting the appointment id from appointment list page as well the data from that page
  $id = $_GET['id'];
  $select = $pdo->prepare("SELECT c.citaid AS citaid, CONCAT(p.pnombre, ' ', p.papellido) AS nombrecompleto, c.citafecha AS citafecha, 
                          c.citahora AS citahora, c.citastatus AS citastatus, c.citaproposito AS citaproposito 
                          FROM tbl_cita c
                          INNER JOIN tbl_paciente p
                          ON p.pid = c.pacienteid
                          WHERE citaid=$id");
  $select->execute();
  $row = $select->fetch(PDO::FETCH_ASSOC);

  $id_db = $row['citaid'];
  $nombrecompleto_db = $row['nombrecompleto'];
  $citafecha_db = $row['citafecha'];
  $citahora_db = $row['citahora'];
  $citastatus_db = $row['citastatus'];
  $citaproposito_db = $row['citaproposito'];

  //print_r($row);


  if(isset($_POST['btncupdate'])){
    $nombrecompleto_txt = $_POST['txt_nombre_apellido'];
    $citafecha_txt = $_POST['txt_fcita'];
    $citahora_txt = $_POST['txt_hora_cita'];
    $citastatuso_txt = $_POST['txt_nombre_apellido'];
    
  }else{

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
            <h1>Modificar Cita</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Modificar Cita</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      
      <div class="card card-info">
        <div class="card-header">
          <h3 class="card-title"><a href="appointment_list.php" class="btn btn-primary" role="button">Lista de citas</a></h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form role="form" action="" method="POST">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-6 col-md-6 col-lg-6">   <!-- first section 6 columns -->
                <div class="form-group">
                  <label>Nombre del Paciente</label>
                  <input type="text" class="form-control" name="txt_nombre_apellido" disabled value="<?php echo $nombrecompleto_db;?>" disabled>
                </div>
                <div class="form-group">
                  <label>Estado de Cita</label>
                  <select class="custom-select form-control-border" name="selectestado" >
                    <option selected><?php echo $citastatus_db;?></option>
                    <option>Confirmada</option>
                    <option>Finalizada</option>
                    <option>Cancelada</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Propósito</label>
                  <textarea type="text" class="form-control" name="txt_proposito" rows="3"><?php echo $citaproposito_db;?></textarea>
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-info" name="btncupdate">Actualizar</button>
                </div>

              </div> <!-- end first section 6 columns -->
              <div class="col-sm-6 col-md-6 col-lg-6">   <!-- second section 6 columns -->
                <div class="form-group">
                  <label>Fecha de cita:</label>
                    <input type="date" class="form-control" name="txt_fcita" value="<?php echo $citafecha_db;?>" required>
                </div>
                <div class="form-group">
                  <label>Hora de cita</label>
                  <input type="time" class="form-control" name="txt_hora_cita" value="<?php echo $citahora_db;?>" required>
                </div>
              </div> <!-- end second section 6 columns -->
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