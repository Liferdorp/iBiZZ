<?php

include (__DIR__."/classes/dbfunctions.php");
include (__DIR__."/classes/errorlog.php");
include (__DIR__."/classes/flights.php");

$errorLog = new errorlog();


?>

<div class="userManagement">
    <a href="index.php">Home</a>
    <a href="users.php">Gebruikers</a>
    <a href="flights.php">Flights</a>
</div>

    <h1>Flights</h1>
    <hr/>
    <?php


    $GetAll = new DataFunctions();
    $GetAll->GetAll("golf_users");
    $Result = $GetAll->FetchDbArray();

    $flightsClass = new flights();
    $flightResult = $flightsClass->getFlights($Result);

    echo "<div id='flightDiv'>";

    for ($i=0; $i < count($flightResult);$i++) {         
        echo "<div id='flightBlock'>";

        foreach ($flightResult[$i] as $key => $value) {
            if(is_numeric($key)){            
                echo "<p><strong>". $value["name"] ."</strong> met een handicap van: <strong>" . number_format(floatval($value["handicap"]),1,",","") . "</strong></p>";

            }else{
                if($key == "totalHandicap"){
                    echo "<p>De totale handicap is: <strong>" . number_format(floatval($value),1,",","") . "</strong></p>";
                }else{
                    echo "<p>De gemiddelde handicap is: <strong>" . number_format(floatval($value),1,",","") . "</strong></p>";
                }
            }
        }
 
        echo "</div>";
        echo "<hr />";
    }

    echo "</div>";
    echo "</pre>";
