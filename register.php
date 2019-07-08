<!DOCTYPE html>

<?php 

if(isset($_POST['loginButton'])){
	//Login button was pressed
	
}

if(isset($_POST['registerButton'])){
	//Login button was pressed
	
}
?>

<html>
<head>
	<title>MStream</title>
</head>
<body>
	<!-- creating the register form -->
	<div id="inputContainer">
		<form id="loginForm" action="register.php" method="POST">
			<h2>Login to your account!</h2>
			<p>
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
				<label for="registerUsername">Username</label>
				<input id="registerUsername" type="text" name="registerUsername" placeholder="e.g. alexChheng" required>
			</p>

			<p>
				<label for="firstName">First Name</label>
				<input id="firstName`
			" type="text" name="firstName" placeholder="e.g. Alexandra" required>
			</p>

			<p>
				<label for="lastName">Last Name</label>
				<input id="lastName" type="text" name="lastName" placeholder="e.g. Chheng" required>
			</p>

			<p>
				<label for="registerEmail">Email</label>
				<input id="registerEmail" type="email" name="registerEmail" placeholder="e.g. alexChheng@email.com" required>
			</p>

			<p>
				<label for="emailConfirmation">Confirm Email</label>
				<input id="emailConfirmation" type="email" name="emailConfirmation" placeholder="e.g. alexChheng@email.com" required>
			</p>




			<p>
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

</body>
</html>