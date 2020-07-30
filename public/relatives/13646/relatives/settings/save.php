<?php

    require ('../../config/server.php');
    if(!empty($_POST['page']) || !empty($_POST['description']) || !empty($_POST['tags'])){
        $id = htmlspecialchars(stripslashes(mysqli_real_escape_string($db, $_POST['id'])));
        $page = base64_encode(htmlspecialchars(stripslashes(mysqli_real_escape_string($db, $_POST['page']))));
        $description = base64_encode(htmlspecialchars(stripslashes(mysqli_real_escape_string($db, $_POST['description']))));
        $tags = base64_encode(htmlspecialchars(stripslashes(mysqli_real_escape_string($db, $_POST['tags']))));

        $set = $db->prepare("UPDATE `meta` SET `pages`=?,`description`=?,`tags`=? WHERE `id` = ?");
        $set->bind_param('sssi', $page, $description, $tags, $id);
        if($set->execute()){
            //echo 'arried';
            header('location: ./');
            $set->close();
        };
    }
    
