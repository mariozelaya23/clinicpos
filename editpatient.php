<?php
  include_once'connectdb.php';
  session_start();

  if($_SESSION['useremail']=="" OR $_SESSION['role']=="Usuario"){  //with this session variable changepassword.php wont open until you login
    header('location:index.php');
  }

  // getting the patient id from patient list page as well the data from that page
  $id = $_GET['id'];
  $select = $pdo->prepare("SELECT * FROM tbl_paciente WHERE pid=$id");
  $select->execute();
  $row = $select->fetch(PDO::FETCH_ASSOC);

  $id_db = $row['pid'];
  $pnombe_db = $row['pnombre'];
  $papellido_db = $row['papellido'];
  $pdomicilio_db = $row['pdomicilio'];
  $pemail_db = $row['pemail'];
  $pnumerotel_db = $row['pnumerotel'];
  $pfnac_db = $row['pfnac'];

  //print_r($row);

  if(isset($_POST['btnpupdate'])){
    $pnombe_txt = $_POST['txt_nombre'];
    $papellido_txt = $_POST['txt_apellido'];
    $pdomicilio_txt = $_POST['txt_domicilio'];
    $pemail_txt = $_POST['txt_email'];
    $pnumerotel_txt = $_POST['txt_telefono'];
    $pfnac_txt = $_POST['txt_fnac'];

    $update = $pdo->prepare("UPDATE tbl_paciente SET pnombre=:pnombre,papellido=:papellido,pdomicilio=:pdomicilio,pemail=:pemail,pnumerotel=:pnumerotel,pfnac=:pfnac WHERE pid=$id");

    $update->bindParam(':pnombre',$pnombe_txt);
    $update->bindParam(':papellido',$papellido_txt);
    $update->bindParam(':pdomicilio',$pdomicilio_txt);
    $update->bindParam(':pemail',$pemail_txt);
    $update->bindParam(':pnumerotel',$pnumerotel_txt);
    $update->bindParam(':pfnac',$pfnac_txt);

    if($update->execute()){
      echo '<script type="text/javascript">
      jQuery(function validation(){

        swal({
          title: "Datos actualizados",
          text: "Datos del paciente actualizado exitosamente",
          icon: "success",
          button: "Ok",
        });

      })
      </script>';
      header("location:patientlist.php");
      exit();
    }else{
      echo '<script type="text/javascript">
      jQuery(function validation(){
  
        swal({
          title: "Error!",
          text: "Los datos del paciente NO pudieron ser actualizados",
          icon: "error",
          button: "Ok",
        });
  
      })
      </script>';
    }
  }

  // adding this code here, will show the updated information on the form, this fix the issue when you press the update button (procedural programming)
  $select = $pdo->prepare("SELECT * FROM tbl_paciente WHERE pid=$id");
  $select->execute();
  $row = $select->fetch(PDO::FETCH_ASSOC);

  $id_db = $row['pid'];
  $pnombe_db = $row['pnombre'];
  $papellido_db = $row['papellido'];
  $pdomicilio_db = $row['pdomicilio'];
  $pemail_db = $row['pemail'];
  $pnumerotel_db = $row['pnumerotel'];
  $pfnac_db = $row['pfnac'];

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
            <h1>Agregar Paciente</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Modificar Paciente</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      
      <div class="card card-info">
        <div class="card-header">
          <h3 class="card-title"><a href="patientlist.php" class="btn btn-primary" role="button">Lista de pacientes</a></h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form role="form" action="" method="POST">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-6 col-md-6 col-lg-6">   <!-- first section 6 columns -->
                <div class="form-group">
                  <label for="">Nombre</label>
                  <input type="text" class="form-control" id="nombre" placeholder="Ingrese el nombre" name="txt_nombre" value="<?php echo $pnombe_db;?>" required>
                </div>
                <div class="form-group">
                  <label for="">Apellido</label>
                  <input type="text" class="form-control" id="apellido" placeholder="Ingrese el apellido" name="txt_apellido" value="<?php echo $papellido_db;?>" required>
                </div>
                <div class="form-group">
                  <label for="">Domicilio</label>
                  <textarea type="text" class="form-control" id="domicilio" placeholder="Ingrese el domicilio" name="txt_domicilio" rows="2"><?php echo $pdomicilio_db;?></textarea>
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-info" name="btnpupdate">Actualizar</button>
                </div>
              </div> <!-- end first section 6 columns -->
              <div class="col-sm-6 col-md-6 col-lg-6">   <!-- second section 6 columns -->
                <div class="form-group">
                    <label for="">Correo electrónico</label>
                    <input type="email" class="form-control" id="email"  placeholder="Ingrese el correo electrónico" name="txt_email" value="<?php echo $pemail_db;?>">
                </div>
                <div class="form-group">
                  <label for="">Número de teléfono</label>
                  <input type="tel" class="form-control" id="telefono" pattern="[0-9]{8}" placeholder="8 digitos --------" name="txt_telefono" value="<?php echo $pnumerotel_db;?>" required>
                </div>
                <div class="form-group">
                  <label>Fecha de nacimiento:</label>
                    <input type="date" class="form-control" id="DOB" data-date-inline-picker="true"  name="txt_fnac" value="<?php echo $pfnac_db;?>"/>
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