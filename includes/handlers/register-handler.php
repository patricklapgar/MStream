<?php 

// Sanitize functions for username, password, and generic strings

function sanitizeFormUsername($inputText){
	$inputText = strip_tags($inputText);
	$inputText = str_replace(" ", "", $inputText);
	return $inputText;
}

function sanitizeFormString($inputText){
	$inputText = strip_tags($inputText);
	$inputText = str_replace(" ", "", $inputText);
	$inputText = ucfirst(strtolower($inputText));
	return $inputText;
}

function sanitizeFormPassword($inputText){
	$inputText = strip_tags($inputText);
	return $inputText;
}



if(isset($_POST['registerButton'])){
	//Login button was pressed
	$registerUsername = sanitizeFormUsername($_POST['registerUsername']);
	$firstName = sanitizeFormString($_POST['firstName']);	
	$lastName = sanitizeFormString($_POST['lastName']);
	$registerEmail = sanitizeFormString($_POST['registerEmail']);
	$emailConfirmation = sanitizeFormString($_POST['emailConfirmation']);
	$registerPassword = sanitizeFormPassword($_POST['registerPassword']);
	$passwordConfirmation = sanitizeFormPassword($_POST['passwordConfirmation']);

    validateUsername($registerUsername);
    validateFirstName($firstName);
    validateLastName($lastName);
    validateEmails($registerEmail, $emailConfirmation);
    validatePasswords($registerPassword, $passwordConfirmation);
}


?>