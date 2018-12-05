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
        $fulfillment = "Hi from webhookV2";
            break;

        case 'abc':
            $fulfillment = "action: abc";
            break;

        default:

            break;
    }




    $response = new stdClass();
    $response->fulfillmentText = "Hi from webhook";

    echo json_encode($response);

}
else {
    echo "method not allowedOK";

}
?>
