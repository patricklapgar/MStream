<?php 
	include("includes/config.php");

	// session_destroy(); LOGOUT


	if(isset($_SESSION['userLoggedIn'])){
		$userLoggedIn = $_SESSION['userLoggedIn'];
	}else{
		header("Location: register.php");
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>MStream</title>
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>

<body>
	
	<div id="nowPlayingBarContainer">
		<div id="nowPlayingBar">
			<div id="nowPlayingLeft">
			
			</div>

			<div id="nowPlayingCenter">
				<div class="content playerControls">

					<div class="buttons">
						<button class="controlButton shuffle" title="Shuffle">
							<img src="assets/images/icons/shuffle.png" alt="shuffle icons">
						</button>
					</div>

				</div>
			</div>

			<div id="nowPlayingRight">
			
			</div>
		</div>
	</div>

</body>

</html>