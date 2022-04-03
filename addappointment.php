<?php
  include_once'connectdb.php';
  session_start();

  if($_SESSION['useremail']=="" OR $_SESSION['role']=="User"){  //with this session variable changepassword.php wont open until you login
    header('location:index.php');
  }

  if($_SESSION['role']=="Admin"){
    include_once'header.php';
  }else{
    include_once'headeruser.php';
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

  if(isset($_POST['btnadd_app'])){
    $citafecha = $_POST['txt_fcita'];
    $citahora = $_POST['txt_hora_cita'];
    $citastatus = $_POST['selectestado'];
    $citaproposito = $_POST['txt_proposito'];

    $insert = $pdo->prepare("INSERT INTO tbl_cita(citafecha,citahora,citastatus,citaproposito,pacienteid)
    VALUES(:citafecha,:citahora,:citastatus,:citaproposito,:pacienteid)");

    $insert->bindParam(':citafecha',$citafecha);
    $insert->bindParam(':citahora',$citahora);
    $insert->bindParam(':citastatus',$citastatus);
    $insert->bindParam(':citaproposito',$citaproposito);
    $insert->bindParam(':pacienteid',$id_db);

    if($insert->execute()){
      echo '<script type="text/javascript">
      jQuery(function validation(){

        swal({
          title: "Cita agreada",
          text: "Cita agreada exitosamente",
          icon: "success",
          button: "Ok",
        });

      })
      </script>';
    }else{
      echo '<script type="text/javascript">
      jQuery(function validation(){

        swal({
          title: "Error!",
          text: "La cita NO pudo ser agregada",
          icon: "error",
          button: "Ok",
        });

      })
      </script>';
    }

  }

  // if(isset($_POST['btnadd'])){
  //   $pnombre = $_POST['txt_nombre'];
  //   $papellido = $_POST['txt_apellido'];
  //   $pdomicilio = $_POST['txt_domicilio'];
  //   $pemail = $_POST['txt_email'];
  //   $pnumerotel = $_POST['txt_telefono'];
  //   $pfnac	 = $_POST['txt_fnac'];

  //   $insert = $pdo->prepare("INSERT INTO tbl_paciente(pnombre,papellido,pdomicilio,pemail,pnumerotel,pfnac) 
  //   VALUES(:pnombre,:papellido,:pdomicilio,:pemail,:pnumerotel,:pfnac)");
    
  //   $insert->bindParam(':pnombre',$pnombre);
  //   $insert->bindParam(':papellido',$papellido);
  //   $insert->bindParam(':pdomicilio',$pdomicilio);
  //   $insert->bindParam(':pemail',$pemail);
  //   $insert->bindParam(':pnumerotel',$pnumerotel);
  //   $insert->bindParam(':pfnac',$pfnac);

  //   if($insert->execute()){
  //     echo '<script type="text/javascript">
  //     jQuery(function validation(){

  //       swal({
  //         title: "Paciente agreado",
  //         text: "Paciente agreado exitosamente",
  //         icon: "success",
  //         button: "Ok",
  //       });

  //     })
  //     </script>';
  //   }else{
  //     echo '<script type="text/javascript">
  //     jQuery(function validation(){

  //       swal({
  //         title: "Error!",
  //         text: "El paciente NO pudo ser agregado",
  //         icon: "error",
  //         button: "Ok",
  //       });

  //     })
  //     </script>';
  //   }
  // }


?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Generar Nueva Cita</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Nueva Cita</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      
      <div class="card card-info">
        <div class="card-header">
          <h3 class="card-title"><a href="patientlist.php" class="btn btn-primary" role="button">Lista de citas</a></h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form role="form" action="" method="POST">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-6 col-md-6 col-lg-6">   <!-- first section 6 columns -->
                <div class="form-group">
                  <label>Nombre del Paciente</label>
                  <input type="text" class="form-control" name="txt_nombre_apellido" value="<?php echo $pnombre_db.' '.$papellido_db;?>" required>
                </div>
                <div class="form-group">
                  <label>Estado de Cita</label>
                  <select class="custom-select form-control-border" name="selectestado">
                    <option selected>No confirmada</option>
                    <option>Confirmada</option>
                    <option>Finalizada</option>
                    <option>Cancelada</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Propósito</label>
                  <textarea type="text" class="form-control" placeholder="Ingrese el Propósito de la cita" name="txt_proposito" rows="2"></textarea>
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-info" name="btnadd_app">Agregar</button>
                </div>
              </div> <!-- end first section 6 columns -->
              <div class="col-sm-6 col-md-6 col-lg-6">   <!-- second section 6 columns -->
                <div class="form-group">
                  <label>Fecha de cita:</label>
                    <input type="date" class="form-control" data-date-inline-picker="true"  name="txt_fcita" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Hora de cita</label>
                  <input type="text" class="form-control" placeholder="Ingrese hora de la cita" name="txt_hora_cita" required>
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