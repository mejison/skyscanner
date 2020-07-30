<?php

require('../../config/server.php');
$link = "Medical Air Transport";

?>
<!DOCTYPE html>
<html lang="en">
<?php require('../../config/vendor/ambulance/ambulance.head.php'); ?>

<body>
    <div class="divWrap fade">
        <?php require('../../config/vendor/ambulance/ambulance.nav.php'); ?>
        <div class="container" id="home">
            <div class="airTranSlider carousel slide" id="airTranCarousel">
                <div class="carousel-inner">
                    <div class="item active">
                        <div class="fill">
                        </div>
                    </div>
                    <div class="item">
                        <div class="fill">
                        </div>
                    </div>
                </div>
            </div>
            <div class="home_bod">
                <div class="slider_text">
                    <h4>First <span id="emp">Med</span> <span id="rek">Ambulance</span></h4>
                    <p>Get affordable air and land ambulance for your medical travels.</p>
                    <div class="slider_butt">
                        <a href="/request/p?<?php echo substr(md5(microtime()), 0, 20); ?>">Private air charter</a>
                        <a href="/request/c?<?php echo substr(md5(microtime()), 0, 20); ?>">Commercial air ambulance</a>
                        <a href="/request/g?<?php echo substr(md5(microtime()), 0, 20); ?>">Ground ambulance</a>
                    </div>
                </div>
            </div>
            <span id="more"><i class="mdi mdi-chevron-double-down"></i></span>
        </div>
        <div class="container" id="body">
            <section id="workings">
                <div class="workings_header">
                    <div id="title">
                        <h1>Our Services</h1>
                    </div>
                </div>
                <div class="workings_body">
                    <div class="workings_row">
                        <div class="working">
                            <div class="working-inner">
                                <div class="flip-front">
                                    <div class="working_img">
                                        <i class="mdi mdi-human-wheelchair"></i>
                                    </div>
                                    <h3>Medical Escorts</h3>
                                </div>
                                <div class="flip-back">
                                    <p>Our ACLS and BLS certified medical doctors are available to escort critical patients during medical evaluation.</p>
                                </div>
                            </div>
                        </div>
                        <div class="working">
                            <div class="working-inner">
                                <div class="flip-front">
                                    <div class="working_img">
                                        <i class="mdi mdi-airplane-takeoff"></i>
                                    </div>
                                    <h3>Medical Evacuation</h3>
                                </div>
                                <div class="flip-back">
                                    <h1>John Doe</h1>
                                    <p>Architect & Engineer</p>
                                    <p>We love that guy</p>
                                </div>
                            </div>
                        </div>
                        <div class="working">
                            <div class="working-inner">
                                <div class="flip-front">
                                    <div class="working_img">
                                        <i class="mdi mdi-bed-outline"></i>
                                    </div>
                                    <h3>ETU/Stretcher Services</h3>
                                </div>
                                <div class="flip-back">
                                    <h1>John Doe</h1>
                                    <p>Architect & Engineer</p>
                                    <p>We love that guy</p>
                                </div>
                            </div>
                        </div>
                        <div class="working">
                            <div class="working-inner">
                                <div class="flip-front">
                                    <div class="working_img">
                                        <i class="mdi mdi-ambulance"></i>
                                    </div>
                                    <h3>Ground Ambulance</h3>
                                </div>
                                <div class="flip-back">
                                    <h1>John Doe</h1>
                                    <p>Architect & Engineer</p>
                                    <p>We love that guy</p>
                                </div>
                            </div>
                        </div>
                        <div class="working">
                            <div class="working-inner">
                                <div class="flip-front">
                                    <div class="working_img">
                                        <i class="mdi mdi-alarm-light-outline"></i>
                                    </div>
                                    <h3>Emergency</h3>
                                </div>
                                <div class="flip-back">
                                    <h1>John Doe</h1>
                                    <p>Architect & Engineer</p>
                                    <p>We love that guy</p>
                                </div>
                            </div>
                        </div>
                        <div class="working">
                            <div class="working-inner">
                                <div class="flip-front">
                                    <div class="working_img">
                                        <i class="mdi mdi-face-agent"></i>
                                    </div>
                                    <h3>Dedicated Case Manager</h3>
                                </div>
                                <div class="flip-back">
                                    <h1>John Doe</h1>
                                    <p>Architect & Engineer</p>
                                    <p>We love that guy</p>
                                </div>
                            </div>
                        </div>
                        <div class="working">
                            <div class="working-inner">
                                <div class="flip-front">
                                    <div class="working_img">
                                        <i class="mdi mdi-bed"></i>
                                    </div>
                                    <h3>Bed to Bed Service</h3>
                                </div>
                                <div class="flip-back">
                                    <h1>John Doe</h1>
                                    <p>Architect & Engineer</p>
                                    <p>We love that guy</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <div class="ground_bod">
                <div class="groundlef">
                    <a href="https://ambulance.firstmedtrade.com/request/g?<?php echo substr(md5(microtime()), 0, 15); ?>&t=<?php echo substr(md5(microtime()), 0, 15); ?>">Ground<br>Ambulance? <span>Request here...</span></a>
                </div>
            </div>
            <!-- <section class="adv">
                <div id="calc" class="big"></div>
                <div id="calc" class="big"></div>
                <div class="adv_holder">
                    <div id="calc" class="small"></div>
                    <div id="calc" class="small"></div>
                    <div id="calc" class="small"></div>
                </div>
            </section> -->
            <section id="why">
                <div class="why b">
                    <div class="i-holder">
                        <div id="title">
                            <h1>Why Choose Us?</h1>
                            <p>With partners in Africa, Europe, Middle East & Asia, North & South America, we provide you with a cutting-edge platform for your medical travel needs.</p>
                        </div>
                        <div class="inx">
                            <div id="face">
                                <h3>The Power of Choice</h3>
                                <p>With our air ambulance services, you have the power to choose between commercial
                                    and private ambulance according to your budget and preference.</p>
                            </div>
                            <div id="face">
                                <h3>Compare Price Quotes</h3>
                                <p>Get quotes and compare prices from multiple air ambulance operators.</p>
                            </div>
                            <div id="face">
                                <h3>Flight Doctors</h3>
                                <p>Our ACLS and BLS certified medical doctors are available to escort critical
                                    patients during medical evaluation.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section id="about">
                <div id="traped">
                    <div class="success">
                        <div class="success_mini">
                            <h3>2+</h3>
                            <h5>Evacuations</h5>
                        </div>
                        <div class="success_mini">
                            <h3>5+</h3>
                            <h5>Patients Treated</h5>
                        </div>
                    </div>
                    <div class="success">
                        <div class="success_mini">
                            <h3>3+</h3>
                            <h5>Nurses and other Staff</h5>
                        </div>
                        <div class="success_mini">
                            <h3>24/7</h3>
                            <h5>Support</h5>
                        </div>
                    </div>
                </div>
                <div id="traped_box">
                    <h2>Who do We Serve?</h2>
                    <ul>
                        <li>Traffic accident victims</li>
                        <li>Trauma victims</li>
                        <li>Cancer patients</li>
                        <li>Disaster victims</li>
                        <li>Medical tourism</li>
                        <li>Bed to bed transfer patients</li>
                        <li>Corpse removal</li>
                    </ul>
                </div>
            </section>
            <section id="partners">
                <div class="row">
                    <div class="partners_img">
                        <div></div><img src="https://639.firstmedtrade.com//config/assets/images/TWVkaWNhIEFpciBUcmFuc3BvcnQ/partners/logo-cqc.png" alt="">
                    </div>
                    <div class="partners_img">
                        <div></div><img src="https://639.firstmedtrade.com//config/assets/images/TWVkaWNhIEFpciBUcmFuc3BvcnQ/partners/logo-easa.png" alt="">
                    </div>
                    <div class="partners_img">
                        <div></div><img src="https://639.firstmedtrade.com//config/assets/images/TWVkaWNhIEFpciBUcmFuc3BvcnQ/partners/logo-iata.png" alt="">
                    </div>
                    <div class="partners_img">
                        <div></div><img src="https://639.firstmedtrade.com//config/assets/images/TWVkaWNhIEFpciBUcmFuc3BvcnQ/partners/logo-nhs.png" alt="">
                    </div>
                </div>
            </section>
            <section id="signup">
                <div class="signup_action">
                    <div class="signup-text">                
                        <p>Let us handle your medical travel needs. Request a quotation for a private charter or book a commercial flight. We are also here 24/7 for your assistance through email or phone.</p>
                        <a href="/request/p?<?php echo substr(md5(microtime()), 0, 20); ?>">Private air charter</a>
                        <a href="/request/c?<?php echo substr(md5(microtime()), 0, 20); ?>">Commercial air ambulance</a>
                        <a href="/request/g?<?php echo substr(md5(microtime()), 0, 20); ?>">Ground ambulance</a>
                    </div>
                </div>
            </section>
        </div>
        <?php require('../../config/footer.php'); ?>
    </div>
</body>
<script>
    $(document).ready(function() {
        //-----------------------------------------------------------------------------------------------
        $('.carousel').carousel({
            interval: 5500,
            pause: false,
        });
        //-----------------------------------------------------------------------------------------------
        if ($('#calc').html('')) {
            $(this).css({
                'display': 'none'
            })
        }
    });
</script>

</html>