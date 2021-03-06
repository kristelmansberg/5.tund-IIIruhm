<?php
	//functions.php
	require("../../config.php");
	
	//et saab kasutada $_SESSION muutujaid
	//kõigis failides, mis on selle failiga seotud
	session_start();
	
	
	$database = "if16_kristelg";
		
	//var_dump($GLOBALS);
	
	function signup($email, $password){
		
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
				
		$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password) VALUES (?, ?)");
		echo $mysqli->error;
		
		$stmt->bind_param("ss", $email, $password );
		
		if($stmt->execute() ){
			echo "salvestamine õnnestus";
			
		} else {
			
			echo "ERROR".$stmt->error;
			
		}
		
	}
		
	function login ($email, $password){
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("
		
			SELECT id, email, password, created
			FROM user_sample
			WHERE email = ?
	
		");
		//asendan küsimärgi
		$stmt->bind_param("s", $email);
		
		//määran muutujad reale, mis kätte saan
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb, $created);
		
		$stmt->execute();
		
		$notice= " ";
		//ainult SELECTI'i puhul
		if ($stmt->fetch()){
			
			//vähemalt üks rida tuli
			//kasutaja siselogiminse parool räsiks
			
			$hash = hash("sha512", $password);
			
			if($hash == $passwordFromDb){
				//õnnestus
				echo "Kasutaja ".$id."logis sisse";
				
				$_SESSION["userId"] = $id;
				$_SESSION["userEmail"] = $emailFromDb;
				
				header("Location: data.php");
				
			}else{
				$notice = "Vale parool!";
			}
			
		} else{
			//ei leitud ühtegi rida
			$notice = "Sellist emaili ei ole!";
		}
		
		return $notice;
	}


	function saveNote($note, $color){
		
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
				
		$stmt = $mysqli->prepare("INSERT INTO colorNotes (note, color) VALUES (?, ?)");
		echo $mysqli->error;
		
		$stmt->bind_param("ss", $note, $color );
		
		if($stmt->execute() ){
			echo "salvestamine õnnestus";
		} else {
			echo "ERROR".$stmt->error;
		}
		
	}
	
	function getAllNotes(){
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT id, note, color FROM colorNotes");
		
		$stmt->bind_result($id, $note, $color);
		
		$stmt->execute();
		
		$result =array();
		
		//tsükkel töötab seni kuni saab uue rea andmebaasist
		//nii mitu korda palju SELECT lausega tuli
		while($stmt->fetch()) {
			//echo $note."<br>";
			
			$object = new StdClass();
			$object->id = $id;
			$object->note = $note;
			$object->noteColor = $color;
			
			array_push($result, $object);
		}
		
		return $result;
		
	}
	
	
	/*function sum($x, $y){
	
	$answer = $x+$y;
	
	return $answer;
	
	}
	function hello($firstname, $lastname){

	
	return "Tere tulemast ".$firstname." ".$lastname."!" ;
	}
	
	echo sum( 3,4);
	echo "<br>";
	
	echo sum( 1,2);
	echo "<br>";
	
	$firstname= "Kristel";
	echo hello("Kristel", "M");
	*/
?>