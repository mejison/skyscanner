<?php

$link = "Overview";

require_once('../config/server.php');


?>
<!DOCTYPE html>
<html lang="en">
<?php require('../config/head.php'); ?>
<body>
    <div class="divWrap fade">
        <?php require('../config/sidebar.php'); ?>
        <section id="ref">
            <navigation id="navigation">
                <?php require('../config/nav.php'); ?>
            </navigation>
            <div class="ref">
                <div class="back"></div>
                <div id="body">
                    <div class="bodyLeft">
                        <div class="bodyLeft_top">
                        </div>
                        <div class="bodyLeft_botm">
                        </div>
                    </div>
                    <div class="bodyRight">
                        <div id="title">
                            <h1></h1><span>
                                <hr></span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>

</html>