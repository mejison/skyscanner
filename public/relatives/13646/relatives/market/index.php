<?php

$link = "Market";

require('../../config/server.php');

$req_query = mysqli_query($db, "SELECT * FROM `mart_requests` WHERE `state`='1' ORDER BY `updated` DESC LIMIT 5");


?>
<!DOCTYPE html>
<html lang="en">
<?php require('../../config/head.php'); ?>

<body>
    <div class="divWrap fade">
        <link rel="stylesheet" type="text/css" media="screen" href="https://13646c.firstmedtrade.com//config/assets/css/market.css" />
        <?php require('../../config/sidebar.php'); ?>
        <section id="ref">
            <navigation id="navigation">
                <?php require('../../config/nav.php'); ?>
            </navigation>
            <div class="ref mart">
                <div id="body">
                    <div class="bodyData">
                        <div class="wrapper">
                            <div class="row top">
                                <h1>May / 2020</h1>
                            </div>
                            <div class="row middle">
                                <div class="ship">
                                    <div class="ship_top">
                                        <h3>Location</h3>
                                    </div>
                                    <div class="ship_bottom">
                                        <p>24</p>
                                    </div>
                                </div>
                                <div class="ship">
                                    <div class="ship_top">
                                        <h3>Facilities</h3>
                                    </div>
                                    <div class="ship_bottom">
                                        <div class="ship_bottom_mini">
                                            <div class="ship_bottom_miniTop">
                                                <h3>Hospitals / Clinics</h3>
                                            </div>
                                            <div class="ship_bottom_minibottom">
                                                <div class="ship_bottom_miniTop">
                                                    <p>30</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ship_bottom_mini">
                                            <div class="ship_bottom_miniTop">
                                                <h3>Pharmacies</h3>
                                            </div>
                                            <div class="ship_bottom_minibottom">
                                                <div class="ship_bottom_miniTop">
                                                    <p>30</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ship_bottom_mini">
                                            <div class="ship_bottom_miniTop">
                                                <h3>Labs</h3>
                                            </div>
                                            <div class="ship_bottom_minibottom">
                                                <div class="ship_bottom_miniTop">
                                                    <p>30</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ship_bottom_mini">
                                            <div class="ship_bottom_miniTop">
                                                <h3>Co-vid19 Testing centers</h3>
                                            </div>
                                            <div class="ship_bottom_minibottom">
                                                <div class="ship_bottom_miniTop">
                                                    <p>30</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="ship">
                                    <div class="ship_top">
                                        <h3>Net Amount</h3>
                                    </div>
                                    <div class="ship_bottom">
                                        <p>#31000</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row bottom">
                                <p><span>Number of requests:</span>5</p>
                                <p><span>Average Daily requests:</span>10</p>
                                <p><span>Pendng requests:</span>14</p>
                                <p><span>Completed:</span>20</p>
                            </div>
                        </div>
                    </div>
                    <div class="bodyLeft">
                        <div class="warpper">
                            <input class="radio" id="one" name="group" type="radio" checked>
                            <input class="radio" id="two" name="group" type="radio">
                            <input class="radio" id="three" name="group" type="radio">
                            <div class="tabs">
                                <label class="tab" id="one-tab" for="one">New Requests <span id="req_count">(<?php echo mysqli_num_rows($req_query) ?>)</span></label>
                                <label class="tab" id="two-tab" for="two">Ongoing Requests</label>
                                <label class="tab" id="three-tab" for="three">Confirmed Requests</label>
                            </div>
                            <div class="panels">
                                <div class="panel" id="one-panel">
                                    <div>
                                        <table>
                                            <tr>
                                                <th>Name</th>
                                                <th>Facility Type</th>
                                                <th>Facility Name</th>
                                                <th>Request_id</th>
                                                <th>Date requested</th>
                                                <th></th>
                                            </tr>
                                            <?php
                                            if (mysqli_num_rows($req_query) > 0) {
                                                while ($show_req = mysqli_fetch_array($req_query)) {
                                                    echo '                                            
                                                    <tr id="req_body">
                                                        <td><p>' . base64_decode($show_req['cont_name']) . '</p></td>
                                                        <td><p>' . base64_decode($show_req['facility_type']) . '</p></td>
                                                        <td><p>' . base64_decode($show_req['facility_name']) . '</p></td>
                                                        <td><p>' . $show_req['req_id'] . '</p></td>
                                                        <td><p>' . $date = date('d-m-Y', strtotime($show_req['updated'])) . '</p></td>
                                                        <td><a class="view" href="view.php?getid=' . $show_req['req_id'] . '">View</a></td>
                                                    </tr>
                                                ';
                                                }
                                            } else {
                                                echo 'No blog found';
                                            }
                                            ?>
                                        </table>
                                    </div>
                                </div>
                                <div class="panel" id="two-panel">
                                    <div class="panel-title">Take-Away Skills</div>
                                    <p>You will learn many aspects of styling web pages! You’ll be able to set up the correct file structure, edit text and colors, and create attractive layouts. With these skills, you’ll be able to customize the appearance of your web pages to suit your every need!</p>
                                </div>
                                <div class="panel" id="three-panel">
                                    <div class="panel-title">Note on Prerequisites</div>
                                    <p>We recommend that you complete Learn HTML before learning CSS.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>
<script>
    //------------------------------------------------------------------------------------
    $(document).ready(function() {
        $('.view').click(function(e) {
            var link = $(this).attr("href");
            $.ajax({
                url: link,
                type: 'GET',
                success: function(response) {
                    $('.bodyLeft').html(response);
                }
            });
            return false;
        });
    });
    //------------------------------------------------------------------------------------
</script>


</html>