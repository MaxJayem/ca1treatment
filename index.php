<?php


require_once("vendor/autoload.php");

$method = $_SERVER['REQUEST_METHOD'];

// Process only when method is POST
if($method == 'POST'){
    $requestBody = file_get_contents('php://input');
    $json = json_decode($requestBody);

    $text = $json->queryResult->queryText;
    $action = $json->queryResult->action;
    $response = new stdClass();


    switch ($action) {


        case 'input.welcome':

            $fulfillment = "Herzlich willkommen im Chatbot-Support von HandyDiscounter2000. Wobei kann ich Ihnen helfen? ;)";

            break;


        case 'problem_1':


            if (checkSentiment($text) == "negative") { //empathische Reaktion

                $fulfillment = "Verstehe, das würde mich auch ärgern. Ich werfe gerne einen Blick in die aktuelle Rechnung. 
                                Um eine Rechnung einsehen zu können, benötige ich zunächst Ihre Kundennummer, 
                                die Rechnungsnummer, sowie ihr Geburtsdatum zur Authentifizierung. Zunächst die 
                                Kundennummer bitte. 😊";
            }
            else {  //Normale Reaktion

                $fulfillment = "Um eine Rechnung einsehen zu können, benötige ich zunächst Ihre Kundennummer, 
                                die Rechnungsnummer, sowie ihr Geburtsdatum zur Authentifizierung. Zunächst die 
                                Kundennummer bitte. 😊";
            }

            break;


        case 'problem_2':

            $fulfillment = "Vielen Dank. Ich habe die Rechnung vor mir, der Rechnungsbetrag für den aktuellen Monat beläuft sich auf 42,99€.(inkl. MwSt.)";

            break;


        case 'problem_3':

            if (checkSentiment($text) == "negative") { //empathische Reaktion

                $fulfillment = "Verstehe, bitte entschuldigen Sie die Verwirrung. Wenn sie möchten, kann ich Ihnen eine genaue Auflistung der Kosten nennen.";
            }
            else {//Normale Reaktion

                $fulfillment = "Wenn sie möchten, kann ich Ihnen eine genaue Auflistung der Kosten nennen.";
            }
            break;


        case 'problem_4':

            if (checkSentiment($text) == "negative") { //empathische Reaktion
                $fulfillment= "Ok, ich sehe das Problem und kann ihren Ärger nachvollziehen. Im System steht, dass das Abo am 22.02. abgeschlossen wurde.";
            }
            else {

                $fulfillment = "Im System steht, dass das Abo am 22.02. abgeschlossen wurde.";
            }
         break;

        case 'problem_5':

            if (checkSentiment($text) == "negative") { //empathische Reaktion
                $fulfillment= "Ich kann Ihnen bei dem Anliegen leider nicht helfen, und leite Sie nun an einen unserer Servicemitarbeiter weiter.
                               Dieser kann für sie eine Drittanbietersperre einrichten, damit keine weiteren Zusatzleistungen gebucht werden können. ";
            }
            else {

                $fulfillment = "Ich kann Ihre Verärgerung sehr gut nachvollziehen, und denke, dass ich Ihnen leider nicht bei Ihrem Anliegen helfen kann. Ich leite Sie nun an einen unserer Servicemitarbeiter weiter.
                                Dieser kann für sie eine Drittanbietersperre einrichten,
                                damit keine weiteren Zusatzleistungen gebucht werden können.";
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
