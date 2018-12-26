<?php


require_once("vendor/autoload.php");

$method = $_SERVER['REQUEST_METHOD'];

// Überprüfung, ob es sich om 'POST'-Methode handelt

if($method == 'POST'){
    $requestBody = file_get_contents('php://input');
    $json = json_decode($requestBody);

    $text = $json->queryResult->queryText;
    $action = $json->queryResult->action;
    $response = new stdClass();


    switch ($action) {


        case 'input.welcome':

            $fulfillment = "Herzlich willkommen im Chatbot-Support von Handytarife2000. Wobei kann ich Ihnen helfen? 😊";

            break;


        case 'problem_1':

            //problembeschreibung_problem_1

            if (checkSentiment($text) == "negative") { //empathische Reaktion

                $fulfillment = "Verstehe, das würde mich auch ärgern. Ich werfe gerne einen Blick in die aktuelle Rechnung. Um eine Rechnung einsehen zu können, benötige ich zunächst Ihre Kundennummer, die Rechnungsnummer, sowie ihr Geburstjahr zur Authentifizierung. Zunächst die Kundennummer bitte. 😊";

            }
            else {  //Normale Reaktion

                $fulfillment = "Um eine Rechnung einsehen zu können, benötige ich zunächst Ihre Kundennummer, die Rechnungsnummer, sowie ihr Geburstjahr zur Authentifizierung. Zunächst die Kundennummer bitte. 😊";
            }

            break;




        case 'problem_3':

            //Kostenauflistung?_problem_3

            if (checkSentiment($text) == "negative") { //empathische Reaktion

                $fulfillment = "Verstehe, bitte entschuldigen Sie die Verwirrung. Wenn sie möchten, kann ich Ihnen eine genaue Auflistung der Kosten nennen.";
            }
            else {//Normale Reaktion

                $fulfillment = "Wenn sie möchten, kann ich Ihnen eine genaue Auflistung der Kosten nennen.";
            }
            break;


        case 'problem_4':


            //Spiele-Abo Details_problem_4

            if (checkSentiment($text) == "negative") { //empathische Reaktion
                $fulfillment= "Ok, ich sehe das Problem und kann ihren Ärger gut nachvollziehen. Im System steht, dass das Abonnement am 22.12.2018 abgeschlossen wurde.";
            }
            else {

                $fulfillment = "Im System steht, dass das Abonnement am 22.12.2018 abgeschlossen wurde.";
            }
         break;


        default:

            break;
    }


    $response->fulfillmentText = $fulfillment;



    echo json_encode($response);

}
else {
    echo "method not allowed!";

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
