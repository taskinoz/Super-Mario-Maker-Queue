<?php
// Include Keys
include "config.php";

// Queue File
$file = "queue.json";
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
	// Check if key matches
	if ($_GET['key']===$key){
		$name = $_GET['name'];
		$code = $_GET['code'];
		// Check ID
		if (checkID($code)){
			// Write File
      if (file_exists($file)) {
        //Set $queueData to the JSON data
				$raw = file_get_contents($file);
        $queueData = json_decode($raw);
				$order = (count(json_decode($raw,true)))+1;
      }
      else {
        //Create File
        fopen($file, 'w') or die('Cannot open file:  '.$file); //implicitly creates file
				$order = 1;
      }

      //Create JSON Objects
      $currentData->name = $name;
      $currentData->code = $code;
      $queueData->$order = $currentData;

      //Encode JSON
      $queueJSON = json_encode($queueData, JSON_PRETTY_PRINT);

      //Write JSON
			$jsonFile = fopen($file,'w') or die('Cannot open file:  '.$file); //implicitly creates file
      fwrite($jsonFile,$queueJSON);
      fclose($jsonFile);

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
		<head>
			<script
			src="https://code.jquery.com/jquery-3.3.1.min.js"
			integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
			crossorigin="anonymous"></script>
			<script type="text/javascript">
				$(document).ready(function() {
				var g=new Date();
				function getData() {
					$.ajax({
						url: "/queue.json?"+g.getSeconds(),
						context: document.body,
						queue: "data"
					}).done(function(queue) {
						// Code
						$('.code').remove();
						var count = Object.keys(queue).length;
						for (var i = 1; i < count+1; i++) {
							$('.codes').append('<div class="code"><span class="name">'+queue[i].name+'</span> - <span class="level">'+queue[i].code+'</span>')
						}
					});
				}
				setInterval(function () {
					getData();
				},10000);
				getData()
			});
			</script>
			<style>
				/* RESET */
				html,body{border:0;padding:0;margin:0;font-family:Arial;counter-reset:a}
				h1{margin:5px 0;}
				.codes{text-transform:uppercase}
				.codes:empty::before{content:"There are no levels in the Queue";text-transform: none}
				.code:first-child{font-size:1.2em}
				.code::before{
					counter-increment: a;
					content: counter(a) ") ";
				}
			</style>
		</head>
		<body>
			<header>
				<h1>Level Queue</h1>
			</header>
			<div class="container">
				<div class="codes"></div>
			</div>
		</body>
	</html>
	<?php
}
