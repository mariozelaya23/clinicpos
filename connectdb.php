<?php
    try{
        $pdo = new PDO('mysql:host=localhost;dbname=clinic_db','root','');
        echo 'connection successfull';
    }catch(PDOException $f){
        echo $f->getMessage();
    }
    
?>