<?php

$link = "Book cheap flights with Commercial airlines for your medical travel";

require '../../../../config/server.php';

?>
<!DOCTYPE html>
<html lang="en">
<?php require '../../../../config/vendor/ambulance/ambulance.head.php';?>

<body>
    <script>
        $(document).ready(function() {
            //-----------------------------------------------------------------------------------------------------------------------
            $('input[name="services"]').click(function(){
                var favorite = [];
                $.each($("input[name='services']:checked"), function(){
                    favorite.push($(this).val());
                });
                $('#f_services').html(favorite.join("<br/>"));
            })
            //-----------------------------------------------------------------------------------------------------------------------
            $(function() {
                $('#com-show').click(function() {
                    $('.comdes').css('display','block');
                });
                $('#com-hide').click(function() {
                    $('.comdes').css('display','none');
                });
            });
            //-----------------------------------------------------------------------------------------------------------------------
            $("input[name='deprtdte']").change(function() {
                $("input[name='destndte']").prop('min', ($(this).val()));
            })
        });
    </script>
    <div class="divWrap request fade" id="app">
        <?php require '../../../../config/vendor/ambulance/ambulance.nav.php';?>
        <div class="container" id="body">
            <span id="recha">Loading, please wait...</span>
            <router-view></router-view>
        </div>
        <?php require '../../../../config/footer.php';?>
    </div>    
    <script src="/assets/js/main.js"></script>
</body>
</html>