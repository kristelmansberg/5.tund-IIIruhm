<?php
	
	//et saada ligi sessioonile
	require("functions.php");
	
	if(!isset($_SESSION["userId"])){
		header("Location: login.php");
		
	}
		
	//kas kasutaja tahab välja logida
	//kas aadressi real on logout olemas
	if(isset($_GET["logout"])){
		
		session_destroy();
		
		header("Location: login.php");
		
	}
	
	if(	isset($_POST["note"]) &&
		isset($_POST["color"]) &&
		!empty($_POST["note"]) &&
		!empty($_POST["color"])
	){
		saveNote($_POST["note"], $_POST["color"]);
		
		header("Location: data.php");
	}
	
	$notes = getAllNotes();
	
	//echo "<pre>";
	//var_dump($notes);
	//echo "</pre>";
	
?>

<h1>Data</h1>
<p>
	Tere tulemast <?=$_SESSION["userEmail"];?>!
	<a href="?logout=1">Logi välja</a>
</p>	

<h2>Märkmed</h2>
<form method="POST">
	
	<label>Märkmed</label><br>
	<input name="note" type="text" value="<?php $note?>">
			
	<br><br>
	<label>Värv</label><br>
	<input name="color" type="color" value="<?php $color?>">
	
	<br><br>
	
	<input type="submit">	
						
</form>

<h2>Arhiiv</h2>

<?php

	//iga liikme kohta massiivis
	foreach ($notes as $n){
		
		$style = "width:100px; 
				  float:left; 
				  min-height:50px; 
				  border: 1px solid gray; 
				  background-color: ".$n->noteColor.";";
	
		echo "<p style=' ".$style." '>".$n->note."</p>";
	}

?>


<h2 style="clear:both;">Tabel</h2>

<?php 
	
	$html = "<table>";
	
		$html .= "<tr>";
			$html .= "<th>id</th>";
			$html .= "<th>Märkus</th>";
			$html .= "<th>Värv</th>";
		$html .= "</tr>";
		
	foreach($notes as $note){
		$html .= "<tr>";
			$html .= "<td>".$note->id."</td>";
			$html .= "<td>".$note->note."</td>";
			$html .= "<td>".$note->noteColor."</td>";
			
		$html .= "</tr>";	
	}
		
	$html .= "</table>";
	
	echo $html;
	
?>



