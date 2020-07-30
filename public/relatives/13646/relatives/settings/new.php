<?php

    require ('../../config/server.php');

    $pages = '';
    $description = '';
    $tags = '';

    $set = $db->prepare("INSERT INTO `meta` (`pages`, `description`, `tags`) VALUES (?, ?, ?)");
    $set->bind_param('sss',$pages, $description, $tags);
    if($set->execute()){
        //echo ' success';
        header('location: ./');
        $set->close();
    };
    
