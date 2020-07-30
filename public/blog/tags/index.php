<?php

    $link = "Blogs tagged with #" . $_GET["tagname"];

    require('../../../config/server.php');

    $tag_name = $_GET["tagname"];

?>
<!DOCTYPE html>
<html lang="en">
<?php require('../../../config/vendor/blog/blog.head.php'); ?>

<body>
    <div class="divWrap fade blg">
        <?php require('../../../config/nav.php'); ?>
        <?php
        if ($tag_name) {
        ?>
            <div class="container" id="body">
                <section class="bodyLeft">
                    <div class="bodyLeft_botm">
                        <div id="title" class="pagin">
                            <h1 id="pagin">
                                <a href="https://firstmedtrade.com/">Home</a> >
                                <a href="https://blog.firstmedtrade.com/">Blog</a> >
                                <a href="https://blog.firstmedtrade.com/tags/?tagname=">Tags</a> >
                                <span id="tell"><?php echo '#' . $tag_name; ?></span>
                            </h1><span>
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
                                $no_of_records_per_page = 12;
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

                                $sql = $db->prepare("SELECT * FROM `blog` WHERE `published`=? AND find_in_set(?, `tags`) > 0 ORDER BY `pub_date` DESC LIMIT ?, ? ");
                                $sql->bind_param('isii', $pub, $tag_name, $offset, $no_of_records_per_page);
                                $sql->execute();
                                $result = $sql->get_result();
                                while ($row = $result->fetch_array()) {
                                        require('../../../config/vendor/blog/b_dt.php');
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
        <?php
        } else {
            echo '<h3 id="info">Nothing to see here!<br><span>Go back to <a href="https://blog.firstmedtrade.com/">Blogs</a></h3>';
        }
        ?>
        <?php require('../../../config/footer.php'); ?>
    </div>
</body>
<script>
    $(window).ready(function() {
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
