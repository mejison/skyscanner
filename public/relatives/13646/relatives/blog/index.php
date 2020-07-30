<?php

$link = "Blogger";

require('../../config/server.php');

?>
<!DOCTYPE html>
<html lang="en">
<?php require('../../config/head.php'); ?>

<body>
    <link rel="stylesheet" type="text/css" media="screen" href="https://13646c.firstmedtrade.com//config/assets/css/blog.css" />
    <div class="divWrap fade">
        <?php require('../../config/sidebar.php'); ?>
        <section id="ref">
            <navigation id="navigation">
                <?php require('../../config/nav.php'); ?>
            </navigation>
            <div class="ref">
                <div id="body">
                    <div class="body_alert">
                        <?php
                        $stats_query = mysqli_query($db, "SELECT `id`, `published`, `views` FROM `blog`");
                        $articles = mysqli_num_rows($stats_query);
                        if ($articles > 0) {
                            while ($show_stats = mysqli_fetch_array($stats_query)) {
                                $sum_views[] = $show_stats['views'];
                                $sum_pubs[] = $show_stats['published'];
                            }
                            $sum_views = array_sum($sum_views);
                            $sum_pubs = array_sum($sum_pubs);
                            echo '
                                            <p>All Articles: <span>' . $articles . '</span></p>
                                            <p>Published: <span>' . $sum_pubs . '</span></p>
                                            <p>Viewed: <span>' . $sum_views . '</span></p>
                                        ';
                        } else {
                            echo '
                                            <p>All Articles: <span>0</span></p>
                                            <p>Published: <span>0</span></p>
                                            <p>Viewed: <span>0</span></p>
                                        ';
                        }
                        ?>
                    </div>
                    <div class="bodyLeft">
                        <div class="bodyLeft_top">
                            <div id="rare">
                                <a href="./form.php" id="create">
                                    <div>
                                        <i class="mdi mdi-plus"></i>
                                        <h4>Create<br>new<br>Article</h4>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="bodyLeft_botm">
                            <div id="title">
                                <h1>Drafts</h1><span>
                                    <hr></span>
                            </div>
                            <div class="drafts">
                                <?php
                                $draft_query = mysqli_query($db, "SELECT * FROM `blog` WHERE `published`='0' ORDER BY `updates` DESC LIMIT 6");
                                if (mysqli_num_rows($draft_query) > 0) {
                                    while ($show_drafts = mysqli_fetch_array($draft_query)) {
                                        $tags = explode(",", $show_drafts['tags']);
                                        echo '
                                            <div id="drafts">
                                                <div class="draft_options">
                                                    <i id="options" class="mdi mdi-dots-vertical"></i>
                                                    <div class="tooltip">
                                                        <a class="edit" href="edit.php?getid=' . $show_drafts['id'] . '">Edit</a>
                                                        <a class="action" href="delete.php?getid=' . $show_drafts['id'] . '">Delete</a>
                                                    </div>
                                                </div>
                                                <div class="draft_body">
                                                    <div class="draft_body_img" style="background-image: url(\'' . base64_decode($show_drafts['imgloc']) . $show_drafts['img'] . '\')">
                                                    </div>
                                                    <div class="draft_body_text">
                                                        <h2>' . base64_decode($show_drafts['title']) . '</h2>
                                                        <h3>' . base64_decode($show_drafts['subtitle']) . '</h3>
                                                        <p>' . htmlspecialchars_decode(base64_decode($show_drafts['body'])) . '</p>
                                                    </div>
                                                    <div class="draft_body_bott">
                                                        <div id="bott_left"><i class="mdi mdi-calendar"></i><span id="date">' . $show_drafts['date_created'] . '</span></div>
                                                        <div id="bott_right"><span>' . implode("</span><span>", $tags) . '</span></div>
                                                    </div>
                                                </div>
                                            </div>
                                        ';
                                    }
                                } else {
                                    echo 'No blog found';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="bodyRight">
                        <div id="title">
                            <h1>Previous Articles</h1><span>
                                <hr></span>
                        </div>
                        <?php
                        $draft_query = mysqli_query($db, "SELECT * FROM `blog` WHERE `published`='1' ORDER BY `pub_date` DESC LIMIT 10");
                        if (mysqli_num_rows($draft_query) > 0) {
                            while ($show_drafts = mysqli_fetch_array($draft_query)) {
                                $tags = explode(",", base64_decode($show_drafts['tags']));
                                echo '
                                    <div id="published">
                                        <div class="pub_options">
                                            <i id="options" class="mdi mdi-dots-vertical"></i>
                                            <div class="tooltip"> 
                                                <a class="edit" href="edit.php?getid=' . $show_drafts['id'] . '">Edit</a>
                                                <a class="action" href="hide.php?getid=' . $show_drafts['id'] . '">Hide</a>
                                                <a class="action" href="delete.php?getid=' . $show_drafts['id'] . '">Delete</a>
                                                <a class="action" href="fav.php?getid=' . $show_drafts['id'] . '">Add to fav</a>
                                            </div>
                                        </div>
                                        <div class="pub_body">
                                            <div class="pub_body_img" style="background-image: url(\'' . base64_decode($show_drafts['imgloc']) . $show_drafts['img'] . '\')">
                                            </div>
                                            <div id="pub_hold">
                                                <div class="pub_body_text">
                                                    <h3>' . base64_decode($show_drafts['title']) . '</h3>
                                                </div>
                                                <div class="pub_body_bott">
                                                    <div id="bott_left"><i class="mdi mdi-calendar"></i><span id="date">' . $show_drafts['pub_date'] . '</span></div>
                                                </div>
                                                <div class="pub_stats">
                                                    <div id="stat_left"><i class="mdi mdi-eye-settings"></i><span id="views">' . $show_drafts['views'] . '</span></div>                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                ';
                            }
                        } else {
                            echo 'No articles have been published yet';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>
<script>
    //------------------------------------------------------------------------------------
    $(document).ready(function() {
        $('#create').click(function() {
            var link = $(this).attr("href");
            $.ajax({
                url: link,
                type: 'GET',
                success: function(response) {
                    $("#body").html(response);
                }
            })
            return false;
        });
        //------------------------------------------------------------------------------------
        $('.action').click(function() {
            var link = $(this).attr("href");
            $.ajax({
                url: link,
                type: 'GET',
                success: function(response) {
                    if (response = 'Success') {
                        alert('Your action was carried out successfully!');
                        location.reload();
                    } else {
                        alert('This is new! I don\'t understand you please!');
                    }
                }
            })
            return false;
        });
        //------------------------------------------------------------------------------------
        $('.edit').click(function() {
            var link = $(this).attr("href");
            $.ajax({
                url: link,
                type: 'GET',
                success: function(response) {
                    $("#body").html(response);
                }
            })
            return false;
        });


    });
</script>

</html>