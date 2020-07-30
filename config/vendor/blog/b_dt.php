<?php
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
                            <a href="../view?'.substr(md5(microtime()), 0, 15).'&blg=' . str_rot13(base64_encode($row['id'])) . '"><h2 class="tit">' . base64_decode($row['title']) . '</h2></a>
                            <div class="draft_body_bott">
                                <div id="bott_left">
                                    <h4><span>by</span> ' . base64_decode($row['author']) . '</h4><br>
                                    <h4>' . $row['views'] . ' reads</h4>
                                    <span id="date">' . date("d-M-Y", strtotime($row['pub_date'])) . '</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    ';

?>