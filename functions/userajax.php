<?php

if(!class_exists("dbfunctions")){
    include ("../classes/dbfunctions.php");
}
if(!class_exists("errorlog")){
    include ("../classes/errorlog.php");
}

$errorLog = new errorlog();

$JsonInput = file_get_contents('php://input');
$PostArray = json_decode($JsonInput, true);

$FormAction = $PostArray["action"];

$errorLog->Log("Aangeroepen user actie[".$PostArray["action"]."]");

if ($FormAction == "aanmaken") {
    $handicap = number_format(floatval($PostArray["handicap"]),1,".","");
    $gender = trim(strip_tags($PostArray["gender"]));
    $name = trim(strip_tags($PostArray["name"]));

    $Insert = new DataFunctions();
    $Insert->Insert("golf_users",array($name,$gender,$handicap));

    $errorLog->Log("Gebruiker toegevoegd [".$PostArray["name"]."]");


}else if($FormAction == "renderUsers"){


    $return = "";
    $GetAll = new DataFunctions();
    $GetAll->GetAll("golf_users");
    $Result = $GetAll->FetchDbArray();

    for ($i = 0; $i < count($Result); $i++) {
        $return .= "<p>";
        $return .= "<input type=\"text\" id=\"name_".$Result[$i]["id"]."\" value=\"".$Result[$i]["name"]."\" placeholder=\"Naam\"/>";
        $return .= "<select id=\"gender_".$Result[$i]["id"]."\" placeholder=\"Geslacht\"/>";

        $return .= "<option value=\"m\"";
        if($Result[$i]["gender"] == "m"){
            $return .= " selected ";
        }
        $return .= ">Man</option>";
        $return .= "<option value=\"f\"";
        if($Result[$i]["gender"] == "f"){
            $return .= " selected ";
        }
        $return .= ">Vrouw</option>";
        $return .= "</select>";
        $return .= "<input type=\"text\" value=\"".number_format(floatval($Result[$i]["handicap"]),1,",","")."\" id=\"handicap_".$Result[$i]["id"]."\" placeholder=\"Handicap\"/>";
        $onclickChange = "userfunctions('".$Result[$i]['id']."','aanpassen')";
        $return .= "<button onclick=\"".$onclickChange."\">Aanpassen</button>";
        $onclickDelete = "userfunctions('".$Result[$i]['id']."','verwijderen')";

        $return .= "<button onclick=\"".$onclickDelete."\">Verwijderen</button>";
        $return .= "</p>";
    }

    echo $return;

}else if($FormAction == "verwijderen"){


    $GetAll = new DataFunctions();
    $GetAll->Search("golf_users","id",$PostArray["id"]);
    $Result = $GetAll->FetchDbArray();


    $Insert = new DataFunctions();
    $Insert->DeleteSearched("golf_users","id",$PostArray["id"]);


    $errorLog->Log("Gebruiker verwijderd [".$Result[0]["name"]."]");
}else if($FormAction == "aanpassen"){
    $handicap = number_format(floatval($PostArray["handicap"]),1,".","");
    $gender = trim(strip_tags($PostArray["gender"]));
    $name = trim(strip_tags($PostArray["name"]));

    $Update = new DataFunctions();
    $Update->Update("golf_users","name",$name,"id",$PostArray["id"]);
    $Update->Update("golf_users","gender",$gender,"id",$PostArray["id"]);
    $Update->Update("golf_users","handicap",$handicap,"id",$PostArray["id"]);

    
    $errorLog->Log("Gebruiker aangepast [".$name."]");

}





?>