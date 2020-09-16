<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require 'vendor/autoload.php';
    require 'vendor/larapack/dd/src/helper.php';
    require 'vendor/digitickets/lalit/src/XML2Array.php';
    require '../../config/server.php';

    $post = file_get_contents("php://input");
    $post = json_decode($post);

    insertRequest(['travlers' => json_encode($post->travlers), 
                    'contact_firstname' => $post->contact->firstname, 
                    'contact_surname' => $post->contact->surname,
                    'contact_email' => $post->contact->email,
                    'contact_mobile' => $post->contact->mobile,
                    'created_at' => date('Y-m-d H:i:s', time()),
                    ]);

    function insertRequest($data) {
        global $db;
        $length = count($data);
        $keys = array_keys($data);
        $values = array_values($data);
        $request = $db->prepare("INSERT INTO `requests` (`" . implode('`,`', $keys) . "`) VALUES (" . str_repeat('?,', $length-1) . "?)");
        $request->bind_param(str_repeat('s', $length), ...$values);
        return $request->execute();
    }