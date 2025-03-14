<?php
//*****CONNEXION BDD*****
$serveur="trailrunagenda.mysql.db";
$user="trailrunagenda";
$pass="M1Em64WvA";
$base = "trailrunagenda";

try
{
	$dbh = new PDO('mysql:dbname='.$base.';host='.$serveur, $user,$pass);
} 
catch (Exception $e) 
{
	die("Impossible de se connecter: " . $e->getMessage());
}
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
