<?php

require('../../../../config/server.php');
$link = "Book a Private air charter for your medical travels";

?>
<!DOCTYPE html>
<html lang="en">
<?php require('../../../../config/vendor/ambulance/ambulance.head.php'); ?>

<body>
    <script>
        $(document).ready(function() {
            //----------------------------------------------------------------------------------------------------------
            $.getScript("https://maps.googleapis.com/maps/api/js?key=AIzaSyB0SQ9c2F6EnDvzkattgCb0Pf8Bfd3XE2U&libraries=places", function() {
                console.log("Map Script loaded and executed");

                function initialize() {
                    var loc_input = document.getElementsByClassName('loc');
                    for (var i = 0; i < loc_input.length; ++i) {
                        var item = loc_input[i];
                        new google.maps.places.Autocomplete(item);
                    }
                }
                google.maps.event.addDomListener(window, 'load', initialize);
            });
            //----------------------------------------------------------------------------------------------------------
            $("#req_submit").on('click', function(e) {
                e.preventDefault();
                $('.divWrap').prepend('<span id="recha">Preparing your results, please wait...</span>');
                let data = new FormData($('#requestForm')[0]);
                $.ajax({
                    url: 'rep.php',
                    type: "POST",
                    data: data,
                    contentType: false,
                    cache: false,
                    processData: false,

                    success: function(response) {
                        if (response.trim() == 'Successful!') {
                            $('#recha').remove();
                            $('#error').removeClass('shower');
                            $('#success').html(
                                'Your request was submitted successfully! We just sent you a confirmation. Please check your email'
                            ).addClass('shower');
                            $('#requestForm')[0].reset();
                            $("img[id*='output']").removeAttr('src');
                            var timeout = setTimeout(reloadDart, 6500);

                            function reloadDart() {
                                $('#success').removeClass('shower');
                            }
                        } else {
                            $('#recha').remove();
                            $('#error').html(response).addClass('shower');
                            $('#success').html('');
                            var timeout = setTimeout(reloadDart, 6500);

                            function reloadDart() {
                                $('#error').removeClass('shower');
                            }
                        }
                    }

                });
            });
            //----------------------------------------------------------------------------------------------------------
            $('#selfBook').click(function() {
                var serial = '<div class="form-group"><label><input id="pat_name" placeholder="Patient Name *" name="pat_name" type="text" minlength="5" maxlength="50" required></label><label><input id="pat_rel" placeholder="Relationship with patient *" name="pat_rel" type="text" minlength="5" maxlength="50" required></label></div>';
                var man = $("#selfBook:checked").val();
                if (man != null) {
                    $('#yhudda').html('');
                } else {
                    $('#yhudda').html(serial);
                }
            });
            $('input[name="companion"]').click(function() {
                var serial = '<input type="numberber" name="comp_adult_number" placeholder="Enter number of adults not more than five(5)" max="5" required /><input type="number" name="comp_child_number" placeholder="Enter number of children not more than two(2)" max="2" required />';
                var man = $('input[name="companion"]:checked').val();
                if (man != 'yes') {
                    $('.comdes').html('');
                } else {
                    $('.comdes').html(serial);
                }
            });
            //----------------------------------------------------------------------------------------------------------
            var max_fields = 3;
            var wrapper = $(".report");
            var add_button = $("#add_more");

            var x = 1; //initlal text box count
            $(add_button).click(function(e) { //on add input button click
                if (x < max_fields) { //max input box allowed
                    x++; //text box increment
                    var showNxtId = +x;
                    $(wrapper).append(
                        '<div id="report"><span class="remove_field mdi mdi-minus"></span><div><label for="prod_img">Upload Medical report<br>(pdf or image)</label><img id="output' +
                        showNxtId +
                        '"/><input type="file" name="reprt_up[]" capture accept="application/pdf, image/*" onchange="document.getElementById(\'output' +
                        showNxtId +
                        '\').src = window.URL.createObjectURL(this.files[0])"/></div></div>'
                    ); //add input box
                }
                if (x > 2) {
                    $(add_button).css({
                        'opacity': '0'
                    })
                }
            });
            $(wrapper).on("click", ".remove_field", function(e) { //user click on remove text
                $(this).parent('div').remove();
                x--;
                if (x < max_fields) {
                    $(add_button).css({
                        'opacity': '1'
                    })
                }
            })
        });
    </script>
    <div class="divWrap request fade">
        <?php require('../../../../config/vendor/ambulance/ambulance.nav.php'); ?>
        <div>
            <div class="container" id="home">
                <div class="reqSlider carousel slide" id="reqBakCarousel">
                    <div class="carousel-inner">
                        <div class="item active">
                            <div class="fill">
                                <div class="home_bod">
                                    <div class="slider_text">
                                        <h4>Private Charter<br>Quote form</h4>
                                        <p>Please fill the form below and we'll get back to you within 24 hours. Fields marked with * are required.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container" id="body">
            <section id="query">
                <div class="query">
                    <div class="contactform">
                        <form novalidate id="requestForm" method="POST" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
                            <fieldset id="contact">
                                <h3>Contact information</h3>
                                <div class="form-group">
                                    <label>
                                        <input id="cont_name" placeholder="Name *" name="cont_name" type="text" minlength="2" maxlength="100" required>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label>
                                        <input id="cont_email" placeholder="Email *" name="cont_email" type="email" minlength="5" maxlength="100" required>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label>
                                        <input id="cont_phone" placeholder="Phone Number *" name="cont_phone" type="tel" minlength="5" maxlength="20" required>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label id="container">I am booking for myself
                                        <input id="selfBook" name="selfBook" type="checkbox" checked value="self">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div id="yhudda"></div>
                            </fieldset>
                            <fieldset>
                                <h3>Journey Information </h3>
                                <div class="form-group">
                                    <label>From <span id="asteriks">*</span></label>
                                    <input class="loc" placeholder="location *" name="from_loc" type="text" minlength="5" maxlength="200" required>
                                    <div class="form-group">
                                        <label id="container">This is a hospital
                                            <input id="hos_check_from" name="from_check" type="checkbox" value="hospital">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>To *</label>
                                    <input class="loc" placeholder="Destination *" name="to_loc" type="text" minlength="5" maxlength="100" required>
                                    <div class="form-group">
                                        <label id="container">This is a hospital
                                            <input id="hos_check_away" name="to_check" type="checkbox" value="hospital">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Travel date *
                                        <input id="trv_date" placeholder="Travel date *" name="trv_date" type="date" min="<?php $rtoday = date("Y-m-d");
                                                                                                                            echo $rtoday; ?>" required>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label id="quest">Do you need medical escort (flight doctor)? *</label><br>
                                    <label id="container">Yes
                                        <input id="esc_check_yes" name="esc_check" type="radio" value="yes" required>
                                        <span class="checkmark"></span>
                                    </label><br>
                                    <label id="container">No
                                        <input id="esc_check_no" name="esc_check" type="radio" value="no" required>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label id="quest">Travelling with a companion? *</label><br>
                                    <label id="container">Yes
                                        <input id="to_check_yes" name="companion" type="radio" value="yes" required>
                                        <span class="checkmark"></span>
                                    </label><br>
                                    <label id="container">No
                                        <input id="to_check_no" name="companion" type="radio" value="no" required>
                                        <span class="checkmark"></span>
                                    </label>
                                    <div class="comdes">
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <h3>Patient Information</h3>
                                <div class="form-group">
                                    <label id="quest">Gender *</label><br>
                                    <label id="container">Male
                                        <input id="genm_check" name="gen_check" type="radio" value="male" required>
                                        <span class="checkmark"></span>
                                    </label><br>
                                    <label id="container">Female
                                        <input id="genf_check" name="gen_check" type="radio" value="female" required>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label>Diagnosis (Type of casualty) *</label>
                                    <textarea name="diagnosis" placeholder="30 - 200 characters..." minlength="30" maxlength="200" required></textarea>
                                </div>
                                <div class="form-group rpt">
                                    <div class="report">
                                        <div id="report">
                                            <div>
                                                <label for="reprt_up">Upload Medical report<br>(pdf or image)</label>
                                                <img id="output" />
                                                <input type="file" name="reprt_up[]" capture accept="application/pdf, image/*" onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0])" />
                                            </div>
                                        </div>
                                    </div>
                                    <span id="add_more">Add more</span>
                                </div>
                                <div class="form-group" id="additional">
                                    <label id="quest">Additional services needed *</label><br>
                                    <label id="container" class="multiple">Wheelchair
                                        <input type="checkbox" name="additional[]" value="Wheelchair">
                                        <span class="checkmark"></span>
                                    </label>
                                    <label id="container" class="multiple">Ground Ambulance
                                        <input type="checkbox" name="additional[]" value="Ground ambulance">
                                        <span class="checkmark"></span>
                                    </label>
                                    <label id="container" class="multiple">Ventilated
                                        <input type="checkbox" name="additional[]" value="Ventilated">
                                        <span class="checkmark"></span>
                                    </label>
                                    <label id="container" class="multiple">Incubator
                                        <input type="checkbox" name="additional[]" value="Incubator">
                                        <span class="checkmark"></span>
                                    </label>
                                    <label id="container" class="multiple">High-risk Pregnancy
                                        <input type="checkbox" name="additional[]" value="High-risk Pregnancy">
                                        <span class="checkmark"></span>
                                    </label>
                                    <label id="container" class="multiple">Incontinent
                                        <input type="checkbox" name="additional[]" value="Incontinent">
                                        <span class="checkmark"></span>
                                    </label>
                                    <label id="container" class="multiple">
                                        <input type="checkbox" name="additional[]" value="On Oxygen">On Oxygen
                                        <span class="checkmark"></span>
                                    </label>
                                    <label id="container" class="multiple">
                                        <input type="checkbox" name="additional[]" value="Psychiatric Condition">Psychiatric Condition
                                        <span class="checkmark"></span>
                                    </label>
                                    <label id="container" class="multiple">
                                        <input type="checkbox" name="additional[]" value="Terminal Patient">Terminal Patient
                                        <span class="checkmark"></span>
                                    </label>
                                    <label id="container" class="multiple">
                                        <input type="checkbox" name="additional[]" value="Catheterised">Catheterised
                                        <span class="checkmark"></span>
                                    </label>
                                    <label id="container" class="multiple">
                                        <input type="checkbox" name="additional[]" value="External Pacemaker">External Pacemaker
                                        <span class="checkmark"></span>
                                    </label>
                                    <label id="container" class="multiple">
                                        <input type="checkbox" name="additional[]" value="Drainages">Drainages
                                        <span class="checkmark"></span>
                                    </label>
                                    <label id="container" class="multiple">
                                        <input type="checkbox" name="additional[]" value="Infectious disease">Infectious Disease
                                        <span class="checkmark"></span>
                                    </label>
                                    <label id="container" class="multiple">
                                        <input type="checkbox" name="additional[]" value="Traction device">Traction Device
                                        <span class="checkmark"></span>
                                    </label>
                                    <label id="container" class="multiple">
                                        <input type="checkbox" name="additional[]" value="Unconscious">Unconscious
                                        <span class="checkmark"></span>
                                    </label>
                                    <label id="container" class="multiple">
                                        <input type="checkbox" name="additional[]" value="Intubator">Intubator
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            </fieldset>
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
        <?php require('../../../../config/footer.php'); ?>
    </div>
</body>

</html>