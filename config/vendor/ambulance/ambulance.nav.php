<navigation class="navigation">
    <div class="bottom-nav">
        <div class="navlinks-holder">
            <div id="mobile-opener">
                <i class="mdi mdi-menu"></i>
            </div>
            <a href="https://firstmedtrade.com/">
                <div id="logo_class">
                    <div class="block"></div>
                    <div class="logo_nav_options">
                        <img src="https://639.firstmedtrade.com/config/assets/images/logo.png" alt="Logo">
                        <img src="https://639.firstmedtrade.com/config/assets/images/min-logo.png" alt="minLogo">
                    </div>
                </div>
            </a>
            <div id="links_class">
                <div class="left-links">
                    <a href="/" class="<?php if (strpos($title, "Transport") !== false) {
                                                                                                echo 'active-link';
                                                                                            } ?>">Home</a>
                    <a href="/request/p?<?php echo substr(md5(microtime()), 0, 15); ?>&t=<?php echo substr(md5(microtime()), 0, 15); ?>" class="<?php if (strpos($title, "Private") !== false) {
                                                                                                                                echo 'active-link';
                                                                                                                            } ?>">Private Air Charter</a>
                    <a href="/request/c?<?php echo substr(md5(microtime()), 0, 15); ?>&t=<?php echo substr(md5(microtime()), 0, 15); ?>" class="<?php if (strpos($title, "Commercial") !== false) {
                                                                                                                                echo 'active-link';
                                                                                                                            } ?>">Commercial Air Ambulance</a>
                    <a href="/request/g?<?php echo substr(md5(microtime()), 0, 15); ?>&t=<?php echo substr(md5(microtime()), 0, 15); ?>" class="<?php if (strpos($title, "Ground") !== false) {
                                                                                                                                echo 'active-link';
                                                                                                                            } ?>">Ground Ambulance</a>
                    <a href="/manage?<?php echo substr(md5(microtime()), 0, 15); ?>&t=<?php echo substr(md5(microtime()), 0, 15); ?>" class="<?php if (strpos($title, "Manage") !== false) {
                                                                                                                                                                        echo 'active-link';
                                                                                                                                                                    } ?>">Manage Booking</a>
                    <a href="/contact/">Contact us</a>
                    <a id="mil" href="/login">My Account <i class="mdi mdi-account-outline"></i> </a>
                </div>
            </div>
        </div>
    </div>
    <div id="navtop">
        <div class="navtop_alert">
            <h3>Emergency. Support. Assistance. 24/7<a href="tel:+234 701 236 7770"><span><i class="mdi mdi-phone"></i>+234 701 236 7770</span></a></h3>
        </div>
    </div>
</navigation>
