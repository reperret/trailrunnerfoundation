<?php
// Inclure le fichier de fonctions
require_once 'fonctions.php';

// Définir les paramètres pour l'envoi de l'email
$emailOrganisateur = "destinataire@example.com";
$titre            = "Bienvenue sur Trail Runner Foundation";
$contenu          = "Nous vous remercions pour votre inscription.";
$libelleBouton    = "Accéder à mon compte";
$lienBouton       = "https://google.fr";
$template         = 123456; // Remplacez par l'ID de votre template Mailjet

// Logger les actions (ici, nous utilisons error_log pour simplifier, vous pouvez adapter à votre système de logs)
error_log("Début de l'envoi de l'email à " . $emailOrganisateur);

try {
    $resultat = sendMailMailjet($emailOrganisateur, $titre, $contenu, $libelleBouton, $lienBouton, $template);
    error_log("Envoi réussi : " . $resultat);
    echo "Envoi réussi : " . $resultat;
} catch (Exception $e) {
    error_log("Erreur lors de l'envoi de l'email : " . $e->getMessage());
    echo "Erreur lors de l'envoi de l'email : " . $e->getMessage();
}
