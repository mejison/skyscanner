<?php

require_once('../../../../config/server.php');

$id = stripslashes($_GET["id"]);
$r = $db->prepare("SELECT `views` FROM `blog` WHERE `id`= ? ");
$r->bind_param('i', $id);
$r->execute();
$res = $r->get_result();
if ($c = $res->fetch_assoc()) {
   $v = $c['views'];
}
$r->close();

$viewd = $db->prepare("UPDATE `blog` SET `views`= ? WHERE `id`= ? ");
$av = ++$v;
$viewd->bind_param('ii', $av, $id);
if($viewd->execute()){
    $rad = $db->prepare("SELECT `views` FROM `blog` WHERE `id`= ? ");
    $rad->bind_param('i', $id);
    $rad->execute();
    $result = $rad->get_result();
    if ($count = $result->fetch_assoc()) {
        echo $count['views'];
    }
    $rad->close();
}
$viewd->close();

