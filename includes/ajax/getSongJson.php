<?php 
include("../../config.php");

if(isset($_POST['songId'])) {
    $songId = $_POST['songId'];

    // Create a MySQL query to retrieve all songs where the id is equal to the passed songId
    $query = mysqli_query($con, "SELECT * FROM songs WHERE id='$songId'");

    // Conver that query into an array
    $resultArray = mysqli_fetch_array($query);

    // Covert the array into a json array and return
    echo json_encode($resultArray);
}

?>