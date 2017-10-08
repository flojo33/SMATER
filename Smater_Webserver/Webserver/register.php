<?php
	include_once("mysql.php");
	if(isset($_POST["username"]) || isset($_POST["password"]) || isset($_POST["password2"])) {
		$username = $_POST["username"];
		$password = $_POST["password"];
		$password2 = $_POST["password2"];
		
		$error = 0;
		$errorString = "";
		
		if(trim($username) == "") {
			$error = 1;
			$errorString .= "- Bitte gebe eine E-Mail Adresse an.<br>";
		}
		
		if(trim($password) == "") {
			$error = 1;
			$errorString .= "- Bitte gebe ein Passwort an.<br>";
		}
		
		if(trim($password2) == "") {
			$error = 1;
			$errorString .= "- Bitte wiederhole dein Passwort.<br>";
		} else {
			if($password != $password2) {
				$error = 1;
				$errorString .= "- Die beiden Passwörter stimmen nicht überein!<br>";
			}
		}
		
		if($error == 0) {
			if(count(Query("*","users","`username` = '$username'")) != 0) {
				$error = 1;
				$errorString .= "Ein Benutzer mit dieser E-Mail existiert bereits!";
			} else {
				$exists = true;
				$curKey = "";
				while($exists == true) {
					$curKey = CreateRandomApiKey(128);
					if(count(Query("*","users","`key` = '$curKey'")) == 0) {
						$exists = false;
					}
				}
				Insert("users","(`id`, `username`, `password`, `key`)","(NULL, '$username', '$password', '$curKey')");
				$success = true;
			}
		}
	}
	
	function CreateRandomApiKey($LENGTH = 128) {
		$CHARACHTERS = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$str = "";
		 for ($i = 0; $i < $LENGTH; $i++) {
	        $str .= $CHARACHTERS[rand(0, strlen($CHARACHTERS) - 1)];
	    }
	    return $str;
	}
?>

<html>
	<head>
		<!-- Required meta tags -->
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	    <!-- Bootstrap CSS -->
	    <link rel="stylesheet" href="css/bootstrap.min.css">
	    <style>
		    body {
			    padding-top: 25px;
		    }
		</style>
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-12">
					<h1>SMATER Webserver</h1>
					<h2>Registrierung</h2>
					<p>Hier können Sie sich für den SMATER Webservice registrieren</p>
					<?php if($success == true) { ?>
					<p class="text-success">Registrierung war erfolgreich!<br>API Schlüssel: <?php echo $curKey; ?></p>
					<?php } else { ?>
					<form action="register.php" method="post">
						<label>E-Mail</label>
						<input type="email" name="username" class="form-control" value="<?php echo $username; ?>">
						<br>
						<label>Passwort</label>
						<input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
						<br>
						<label>Wiederhole Passwort</label>
						<input type="password" name="password2" class="form-control" value="<?php echo $password2; ?>">
						<br>
						<?php if($error == 1) echo "<p class='text-danger'>$errorString</p>"; ?>
						<button type="submit" class="btn btn-primary">Registrierung Abschließen</button>
					</form>
					<?php } ?>
					<a href="index.php">Zurück</a>
				</div>
			</div>
		</div>
	</body>
</html>