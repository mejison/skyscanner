<?php
    if ($_SESSION['adminid']){
        echo'
            <div class="user-options">
                <div class="fillers">
                    <div class="circle" id="big"></div>
                    <div class="circle" id="medium"></div>
                    <div class="circle" id="small"></div>
                    <div class="circle" id="right"></div>
                </div>
                <span class="exiter"><i class="mdi mdi-close"></i></span>
                <ul>
                    <div class="profilePic">
                        <p id="icon"><i class="mdi mdi-account-outline"></i></p>
                    </div>
                </ul>
                <ul>
                    <li>+234 811 933 4926</li>
                    <li>Officialuby@gmail.com</li>
                    <li>Caritas University, Amorji-Nike, Enugu</li>
                    <li>Nigeria</li>
                </ul>
                <ul>
                    <li><span>Total Sales:</span> <h5>1, 200</h5></li>
                    <li><span>Total Referrals:</span> <h5>10, 480</h5></li>
                    <li><span>Number Of Users:</span> <h5>150</h5></li>
                </ul>
                <div class="logout">
                    <a href="https://13646.firstmedtrade.com//logout/"><i class="mdi mdi-power"></i></a>
                </div>
            </div>
        ';
    }

?>