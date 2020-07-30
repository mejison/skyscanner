<?php
    if(isset($_GET["blg"])){

        require('../../../config/server.php');

        $id = base64_decode(str_rot13($_GET["blg"]));
        $til=$db->prepare("SELECT `title` FROM `blog` WHERE `id`=?");
        $til->bind_param('i', $id);
        $til->execute();
        $result = $til->get_result();
        $row = $result->fetch_assoc();
        $b_title = base64_decode($row["title"]);
        $link = $b_title." -- Blog ";
        $til->close();


?>
<!DOCTYPE html>
<html lang="en">
    <?php require('../../../config/vendor/blog/blog.head.php'); ?>
    <body>
    <script>
        $(document).ready(function() {
            //-------------------------------------------------------------
            let max = 600;

            let str = $("#view_body").html();
            let tot = str.length;
            let res = str.substring(0, (max + 1));
            let more = '<?php echo ' <span id="readmore">(Read More)</span>'; ?>';

            if (tot > max) {
                $('#view_body').html(res + '...' + more);
                $('#readmore').on('click', function() {
                    $('#view_body').html(str);
                    let link = './vendor/read.php?id=<?php echo $id ?>';
                    $.ajax({
                        url: link,
                        type: "POST",
                        success: function(response) {
                            console.log('Read');
                            $('#v_no a').text(response);
                            $('#readmore').removeAttr("href");
                        }
                    });
                    return false;
                })
            }
        })
    </script>
    <div class="divWrap fade blg">
            <?php require('../../../config/nav.php'); ?>
            <div class="container" id="body">
                <section id="read">
                    <?php
                    $query = $db->prepare( "SELECT * FROM `blog` WHERE `id`=? LIMIT 1");
                    $query->bind_param('i', $id);
                    $query->execute();
                    $result = $query->get_result();

                    if ($dt = $result->fetch_assoc()) {
                        $tags = explode(",", $dt['tags']);
                        $body = base64_decode($dt['body']);
                        echo '
                                <div id="read">
                                    <div class="read_head">
                                        <div class="read_tittle">
                                            <h2>' . base64_decode($dt['title']) . '</h2>
                                        </div>
                                        <div class="read_body_img" style="background-image: radial-gradient(rgba(0, 0, 0, 0), rgba(255, 255, 255, 0.18)), url(\'' . base64_decode($dt['imgloc']) . $dt['img'] . '\')">
                                        </div>
                                        <div id="read_hold">
                                            <div class="read_tittle">
                                                <div id="read_dta">
                                                    <h3><span>By </span>' . base64_decode($dt['author']) . '</h3>
                                                    <span>' . date("d-M-Y", strtotime($dt['pub_date'])) . '</span>
                                                    <h3 id="v_no"><a>' . $dt['views'] . '</a> reads</h3>
                                                </div>
                                            </div>
                                            <div class="view_actions">
                                                <span id="like">
                                                    <div id="view_actions_icon">
                                                        <p>
                                                            <i id="liken" class="mdi mdi-thumb-up-outline"></i><span>' . $dt['likes'] . '</span>
                                                        </p>
                                                    </div>
                                                </span>
                                                <span id="unlike">
                                                    <div id="view_actions_icon">
                                                        <p>
                                                            <i id="unlike" class="mdi mdi-thumb-down-outline"></i><span>' . $dt['dislikes'] . '</span>
                                                        </p>
                                                    </div>
                                                </span>
                                                <span id="share">
                                                    <div id="view_actions_icon">
                                                        <p>
                                                            <i class="mdi mdi-share"></i><span>Share</span>
                                                        </p>
                                                    </div>
                                                </span>
                                                <div class="share_pop">
                                                    <ul class="share_pop_content">
                                                        <div class="share" id="remove"><i class="mdi mdi-close"></i></div>
                                                        <li>
                                                            <!-- Email -->
                                                            <a rel="nofollow opener" href="mailto:?subject='.$b_title.'&body=Check this out - '.$b_title.' - https://blog.firstmedtrade.com/view/?'.substr(md5(microtime()), 0, 15).'blg=' . str_rot13(base64_encode($dt["id"])) .'%26drect=false" target="_blank" title="Share via email" >
                                                                <i class="mdi mdi-email"></i>Share via Email
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <!-- Facebook -->
                                                            <a rel="nofollow opener" href="https://www.facebook.com/sharer/sharer.php?u=https://blog.firstmedtrade.com/view/?'.substr(md5(microtime()), 0, 15).'%26blg=' . str_rot13(base64_encode($dt["id"])) .'%26drect=false&t='.$b_title.'" title="Share on Facebook" target="_blank" >
                                                                <i class="mdi mdi-facebook"></i>Share via Facebook
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <!-- LinkedIn -->
                                                            <a rel="nofollow opener" href="http://www.linkedin.com/shareArticle?mini=true&url=https://blog.firstmedtrade.com/view/%2F%'.substr(md5(microtime()), 0, 15).'%26blg=' . str_rot13(base64_encode($dt["id"])) .'%26drect=false&title='.$b_title.'%26summary=&source=" target="_blank" title="Share on LinkedIn">
                                                                <i class="mdi mdi-linkedin"></i>Share via Linkedin
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <!-- Twitter -->
                                                            <a rel="nofollow opener" href="https://twitter.com/intent/tweet?text='.$b_title.': https://blog.firstmedtrade.com/view/?'.substr(md5(microtime()), 0, 15).'%26blg=' . str_rot13(base64_encode($dt["id"])) .'%26drect=false" target="_blank" title="Share on Twitter" >
                                                                <i class="mdi mdi-twitter"></i>Share via Twitter
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <!--WhatsApp -->
                                                            <a rel="nofollow opener" href="whatsapp://send?text=https://blog.firstmedtrade.com/view/?'.substr(md5(microtime()), 0, 15).'%26blg=' . str_rot13(base64_encode($dt["id"])) .'%26drect=false%26t='.$b_title.'" data-action="share/whatsapp/share">
                                                                <i class="mdi mdi-whatsapp"></i>Share via Whatsapp
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="read_body">
                                        <div id="view_body">' . htmlspecialchars_decode($body) . '</div>
                                        <div id="read_tags">
                                            <p id="tg"><i class="mdi mdi-tag"></i>Tags</p>';
                        foreach ($tags as $tag) {
                            echo '<a href="../tags?'.md5('$tag').'&amp;tagname=' . $tag . '">' . $tag . '</a>';
                        }
                        echo '
                                        </div>
                                    </div>
                                </div>
                            ';
                    }
                    $query->close();
                    ?>
                </section>
                <section class="bodyLeft read">
                    <div class="bodyLeft_botm">
                        <div id="title">
                            <h1>Previous Articles</h1><span>
                                <hr></span>
                        </div>
                        <div class="new">
                            <div id="galleria">
                                <?php
                                if (isset($_GET['pageno'])) {
                                    $pageno = $_GET['pageno'];
                                } else {
                                    $pageno = 1;
                                }
                                $no_of_records_per_page = 10;
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

                                $sql = $db->prepare("SELECT * FROM `blog` WHERE `published`=? AND `id`!=? ORDER BY `pub_date` ASC LIMIT ?, ? ");
                                $sql->bind_param('iiii', $pub, $id, $offset, $no_of_records_per_page);
                                $sql->execute();
                                $result = $sql->get_result();
                                if ($result->num_rows == 0) {
                                    echo '';
                                } else {
                                    while ($row = $result->fetch_array()) {
                                        require('../../../config/vendor/blog/b_dt.php');
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <?php require('../../../config/footer.php'); ?>
        </div>
    </body>
    <script>
        $(window).ready(function() {
            ///-------------------------------------------products next and previous
            $("a#liners").on('click', function() {
                let link = $(this).attr("href");

                $('.nums#liners').removeClass('active');
                $(this).addClass('active');

                $.ajax({
                    url: link,
                    success: function(response) {
                        $('#body').empty().append(response);
                    }
                })
                return false;
            });

            ///-------------------------------------------like
            $("span#like").on('click', function(e) {
                if($('span#unlike #view_actions_icon').hasClass('act')){
                    let link = "./vendor/ul.php?r=<?php echo $id; ?>";
                    $.ajax({
                        url: link,
                        type: "POST",
                        success: function(response) {
                            $('i#unlike').removeClass('mdi-thumb-down').addClass('mdi-thumb-down-outline');
                            $('span#unlike p span').html(response);
                            $('span#unlike #view_actions_icon').removeClass('act');
                            let link = "./vendor/l.php?like=<?php echo $id; ?>";
                            $.ajax({
                                url: link,
                                type: "POST",
                                success: function(response) {
                                    $('i#liken').removeClass('mdi-thumb-up-outline').addClass('mdi-thumb-up');
                                    $('span#like p span').html(response);
                                    $('span#like #view_actions_icon').addClass('act');
                                }
                            });
                        }
                    });
                }else if($('span#like #view_actions_icon').hasClass('act')){
                    let link = "./vendor/l.php?r=<?php echo $id; ?>";
                    $.ajax({
                        url: link,
                        type: "POST",
                        success: function(response) {
                            $('i#liken').removeClass('mdi-thumb-up').addClass('mdi-thumb-up-outline');
                            $('span#like p span').html(response);
                            $('span#like #view_actions_icon').removeClass('act');
                        }
                    });
                }else{
                    let link = "./vendor/l.php?like=<?php echo $id; ?>";
                    $.ajax({
                        url: link,
                        type: "POST",
                        success: function(response) {
                            $('i#liken').removeClass('mdi-thumb-up-outline').addClass('mdi-thumb-up');
                            $('span#like p span').html(response);
                            $('span#like #view_actions_icon').addClass('act');
                        }
                    });
                    e.preventDefault();
                }
            });

            ///-------------------------------------------unlike
            $("span#unlike").on('click', function(e) {
                if($('span#like #view_actions_icon').hasClass('act')){
                    let link = "./vendor/l.php?r=<?php echo $id; ?>";
                    $.ajax({
                        url: link,
                        type: "POST",
                        success: function(response) {
                            $('i#liken').removeClass('mdi-thumb-up').addClass('mdi-thumb-up-outline');
                            $('span#like p span').html(response);
                            $('span#like #view_actions_icon').removeClass('act');
                            let link = "./vendor/ul.php?ulike=<?php echo $id; ?>";
                            $.ajax({
                                url: link,
                                type: "POST",
                                success: function(response) {
                                    $('i#unlike').removeClass('mdi-thumb-down-outline').addClass('mdi-thumb-down');
                                    $('span#unlike p span').html(response);
                                    $('span#unlike #view_actions_icon').addClass('act');
                                }
                            });
                        }
                    });
                }else if($('span#unlike #view_actions_icon').hasClass('act')){
                    let link = "./vendor/ul.php?r=<?php echo $id; ?>";
                    $.ajax({
                        url: link,
                        type: "POST",
                        success: function(response) {
                            $('i#unlike').removeClass('mdi-thumb-down').addClass('mdi-thumb-down-outline');
                            $('span#unlike p span').html(response);
                            $('span#unlike #view_actions_icon').removeClass('act');
                        }
                    });
                }else{
                    let link = "./vendor/ul.php?ulike=<?php echo $id; ?>";
                    $.ajax({
                        url: link,
                        type: "POST",
                        success: function(response) {
                            $('i#unlike').removeClass('mdi-thumb-down-outline').addClass('mdi-thumb-down');
                            $('span#unlike p span').html(response);
                            $('span#unlike #view_actions_icon').addClass('act');
                        }
                    });
                    e.preventDefault();
                }
            });
        })
    </script>

</html>
<?php
}else{
?>
<!DOCTYPE html>
<html lang="en">
    <?php
        $link = "Blog ";
        require('../../../config/vendor/blog/blog.head.php');
    ?>
    <body>
        <div class="divWrap fade blg">
            <?php require('../../../config/nav.php'); ?>
            <h3 id="info">Nothing to see here!<br><span>Go back to <a href="https://blog.firstmedtrade.com/">Blogs</a></h3>
        </div>
        <?php require('../../../config/footer.php'); ?>
    </body>

</html>
<?php
}
?>
