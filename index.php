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

    $request = new HttpRequest();
    $request->setUrl('https://api.aylien.com/api/v1/sentiment');
    $request->setMethod(HTTP_METH_GET);

    $request->setQueryData(array(
        'text' => 'Warum%20ist%20mein%20Vertrag%20so%20teuer?',
        'language' => 'de'
    ));

    $request->setHeaders(array(
        'Postman-Token' => 'ccbd8a69-3127-4edf-9821-8ec5254682cf',
        'cache-control' => 'no-cache',
        'X-AYLIEN-TextAPI-Application-ID' => '5830e19e',
        'X-AYLIEN-TextAPI-Application-Key' => 'dcb00d991f9cf96640e804ee71681782'
    ));

    try {
        $response1 = $request->send();

        return "Hallo";
    } catch (HttpException $ex) {
        return $ex;
    }


}
?>
