<head>
    <?php
        $title = $link;

        $page = base64_encode("Medical Air Transport");

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta http-equiv="cache-control" content="no-cache"/>
    <meta name="author" content="First MedTrade Africa" />
    <meta name="robots" content="index, follow" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="language" content="English">
    <meta name="revisit-after" content="1 days">
    <meta name="title" content="<?php echo $title; ?> | First Medtrade Africa">
    <meta name="description" content="<?php echo $description?>">
    <meta name="keywords" content="<?php echo $tags?>">

    <meta name="dcterms.rightsHolder" content="First MedTrade Africa">
    <meta name="dcterms.rights" content="Unless otherwise indicated, this Website is our proprietary property and all source codes, databases, functionalities, softwares, audio, video, text, photographs, graphic content and designs on the Website (collectively, The 'Content') and the trademarks, service marks, and logos contained therein (the 'Marks') are owned or controlled by us or licensed to us, and are protected by copyright and trademark laws and various other intellectual property rights and unfair competition laws of Nigeria, foreign jurisdictions, and international conventions."/>
    <meta name="dcterms.dateCopyrighted" content="2019-2020">
    <meta content="<?php echo $title; ?> | First Medtrade Africa" property="og:title"/>
    <meta content="First MedTrade Africa Emergency" property="og:site_name"/>
    <meta content="Health, Medical Transport" property="og:type"/>
    <meta content="<?php echo $description?>" property="og:description"/>
    <meta content="https://639.firstmedtrade.com/config/assets/images/favicon-96x96.png" property="og:image"/>
    <meta content="https://ambulance.firstmedtrade.com/" property="og:url"/>

    <link rel="apple-touch-icon" sizes="180x180" href="https://639.firstmedtrade.com/config/assets/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="https://639.firstmedtrade.com/config/assets/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="https://639.firstmedtrade.com/config/assets/images/favicon-16x16.png">
    <link rel="manifest" href="https://639.firstmedtrade.com/config/assets/images/site.webmanifest">
    <link rel="icon" type="image/x-icon" href="https://639.firstmedtrade.com/config/assets/images/favicon.ico">
    <link rel="shortcut icon" type="image/x-icon" href="https://639.firstmedtrade.com/config/assets/images/favicon.ico">
    <title><?php echo $title; ?> | First Medtrade Africa</title>

    <link rel="stylesheet" type="text/css" media="screen" href="https://639.firstmedtrade.com/config/assets/css/air-ambulance.css">
    <link rel="stylesheet" href="//cdn.materialdesignicons.com/5.1.45/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">    
    <link rel="stylesheet"  type="text/css" media="screen" href="/assets/css/main.css">

    <script async src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://639.firstmedtrade.com/config/assets/js/jquery-3.2.1.min.js"></script>
    <script defer src="https://639.firstmedtrade.com/config/assets/js/ind.js"></script>
    <script src="https://639.firstmedtrade.com/config/assets/js/bootstrap.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.min.js"></script>
    <script src="https://unpkg.com/vue-router@3.3.4/dist/vue-router.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.js"></script>
    <script src="https://unpkg.com/vuex@3.5.1/dist/vuex.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://js.paystack.co/v1/inline.js"></script>

    <script defer>
        var Tawk_API = Tawk_API || {},
            Tawk_LoadStart = new Date();
        (function() {
            var s1 = document.createElement("script"),
                s0 = document.getElementsByTagName("script")[0];
            s1.defer = true;
            s1.src = 'https://embed.tawk.to/5b2b5eefd0b5a54796820741/default';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>

</head>
