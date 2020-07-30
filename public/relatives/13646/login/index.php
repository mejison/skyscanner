<?php

    require ('../config/server.php');

?>
  <!DOCTYPE html>
  <html lang="en">
      <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <meta http-equiv="X-UA-Compatible" content="ie=edge">
          <meta name="author" content="Mite Systems">
          <meta name="description" content="">
          <meta name="format-detection" content="telephone=no">
          <meta name="keywords" content="">

          <link rel="icon" href="https://639.firstmedtrade.com/public/13646/config/assets/images/logo-mini.png"/>
          <title>System Log</title>

            <link rel="stylesheet" type="text/css" media="screen" href="https://639.firstmedtrade.com/public/13646/config/assets/css/admin.css" />
            <link rel="stylesheet" type="text/css" media="screen" href="https://639.firstmedtrade.com/public/13646/config/assets/css/materialdesignicons.min.css" />
            <link rel="stylesheet" href="//cdn.materialdesignicons.com/5.1.45/css/materialdesignicons.min.css">
      </head>
      <body>
          <div class="divWrap fade">
              <div class="form login">
                  <form method="POST" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" name="login-form" id="login-form">
                      <div class="form-content">
                          <div class="form-group header">
                              <h1>Hi!</h1>
                              <p>Please enter your login details below...</p>
                          </div>
                          <div class="form-group">
                              <label for="adminuser"></label>
                              <input required type="text" id="adminuser" name="adminuser" placeholder="Enter Admin ID" size="10" minlength="5" maxlength="10" >
                            </div>
                            <div class="form-group">
                                <label for="adminpassword"></label>
                                <input required type="password" name="adminpassword" placeholder="Enter Passcode" size="20" minlength="8" maxlength="20">
                            </div>
                            <div class="form-group error-hold fader" style="border-top: none; padding: 0px;">
                              <div class="error">
                                  <p id="error"></p>
                                  <p id="success"></p>
                              </div>
                            </div>
                            <div class="form-group">
                                <h3>Sign In</h3>
                              <button type="submit" name="login" id="log-button"><i class="mdi mdi-arrow-right"></i></button>
                          </div>
                          <div class="form-group forget">
                              <a href="#">Forgot Password</a>
                          </div>
                      </div>
                  </form>
              </div>
          </div>
      </body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://639.firstmedtrade.com/public/13646/config/assets/js/jquery-3.2.1.min.js"></script>
    <script src="https://639.firstmedtrade.com/public/13646/config/assets/js/landing.js"></script>
    <script>
        $(document).ready(function(){
            $("#login-form").on('submit', function(e){
                e.preventDefault();
                var data = $('#login-form').serialize();
                $.ajax({
                    url: '../config/server.php',
                    type: 'POST',
                    data: data,
                    success: function(response){
                        if(response=='Login Successful!'){
                            $('#error').html('');
                            $('#success').html("Successful! Logging you in...");
                            setTimeout('window.location.href = "../"', 2500);
                        }else{
                            $('#error').html(response);
                        }
                    }

                });
            });
        });
    </script>
  </html>
