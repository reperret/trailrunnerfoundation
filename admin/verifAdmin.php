<?php
//**************RECUPERATION DES DROITS**********************
	session_start();
    $emailUtilisateur=NULL;
    $passUtilisateur=NULL;
    $nomUtilisateur=NULL;
    $prenomUtilisateur=NULL;
    $profilUtilisateur=-1;
    $idUtilisateur=NULL;
    $redirect=NULL;
    $rentreDansCookie=false;
    $authExplode=NULL;
    $authExplodeNb=0;
    $hash=NULL;
    if(isset($_COOKIE['authTrfAdmin'])) 
    {
        $authExplode = explode('---', $_COOKIE['authTrfAdmin']);
        if (count($authExplode) === 2) 
        {
            $authExplodeNb=count($authExplode);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $dbh->query('SET NAMES UTF8');
            $resultats = $dbh->query('SELECT * FROM utilisateur WHERE idUtilisateur='.$authExplode[0]);
            $lignes=$resultats->fetchAll(PDO::FETCH_OBJ);

            foreach ($lignes as $colonne)
            {
                $idUtilisateur=$colonne->idUtilisateur;
                $emailUtilisateur=$colonne->emailUtilisateur;	
                $nomUtilisateur=$colonne->nomUtilisateur;
                $prenomUtilisateur=$colonne->prenomUtilisateur;	
                $passUtilisateur=$colonne->passUtilisateur;	
                $profilUtilisateur=$colonne->profilUtilisateur;	
            }	
            $resultats->closeCursor();	

            if ($lignes!=NULL && $authExplode[1] === hash('sha512', $emailUtilisateur.'---'.$passUtilisateur."---_Admin")) 
            {
                $_SESSION['loginAdmin'] = $emailUtilisateur;
                $hash=hash('sha512', $emailUtilisateur.'---'.$passUtilisateur."---_Admin");
            }
        }
    }
    elseif(isset($_SESSION['loginAdmin']) && $_SESSION['loginAdmin'] != NULL )
    {
        $emailUtilisateur=$_SESSION['loginAdmin'];
    }	

    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $dbh->query('SET NAMES UTF8');
    $resultats = $dbh->query('SELECT idUtilisateur, profilUtilisateur, emailUtilisateur FROM utilisateur WHERE emailUtilisateur LIKE "'.$emailUtilisateur.'"');
    $lignes=$resultats->fetchAll(PDO::FETCH_OBJ);

    foreach ($lignes as $colonne)
    {	
        $idUtilisateur=intval($colonne->idUtilisateur);	
        $profilUtilisateur=intval($colonne->profilUtilisateur);	
        $emailUtilisateur=$colonne->emailUtilisateur;	
    }	
    $resultats->closeCursor();	

    if($profilUtilisateur!=0 && $profilUtilisateur!=1 )
    {
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $redirect="login.php?e=1&urlReturn=".urlencode($actual_link);
        header('Location: '.$redirect);
        exit();
    }

    $droitsUtilisateur=array();
    if($profilUtilisateur==0)
    {
        $droitsUtilisateur=getDroitsUtilisateur($idUtilisateur, $dbh);
    }
   


?>
