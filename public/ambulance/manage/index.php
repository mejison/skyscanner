<?php

require('../../../config/server.php');
$link = "Manage your booking";

?>
<!DOCTYPE html>
<html lang="en">
<?php require('../../../config/vendor/ambulance/ambulance.head.php'); ?>

<body>
    <div class="divWrap fade">
        <div id="hold"></div>
        <?php require('../../../config/vendor/ambulance/ambulance.nav.php'); ?>
        <section id="query">
                        <div class="query manage">
                <form name="man_form" id="man_form" method="POST" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" enctype="text/plain">
                    <fieldset id="manage">
                        <h3>Manage your Booking</h3>
                        <div class="form-group">
                            <label>
                                <input name="man_email" placeholder="Email" minlength="0" maxlength="50" id="man_email" type="email" required>
                            </label>
                        </div>
                        <div class="form-group minor">
                            <label>
                                <span>FMA-</span>
                                <input name="man_number" placeholder="Booking refernce number" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==6) return false;" id="man_number" type="number" required>
                            </label>
                        </div>
                    </fieldset>
                    <div class="form-group error-hold fader" style="border-top: none; padding: 0px;">
                        <p id="error"></p>
                    </div>
                    <div class="form-group">
                        <button id="man_submit" name="man_submit" type="submit">Submit</button>
                    </div>
                    <div class="form-group">
                        <span>Request a <a href="https://ambulance.firstmedtrade.com/request/p?<?php echo substr(md5(microtime()), 0, 15); ?>&t=<?php echo substr(md5(microtime()), 0, 15); ?>">private</a> quote</span> |
                        <span>Book a <a href="https://ambulance.firstmedtrade.com/request/c?<?php echo substr(md5(microtime()), 0, 15); ?>&t=<?php echo substr(md5(microtime()), 0, 15); ?>">commercial</a> flight</span>
                    </div>
                </form>
            </div>
        </section>
    </div>
    <?php require('../../../config/footer.php'); ?>
    <script>
        $(document).ready(function() {
            //---------------------------------------------------------------------------------------------------------------
            $("#man_submit").on('click', function(e) {
                e.preventDefault();
                $('.divWrap').prepend('<span id="recha">Preparing your results, please wait...</span>');
                let data = $('#man_form').serialize()
                $.ajax({
                    url: 'res.php',
                    type: "POST",
                    data: data,
                    success: function(response) {
                        if (response.trim() == 'Successful!') {
                            $('#recha').remove();
                            $('#error').removeClass('shower');
                            $('#man_form').load('https://ambulance.firstmedtrade.com/manage/results.php');
                        } else {
                            $('#recha').remove();
                            $('#error').html(response).addClass('shower');
                            var timeout = setTimeout(reloadDart, 6500);

                            function reloadDart() {
                                $('#error').removeClass('shower');
                            }
                        }
                    }
                });
            });
            //---------------------------------------------------------------------------------------------------------------
        })
    </script>
</body>

</html>