<?php 
    class Account{
        private $con;
        private $errorArray;

        // Constructor function
        public function __construct($con){
            $this->con = $con;
            $this->errorArray = array();
        }

        public function login($un, $pw){
            $pw = md5($pw);

            $query = mysqli_query($this->con, "SELECT * FROM users WHERE username='$un' AND password='$pw'");
            
            if(mysqli_num_rows($query) == 1){
                return true;
            }else{
                array_push($this->errorArray, Constants::$loginFailed);
                return false;
            }
        }

        public function register($un, $fn, $ln, $em, $em2, $pw, $pw2){
            $this->validateUsername($un);
            $this->validateFirstName($fn);
            $this->validateLastName($ln);
            $this->validateEmails($em, $em2);
            $this->validatePasswords($pw, $pw2);

            if(empty($this->errorArray)){
                // Insert into db
                return $this->insertUserDetails($un, $fn, $ln, $em, $pw);
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
            $profilePic = "assets/images/profile-pics/download.png";
            $date = date("Y-m-d");
            
            // MySQL query
            $result = mysqli_query($this->con, "INSERT INTO users VALUES ('', '$un', '$fn', '$ln', '$em', '$encryptedPW', '$date', '$profilePic')");
            return $result;
        }

        private function validateUsername($username){
            if(strlen($username) > 25 || strlen($username) < 5){
                array_push($this->errorArray, Constants::$usernameCharacters);
                return;
            }

            $checkUsernameQuery = mysqli_query($this->con, "SELECT username FROM users WHERE username='$username'");
            if(mysqli_num_rows($checkUsernameQuery) != 0){
                array_push($this->errorArray, Constants::$usernameTaken);
                return;
            }
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
            
            $checkEmailQuery = mysqli_query($this->con, "SELECT email FROM users WHERE email='$email'");
            if(mysqli_num_rows($checkEmailQuery) != 0){
                array_push($this->errorArray, Constants::$emailTaken);
                return;
            }
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