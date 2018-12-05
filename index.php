<?php

$method = $_SERVER['REQUEST'];

//Processes only when method is POST
if ($method == "POST") {

    $requestBody = file_get_contents('php://input');
    $json =  json_decode($requestBody);

    $text = $json->queryResult->queryText;
    $action = $json->queryResult->action;

    switch ($action) {

        case 'testaction':
        $fulfillment = "Hi from webhook";
            break;

        case 'abc':
            $fulfillment = "abc";
            break;

        default:

            break;
    }
    $response = new \stdClass();
    $response->fulfillmentText ="Hall0";
    $response->displayText = "";
    $response->source = "webhook";
    echo json_encode($response);
}
else {
    echo"method not allowed";

}
?>