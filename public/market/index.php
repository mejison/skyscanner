<?php

require('../../config/server.php');
$link = "Medical Market";

$page = base64_encode("Medical Market");

$stmt=$db->prepare("SELECT `description`, `tags` FROM `meta` WHERE `pages`=?");
$stmt->bind_param('s', $page);
$stmt->execute();
$result = $stmt->get_result();
if($result->num_rows == 0) echo("<script>console.log('PHP: No SEO data found!');</script>");
while($row = $result->fetch_assoc()) {
    $description =  base64_decode($row['description']);
    $tags =  base64_decode($row['tags']);
}

$stmt->close();


?>
<!DOCTYPE html>
<html lang="en">
<?php require('../../config/head.php'); ?>

<body>
    <link rel="stylesheet" href="https://639.firstmedtrade.com/config/assets/css/market.css">
    <div class="divWrap fade mkt blg">
        <div class="container mkt" id="body">
            <?php require('../../config/nav.php'); ?>
                
            <div class="hcSlider carousel slide" id="hcCarousel">
                <div class="carousel-inner">
                    <div class="item active">
                        <div class="fill">
                            <h2>Biopsy Needles</h2>
                        </div>
                    </div>
                    <div class="item">
                        <div class="fill">
                            <h2>Cardiac Consumables</h2>
                        </div>
                    </div>
                    <div class="item">
                        <div class="fill">
                            <h2>Catheters</h2>
                        </div>
                    </div>
                    <div class="item">
                        <div class="fill">
                            <h2>Dialysis Consumables</h2>
                        </div>
                    </div>
                    <div class="item">
                        <div class="fill">
                            <h2>Hospital Furniture</h2>
                        </div>
                    </div>
                    <div class="item">
                        <div class="fill">
                            <h2>Scrubs</h2>
                        </div>
                    </div>
                    <div class="item">
                        <div class="fill">
                            <h2>Radiology Consumables</h2>
                        </div>
                    </div>
                </div>
            </div>

            <h3 id="info">
                Now you can request and get<br><br>For your Health facility<br>
                <a href="https://market.firstmedtrade.com/requests" id="requt">Request A Quote</a>
            </h3>
        </div>
    </div>
</body>
<script type="text/javascript">
    $('.carousel').carousel({
        interval: 4500,
        pause: false,
    })
</script>

</html>