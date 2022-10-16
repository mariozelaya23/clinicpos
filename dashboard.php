<?php
  include_once'connectdb.php';
  session_start();

  if($_SESSION['useremail']=="" OR $_SESSION['role']=="Usuario"){  //with this session variable dashboard.php wont open until you login
    header('location:index.php');
  }

  if($_SESSION['role']=="Admin"){
    include_once'header.php';
  }else{
    include_once'headeruser.php';
  }

  //fetching total count of patients
  $select_p = $pdo->prepare("SELECT COUNT(pid) AS tp FROM tbl_paciente");
  $select_p->execute();
  $row_p = $select_p->fetch(PDO::FETCH_ASSOC);

  $total_patient = $row_p['tp'];

  //fetching total count of Checkins
  $select_c = $pdo->prepare("SELECT COUNT(checkid) AS tc FROM tbl_checkin");
  $select_c->execute();
  $row_c = $select_c->fetch(PDO::FETCH_ASSOC);

  $total_checkins = $row_c['tc'];

  //fetching total count of Antecedentes
  $select_a = $pdo->prepare("SELECT COUNT(antecedentesid) AS ta FROM tbl_antecedente");
  $select_a->execute();
  $row_a = $select_a->fetch(PDO::FETCH_ASSOC);

  $total_antecedentes = $row_a['ta'];

  //fetching total count of Antecedentes
  $select_f = $pdo->prepare("SELECT COUNT(parchivosid) AS ta FROM tbl_parchivos");
  $select_f->execute();
  $row_f = $select_f->fetch(PDO::FETCH_ASSOC);

  $total_files = $row_f['ta'];



?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Admin Dashboard</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Admin Dashboard</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php echo $total_patient;?></h3>

                <p>Total de Pacientes</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="patientlist.php" class="small-box-footer">Mas información <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?php echo $total_checkins;?></h3>

                <p>Total Checkins</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="checkin_list.php" class="small-box-footer">Mas información <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?php echo $total_antecedentes;?></h3>

                <p>Total de Antecedentes</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="antecedentes_list.php" class="small-box-footer">Mas información <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?php echo $total_files;?></h3>

                <p>Total de Archivos Subidos</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer">Mas información <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
      </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php
  include_once 'footer.php';
?>
