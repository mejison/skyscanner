<?php
  require 'vendor/autoload.php';
  require 'vendor/larapack/dd/src/helper.php';

  use GuzzleHttp\Client;

  class Flights {    

    public $client;
    public $apikey = 'prtl6749387986743898559646983194';
    public $currency = 'NGN';    

    public function __construct() {      
      $this->client = new Client([
          'base_uri' => 'https://partners.api.skyscanner.net/apiservices/pricing/v1.0',
          'timeout'  => 2.0,
          'http_errors' => false,
          'headers' => [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'X-Forwarded-For' => $_SERVER['REMOTE_ADDR']
          ]
      ]);      
    }

    public function getISOCodeCountryByName($name) {      
      $apikey = $this->apikey;
      $response = $this->client->request('GET', "/apiservices/reference/v1.0/countries/en-GB?apiKey={$apikey}");      
      $response = json_decode($response->getBody(), true);

      $finedCountry = array_filter($response['Countries'], function($item) use ($name) {        
        return trim($item['Name']) == $name;
      });
      
      return ! empty($finedCountry) ? end($finedCountry)['Code'] : "";
    }

    public function getCountryByName($name) {
      list($code, $country) = explode(",", $name);
      return trim($country);
    }
    
    public function getCodeISOByName($name) {
      list($code) = explode(",", $name);
      return trim($code);
    }

    public function getFlights($params) {  
      ini_set('max_execution_time', -1);

      $originplace = $this->getCodeISOByName($params["from"]);
      $destinationplace = $this->getCodeISOByName($params["to"]);
      $country = $this->getISOCodeCountryByName($this->getCountryByName($params["from"]));

      $response = $this->client->request('POST', '/apiservices/pricing/v1.0', [
        'form_params' => [
          'cabinclass' => $params['class'],
          'country' => $country,
          'currency' => $this->currency,
          'locale' => 'en-GB',
          'locationSchema' => 'iata',
          'originplace' => $originplace,
          'destinationplace' => $destinationplace,
          'outbounddate' => $params['departure_date'],
          'inbounddate' => $params['return_date'],
          'adults' => $params['passengers'],
          'children' => 0,
          'infants' => 0,
          'apikey' => $this->apikey,
        ]
      ]);

      $data = json_decode($response->getBody(), true);      
      if ($response->getStatusCode() != 201) {                
        header('X-PHP-Response-Code: ' . $data['code'], true, $data['code']);
        echo json_encode($data);
        die;
      }
      
      $pullingUrl = $response->getHeaderLine('Location');
      while(true) {
        $data = $this->pullingFlights(end(explode("/", $pullingUrl)));
        if ($data['Status'] == 'UpdatesComplete') {
          return $data;
        }
        sleep(2);
      }
    }

    public function pullingFlights($session_key) {      
      $api_key = $this->apikey;      
      $response = $this->client->request('GET', "/apiservices/pricing/uk1/v1.0/{$session_key}?apiKey={$api_key}");
      return json_decode($response->getBody(), true);
    }
  }

  $flights = new Flights();
  $results = $flights->getFlights($_GET);
   
  echo json_encode($results);
  die;
?>