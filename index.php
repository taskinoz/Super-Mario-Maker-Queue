<?php
// Include Keys
include "config.php";

// Queue File
$queue = "queue.json";
$queueData = new \stdClass(); //Avoid Errors
$currentData = new \stdClass(); //Avoid Errors

// Check for valid SMM ID
// e.g XXX-XXX-XXX
function checkID($r){
	if (strlen($r)==11&&$r[3]=="-"&&$r[7]=="-"){
		return true;
	}
	else {
		return false;
	}
}

//Get requests
if ((isset($_GET['name']) || isset($_GET['code'])) && isset($_GET['key'])){
	if ($_GET['key']===$key){
		$name = $_GET['name'];
		$code = $_GET['code'];
		// Check ID
		if (checkID($code)){
			// Write File
      if (file_exists($queue)) {
        //Set $queueData to the JSON data
        $queueData = json_decode(file_get_contents($queue));
      }
      else {
        //Create File
        fopen($queue, 'w') or die('Cannot open file:  '.$queue); //implicitly creates file
      }

      //Create JSON Objects
      $currentData->name = $name;
      $currentData->code = $code;
      $queueData->level = $currentData;
      //$queueData->test = $currentData;
      //Encode JSON
      $queueData = json_encode($queueData, JSON_PRETTY_PRINT);
      //Write JSON
      $currentData=fopen($queue, 'w') or die('Cannot open file:  '.$queue); //implicitly creates fil
      fwrite($currentData, $queueData);
      fclose($currentData);

			echo "Your level has been added to the queue";
		}
		else{
			echo "That is not a valid level ID";
		}
	}
	else{
		echo "Incorrect API key";
	}
}
else{
// Show HTML
?>
<html>
<h1>SMM</h1>
</html>
<?php
}
