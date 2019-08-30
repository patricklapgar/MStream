<!DOCTYPE html>

<?php 
	include("includes/config.php");
	include("includes/classes/Account.php");
	include("includes/classes/Constants.php");

	$account = new Account($con);

	include("includes/handlers/register-handler.php");
	include("includes/handlers/login-handler.php");

	function getInputValue($name){
		if(isset($_POST[$name])){
			echo $_POST[$name];
		}
	}
?>

<html>
<head>
	<title>MStream</title>
	<link rel="stylesheet" type="text/css" href="assets/css/register.css">
	
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="assets/js/register.js"></script>
</head>
<body>
	<?php 
		if(isset($_POST['registerButton'])) {
			echo '<script>
					$(document).ready(function() {
						$("#loginForm").hide();
        				$("#registerForm").show();
					});
				</script>';
		}else {
			echo '<script>
					$(document).ready(function() {
						$("#loginForm").show();
        				$("#registerForm").hide();
					});
				</script>';
		}
	?>

	<!-- creating the register form -->
	<div id = "background">

		<div id="loginContainer">
			<div id="inputContainer">
				<form id="loginForm" action="register.php" method="POST">
					<h2>Login to your account!</h2>
					<p>
						<?php echo $account->getError(Constants::$loginFailed); ?>
						<label for="loginUsername">Username</label>
						<input id="loginUsername" type="text" name="loginUsername" placeholder="e.g. alexChheng" value="<?php getInputValue('loginUsername') ?>" required>
					</p>
					<p>
						<label for="loginPassword">Password</label>
						<input id="loginPassword" type="password" name="loginPassword" placeholder="Your Password" required>
					</p>

					<button type="submit" name="loginButton">Login</button>
					
					<div class="hasAccountText">
						<span id="hideLogin">Don't have an account yet? Signup here.</span>
					</div>

				</form>

				<form id="registerForm" action="register.php" method="POST">
					<h2>Create you free account!</h2>
					<p>
						<?php echo $account->getError(Constants::$usernameCharacters); ?>
						<?php echo $account->getError(Constants::$usernameTaken); ?>
						<label for="registerUsername">Username</label>
						<input id="registerUsername" type="text" name="registerUsername" placeholder="e.g. alexChheng" value="<?php getInputValue('registerUsername') ?>" required>
					</p>

					<p>
						<?php echo $account->getError(Constants::$firstNameCharacters); ?>
						<label for="firstName">First Name</label>
						<input id="firstName`
					" type="text" name="firstName" placeholder="e.g. Alexandra" value="<?php getInputValue('firstName') ?>" required>
					</p>

					<p>
						<?php echo $account->getError(Constants::$lastNameCharacters); ?>
						<label for="lastName">Last Name</label>
						<input id="lastName" type="text" name="lastName" placeholder="e.g. Chheng" value="<?php getInputValue('lastName') ?>" required>
					</p>

					<p>
						<?php echo $account->getError(Constants::$emailsDoNotMatch); ?>
						<?php echo $account->getError(Constants::$emailInvalid); ?>
						<?php echo $account->getError(Constants::$emailTaken); ?>
						<label for="registerEmail">Email</label>
						<input id="registerEmail" type="email" name="registerEmail" placeholder="e.g. alexChheng@email.com" value="<?php getInputValue('registerEmail') ?>" required>
					</p>

					<p>
						<label for="emailConfirmation">Confirm Email</label>
						<input id="emailConfirmation" type="email" name="emailConfirmation" placeholder="e.g. alexChheng@email.com" value="<?php getInputValue('emailConfirmation') ?>" required>
					</p>



 
					<p>
						<?php echo $account->getError(Constants::$passwordsDoNotMatch); ?>
						<?php echo $account->getError(Constants::$passwordNotAlphanumeric); ?>
						<?php echo $account->getError(Constants::$passwordCharacters); ?>
						<label for="registerPassword">Password</label>
						<input id="registerPassword" type="password" name="registerPassword" placeholder="Your Password" required>
					</p>

					<p>
						<label for="passwordConfirmation">Confirm Password</label>
						<input id="passwordConfirmation" type="password" name="passwordConfirmation" placeholder="Your Password" required>
					</p>

					<button type="submit" name="registerButton">Sign Up</button>
				
					<div class="hasAccountText">
						<span id="hideRegister">Already have an account? Log in here.</span>
					</div>

				</form>

			</div>

			<div id="loginText">
				<h1>Get great music, right now</h1>
				<h2>Listen to loads of songs for free</h2>
				<ul>
					<li>Discover music you'll fall in love with</li>
					<li>Create your own playlists</li>
					<li>Follow artists to keep up to date</li>
				</ul>
			</div>

		</div>
		<h5 id="courtesy">Courtesy of <a href="https://icons8.com/paid-license-99">Icons8</a> for supplying the icons used in this application</h5>
	</div>

</body>
</html>