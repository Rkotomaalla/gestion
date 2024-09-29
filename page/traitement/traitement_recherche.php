<?php 
session_start();
include("../../inc/function.php");
$dateDebut=$_POST["dateDebut"];
$dateFin=$_POST["dateFin"];

$charges=get_charge($connexion,$dateDebut,$dateFin);
$_SESSION["charges"]    = $charges;
header("location:../model.php?page=list_charge.php");
?>