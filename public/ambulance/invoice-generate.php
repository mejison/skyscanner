<?php
  require_once __DIR__ . '/vendor/autoload.php';
  
  $data = file_get_contents("php://input");          
  $data = json_decode($data, true);
  
  ob_start();  
  include "./invoice.php";    
  $content = ob_get_contents();
  ob_end_clean();

  $mpdf = new \Mpdf\Mpdf();
  $mpdf->WriteHTML($content);
  $fileName =  time() . '.pdf';
  $fileUrl = '/pdfs/' . $fileName;
  $mpdf->Output(__DIR__ . $fileUrl, \Mpdf\Output\Destination::FILE);

  echo json_encode([
    'code' => 200,
    'message' => "Successfuly generate",
    'data' => [
      'pdf_link' => $fileUrl
    ]
  ]);