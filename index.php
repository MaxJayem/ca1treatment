<?php


require_once("vendor/autoload.php");

$method = $_SERVER['REQUEST_METHOD'];

// Überprüfung, ob es sich om 'POST'-Methode handelt

if($method == 'POST'){
    $requestBody = file_get_contents('php://input');
    $json = json_decode($requestBody);

    $text = $json->queryResult->queryText;
    $action = $json->queryResult->action;


    //Session bestimmen
    $session =  $json->session;
    $session_id = substr($session, 37);


    $response = new stdClass();





    switch ($action) {


        case 'input.welcome':

            $fulfillment = "Hallo! Mein Name ist Sarah und ich bin Teil des Kundensupport-Teams von Handytarife2000. Auch wenn ich kein Mensch bin, möchte ich Sie bestmöglich unterstützen. 😊 Wobei kann ich Ihnen helfen?";

            break;


        case 'problem_1':



            //problembeschreibung_problem_1

            if (checkSentiment($text) == "negative") { //empathische Reaktion

                $fulfillment = "Verstehe, das würde mich auch ärgern. Ich werfe gerne einen Blick in die aktuelle Rechnung. Um eine Rechnung einsehen zu können, benötige ich zunächst Ihre Kundennummer, die Rechnungsnummer, sowie ihr Geburstjahr zur Authentifizierung. Bitte teilen Sie mir zunächst Ihre Kundennummer mit. 😊";
                updateDB($session, 1, 1);
            }
            else {  //Normale Reaktion

                $fulfillment = "Um eine Rechnung einsehen zu können, benötige ich zunächst Ihre Kundennummer, die Rechnungsnummer, sowie ihr Geburstjahr zur Authentifizierung. Bitte teilen Sie mir zunächst Ihre Kundennummer mit. 😊";
                updateDB($session, 1, 0);
            }

            break;




        case 'problem_3':

            //Kostenauflistung?_problem_3

            if (checkSentiment($text) == "negative") { //empathische Reaktion

                $fulfillment = "Verstehe, bitte entschuldigen Sie die Verwirrung. Wenn sie möchten, kann ich Ihnen eine genaue Auflistung der Kosten in diesem Monat nennen.";
                updateDB($session, 2, 1);
            }
            else {//Normale Reaktion

                $fulfillment = "Wenn sie möchten, kann ich Ihnen eine genaue Auflistung der Kosten in diesem Monat nennen.";
                updateDB($session, 2, 0);
            }
            break;


        case 'problem_4':


            //Spiele-Abo Details_problem_4

            if (checkSentiment($text) == "negative") { //empathische Reaktion
                $fulfillment= "Ok, ich sehe das Problem und kann ihren Ärger gut nachvollziehen. Im System steht, dass das Abonnement am 22.12.2018 abgeschlossen wurde.";
                updateDB($session, 3, 1);
            }
            else {

                $fulfillment = "Im System steht, dass das Abonnement am 22.12.2018 abgeschlossen wurde.";
                updateDB($session, 3, 0);
            }
         break;

        case 'test':
            $session =  $json->session;
            $session_id = substr($session, 37);
            $fulfillment = updateDB($session, 3, 0);
            break;


        default:

            break;
    }


    $response->fulfillmentText = $fulfillment;



    echo json_encode($response);

}
else {
   echo "Ergebnis:";



    $dsn = "pgsql:"
        . "host=ec2-46-137-99-175.eu-west-1.compute.amazonaws.com;"
        . "dbname=de702gpabga2b8;"
        . "user=tyejvoeteqjsrj;"
        . "port=5432;"
        . "sslmode=require;"
        . "password=8190d40158952a0b212121997e2b4dc15d39ebabff5de45d9ddecd59016e15f1";

    $db = new PDO($dsn);

    $query = "SELECT probanden_id "
        . "FROM empathie WHERE probanden_id = testdatensatz";

    $result = $db->query($query);

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

            echo "<p>" . $row["probanden_id"] . "</p>";
        }

    $result->closeCursor();


}

function updateDB ($session_id, $KP, $empathic) {
    //session_id wird als probanden_id übernommen
    //KP gibt an, an welchem Konversationspunkt man ist [1,2,3]
    //empathic ist boolean (1= empathische Antwort, 0 = normale Antwort)


    //Schitt 1: Überprüfen, ob Datensatz schon vorhanden

    $dsn = "pgsql:"
        . "host=ec2-46-137-99-175.eu-west-1.compute.amazonaws.com;"
        . "dbname=de702gpabga2b8;"
        . "user=tyejvoeteqjsrj;"
        . "port=5432;"
        . "sslmode=require;"
        . "password=8190d40158952a0b212121997e2b4dc15d39ebabff5de45d9ddecd59016e15f1";

    $pdo = new PDO($dsn);

    $query = "SELECT probanden_id "
        . "FROM empathie WHERE probanden_id =testdatensatz"; // .$session_id;

    $result = $pdo->query($query);
    $checkID = $result->fetch();





    return $checkID;

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
