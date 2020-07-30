<?php

require('../../../../config/server.php');

if(isset($_GET["like"])){
    $id = $_GET["like"];
    $r = $db->prepare("SELECT `likes` FROM `blog` WHERE `id`= ? ");
    $r->bind_param('i', $id);
    $r->execute();
    $res = $r->get_result();
    if ($c = $res->fetch_assoc()) {
        $v = $c['likes'];
        $al = ++$v;
    }
    $r->close();
}elseif (isset($_GET["r"])){
    $id = $_GET["r"];
    $r = $db->prepare("SELECT `likes` FROM `blog` WHERE `id`= ? ");
    $r->bind_param('i', $id);
    $r->execute();
    $res = $r->get_result();
    if ($c = $res->fetch_assoc()) {
        $v = $c['likes'];
        $al = --$v;
    }
    $r->close();
}

$likd = $db->prepare("UPDATE `blog` SET `likes`= ? WHERE `id`= ? ");
$likd->bind_param('ii', $al,$id);
if($likd->execute()){
    $dne = $db->prepare("SELECT `likes` FROM `blog` WHERE `id`= ? ");
    $dne->bind_param('i', $id);
    $dne->execute();
    $result = $dne->get_result();
    if($row = $result->fetch_assoc()) {
        echo $row['likes'];
    }
    $dne->close();
}
$likd->close();


