<?php
//-----------------------------------------------------------------------------------------------------------------------
require_once('../../../../config/server.php');
//-----------------------------------------------------------------------------------------------------------------------
if (empty($_POST['cont_name']) || empty($_POST['cont_email']) || empty($_POST['cont_phone']) || empty($_POST['from_loc']) || empty($_POST['to_loc']) || empty($_POST['trv_date']) || empty($_POST['esc_check']) || empty($_POST['companion'])|| empty($_POST['gen_check']) || empty($_POST['diagnosis']) ) {
    echo 'Opps! we cannot submit your form; Please fill in all the required fields.';
} else {
    if (isset($_POST['cont_name'], $_POST['cont_email'], $_POST['cont_phone'], $_POST['selfBook'], $_POST['from_loc'], $_POST['to_loc'], $_POST['trv_date'], $_POST['esc_check'], $_POST['companion'], $_POST['gen_check'], $_POST['diagnosis'])) {
        $cont_email = htmlspecialchars(stripslashes(mysqli_real_escape_string($db, $_POST['cont_email'])));
        $cont_emaild = base64_encode($cont_email);

        $status = 'Completed';
        $stmt = $db->prepare("SELECT `email` FROM `pamb` WHERE `status`!=? AND `email`=?");
        $stmt->bind_param('ss', $status, $cont_emaild);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows >= 1) {
            echo "Sorry we cannot continue with your request. Please complete your pending request before booking a new one or contact our support for assistance.";
        }else{
            $cont_name = htmlspecialchars(stripslashes(mysqli_real_escape_string($db, $_POST['cont_name'])));
            $cont_named = base64_encode($cont_name);

            $cont_phone = htmlspecialchars(stripslashes(mysqli_real_escape_string($db, $_POST['cont_phone'])));
            $cont_phoned = base64_encode($cont_phone);

            if (empty($_POST['selfBook'])) {
                $pat_name = htmlspecialchars(stripslashes(mysqli_real_escape_string($db, $_POST['pat_name'])));
                $pat_named = base64_encode($pat_name);
                $pat_rel = htmlspecialchars(stripslashes(mysqli_real_escape_string($db, $_POST['pat_rel'])));
                $pat_reld = base64_encode($pat_rel);
            } else {
                $pat_named = $cont_named;
                $pat_reld = 'Self';
            }

            $from_loc = htmlspecialchars(stripslashes(mysqli_real_escape_string($db, $_POST['from_loc'])));
            $from_loc = base64_encode($from_loc);

            $to_loc = htmlspecialchars(stripslashes(mysqli_real_escape_string($db, $_POST['to_loc'])));
            $to_loc = base64_encode($to_loc);

            if (empty($_POST['from_check'])) {
                $from_check = 'Home';
            } else {
                $from_check = 'Hospital';
            }
            if (empty($_POST['to_check'])) {
                $to_check = 'Home';
            } else {
                $to_check = 'Hospital';
            }
            $journey_type = $from_check . ' to ' . $to_check;

            $trv_date = htmlspecialchars(stripslashes(mysqli_real_escape_string($db, $_POST['trv_date'])));
            
            $esc_check = htmlspecialchars(stripslashes(mysqli_real_escape_string($db, $_POST['esc_check'])));

            if ($_POST['companion'] == 'no') {
                $comp_ad_num = '0';
                $comp_chl_num = '0';
            } else if ($_POST['companion'] == 'yes') {
                $comp_ad_num = htmlspecialchars(stripslashes(mysqli_real_escape_string($db, $_POST['comp_adult_number'])));
                $comp_chl_num = htmlspecialchars(stripslashes(mysqli_real_escape_string($db, $_POST['comp_child_number'])));
            }

            $gen_check = htmlspecialchars(stripslashes(mysqli_real_escape_string($db, $_POST['gen_check'])));

            $diagnosis = htmlspecialchars(stripslashes(mysqli_real_escape_string($db, $_POST['diagnosis'])));
            $diagnosis = base64_encode($diagnosis);

            $gen_check = htmlspecialchars(stripslashes(mysqli_real_escape_string($db, $_POST['gen_check'])));

            $additional = filter_var_array($_POST['additional']);
            $additional = implode(",", $additional);
            
            $status = 'Awaiting confirmation';
            $booking_id = 'FMA-' . substr((mt_rand()), 0, 6);
            $book_date = date('Y-m-d');
            $class = 'Private charter';
            //-------------------------------------------------------------------------------------------------------------
            $directory = 'files/' . date("Y") . '/' . date("m") . '/' . date("D") . '/' . date('Hi') . '/' . $cont_named;
            if (!is_dir($directory)) {
                mkdir("../p/assets/$directory", 755, true);
            }

            $reprt = filter_var_array($_FILES["reprt_up"]["name"]); //get the files
            foreach ($reprt as $i => $name) {
                $name = $_FILES['reprt_up']['name'][$i];
                $size = $_FILES['reprt_up']['size'][$i];
                $tmp = $_FILES['reprt_up']['tmp_name'][$i];

                $explode = explode('.', $name);
                $ext = end($explode);

                $fold = "../p/assets/$directory/$name";

                $allowed = array('jpg', 'pdf', 'jpeg', 'gif', 'bmp', 'png');
                $max_size = 5000000; //5MB

                if (!empty($name)) {
                    if (in_array($ext, $allowed) === false) {
                        echo 'The file extension for <b>' . $name . '</b> is not allowed.<br/>';
                    } else  if ($size > $max_size) {
                        echo 'The file, <b>' . $name . '</b> is too large.<br/>';
                    } else {
                        $uploaded = move_uploaded_file($tmp, $fold); //move the image to the $directory
                        if ($uploaded) {
                            $reprtId = implode(',', $reprt);
                            $reprtDir = base64_encode($directory);                
                        } else {
                            echo 'Not able to upload files';
                        }
                    }
                }
            }
            $set = $db->prepare("INSERT INTO `pamb`(`name`, `email`, `phone`, `location`, `destination`, `travel_type`, `booking_id`, `travel_date`, `medical_escort`, `companion(adult)`, `companion(children)`, `booking_type`, `status`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $set->bind_param("sssssssssiiss", $cont_named, $cont_emaild, $cont_phoned, $from_loc, $to_loc, $journey_type, $booking_id, $trv_date, $esc_check, $comp_ad_num, $comp_chl_num, $class, $status);
            if ($set->execute()) {
                $set->close();
                $add_prod = $db->prepare("INSERT INTO `pamb_data`(`booking_id`, `patient`, `relationship`, `gender`, `diagnosis`, `reports`, `reportsDir`, `additional_services`, `date_booked`) VALUES (?,?,?,?,?,?,?,?,?)");
                $add_prod->bind_param("sssssssss", $booking_id, $pat_named, $pat_reld, $gen_check, $diagnosis, $reprtId, $reprtDir, $additional, $book_date);
                if ($add_prod->execute()) {
                    echo 'Successful!';
                    $add_prod->close();
                } else {
                    echo 'Oops! There was an unusual error. Please try again in a few minutes.';
                }
            }
        }
    }
}
    //-----------------------------------------------------------------------------------------------------------------------
