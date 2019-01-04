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

            $fulfillment = "Hallo! Mein Name ist Sarah und ich bin Teil des Kundensupport-Teams von Handytarife2000. Auch wenn ich kein Mensch bin, möchte ich Sie bestmöglich unterstützen. 😊 Wobei kann ich Ihnen helfen?";

            break;


        case 'problem_1':



            //problembeschreibung_problem_1

            if (checkSentiment($text) == "negative") { //empathische Reaktion

                $fulfillment = "Verstehe, das würde mich auch ärgern. Ich werfe gerne einen Blick in die aktuelle Rechnung. Um eine Rechnung einsehen zu können, benötige ich zunächst Ihre Kundennummer, die Rechnungsnummer, sowie ihr Geburstjahr zur Authentifizierung. Bitte teilen Sie mir zunächst Ihre Kundennummer mit. 😊";
                updateDB(1,1);
            }
            else {  //Normale Reaktion

                $fulfillment = "Um eine Rechnung einsehen zu können, benötige ich zunächst Ihre Kundennummer, die Rechnungsnummer, sowie ihr Geburstjahr zur Authentifizierung. Bitte teilen Sie mir zunächst Ihre Kundennummer mit. 😊";
                updateDB(1,0);
            }

            break;




        case 'problem_3':

            //Kostenauflistung?_problem_3

            if (checkSentiment($text) == "negative") { //empathische Reaktion

                $fulfillment = "Verstehe, bitte entschuldigen Sie die Verwirrung. Wenn sie möchten, kann ich Ihnen eine genaue Auflistung der Kosten in diesem Monat nennen.";
                updateDB(2,1);
            }
            else {//Normale Reaktion

                $fulfillment = "Wenn sie möchten, kann ich Ihnen eine genaue Auflistung der Kosten in diesem Monat nennen.";
                updateDB(2,0);
            }
            break;


        case 'problem_4':


            //Spiele-Abo Details_problem_4

            if (checkSentiment($text) == "negative") { //empathische Reaktion
                $fulfillment= "Ok, ich sehe das Problem und kann ihren Ärger gut nachvollziehen. Im System steht, dass das Abonnement am 22.12.2018 abgeschlossen wurde.";
                updateDB(3,1);
            }
            else {

                $fulfillment = "Im System steht, dass das Abonnement am 22.12.2018 abgeschlossen wurde.";
                updateDB(3,0);
            }
         break;

        case 'test':

            $dsn = "pgsql:"
                . "host=ec2-46-137-99-175.eu-west-1.compute.amazonaws.com;"
                . "dbname=de702gpabga2b8;"
                . "user=tyejvoeteqjsrj;"
                . "port=5432;"
                . "sslmode=require;"
                . "password=8190d40158952a0b212121997e2b4dc15d39ebabff5de45d9ddecd59016e15f1";

            $pdo = new PDO($dsn);



            $result = $pdo->prepare("SELECT MAX(tracking_id) FROM tracking");
            $result->execute();
            $currentMax = $result->fetch();
            $cast = intval($currentMax[0]);
            $cast++;
            $fulfillment = $cast;


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

function makeDB($session_id) {

    $dsn = "pgsql:"
        . "host=ec2-46-137-99-175.eu-west-1.compute.amazonaws.com;"
        . "dbname=de702gpabga2b8;"
        . "user=tyejvoeteqjsrj;"
        . "port=5432;"
        . "sslmode=require;"
        . "password=8190d40158952a0b212121997e2b4dc15d39ebabff5de45d9ddecd59016e15f1";

    $pdo2 = new PDO($dsn);
   // $result2 = $pdo2->prepare("INSERT INTO empathie (probanden_id, kp1, kp2, kp3, time) VALUES (?,0,0,?,?)");

    //$result2->execute([$session_id, 1, "asd"]);

    $result2 = $pdo2->prepare("UPDATE empathie SET kp2 =? WHERE probanden_id =?");
    $result2->execute([1, "testdatensatz"]);

    //Funktioniert so
}

function createDB ($session_id) {

    $dsn = "pgsql:"
        . "host=ec2-46-137-99-175.eu-west-1.compute.amazonaws.com;"
        . "dbname=de702gpabga2b8;"
        . "user=tyejvoeteqjsrj;"
        . "port=5432;"
        . "sslmode=require;"
        . "password=8190d40158952a0b212121997e2b4dc15d39ebabff5de45d9ddecd59016e15f1";

    $pdo2 = new PDO($dsn);
    $result2 = $pdo2->prepare("INSERT INTO empathie VALUES (?,?,?,?,?)");

    $date = date("D M d, Y G:i");
    $result2->execute([$session_id, 0,1,0,"$date"]);

    //Funktioniert

}






function updateDB ($KP, $empathic) {


    //Schritt 1: Maximale Tracking_id bestimmen, um für neuen Datensatz einen höhere Tracking ID zu erzeugen
    $dsn = "pgsql:"
        . "host=ec2-46-137-99-175.eu-west-1.compute.amazonaws.com;"
        . "dbname=de702gpabga2b8;"
        . "user=tyejvoeteqjsrj;"
        . "port=5432;"
        . "sslmode=require;"
        . "password=8190d40158952a0b212121997e2b4dc15d39ebabff5de45d9ddecd59016e15f1";

    $pdo = new PDO($dsn);



    $result = $pdo->prepare("SELECT MAX(tracking_id) FROM tracking");
    $result->execute();
    $currentMax = $result->fetch();

    //Datum/Zeit bestimmen
    $date = date("D M d, Y G:i");

    $tracking_id = $currentMax[0]++;

    //Schritt 2 Datensatz erstellen/updaten


        $pdo2 = new PDO($dsn);
        $result2 = $pdo2->prepare("INSERT INTO tracking VALUES (?,?,?,?)");
        $result2->execute([$tracking_id, $KP, $empathic, $date]);


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
