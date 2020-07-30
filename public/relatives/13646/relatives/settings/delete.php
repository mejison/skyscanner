<?php

    require ('../../config/server.php');
    $id = (INT)$_GET["getid"];

    $ddel = $db->prepare("DELETE FROM `meta` WHERE `id`=?");
    $ddel->bind_param('i', $id);
    if ($ddel->execute()){
        //echo ' success';
        header('location: ./');
        $ddel->close();
    }else{
        echo 'Error';
    }
