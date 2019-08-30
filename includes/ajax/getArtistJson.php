<?php 
include("../../config.php");

if(isset($_POST['artistId'])) {
    $artistId = $_POST['artistId'];

    // Create a MySQL query to retrieve the artist where the id is equal to the passed artistId
    $query = mysqli_query($con, "SELECT * FROM artists WHERE id='$artistId'");

    // Conver that query into an array
    $resultArray = mysqli_fetch_array($query);

    // Covert the array into a json array and return
    echo json_encode($resultArray);
}

?>