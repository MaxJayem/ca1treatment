<?php


require_once("vendor/autoload.php");

$method = $_SERVER['REQUEST_METHOD'];

// Process only when method is POST
if($method == 'POST'){
    $requestBody = file_get_contents('php://input');
    $json = json_decode($requestBody);

    $text = $json->queryResult->queryText;
    $action = $json->queryResult->action;
    //$response = new stdClass();


    switch ($action) {

        case 'testaction':
        $fulfillment = checkSentiment("Funktion funktioniert");

            $response->fulfillmentText = $fulfillment;
            break;


        case 'abc':
            $fulfillment = "action: abc";
            $response->fulfillmentText = $fulfillment;
            break;
            
        case 'hi':
            $fulfillment = "Hi wie geht's?";
            $response->fulfillmentText = $fulfillment;
            break;

        case 'problem1':
            $fulfillment = $text." [Polarität: ".checkSentiment($text)."]";
            $response->fulfillmentText = $fulfillment;
            break;

        case 'rich':
            $response = new stdClass([
                "fulfillmentText" => "Das geht auch"
            ]);


            break;


        default:

            break;
    }



    echo json_encode($response);

}
else {
    echo "method not allowedOK";

}

function checkSentiment ($text) {

    $textapi = new AYLIEN\TextAPI("5830e19e", "dcb00d991f9cf96640e804ee71681782");

    $sentiment = $textapi->Sentiment(array(
        'text' =>  $text,
        'language' => 'de'
    ));

    return $sentiment->polarity;
}
?>
