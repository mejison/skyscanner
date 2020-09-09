<?php

require 'vendor/autoload.php';
require 'vendor/larapack/dd/src/helper.php';
require 'vendor/digitickets/lalit/src/XML2Array.php';

// error_reporting(E_ALL);
// ini_set('display_errors', TRUE);
// ini_set('display_startup_errors', TRUE);

use GuzzleHttp\Client;

class TravelportFlights {

	public $client;
	public $target_branch = 'P7004934';
	public $credentials = 'Universal API/uAPI4900536672-60b8e52c:ngFHTKWSDkwPxPPtC7qQqf7En';
	public $provider = '1G';
	public $message = '';

    public function __construct() {      
		$auth = base64_encode($this->credentials);
		$this->client = new Client([
			'base_uri' => 'https://apac.universal-api.pp.travelport.com',
			'http_errors' => false,
			'headers' => [
				"Content-Type" => "text/xml;charset=UTF-8",
				"Accept-Encoding" => "gzip,deflate",
				"Cache-Control" => "no-cache",
				"Pragma" => "no-cache",
				"SOAPAction" => '""',
				"Authorization" => "Basic $auth"
			]
		]);      
	}

	public function setBodyMessage($from, $to, $departure_date, $return_date, $passangers = 1, $class = "Economy") {
		$PreferredDepDate = $departure_date;
		$PreferredRetDate = $return_date;
		$Origin = $from;
		$Destination = $to;
		$Carrier = "UA";
		$CabinClass = $class;		
		$NumberOfTravelers = $passangers;
		$Provider = $this->provider;
		$TARGETBRANCH = $this->target_branch;

		$message = new DOMDocument('1.0', 'UTF-8');

		$xmlRoot = $message->createElementNS("http://schemas.xmlsoap.org/soap/envelope/","soapenv:Envelope","");
		$xmlRoot = $message->appendChild($xmlRoot);

		$xmlRootHeader = $message->createElement("soapenv:Header");
		$xmlRootHeader = $xmlRoot->appendChild($xmlRootHeader);
		$xmlRootBody = $message->createElement("soapenv:Body");
		$xmlRootBody = $xmlRoot->appendChild($xmlRootBody);

		$lfsRootNode = $message->createElementNS("http://www.travelport.com/schema/air_v42_0","air:LowFareSearchReq","");
		$lfsRootNode = $xmlRootBody->appendChild($lfsRootNode);

		$lfsRootNodeattribute = $message->createAttribute("TraceId");
		$lfsRootNodeattribute->value = "trace";
		$lfsRootNode->appendChild($lfsRootNodeattribute);

		$lfsRootNodeattribute = $message->createAttribute("AuthorizedBy");
		$lfsRootNodeattribute->value = "user";
		$lfsRootNode->appendChild($lfsRootNodeattribute);

		$lfsRootNodeattribute = $message->createAttribute("TargetBranch");
		$lfsRootNodeattribute->value = $TARGETBRANCH;
		$lfsRootNode->appendChild($lfsRootNodeattribute);

		$lfsRootNodeattribute = $message->createAttribute("SolutionResult");
		$lfsRootNodeattribute->value = "true";
		$lfsRootNode->appendChild($lfsRootNodeattribute);

		$billPointOfSaleNode = $message->createElementNS("http://www.travelport.com/schema/common_v42_0","com:BillingPointOfSaleInfo","");
		$billPointOfSaleNodeattribute = $message->createAttribute("OriginApplication");
		$billPointOfSaleNodeattribute->value = "UAPI";
		$billPointOfSaleNode->appendChild($billPointOfSaleNodeattribute);

		$billPointOfSaleNode = $lfsRootNode->appendChild($billPointOfSaleNode);

		$outboundFlightLeg = $message->createElement("air:SearchAirLeg");
		$outboundFlightLeg = $lfsRootNode->appendChild($outboundFlightLeg);

		$originLeg = $message->createElement("air:SearchOrigin");
		$originLeg = $outboundFlightLeg->appendChild($originLeg);
		$destinatonLeg = $message->createElement("air:SearchDestination");
		$destinatonLeg = $outboundFlightLeg->appendChild($destinatonLeg);
		$prefOutDate = $message->createElement("air:SearchDepTime");
		$prefOutDateAttribute = $message->createAttribute("PreferredTime");
		$prefOutDateAttribute->value = $PreferredDepDate;
		$prefOutDate->appendChild($prefOutDateAttribute);
		$prefOutDate = $outboundFlightLeg->appendChild($prefOutDate);

		$aiportCode = $message->createElementNS("http://www.travelport.com/schema/common_v42_0","com:Airport","");
		$aiportCodeattribute = $message->createAttribute("Code");
		$aiportCodeattribute->value = $Origin;
		$aiportCode->appendChild($aiportCodeattribute);
		$aiportCode = $originLeg->appendChild($aiportCode);

		$aiportCode = $message->createElementNS("http://www.travelport.com/schema/common_v42_0","com:Airport","");
		$aiportCodeattribute = $message->createAttribute("Code");
		$aiportCodeattribute->value = $Destination;
		$aiportCode->appendChild($aiportCodeattribute);
		$aiportCode = $destinatonLeg->appendChild($aiportCode);

		$inboundFlightLeg = $message->createElement("air:SearchAirLeg");
		$inboundFlightLeg = $lfsRootNode->appendChild($inboundFlightLeg);

		$originLeg = $message->createElement("air:SearchOrigin");
		$originLeg = $inboundFlightLeg->appendChild($originLeg);
		$destinatonLeg = $message->createElement("air:SearchDestination");
		$destinatonLeg = $inboundFlightLeg->appendChild($destinatonLeg);
		$prefOutDate = $message->createElement("air:SearchDepTime");
		$prefOutDateAttribute = $message->createAttribute("PreferredTime");
		$prefOutDateAttribute->value = $PreferredRetDate;
		$prefOutDate->appendChild($prefOutDateAttribute);
		$prefOutDate = $inboundFlightLeg->appendChild($prefOutDate);

		$aiportCode = $message->createElementNS("http://www.travelport.com/schema/common_v42_0","com:Airport","");
		$aiportCodeattribute = $message->createAttribute("Code");
		$aiportCodeattribute->value = $Destination;
		$aiportCode->appendChild($aiportCodeattribute);
		$aiportCode = $originLeg->appendChild($aiportCode);

		$aiportCode = $message->createElementNS("http://www.travelport.com/schema/common_v42_0","com:Airport","");
		$aiportCodeattribute = $message->createAttribute("Code");
		$aiportCodeattribute->value = $Origin;
		$aiportCode->appendChild($aiportCodeattribute);
		$aiportCode = $destinatonLeg->appendChild($aiportCode);

		$airSearchModifiersNode = $message->createElement("air:AirSearchModifiers");
		$airSearchModifiersNode = $lfsRootNode->appendChild($airSearchModifiersNode);

		$prefProviderNode = $message->createElement("air:PreferredProviders");
		$prefProviderNode = $airSearchModifiersNode->appendChild($prefProviderNode);

		$prefCabinNode = $message->createElement("air:PermittedCabins");
		$prefCabinNode = $airSearchModifiersNode->appendChild($prefCabinNode);

		$perfProviderCodeNode = $message->createElementNS("http://www.travelport.com/schema/common_v42_0","com:Provider","");
		$perfProviderCodeNodeattribute = $message->createAttribute("Code");
		$perfProviderCodeNodeattribute->value = $Provider;
		$perfProviderCodeNode->appendChild($perfProviderCodeNodeattribute);
		$perfProviderCodeNode = $prefProviderNode->appendChild($perfProviderCodeNode);

		$perfCabinCodeNode = $message->createElementNS("http://www.travelport.com/schema/common_v42_0","com:CabinClass","");
		$perfCabinCodeNodeattribute = $message->createAttribute("Type");
		$perfCabinCodeNodeattribute->value = $CabinClass;
		$perfCabinCodeNode->appendChild($perfCabinCodeNodeattribute);
		$perfCabinCodeNode = $prefCabinNode->appendChild($perfCabinCodeNode);

		for($i = 0; $i < $NumberOfTravelers; $i++)
		{
			$travelerDetails = $message->createElementNS("http://www.travelport.com/schema/common_v42_0","com:SearchPassenger","");
			$travelerDetailsattribute = $message->createAttribute("BookingTravelerRef");
			$travelerDetailsattribute->value = $i;
			$travelerDetails->appendChild($travelerDetailsattribute);
			$travelerDetailsattribute = $message->createAttribute("Code");
			$travelerDetailsattribute->value = "ADT";
			$travelerDetails->appendChild($travelerDetailsattribute);
			$travelerDetails = $lfsRootNode->appendChild($travelerDetails);
		}

		$message->preserveWhiteSpace = false;
		$message->formatOutput = true;
		$this->message = $message->saveXML();
	}
	
	public function search($from, $to, $departure_date, $return_date, $passangers, $class) {
		$this->setBodyMessage($from, $to, $departure_date, $return_date, $passangers, $class);
		$response = $this->client->post("/B2BGateway/connect/uAPI/AirService", [
			'headers' => [
				"Content-length: " . strlen($this->message),
			],
			'body' => $this->message,
		]);
			
		$dom = new DOMDocument;
		$dom->preserveWhiteSpace = false;
		$dom->loadXML((string)$response->getBody());
		$dom->formatOutput = true;
		$content =  $dom->saveXML();
		
		$xml = simplexml_load_String($content, null, null, 'SOAP', true);
		$Body = $Results = $xml->children('SOAP',true);
		$Fault = $Body->children('SOAP',true);
		
		if ( ! empty($Fault)) {
			http_response_code(400);
			return [
				'message' => $content,
			];
		}

		return $this->parseResponse($Results);
	}

	public function parseResponse($Results) {
		$output = [
			'flights' => [],
			'segments' => [],
			'details' => [],
			'bands' => [],
		];

		foreach($Results->children('air',true) as $lowFare) {
			foreach($lowFare->children('air',true) as $airPriceSol) {
				if(strcmp($airPriceSol->getName(),'AirPricingSolution') == 0) {
					$flight = [];
					foreach($airPriceSol->children('air',true) as $journey) {
						if(strcmp($journey->getName(),'Journey') == 0) {
							foreach($journey->children('air', true) as $segmentRef) {
								if(strcmp($segmentRef->getName(),'AirSegmentRef') == 0) {
									foreach($segmentRef->attributes() as $a => $b){
										$segment = $this->ListAirSegments($b, $lowFare);
										$t = [];
										foreach($segment->attributes() as $c => $d){
											if(strcmp($c, "Origin") == 0){
												$t['From'] = (string)$d;
											}
											if(strcmp($c, "Destination") == 0){
												$t['To'] = (string)$d;
											}
											if(strcmp($c, "Carrier") == 0){
												$t['Airline'] = (string)$d;
											}
											if(strcmp($c, "FlightNumber") == 0){
												$t['Flight'] = (string)$d;
											}
											if(strcmp($c, "DepartureTime") == 0){
												$t['Depart'] = (string)$d;
											}
											if(strcmp($c, "ArrivalTime") == 0){
												$t['Arrive'] = (string)$d;
											}
										}
										$flight['AirSegmentRef'][] = $t;
									}
								}
							}

						}
					}

					foreach($airPriceSol->children('air',true) as $priceInfo) {
						if(strcmp($priceInfo->getName(),'AirPricingInfo') == 0) {
							$AirPricingInfo = [];
							
							foreach($priceInfo->children('air', true) as $f){ 
								if ($f->getName() == 'FareInfoRef') {
									$attributes = (array)$f->attributes();
									$AirPricingInfo['FareInfoRef'][] = $attributes['@attributes'];
								}
							}

							foreach($priceInfo->attributes() as $e => $f){
									if(strcmp($e, "ApproximateBasePrice") == 0){ 
										$AirPricingInfo['ApproximateBasePrice'] = str_replace("USD", "", (string)$f) * 1 ?? 0;
									}
									if(strcmp($e, "ApproximateTaxes") == 0) {
										$AirPricingInfo['ApproximateTaxes'] = str_replace("USD", "", (string)$f) * 1 ?? 0;
									}
									if(strcmp($e, "ApproximateTotalPrice") == 0) {
										$AirPricingInfo['ApproximateTotalPrice'] = str_replace("USD", "", (string)$f) * 1 ?? 0;
									}
									if(strcmp($e, "BasePrice") == 0) {
										$AirPricingInfo['BasePrice'] = str_replace("USD", "", (string)$f) * 1 ?? 0;
									}
									if(strcmp($e, "Taxes") == 0){
										$AirPricingInfo['Taxes'] = str_replace("USD", "", (string)$f) * 1 ?? 0;
									}
									if(strcmp($e, "TotalPrice") == 0){
										$AirPricingInfo['TotalPrice'] = str_replace("USD", "", (string)$f) * 1 ?? 0;
									}
							}
							$flight = array_merge($AirPricingInfo, $flight);
						}
					}

					foreach($priceInfo->children('air',true) as $bookingInfo){
						if(strcmp($bookingInfo->getName(),'c') == 0) {
							foreach($bookingInfo->attributes() as $e => $f){
								if(strcmp($e, "CabinClass") == 0){
									$flight['CabinClass'] = (string)$f;
								}
							}
						}
					}

					$output['flights'][] = $flight;
				}

				if(strcmp($airPriceSol->getName(),'AirSegmentList') == 0) {
					foreach($airPriceSol->children('air',true) as $journey) {
						$attributes = (array)$journey->attributes();
						$segment = $attributes['@attributes'];
						$segment['CodeshareInfo'] = (string)$journey->CodeshareInfo;
						$segment['AirAvailInfo'] = (string)$journey->AirAvailInfo->attributes()->ProviderCode;
						$segment['FlightDetailsRef'] = (string)$journey->FlightDetailsRef->attributes()->Key;
						$output['segments'][] = $segment;
					}
				}

				if(strcmp($airPriceSol->getName(), 'FlightDetailsList') == 0) {
					foreach($airPriceSol->children('air',true) as $detail) {
						$attributes = (array)$detail->attributes();
						$detail = $attributes['@attributes'];
						$output['details'][] = $detail;
					}
				}

				if(strcmp($airPriceSol->getName(), 'BrandList') == 0) {
					foreach($airPriceSol->children('air',true) as $band) {
						$attributes = (array)$band->attributes();
						$band = $attributes['@attributes'];
						$output['bands'][] = $band;
					}
				}
			}
		}
		
		return $output;
	}

	function ListAirSegments($key, $lowFare){
		foreach($lowFare->children('air',true) as $airSegmentList){
			if(strcmp($airSegmentList->getName(),'AirSegmentList') == 0){
				foreach($airSegmentList->children('air', true) as $airSegment){
					if(strcmp($airSegment->getName(),'AirSegment') == 0){
						foreach($airSegment->attributes() as $a => $b){
							if(strcmp($a,'Key') == 0){
								if(strcmp($b, $key) == 0){
									return $airSegment;
								}
							}
						}
					}
				}
			}
		}
	}
}


header("Content-type: application/json");

if (empty($_GET['from'])) {
	$errors[] = 'Params `from` not be empty';
}

if (empty($_GET['to'])) {
	$errors[] = 'Params `to` not be empty';
}

if (empty($_GET['departure_date'])) {
	$errors[] = 'Params `departure_date` not be empty';
}

if (empty($_GET['return_date'])) {
	$errors[] = 'Params `return_date` not be empty';
}

if ( ! empty($errors)) {
	echo json_encode([
		'message' => 'Invalid parameters',
		'errors' => $errors,
	]);
	die;
}

$travelportFlights = new TravelportFlights;
$params = [
	'from' => $_GET['from'],
	'to' => $_GET['to'],
	'departure_date' => $_GET['departure_date'],
	'return_date' => $_GET['return_date'],
	'passangers' => $_GET['passangers'] ?? 1,
	'class' => $_GET['class'] ?? 'Economy',
];

list($from) = explode(",", $params['from']);
list($to) = explode(",", $params['to']);

$params['from'] = $from;
$params['to'] = $to;

$response = $travelportFlights->search($params['from'], $params['to'], $params['departure_date'], $params['return_date'], $params['passangers'], $params['class']);

echo json_encode($response);
die;