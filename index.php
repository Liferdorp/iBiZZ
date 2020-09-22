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

    <h1>Home</h1>
    <hr/>

    <p>Welkom in de Texas scramble tool.</p>
    <p>Klik op gebruikers om personen toe te voegen of wijzigen</p>
    <p>Klik op flights om een tournooi te genereren</p>

