<?php
  require '../../config/server.php';
  $data = file_get_contents('php://input');

  // verefication payment

  // save to db

  echo json_encode([
    'code' => 200,
    'message' => 'Successfuly booking'
  ]);