<?php 
    class Account{
        private $errorArray;

        // Constructor function
        public function __construct(){
            // Validation functions
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
                return true;
            }else{
                return false;
            }
        }

        /////////////////////////////////////////////////////////
        // THIS IS WHERE THE ERROR IS

        public function getError($error){
            if(!in_array($error, $this->errorArray)) {
                $error = "";
            }
            return "<span class='errorMessage'>$error</span>";
        }

        //////////////////////////////////////////////////////////

        private function validateUsername($username){
            if(strlen($un) > 25 || strlen($un) < 5){
                array_push($this->errorArray, "Your user name must be between 5 and 25 characters.");
                return;
            }

            // TODO: check if username exists
        }

        private function validateFirstName($firstName){
            if(strlen($firstName) > 25 || strlen($firstName) < 2){
                array_push($this->errorArray, "Your first name must be between 2 and 25 characters.");
                return;
            }
        }

        private function validateLastName($lastName){
            if(strlen($lastName) > 25 || strlen($lastName) < 2){
                array_push($this->errorArray, "Your last name must be between 2 and 25 characters.");
                return;
            }
        }

        private function validateEmails($email, $emailConfirmed){
            if($email != $emailConfirmed){
                array_push($this->errorArray, "Your emails don't match.");
                return;
            }

            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                array_push($this->errorArray, "Email is invalid.");
                return;
            }
            // TODO: Check that username hasn't already been used.
        }

        private function validatePasswords($password, $passwordConfirmed){
            if($password != $passwordConfirmed){
                array_push($this->errorArray, "Your passwords don't match.");
                return;
            }

            if(preg_match('/[^A-Za-z0-9]/', $password)){
                array_push($this->errorArray, "Your password can only contain numbers and letters.");
                return;
            }

            if(strlen($password) > 30 || strlen($password) < 5){
                array_push($this->errorArray, "Your password must be between 5 and 30 characters.");
                return;
            }
        }
    }
?>