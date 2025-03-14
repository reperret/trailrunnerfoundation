<?php 
include 'api/bdd.php';
include 'api/fonctionsUtiles.php';
include 'verifAdmin.php';

$listingJeux=getExemplaire($idLudotheque,NULL,NULL,$dbh);

//********RECUPERATION IDADHERENTPARAMETRE POST OU GET*******************
$idAdherent=NULL;
if(isset($_POST['idA']) && $_POST['idA']!='' ) $idAdherent=$_POST['idA'];
if(isset($_GET['idA'])  && $_GET['idA']!=''  ) $idAdherent=$_GET['idA'];

//********DELETE ADHESION******************************************************
$returnDeleteAdhesion=-1;
if(isset($_GET['idAdhesionToDelete']) && $_GET['idAdhesionToDelete']!='')
{
    $returnDeleteAdhesion=deleteAdhesion($_GET['idAdhesionToDelete'], $dbh);
}

//********UPDATE ADHESION******************************************************
$returnUpdateAdhesion=-1;
if(isset($_GET['marquerCommeVerser']) && $_GET['marquerCommeVerser']!='')
{
    $returnUpdateAdhesion=updateAdhesion($_GET['idAdhesionToUpdate'],date('Y-m-d H:i:s'),$dbh);
}




//*********CREATE ADHESION*************************************************
$returnCreateAdhesion=-1;
if(isset($_GET['successCreateAdhesion'])  && $_GET['successCreateAdhesion']!=''  ) $returnCreateAdhesion=$_GET['successCreateAdhesion'];


//********UPDATE INFOS******************************************************
$returnUpdateAdherent=-1;
if(isset($_POST['updateAdherent']) && $_POST['updateAdherent']==1)
{
    $returnUpdateAdherent=updateAdherent($idAdherent,$_POST['nomAdherent'],$_POST['prenomAdherent'],$_POST['emailAdherent'],$_POST['telephoneAdherent'],$_POST['accepteNewsAdherent'],$_POST['commentaireAdherent'], $dbh);
}

//********CREATE EMPRUNT******************************************************
$returnCreateEmprunt=NULL;
$exemplaireNonDisponible=0;
$exemplaireNonRetrouve=0;
if(isset($_POST['createEmprunt']) && $_POST['createEmprunt']==1)
{
    $idExemplaire=-1;
    $idExemplaire=getIdEFromCode(getAzertyFromQwerty($_POST['codeJeu']),$dbh);
    if($idExemplaire!=-1)
    {
            $statut=getEtatExemplaire($idExemplaire,$dbh);
            $pretPossible=$statut['pretPossible'];
            $statut=$statut['statut'];
            if($statut!='Sorti' &&  $statut!='A réparer' && $statut!='HS'  && $pretPossible==1  )
            {
                $returnCreateEmprunt=createEmprunt($idAdherent,$idExemplaire,$dbh);
            }
            else
            {
                $exemplaireNonDisponible=1;
            }
    }
    else
    {
        $exemplaireNonRetrouve=1;
    }


}

//********GESTION DE LA FONCTION RETOUR RAPIDE D'UN EXEMPLAIRE**************
$returnGetBackEmpruntNow=-1;
if(isset($_GET['r']) && $_GET['r']!='' && isset($_GET['idEM']) && $_GET['idEM']!='' )
{
    $returnGetBackEmpruntNow=updateEmprunt($_GET['idEM'],$dbh);
}

//********RECUPERATION INFOS ADHERENT**************************************
if($idAdherent!=NULL)
{
    $infosAdherent=getAdherent($idLudotheque,$idAdherent,$dbh);
    $infosAdherent=$infosAdherent[0];
}

//********REDIRECTION ERREUR SI PARAMETRE ERRONE*****************************
if($idAdherent==NULL || $infosAdherent==NULL)
{
    header('Location: erreur.php');
    exit(); 
}

//********RECUPERATION LISTE DES EMPRUNTS DE CET ADHERENT******************
$listingEmprunts=getEmprunts($idLudotheque,$idAdherent,NULL,NULL,$dbh);

//********RECUPERATION LISTE DES ADHESION DE L'ADHERENT******************
$listingAdhesions=getAdhesions($idAdherent,$dbh);





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
	
</head>

<body class="fixed-nav sticky-footer" id="page-top">
 
    <?php include 'nav.php';?>
    
    
  <div class="content-wrapper">
      
          <div class="container-fluid">
              
               
        <?php if($returnUpdateAdherent==1){ ?><div class="alert alert-success" role="alert">Mise à jour réussie</div><?php } ?>
        <?php if($returnUpdateAdherent==0){ ?><div class="alert alert-danger" role="alert">La mise à jour a échoué. Veuillez recommencer</div><?php } ?>
              
              
     <div class="box_general padding_bottom">
			<div class="header_box version_2">
				<h2><i class="fa fa-id-card-o"></i>Ajouter un emprunt</h2>
			</div>
			<div class="row">
				<div class="col-md-4">
                    
              
<?php if($infosAdherent['cautionVersee']==1 && $infosAdherent['cotisationAJour']==1)
{?>
<form class="form-inline my-2 my-lg-0 mr-lg-2" method="post" action="detailAdherent2.php">
            <div class="input-group">
                
                
<input list="elements" type="text" name="codeJeu"  class="form-control search-top" autofocus />
			<datalist id="elements">
				<select>
                    <?php
                    for($i=0;$i<sizeof($listingJeux);$i++)
                    { ?>
                       <option value="<?php echo $listingJeux[$i]['cbJeu'];?>"><?php echo $listingJeux[$i]['libelleJeu'];?></option>
                       <?php    
                      
                    }
                        
                    ?>
                                                           
				</select>
			</datalist>
                
                
           <!--   <input name="codeJeu" class="form-control search-top" type="text" placeholder="Scannez un jeu" autofocus>-->
                
                
                
                
                
                
                    <input type="hidden" name="createEmprunt" value="1">
                <input type="hidden" name="idA" value="<?php echo $idAdherent;?>">
              <span class="input-group-btn">
                <button class="btn btn-primary" type="submit">
                  <i class="fa fa-plus"></i>
                </button>
              </span>
            </div>
          </form>
<?php
}
else
{
     echo "L'emprunt n'est pas autorisé car : ";                   
    if($infosAdherent['cotisationAJour']!=1)
    {
        ?><i class="cancel">ADHESION KO</i><?php
    }
    if($infosAdherent['cautionVersee']!=1)
    {
        ?><i class="cancel">CAUTION KO</i><?php
    }
    
}
?>
                    
					
                    
                    
                    
				</div>
                <div class="col-md-8">
			                <?php 
        if($exemplaireNonDisponible && $_POST['createEmprunt']==1)
        {
            ?><h3>CET EXEMPLAIRE N'EST PAS DISPONIBLE A L'EMPRUNT CAR SON ETAT EST : <strong><?php echo $statut; ?></strong></h3><?php
        }
        if($exemplaireNonRetrouve && $_POST['createEmprunt']==1)
        {
            ?><h3>L'IDENTIFIANT NE CORRESPOND A AUCUN EXEMPLAIRE</h3><?php
        }
        elseif($_POST['createEmprunt']==1 && $returnCreateEmprunt)
        {
            ?><h3>EMPRUNT ENREGISTRE</h3><?php
        }
        ?>
 
                    
				</div>
				
			</div>
		</div> 
      
      
      
      
      
      

        <form action="detailAdherent2.php" method="post">
      <!-- Breadcrumbs-->
    <!--  <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Add listing</li>
      </ol>-->
        
        
              
        
        
        <?php if($returnDeleteAdhesion==1){ ?><div class="alert alert-success" role="alert">Suppression de l'adhésion réussie</div><?php } ?>
        <?php if($returnDeleteAdhesion==0){ ?><div class="alert alert-danger" role="alert">La suppression de l'adhésion a échoué. Veuillez recommencer</div><?php } ?>
            
        <?php if($returnCreateAdhesion==1){ ?><div class="alert alert-success" role="alert">Création de l'adhésion réussie</div><?php } ?>
        <?php if($returnCreateAdhesion==0){ ?><div class="alert alert-danger" role="alert">La création de l'adhésion a échoué. Veuillez recommencer</div><?php } ?>
            
        <?php if($returnUpdateAdhesion==1){ ?><div class="alert alert-success" role="alert">Mise à jour de l'adhésion réussie</div><?php } ?>
        <?php if($returnUpdateAdhesion==0){ ?><div class="alert alert-danger" role="alert">La mise à jour de l'adhésion a échoué. Veuillez recommencer</div><?php } ?>            
          
        <?php if($returnGetBackEmpruntNow==1){ ?><div class="alert alert-success" role="alert">Retour du jeu réussi</div><?php } ?>
        <?php if($returnGetBackEmpruntNow==0){ ?><div class="alert alert-danger" role="alert">Le retour du jeu a échoué. Veuillez recommencer</div><?php } ?>  
            
            
		<div class="box_general padding_bottom">
			<div class="header_box version_2">
				<h2><i class="fa fa-id-card-o"></i>Adhérent créé le (<strong><?php echo date_format(date_create($infosAdherent['dateCreationAdherent']), 'd/m/y à H:i:s');?></strong>) </h2>
                <?php 
                                if($infosAdherent['cotisationAJour']==1)
                                {
                                    ?> <i class="approved">ADHESION OK</i><?php
                                }
                                else
                                {
                                   ?> <i class="cancel">ADHESION KO</i><?php
                                }
                
                                if($infosAdherent['cautionVersee']==1)
                                {
                                    ?> <i class="approved">CAUTION OK</i><?php
                                }
                                else
                                {
                                   ?> <i class="cancel">CAUTION KO</i><?php
                                }
                                
                            ?>
			</div>
			<div class="row">
				<div class="col-md-2">
					<div class="form-group">
                        <?php 
                        if($infosAdherent['photoJeu']!=NULL)
                        {
                            ?>
                            <img src="ressources/photosJeux/<?php echo $infosAdherent['photoJeu'];?>" width="200px">
                            <?php 
                        }
                        else
                        { 
                            ?>
                            <label>Photo</label>
                           Photo Adhérent
                            <?php
                        }
                        ?>
                        
				    </div>
				</div>
				<div class="col-md-10 add_top_30">
					<div class="row">
						<div class="col-md-2">
							<div class="form-group">
								<label>Nom</label>
								<input type="text" class="form-control" name="nomAdherent" value="<?php echo $infosAdherent['nomAdherent'];?>">
							</div>
						</div>
						
                        <div class="col-md-2">
							<div class="form-group">
								<label>Prénom</label>
								<input type="text" class="form-control" name="prenomAdherent" value="<?php echo $infosAdherent['prenomAdherent'];?>">
							</div>
						</div>
                        
                        <div class="col-md-2">
							<div class="form-group">
								<label>Email</label>
								<input type="text" class="form-control" name="emailAdherent" value="<?php echo $infosAdherent['emailAdherent'];?>">
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label>Téléphone</label>
								<input type="text" class="form-control" name="telephoneAdherent" value="<?php echo $infosAdherent['telephoneAdherent'];?>">
							</div>
						</div>
                 
                        <div class="col-md-2">
							<div class="form-group">
								<label>Abonné news</label>
								    <select class="form-control" name="accepteNewsAdherent">
                                        <option value="1">OUI</option <?php if("1"==$infosAdherent['accepteNewsAdherent']) echo " selected"; ?>>
                                        <option value="0" <?php if("0"==$infosAdherent['accepteNewsAdherent']) echo " selected"; ?>>NON</option>
                                </select> 
							</div>
						</div>
                        
                        
                        
                 
                       
					</div>
					<!-- /row-->
					<div class="row">
							<div class="col-md-10">
							<div class="form-group">
								<label>Commentaire</label>
								  	<input type="text" class="form-control" name="commentaireAdherent" value="<?php echo $infosAdherent['commentaireAdherent'];?>">
							</div>
						</div>	
					</div>
					<!-- /row-->
                    

                    
                    
				</div>
			</div>
		</div>
		<!-- /box_general-->
            
            

		<!-- /box_general-->
        
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

                    <th>Emprunté</th>
                    <th>Code</th>
                    <th>Libellé</th>
                    <th>Retour prévu</th>
                    <th>Retard</th>
                    <th>Retour effectif</th>
                    <th>Comm.</th>
                    <th>Checkin</th>
                    <th>Retour</th>
                    <th>Relance</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                    <th>Emprunté</th>
                    <th>Code</th>
                    <th>Libellé</th>
                    <th>Retour prévu</th>
                    <th>Retard</th>
                    <th>Retour effectif</th>
                    <th>Comm.</th>
                    <th>Checkin</th>
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
                    <td><?php echo date_format(date_create($listingEmprunts['listingEmprunts'][$i]['dateEmprunt']), 'd/m/y à H:i:s');?></td>
                   <td>#<?php echo $listingEmprunts['listingEmprunts'][$i]['cbJeu'];?></td>
                    <td><a href="detailJeu.php?idE=<?php echo $listingEmprunts['listingEmprunts'][$i]['idExemplaire'];?>"><?php echo $listingEmprunts['listingEmprunts'][$i]['libelleJeu'];?></a></td>
                    <td><?php echo date_format(date_create($listingEmprunts['listingEmprunts'][$i]['retourPrevuEmprunt']), 'd/m/y'); ?>
                    <td> <?php if($listingEmprunts['listingEmprunts'][$i]['retardEmprunt']<0 && $listingEmprunts['listingEmprunts'][$i]['dateRetourEffectiveEmprunt']==NULL ) { ?><i class="cancel"><?php echo -$listingEmprunts['listingEmprunts'][$i]['retardEmprunt']."j";?></i><?php } ?></td>
                    </td>
                    <td>
                    <?php 
                      if($listingEmprunts['listingEmprunts'][$i]['dateRetourEffectiveEmprunt']!=NULL)
                      {
                                 if($listingEmprunts['listingEmprunts'][$i]['retardEmprunt']<0)  
                                {
                                    ?><span class="retardFinal"><?php echo date_format(date_create($listingEmprunts['listingEmprunts'][$i]['dateRetourEffectiveEmprunt']), 'd/m/y'); ?></span><?php
                                }
                                else
                                {
                                     echo date_format(date_create($listingEmprunts['listingEmprunts'][$i]['dateRetourEffectiveEmprunt']), 'd/m/y  à H:i:s'); 
                                }
                      }
                      else
                      {
                          echo "";
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
                        if($listingEmprunts['listingEmprunts'][$i]['checkinJeu']!='')
                        {
                        ?>
                        <p class="inline-popups" style="margin:0 !important;padding:0 !important"><a href="#checkinJeu<?php echo $i;?>" data-effect="mfp-zoom-in" class="btn_1 gray"><i class="fa fa-fw fa-eye"></i></a></p>
                        <!-- Reply to review popup -->
                        <div id="checkinJeu<?php echo $i;?>" class="white-popup mfp-with-anim mfp-hide">
                            <div class="small-dialog-header">
                                <h3>Commentaire</h3>
                            </div>
                            <div class="message-reply margin-top-0">
                                <?php echo $listingEmprunts['listingEmprunts'][$i]['checkinJeu'];?>
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
                        <a href="detailAdherent2.php?idA=<?php echo $idAdherent;?>&r=1&idEM=<?php echo $listingEmprunts['listingEmprunts'][$i]['idEmprunt'];?>"  class="btn_1 gray"><i class="fa fa-fw fa-undo"></i></a>        
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
      
      
      <div class="box_general padding_bottom">
					<div class="header_box version_2">
						<h2><i class="fa fa-file"></i>Historique des adhésions </h2>  
                    
					</div>
              
				
         
     
          <a href="creerAdhesion.php?idA=<?php echo $idAdherent;?>" class="btn btn-secondary">Nouvelle adhésion</a>
         
          <br><br>
              <div class="row">        
                    
                        
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>

                    <th>Date adhésion</th>
                    <th>Caution versée</th>
                    <th>Supprimer</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                      <th>Date adhésion</th>
                    <th>Caution versée</th>
                    <th>Supprimer</th>
                </tr>
              </tfoot>
              <tbody>
                  
                  <?php
                  for($i=0;$i<sizeof($listingAdhesions);$i++)
                  {

                  ?>
 
                <tr>
                    <td><?php echo date_format(date_create($listingAdhesions[$i]['dateAdhesion']), 'd/m/y à H:i:s'); ?></td>
                    <td><?php 
                      if($listingAdhesions[$i]['cautionVerseeAdhesion']==NULL || $listingAdhesions[$i]['cautionVerseeAdhesion']=='')
                      {
                          ?><i class="cancel">KO</i> <a href="detailAdherent2.php?idA=<?php echo $idAdherent;?>&marquerCommeVerser=1&idAdhesionToUpdate=<?php echo $listingAdhesions[$i]['idAdhesion'];?>">marquer comme versée</a><?php
                      }
                      else
                      {
                          ?><i class="approved">OK</i> (<?php echo date_format(date_create($listingAdhesions[$i]['cautionVerseeAdhesion']), 'd/m/y à H:i:s');?> )<?php
                      }
                      
                        
                        ?></td>
                    <td><a href="detailAdherent2.php?idA=<?php echo $idAdherent."&idAdhesionToDelete=".$listingAdhesions[$i]['idAdhesion'] ;?>">Suppr.</a></td>
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
        <input type="hidden" name="updateAdherent" value="1">
        <input type="hidden" name="idA" value="<?php echo $idAdherent;?>">
    
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
	
</body>

<!-- Mirrored from www.ansonika.com/findoctor/admin_section/user-profile.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 29 Jan 2019 15:12:29 GMT -->
</html>
