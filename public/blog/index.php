<?php

    require('../../config/server.php');
    $link = "Blog";

    $draft_query = $db->prepare("SELECT * FROM `blog` WHERE `published`=? AND `fav`=? ORDER BY `pub_date` DESC LIMIT 5");
    $pub = 1;
    $fav = 1;
    $draft_query->bind_param('ii', $pub, $fav);
    $draft_query->execute();
    $res = $draft_query->get_result();
    $draft_query->close();

?>
<!DOCTYPE html>
<html lang="en">
<?php require('../../config/vendor/blog/blog.head.php'); ?>

<body>
    <div class="divWrap fade">
        <?php require('../../config/nav.php'); ?>
        <div class="container" id="home">
            <div class="blogSlider carousel slide" id="featuredblogCarousel">
                <div class="carousel-inner">
                    <?php
                    if ($res->num_rows > 0) {
                        $count  = 0;
                        while ($show_drafts = $res->fetch_assoc()) {
                            $tags = explode(",", $show_drafts['tags']);
                            echo '
                                <div class="item ';$count++;if ($count == 1) {echo 'active';}echo '">
                                    <div class="fill">
                                        <div id="published">
                                            <div class="pub_body">
                                                <div class="pub_body_img" style="background-image: linear-gradient(rgba(46, 45, 45, 0.13), rgba(46, 45, 45, 0.16)), url(\'' . base64_decode($show_drafts['imgloc']) . $show_drafts['img'] . '\')">
                                                </div>
                                                <div id="pub_hold">
                                                    <div class="pub_body_bott">
                                                        <a href="./view?'.substr(md5(microtime()), 0, 15).'&blg=' . str_rot13(base64_encode($show_drafts['id'])) . '"><h2>' . base64_decode($show_drafts['title']) . '</h2></a>
                                                        <div id="bott_left">
                                                            <h3>' . base64_decode($show_drafts['author']) . '</h3>
                                                            <span>' . date("d-M-Y",strtotime($show_drafts['pub_date'])) . '</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            ';
                        }
                    }
                    ?>
                    <a class="left carousel-control" data-target="#featuredblogCarousel" data-slide="prev">
                        <span class="mdi mdi-chevron-left"></span>
                    </a>
                    <a class="right carousel-control" data-target="#featuredblogCarousel" data-slide="next">
                        <span class="mdi mdi-chevron-right"></span>
                    </a>
                </div>
                <ol class="carousel-indicators">
                    <?php
                    $draft_query = $db->prepare("SELECT * FROM `blog` WHERE `published`=? AND `fav`=? ORDER BY `pub_date` DESC LIMIT 5");
                    $pub = 1;
                    $fav = 1;
                    $draft_query->bind_param('ii', $pub, $fav);
                    $draft_query->execute();
                    $res = $draft_query->get_result();
                    $draft_query->close();

                    if ($res->num_rows > 1) {
                        $count  = 0;
                        while ($show_drafts = $res->fetch_array()) {
                            echo '
                                <li data-target="#featuredblogCarousel" data-slide-to="0" class="';$count++;if ($count == 1) {echo 'active';}echo '"></li>
                            ';
                        }
                    }
                    ?>
                </ol>
            </div>
        </div>
        <div class="container" id="body">
            <section class="bodyLeft">
                <div class="bodyLeft_botm">
                    <div id="title">
                        <h1>Top Articles</h1><span><hr/></span>
                    </div>
                    <div class="new">
                        <div id="galleria">
                            <?php
                            $sql = $db->prepare("SELECT * FROM `blog` WHERE `published`=? AND `new`=? ORDER BY `views` DESC LIMIT ? ");
                            $pub = '1';
                            $new = '0';
                            $no_of_records_per_page = 3;
                            $sql->bind_param('iii', $pub, $new, $no_of_records_per_page);
                            $sql->execute();
                            $result = $sql->get_result();
                            if ($result->num_rows == 0) {
                                echo '';
                            } else {
                                while ($row = $result->fetch_array()) {
                                    $taggs = explode(",", $row['tags']);
                                    echo '
                                        <div id="drafts">
                                            <div class="draft_body">
                                                <div id="craft">
                                                    <div class="craft_left">
                                                        <div class="draft_body_img" style="background-image: url(\'' . base64_decode($row['imgloc']) . $row['img'] . '\')">
                                                        </div>
                                                    </div>
                                                    <div class="craft_right">
                                                        <div class="draft_body_text">
                                                            <a href="./view?'.substr(md5(microtime()), 0, 15).'&blg=' . str_rot13(base64_encode($row['id'])) . '"><h2 class="tit">' . base64_decode($row['title']) . '</h2></a>
                                                            <div class="draft_body_bott">
                                                                <div id="bott_left">
                                                                    <h4><span>by</span> ' . base64_decode($row['author']) . '</h4><br>
                                                                    <h4>' . $row['views'] . ' reads</h4>
                                                                    <span id="date">' . date("d-M-Y",strtotime($row['date_created'])) . '</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    ';
                                }
                            }
                            $sql->close();
                            ?>
                        </div>
                    </div>
                </div>
            </section>
            <section class="bodyLeft">
                <div class="bodyLeft_botm">
                    <div id="title">
                        <h1>All Articles</h1><span><hr/></span>
                    </div>
                    <div class="new">
                        <div id="galleria">
                            <?php
                                if (isset($_GET['pageno'])) {
                                    $pageno = $_GET['pageno'];
                                } else {
                                    $pageno = 1;
                                }
                                $no_of_records_per_page = 15;
                                $offset = ($pageno - 1) * $no_of_records_per_page;

                                $total_pages_sql = $db->prepare("SELECT COUNT(*) FROM `blog` WHERE `published`=? AND `new`=? ");
                                $pub = '1';
                                $new = '0';
                                $total_pages_sql->bind_param('ii', $pub, $new);
                                $total_pages_sql->execute();
                                $res = $total_pages_sql->get_result();
                                $total_rows = $res->fetch_array()[0];
                                $total_pages = ceil($total_rows / $no_of_records_per_page);
                                $total_pages_sql->close();

                                $sql = $db->prepare("SELECT * FROM `blog` WHERE `published`=? AND `new`=? ORDER BY `pub_date` DESC LIMIT ?, ? ");
                                $sql->bind_param('iiii', $pub, $new, $offset, $no_of_records_per_page);
                                $sql->execute();
                                $result = $sql->get_result();
                                if ($result->num_rows == 0) {
                                    echo '';
                                } else {
                                    while ($row = $result->fetch_array()) {
                                        $taggs = explode(",", $row['tags']);
                                        echo '
                                            <div id="drafts">
                                                <div class="draft_body">
                                                    <div id="craft">
                                                        <div class="craft_left">
                                                            <div class="draft_body_img" style="background-image: url(\'' . base64_decode($row['imgloc']) . $row['img'] . '\')">
                                                            </div>
                                                        </div>
                                                        <div class="craft_right">
                                                            <div class="draft_body_text">
                                                                <a href="./view?'.substr(md5(microtime()), 0, 15).'&blg=' . str_rot13(base64_encode($row['id'])) . '"><h2 class="tit">' . base64_decode($row['title']) . '</h2></a>
                                                                <div class="draft_body_bott">
                                                                    <div id="bott_left">
                                                                        <h4><span>by</span> ' . base64_decode($row['author']) . '</h4><br>
                                                                        <h4>' . $row['views'] . ' reads</h4>
                                                                        <span id="date">' . date("d-M-Y",strtotime($row['date_created'])) . '</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        ';

                                    }
                                }
                                $sql->close();
                            ?>
                        </div>
                        <div id="pro-id">
                            <?php
                            if ($result->num_rows > 1) {
                                echo '
                                    <ul class="pagination">
                                        <li class="'; if($pageno <= 1){ echo 'disabled'; }
                                echo'">
                                            <a id="liners" '; if($pageno <= 1){ echo 'style="display: none;"'; } else { echo 'href="../?pageno='.($pageno - 1).'"'; } echo'><i class="mdi mdi-chevron-left"></i></a>
                                        </li>';
                                            if(!empty($total_pages)){
                                                for($i = 1; $i <= $total_pages; $i++){
                                                    if($i === 1){
                                                        echo '
                                                            <li id="'.$i.'">
                                                                <a id="liners" class="nums active" href="../?pageno='.$i.'">'.$i.'</a>
                                                            </li>
                                                        ';
                                                    }else{
                                                        echo'
                                                            <li id="'.$i.'">
                                                                <a id="liners" class="nums" href="../?pageno='.$i.'">'.$i.'</a>
                                                            </li>
                                                        ';
                                                    }
                                                }
                                            }
                                echo '<li class="'; if($pageno >= $total_pages){ echo 'disabled'; } echo'">
                                            <a id="liners"'; if($pageno >= $total_pages){ echo 'style="display: none;"'; } else { echo 'href="../?pageno='.($pageno + 1).'"';} echo'><i class="mdi mdi-chevron-right"></i></a>
                                        </li>
                                    </ul>
                                ';
                            } else {
                                echo '';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <?php require('../../config/footer.php'); ?>
    </div>
</body>
<script>
    $(document).ready(function() {
        $('.carousel').carousel({
            interval: 6500,
            pause: false,
        })
        ///-------------------------------------------products next and previous

        $("a#liners").on('click', function() {
            let link = $(this).attr("href");
            $('#liners').removeClass('active');
            $(this).addClass('active');

            $.ajax({
                url: link,
                success: function(response) {
                    $('.divWrap').empty().append(response);
                }
            })
            return false;
        });

    })
</script>

</html>
