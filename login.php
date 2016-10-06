<?php
	
	
	require("functions.php");
	
	//kui kasutaja on sisseloginud juba, siis suunan data lehele
	if(isset($_SESSION["userId"])){
		header("Location: data.php");
	}

	//var_dump($_GET);
	//echo "<br>"; echo-näitab ainult tekstina
	//var_dump ($_POST); var_dump-näitabab nii teksti kui numbrina
	//empty - "" nii on true, " " nüüd on false
	
	$signupEmailError = "";
	$signupEmail = "";
	$gender = "";
	
	//kas on üldse olemas
	if (isset ($_POST ["signupEmail"])){
		
		//oli olemas, ehk keegi vajutas nuppu
		//kas oli tühi
		if (empty ($_POST ["signupEmail"])){
			
			//oli tõesti tühi
			$signupEmailError = "See väli on kohustuslik";
		
		}else{
			//kõik korras, email ei ole tühi ja on olemas
			$signupEmail = $_POST ["signupEmail"];
		}
			
	}
	
	$signupPasswordError = "";
	
	//kas on üldse olemas
	if (isset ($_POST ["signupPassword"])){
		
		//oli olemas, ehk keegi vajutas nuppu
		//kas oli tühi
		if (empty ($_POST ["signupPassword"])){
			
			//oli tõesti tühi
			$signupPasswordError = "See väli on kohustuslik";
		} else {
			// oli midagi ei olnud tühi
			
			// kas pikkus vähemalt 8
			if(strlen ($_POST ["signupPassword"]) < 8 ){
				
				$signupPasswordError = "Parool peab olema vähemalt 8 tühemärki pikk";
				
			}
		}
	
	
	if (isset($_POST["gender"])) {
		if(!empty($_POST["gender"]))
		
			//on olemas ja ei ole tühi
			$gender = $_POST["gender"];
		}
	}

	if 
		(isset($_POST["signupEmail"]) &&
		isset($_POST["signupPassword"]) &&
		$signupEmailError  == "" &&
		empty($signupPasswordError)
		) {
		
		//ühtegi viga ei ole, kõik vajalik olemas
		echo "salvestan...<br>";
		echo "email ".$signupEmail."<br>";
		echo "parool ".$_POST["signupPassword"]."<br>";
		
		$password = hash("sha512", $_POST["signupPassword"]);
		
		
		echo "räsi ".$password."<br>";
		
		//kutsun funktsiooni, et salvestada
		signup($signupEmail, $password);
	
	}
	
	$notice=" ";
	// mõlemad login vormi väljad on täidetud
	if(	isset($_POST["loginEmail"]) &&
		isset($_POST["loginPassword"]) &&
		!empty($_POST["loginEmail"]) &&
		!empty($_POST["loginPassword"])
	){
		$notice = login($_POST["loginEmail"], $_POST["loginPassword"]);
		
	}
	
	
	
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Sisselogimise leht</title>
	</head>
	<body>

		<h1>Logi sisse</h1>
		<p style="color:red;"> =<?php echo $notice; ?></p>
		<form method="POST">
			<!--label>E-post</label>-->
			<input placeholder= "E-post" name="loginEmail" type="email"><?php echo $signupEmailError; ?>
			
			<br> <br>
			<!--label>Parool</label>-->
			<input placeholder= "Parool" name="loginPassword" type="password"><?php echo $signupPasswordError; ?>
			
			<br> <br>
			
			<input type="submit">
		</form>
		
		<h1>Loo kasutaja</h1>
		
		<form method="POST">
			<!--label>E-post</label>-->
			<input placeholder= "E-post" name="signupEmail" type="email" value="<?= $signupEmail; ?>"> <?php echo $signupEmailError; ?>
			
			<br> <br>
			<!--label>Parool</label>-->
			<input placeholder= "Parool" name="signupPassword" type="password"><?php echo $signupPasswordError; ?>
			
			<br> <br>
			<?php if ($gender == "male") { ?>
			<input type="radio" name="gender" value="male" checked > Mees<br>
			<?php } else { ?>
			<input type="radio" name="gender" value="male" > Mees<br>
			<?php } ?>
			
			<?php if ($gender == "female") { ?>
				<input type="radio" name="gender" value="female" checked > Naine<br>
			<?php } else { ?>
				<input type="radio" name="gender" value="female"> Naine<br>
			<?php } ?>
			<br>
			<input type="submit" value="Loo kasutaja">
			
		</form>
	</body>
</html>