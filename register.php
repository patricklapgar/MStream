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
</head>
<body>
	<!-- creating the register form -->
	<div id = "background">
		<div id="inputContainer">
			<form id="loginForm" action="register.php" method="POST">
				<h2>Login to your account!</h2>
				<p>
					<?php echo $account->getError(Constants::$loginFailed); ?>
					<label for="loginUsername">Username</label>
					<input id="loginUsername" type="text" name="loginUsername" placeholder="e.g. alexChheng" required>
				</p>
				<p>
					<label for="loginPassword">Password</label>
					<input id="loginPassword" type="password" name="loginPassword" placeholder="Your Password" required>
				</p>

				<button type="submit" name="loginButton">Login</button>
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
			</form>

		</div>
	</div>

</body>
</html>