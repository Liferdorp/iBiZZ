<?php

class flights{

	/**
	 * Give a list of golfers per flight
	 *
	 * @param array    $golfers The golfers to organize
	 
	 * 
	 * @throws None
	 * @author Jessie den Ridder <info@jessiedenridder.nl>
	 * @return array flights with golfers, average handicap and playing handicap
	 */ 
    function getFlights(array $golfers) : array{

        
        // Shuffle the array to randomize.
        shuffle($golfers);

        // Define two arrays to get put golfers in.
        $golf1 = array();
        $golf2 = array();
        
        // Loop through golfers and place in array 1 or 2
        for ($gf=0; $gf < count($golfers); $gf++) { 
            if($gf % 2 == 0){
                array_push($golf1,$golfers[$gf]);
            }else{
                array_push($golf2,$golfers[$gf]);
            }
        }

        // Sort both arrays on handicap
        usort($golf1, function($a, $b) {
            return $b['handicap'] <=> $a['handicap'];
        });

        usort($golf2, function($a, $b) {
            return $b['handicap'] <=> $a['handicap'];
        });

      
        // Make flights of each split array
        $flights1 = $this->makeFlights($golf1);

        $flights2 = $this->makeFlights($golf2);


        // Define empty flights
        $flights = array();

        // merge both flight arrays
        $mergeArray = array_merge($flights1, $flights2);
        
        // Put merge array in flights

        $flights = $mergeArray;

        return $flights;
    }

    /**
	 * Generate random number
	 * 
	 * @throws None
	 * @author Jessie den Ridder <info@jessiedenridder.nl>
	 * @return int A random number consisting of 2, 3 or 4
	 */ 
    private function randNumber() : int{
        $peopleInGroup = rand(2,4);
        return $peopleInGroup;
    }


    /**
	 * Function to put golfers in a flight
     * 
     * This function is designed to put golfers in flight teams of 2, 3 or 4 golfers.
	 *
	 * @param array    $golfArray  Array of golfers to put in a flight
	 * 
	 * @throws None
	 * @author Jessie den Ridder <info@jessiedenridder.nl>
	 * @return array array of the flights made by the give array
	 */ 

    private function makeFlights(array $golfArray)  : array{

        // Define variables
        $returnArray = array();
        $i = 0;
        $left = count($golfArray);
        while( $i < count($golfArray)) {

            $randomNumber = $this->randNumber();

            // Check if the randomnumber is not mare than there are left, and if it will not leave only one contestand
            if(intval($randomNumber) >= intval($left) || ($left - $randomNumber) < 2){
           
                // put last results in temp array
                $tempArray = $golfArray;

                // Calculate the handicap of the flight
                $handicap = $this->calculateHandicap($tempArray);
                $averageHandicap = $this->calculateAverageHandicap($tempArray);

                // add handicap to array
                $tempArray["totalHandicap"] = $handicap;
                $tempArray["averageHandicap"] = $averageHandicap;
                
                // add temp array to final array
                $returnArray[] = $tempArray;
                break;
                
            }else{

                $tempArray = array();

                if($randomNumber == 2){
                    // Check if lenght is just right
                    if($left == 2){
                        // put last results in temp array
                        $tempArray = $golfArray;

                          // Calculate the handicap of the flight
                          $handicap = $this->calculateHandicap($tempArray);
                          $averageHandicap = $this->calculateAverageHandicap($tempArray);
          
                          // add handicap to array
                          $tempArray["totalHandicap"] = $handicap;
                          $tempArray["averageHandicap"] = $averageHandicap;
                        
                        // add temp array to final array
                        $returnArray[] = $tempArray;
                    }else{
                        // Place in temp array
                        array_push($tempArray,$golfArray[0]);
                        // Remove used key
                        unset($golfArray[0]);
                        // Flip array to get last key
                        array_reverse($golfArray);
                        // Reindex
                        $golfArray = array_values($golfArray);
                        // Sort ascending
                        usort($golfArray, function($a, $b) {
                            return $a['handicap'] <=> $b['handicap'];
                        });
                        // Place in temp array
                        array_push($tempArray,$golfArray[0]);
                        // Remove used key
                        unset($golfArray[0]);
                        // Reindex
                        $golfArray = array_values($golfArray);
                        // Put back to descending
                        usort($golfArray, function($a, $b) {
                            return $b['handicap'] <=> $a['handicap'];
                        });
                        // Update how many are left
                        $left = $left - $randomNumber;
                        
                        // Sort temp array before push to handicap asc
                        usort($tempArray, function($a, $b) {
                            return $a['handicap'] <=> $b['handicap'];
                        });
                        
                        // Calculate the handicap of the flight

                        // Calculate the handicap of the flight
                        $handicap = $this->calculateHandicap($tempArray);
                        $averageHandicap = $this->calculateAverageHandicap($tempArray);
        
                        // add handicap to array
                        $tempArray["totalHandicap"] = $handicap;
                        $tempArray["averageHandicap"] = $averageHandicap;

                        // add temp array to final array
                        $returnArray[] = $tempArray;
                        // Empty temp array
                        unset($tempArray);
                    }
                }else if($randomNumber == 3){
                    // Check if lenght is just right
                    if($left == 3){
                        // put last results in temp array
                        $tempArray = $golfArray;

                        // Calculate the handicap of the flight
                        $handicap = $this->calculateHandicap($tempArray);
                        $averageHandicap = $this->calculateAverageHandicap($tempArray);
        
                        // add handicap to array
                        $tempArray["totalHandicap"] = $handicap;
                        $tempArray["averageHandicap"] = $averageHandicap;
                        
                        // add temp array to final array
                        $returnArray[] = $tempArray;
                    }else{
                        // Get middle of array
                        $middleIndex = floor(count($golfArray) / 2);
                        // Place in temp array
                        array_push($tempArray,$golfArray[0]);
                        // Remove used key
                        unset($golfArray[0]);
                        // Place in temp array
                        array_push($tempArray,$golfArray[$middleIndex]);
                        // Remove used key
                        unset($golfArray[$middleIndex]);
                        // Flip array to get last key
                        array_reverse($golfArray);
                        // Reindex
                        $golfArray = array_values($golfArray);
                        // Sort ascending
                        usort($golfArray, function($a, $b) {
                            return $a['handicap'] <=> $b['handicap'];
                        });
                        // Place in temp array
                        array_push($tempArray,$golfArray[0]);
                        // Remove used key
                        unset($golfArray[0]);
                        $golfArray = array_values($golfArray);
                        // Put back to descending
                        usort($golfArray, function($a, $b) {
                            return $b['handicap'] <=> $a['handicap'];
                        });
                        // Update how many are left
                        $left = $left - $randomNumber;
                        
                        // Sort temp array before push to handicap asc
                        usort($tempArray, function($a, $b) {
                            return $a['handicap'] <=> $b['handicap'];
                        });
                        
                        // Calculate the handicap of the flight
                        $handicap = $this->calculateHandicap($tempArray);
                        $averageHandicap = $this->calculateAverageHandicap($tempArray);

                        // add handicap to array
                        $tempArray["totalHandicap"] = $handicap;
                        $tempArray["averageHandicap"] = $averageHandicap;

                        // add temp array to final array
                        $returnArray[] = $tempArray;
                         // Empty temp array
                        unset($tempArray);
                    }
                }else if($randomNumber == 4){
                    // Check if lenght is just right
                    if($left == 4){
                        // put last results in temp array
                        $tempArray = $golfArray;

                        // Calculate the handicap of the flight
                        $handicap = $this->calculateHandicap($tempArray);
                        $averageHandicap = $this->calculateAverageHandicap($tempArray);

                        // add handicap to array
                        $tempArray["totalHandicap"] = $handicap;
                        $tempArray["averageHandicap"] = $averageHandicap;
                        
                        // add temp array to final array
                        $returnArray[] = $tempArray;

                    }else{
                        // Place in temp array
                        array_push($tempArray,$golfArray[0]);
                        // Remove used key
                        unset($golfArray[0]);
                        // Flip array to get last key
                        array_reverse($golfArray);
                        // Reindex
                        $golfArray = array_values($golfArray);
                        // Sort ascending
                        usort($golfArray, function($a, $b) {
                            return $a['handicap'] <=> $b['handicap'];
                        });
                        // Place in temp array
                        array_push($tempArray,$golfArray[0]);
                        // Remove used key
                        unset($golfArray[0]);
                        // Reindex
                        $golfArray = array_values($golfArray);
                        // Put back to descending
                        usort($golfArray, function($a, $b) {
                            return $b['handicap'] <=> $a['handicap'];
                        });
                        // Place in temp array
                        array_push($tempArray,$golfArray[0]);
                        // Remove used key
                        unset($golfArray[0]);
                        // Flip array to get last key
                        array_reverse($golfArray);
                        // Reindex
                        $golfArray = array_values($golfArray);
                        // Sort ascending
                        usort($golfArray, function($a, $b) {
                            return $a['handicap'] <=> $b['handicap'];
                        });
                        // Place in temp array
                        array_push($tempArray,$golfArray[0]);
                        // Remove used key
                        unset($golfArray[0]);
                        // Reindex
                        $golfArray = array_values($golfArray);
                        // Put back to descending
                        usort($golfArray, function($a, $b) {
                            return $b['handicap'] <=> $a['handicap'];
                        });
                        // Update how many are left
                        $left = $left - $randomNumber;

                        // Sort temp array before push to handicap asc
                        usort($tempArray, function($a, $b) {
                            return $a['handicap'] <=> $b['handicap'];
                        });

                        // Calculate the handicap of the flight
                        $handicap = $this->calculateHandicap($tempArray);
                        $averageHandicap = $this->calculateAverageHandicap($tempArray);

                        // add handicap to array
                        $tempArray["totalHandicap"] = $handicap;
                        $tempArray["averageHandicap"] = $averageHandicap;
                        
                        // add temp array to final array
                        $returnArray[] = $tempArray;
                        // Empty temp array
                        unset($tempArray);
                    }
                }else{
                    break;
                }

                
            }
        }

        return $returnArray;
        
    }

    /**
     * Function to calculate playing handicap of a flight
     *
     * @param array    $handicapArray  Flight array to calculate handicap from
     * 
     * @throws None
     * @author Jessie den Ridder <info@jessiedenridder.nl>
     * @return int the playing handicap of the flight
	 */ 


    private function calculateHandicap(array $handicapArray) : int{

        // Get the last key. Handicap is ascending. Last key is highest.

        $lastKey = key(array_slice($handicapArray, -1, 1, true));

        // Highest handicap
        $hightestHandicap = $handicapArray[$lastKey]["handicap"];

        // Remove the highest handicap from array
        unset($handicapArray[$lastKey]);

        // count rest of total handicap
        $restOfHandicap = 0;
        for ($roh=0; $roh < count($handicapArray); $roh++) { 
            $restOfHandicap = $restOfHandicap + $handicapArray[$roh]["handicap"];
        }

        // Calculate total handicap
        $totalHandicap = $restOfHandicap * 0.1 + $hightestHandicap * 0.5;

        return $totalHandicap;

    }


        /**
     * Function to calculate average handicap of a flight
     *
     * @param array    $handicapArray  Flight array to calculate handicap from
     * 
     * @throws None
     * @author Jessie den Ridder <info@jessiedenridder.nl>
     * @return int the average handicap of the flight
	 */ 

    private function calculateAverageHandicap(array $handicapArray) : int{
        $handicap = 0;

        for ($roh=0; $roh < count($handicapArray); $roh++) { 
            $handicap = $handicap + $handicapArray[$roh]["handicap"];
        }

        // Calculate total handicap
        $averageHandicap = $handicap / (count($handicapArray));

        return $averageHandicap;

    }

}

?>