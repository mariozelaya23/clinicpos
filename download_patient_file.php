<?php 
    include_once 'connectdb.php';
    session_start();

    if($_SESSION['useremail']=="" OR $_SESSION['role']=="Usuario"){   //this username comes from the variable in index.php, we are restricting the access
        header('location:index.php');
    }

    if($_SESSION['role']=="Admin"){
        include_once'header.php';
    }else{
        include_once'headeruser.php';
    }

    if(isset($_REQUEST['parchivosid']))
    {
        $id=$_REQUEST['parchivosid'];
        $select=$pdo->prepare("SELECT * FROM tbl_parchivos WHERE parchivosid=$id");
        $select->execute();
        $row=$select->fetch(PDO::FETCH_ASSOC);
        $filename=$row['parchivonombre'];
        $parchivosid=$row['parchivosid'];
        header("Content-Disposition: attachment; filename=".$filename);
		header("Content-Type: application/octet-stream;");
		readfile("patientfiles/".$filename);
    }


?>