<?php
  include_once'connectdb.php';
  session_start();

  if($_SESSION['useremail']=="" OR $_SESSION['role']=="User"){  //with this session variable changepassword.php wont open until you login
    header('location:index.php');
  }

  try {
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }catch (PDOException $e){
    echo $e->getMessage();
  }

  if(isset($_POST['btnadd'])){
    $pnombre = $_POST['txt_nombre'];
    $papellido = $_POST['txt_apellido'];
    $pdomicilio = $_POST['txt_domicilio'];
    $pemail = $_POST['txt_email'];
    $pnumerotel = $_POST['txt_telefono'];
    $pfnac	 = $_POST['txt_fnac'];
    
    try {
      $insert = $pdo->prepare("INSERT INTO tbl_paciente(pnombre,papellido,pdomicilio,pemail,pnumerotel,pfnac) 
      VALUES(:pnombre,:papellido,:pdomicilio,:pemail,:pnumerotel,:pfnac)");

      $insert->bindParam(':pnombre',$pnombre);
      $insert->bindParam(':papellido',$papellido);
      $insert->bindParam(':pdomicilio',$pdomicilio);
      $insert->bindParam(':pemail',$pemail);
      $insert->bindParam(':pnumerotel',$pnumerotel);
      $insert->bindParam(':pfnac',$pfnac);

      if($insert->execute()){
        echo '<script type="text/javascript">
        jQuery(function validation(){
  
          swal({
            title: "Paciente agreado",
            text: "Paciente agreado exitosamente",
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
            text: "El paciente NO pudo ser agregado",
            icon: "error",
            button: "Ok",
          });
  
        })
        </script>';
      }
    }catch (PDOException $e) {
      if($e->getCode() == 23000){
        //echo "Numero de Telefono y Fecha de Nacimiento ya existen.  Intente colocar diferentes datos";
        echo '<script type="text/javascript">
        jQuery(function validation(){
  
          swal({
            title: "Error!",
            text: "Telefono y Fecha de Nacimiento ya existen.  Intente colocar diferentes datos",
            icon: "error",
            button: "Ok",
          });
  
        })
        </script>';
      } else{
        echo $e->getMessage();
      }
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
            <h1>Agregar Paciente</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Agregar Paciente</li>
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
                  <input type="text" class="form-control" id="nombre" placeholder="Ingrese el nombre" name="txt_nombre" required>
                </div>
                <div class="form-group">
                  <label for="">Apellido</label>
                  <input type="text" class="form-control" id="apellido" placeholder="Ingrese el apellido" name="txt_apellido" required>
                </div>
                <div class="form-group">
                  <label for="">Domicilio</label>
                  <textarea type="text" class="form-control" id="domicilio" placeholder="Ingrese el domicilio" name="txt_domicilio" rows="2"></textarea>
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-info" name="btnadd">Agregar</button>
                </div>
              </div> <!-- end first section 6 columns -->
              <div class="col-sm-6 col-md-6 col-lg-6">   <!-- second section 6 columns -->
                <div class="form-group">
                    <label for="">Correo electrónico</label>
                    <input type="email" class="form-control" id="email" placeholder="Ingrese el correo electrónico" name="txt_email">
                </div>
                <div class="form-group">
                  <label for="">Número de teléfono</label>
                  <input type="tel" class="form-control" id="telefono" pattern="[0-9]{8}" placeholder="8 digitos --------" name="txt_telefono" required>
                </div>
                <div class="form-group">
                  <label>Fecha de nacimiento:</label>
                    <input type="date" class="form-control" id="DOB" data-date-inline-picker="true"  name="txt_fnac" />
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