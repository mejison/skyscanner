<?php

    $db = new mysqli(
        $host = 'localhost',
        $user = 'root',
        $password = 'x7liruk',
        $database = 'fmta_ambulance',
        $port = '3306'//,
        //$socket = '',
    );
    
    if ($db -> connect_error) {
        die('Unexpected Error! Could not connect to the database:');
    }

    date_default_timezone_set('Africa/Lagos');
    session_start();


