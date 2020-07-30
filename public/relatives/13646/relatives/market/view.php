<?php

require_once('../../config/server.php');
$user_id = $_GET['getid'];

$reqUsquery = mysqli_query($db, "SELECT * FROM `mart_requests` JOIN `mart_data` WHERE `mart_requests`.`req_id`='" . $user_id . "' AND `mart_data`.`req_id`='" . $user_id . "' ");

if (mysqli_num_rows($reqUsquery) == 1) {
    while ($show_req = mysqli_fetch_assoc($reqUsquery)) {
        $prod_name = explode(",", $show_req['prod_name']);
        $prod_quant = explode(",", $show_req['prod_quant']);
        $prod_size = explode(",", $show_req['prod_size']);
        $prod_img = explode(",", $show_req['prod_img']);

        $total = array($prod_name, $prod_quant, $prod_size, $prod_img);

        function combine($total){
            array_unshift($total, null);
            return call_user_func_array('array_map', $total);
        }
        $total = combine($total);

        echo '
            <div id="mart_data">
                <div id="mart_data_left">
                    <a href="../market/">Back</a>
                    <p id="dat">Request ID: <span>' . $show_req['req_id'] . '</span><br>Request Status: <span>' . $show_req['status'] . '</span></p>
                    <h4>Name: <span>' . base64_decode($show_req['cont_name']) . '</span></h4>
                    <h4>Email: <span>' . base64_decode($show_req['cont_email']) . '</span></h4>
                    <h4>Phone: <span>' . base64_decode($show_req['cont_phone']) . '</span></h4>
                    <h4>Facility: <span>' . base64_decode($show_req['facility_name']) . '</span></h4>
                    <h4>Facility Type: <span>' . base64_decode($show_req['facility_type']) . '</span></h4>
                    <h4>' . base64_decode($show_req['facility_type']) . ' Location: <span>' . base64_decode($show_req['facility_loc']) . '</span></h4>
                    <h4>Date Requested: <span>' . $date = date('d-M-Y', strtotime($show_req['updated'])) . '</span></h4>
                    <h4>Expected Delivery Date: <span>' . $date = date('d-M-Y', strtotime($show_req['del_date'])) . '</span></h4>
                    <br /><table border="1">
                        <tr>
                            <th>Product Name</th>
                            <th>Product Qty</th>
                            <th>Product Size</th>
                            <th>Product Image</th>
                        </tr>            
                        ';
                        foreach ($total as $row) {
                            echo'
                                <tr>
                                    <td><p>'. $row[0] .'</p></td>
                                    <td><p>'. $row[1] .'</p></td>
                                    <td><p>'. $row[2] .'</p></td>
                                    <td><div class="table-image"><img src="https://market.firstmedtrade.com/requests/assets/'. base64_decode($show_req['prod_img_loc']) .'/'. $row[3] .'"></div></td>
                                </tr>
                            ';
                        }
                    '</table>
                </div>
            </div>
        ';
    }
} else {
    echo 'There was an error loading the data.<br>Click <a href="../market/">Here</a> to go back' .mysqli_error($db);
}


?>