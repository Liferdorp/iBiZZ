<?php

include (__DIR__."/classes/dbfunctions.php");
include (__DIR__."/classes/errorlog.php");


//$errorLog = new errorlog();
//$errorLog->Log();


?>

    <head xmlns="http://www.w3.org/1999/html">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <script src="js/userajax.js"></script>
    </head>

    <div class="userManagement">
        <a href="index.php">Home</a>
        <a href="users.php">Gebruikers</a>
        <a href="flights.php">Flights</a>
    </div>

    <h1>Gebruikers</h1>
    <hr/>
    <div class="userManagement">
        <h1>Alle gebruikers:</h1>
        <div id="userContentFrame">
            <script>
                $(function() {
                    userfunctions('','renderUsers');
                });
            </script>

        </div>

        <div>
            <h1>Maak nieuwe gebruiker</h1>
            <p><input type="text" id="name" placeholder="Naam"/></p>
            <p><select id="gender" placeholder="Geslacht"/>
                <option value="m">Man</option>
                <option value="f">Vrouw</option>
            </select></p>
            <p><input type="text" id="handicap" placeholder="Handicap"/></p>
            <p><button onclick="userfunctions('','aanmaken');">Aanmaken</button></p>
        </div>
    </div>

<?php


