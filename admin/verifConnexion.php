<?php
if (isset($_POST['connexion']) && $_POST['connexion'] == 'Connexion') 
{
	if ((isset($_POST['emailUtilisateur']) && !empty($_POST['emailUtilisateur'])) && (isset($_POST['passUtilisateur']) && !empty($_POST['passUtilisateur']))) 
	{
		$reqInsert = $dbh->prepare('SELECT idUtilisateur, passUtilisateur, profilUtilisateur,emailUtilisateur, count(*) AS nbre FROM utilisateur WHERE emailUtilisateur=? AND passUtilisateur=?');
		$reqInsert->bindParam(1, $login);
		$reqInsert->bindParam(2, $passmd5);
		$login = $_POST['emailUtilisateur'];
		$passmd5 = md5($_POST['passUtilisateur']);
		$reqInsert->execute();
		$lignes=$reqInsert->fetchAll(PDO::FETCH_OBJ);
        
        foreach ($lignes as $colonne)
        {
            if ($colonne->nbre == 1) 
            {
                $some_name = session_name("loginAdmin");
                session_set_cookie_params(0, '/', $domaineCookie);
                session_start();
                $_SESSION['loginAdmin'] = $_POST['emailUtilisateur'];
                $value = $colonne->idUtilisateur.'---'.hash('sha512', $colonne->emailUtilisateur.'---'.$colonne->passUtilisateur."---_Admin");
                setcookie('authTrfAdmin', $value, time() + (7 * 24 * 3600) , "/", $domaineCookie);
                //echo "Cookie: ".$_COOKIE['authTrfAdmin'];
               //echo "Session: ".$_SESSION['loginAdmin'];
                $redirect="index.php"; 
                if(isset($_POST['urlReturn']) && $_POST['urlReturn']!='' )
                $redirect=urldecode($_POST['urlReturn']);
                header('Location: '.$redirect);
                exit();
            }
            elseif ($colonne->nbre == 0) 
            {
                $erreur = 'Compte non reconnu.';
            }
            else 
            {
                $erreur = 'Une erreur fatale est intervenue. Veuillez contacter votre webmaster';
            }
        }
        $reqInsert->closeCursor(); 
	}
	else 
	{
		$erreur = 'Veuillez remplir tous les champs demandés';
	}
}
?>
