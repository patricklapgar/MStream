<?php 
    class Account{
        private $con;
        private $errorArray;

        // Constructor function
        public function __construct($con){
            $this->con = $con;
            $this->errorArray = array();
        }

        public function register($un, $fn, $ln, $em, $em2, $pw, $pw2){
            $this->validateUsername($un);
            $this->validateFirstName($fn);
            $this->validateLastName($ln);
            $this->validateEmails($em, $em2);
            $this->validatePasswords($pw, $pw2);

            if(empty($this->errorArray)){
                // Insert into db
                return insertUserDetails($un, $fn, $ln, $em, $pw);
            }else{
                return false;
            }
        }

        public function getError($error){
            if(!in_array($error, $this->errorArray)) {
                $error = "";
            }
            return "<span class='errorMessage'>$error</span>";
        }

        private function insertUserDetails($un, $fn, $ln, $em, $pw){
            $encryptedPW = md5($pw);
            $profilePic = "";

        }

        private function validateUsername($username){
            if(strlen($username) > 25 || strlen($username) < 5){
                array_push($this->errorArray, Constants::$usernameCharacters);
                return;
            }

            // TODO: check if username exists
        }

        private function validateFirstName($firstName){
            if(strlen($firstName) > 25 || strlen($firstName) < 2){
                array_push($this->errorArray, Constants::$firstNameCharacters);
                return;
            }
        }

        private function validateLastName($lastName){
            if(strlen($lastName) > 25 || strlen($lastName) < 2){
                array_push($this->errorArray, Constants::$lastNameCharacters);
                return;
            }
        }

        private function validateEmails($email, $emailConfirmed){
            if($email != $emailConfirmed){
                array_push($this->errorArray, Constants::$emailsDoNotMatch);
                return;
            }

            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                array_push($this->errorArray, Constants::$emailInvalid);
                return;
            }
            // TODO: Check that username hasn't already been used.
        }

        private function validatePasswords($password, $passwordConfirmed){
            if($password != $passwordConfirmed){
                array_push($this->errorArray, Constants::$passwordsDoNotMatch);
                return;
            }

            if(preg_match('/[^A-Za-z0-9]/', $password)){
                array_push($this->errorArray, Constants::$passwordNotAlphanumeric);
                return;
            }

            if(strlen($password) > 30 || strlen($password) < 5){
                array_push($this->errorArray, Constants::$passwordCharacters);
                return;
            }
        }
    }
?>