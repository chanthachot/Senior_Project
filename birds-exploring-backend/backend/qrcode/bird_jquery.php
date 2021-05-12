<?php
include('../connection/bird.php');
$bird_family_id = $_GET['bird_family_id'];

$query = "SELECT * FROM birds WHERE bird_family_id = $bird_family_id";
$result = mysqli_query($con2, $query);

$json = array();
while ($row = mysqli_fetch_assoc($result)) {
    array_push($json, $row);
}
echo json_encode($json);
