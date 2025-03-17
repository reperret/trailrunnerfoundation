<?php


function sendmailRporg($emailOrganisateur, $titre, $contenu, $libelleBouton, $lienBouton, $template)
{
    // Vos identifiants Mailjet
    $apiKey = 'f5cce6f3c1cd07ff3c7045e0007a663e';
    $apiSecret = 'b50ae69f9d0e26ff38b53ee6d37fcfde';
    $template = 6815714;

    // Endpoint Mailjet pour l'envoi de mails via l'API v3.1
    $url = "https://api.mailjet.com/v3.1/send";

    // Construction de la charge utile
    $payload = [
        "Messages" => [
            [
                "From" => [
                    "Email" => "contact@trailrunnerfoundation.com",
                    "Name"  => "Trail Runner Foundation"
                ],
                "To" => [
                    [
                        "Email" => $emailOrganisateur,
                        "Name"  => ""  // Vous pouvez préciser un nom si besoin
                    ]
                ],
                "TemplateID" => $template,
                "TemplateLanguage" => true,
                "Subject" => "votre compte Trail Runner Foundation",
                "Variables" => [
                    "titre"         => $titre,
                    "contenu"       => $contenu,
                    "lienbouton"    => $lienBouton,
                    "libellebouton" => $libelleBouton
                ]
            ]
        ]
    ];

    $jsonData = json_encode($payload);

    // Initialisation de cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    // Authentification basique avec vos identifiants Mailjet
    curl_setopt($ch, CURLOPT_USERPWD, $apiKey . ":" . $apiSecret);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);

    try {
        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
            throw new Exception("Erreur cURL lors de l'envoi : " . $error_msg);
        }

        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($http_code != 200 && $http_code != 201) {
            throw new Exception("Erreur lors de l'envoi de l'email, code HTTP : " . $http_code . " Réponse : " . $response);
        }
    } catch (Exception $e) {
        curl_close($ch);
        throw $e;
    }

    curl_close($ch);

    // Renvoie le message de confirmation en cas de succès
    return "Message reçu. Nous vous répondons dans les plus bref délais.";
}



function getDroitsUtilisateur($idUtilisateur, $dbh)
{
    $requete = "SELECT idCourse from utilisateur U inner join droit D on D.idUtilisateur=U.idUtilisateur where U.idUtilisateur=" . $idUtilisateur;
    $idsCourse = array();
    $resultats = $dbh->query('SET NAMES UTF8');
    $resultats = $dbh->query($requete);
    $lignes = $resultats->fetchAll(PDO::FETCH_OBJ);
    foreach ($lignes as $colonne) {
        $idsCourse[] = $colonne->idCourse;
    }

    return $idsCourse;
}

function createUtilisateur($dbh)
{
    $profil = 0;
    $nomUtilisateur = "NOUVEAU";
    $prenomUtilisateur = "Utilisateur";
    $reqInsert = $dbh->prepare("INSERT INTO utilisateur (profilUtilisateur, nomUtilisateur, prenomUtilisateur) VALUES (?,?,?)");
    $reqInsert->bindParam(1, $profil);
    $reqInsert->bindParam(2, $nomUtilisateur);
    $reqInsert->bindParam(3, $prenomUtilisateur);
    $return = $reqInsert->execute();
    $idUtilisateur = $dbh->lastInsertId();



    return $idUtilisateur;
}

function getCoursesFromIdCourse($idCourse, $dbh)
{
    $requete = "SELECT C.libelleCourse, C.villeCourse, C.codepostalCourse, D.idDroit, C.idCourse from course C inner join droit D on D.idCourse=C.idCourse and C.idCourse=" . $idCourse;
    $array = array();
    $resultats = $dbh->query('SET NAMES UTF8');
    $resultats = $dbh->query($requete);
    $lignes = $resultats->fetchAll(PDO::FETCH_OBJ);
    foreach ($lignes as $colonne) {
        $array['idDroit'] = $colonne->idDroit;
        $array['idCourse'] = $colonne->idCourse;
        $array['libelleCourse'] = $colonne->libelleCourse;
        $array['villeCourse'] = $colonne->villeCourse;
        $array['codepostalCourse'] = $colonne->codepostalCourse;
    }

    return $array;
}

function createCourse($dbh)
{
    $latitudeCourse = "4.5";
    $longitudeCourse = "1.5";
    $libelleCourse = "Nouvelle course";
    $active = 1;

    $reqInsert = $dbh->prepare("INSERT INTO course (latitudeCourse,longitudeCourse,libelleCourse,activeCourse) VALUES (?,?,?,?)");

    $reqInsert->bindParam(1, $latitudeCourse);
    $reqInsert->bindParam(2, $longitudeCourse);
    $reqInsert->bindParam(3, $libelleCourse);
    $reqInsert->bindParam(4, $active);

    $return = $reqInsert->execute();
    $idCourse = $dbh->lastInsertId();

    return $idCourse;
}

function deleteCourse($idCourse, $dbh)
{
    $return = false;
    $idCourse = intval($idCourse);

    $reqDelete = $dbh->prepare("DELETE FROM droit where idCourse=?");
    $reqDelete->bindParam(1, $idCourse);
    $return = $reqDelete->execute();

    $reqDelete = $dbh->prepare("DELETE FROM mot where idCourse=?");
    $reqDelete->bindParam(1, $idCourse);
    $return = $reqDelete->execute();

    $reqDelete = $dbh->prepare("DELETE FROM photo where idCourse=?");
    $reqDelete->bindParam(1, $idCourse);
    $return = $reqDelete->execute();

    $reqDelete = $dbh->prepare("DELETE FROM course where idCourse=?");
    $reqDelete->bindParam(1, $idCourse);
    $return = $reqDelete->execute();

    return $return;
}

function deleteUtilisateur($idUtilisateur, $dbh)
{
    $return1 = false;
    $return2 = false;

    $reqDelete = $dbh->prepare("DELETE FROM droit where idUtilisateur=?");
    $reqDelete->bindParam(1, $idUtilisateur);
    $return1 = $reqDelete->execute();


    $reqDelete = $dbh->prepare("DELETE FROM utilisateur where idUtilisateur=?");
    $reqDelete->bindParam(1, $idUtilisateur);
    $return2 = $reqDelete->execute();

    return $return1 && $return2;
}

function getCenterLatLng($coordinates)
{
    $x = $y = $z = 0;
    $n = count($coordinates);
    foreach ($coordinates as $point) {
        $lt = $point[0] * pi() / 180;
        $lg = $point[1] * pi() / 180;
        $x += cos($lt) * cos($lg);
        $y += cos($lt) * sin($lg);
        $z += sin($lt);
    }
    $x /= $n;
    $y /= $n;

    return [atan2(($z / $n), sqrt($x * $x + $y * $y)) * 180 / pi(), atan2($y, $x) * 180 / pi()];
}

function getTypeCourse($typeCourse)
{
    $libelle = NULL;
    switch ($typeCourse) {
        case 0:
            $libelle = "Adhérente";
            break;
        case 1:
            $libelle = "Labelisée";
            break;
    }
    return $libelle;
}

function getClassCssTypeCourse($statut)
{
    $class = NULL;
    switch ($statut) {
        case 0:
            $class = "consultable";
            break;
        case 1:
            $class = "approved";
            break;
    }

    return $class;
}


function getDepartements($dbh)
{
    $requete = "SELECT * from departement";
    $array = array();
    $resultats = $dbh->query('SET NAMES UTF8');
    $resultats = $dbh->query($requete);
    $lignes = $resultats->fetchAll(PDO::FETCH_OBJ);
    foreach ($lignes as $colonne) {
        $numDep2Digits = $colonne->numDepartement;
        if (strlen($colonne->numDepartement) == 1) $numDep2Digits = "0" . $colonne->numDepartement;
        $array[$numDep2Digits] = $colonne->libelleDepartement;
    }

    return $array;
}



function getListImages($idCourse, $dbh)
{
    $requete = "SELECT * from photo where idCourse=" . $idCourse;
    $array = array();
    $resultats = $dbh->query('SET NAMES UTF8');
    $resultats = $dbh->query($requete);
    $lignes = $resultats->fetchAll(PDO::FETCH_OBJ);
    $i = 0;
    foreach ($lignes as $colonne) {
        $array[$i]['idPhoto'] = $colonne->idPhoto;
        $array[$i]['idCourse'] = $colonne->idCourse;
        $array[$i]['nomPhoto'] = $colonne->nomPhoto;
        $array[$i]['typePhoto'] = $colonne->typePhoto;
        $i++;
    }

    return $array;
}

function insertImage($idCourse, $referenceImage, $typePhoto, $dbh)
{
    $reqInsert = $dbh->prepare("INSERT INTO photo (idCourse,nomPhoto,typePhoto) VALUES (?,?,?)");
    $reqInsert->bindParam(1, $idCourse);
    $reqInsert->bindParam(2, $referenceImage);
    $reqInsert->bindParam(3, $typePhoto);

    $etatExecution = $reqInsert->execute();
    $idImage = $dbh->lastInsertId();

    return $idImage;
}

function getTypeImage($typeImage)
{
    $libelle = NULL;
    switch ($typeImage) {
        case 0:
            $libelle = "Diaporama";
            break;
        case 1:
            $libelle = "Grand bandeau";
            break;
        case 2:
            $libelle = "Vignette";
            break;
    }
    return $libelle;
}

function deleteDroit($idDroit, $dbh)
{
    $exec = false;

    // Suppression du droit
    $reqDelete = $dbh->prepare("DELETE FROM droit where idDroit=?");
    $reqDelete->bindParam(1, $idDroit);
    $exec = $reqDelete->execute();

    return $exec;
}

function getInfosCourseUtilisateur($idUtilisateur, $idCourse, $dbh)
{
    $emailOrganisateur = NULL;
    $prenom = NULL;
    $nom = NULL;
    $libelleCourse = NULL;

    //INFOS USER
    $requete = "SELECT * from utilisateur where idUtilisateur=" . $idUtilisateur;
    $resultats = $dbh->query('SET NAMES UTF8');
    $resultats = $dbh->query($requete);
    $lignes = $resultats->fetchAll(PDO::FETCH_OBJ);
    foreach ($lignes as $colonne) {
        $emailOrganisateur = $colonne->emailUtilisateur;
        $prenom = $colonne->prenomUtilisateur;
        $nom = $colonne->nomUtilisateur;
    }

    //INFOS COURSE
    $requete = "SELECT libelleCourse from course where idCourse=" . $idCourse;
    $resultats = $dbh->query('SET NAMES UTF8');
    $resultats = $dbh->query($requete);
    $lignes = $resultats->fetchAll(PDO::FETCH_OBJ);
    foreach ($lignes as $colonne) {
        $libelleCourse = $colonne->libelleCourse;
    }

    return array($emailOrganisateur, $prenom, $nom, $libelleCourse);
}

function createDroit($idUtilisateur, $idCourse, $dbh)
{
    $return = false;
    $reqInsert = $dbh->prepare("INSERT INTO droit (idUtilisateur,idCourse) VALUES (?,?)");
    $reqInsert->bindParam(1, $idUtilisateur);
    $reqInsert->bindParam(2, $idCourse);
    $return = $reqInsert->execute();

    $infos = getInfosCourseUtilisateur($idUtilisateur, $idCourse, $dbh);

    // GET INFO COURSE / USER
    $template = "4";
    $emailOrganisateur = $infos[0];
    $prenom = $infos[1];
    $nom = $infos[2];
    $libelleCourse = $infos[3];



    $titre = "Nouvel accès à une course";
    $contenu = "Bonjour " . $prenom . " " . $nom . ",<br><br>";
    $contenu .= "Vous venez de récupérer les droits d'accès administrateur pour la course " . $libelleCourse;
    $contenu .= "<br><br>Vous pouvez dès à présent cliquer sur le lien ci dessous, vous connecter et accéder à la page de personnalisation de votre évènement.";
    $libelleBouton = "Paramétrer votre course";
    $lienBouton = "https://agenda.trailrunnerfoundation.com/admin/detailCourse.php?idC=" . $idCourse;

    sendmailRporg($emailOrganisateur, $titre, $contenu, $libelleBouton, $lienBouton, $template);

    return $return;
}

function deleteImage($idPhoto, $cheminAbsolu, $dbh)
{
    //****RECUPERATION NOM FICHIER A SUPPRIMER****
    $resultats = $dbh->query('SET NAMES UTF8');
    $resultats = $dbh->query("SELECT * from photo where idPhoto=" . $idPhoto);
    $lignes = $resultats->fetchAll(PDO::FETCH_OBJ);
    $nomPhoto = NULL;
    foreach ($lignes as $colonne) {
        $nomPhoto = $colonne->nomPhoto;
    }


    //****DELETE BDD****
    $exec = false;
    $reqDelete = $dbh->prepare("DELETE FROM photo where idPhoto=?");
    $reqDelete->bindParam(1, $idPhoto);
    $exec = $reqDelete->execute();


    //****DELETE BDD****
    if ($exec) {
        unlink($cheminAbsolu . $nomPhoto);
    }

    return $exec;
}

function uploadImage($file, $idCourse, $cheminAbsolu, $typePhoto, $dbh)
{
    //*********GESTION IMAGES****************
    $errorUpload = NULL;
    $uploadEnCours = false;
    $uploadImageFinal = NULL;
    $image_file = $file;

    // Exit if no file uploaded
    if (!isset($image_file)) {
        $uploadEnCours = true;
    }

    // Exit if image file is zero bytes
    if (filesize($image_file["tmp_name"]) <= 0) {
        $errorUpload = "Le fichier est vide";
    }

    // Exit if is not a valid image file
    $image_type = exif_imagetype($image_file["tmp_name"]);
    if (!$image_type) {
        $errorUpload = "Le fichier n'est pas une image valide";
    }
    // Get file extension based on file type, to prepend a dot we pass true as the second parameter
    $image_extension = image_type_to_extension($image_type, true);
    $image_name = bin2hex(random_bytes(16)) . $image_extension;
    $uploadImageFinal = move_uploaded_file($image_file["tmp_name"], $cheminAbsolu . $image_name);

    if ($uploadImageFinal)  insertImage($idCourse, $image_name, $typePhoto, $dbh);

    return array($uploadEnCours, $uploadImageFinal, $errorUpload, $image_name, __DIR__ . "/images/" . $image_name);
}

function arfUploadImage($fichier, $nomFichier, $idEvenement, $dateCreationImage, $typeImage, $idImageParent, $dbh)
{
    $return = array();
    $return['ecritureFichierImage'] = false;
    $return['ecritureBddImage'] = false;
    $dateReceptionImage = date('Y-m-d H:i:s');

    try {
        $nomFichierFinal = $nomFichier;
        $current = file_get_contents($fichier['tmp_name']);
        $result = file_put_contents(dirname(__DIR__, 1) . "/photos/" . $nomFichierFinal, $current);
        $return['ecritureFichierImage'] = false;
        if ($result > 0) $return['ecritureFichierImage'] = true;
    } catch (Exception $e) {
        $return['ecritureFichierImage'] = false;
        $return['errorDetailEcritureFichierImage'] = $e->getMessage();
    }

    if ($return['ecritureFichierImage']) {
        try {
            $reqInsert = $dbh->prepare("INSERT INTO image (idEvenement,nomImage,dateCreationImage,dateReceptionImage,typeImage,idImageParent) VALUES (?,?,?,?,?,?)");
            $reqInsert->bindParam(1, $idEvenement);
            $reqInsert->bindParam(2, $nomFichierFinal);
            $reqInsert->bindParam(3, $dateCreationImage);
            $reqInsert->bindParam(4, $dateReceptionImage);
            $reqInsert->bindParam(5, $typeImage);
            $reqInsert->bindParam(6, $idImageParent);
            $etatExecution = $reqInsert->execute();
            $idImage = $dbh->lastInsertId();
            $return['ecritureBddImage'] = $etatExecution;
            $return['idImage'] = $idImage;
        } catch (Exception $e) {
            $return['ecritureBddImage'] = false;
            $return['idImage'] = NULL;
            $return['errorDetailEcritureBddImage'] = $e->getMessage();
        }
    }


    return $return;
}

function getPhotosCourse($idCourse, $dbh)
{
    $requete = NULL;
    $requete = "SELECT * from photo";
    if ($idCourse != "" && $idCourse != NULL) {
        $requete = "SELECT * FROM photo where idCourse=" . $idCourse;
    }

    $array = array();
    $resultats = $dbh->query('SET NAMES UTF8');
    $resultats = $dbh->query($requete);
    $lignes = $resultats->fetchAll(PDO::FETCH_OBJ);
    $i = 0;
    foreach ($lignes as $colonne) {
        $array[$i]['idPhoto'] = $colonne->idPhoto;
        $array[$i]['idCourse'] = $colonne->idCourse;
        $array[$i]['nomPhoto'] = $colonne->nomPhoto;
        $array[$i]['typePhoto'] = $colonne->typePhoto;
        $i++;
    }
    return $array;
}
/*
function getCourses($idCourse,$keyWord,$dateDebut,$dateFin,$typeCourse,$dbh)
{
    $requete=NULL;
    $requete="SELECT * from course where activeCourse=1";
    if($idCourse!="" && $idCourse!=NULL)
    {
        $requete="SELECT * FROM course where activeCourse=1 AND idCourse=".$idCourse;
    }
    elseif($keyWord!="" && $keyWord!=NULL)
    {
        $requete="SELECT
                *,
                MATCH(libelleCourse) AGAINST('".$keyWord."')  AS  score_libelleCourse,
                MATCH(descriptionCourse) AGAINST('".$keyWord."') AS score_descriptionCourse,
                MATCH(villeCourse) AGAINST('".$keyWord."') AS score_villeCourse,
                MATCH(codepostalCourse) AGAINST('".$keyWord."') AS score_codepostalCourse
                FROM course
                WHERE
                MATCH(libelleCourse) AGAINST('".$keyWord."') OR
                MATCH(descriptionCourse) AGAINST('".$keyWord."') OR
                MATCH(villeCourse) AGAINST('".$keyWord."') OR
                MATCH(codepostalCourse) AGAINST('".$keyWord."')
                ORDER BY (score_libelleCourse+score_descriptionCourse*0.5+score_villeCourse*0.1) DESC";
    }
    
    $array = array();
    $resultats = $dbh->query('SET NAMES UTF8');
    $resultats = $dbh->query($requete);
    $lignes=$resultats->fetchAll(PDO::FETCH_OBJ);
    $i=0;
    foreach ($lignes as $colonne)
    {
        $array[$i]['idCourse']=$colonne->idCourse;
        $array[$i]['latitudeCourse']=$colonne->latitudeCourse;
        $array[$i]['longitudeCourse']=$colonne->longitudeCourse;
        $array[$i]['dateDebutCourse']=$colonne->dateDebutCourse;
        $array[$i]['dateFinCourse']=$colonne->dateFinCourse;
        $array[$i]['libelleCourse']=$colonne->libelleCourse;
        $array[$i]['descriptionCourse']=$colonne->descriptionCourse;
        $array[$i]['sitewebCourse']=$colonne->sitewebCourse;
        $array[$i]['villeCourse']=$colonne->villeCourse;
        $array[$i]['codepostalCourse']=$colonne->codepostalCourse;
        $array[$i]['paysCourse']=$colonne->paysCourse;
        $array[$i]['distanceMinCourse']=$colonne->distanceMinCourse;
        $array[$i]['distanceMaxCourse']=$colonne->distanceMaxCourse;
        $array[$i]['typeCourse']=getTypeCourse($colonne->typeCourse);
        $array[$i]['typeCourseCode']=$colonne->typeCourse;
        $array[$i]['activeCourse']=$colonne->activeCourse;
        $array[$i]['photosCourse']=getPhotosCourse($colonne->idCourse,$dbh);
        $i++;
    }
    
    return $array;
}
*/

function getCourses($idCourse, $keyWord, $dateDebut, $dateFin, $typeCourse, $departement, $dbh)
{
    $requete = NULL;
    $whereDate = NULL;
    $whereType = NULL;
    $whereDepartement = NULL;

    if ($dateDebut != '' && $dateDebut != NULL) {
        $whereDate = " AND dateDebutCourse>='" . $dateDebut . "' AND dateFinCourse<='" . $dateFin . "' ";
    }

    if ($typeCourse != '' && $typeCourse != NULL) {
        $whereType = " AND typeCourse=" . $typeCourse . " ";
    }

    if ($departement != '' && $departement != NULL) {
        if (strlen($departement) == 1) $departement = "0" . $departement;
        $whereDepartement = " AND codepostalCourse LIKE '" . $departement . "%' ";
    }



    $requete = "SELECT * from course where activeCourse=1 " . $whereDate . $whereType . $whereDepartement . " ORDER BY 
  CASE 
    WHEN dateDebutCourse >= CURDATE() THEN 0 
    ELSE 1 
  END,
  ABS(DATEDIFF(dateDebutCourse, CURDATE()))";


    if ($keyWord != "" && $keyWord != NULL) {
        $requete = "SELECT
                *,
                MATCH(libelleCourse) AGAINST('" . $keyWord . "')  AS  score_libelleCourse,
                MATCH(descriptionCourse) AGAINST('" . $keyWord . "') AS score_descriptionCourse,
                MATCH(villeCourse) AGAINST('" . $keyWord . "') AS score_villeCourse,
                MATCH(codepostalCourse) AGAINST('" . $keyWord . "') AS score_codepostalCourse
                FROM course
                WHERE
                activeCourse=1 AND
                (
                MATCH(libelleCourse) AGAINST('" . $keyWord . "') OR
                MATCH(descriptionCourse) AGAINST('" . $keyWord . "') OR
                MATCH(villeCourse) AGAINST('" . $keyWord . "') OR
                MATCH(codepostalCourse) AGAINST('" . $keyWord . "') 
                ) " . $whereDate . " " . $whereType . " " . $whereDepartement . "
                ORDER BY (score_libelleCourse+score_descriptionCourse*0.5+score_villeCourse*0.1) DESC, CASE 
    WHEN dateDebutCourse >= CURDATE() THEN 0 
    ELSE 1 
  END,
  ABS(DATEDIFF(dateDebutCourse, CURDATE()))";
    }


    if ($idCourse != "" && $idCourse != NULL) {
        $requete = "SELECT * FROM course where activeCourse=1 AND idCourse=" . $idCourse;
    }

    $array = array();
    $resultats = $dbh->query('SET NAMES UTF8');
    $resultats = $dbh->query($requete);
    $lignes = $resultats->fetchAll(PDO::FETCH_OBJ);
    $i = 0;
    foreach ($lignes as $colonne) {
        $array[$i]['idCourse'] = $colonne->idCourse;
        $array[$i]['latitudeCourse'] = $colonne->latitudeCourse;
        $array[$i]['longitudeCourse'] = $colonne->longitudeCourse;
        $array[$i]['dateDebutCourse'] = $colonne->dateDebutCourse;
        $array[$i]['dateFinCourse'] = $colonne->dateFinCourse;
        $array[$i]['libelleCourse'] = $colonne->libelleCourse;
        $array[$i]['descriptionCourse'] = $colonne->descriptionCourse;
        $array[$i]['sitewebCourse'] = $colonne->sitewebCourse;
        $array[$i]['villeCourse'] = $colonne->villeCourse;
        $array[$i]['codepostalCourse'] = $colonne->codepostalCourse;
        $array[$i]['paysCourse'] = $colonne->paysCourse;
        $array[$i]['distanceMinCourse'] = $colonne->distanceMinCourse;
        $array[$i]['distanceMaxCourse'] = $colonne->distanceMaxCourse;
        $array[$i]['typeCourse'] = getTypeCourse($colonne->typeCourse);
        $array[$i]['typeCourseCode'] = $colonne->typeCourse;
        $array[$i]['activeCourse'] = $colonne->activeCourse;
        $array[$i]['photosCourse'] = getPhotosCourse($colonne->idCourse, $dbh);
        $array[$i]['requete'] = $requete;
        $i++;
    }

    return $array;
}


function getPhotosCourseFile($tableauPhotos)
{
    $vignette = NULL;
    $bandeau = NULL;
    $diaporama = array();
    foreach ($tableauPhotos as $photo) {
        if ($photo['typePhoto'] == 0) $diaporama[] = $photo['nomPhoto'];
        if ($photo['typePhoto'] == 1) $bandeau = $photo['nomPhoto'];
        if ($photo['typePhoto'] == 2) $vignette = $photo['nomPhoto'];
    }
    return array($vignette, $bandeau, $diaporama);
}

function getUtilisateurs($idUtilisateur, $profilUtilisateur, $idCourse, $dbh)
{
    $requete = NULL;
    $requete = "SELECT U.*, D.idDroit, D.idCourse from utilisateur U left outer join droit D on D.idUtilisateur=U.idUtilisateur order by U.idUtilisateur";
    if ($idUtilisateur != "" && $idUtilisateur != NULL) {
        $requete = "SELECT U.*, D.idDroit, D.idCourse FROM utilisateur U left outer join droit D on D.idUtilisateur=U.idUtilisateur where U.idUtilisateur=" . $idUtilisateur . " order by U.idUtilisateur";
    }
    if ($profilUtilisateur != "" && $profilUtilisateur != NULL) {
        $requete = "SELECT U.*, D.idDroit, D.idCourse FROM utilisateur U left outer join droit D on D.idUtilisateur=U.idUtilisateur where U.profilUtilisateur=" . $profilUtilisateur . " order by U.idUtilisateur";
    }
    if ($idCourse != "" && $idCourse != NULL) {
        $requete = "SELECT U.*, D.idDroit, D.idCourse FROM utilisateur U left outer join droit D on D.idUtilisateur=U.idUtilisateur where D.idCourse=" . $idCourse . " order by U.idUtilisateur";
    }


    $array = array();
    $resultats = $dbh->query('SET NAMES UTF8');
    $resultats = $dbh->query($requete);
    $lignes = $resultats->fetchAll(PDO::FETCH_OBJ);
    $i = -1;
    $idUPrecedent = -1;
    $droits = array();
    $first = true;
    foreach ($lignes as $colonne) {

        if ($idUPrecedent != $colonne->idUtilisateur) {
            $idUPrecedent = $colonne->idUtilisateur;

            //*****ON INJECTE DANS LE PRECEDENT UTILIASTEUR LES DROITS SAUF AU TOUT PREMIER PASSAGE
            if ($first) {
                $first = false;
            } else {
                $array[$i]['droits'] = $droits;
            }

            $i++;

            $droits = array();
            $array[$i]['idDroit'] = $colonne->idDroit;
            $array[$i]['idUtilisateur'] = $colonne->idUtilisateur;
            $array[$i]['nomUtilisateur'] = $colonne->nomUtilisateur;
            $array[$i]['prenomUtilisateur'] = $colonne->prenomUtilisateur;
            $array[$i]['emailUtilisateur'] = $colonne->emailUtilisateur;
            $array[$i]['mobileUtilisateur'] = $colonne->mobileUtilisateur;
            $array[$i]['profilUtilisateur'] = $colonne->profilUtilisateur;
        }
        if ($colonne->idCourse != NULL) $droits[] = $colonne->idCourse;
    }
    if ($idUPrecedent != -1) $array[$i]['droits'] = $droits;

    return $array;
}


function deleteReglage($idReglagePhoto, $dbh)
{
    $exec = false;

    // Changement de tous les évenements concerné par le réglage pour mettre le réglage par défaut
    $reqUpdate = $dbh->prepare("UPDATE evenement set idReglagePhoto=1 where idReglagePhoto=?");
    $reqUpdate->bindParam(1, $idReglagePhoto);
    $exec1 = $reqUpdate->execute();

    // Suppression du réglage
    $reqDelete = $dbh->prepare("DELETE FROM reglagePhoto where idReglagePhoto=?");
    $reqDelete->bindParam(1, $idReglagePhoto);
    $exec2 = $reqDelete->execute();


    return $exec2;
}

function deleteEvenement($idEvenement, $dbh)
{
    $exec = false;
    $reqDelete = $dbh->prepare("DELETE FROM evenement where idEvenement=?");
    $reqDelete->bindParam(1, $idEvenement);
    $exec = $reqDelete->execute();


    return $exec;
}

function updateCourse($idCourse, $parametres, $dbh)
{
    $exec = true;
    foreach ($parametres as $key => $value) {
        if ($key != "idC" && $key != "updateCourse") {
            if ($value == "") $value = NULL;
            $reqUpdate = $dbh->prepare("UPDATE course set " . $key . "=? where idCourse=?");
            $reqUpdate->bindParam(1, $value);
            $reqUpdate->bindParam(2, $idCourse);

            $exec1 = $reqUpdate->execute();
            if (!$exec1) $exec = false;
        }
    }
    return $exec;
}

function checkPremierUpdate($idUtilisateur, $dbh)
{
    $requete = "SELECT creationUtilisateur from utilisateur where idUtilisateur=" . $idUtilisateur;
    $creationUtilisateur = 0;
    $resultats = $dbh->query('SET NAMES UTF8');
    $resultats = $dbh->query($requete);
    $lignes = $resultats->fetchAll(PDO::FETCH_OBJ);
    foreach ($lignes as $colonne) {
        $creationUtilisateur = $colonne->creationUtilisateur;
    }

    return $creationUtilisateur;
}

function updateUtilisateur($idUtilisateur, $parametres, $dbh)
{
    $passClair = NULL;
    $emailLogin = NULL;
    $nom = NULL;
    $prenom = NULL;
    $premierUpdate = checkPremierUpdate($idUtilisateur, $dbh);
    $exec = true;
    foreach ($parametres as $key => $value) {
        if ($key != "idU" && $key != "updateUtilisateur" && $key != "passUtilisateurBIS" && $value != 'mdpImprobableuhhhhhhh') {
            if ($value == "") $value = NULL;

            if ($key == 'passUtilisateur') {
                $passClair = $value;
                $value = md5($value);
            } elseif ($key == 'emailUtilisateur') {
                $emailLogin = $value;
            } elseif ($key == 'nomUtilisateur') {
                $nom = $value;
            } elseif ($key == 'prenomUtilisateur') {
                $prenom = $value;
            }

            $reqUpdate = $dbh->prepare("UPDATE utilisateur set " . $key . "=? where idUtilisateur=?");
            $reqUpdate->bindParam(1, $value);
            $reqUpdate->bindParam(2, $idUtilisateur);

            $exec1 = $reqUpdate->execute();
            if (!$exec1) $exec = false;
        }
    }

    if (intval($premierUpdate) == 1) {
        $template = "4";
        $emailOrganisateur = $emailLogin;
        $titre = "Création de votre compte admin TRF";
        $contenu = "Bonjour " . $prenom . " " . $nom . ",<br><br>";
        $contenu .= "Votre compte organisateur sur la plateforme TRF vient d'être créé. Voici vos identifiants :<br><br> Login : <strong>" . $emailLogin . "</strong> <br> Mot de passe : <strong>" . $passClair . "</strong>";
        $contenu .= "<br><br>Vous pouvez dès à présent cliquer sur le lien ci dessous, vous connecter et accéder à la page de personnalisation de votre évènement.";
        $libelleBouton = "Accéder à l'interface administrateur";
        $lienBouton = "https://agenda.trailrunnerfoundation.com/admin/detailUtilisateur.php?idU=" . $idUtilisateur;

        sendmailRporg($emailOrganisateur, $titre, $contenu, $libelleBouton, $lienBouton, $template);

        $reqUpdate = $dbh->prepare("UPDATE utilisateur set creationUtilisateur=1 where idUtilisateur=?");
        $reqUpdate->bindParam(1, $idUtilisateur);
        $reqUpdate->execute();
    }

    return $exec;
}




function insertCourse($libelleCourse, $dbh)
{
    $reqInsert = $dbh->prepare("INSERT INTO course (libelleCourse) VALUES (?)");
    $reqInsert->bindParam(1, $libelleCourse);
    $etatExecution = $reqInsert->execute();
    $idCourse = $dbh->lastInsertId();

    return $idCourse;
}

/*
function uploadImage($target_dir, $nomInputFile, $type)
{
    $base64=NULL;
    $return=array();
    $ext = pathinfo($_FILES[$nomInputFile]["name"], PATHINFO_EXTENSION);
    $erreur=NULL;
    $nomFichier=$type."_".time().".".$ext;
    $target_file = $target_dir.$nomFichier;
    $uploadOk = 1;
    $imageFileType = strtolower($ext);


    if(isset($_POST["submit"]))
    {
        $check = getimagesize($_FILES[$nomInputFile]["tmp_name"]);
        if($check !== false)
        {
            $erreur.= "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            $erreur.= "Ce fichier n'est pas un fichier image";
            $uploadOk = 0;
        }
    }

    if (file_exists($target_file))
    {
        $erreur.="Ce nom de fichier existe déjà<br>";
        $uploadOk = 0;
    }

    if ($_FILES[$nomInputFile]["size"] > 200000)
    {
        $erreur.="Votre fichier est trop lourd et doit peser moins de 1mo";
        $uploadOk = 0;
    }


    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" )
    {
        $erreur.="Veuillez utiliser un format parmi : JPG, JPEG, PNG & GIF<br>";
        $uploadOk = 0;
    }

    if ($uploadOk == 0)
    {
        $erreur.= "Désolé, le téléchargement de l'image a échoué<br>";
    }
    else
    {
        if (move_uploaded_file($_FILES[$nomInputFile]["tmp_name"], $target_file))
        {
            $base64=base64_encode(file_get_contents( $target_file ));
            unlink($target_file);
            $erreur.="Le fichier a bien été téléchargé et enregistré<br>";
            $uploadOk=1;
        }
        else
        {
            $erreur.= "Désolé, une erreur est survenue pendant le téléchargement. Veuillez recommencer<br>";
            $uploadOk=0;
            
        }
    }
    
    
    
    
    $return['codeErreur']='ERROR_UPLOAD';
    if($uploadOk==1) $return['codeErreur']='SUCCESS';
    $return['base64']=$base64;
    $return['message']=$erreur;
    

    return $return;
}

*/




function cleanString($chaine, $maj)
{
    if (trim($chaine) == '' || $chaine == NULL) {
        return NULL;
    } else {
        //SUPPRIMER TOUT ACCENT OU CARACTERE CHELOU SUR UNE LETTRE
        $a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ');
        $b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o');
        $chaine = str_replace($a, $b, $chaine);

        //ON MET TOUT EN MINUSCULE
        $chaine = strtolower($chaine);

        //ON NE GARDE QUE DES LETTRES DE A 0 Z
        $email = NULL;
        if ($maj == 2) $regex = '0-9@\.\-_';
        if ($maj == 3) $regex = '0-9\'';
        $chaine = preg_replace("/[^a-z" . $regex . "]+/", " ", $chaine);

        //SUPPRESSION ESPACES EN TROP
        $chaine = trim($chaine);
        if ($maj == 1 || $maj == 3) {
            $chaine = strtoupper($chaine);
        } else {
            $chaine = ucwords($chaine);
        }
        if ($maj == 2) {
            $chaine = strtolower($chaine);
        }
        return $chaine;
    }
}


/*
function envoiEmailTemplate($titrePrincipal,$sujet,$message,$lien,$email)
{

	global $domaine;
	global $dbh;

    $message2 = file_get_contents('templateEmailFavoris.html');
    $message2 = str_replace('[TITRE_PRINCIPAL]', $titrePrincipal, $message2);
    $message2 = str_replace('[TAG_RESUME_COURSE]', $message, $message2);
    $message2 = str_replace('[TAG_URL_DETAILEQUIPE]', $lien, $message2);

    $mail = new PHPMailer();
    $mail->IsHTML(true);
    $mail->CharSet = "utf-8";
    $mail->From = "nepasrepondre@folomi.fr";
    $mail->FromName = "Folomi Live";
    $mail->Subject = $sujet;
    $mail->Body = stripslashes ($message2);
    $mail->AddAddress($email, $email);
    return $mail->send();
}



function createEditeur($libelleEditeur,$dbh)
{
    $return=false;
    $reqInsert = $dbh->prepare("INSERT INTO editeur (libelleEditeur) VALUES (?)");
    $reqInsert->bindParam(1, $libelleEditeur);
    $return=$reqInsert->execute();

    return $return;
}

function createJeuExemplaire($dbh)
{
    global $idLudotheque;
    $idExemplaire=-1;
    
    //****CREATION JEU******
    $typeJeu='Compétition';
    $difficulteJeu='Familial';
    $dureeJeu=0;
    $litteratieJeu=0;
    $ageMinimumJeu=0;
    $joueursMinJeu=0;
    $joueursMaxJeu=0;
    $surdimensionneJeu=0;
    $valeurNeufJeu=0;
    $dateEditionJeu=date('Y');
    $editeurs=getEditeurs($dbh);
    $idEditeur=$editeurs[0]['idEditeur'];
    $libelleEditeur="Nouveau jeu";
    $reqInsert = $dbh->prepare("INSERT INTO jeu (libelleJeu,idEditeur,typeJeu,difficulteJeu,dureeJeu,litteratieJeu,ageMinimumJeu,joueursMinJeu,joueursMaxJeu,surdimensionneJeu,valeurNeufJeu,dateEditionJeu) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
    $reqInsert->bindParam(1, $libelleEditeur);
    $reqInsert->bindParam(2, $idEditeur);
    $reqInsert->bindParam(3, $typeJeu);
    $reqInsert->bindParam(4, $difficulteJeu);
    $reqInsert->bindParam(5, $dureeJeu);
    $reqInsert->bindParam(6, $litteratieJeu);
    $reqInsert->bindParam(7, $ageMinimumJeu);
    $reqInsert->bindParam(8, $joueursMinJeu);
    $reqInsert->bindParam(9, $joueursMaxJeu);
    $reqInsert->bindParam(10, $surdimensionneJeu);
    $reqInsert->bindParam(11, $valeurNeufJeu);
    $reqInsert->bindParam(12, $dateEditionJeu);
    
    $return=$reqInsert->execute();
    $idJeu=$dbh->lastInsertId();
    
    //****CREATION EXEMPLAIRE******
    $versionExemplaire="A";
    $libelleExemplaire="";
    $dateAjoutExemplaire=date('Y-m-d H:i:s');
    $reqInsert = $dbh->prepare("INSERT INTO exemplaire (idJeu,idLudotheque,versionExemplaire, libelleExemplaire, dateAjoutExemplaire) VALUES (?,?,?,?,?)");
    $reqInsert->bindParam(1, $idJeu);
    $reqInsert->bindParam(2, $idLudotheque);
    $reqInsert->bindParam(3, $versionExemplaire);
    $reqInsert->bindParam(4, $libelleExemplaire);
    $reqInsert->bindParam(5, $dateAjoutExemplaire);
    $return=$reqInsert->execute();
    $idExemplaire=$dbh->lastInsertId();

    return $idExemplaire;
}

function createAdhesion($idAdherent,$dateAdhesion,$cautionVerseeAdhesion,$dbh)
{
    $return=false;
    $reqInsert = $dbh->prepare("INSERT INTO adhesion (idAdherent, dateAdhesion, cautionVerseeAdhesion) VALUES (?,?,?)");
    $reqInsert->bindParam(1, $idAdherent);
    $reqInsert->bindParam(2, $dateAdhesion);
    $reqInsert->bindParam(3, $cautionVerseeAdhesion);
    $return=$reqInsert->execute();

    return $return;
}


function deleteAdhesion($idAdhesion,$dbh)
{
    $return=false;
    $reqDelete = $dbh->prepare("DELETE FROM adhesion where idAdhesion=?");
    $reqDelete->bindParam(1, $idAdhesion);
    $return=$reqDelete->execute();

    return $return;
}



function updateAdhesion($idAdhesion,$cautionVerseeAdhesion,$dbh)
{
    $return=false;
    $reqUpdate = $dbh->prepare("UPDATE adhesion set cautionVerseeAdhesion=? where idAdhesion=?");
    $reqUpdate->bindParam(1, $cautionVerseeAdhesion);
    $reqUpdate->bindParam(2, $idAdhesion);
    $return=$reqUpdate->execute();

    return $return;
}

function getTdb($idLudotheque, $dbh)
{
    $data=array();
    $nbJeux=0;
    $nbExemplaires=0;
    $nbJeuxConsultables=0;
    $nbJeuxEmpruntables=0;
    $nbJeuxSortis=0;
    $nbJeuxRetard=0;
    $nbJeuxHS=0;
    $nbJeuxAReparer=0;
    $nbAdherentsActifs=0;
    $nbAdherentsTotal=0;
    $nbExemplaires=0;
    $idJeux=array();

    $listingJeux=getExemplaire($idLudotheque,NULL,NULL,$dbh);
   
    for($i=0;$i<sizeof($listingJeux);$i++)
    {
        if(!in_array($listingJeux[$i]['idJeu'], $idJeux)) $idJeux[]=$listingJeux[$i]['idJeu'];
        $nbExemplaires++;
        if($listingJeux[$i]['statutExemplaire']=='Sorti')       $nbJeuxSortis++;
        if($listingJeux[$i]['statutExemplaire']=='Empruntable') $nbJeuxEmpruntables++;
        if($listingJeux[$i]['statutExemplaire']=='Consultable') $nbJeuxConsultables++;
        if($listingJeux[$i]['statutExemplaire']=='HS')          $nbJeuxHS++;
        if($listingJeux[$i]['statutExemplaire']=='A réparer')   $nbJeuxAReparer++;
    }
    
    $listingAdherents=getAdherent($idLudotheque,NULL,$dbh);
    for($i=0;$i<sizeof($listingAdherents);$i++)
    {
        $nbAdherentsTotal++;
        if($listingAdherents[$i]['cotisationAJour']==1) $nbAdherentsActifs++;
    }
    
    $data['nbJeux']=sizeof($idJeux);
    $data['nbExemplaires']=$nbExemplaires;
    $data['nbJeuxConsultables']=$nbJeuxConsultables;
    $data['nbJeuxEmpruntables']=$nbJeuxEmpruntables;
    $data['nbJeuxSortis']=$nbJeuxSortis;
    $data['nbJeuxRetard']=getNbRetard($dbh);
    $data['nbAdherentsActifs']=$nbAdherentsActifs;
    $data['nbAdherentsTotal']=$nbAdherentsTotal;
    
    return $data;
}

*/