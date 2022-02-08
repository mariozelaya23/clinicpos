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

  // when click on update password button we get values from USER into variables
  if(isset($_POST['btn_update'])){
    $oldpassword_txt=$_POST['txt_oldpass'];
    $newpassword_txt=$_POST['txt_newpass'];
    $confpassword_txt=$_POST['txt_confpass'];

    //echo $oldpassword_txt." ".$newpassword_txt." ".$confpassword_txt;

    //using of select query we get database record according to useremail
    $email = $_SESSION['useremail'];
    $select = $pdo->prepare("SELECT * FROM tbl_user WHERE useremail='$email'");
    $select->execute();
    $row = $select->fetch(PDO::FETCH_ASSOC);

    $useremail_db = $row['useremail']; // asigning values from DATABASE
    $password_db = $row['password']; //asigning values from DATABASE

    //compare userinput and database values
    if($oldpassword_txt == $password_db){  //check old password with the actual value in the database
      if($newpassword_txt == $confpassword_txt){  // compare 2 fields password should be the same, if both are the same, it will run the query
        $update = $pdo->prepare("UPDATE tbl_user SET password=:pass WHERE useremail=:email");  //placeholders :pass and :email
        $update->bindParam(':pass',$confpassword_txt); 
        $update->bindParam(':email',$email);

        if($update->execute()){
          //message to show the password has been successfully updated
          echo '<script type="text/javascript">
          jQuery(function validation(){
    
            swal({
              title: "Muy bien!",
              text: "¡Contraseña actualizada correctamente!",
              icon: "success",
              button: "Ok",
            });
    
          })
    
          </script>';
        }else{
          //message: the password has not been updated
          echo '<script type="text/javascript">
          jQuery(function validation(){
    
            swal({
              title: "Error!",
              text: "¡La contraseña no se ha podido actualizar!",
              icon: "error",
              button: "Ok",
            });
    
          })
    
          </script>';
        }
      }else{
        //message: old and new password does not match
        echo '<script type="text/javascript">
          jQuery(function validation(){
    
            swal({
              title: "Ops!",
              text: "¡La nueva contraseña y confirmar contraseña no coinciden!",
              icon: "warning",
              button: "Ok",
            });
    
          })
    
          </script>';
      }
    }else{
      //message if old password is wrong
      echo '<script type="text/javascript">
      jQuery(function validation(){

        swal({
          title: "Error!!",
          text: "¡Contraseña antigua no coincide!",
          icon: "warning",
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
            <h1>Actualizar contraseña</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Actualizar contraseña</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
    
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Formulario para la actualización de contraseña</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="" method="POST">
          <div class="card-body">
            <div class="form-group">
              <label for="exampleInputPassword1">Contraseña antigua</label>
              <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Password" name="txt_oldpass" required>
            </div>
          </div>
          <div class="card-body">
            <div class="form-group">
              <label for="exampleInputPassword1">Nueva contraseña</label>
              <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="txt_newpass" required>
            </div>
          </div>
          <div class="card-body">
            <div class="form-group">
              <label for="exampleInputPassword1">Confirmar contraseña</label>
              <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="txt_confpass" required>
            </div>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <button type="submit" class="btn btn-primary" name="btn_update">Actualizar</button>
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
