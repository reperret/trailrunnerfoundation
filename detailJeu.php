<?php 
try {
   

include 'api/bdd.php';
include 'api/fonctionsUtiles.php';
include 'verifAdmin.php';

$listingEditeurs=getEditeurs($dbh);
$listingTypesJeu=getTypesJeu($dbh);
$listingDifficultesJeu=getDifficultesJeu($dbh);
$idExemplaire=NULL;

//********CREATION D'UN JEU VIDE ET D'UN EXEMPLAIRE VIDE*******************
if(isset($_GET['c']) &&  $_GET['c']==1)
{
    $idExemplaire=createJeuExemplaire($dbh);
}


//********CREATION D'UN EXEMPLAIRE VIDE ET RENVOIE FICHE EXEMPLAIRE*******************
if(isset($_GET['e']) &&  $_GET['e']==1 && $_GET['idJeu']!='' )
{
    $idExemplaire=createExemplaire($_GET['idJeu'],$dbh);
    header('detailJeu.php?idE='.$idExemplaire);
}



    
//********RECUPERATION IDEXEMPLAIRE PARAMETRE POST OU GET*******************
if(isset($_POST['idE']) && $_POST['idE']!='' ) $idExemplaire=$_POST['idE'];
if(isset($_GET['idE'])  && $_GET['idE']!=''  ) $idExemplaire=$_GET['idE'];

//********UPDATE INFOS******************************************************
$returnUpdateExemplaire=-1;
 $maVar=NULL;
if(isset($_POST['updateExemplaire']) && $_POST['updateExemplaire']==1)
{
   
 /* $maVar=$_POST['idE']. "idE / ".$_POST['idJeu']."idJeu / ".$_POST['libelleJeu']."libelleJeu / ".$_POST['idEditeur']."idEditeur / ".$_POST['typeJeu']."typeJeu / ".$_POST['dureeJeu']."dureeJeu / ".$_POST['difficulteJeu']."difficulteJeu / ".$_POST['updateExemplaire']."ageMinimumJeu / ".$_POST['joueursMinJeu']."joueursMinJeu / ".$_POST['joueursMaxJeu']."joueursMaxJeu / ".$_POST['dateEditionJeu']."dateEditionJeu / ".$_POST['valeurNeufJeu']."valeurNeufJeu / ".$_POST['mecanismesJeu']."mecanismesJeu / ".$_POST['litteratieJeu']."litteratieJeu / ".$_POST['surdimensionneJeu']."surdimensionneJeu / ".$_POST['descriptionJeu']."descriptionJeu / ".$_POST['contenuJeu']."contenuJeu / ".$_POST['checkinJeu']."checkinJeu / ".$_POST['dateAjoutExemplaire']."dateAjoutExemplaire / ".$_POST['etatExemplaire']."etatExemplaire / ".$_POST['proposeAuPretExemplaire']."proposeAuPretExemplaire / ".$_POST['remarqueExemplaire']."remarqueExemplaire / ".$_POST['typeJeu']."typeJeu";*/
    $returnUpdateExemplaire=updateExemplaire($_POST['idE'],$_POST['idJeu'],$_POST['libelleJeu'],$_POST['idEditeur'],$_POST['typeJeu'],$_POST['dureeJeu'],$_POST['difficulteJeu'],$_POST['ageMinimumJeu'],$_POST['joueursMinJeu'],$_POST['joueursMaxJeu'],$_POST['dateEditionJeu'],$_POST['valeurNeufJeu'],$_POST['mecanismesJeu'],$_POST['litteratieJeu'],$_POST['surdimensionneJeu'],$_POST['descriptionJeu'],$_POST['contenuJeu'],$_POST['checkinJeu'],$_POST['dateAjoutExemplaire'],$_POST['etatExemplaire'],$_POST['proposeAuPretExemplaire'],$_POST['remarqueExemplaire'],$dbh);
}

//********UPDATE DATE RETOUR******************************************************
$returnUpdateDateRetour=-1;
if(isset($_POST['prolongation']) && $_POST['prolongation']==1 )
{
    $returnUpdateDateRetour=updateDateRetour($_POST['idEMP'],$_POST['dateRetourPrevu'], $dbh);
}

//********GESTION DE LA FONCTION RETOUR RAPIDE D'UN EXEMPLAIRE**************
$returnGetBackEmpruntNow=NULL;
if(isset($_GET['r']) && $_GET['r']!='' && isset($_GET['idEM']) && $_GET['idEM']!='' )
{
    $returnGetBackEmpruntNow='KO';
    $returnGetBackEmpruntNow=updateEmprunt($_GET['idEM'],$dbh);
}

//********RECUPERATION INFOS EXEMPLAIRE**************************************
if($idExemplaire!=NULL)
{
    $infosExemplaire=getExemplaire($idLudotheque,$idExemplaire,NULL, $dbh);
    $infosExemplaire=$infosExemplaire[0];
}

//********REDIRECTION ERREUR SI PARAMETRE ERRONE*****************************
if($idExemplaire==NULL || $infosExemplaire==NULL)
{
    header('Location: erreur.php');
    exit(); 
}

//********RECUPERATION LISTE DES EMPRUNTS DE CET EXEMPLAIRE******************
$listingEmprunts=getEmprunts($idLudotheque,NULL,$idExemplaire,NULL,$dbh);





?>
<!DOCTYPE html>
<html lang="fr">


<!-- Mirrored from www.ansonika.com/findoctor/admin_section/user-profile.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 29 Jan 2019 15:12:29 GMT -->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>La cabane à jeux - Admin</title>
	
  <!-- Favicons-->
  <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
  <link rel="apple-touch-icon" type="image/x-icon" href="img/apple-touch-icon-57x57-precomposed.png">
  <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="img/apple-touch-icon-72x72-precomposed.png">
  <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="img/apple-touch-icon-114x114-precomposed.png">
  <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="img/apple-touch-icon-144x144-precomposed.png">

  <!-- GOOGLE WEB FONT -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800" rel="stylesheet">
	
  <!-- Bootstrap core CSS-->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Icon fonts-->
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Plugin styles -->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <link href="vendor/dropzone.css" rel="stylesheet">
          <!-- Plugin styles -->
  <link href="vendor/animate.min.css" rel="stylesheet">
  <link href="vendor/magnific-popup.css" rel="stylesheet">
  <!-- Main styles -->
  <link href="css/admin.css" rel="stylesheet">
  <!-- Your custom styles -->
  <link href="css/custom.css" rel="stylesheet">
    
<!-- Favicons-->
  <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
  <link rel="apple-touch-icon" type="image/x-icon" href="img/apple-touch-icon-57x57-precomposed.png">
  <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="img/apple-touch-icon-72x72-precomposed.png">
  <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="img/apple-touch-icon-114x114-precomposed.png">
  <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="img/apple-touch-icon-144x144-precomposed.png">
    
    
	 <script>
    function suppression()
    {
        return confirm("Voulez vous supprimer définitivement l'exemplaire ?");
    }
    </script>
    
</head>

<body class="fixed-nav sticky-footer" id="page-top">
 
    <?php include 'nav.php';?>
    
    
  <div class="content-wrapper">
    <div class="container-fluid">
        <form action="detailJeu.php" method="post">
      <!-- Breadcrumbs-->
    <!--  <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Add listing</li>
      </ol>-->
        
        

        
        
        <?php if($returnUpdateExemplaire==1){ ?><div class="alert alert-success" role="alert">Mise à jour réussie</div><?php } ?>
        <?php if($returnUpdateExemplaire==0){ ?><div class="alert alert-danger" role="alert">La mise à jour a échoué. Veuillez recommencer</div><?php } ?>
        
		<div class="box_general padding_bottom">
			<div class="header_box version_2">
				<h2><i class="fa fa-id-card-o"></i>Informations  </h2> <p style="display: inline;margin:0 !important;padding:0 !important"><a href="detailJeu.php?e=1&idJeu=<?php echo $infosExemplaire['idJeu'];?>" data-effect="mfp-zoom-in" class="btn_1 gray">Créer un exemplaire</a></p>
			</div>
			<div class="row">
				<div class="col-md-2">
					<div class="form-group">
                        <?php 
                        if($infosExemplaire['photoJeu']!=NULL)
                        {
                            ?>
                            <img src="ressources/photosJeux/<?php echo $infosExemplaire['photoJeu'];?>" width="200px">
                            <?php 
                        }
                        else
                        { 
                            ?>
                            <label>Photo</label>
                            Mettre une dropzone
                            <?php
                        }
                        ?>
                        
				    </div>
				</div>
				<div class="col-md-10 add_top_30">
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label>Libellé</label>
								<input type="text" class="form-control" name="libelleJeu" value="<?php echo $infosExemplaire['libelleJeu'];?>">
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>Editeur</label>
				           <select class="form-control" name="idEditeur" id="idEditeur">
                                       <option value="0"></option>                    
                                 <?php
                                for($i=0;$i<sizeof($listingEditeurs);$i++)
                                {
                                   ?><option value="<?php echo $listingEditeurs[$i]['idEditeur']; ?>" <?php if($listingEditeurs[$i]['idEditeur']==$infosExemplaire['idEditeur']) echo " selected";?>><?php echo $listingEditeurs[$i]['libelleEditeur']; ?></option>

                                <?php 
                                }
                               ?>
                            </select>
                            <a href="creerEditeur.php?idE=<?php echo $idExemplaire;?>">(créer un éditeur)</a>
							</div>
						</div>
                        <div class="col-md-3">
							<div class="form-group">
								<label>Type</label>
								
                                <select class="form-control" name="typeJeu" id="typeJeu">
                                                          
                                 <?php
                                for($i=0;$i<sizeof($listingTypesJeu);$i++)
                                {
                                   ?><option value="<?php echo $listingTypesJeu[$i]; ?>" <?php if($listingTypesJeu[$i]==$infosExemplaire['typeJeu']) echo " selected";?>><?php echo $listingTypesJeu[$i]; ?></option>

                                <?php 
                                }
                               ?>
                            </select>
                                
                                
							</div>
						</div>
                        <div class="col-md-3">
							<div class="form-group">
								<label>Durée</label>
								<input type="text" class="form-control" name="dureeJeu" value="<?php echo $infosExemplaire['dureeJeu'];?>">
							</div>
						</div>
					</div>
					<!-- /row-->
					<div class="row">
								<div class="col-md-3">
							<div class="form-group">
								<label>Difficulté</label>
				
                                
                                <select class="form-control" name="difficulteJeu" id="difficulteJeu">
                                                     
                                 <?php
                                for($i=0;$i<sizeof($listingDifficultesJeu);$i++)
                                {
                                   ?><option value="<?php echo $listingDifficultesJeu[$i]; ?>" <?php if($listingDifficultesJeu[$i]==$infosExemplaire['difficulteJeu']) echo " selected";?>><?php echo $listingDifficultesJeu[$i]; ?></option>

                                <?php 
                                }
                               ?>
                            </select>
                                
                                
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>Age minimum</label>
								<input type="text" class="form-control" name="ageMinimumJeu" value="<?php echo $infosExemplaire['ageMinimumJeu'];?>">
							</div>
						</div>
                        <div class="col-md-3">
							<div class="form-group">
								<label>Joueurs min</label>
								<input type="text" class="form-control" name="joueursMinJeu" value="<?php echo $infosExemplaire['joueursMinJeu'];?>">
							</div>
						</div>
                        <div class="col-md-3">
							<div class="form-group">
								<label>Joueurs max</label>
								<input type="text" class="form-control" name="joueursMaxJeu" value="<?php echo $infosExemplaire['joueursMaxJeu'];?>">
							</div>
						</div>
					</div>
					<!-- /row-->
                    
                    <div class="row">
			
					
                        <div class="col-md-3">
							<div class="form-group">
								<label>Date edition</label>
								<input type="text" class="form-control" name="dateEditionJeu" value="<?php echo $infosExemplaire['dateEditionJeu'];?>">
							</div>
						</div>
                        <div class="col-md-3">
							<div class="form-group">
								<label>Valeur à neuf</label>
								<input type="text" class="form-control" name="valeurNeufJeu" value="<?php echo $infosExemplaire['valeurNeufJeu'];?>">
							</div>
						</div>
                        	<div class="col-md-6">
							<div class="form-group">
								<label>Règles</label>
                                <?php if($infosJeu['reglesJeu']=='' || $infosJeu['reglesJeu']==NULL)
{
    ?><br>Aucune règle disponible<?php
}
else
{
    ?><br><a href="<?php echo $infosJeu['reglesJeu'];?>" target="_blank">Voir les règles</a><?php
}
		?>						
							</div>
						</div>
					</div>
                    
                    
				</div>
			</div>
		</div>
		<!-- /box_general-->
        
		<div class="row">
			<div class="col-md-6">
				<div class="box_general padding_bottom">
					<div class="header_box version_2">
						<h2><i class="fa fa-info-circle"></i>Détails</h2>
					</div>
					
                    <div class="form-group">
						<label>Littératie</label>
                         <select class="form-control" name="litteratieJeu" >
                                <option value="0" <?php if($infosExemplaire['litteratieJeu']=="0") echo " selected";?>>Pas de texte</option>
                                <option value="1" <?php if($infosExemplaire['litteratieJeu']=="1") echo " selected";?>>Peu de texte</option>
                                <option value="2" <?php if($infosExemplaire['litteratieJeu']=="2") echo " selected";?>>Beaucoup de texte</option>
                                <option value="3" <?php if($infosExemplaire['litteratieJeu']=="3") echo " selected";?>>Ecriture requise</option>
                            </select>
                        
						
					</div>
                    <div class="form-group">
						<label>Surdimensionné</label>
                         <select class="form-control" name="surdimensionneJeu" >
                                <option value="0" <?php if($infosExemplaire['surdimensionneJeu']=="0") echo " selected";?>>NON</option>
                                <option value="1" <?php if($infosExemplaire['surdimensionneJeu']=="1") echo " selected";?>>OUI</option>
                            </select>
                        
						
					</div>
                    <div class="form-group">
						<label>Description</label>
						<textarea class="form-control" name="descriptionJeu" rows="7"><?php echo $infosExemplaire['descriptionJeu'];?></textarea>
					</div>
					<div class="form-group">
						<label>Contenu</label>
						<textarea class="form-control"  name="contenuJeu" rows="7"><?php echo $infosExemplaire['contenuJeu'];?></textarea>
					</div>
                    <div class="form-group">
						<label>Checkin</label>
						<textarea class="form-control"  name="checkinJeu" rows="7"><?php echo $infosExemplaire['checkinJeu'];?></textarea>
					</div>
					
				</div>
                
                  
			
		
			</div>
			<div class="col-md-6">
				<div class="box_general padding_bottom">
					<div class="header_box version_2">
                        <h2><i class="fa fa-file"></i>Exemplaire <span class="cbJeuDetail">#<?php echo $infosExemplaire['cbJeu'];?></span></h2> <a href="exemplaires.php?se=1&idEx=<?php echo $idExemplaire;?>"  onclick="return suppression();" >(Supprimer exemplaire)</a>
                        
                        <i class="<?php echo getClassCssStatut($infosExemplaire['statutExemplaire']);?>"><?php echo $infosExemplaire['statutExemplaire'];?></i>
					</div>
					<div class="form-group">
						<label>Date ajout inventaire</label>
						<input class="form-control" name="dateAjoutExemplaire"   type="text" value="<?php echo $infosExemplaire['dateAjoutExemplaire'];?>">
					</div>
					<div class="form-group">
						<label>Etat</label>
                            <select class="form-control" name="etatExemplaire" >
                                <option value="Très bon" <?php if($infosExemplaire['etatExemplaire']=="Très bon") echo " selected";?>>Très bon</option>
                                <option value="Bon" <?php if($infosExemplaire['etatExemplaire']=="Bon") echo " selected";?>>Bon</option>
                                <option value="Correct" <?php if($infosExemplaire['etatExemplaire']=="Correct") echo " selected";?>>Correct</option>
                                <option value="Abimé" <?php if($infosExemplaire['etatExemplaire']=="Abimé") echo " selected";?>>Abimé</option>
                                <option value="A réparer" <?php if($infosExemplaire['etatExemplaire']=="A réparer") echo " selected";?>>A réparer</option>
                                <option value="HS" <?php if($infosExemplaire['etatExemplaire']=="HS") echo " selected";?>>HS</option>
                            </select>
					</div>
                    <div class="form-group">
						<label>Proposé au prêt</label>
                            <select class="form-control" name="proposeAuPretExemplaire" >
                                <option value="1" <?php if($infosExemplaire['proposeAuPretExemplaire']==1) echo " selected";?>>OUI</option>
                                <option value="0" <?php if($infosExemplaire['proposeAuPretExemplaire']==0) echo " selected";?>>NON</option>
                            </select>
					</div>
					<div class="form-group">
						<label>Remarque</label>
						<textarea class="form-control" name="remarqueExemplaire"><?php echo $infosExemplaire['remarqueExemplaire'];?></textarea>
					</div>
                    
         
				</div>
                
                <div class="box_general padding_bottom">
					<div class="header_box version_2">
						<h2><i class="fa fa-file"></i>Mécanismes </h2>  <a href="detailJeuMecanismes.php?idJ=<?php echo $infosExemplaire['idJeu'];?>&idE=<?php echo $idExemplaire;?>" class="btn_1 gray">Gérer les mécanismes</a>
                        
                      
					</div>

                    <div class="form-group">

                        

                        <?php 
                        $listingMecanismesJeu=getMecanismesJeu($infosExemplaire['idJeu'],$dbh);
                        $chaineMecanismes=NULL;
                        foreach($listingMecanismesJeu as $idMecanisme)
                        {
                            $chaineMecanismes.= getMecanismeFromIdMecanisme($idMecanisme,$dbh)." <br> ";
                        }
                         echo $chaineMecanismes;
                        ?>
                        
                        

                    </div>
				</div>
                
                
			</div>
            
         
		</div>
        
      
        
        	<div class="box_general padding_bottom">
					<div class="header_box version_2">
						<h2><i class="fa fa-file"></i>Emprunts </h2>  
                    <br>
  <i class="approved"><?php echo $listingEmprunts['statsEmprunts']['nbEmpruntsTotal'] ;?></i> total<br>  <i class="pending"><?php echo $listingEmprunts['statsEmprunts']['nbEmpruntsEnCours'] ;?></i> en cours <br> <i class="cancel"><?php echo $listingEmprunts['statsEmprunts']['nbEmpruntsRetard'] ;?></i> en retard
                   
					</div>
              
				
              <div class="row">        
                    
                        
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>

                    <th>Adhérent</th>

                    <th>Emprunté</th>
                    <th>Retour prévu</th>
                    <th>Retard</th>
                    <th>Retour effectif</th>
                    <th>Comm.</th>
                    <th>Retour</th>
                    <th>Relance</th>
                 
                </tr>
              </thead>
              <tfoot>
                <tr>

                    <th>Adhérent</th>

                    <th>Emprunté</th>
                    <th>Retour prévu</th>
                    <th>Retard</th>
                    <th>Retour effectif</th>
                    <th>Comm.</th>
                    <th>Retour</th>
                    <th>Relance</th>
                   
                </tr>
              </tfoot>
              <tbody>
                  
                  <?php
                  for($i=0;$i<sizeof($listingEmprunts['listingEmprunts']);$i++)
                  {

                  ?>
 
                <tr>
  
                    <td><a href="detailAdherent.php?idA=<?php echo $listingEmprunts['listingEmprunts'][$i]['idAdherent'];?>"><?php echo $listingEmprunts['listingEmprunts'][$i]['nomAdherent']." ".$listingEmprunts['listingEmprunts'][$i]['prenomAdherent'];?></a></td>
                    
                    <td><?php echo  date_format(date_create($listingEmprunts['listingEmprunts'][$i]['dateEmprunt']), 'd/m/y à H:i:s');?></td>
                    <td><?php  
                      if(isset($_GET['p']) && $_GET['p']==1 &&  $_GET['idEmprunt']==$listingEmprunts['listingEmprunts'][$i]['idEmprunt'])
                      {
                          ?>
                            <form action="detailJeu.php" method="post">
                            <input type="text" name="dateRetourPrevu" value="<?php echo $listingEmprunts['listingEmprunts'][$i]['retourPrevuEmprunt'];?>">
                            <input type="hidden" name="idEMP" value="<?php echo $listingEmprunts['listingEmprunts'][$i]['idEmprunt'];?>">
                            <input type="hidden" name="idE" value="<?php echo $idExemplaire;?>">
                            <input type="hidden" name="prolongation" value="1">
                                
                                <br>
                            <p><button type="submit" class="btn_1 medium">VALIDER</button></p>
                            </form>

                        <?php
                      }
                      else
                      {
                         echo  date_format(date_create($listingEmprunts['listingEmprunts'][$i]['retourPrevuEmprunt']), 'd/m/y'); ?> (<a href="detailJeu.php?idEmprunt=<?php echo $listingEmprunts['listingEmprunts'][$i]['idEmprunt'];?>&p=1&idE=<?php echo $idExemplaire;?>">modifier</a>)  <?php
                      } ?>
                      
                        
                         </td>
                    <td> <?php if($listingEmprunts['listingEmprunts'][$i]['retardEmprunt']<0 && $listingEmprunts['listingEmprunts'][$i]['dateRetourEffectiveEmprunt']==NULL ) { ?><i class="cancel"><?php echo -$listingEmprunts['listingEmprunts'][$i]['retardEmprunt']."j";?></i><?php } ?></td>
                   
                    <td>
                    <?php 
                    if($listingEmprunts['listingEmprunts'][$i]['retardEmprunt']<0)  
                    {
                        ?><span class="retardFinal"><?php echo $listingEmprunts['listingEmprunts'][$i]['dateRetourEffectiveEmprunt']; ?></span><?php
                    }
                    else
                    {
                        echo  date_format(date_create($listingEmprunts['listingEmprunts'][$i]['dateRetourEffectiveEmprunt']), 'd/m/y  à H:i:s');
                    }
                      ?>
                    </td>
                     <td>
                        <?php 
                        if($listingEmprunts['listingEmprunts'][$i]['commentaireEmprunt']!='')
                        {
                        ?>
                        <p class="inline-popups" style="margin:0 !important;padding:0 !important"><a href="#commentaireEmprunt<?php echo $i;?>" data-effect="mfp-zoom-in" class="btn_1 gray"><i class="fa fa-fw fa-eye"></i></a></p>
                        <!-- Reply to review popup -->
                        <div id="commentaireEmprunt<?php echo $i;?>" class="white-popup mfp-with-anim mfp-hide">
                            <div class="small-dialog-header">
                                <h3>Commentaire</h3>
                            </div>
                            <div class="message-reply margin-top-0">
                                <?php echo $listingEmprunts['listingEmprunts'][$i]['commentaireEmprunt'];?>
                            </div>
                        </div>
                        <?php
                        }
                        ?>
                    </td>
                    <td>
                        <?php 
                        if($listingEmprunts['listingEmprunts'][$i]['dateRetourEffectiveEmprunt']==NULL)
                        {
                        ?>
                        <a href="detailJeu.php?idE=<?php echo $idExemplaire;?>&r=1&idEM=<?php echo $listingEmprunts['listingEmprunts'][$i]['idEmprunt'];?>"  class="btn_1 gray"><i class="fa fa-fw fa-undo"></i></a>        
                        <?php
                        }
                        ?>
                    </td>
                    <td><a href="mailto:<?php echo $listingEmprunts['listingEmprunts'][$i]['emailAdherent'];?>?subject=lettre%20de%20relance&body=<?php echo $listingEmprunts['listingEmprunts'][$i]['libelleJeu']." ".$nomLudotheque;?>">Relance</a></td>
            
                  
                    
                   
                </tr>
                  
                  <?php
                  }
                  ?>
                
              </tbody>
            </table>
          </div>
                        
                        
				</div>
        
        </div>
		<!-- /row-->
        <input type="hidden" name="updateExemplaire" value="1">
        <input type="hidden" name="idE" value="<?php echo $idExemplaire;?>">
        <input type="hidden" name="idJeu" value="<?php echo $infosExemplaire['idJeu'];?>">
    
		<center><p><button type="submit" class="btn_1 medium">METTRE A JOUR</button></p></center>
    
      </form>
	  </div>
	  <!-- /.container-fluid-->
   	</div>
    <!-- /.container-wrapper-->
  
    
    <?php include 'footer.php';?>
    
        

    
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Page level plugin JavaScript-->
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="vendor/datatables/jquery.dataTables.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.js"></script>
	<script src="vendor/jquery.selectbox-0.2.js"></script>
	<script src="vendor/retina-replace.min.js"></script>
	<script src="vendor/jquery.magnific-popup.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/admin.js"></script>
	<!-- Custom scripts for this page-->
	<script src="vendor/dropzone.min.js"></script>
    
	<!-- Custom scripts for this page-->
    <script src="js/admin-datatables.js"></script>

<script src="https://static.codepen.io/assets/common/stopExecutionOnTimeout-de7e2ef6bfefd24b79a3f68b414b87b8db5b08439cac3f1012092b2290c719cd.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
	
</body>

<!-- Mirrored from www.ansonika.com/findoctor/admin_section/user-profile.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 29 Jan 2019 15:12:29 GMT -->
</html>
<?php
} catch (Exception $e) {
    echo 'Exception reçue : ',  $e->getMessage(), "\n";
}

?>