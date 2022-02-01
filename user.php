<?php
  include_once'connectdb.php';
  session_start();

  if($_SESSION['useremail']=="" OR $_SESSION['role']=="Admin"){  //with this session variable dashboard.php wont open until you login, and we dont let the admin login directly to user.php
    header('location:index.php');
  }

  include_once'headeruser.php';
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">User Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">User Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

  </div>
  <!-- /.content-wrapper -->

<?php
  include_once 'footer.php';
?>
