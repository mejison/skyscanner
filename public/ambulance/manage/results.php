<?php
//-----------------------------------------------------------------------------------------------------------------------
require_once '../../../config/server.php';
//-----------------------------------------------------------------------------------------------------------------------
if (!isset($_SESSION['eid'])){
    header('location:./');
}else{
    $email = $_SESSION['eid'];
    $booking_id = $_SESSION['id'];

    $stmt = $db->prepare("SELECT * FROM `pamb` JOIN `pamb_data` WHERE `pamb_data`.`booking_id`=? AND `pamb`.`booking_id`=? LIMIT 1");
    $stmt->bind_param('ss', $booking_id, $booking_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 0) {
        echo 'No data was found!';
    } else {
        $row = $result->fetch_assoc();
        echo '
            <table>
                <a href="./over.php" class="mdi mdi-close"></a>
                <tr>
                    <td><label>Name:</label></td>
                    <td>'.base64_decode($row['name']).'</td>
                </tr>
                <tr>
                    <td><label>Email:</label></td>
                    <td>'.base64_decode($email).'</td>
                </tr>
                <tr>
                    <td><label>Relationship with patient:</label></td>
                    <td>'.$row['relationship'].'</td>
                </tr>
                <tr>
                    <td><label>Booking Id:</label></td>
                    <td>'.$booking_id.'</td>
                </tr>
                <tr>
                    <td><label>Booking Type:</label></td>
                    <td>'.$row['booking_type'].'</td>
                </tr>
                <tr>
                    <td><label>Travel type:</label></td>
                    <td>'.$row['travel_type'].'</td>
                </tr>
                <tr>
                    <td><label>Travel date:</label></td>
                    <td><i>Please check your email for your travel date.</i></td>
                </tr>
                <tr>
                    <td><label>Additional services:</label></td>
                    <td>- '.str_replace(',',"<br/>- ",$row['additional_services']).'</td>
                </tr>
                <tr>
                    <td><label>Status:</label></td>
                    <td>'.$row['status'].'</td>
                </tr>
            </table>
        ';
    }
    $stmt->close();
}
