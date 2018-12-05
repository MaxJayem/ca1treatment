<?php




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

    $client = new http\Client;
    $request = new http\Client\Request;

    $request->setRequestUrl('https://api.aylien.com/api/v1/sentiment');
    $request->setRequestMethod('GET');
    $request->setQuery(new http\QueryString(array(
        'text' => 'Meine Handy-Rechnung ist zu hoch!!',
        '' => '',
        'language' => 'de'
    )));

    $request->setHeaders(array(
        'x-aylien-textapi-application-id' => '5830e19e',
        'x-aylien-textapi-application-key' => 'dcb00d991f9cf96640e804ee71681782',
        'content-type' => 'application/json'
    ));

    $client->enqueue($request)->send();
    $response = $client->getResponse();

     $response->getBody();

    return $response.polarity;
}
?>
