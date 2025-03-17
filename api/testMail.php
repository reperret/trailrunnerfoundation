<?php
// Inclure le fichier des fonctions
require_once 'fonctions.php';

// Récupérer l'email destinataire depuis la variable GET ou définir une valeur par défaut
$emailOrganisateur = isset($_GET['email']) ? filter_var($_GET['email'], FILTER_SANITIZE_EMAIL) : "destinataire@example.com";

// Définir les autres paramètres du mail
$titre         = "Bienvenue sur Trail Runner Foundation";
$contenu       = "Nous vous remercions pour votre inscription. Veuillez trouver toutes les informations nécessaires dans cet email.";
$libelleBouton = "Accéder à mon compte";
$lienBouton    = "https://trailrunnerfoundation.com/mon-compte";
$template      = 6815714; // ID du template Mailjet fourni

// Obtenir la date courante pour le log
$date = date("Y-m-d H:i:s");

// Logger le début de l'envoi
error_log("[$date] Début de l'envoi de l'email à $emailOrganisateur");

// Appel de la fonction d'envoi avec gestion des erreurs
try {
    $resultat = sendmailRporg($emailOrganisateur, $titre, $contenu, $libelleBouton, $lienBouton, $template);
    error_log("[$date] Envoi réussi à $emailOrganisateur : $resultat");
    echo "[$date] Envoi réussi à $emailOrganisateur : $resultat";
} catch (Exception $e) {
    error_log("[$date] Erreur lors de l'envoi de l'email à $emailOrganisateur : " . $e->getMessage());
    echo "[$date] Erreur lors de l'envoi de l'email à $emailOrganisateur : " . $e->getMessage();
}
