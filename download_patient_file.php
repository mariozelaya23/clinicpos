<?php
    ob_start();
    include_once 'connectdb.php';
    session_start();

    if($_SESSION['useremail']=="" OR $_SESSION['role']=="Usuario"){   //this username comes from the variable in index.php, we are restricting the access
        header('location:index.php');
    }

    if(isset($_GET['parchivosid']))
    {
        $id=$_GET['parchivosid'];

        // fetch file to download from database
        $select=$pdo->prepare("SELECT * FROM tbl_parchivos WHERE parchivosid=$id");
        $select->execute();
        $row=$select->fetch(PDO::FETCH_ASSOC);

        $filename=$row['parchivonombre'];
        $parchivosid=$row['parchivosid'];
        $filepath = __DIR__."/patientfiles/".$filename;
        $mime = mime_content_type($filepath);
    

        if (is_file($filepath))
        {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($filepath));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filepath));
            readfile($filepath);
            exit;
        }

    }


?>