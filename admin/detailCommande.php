
<?php 
try {

include 'api/bdd.php';
include 'api/fonctionsUtiles.php';
include 'verifAdmin.php';

$listingTypesProduits=getTypesProduits($dbh);
    
//********RECUPERATION IDCOMMANDE POST OU GET*******************
$idCommande=NULL;
if(isset($_POST['idC']) && $_POST['idC']!='' ) $idCommande=$_POST['idC'];
if(isset($_GET['idC'])  && $_GET['idC']!=''  ) $idCommande=$_GET['idC'];


$log=NULL;

//********UPDATE COMMANDE******************************************************
$returnUpdateCommande=-1;
if(isset($_POST['updateCommande']) && $_POST['updateCommande']==1)
{
    $log.="log1";
    if(isset($_POST['c']) && $_POST['c']==1)
    {
        $idCommande=creerCommande($dbh);
    }
    
    //******************MISE A JOUR COMMANDE*******************************
    if($_POST['encaissementCommande']==1 || $_POST['liquideCommande']!=0 || $_POST['virementCommande']!=0 || $_POST['chequeCommande']!=0 || $_POST['cbCommande']!=0)
    {
        if($_POST['dateEncaissementCommande']=='')
        {
            $dateEncaissementCommande=date('Y-m-d H:i:s');
        }
        else
        {
            $dateEncaissementCommande=$_POST['dateEncaissementCommande'];
        }
    }
    else
    {
        $dateEncaissementCommande=NULL;
    }
    
    $parametres=array();

    
    $parametres['idCommande']=$idCommande;
    if($_POST['nomCommande']=='' || $_POST['nomCommande']=='')
    {
        $parametres['nomCommande']='NOM PAR DEFAUT';
    }
    else
    {
        $parametres['nomCommande']=$_POST['nomCommande'];
    }
    $parametres['prenomCommande']=$_POST['prenomCommande'];
    $parametres['emailCommande']=$_POST['emailCommande'];
    $parametres['adresseCommande']=$_POST['adresseCommande'];
    $parametres['cpCommande']=$_POST['cpCommande'];
    $parametres['villeCommande']=$_POST['villeCommande'];
    $parametres['dateDerniereModificationCommande']=$_POST['dateDerniereModificationCommande'];
    
    $log.="log2";
    if(isset($_POST['validationFinaleFacturation']) && $_POST['validationFinaleFacturation']==1)
    {
        $log.="log3";
        $parametres['dateFacturationCommande']=date('Y-m-d H:i:s');
        $log.="log4";
        $parametres['numeroCommande']=generateNumeroFacture($idCommande,$dbh);
        $log.="log5";
    }
    $parametres['liquideCommande']=$_POST['liquideCommande'];
    $parametres['virementCommande']=$_POST['virementCommande'];
    $parametres['chequeCommande']=$_POST['chequeCommande'];
    $parametres['cbCommande']=$_POST['cbCommande'];
    $parametres['dateEncaissementCommande']=$dateEncaissementCommande;
    $parametres['etatCommande']=$_POST['etatCommande'];
    $parametres['remiseCommande']=$_POST['remiseCommande'];
    $parametres['commentaireCommande']=$_POST['commentaireCommande'];
    $parametres['commentaireFactureCommande']=$_POST['commentaireFactureCommande'];

    $log.="log6";
    $returnUpdateCommande=updateCommande($parametres,$dbh);
    $log.="log7";
    $j=0;
    //******************MISE A JOUR ITEMS*******************************
    $requetesUpdateDeleteInsert=array();
    for($i=0;$i<sizeof($_POST['Zquantite']);$i++)
    {
        
        //******UPDATE*******
        if($_POST['idItem'][$i]!='' && intval($_POST['Zquantite'][$i])>0 &&  intval($_POST['ancienneQuantite'][$i])!=intval($_POST['Zquantite'][$i]))
        {
            $requetesUpdateDeleteInsert[$j]['typeRequete']="UPDATE";
            $requetesUpdateDeleteInsert[$j]['idCommande']=$idCommande;
            $requetesUpdateDeleteInsert[$j]['chaineAssociationsProduit']=-1;
            if($_POST['chaineAssociationsProduit'][$i]!="") $requetesUpdateDeleteInsert[$j]['chaineAssociationsProduit']=$_POST['chaineAssociationsProduit'][$i];
            $requetesUpdateDeleteInsert[$j]['quantite']=$_POST['Zquantite'][$i];
            $requetesUpdateDeleteInsert[$j]['prixItem']=$_POST['prixItem'][$i];
            $requetesUpdateDeleteInsert[$j]['tvaItem']=$_POST['tvaItem'][$i];
            $requetesUpdateDeleteInsert[$j]['idItem']=$_POST['idItem'][$i];
            $requetesUpdateDeleteInsert[$j]['idProduit']=$_POST['idProduit'][$i];
            if($_POST['commentaireItem'][$i]=='')
            {
                $requetesUpdateDeleteInsert[$j]['commentaireItem']=NULL;
            }
            else
            {
                $requetesUpdateDeleteInsert[$j]['commentaireItem']=$_POST['commentaireItem'][$i];
            }
            $j++;
        }
        //******DELETE*******
        elseif($_POST['idItem'][$i]!='' && intval($_POST['Zquantite'][$i])==0)
        {
            $requetesUpdateDeleteInsert[$j]['typeRequete']="DELETE"; 
            $requetesUpdateDeleteInsert[$j]['idCommande']=$idCommande;
            $requetesUpdateDeleteInsert[$j]['idItem']=$_POST['idItem'][$i];
            $requetesUpdateDeleteInsert[$j]['idProduit']=$_POST['idProduit'][$i];
            $requetesUpdateDeleteInsert[$j]['chaineAssociationsProduit']=-1;
            if($_POST['chaineAssociationsProduit'][$i]!="") $requetesUpdateDeleteInsert[$j]['chaineAssociationsProduit']=$_POST['chaineAssociationsProduit'][$i];
            $j++;
        }
        //******INSERT*******
        elseif($_POST['idItem'][$i]==NULL && intval($_POST['Zquantite'][$i])>0)
        {
            $requetesUpdateDeleteInsert[$j]['typeRequete']="INSERT";
            $requetesUpdateDeleteInsert[$j]['idCommande']=$idCommande;
            $requetesUpdateDeleteInsert[$j]['chaineAssociationsProduit']=-1;
            if($_POST['chaineAssociationsProduit'][$i]!="") $requetesUpdateDeleteInsert[$j]['chaineAssociationsProduit']=$_POST['chaineAssociationsProduit'][$i];
            $requetesUpdateDeleteInsert[$j]['quantite']=$_POST['Zquantite'][$i];
            $requetesUpdateDeleteInsert[$j]['prixItem']=$_POST['prixItem'][$i];
            $requetesUpdateDeleteInsert[$j]['tvaItem']=$_POST['tvaItem'][$i];
            $requetesUpdateDeleteInsert[$j]['idProduit']=$_POST['idProduit'][$i];
            if($_POST['commentaireItem'][$i]=='')
            {
                $requetesUpdateDeleteInsert[$j]['commentaireItem']=NULL;
            }
            else
            {
                    $requetesUpdateDeleteInsert[$j]['commentaireItem']=$_POST['commentaireItem'][$i];
            }
            
            $j++;
        }
        
    }
    $returnUpdateCommande=updateProduitsCommande($requetesUpdateDeleteInsert,$dbh);    
}

if(!(isset($_GET['c']) && $_GET['c']==1))
{
    $detailCommande=getDetailCommande($idCommande,$dbh);
    $listingProduitsCommande=getProduitsCommande($idCommande,$dbh);
}






?>
<!DOCTYPE html>
<html lang="fr">


<!-- Mirrored from www.ansonika.com/findoctor/admin_section/user-profile.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 29 Jan 2019 15:12:29 GMT -->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="Ansonika">
  <title>FINDOCTOR - Admin dashboard</title>
	
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
      <!-- Plugin styles -->
  <link href="vendor/animate.min.css" rel="stylesheet">
  <link href="vendor/magnific-popup.css" rel="stylesheet">
  <!-- Main styles -->
  <link href="css/admin.css" rel="stylesheet">
  <!-- Your custom styles -->
  <link href="css/admin.css" rel="stylesheet">
      <!-- Your custom styles -->
  <link href="css/custom.css" rel="stylesheet">
    
   <script
  src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
  integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8="
  crossorigin="anonymous"></script>
    
      <!-- Favicons-->
  <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
  <link rel="apple-touch-icon" type="image/x-icon" href="img/apple-touch-icon-57x57-precomposed.png">
  <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="img/apple-touch-icon-72x72-precomposed.png">
  <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="img/apple-touch-icon-114x114-precomposed.png">
  <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="img/apple-touch-icon-144x144-precomposed.png">
    
    <script>

         $(document).ready( function () 
        {
            var table = $('#dataTable').DataTable();
            $("#idTypeProduitTOUT").click(function() 
            {
                table.search("").draw();
                 $('html,body').animate({
        scrollTop: $(".content").offset().top},
        'slow');
            });
        } );
        
    <?php
    for($i=0;$i<sizeof($listingTypesProduits);$i++)
    {
        ?>
        $(document).ready( function () 
        {
            var table = $('#dataTable').DataTable();
            $("#idTypeProduit<?php echo $listingTypesProduits[$i]['idTypeProduit'];?>").click(function() 
            {
                table.search("<?php echo $listingTypesProduits[$i]['libelleTypeProduit'];?>").draw();
                 $('html,body').animate({
        scrollTop: $(".content").offset().top},
        'slow');
            });
        } );
      
        <?php
    }
    ?>

    function updateQuantite(numero)
    {
        $('#Zquantite'+numero).val($('#quantite'+numero).val());
    }
    
    function validerFacture()
    {
        document.getElementById("formValiderFacture").submit(); 
    }
   
    function verifierMontants()
    {
       
    
        var datefacturation='<?php echo $detailCommande['informations']['dateFacturationCommande'];?>';
        var encaissement=Number(document.getElementById("encaissementCommande").value);
        var liquide=Number(document.getElementById("liquideCommande").value);  
        var virement=Number(document.getElementById("virementCommande").value);  
        var cheque=Number(document.getElementById("chequeCommande").value);  
        var cb=Number(document.getElementById("cbCommande").value);  
        var total=liquide+virement+cheque+cb;
        
        if(Number(<?php echo $detailCommande['informations']['montantTotalTtc'];?>) == 0 && encaissement==1 )
        {
                alert("Aucune facturation possible pour un montant égal à 0€");
                return false;
        }
        else if(datefacturation=='' && encaissement==1)
        {
                alert("La facture doit être validée avant d'être encaissée");
                return false;
        }
        else
         {
            

                if(liquide!=0 || virement!=0 || cheque!=0 || cb!=0 )
                {
                    if(liquide+virement+cheque+cb!= <?php echo $detailCommande['informations']['montantTotalTtc'] ;?>)
                    {
                        alert ("Attention la répartiion des montant est fausse et le total n'est pas égale à <?php echo $detailCommande['informations']['montantTotalTtc'] ;?> mais à "+total);
                        return false;
                    }
                    else
                    {
                        return true;
                    }
                }
                else
                {
                    if(encaissement==0)
                    {
                       return true;
                    }
                    else
                    {
                        alert("Vous devez remplir la répartition des paiements avant de validation l'encaissement");
                        return false;
                    }

                }
             
         }
       
    }
    </script>
    

</head>

<body class="fixed-nav sticky-footer" id="page-top">
    
    
    <form action="detailCommande.php" id="formValiderFacture" name="formValiderFacture" method="POST">
        <input type="hidden" name="validationFinaleFacturation" value="1">  
        <input type="hidden" name="updateCommande" value="1">
        <input type="hidden" name="idC" value="<?php echo $idCommande;?>">
    </form>
    <?php include 'nav.php';?>
    
    
  <div class="content-wrapper">
    <div class="container-fluid">
        <form action="detailCommande.php" method="POST" onsubmit = "return verifierMontants();">
        
        <?php 
         for($i=0;$i<sizeof($listingProduitsCommande);$i++)
         {
        ?>
        <input type="hidden" value="<?php echo $listingProduitsCommande[$i]['chaineAssociationsProduit'] ;?>" name="chaineAssociationsProduit[]"   id="chaineAssociationsProduit<?php echo $i;?>">
        <input type="hidden" value="<?php echo $listingProduitsCommande[$i]['quantiteItem'] ;?>" name="ancienneQuantite[]"   id="ancienneQuantite<?php echo $i;?>">
        <input type="hidden" value="<?php echo $listingProduitsCommande[$i]['prixProduit'] ;?>" name="prixItem[]"   id="prixItem<?php echo $i;?>">
        <input type="hidden" value="<?php echo $listingProduitsCommande[$i]['tvaProduit'] ;?>"  name="tvaItem[]"    id="tvaItem<?php echo $i;?>">
        <input type="hidden" value="<?php echo $listingProduitsCommande[$i]['idItem'];?>"       name="idItem[]"     id="idItem<?php echo $i;?>">
        <input type="hidden" value="<?php echo $listingProduitsCommande[$i]['idProduit'];?>"    name="idProduit[]"  id="idProduit<?php echo $i;?>">
        <input type="hidden" value="<?php echo $listingProduitsCommande[$i]['commentaireItem'];?>" name="commentaireItem[]"  id="commentaireItem<?php echo $i;?>">

        <?php
         }
        ?>
            
        

  
            
        

        <?php if($returnUpdateCommande==1){ ?><div class="alert alert-success" role="alert">Mise à jour réussie</div><?php } ?>
        <?php if($returnUpdateCommande==0){ ?><div class="alert alert-danger" role="alert">La mise à jour a échoué. Veuillez recommencer</div><?php } ?>
        
		<div class="box_general padding_bottom">
			<div class="header_box version_2">
                
				<h2><i class="fa fa-id-card-o"></i>Détail de commande  <?php echo $log;?><?php if($detailCommande['informations']['numeroCommande']!="") { ?><span class="cbJeuDetail">#<?php echo $detailCommande['informations']['numeroCommande']." - ".$detailCommande['informations']['nomCommande'] ;?></span><?php }
                
                ?> </h2><br>
                <?php  echo $_POST['someName'];  echo $_GET['someName'];?>
                Création : <strong><?php echo  date_format(date_create($detailCommande['informations']['dateCreationCommande']), 'd/m/y  à H:i:s');?><br></strong>
                Modification : <strong><?php echo  date_format(date_create($detailCommande['informations']['dateDerniereModificationCommande']), 'd/m/y  à H:i:s');?></strong>
                <?php
                if($detailCommande['informations']['dateFacturationCommande']!="") { ?><br>Facturation :  <strong> <?php echo date_format(date_create($detailCommande['informations']['dateFacturationCommande']), 'd/m/y  à H:i:s');?></strong><?php }
                
                if($detailCommande['informations']['dateEncaissementCommande']!="") { ?><br>Encaissement :  <strong> <?php echo date_format(date_create($detailCommande['informations']['dateEncaissementCommande']), 'd/m/y  à H:i:s');?></strong><?php }
                
                ?>
			</div>
			<div class="row">
		
				<div class="col-md-12 add_top_30">
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label>Nom</label>
								<input type="text" class="form-control" name="nomCommande" value="<?php echo $detailCommande['informations']['nomCommande'];?>" style="color:#d03100; font-weight:bold">
							</div>
						</div>
                        
                        <div class="col-md-3">
							<div class="form-group">
								<label>Prénom</label>
								<input type="text" class="form-control" name="prenomCommande" value="<?php echo $detailCommande['informations']['prenomCommande'];?>" style="color:#d03100; font-weight:bold">
							</div>
						</div>
                        
                        <div class="col-md-3">
							<div class="form-group">
								<label>Téléphone</label>
								<input type="text" class="form-control" name="telephoneCommande" value="<?php echo $detailCommande['informations']['telephoneCommande'];?>">
							</div>
						</div>
                        
                        
						<div class="col-md-3">
							<div class="form-group">
								<label>Etat</label>
				           <select class="form-control" name="etatCommande" id="etatCommande" style="background-color:#<?php echo getCouleurEtat($detailCommande['informations']['etatCommande']);?>">
                                <option value="0" <?php if($detailCommande['informations']['etatCommande']==0) echo " selected";?>>A TRAITER</option>
                                <option value="1" <?php if($detailCommande['informations']['etatCommande']==1) echo " selected";?>>TRAITEE</option>
                                <option value="2" <?php if($detailCommande['informations']['etatCommande']==2) echo " selected";?>>MANQUE MATERIEL</option>
                                <option value="3" <?php if($detailCommande['informations']['etatCommande']==3) echo " selected";?>>ANNULEE</option>
                            </select>
							</div>
						</div>

					</div>
					<!-- /row-->
					<div class="row">
								
                          <div class="col-md-3">
							<div class="form-group">
								<label>Email</label>
								<input type="text" class="form-control" name="emailCommande" value="<?php echo $detailCommande['informations']['emailCommande'];?>">
							</div>
						</div>
                        
                        
                        <div class="col-md-3">
							<div class="form-group">
								<label>Adresse</label>
								<input type="text" class="form-control" name="adresseCommande" value="<?php echo $detailCommande['informations']['adresseCommande'];?>">
							</div>
						</div>
                        
                        <div class="col-md-3">
							<div class="form-group">
								<label>Code postal</label>
								<input type="text" class="form-control" name="cpCommande" value="<?php echo $detailCommande['informations']['cpCommande'];?>">
							</div>
						</div>
                        
                        <div class="col-md-3">
							<div class="form-group">
								<label>Ville</label>
								<input type="text" class="form-control" name="villeCommande" value="<?php echo $detailCommande['informations']['villeCommande'];?>">
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
						<h2><i class="fa fa-info-circle"></i>Commentaires et remise</h2>
					</div>
					
                    		<div class="form-group">
						<label>Remise en €</label>
                            <select class="form-control" name="remiseCommande" >
                               <?php
                                for($i=0;$i<300;$i++)
                                {
                                    ?><option value="<?php echo $i;?>" <?php if($detailCommande['informations']['remiseCommande']==$i) echo " selected";?>><?php echo $i;?></option><?php
                                } ?>
                                
                            </select>
					</div>
    
  <br><br>
                    <div class="form-group">
						<label>Commentaire Commande</label>
						<textarea class="form-control" name="commentaireCommande" rows="2"><?php echo $detailCommande['informations']['commentaireCommande'];?></textarea>
					</div>
                    <br><br>
					<div class="form-group">
						<label>Commentaire Facture</label>
						<textarea class="form-control"  name="commentaireFactureCommande" rows="2"><?php echo $detailCommande['informations']['commentaireFactureCommande'];?></textarea>
					</div>
    
					
				</div>
                
                  
			
		
			</div>
			<div class="col-md-3">
				<div class="box_general padding_bottom">
					<div class="header_box version_2">
						<h2><i class="fa fa-file"></i>Encaissement</h2>
                        
                         <?php
                    $encaissement=0;
                    if($detailCommande['informations']['dateEncaissementCommande']!='' && $detailCommande['informations']['dateEncaissementCommande']!=NULL)
                    {
                        $encaissement=1;
                    }
                    ?>
					 
                     <select class="form-control" name="encaissementCommande" id="encaissementCommande" style="background-color:#<?php echo getCouleurEncaissement($encaissement);?>">
                                <option value="0" <?php if($encaissement==0)   echo " selected";?>>NON</option>
                                <option value="1" <?php if($encaissement==1)   echo " selected";?>>OUI</option>
                    </select>
                    <input type="hidden" value="<?php echo $detailCommande['informations']['dateEncaissementCommande'];?>" name="dateEncaissementCommande">
                        
					</div>
                
                    <div class="form-group">
						<label>Espèces</label>
						<input type="text" name="liquideCommande" id="liquideCommande" class="form-control" value="<?php echo $detailCommande['informations']['liquideCommande'];?>">
					</div>
                                
                                 <div class="form-group">
						<label>Virement</label>
						<input type="text" name="virementCommande" id="virementCommande" class="form-control" value="<?php echo $detailCommande['informations']['virementCommande'];?>">
					</div>
                                
                                 <div class="form-group">
						<label>Carte Bancaire</label>
						<input type="text" name="chequeCommande"  id="chequeCommande" class="form-control" value="<?php echo $detailCommande['informations']['chequeCommande'];?>">
					</div>
                                
                                 <div class="form-group">
						<label>Chèque</label>
						<input type="text" name="cbCommande"   id="cbCommande" class="form-control" value="<?php echo $detailCommande['informations']['cbCommande'];?>">
					</div>
                    
                    

                    </div>
         
				</div>
            <div class="col-md-3">
				<div class="box_general padding_bottom">
					<div class="header_box version_2">
						<h2><i class="fa fa-file"></i>Facture</h2>
                        
                        
					</div>
					
                    <div class="form-group">
                        
                        <?php
                        if($detailCommande['informations']['dateFacturationCommande']==NULL && $detailCommande['informations']['numeroCommande']==NULL )
                        {
                            ?>
                         <center>
                        

                            <p><button type="submit" class="btn_1 small" style="background-color:#CCC !important;" onclick="validerFacture()">Valider la facture</button></p>
                        
                      
                        <div class="form-group">
                        <a href="facturation/examples/facture.php?idC=<?php echo $detailCommande['informations']['idCommande'];?>" class="grand btn_1 gray" target="_blank">Aperçu PDF</a>
					</div>
                               </center>
                        <?php
                        }
                        else
                        {
                            ?>    
                        <center>
                    <div class="form-group">
                        <a href="facturation/examples/facture.php?idC=<?php echo $detailCommande['informations']['idCommande'];?>" class="grand btn_1 gray" target="_blank">Facture PDF</a>
					</div></center>
                        <?php
                        }
                        ?>
                        
                        <strong>Montant HT </strong> :  <span class="montantNoir"><?php echo $detailCommande['informations']['montantTotalHt'];?>€</span><br>
                        <strong>Montant TVA </strong>:  <span class="montantNoir"><?php echo $detailCommande['informations']['montantTotalTva'];?>€</span><br>
                        <strong>Montant TTC </strong>:  <span class="montantRouge"><?php echo $detailCommande['informations']['montantTotalTtc'];?>€</span> <br><br>
                        
                        <strong>Détail TVA</strong><br>
                        <?php
                        foreach($detailCommande['informations']['montantsTva'] as $key=>$value)
                        {
                            echo " - TVA ".$key." :  <span class=\"montantNoir\">".$value."€</span><br>";
                        }
                        ?><br>
                        
                    </div>


					
                    </div>
         
				</div>
        </div>
		


        <div class="box_general padding_bottom">
            <div class="header_box version_2">
                <h2><i class="fa fa-edit"></i>Gestion des produits</h2>  
                <div class="content"></div>
            </div>

            
                      <div class="card-body">
                           <a href="#" id="idTypeProduitTOUT" class="btn btn-secondary btn-sm">TOUT</a> 
                          <?php
                        for($i=0;$i<sizeof($listingTypesProduits);$i++)
                        {
                            ?>
                            <a href="#" id="idTypeProduit<?php echo $listingTypesProduits[$i]['idTypeProduit'];?>" class="btn btn-secondary btn-sm"><?php echo $listingTypesProduits[$i]['libelleTypeProduit'];?></a> 
                            <?php
                        }
                        ?>

          </div>
            
            
            <div class="row">                       
                <div class="table-responsive">
        <table class="table table-bordered"  id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
                <th>Ajouté</th>
                <th>Type</th>
                <th>Produit</th>
                <th>Comm.</th>
                <th>LOC</th>
                <th>Prix</th>
                <th>Tva</th>
                <th>Quantité</th>
    
            </tr>
          </thead>
          <tfoot>
            <tr>
            <tr>
                <th>Ajouté</th>
                <th>Type</th>
                <th>Produit</th>
                <th>Comm.</th>
                <th>LOC</th>
                <th>Prix</th>
                <th>Tva</th>
                <th>Quantité</th>
               

            </tr>
          </tfoot>
          <tbody>

              <?php
              for($i=0;$i<sizeof($listingProduitsCommande);$i++)
              {
                  
              ?>

            <tr>
                <td <?php if($listingProduitsCommande[$i]['itemPresentCommande']=='OUI') { ?> style="color:#FFF;background-color:#44af62" <?php }?>><?php echo $listingProduitsCommande[$i]['itemPresentCommande'];?></td>
                <td><?php echo $listingProduitsCommande[$i]['libelleTypeProduit'];?></td>
                <td><?php echo $listingProduitsCommande[$i]['libelleProduit'];?>
                <?php
                        if($listingProduitsCommande[$i]['associationsProduit']!=NULL)
                        {?>
                        <p class="inline-popups" style="margin:0 !important;padding:0 !important"><a href="#associations<?php echo $i;?>"   data-effect="mfp-zoom-in" ><i class="fa fa-fw fa-eye"></i>produits associés</a></p>
                        <!-- Reply to review popup -->
                        <div id="associations<?php echo $i;?>" class="white-popup mfp-with-anim mfp-hide">
                            <div class="small-dialog-header">
                                <h3>Produits associés</h3>
                            </div>
                            <div class="message-reply margin-top-0">
                                <?php 
                                for($j=0;$j<sizeof($listingProduitsCommande[$i]['associationsProduit']);$j++)
                                {
                                    echo $listingProduitsCommande[$i]['associationsProduit'][$j]['libelleTypeProduit']." - ".$listingProduitsCommande[$i]['associationsProduit'][$j]['libelleProduit']; echo "<br>";      
                                }
                                ?>

                            </div>
                        </div> 
                        <?php } ?>   
                
                </td>
                <td><?php echo $listingProduitsCommande[$i]['commentaireItem'];?></td>
                <td><?php echo $listingProduitsCommande[$i]['nbJoursProduit']; if($listingProduitsCommande[$i]['nbJoursProduit']>0) echo "J";?></td>
                
                <td><?php echo $listingProduitsCommande[$i]['prixProduit'];?>€</td>
                <td><?php echo $listingProduitsCommande[$i]['tvaProduit'];?></td>

                <td>
                   <select class="form-control" name="quantite[]" id="quantite<?php echo $i;?>" <?php if($listingProduitsCommande[$i]['itemPresentCommande']=='OUI') { ?> style="color:#FFF;background-color:#44af62" <?php }?> onchange="updateQuantite(<?php echo $i;?>)">
                       <?php
                  for($j=0;$j<30;$j++)
                  {
                      ?><option value="<?php echo $j;?>" <?php if($listingProduitsCommande[$i]['quantiteItem']==$j) echo " selected";?>><?php echo $j;?></option><?php
                  } ?>
                    
                   </select>
                
                </td>





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
                <h2><i class="fa fa-edit"></i>Gestion des produits</h2>  
                <div class="content"></div>
            </div>

            Ajouter un produit
         
      
        </div>
            
            
            
		<!-- /row-->
        <input type="hidden" name="updateCommande" value="1">
        <input type="hidden" name="idC" value="<?php echo $idCommande;?>">
        <?php
        $libelleBouton="METTRE A JOUR";
        if(isset($_GET['c']) && $_GET['c']==1)
        {
            $libelleBouton="CREER LA COMMANDE";
           ?> <input type="hidden" name="c" value="1"><?php
        }
        ?>
        <?php 
         for($i=0;$i<sizeof($listingProduitsCommande);$i++)
         {
            ?><input type="hidden" value="<?php echo $listingProduitsCommande[$i]['quantiteItem'];?>" id="Zquantite<?php echo $i;?>" name="Zquantite[]"><?php
         }
        ?>
            
		<center><p><button type="submit" class="btn_1 medium" style="background-color:#000 !important; hover" accesskey="s"><?php echo $libelleBouton;?></button></p></center>
    
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
    <script src="js/admin-datatables.js"></script>
    
    

    
    
        <script>
    $('#dataTable').dataTable( {
          "order": [[ 0, "desc" ]],
      "iDisplayLength": 10,
              
 <?php if(isset($_GET['empruntable']) &&  $_GET['empruntable']==1)
{?>
        
  "search": 
        {
            "search": "Empruntable"
        },
        
            
<?php
}

?>
        
        
        
} );
            
    
            
            
    </script>


    
    
	
</body>

<!-- Mirrored from www.ansonika.com/findoctor/admin_section/tables.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 29 Jan 2019 15:12:31 GMT -->
</html>

<?php
} catch (Exception $e) {
    echo 'Exception reçue : ',  $e->getMessage(), "\n";
}
?>