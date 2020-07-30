<?php

    require ('../../config/server.php');
    $id = $_GET["getid"];

    $cancel = mysqli_query($db, "UPDATE `blog` SET `fav`='1' WHERE `id` = '".$id."'");
    if ($cancel){
        echo ' success';
    }else{
        echo 'Error' . mysqli_error($db);
    }
    unset ($id);
