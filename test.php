<?php
$response = new JsonResponse([                  //Erstelle Json-Objekt "Response" mit allen Attributen (z.B. fulfillmentText)

    "fulfillmentMessages" =>[
        [
            "platform" => "ACTIONS_ON_GOOGLE",
            "simpleResponses" => [
                "simpleResponses" =>[
                    [
                        "textToSpeech" => $fulfillment
                    ]
                ]
            ]
        ],
        [
            "platform" => "ACTIONS_ON_GOOGLE",
            "basicCard" => [
                //"title" => "" ,
                // "subtitle" => "subtitle",
                "formattedText" => "Dein Tarif",
                "image" => [
                    "imageUri" => $img,
                    "accessibilityText" => "dein Tarif"
                ],
                "buttons" =>[
                    [
                        "title" => "Easy-SIM",
                        "openUriAction" => [
                            "uri" => $img
                        ]
                    ]
                ]
            ]
        ],
        [
            "platform" => "ACTIONS_ON_GOOGLE",
            "simpleResponses" => [
                "simpleResponses" =>[
                    [
                        "textToSpeech" => "$beschreibung"
                    ]
                ]
            ]
        ],
        [
            "platform" => "ACTIONS_ON_GOOGLE",
            "basicCard" => [
                //"title" => "" ,
                // "subtitle" => "subtitle",
                "formattedText" => "zum Fragebogen",
                "image" => [
                    "imageUri" => "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRoSmX40Ybtu2rCiahTDGdIs0_uZtJyUVykjZbAqIpGGl6MXogz",
                    "accessibilityText" => "zum Fragebogen"
                ],
                "buttons" =>[
                    [
                        "title" => "zum Fragebogen",
                        "openUriAction" => [
                            "uri" => $survey
                        ]
                    ]
                ]
            ]
        ],
        [
            "text" =>
                [
                    "text" => [
                        $fulfillment
                    ]
                ]
        ]

    ],
]);
return $response;