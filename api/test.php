<?php
include 'bdd.php';
include 'fonctions.php';

$template="4";
$emailOrganisateur="reperret@hotmail.com";
$titre="Création de votre compte admin TRF";
$contenu="Bonjour ".$_POST['prenomNom']."<br>";
$contenu.="Votre compte organisateur sur la plateforme TRF vient d'être créé. Voici vos identifiant :<br><br> Login : BLABLA <br> Mot de passe : COUCOU";
$libelleBouton="Accéder à l'interface administrateur";
$lienBouton="https://remyperret.org/trf/admin";

sendmailRporg($emailOrganisateur,$titre ,$contenu, $libelleBouton,$lienBouton, $template);

?>
