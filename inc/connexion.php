<?php 
$connexion=mysqli_connect("localhost","root","","jus");
if (!$connexion) {
    die("Erreur de connexion à la base de données: " . mysqli_connect_error());
}
?>