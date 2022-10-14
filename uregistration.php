<?php
  include_once'connectdb.php';
  session_start();

  if($_SESSION['useremail']=="" OR $_SESSION['role']=="Usuario"){  //with this session variable changepassword.php wont open until you login
    header('location:index.php');
  }
  if($_SESSION['role']=="Admin"){
    include_once'header.php';
  }else{
    include_once'headeruser.php';
  }

  //DELETE action
  error_reporting(0);
  if($_GET['id']){ //this id comes from the URL
    $id=$_GET['id'];
    $delete = $pdo->prepare("DELETE FROM tbl_user WHERE userid=:id");
    $delete->bindParam(':id', $id);
    if($delete->execute()){
      echo '<script type="text/javascript">
      jQuery(function validation(){
  
        swal({
          title: "Muy Bien!",
          text: "¡EL usuario se ha eliminado exitosamente!",
          icon: "success",
          button: "Ok",
        });
  
      })
      </script>';
    }
  }

  //*********** ADD BUTTON STARTS HERE ***********/
  //1- when click on save button we get out values in the textboxes from user into variables
  if(isset($_POST['btnsave'])){ 
    $username = $_POST['txtname'];
    $useremail = $_POST['txtemail'];
    $password = $_POST['txtpassword'];
    $userrole = $_POST['selectrole'];

    //echo $username.' '.$useremail.' '.$password.' '.$userrole;

    if(empty($username) OR empty($useremail) OR empty($password) OR empty($userrole)){
      $error = '<script type="text/javascript">
      jQuery(function validation(){

        swal({
          title: "Error!",
          text: "¡Debe de llenar todos los campos!",
          icon: "error",
          button: "Ok",
        });

      })
      </script>';
      echo $error;
    }

    if(!isset($error)){
          //this condition will prevent to insert the same email
      if(isset($_POST['txtemail'])){
        $select = $pdo->prepare("SELECT useremail FROM tbl_user WHERE useremail='$useremail'");
        $select->execute();

        if($select->rowCount() > 0){  //if rowcount is greater that 0 that means that the useremail already exist
          echo '<script type="text/javascript">
          jQuery(function validation(){
    
            swal({
              title: "Error!",
              text: "¡El correo ingresado ya existe, favor ingresar otro!",
              icon: "error",
              button: "Ok",
            });
    
          })
          </script>';
        }else{
          //2- using of select query we insert into the database
          $insert = $pdo->prepare("INSERT INTO tbl_user(username,useremail,password,role) VALUES(:name,:email,:pass,:role)");  // insert query

          $insert->bindParam(':name',$username); //passing values from placeholders into the variables
          $insert->bindParam(':email',$useremail);
          $insert->bindParam(':pass',$password);
          $insert->bindParam(':role',$userrole);


          if($insert->execute()){
            echo '<script type="text/javascript">
            jQuery(function validation(){
        
              swal({
                title: "Muy bien",
                text: "EL usuario se a guardado correctamente",
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
                text: "No se pudo registrar el usuario!",
                icon: "error",
                button: "Ok",
              });

            })
            </script>';
          }
        }
      }
    }
  }//***********ADD BUTTON ENDS HERE ***********/


  //*********** UPDATE BUTTON STARTS HERE ***********/
  if(isset($_POST['btnupdate'])){
    $username = $_POST['txtname'];
    $useremail = $_POST['txtemail'];
    $password = $_POST['txtpassword'];
    $userrole = $_POST['selectrole'];
    $userid = $_POST['txtid'];

    if(empty($username) OR empty($useremail) OR empty($password) OR empty($userrole)){
      $errorupdate = '<script type="text/javascript">
      jQuery(function validation(){

        swal({
          title: "Error!",
          text: "¡Debe de llenar todos los campos!",
          icon: "error",
          button: "Ok",
        });

      })
      </script>';
      echo $errorupdate;
    }

    if(!isset($errorupdate)){
      //using of select query we update the database
      $insert = $pdo->prepare("UPDATE tbl_user SET username=:name,useremail=:email,password=:pass,role=:role WHERE userid=".$userid);  // insert query

      $insert->bindParam(':name',$username); //passing values from placeholders into the variables
      $insert->bindParam(':email',$useremail);
      $insert->bindParam(':pass',$password);
      $insert->bindParam(':role',$userrole);


      if($insert->execute()){
        echo '<script type="text/javascript">
        jQuery(function validation(){
    
          swal({
            title: "Muy bien",
            text: "EL usuario se a guardado correctamente",
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
            text: "No se pudo registrar el usuario!",
            icon: "error",
            button: "Ok",
          });

        })
        </script>';
      }
    }       

  }//***********UPDATE BUTTON ENDS HERE ***********/



?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Registro de Usuarios</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Registro de Usuarios</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- general form elements -->
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Formulario para el registro de usuarios</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form role="form" action="" method="POST">
          <div class="card-body">
            <div class="row">
            
            <?php
              if(isset($_POST['btnedit'])){
                $select = $pdo->prepare("SELECT * FROM tbl_user WHERE userid=".$_POST['btnedit']);
                $select->execute();
                if($select){
                  $row = $select->fetch(PDO::FETCH_OBJ);
                  echo '
                    <div class="col-sm-4 col-md-4 col-lg-4">   <!-- first section 4 columns -->
                      <div class="form-group">
                        <label for="exampleInputEmail1">Nombre y Apellido</label>
                        <input type="hidden" class="form-control" value="'.$row->userid.'" placeholder="" name="txtid">
                        <input type="text" class="form-control" value="'.$row->username.'" placeholder="Ingrese nombres y apellidos" name="txtname">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Correo Electrónico</label>
                        <input type="email" class="form-control" value="'.$row->useremail.'" placeholder="Ingrese el correo electrónico" name="txtemail">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">Contraseña</label>
                        <input type="password" class="form-control" value="'.$row->password.'"  placeholder="Ingrese la contraseña" name="txtpassword">
                      </div>
                      <label>Role</label>
                      <div class="form-group">
                        <select class="custom-select form-control-border" name="selectrole">
                          <option selected>'.$row->role.'</option>
                          <option>Usuario</option>
                          <option>Admin</option>
                        </select>
                      </div>
                      <div class="card-footer">
                        <button type="submit" class="btn btn-warning" name="btnupdate">Actualizar</button>
                      </div>
                    </div> <!-- end section 4 columns -->
                  ';
                }
              }else{
                echo '
                  <div class="col-sm-4 col-md-4 col-lg-4">   <!-- first section 4 columns -->
                    <div class="form-group">
                      <label for="exampleInputEmail1">Nombre y Apellido</label>
                      <input type="text" class="form-control" placeholder="Ingrese nombres y apellidos" name="txtname">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Correo Electrónico</label>
                      <input type="email" class="form-control" placeholder="Ingrese el correo electrónico" name="txtemail">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Contraseña</label>
                      <input type="password" class="form-control"  placeholder="Ingrese la contraseña" name="txtpassword">
                    </div>
                    <label>Role</label>
                    <div class="form-group">
                      <select class="custom-select form-control-border" name="selectrole">
                        <option value="" disabled selected>Seleccione un role</option>
                        <option>Usuario</option>
                        <option>Admin</option>
                      </select>
                    </div>
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary" name="btnsave">Guardar</button>
                    </div>
                  </div> <!-- end section 4 columns -->
                ';
              }
            ?>


              <div class="col-sm-8 col-md-8 col-lg-8">  <!-- second section 8 columns  --> 

                <div class="card">  <!-- Users Table starts  -->
                  <div class="card-header">
                    <h3 class="card-title">Usuarios registrados al sistema</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body table-responsive p-0">
                    <table id="tableusuers" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>Nombre</th>
                          <th>Correo</th>
                          <th>Role</th>
                          <th></th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                          $select=$pdo->prepare("SELECT * FROM tbl_user ORDER BY userid");
                          $select->execute();

                          while($row=$select->fetch(PDO::FETCH_OBJ)){  //using while to fetch all the data from the database // using FETCH_OBJ because I'm fetching each fild of the database
                            echo '
                              <tr>
                                <td>'.$row->username.'</td>
                                <td>'.$row->useremail.'</td>
                                <td>'.$row->role.'</td>
                                <td>
                                  <button type="submit" value="'.$row->userid.'" class="btn btn-block btn-success btn-xs" name="btnedit">Editar</button>
                                </td>
                                <td>
                                <a href="uregistration.php?id='.$row->userid.'" class="btn btn-block btn-danger btn-xs" role="button" name="btndelete">Eliminar</a>
                                </td>
                              </tr>
                            ';
                          }
                        ?>
                      </tbody>
                    </table>
                  </div>
                  <!-- /.card-body -->
                </div> <!-- Users Table Ends  -->
                <!-- /.card -->  


              </div> <!-- end section 8 columns  --> 
            </div>  
          
          </div>
          <!-- /.card-body -->
        </form>
      </div>
      <!-- /.card -->


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<!-- Call this single function -->
<script>
  jQuery(document).ready( function ($) {
    $('#tableusuers').DataTable();
  } );
</script>

<?php
  include_once 'footer.php';
?>