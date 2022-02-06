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

  if(isset($_POST['btnsave'])){   //if btnsave is click then we get the values from the user input, and we store the values in the $variables
    $username = $_POST['txtname'];
    $useremail = $_POST['txtemail'];
    $password = $_POST['txtpassword'];
    $userrole = $_POST['selectrole'];

    //echo $username.' '.$useremail.' '.$password.' '.$userrole;

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
              <li class="breadcrumb-item"><a href="#">Home</a></li>
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
              <div class="col-sm-4 col-md-4 col-lg-4">   <!-- first section 4 columns -->
                <div class="form-group">
                  <label for="exampleInputEmail1">Nombre y Apellido</label>
                  <input type="text" class="form-control" placeholder="Ingrese nombres y apellidos" name="txtname" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Correo Electrónico</label>
                  <input type="email" class="form-control" placeholder="Ingrese el correo electrónico" name="txtemail" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Contraseña</label>
                  <input type="password" class="form-control"  placeholder="Ingrese la contraseña" name="txtpassword" required>
                </div>
                <label>Role</label>
                <div class="form-group">
                  <select class="custom-select form-control-border" name="selectrole" required>
                    <option value="" disabled selected>Seleccione un role</option>
                    <option>Usuario</option>
                    <option>Administrador</option>
                  </select>
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary" name="btnsave">Guardar</button>
                </div>
              </div> <!-- end section 4 columns -->

              <div class="col-sm-8 col-md-8 col-lg-8">  <!-- second section 8 columns  --> 
                <table class="table table-striped">
                  <thead> <!-- table heading -->  
                    <tr>
                      <th>#</th>
                      <th>Nombre</th>
                      <th>Correo</th>
                      <th>Contraseña</th>
                      <th>Role</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody> <!-- table body --> 
                    <?php
                      $select=$pdo->prepare("SELECT * FROM tbl_user ORDER BY userid");
                      $select->execute();
                      
                      while($row=$select->fetch(PDO::FETCH_OBJ)){  //using while to fetch all the data from the database // using FETCH_OBJ because I'm fetching each fild of the database
                        echo '
                          <tr>
                          <td>'.$row->userid.'</td>
                          <td>'.$row->username.'</td>
                          <td>'.$row->useremail.'</td>
                          <td>'.$row->password.'</td>
                          <td>'.$row->role.'</td>
                          <td>
                            <a href="registration.php?id='.$row->userid.'" class="btn btn-block btn-danger btn-xs" role="button" name="btndelete">Eliminar</a>
                          </td>
                          </tr>
                        ';
                      }
                    ?>
                  </tbody>
                </table>

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

<?php
  include_once 'footer.php';
?>