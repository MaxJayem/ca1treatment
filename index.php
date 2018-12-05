<?php


require_once("vendor/autoload.php");

$method = $_SERVER['REQUEST_METHOD'];

// Process only when method is POST
if($method == 'POST'){
    $requestBody = file_get_contents('php://input');
    $json = json_decode($requestBody);

    $text = $json->queryResult->queryText;
    $action = $json->queryResult->action;



    switch ($action) {

        case 'testaction':
        $fulfillment = checkSentiment("Funktion funktioniert");
            break;


        case 'abc':
            $fulfillment = "action: abc";
            break;
            
        case 'hi':
            $fulfillment = "Hi wie geht's?";
            break;

        case 'problem1':
            $fulfillment = $text."[ ".checkSentiment($text)." ]";
            break;


        default:

            break;
    }




    $response = new stdClass();
    $response->fulfillmentText = $fulfillment;

    echo json_encode($response);

}
else {
    echo "method not allowedOK";

}

function checkSentiment ($text) {

    $textapi = new AYLIEN\TextAPI("5830e19e", "dcb00d991f9cf96640e804ee71681782");

    $sentiment = $textapi->Sentiment(array(
        'text' => 'Ich habe doch gar kein Abonnement abgeschlossen!',
        'language' => 'de'
    ));

    return $sentiment->polarity;
}
?>
