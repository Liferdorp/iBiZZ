<?php

include ("../classes/dbfunctions.php");
include ("../classes/errorlog.php");
//
//
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

$JsonInput = file_get_contents('php://input');
$PostArray = json_decode($JsonInput, true);

$FormAction = $PostArray["action"];

if ($FormAction == "aanmaken") {
    $handicap = number_format(floatval($PostArray["handicap"]),1,".","");
    $gender = trim(strip_tags($PostArray["gender"]));
    $name = trim(strip_tags($PostArray["name"]));

    $Insert = new DataFunctions();
    $Insert->Insert("golf_users",array($name,$gender,$handicap));


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

    $Insert = new DataFunctions();
    $Insert->DeleteSearched("golf_users","id",$PostArray["id"]);
}else if($FormAction == "aanpassen"){
    $handicap = number_format(floatval($PostArray["handicap"]),1,".","");
    $gender = trim(strip_tags($PostArray["gender"]));
    $name = trim(strip_tags($PostArray["name"]));

    $Update = new DataFunctions();
    $Update->Update("golf_users","name",$name,"id",$PostArray["id"]);
    $Update->Update("golf_users","gender",$gender,"id",$PostArray["id"]);
    $Update->Update("golf_users","handicap",$handicap,"id",$PostArray["id"]);

}





?>