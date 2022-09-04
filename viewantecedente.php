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
            <h1>Ver Antecedentes</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Ver Antecedentes</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      
      <div class="card card-info">
        <div class="card-header">
          <h3 class="card-title"><a href="antecedentes_list.php" class="btn btn-primary" role="button">Lista de Antecedentes</a></h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form role="form" action="" method="POST">
          <div class="card-body">
            <div class="row">
              <?php 
                $id = $_GET['id'];
                $select = $pdo->prepare("SELECT a.antecedentesid AS antecedentesid, CONCAT(p.pnombre,' ',p.papellido) AS pnombre, 
                                        a.timestamp AS fecha, a.antecedentes AS antecedentes
                                        FROM tbl_antecedente a
                                        INNER JOIN tbl_paciente p ON p.pid = a.pacienteid
                                        WHERE a.antecedentesid=$id");
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
                      <label>Fecha Antecedentes:</label>
                      <input type="datetime-local" class="form-control" name="txt_fecha" value="'.$row->fecha.'" disabled>
                    </div>
                  </div> <!-- end second section 6 columns -->
                  <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group">
                      <label>Antecedentes</label>
                      <textarea type="text" class="form-control" name="txt_antecedentes" rows="20" disabled>'.$row->antecedentes.'</textarea>
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