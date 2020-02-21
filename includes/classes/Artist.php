<?php 
    class Artist {
        private $con;
        private $id;

        // Constructor function
        public function __construct($con, $id){
            $this->con = $con;
            $this->id = $id;
        }
        
        public function getId() {
            return $this->id;
        }
        
        public function getName() {
            $artistQuery = mysqli_query($this->con, "SELECT name FROM artists WHERE id='$this->id'");
            $artist = mysqli_fetch_array($artistQuery);
            return $artist['name'];
        }

        public function getSongIds(){ 
            $query = mysqli_query($this->con, "SELECT id FROM songs WHERE artist='$this->id' ORDER BY plays ASC");
        //    initialize new array here
            $array = array();

            // Push all values pertaining to the id of the the loop is currently on into the created array above
            while($row = mysqli_fetch_array($query)){
                array_push($array, $row['id']);
            }

            // Return the array created
            return $array;
        }
    }

?>