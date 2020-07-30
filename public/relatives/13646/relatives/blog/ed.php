<?php

    require ('../../config/server.php');

    if(isset($_POST['title'], $_POST['subtitle'], $_POST['author'], $_POST['tags1'], $_POST['tags2'], $_POST['tags3'], $_POST['tags4'], $_POST['tags5']) ){
        $id = htmlspecialchars(stripslashes(mysqli_real_escape_string($db, $_POST['id'])));
        $title = htmlspecialchars(stripslashes(mysqli_real_escape_string($db, $_POST['title'])));
        $titled = base64_encode($title);
        $subtitle = htmlspecialchars(stripslashes(mysqli_real_escape_string($db, $_POST['subtitle'])));
        $subtitled = base64_encode($subtitle);
        $body = htmlspecialchars(stripslashes(mysqli_real_escape_string($db, $_POST['content'])));
        $bodied = base64_encode($body);
        $autho = htmlspecialchars(stripslashes(mysqli_real_escape_string($db, $_POST['author'])));
        $author = base64_encode($autho);
        $tags = array(htmlspecialchars(stripslashes(mysqli_real_escape_string($db, $_POST['tags1']))), htmlspecialchars(stripslashes(mysqli_real_escape_string($db, $_POST['tags2']))), htmlspecialchars(stripslashes(mysqli_real_escape_string($db, $_POST['tags3']))), htmlspecialchars(stripslashes(mysqli_real_escape_string($db, $_POST['tags4']))), htmlspecialchars(stripslashes(mysqli_real_escape_string($db, $_POST['tags5']))), htmlspecialchars(stripslashes(mysqli_real_escape_string($db, $_POST['tags6']))), htmlspecialchars(stripslashes(mysqli_real_escape_string($db, $_POST['tags7']))), htmlspecialchars(stripslashes(mysqli_real_escape_string($db, $_POST['tags8']))), htmlspecialchars(stripslashes(mysqli_real_escape_string($db, $_POST['tags9']))), htmlspecialchars(stripslashes(mysqli_real_escape_string($db, $_POST['tags10']))) );
        $tags = implode(",", $tags);
        $date = date('Y-m-d H:i:s');

        $find = mysqli_query($db, "SELECT `id` FROM `blog` WHERE `id`='".$id."' ");
        if(mysqli_num_rows($find) > 0){
            $getdata = mysqli_fetch_assoc($find);
            //-------------------------------------------------------------------------------------------------------------    
                if(isset($_FILES["ticleImage"]["name"])){
                    $image_name = $_FILES["ticleImage"]["name"];
                    $directory = 'imgs/'.date("Y").'/'.date("m").'/'.date("D").'/'.date('Hi-s');
                    if(!is_dir($directory)){
                        mkdir("../../../../blog/$directory", 755, true);
                    }
                    $fold = "../../../../blog/$directory/"; //move the image to the $directory
                    if(move_uploaded_file($_FILES["ticleImage"]["tmp_name"],"$fold".$image_name)){
                        $img_dir = "https://639.firstmedtrade.com/public/blog/$directory/"; //database directory
                        $dir = base64_encode($img_dir);
                        mysqli_query($db, "UPDATE `blog` SET `img`='" . $image_name . "', `imgloc`='" . $dir . "' WHERE `id`='" . $id . "' ", $resultmode = MYSQLI_STORE_RESULT);
                    }
                }
            //-------------------------------------------------------------------------------------------------------------
            $set = mysqli_query($db, "UPDATE `blog` SET `title`='".$titled."', `subtitle`='".$subtitled."', `body`='".$bodied."', `new`='0', `author`='".$author."', `tags`='".$tags."' 
                                    WHERE `id`='".$id."' ");
            if ($set){
                echo 'updated';
            }else{
                echo 'There was a seious issue!';
            }  
        }
        
    }
?>