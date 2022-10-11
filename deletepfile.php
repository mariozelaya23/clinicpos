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

    // $id=$_POST['parchivosidd'];  //pidd comes from the ajax code in patientlist.php

    // $sql="DELETE FROM tbl_parchivos WHERE parchivosid=$id";
    // $delete=$pdo->prepare($sql);

    // if($delete->execute()){
        
    // }else{
    //     echo 'Error al eliminar';
    // }

    // $sql2="SELECT * FROM tbl_parchivos WHERE parchivosid=$id";
    // $deletef=$pdo->prepare($sql2);

    // if($deletef->execute())
    // {
    //     $deletef->bindParam(':parchivosid',$parchivosid);
    //     $row=$deletef->fetch(PDO::FETCH_ASSOC);
    //     unlink("patientfiles/".$row['parchivonombre']);
    // }

    // $pfiles_table = $pdo->prepare("SELECT * FROM tbl_parchivos WHERE parchivosid=$id");
    // $pfiles_table->bindParam(':parchivosid',$parchivosid);
    // $pfiles_table->execute();
    // $row=$pfiles_table->fetch(PDO::FETCH_ASSOC);
    // unlink("patientfiles/".$row['parchivonombre']);
    
    if(isset($_POST['parchivosidd']))
    {
        $id=$_POST['parchivosidd'];
        $select=$pdo->prepare("SELECT * FROM tbl_parchivos WHERE parchivosid=$id");
        $select->execute();
        $row=$select->fetch(PDO::FETCH_ASSOC);
        $filename=$row['parchivonombre'];
        $parchivosid=$row['parchivosid'];
        if(unlink("patientfiles/".$filename))
        {
            $sql="DELETE FROM tbl_parchivos WHERE parchivosid=$id";
            $delete=$pdo->prepare($sql);
            $delete->execute();
        }
    }




?>