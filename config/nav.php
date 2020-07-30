<navigation class="navigation">
    <?php $title = $link ?>
    <div class="bottom-nav">
        <div class="navlinks-holder">
            <div id="mobile-opener">
                <i class="mdi mdi-menu"></i>
            </div>
            <div id="logo_class">
                <div class="block"></div>
                <div class="logo_nav_options">
                    <img src="https://639.firstmedtrade.com/config/assets/images/logo.png" alt="Logo">
                    <img src="https://639.firstmedtrade.com/config/assets/images/min-logo.png" alt="minLogo">
                </div>
            </div>
            <div id="links_class">
                <div class="left-links">
                    <a href="https://firstmedtrade.com/">Home</a>
                    <a href="https://firstmedtrade.com/find/physicians">Find Doctors</a>
                    <a href="https://firstmedtrade.com/find/hospitals">Find Hospitals</a>
                    <a href="https://ambulance.firstmedtrade.com/" class="<?php if (strpos($title, "Medical Air Transport") !== false) {
                                                                echo 'active-link';
                                                            } ?>">Medical Air Transport</a>
                    <a href="http://market.firstmedtrade.com/" class="<?php if (strpos($title, "Medical Market") !== false) {
                                                                echo 'active-link';
                                                            } ?>">Medical Market</a>
                    <a href="https://blog.firstmedtrade.com/" class="<?php if (strpos($title, "Blog") !== false) {
                                                                echo 'active-link';
                                                            } ?>">Blog</a>
                    <a href=" #">Contact Us</a>
                </div>
                <div class="right-links">
                    <a id="mil" href="https://firstmedtrade.com/login">Login</a>
                    <a id="mil" href="https://firstmedtrade.com/register">Register</a>
                </div>
            </div>
        </div>
    </div>
</navigation>