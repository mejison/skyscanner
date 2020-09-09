<?php

$link = "Book cheap flights with Commercial airlines for your medical travel";

require '../../../../config/server.php';

?>
<!DOCTYPE html>
<html lang="en">
<?php require '../../../../config/vendor/ambulance/ambulance.head.php';?>

<body>
<div class="divWrap request fade" id="app">
        <?php require '../../../../config/vendor/ambulance/ambulance.nav.php';?>
        <div class="container" id="body">
            <router-view></router-view>
        </div>
        <?php require '../../../../config/footer.php';?>
    </div>    
    <script src="/assets/js/form.js"></script>
</body>
</html>