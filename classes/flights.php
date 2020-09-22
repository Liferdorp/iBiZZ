<?php

include ("users.php");

class flights{

    function getFlights(array $golfers){


        $golfersOnHandicap = $golfers;
        usort($golfersOnHandicap, "my_cmp");

        function my_cmp($a, $b) {
            if ($a->handicap == $b->handicap) {
                return 0;
            }
            return ($a->handicap < $b->handicap) ? -1 : 1;
        }

        $flights = array();

        return $flights;
    }

    private function randGroup(){
        $peopleInGroup = rand(2,4);
        return $peopleInGroup;
    }

}

?>