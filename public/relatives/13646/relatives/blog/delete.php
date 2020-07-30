<?php

    require ('../../config/server.php');
    $id = (INT)$_GET["getid"];

    $cancel = mysqli_query($db, "DELETE FROM `blog` WHERE `id` = '".$id."'");
    if ($cancel){
        echo ' success';
    }else{
        echo 'Error';
    }
    unset ($id);
