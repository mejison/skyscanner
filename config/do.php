<?php
    //-----------------------------------------------------------------------------------------------------------------------
        require_once('server.php');
    //-----------------------------------------------------------------------------------------------------------------------
        if(empty($_POST['cont_name']) || empty($_POST['cont_email']) || empty($_POST['cont_phone']) || empty($_POST['fac_name']) || empty($_POST['fac_loc']) || empty($_POST['del_date']) || empty($_POST['prod_name']) || empty($_POST['prod_quant']) || empty($_POST['prod_size'])) {
            echo 'Opps! we cannot submit your form; Please fill in all the required fields.';
        }else{
            if(isset($_POST['cont_name'], $_POST['cont_email'], $_POST['cont_phone'], $_POST['fac_name'], $_POST['fac_loc'], $_POST['del_date'], $_POST['prod_name'], $_POST['prod_quant'], $_POST['prod_size'])){
                $cont_name = htmlspecialchars(stripslashes(mysqli_real_escape_string($db, $_POST['cont_name'])));
                $cont_named = base64_encode($cont_name);

                $cont_email = htmlspecialchars(stripslashes(mysqli_real_escape_string($db, $_POST['cont_email'])));
                $cont_emaild = base64_encode($cont_email);

                $cont_phone = htmlspecialchars(stripslashes(mysqli_real_escape_string($db, $_POST['cont_phone'])));
                $cont_phoned = base64_encode($cont_phone);

                $fac_type = htmlspecialchars(stripslashes(mysqli_real_escape_string($db, $_POST['fac_type'])));
                $fac_typed = base64_encode($fac_type);

                $fac_name = htmlspecialchars(stripslashes(mysqli_real_escape_string($db, $_POST['fac_name'])));
                $fac_named = base64_encode($fac_name);

                $fac_loc = htmlspecialchars(stripslashes(mysqli_real_escape_string($db, $_POST['fac_loc'])));
                $fac_locd = base64_encode($fac_loc);

                $del_date = htmlspecialchars(stripslashes(mysqli_real_escape_string($db, $_POST['del_date'])));

                $prod_name = filter_var_array($_POST['prod_name']);
                $prod_named = implode(",", $prod_name);

                $prod_quant = filter_var_array($_POST['prod_quant']);
                $prod_quantd = implode(",", $prod_quant);

                $prod_size = filter_var_array($_POST['prod_size']);
                $prod_sized = implode(",", $prod_size);

                $state = '1';
                $status = 'Awaiting Confirmation';
                $req_id = 'R' . substr((mt_rand()), 0, 5);
                $req_date = date('r');
                //-------------------------------------------------------------------------------------------------------------    
                $directory = 'imgs/'.date("Y").'/'.date("m").'/'.date("D").'/'.date('Hi').'/'.$cont_named ;
                //If the directory doesn't already exists.
                if(!is_dir($directory)){
                    //Create our directory.
                    mkdir("../requests/assets/$directory", 755, true);
                }

                $prod_img = filter_var_array($_FILES["prod_img"]["name"]); //get the images
                foreach($prod_img as $i => $name) {
                    $name = $_FILES['prod_img']['name'][$i];
                    $size = $_FILES['prod_img']['size'][$i];
                    $tmp = $_FILES['prod_img']['tmp_name'][$i];

                    $explode = explode('.', $name);
                    $ext = end($explode);

                    $fold = "../requests/assets/$directory/$name";

                    $allowed = array('jpg','jpeg','gif','bmp','png');
                    $max_size = 2000000; //2MB
                
                    if(!empty($name)){
                        if(in_array($ext, $allowed) === false) {
                            echo 'The file extension for <b>'.$name.'</b> is not allowed.<br/>';
                        }else  if($size > $max_size) {
                            echo 'The image file, <b>'.$name.'</b> is too large.<br/>';
                        }else{
                            $uploaded = move_uploaded_file($tmp, $fold);//move the image to the $directory
                        }
                    }else{
                        echo 'All images are required!';
                    }
                }
                if ($uploaded) {
                    $prod_img_names = implode(',', $prod_img);
                    $prod_imgDir = base64_encode($directory);
                    $set = $db->prepare("INSERT INTO `mart_requests`(`cont_name`, `cont_email`, `cont_phone`, `facility_type`, `facility_name`, `facility_loc`, `req_id`, `req_date`, `state`) VALUES (?,?,?,?,?,?,?,?,?)");
                    $set->bind_param("sssssssss", $cont_named, $cont_emaild, $cont_phoned, $fac_typed, $fac_named, $fac_locd, $req_id, $req_date, $state);
                    if ($set->execute()) {
                        $add_prod = $db->prepare("INSERT INTO `mart_data`(`req_id`, `prod_name`, `prod_quant`, `prod_size`, `prod_img`, `prod_img_loc`, `del_date`, `status`) VALUES (?,?,?,?,?,?,?,?)");
                        $add_prod->bind_param("ssssssss", $req_id, $prod_named, $prod_quantd, $prod_sized, $prod_img_names, $prod_imgDir, $del_date, $status);
                        $set->close();
                        if ($add_prod->execute()) {
                            echo 'Successful!';
                            $add_prod->close();
                        } else {
                            echo 'Oops! There was an unusual error. Please try again in a few minutes.';
                        }
                    }

                } else {
                    echo 'Not able to upload files';
                }
            }
        }
    //-----------------------------------------------------------------------------------------------------------------------
