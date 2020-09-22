<?php

include("dbconnection.php");

/**
 * File to do quick PDO functions
 *
 * This file handles quick queries for the PDO database communication.
 * They are standardized database functions which will return specific asked values
 *
 * @category   Database
 * @package    Classes
 * @author     Jessie den Ridder <info@jessiedenridder.nl>
 * @copyright  2018 Jessie den Ridder
 * @license    https://www.RistraBuilder.nl/license/1_0.txt Jessie den Ridder License 1.0
 * @version    0.1
 * @link       http://pear.php.net/package/PackageName
 * @see        NetOther, Net_Sample::Net_Sample()
 * @since      File available since Release 0.1
 */


class DataFunctions{
  public $connection;
  public $toBeReturned;
  public $thisResult;
  public $thisDelete;
  public $result_list;
  public $thisQuery;
  public $connectionClass;


	/**
	 * Function to insert new data in the given tablename. Empty places in the arry will be filled with 'NULL'
	 *
	 * @param string   $tableName    The tablename to insert new values is
	 * @param array    $insertArray  Array of values to insert into the database
	 * 
	 * @throws None
	 * @author Jessie den Ridder <info@jessiedenridder.nl>
	 * @return Nothing
	 */ 
	function Insert($tableName,$insertArray){
		// Define empty variable to form query
		$query = "";
		// Make the start query and add table name
		$query .= "INSERT INTO `".$tableName."` VALUES (0,";

		// Add all the values to the string
		for ($i = 0; $i < count($insertArray); $i++) {
			
				$query .= "?";
			
			if($i < count($insertArray) - 1){
				$query .= ",";
			}
		}
		// End values array
		$query .= ");";
   
    // Make PDO connection
		$PDOconnection = $this->makeConnection();
    // Insert the values in the database


		$this->thisResult = $PDOconnection->prepare($query);
    
    try{
      $this->thisResult->execute($insertArray);
    } catch (\PDOException $e) {
      throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }
    
    // End the PDO connection
		$this->endConnection();
	}
	/**
	 * Function to get all data in a given tablename
	 *
	 * @param string   $tableName    The tablename to get data from
	 * 
	 * @throws None
	 * @author Jessie den Ridder <info@jessiedenridder.nl>
	 * @return Nothing
	 */ 
	function GetAll($tableName){
		$PDOconnection = $this->makeConnection();
		$this->thisResult = $PDOconnection->prepare('SELECT * FROM `' . $tableName . '`');
		$this->thisResult->execute();
		return $this->thisResult;

      // End the PDO connection
		$this->endConnection();
	}
	/**
	 * Function to get all data in a given tablename, sorted by a column name
	 *
	 * @param string   $tableName    The tablename to get data from
	 * @param string   $collumn      The column to sort the data on
	 * @param string   $AscDesc    	 Ordered by. Choose from: ASC DESC
	 * 
	 * @throws None
	 * @author Jessie den Ridder <info@jessiedenridder.nl>
	 * @return Nothing
	 */ 
	function GetAllOrder($tableName,$collumn, $AscDesc)
	{
		$PDOconnection = $this->makeConnection();
		$this->thisResult = $PDOconnection->prepare('SELECT * FROM `' . $tableName . '` ORDER BY `' . $collumn . '` ' . $AscDesc);
		$this->thisResult->execute();
		return $this->thisResult;

		// End the PDO connection
		$this->endConnection();
	}

	
	function Search($tableName,$columName,$searchValue){
      $PDOconnection = $this->makeConnection();
      $this->thisResult = $PDOconnection->prepare('SELECT * FROM `'.$tableName.'` WHERE ' . $columName . ' = ?');
      $this->thisResult->execute([$searchValue]); 
      return $this->thisResult;

      // End the PDO connection
      $this->endConnection();
	}
	
	function SearchMore($tableName,$columArray,$searchArray){
        $PDOconnection = $this->makeConnection();
		
      $query = "SELECT * FROM `".$tableName."` WHERE ";
      if(count($columArray) == count($searchArray)){
              for($i=0; $i<count($columArray);$i++) {
                  $query .= $columArray[$i]." = ?";
          if($i < count($columArray) - 1){
                      $query .= " AND ";
          }
        }
      $query .= ";";

      $this->thisResult = $PDOconnection->prepare($query);
      $this->thisResult->execute($searchArray);
      return $this->thisResult;
		}else{
			return "The search array(".$searchArray.") does not match the columnarray(".count($columArray).")";
		}
    
    // End the PDO connection
		$this->endConnection();
	}

	function Update($tableName, $columName, $newValue, $columSearchname, $searchValue){
		$PDOconnection = $this->makeConnection();
		$this->thisResult = $PDOconnection->prepare('UPDATE `' . $tableName . '`  SET '.$columName.' = ? WHERE ' . $columSearchname . ' = ?');
		$this->thisResult->execute([$newValue, $searchValue]);
		return $this->thisResult->rowCount();
    
    // End the PDO connection
		$this->endConnection();
	}
	
	function DeleteSearched($tableName,$columName,$searchValue){
    $PDOconnection = $this->makeConnection();
    $this->thisResult = $PDOconnection->prepare('DELETE FROM `' . $tableName . '` WHERE ' . $columName . ' = ?');
    $this->thisResult->execute([$searchValue]);
    return $this->thisResult->rowCount();
    
    // End the PDO connection
		$this->endConnection();
	}
	
	function DoCustomQuery($CustomQuery){
    $PDOconnection = $this->makeConnection();
    $this->thisResult = $PDOconnection->query($CustomQuery);
    return $this->thisResult;
    
    // End the PDO connection
		$this->endConnection();
	}
	
	
	function FetchDbArray(){
    $result_list = array();
    while ($row = $this->thisResult->fetch()) {
        $result_list[] = $row;
    }
		return $result_list;
	}
	
	function makeConnection(){
		$this->connectionClass = new dbConnect();
		$PDOconnection = $this->connectionClass->makeConnection();
		return $PDOconnection;
		
	}
  
    function endConnection(){
			$this->connectionClass->closeConnection();
			$PDOconnection = null;
		}


}



?>