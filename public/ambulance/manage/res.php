<?php
//-----------------------------------------------------------------------------------------------------------------------
require_once '../../../config/server.php';
//-----------------------------------------------------------------------------------------------------------------------
if (empty($_POST['man_email']) || empty($_POST['man_number'])) {
    echo 'Oops! we cannot submit your form; Please fill in all the required fields.';
} else {
    $email = htmlspecialchars(stripslashes(mysqli_real_escape_string($db, $_POST['man_email'])));
    $email = base64_encode($email);

    $booking_num = htmlspecialchars(stripslashes(mysqli_real_escape_string($db, $_POST['man_number'])));
    $booking_id = 'FMA-'.$booking_num;

    $stmt=$db->prepare("SELECT `email`, `booking_id` FROM `pamb` WHERE `email`=? OR `booking_id`=? LIMIT 1");
    $stmt->bind_param('ss', $email, $booking_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows == 0) {
        echo 'You entered an incorrect combination of your email and your booking id.';
    }else{
        $row = $result->fetch_assoc();
        if($email != $row['email']){
            echo "Your email seems to be incorrect!<br> Let's try it again.";
        }elseif ($booking_id != $row['booking_id']) {
            echo 'Your booking id is incorrect! Please try again.';
        }else{
            $_SESSION['eid'] = $email;
            $_SESSION['id'] = $booking_id;
            echo 'Successful!';
        }
    }

}
//-----------------------------------------------------------------------------------------------------------------------
