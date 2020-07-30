<?php

require('../../config/server.php');
   
    $id = stripslashes(($_GET["id"]));
    
    if($id){
        $date = date('Y-m-d H:i:s');

        $pub_add = mysqli_query($db, "UPDATE `blog` SET `published`= '1', `upd_date`='" . $date . "' WHERE `id`='" . $id . "'");
        if ($pub_add) {
            echo 'Published!';
        }
        
    }

