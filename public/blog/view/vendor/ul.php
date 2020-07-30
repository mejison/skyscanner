<?php

require('../../../../config/server.php');

if(isset($_GET["ulike"])){
    $id = $_GET["ulike"];

    $r = $db->prepare("SELECT `dislikes` FROM `blog` WHERE `id`= ? ");
    $r->bind_param('i', $id);
    $r->execute();
    $res = $r->get_result();
    if ($c = $res->fetch_assoc()) {
        $d = $c['dislikes'];
        $ad = ++$d;
    }
    $r->close();
}elseif (isset($_GET["r"])) {
    $id = $_GET["r"];
    $r = $db->prepare("SELECT `dislikes` FROM `blog` WHERE `id`= ? ");
    $r->bind_param('i', $id);
    $r->execute();
    $res = $r->get_result();
    if ($c = $res->fetch_assoc()) {
        $d = $c['dislikes'];
        $ad = --$d;
    }
    $r->close();
}

$dislikd = $db->prepare("UPDATE `blog` SET `dislikes`= ? WHERE `id`= ? ");
$dislikd->bind_param('ii', $ad, $id);
if ($dislikd->execute()) {
    $dne = $db->prepare("SELECT `dislikes` FROM `blog` WHERE `id`= ? ");
    $dne->bind_param('i', $id);
    $dne->execute();
    $result = $dne->get_result();
    if ($row = $result->fetch_assoc()) {
        echo $row['dislikes'];
    }
    $dne->close();
}

$dislikd->close();
