<?php
    require('../../../config/server.php');
    $link = "Hospital Supplies - Medical market";

    $page = base64_encode("Medical Market");

    $stmt=$db->prepare("SELECT `description`, `tags` FROM `meta` WHERE `pages`=?");
    $stmt->bind_param('s', $page);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows == 0) echo("<script>console.log('PHP: No SEO data found!');</script>");

    while($row = $result->fetch_assoc()) {
        $description =  base64_decode($row['description']);
        $tags =  base64_decode($row['tags']);
    }

    $stmt->close();

?>
<!DOCTYPE html>
<html lang="en">
<?php require('../../../config/head.php'); ?>

<body>
    <script>
        $(document).ready(function() {
            //----------------------------------------------------------------------------------------------------------
            $.getScript("https://maps.googleapis.com/maps/api/js?key=AIzaSyB0SQ9c2F6EnDvzkattgCb0Pf8Bfd3XE2U&libraries=places", function() {
                console.log("Map Script loaded and executed");
                function initialize() {
                    var loc_input = document.getElementById('fac_loc');
                    new google.maps.places.Autocomplete(loc_input);
                }
        
                google.maps.event.addDomListener(window, 'load', initialize);
            });
            //----------------------------------------------------------------------------------------------------------
            $('.carousel').carousel({
                interval: 6000,
                pause: false,
            })
            //----------------------------------------------------------------------------------------------------------
            $("#req_submit").on('submit', function(e) {
                e.preventDefault();
                var data = new FormData("#requestForm");
                $.ajax({
                    url: 'rep.php',
                    type: "POST",
                    data: data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    
                    success: function(response) {
                        if (response.trim() == 'Successful!') {
                            $('#error').removeClass('shower');
                            $('#success').html(
                                'Your request was submitted successfully! We just sent you a confirmation. Please check your email'
                            ).addClass('shower');
                            $('#requestForm')[0].reset();
                            $("img[id*='output']").removeAttr('src');
                            var timeout = setTimeout(reloadDart, 5500);
    
                            function reloadDart() {
                                $('#success').removeClass('shower');
                            }
                        } else {
                            $('#error').html(response).addClass('shower');
                            $('#success').html('');
                            var timeout = setTimeout(reloadDart, 5500);
    
                            function reloadDart() {
                                $('#error').removeClass('shower');
                            }
                        }
                    }
                    
                });
            });
            //----------------------------------------------------------------------------------------------------------
            var max_fields = 10;
            var wrapper = $(".form-group.minor");
            var add_button = $("#add_button");
    
            var x = 1; //initlal text box count
            $(add_button).click(function(e) { //on add input button click
                e.preventDefault();
                if (x < max_fields) { //max input box allowed
                    x++; //text box increment
                    var showNxtId = +x;
                    $(wrapper).append(
                        '<div id="minor-holder"><a href="#" class="remove_field mdi mdi-minus"></a><div class="form-group desc"><div class="product_data"><div class="form-group desc_data"><input id="prod_name" placeholder="Product Name *" name="prod_name[]" type="text" minlength="5" required><input id="prod_quant" placeholder="Product quantity *" name="prod_quant[]" type="number" min="1" required><input id="prod_size" placeholder="Product size *" name="prod_size[]" type="text" list="sizes" required><datalist id="sizes"><option value="Cartons">Cartons</option><option value="Containers">Containers</option><option value="Packets">Packets</option><option value="Pieces">Pieces</option></datalist></div><div class="form-group desc_img"><div id="img"><i class="mdi mdi-plus"><label for="prod_img">Add image</label></i><img id="output' +
                        showNxtId +
                        '"/><input type="file" name="prod_img[]" accept="image/*" onchange="document.getElementById(\'output' +
                        showNxtId +
                        '\').src = window.URL.createObjectURL(this.files[0])" required/></div></div></div></div></div>'
                    ); //add input box
                }
            });
    
            $(wrapper).on("click", ".remove_field", function(e) { //user click on remove text
                e.preventDefault();
                $(this).parent('div').remove();
                x--;
            })
        });
    </script>

    <link rel="stylesheet" href="https://639.firstmedtrade.com/config/assets/css/market.css">
    <div class="divWrap fade">
        <div class="landing">
            <?php require('../../../config/nav.php'); ?>
            <div class="container" id="home">
                <div class="reqSlider carousel slide" id="reqBakCarousel">
                    <div class="carousel-inner">
                        <div class="item active">
                            <div class="fill">
                                <div id="requestBackground">
                                    <div class="req_body">
                                        <p>We have a network of wholesalers and importers of medical consumables and supplies.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="fill">
                                <div id="requestBackground">
                                    <div class="req_body">
                                        <p>Our collaborations extend far with different logistics companies for the safe delivery of your supplies.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="fill">
                                <div id="requestBackground">
                                    <div class="req_body">
                                        <p>Connecting and facilitating the sales and deliveries of your hospital supplies.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a class="left carousel-control" data-target="#reqBakCarousel" data-slide="prev">
                        <span class="mdi mdi-chevron-left"></span>
                    </a>
                    <a class="right carousel-control" data-target="#reqBakCarousel" data-slide="next">
                        <span class="mdi mdi-chevron-right"></span>
                    </a>
                </div>
            </div>
        </div>
        <div class="container" id="body">
            <div id="title" class="pagin">
                <h1 id="pagin"><a href="https://firstmedtrade.com/">Home</a> > <a href="https://market.firstmedtrade.com/">Medical Market</a> > <p>Request a quote</p>
                </h1>
                <i class="mdi mdi-cart"></i>
            </div>
            <section id="notice">
                <div class="notice-holder">
                    <div id="remove"><i class="mdi mdi-close"></i></div>
                    <div class="notice_left">
                        <i class="mdi mdi-alert-outline"></i>
                    </div>
                    <div class="notice_right">
                        <p>Due to the current worldwide pandemic and subsequent lockdown, we are helping Hospitals with the
                            supply of their medical supplies and consumables.<br>Submit a request to our sales department by filling the quote form below.
                            <br>Please note that these requests will take a period of 3 - 14 working days to be processed and
                            your supplies delivered to you.</p>
                    </div>
                </div>
            </section>
            <section id="query">
                <div class="query">
                    <div class="contactform">
                        <h1>Quote Form</h1>
                        <form novalidate id="requestForm" method="POST" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
                            <h2>Please fill the form below and we'll get back to you within 24 hours. Fields marked with
                                * are required</h2>
                            <h3>Contact information <span id="asteriks">*</span></h3>
                            <div class="form-group">
                                <input id="cont_name" placeholder="Your name *" name="cont_name" type="text" minlength="2" maxlength="100" required>
                            </div>
                            <div class="form-group">
                                <input id="cont_email" placeholder="Your email *" name="cont_email" type="email" minlength="5" maxlength="100" required>
                            </div>
                            <div class="form-group">
                                <input id="cont_phone" placeholder="Your phone *" name="cont_phone" type="tel" minlength="5" maxlength="20" required>
                            </div>
                            <div class="form-group">
                                <input id="fac_type" placeholder="Facility type *" name="fac_type" type="text" list="facility" minlength="2" required>
                                <datalist id="facility">
                                    <option value="Covid-19 Testing center">Covid-19 Testing center</option>
                                    <option value="Hospital/Clinic">Hospital/Clinic</option>
                                    <option value="Lab">Lab</option>
                                    <option value="Pharmacy">Pharmacy</option>
                                </datalist>
                            </div>
                            <div class="form-group">
                                <input id="fac_name" placeholder="Facility name *" name="fac_name" type="text" minlength="5" maxlength="100" required>
                            </div>
                            <div class="form-group">
                                <input id="fac_loc" placeholder="Facility location *" name="fac_loc" type="text" minlength="5" maxlength="150" required>
                            </div>
                            <h3>What are you looking for? <span id="asteriks">*</span></h3>
                            <div class="form-group minor">
                                <div id="minor-holder">
                                    <div class="form-group desc">
                                        <div class="product_data">
                                            <div class="form-group desc_data">
                                                <input id="prod_name" placeholder="Product Name *" name="prod_name[]" type="text" minlength="5" required>
                                                <input id="prod_quant" placeholder="Product quantity *" name="prod_quant[]" type="number" min="1" required>
                                                <input id="prod_size" placeholder="Product size *" name="prod_size[]" type="text" list="sizes" minlength="4" required>
                                                <datalist id="sizes">
                                                    <option value="Cartons">Cartons</option>
                                                    <option value="Containers">Containers</option>
                                                    <option value="Packets">Packets</option>
                                                    <option value="Pieces">Pieces</option>
                                                </datalist>
                                            </div>
                                            <div class="form-group desc_img">
                                                <div id="img">
                                                    <i class="mdi mdi-plus"><label for="prod_img">Add image</label></i>
                                                    <img id="output" />
                                                    <input type="file" name="prod_img[]" accept="image/*" onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0])" required />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a href="#" id="add_button">Add more products</a>
                            <div class="form-group">
                                <h3>Expected delivery date <span id="asteriks">*</span></h3>
                                <input id="del_date" placeholder="Delivery date(Expected) *" name="del_date" type="date" min="<?php $today = date("Y-m-d");
                                                                                                                                $fiveDays = date("Y-m-d", strtotime($today . "+19 days"));
                                                                                                                                echo $fiveDays; ?>" required>
                            </div>
                            <div class="form-group error-hold fader" style="border-top: none; padding: 0px;">
                                <p id="error"></p>
                                <p id="success"></p>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="req_submit" id="req_submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
        <?php require('../../../config/footer.php'); ?>
    </div>
</body>

</html>
