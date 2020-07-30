<?php $title = $link ?>

<div class="side_menu">
    <div class="navigation-options">
        <ul id="side-links">
            <li><a id="links" href="https://13646.firstmedtrade.com//" class="<?php if ($title == 'Overview') {
                                                                            echo 'active';
                                                                        } ?>"><i class="mdi mdi-speedometer"></i>Dashboard</a></li>
            <li><a id="links" href="https://13646.firstmedtrade.com//blog/" class="<?php if ($title == 'Blogger') {
                                                                                                        echo 'active';
                                                                                                    } ?>"><i class="mdi mdi-file-document-edit"></i>Blog</a></li>
            <li><a id="links" href="https://13646.firstmedtrade.com//market/" class="<?php if ($title == 'Market') {
                                                                                                        echo 'active';
                                                                                                    } ?>"><i class="mdi mdi-shopping"></i>Market</a></li>
            <li><a id="links" href="https://13646.firstmedtrade.com//settings/" class="<?php if ($title == 'Settings') {
                                                                                                        echo 'active';
                                                                                                    } ?>"><i class="mdi mdi-wrench-outline"></i>Settings</a></li>
        </ul>

    </div>
</div>