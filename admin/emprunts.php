<?php 
include 'api/bdd.php';
include 'api/fonctionsUtiles.php';
include 'verifAdmin.php';


//****Vérification filtre en cours/en retard/rendus*********
$enCours=1;
$enRetard=0;
$rendus=0;

if(isset($_POST['filtre']) && $_POST['filtre']!='')
{
    $filtre=$_POST['filtre'];
}

if(isset($_GET['filtre']) && $_GET['filtre']!='')
{
    $filtre=$_GET['filtre'];
}

if($filtre=='enCours')
{
    $enRetard=0;
    $enCours=1;
    $rendus=0;
}

if($filtre=='enRetard')
{
    $enRetard=1;
    $enCours=0;
    $rendus=0;
}

if($filtre=='rendus')
{
    $enRetard=0;
    $enCours=0;
    $rendus=1;
}


$returnGetBackEmpruntNow=-1;
if(isset($_GET['r']) && $_GET['r']!='' && isset($_GET['idE']) && $_GET['idE']!='' )
{
    $returnGetBackEmpruntNow=updateEmprunt($_GET['idE'],$dbh);
}


$listingEmprunts=getEmprunts($idLudotheque,NULL,NULL, $enCours."$".$enRetard."$".$rendus,$dbh);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>La cabane à jeux - Admin</title>

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
      <!-- Breadcrumbs-->
     <!-- <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Tables</li>
      </ol>-->
		<!-- Example DataTables Card-->
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-exchange"></i> Emprunts </div>
          
          
          
                   <br>
              <div id="filtresPerso">
<form action="emprunts.php" method="post">
    <input type="radio" value="enCours" name="filtre" onChange="this.form.submit()" <?php if($enCours==1) echo " checked";?> >
    En cours
    
    <input type="radio" value="enRetard" name="filtre" onChange="this.form.submit()" <?php if($enRetard==1) echo " checked";?> >
    En retard
    
    <input type="radio" value="rendus" name="filtre" onChange="this.form.submit()" <?php if($rendus==1) echo " checked";?> >
    Rendu
</form>
                  
                  </div>
          
        <?php if($returnGetBackEmpruntNow==1){ ?><div class="alert alert-success" role="alert">Le retour a bien été enregistré</div><?php } ?>
        <?php if($returnGetBackEmpruntNow==0){ ?><div class="alert alert-danger" role="alert">L'enregistrement de retour a échoué. Veuillez recommencer</div><?php } ?>
          
          
        <div class="card-body">
            						

            
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
               <th>Code</th>
                    <th>Adhérent</th>
                    <th>Jeu</th>
                    <th>Checkin</th>
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
                    <th>Code</th>
                    <th>Adhérent</th>
                    <th>Jeu</th>
                    <th>Checkin</th>
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
                    <td>#<?php echo $listingEmprunts['listingEmprunts'][$i]['cbJeu'];?></td>
                    <td><a href="detailAdherent.php?idA=<?php echo $listingEmprunts['listingEmprunts'][$i]['idAdherent'];?>"><?php echo $listingEmprunts['listingEmprunts'][$i]['nomAdherent']." ".$listingEmprunts['listingEmprunts'][$i]['prenomAdherent'];?></a></td>
                    <td><a href="detailJeu.php?idE=<?php echo $listingEmprunts['listingEmprunts'][$i]['idExemplaire'];?>"><?php echo $listingEmprunts['listingEmprunts'][$i]['libelleJeu'];?></a></td>
                       <td>
                        <?php 
                        if($listingEmprunts['listingEmprunts'][$i]['checkinJeu']!='')
                        {
                        ?>
                        <p class="inline-popups" style="margin:0 !important;padding:0 !important"><a href="#description<?php echo $i;?>"  class="btn_1 gray" data-effect="mfp-zoom-in" ><i class="fa fa-fw fa-eye"></i></a></p>
                        <!-- Reply to review popup -->
                        <div id="description<?php echo $i;?>" class="white-popup mfp-with-anim mfp-hide">
                            <div class="small-dialog-header">
                                <h3>Checkin</h3>
                            </div>
                            <div class="message-reply margin-top-0">
                                <?php echo $listingEmprunts['listingEmprunts'][$i]['checkinJeu'];?>
                            </div>
                        </div>
                        <?php
                        }
                        ?>
                        
                    </td>
                    
                    <td><?php echo $listingEmprunts['listingEmprunts'][$i]['dateEmprunt'];?></td>
                    <td><?php echo $listingEmprunts['listingEmprunts'][$i]['retourPrevuEmprunt']; ?>
                    <td> <?php if($listingEmprunts['listingEmprunts'][$i]['retardEmprunt']<0 && $listingEmprunts['listingEmprunts'][$i]['dateRetourEffectiveEmprunt']==NULL ) { ?><i class="cancel"><?php echo -$listingEmprunts['listingEmprunts'][$i]['retardEmprunt']."j";?></i><?php } ?></td>
                    </td>
                    <td>
                    <?php 
                    if($listingEmprunts['listingEmprunts'][$i]['retardEmprunt']<0)  
                    {
                        ?><span class="retardFinal"><?php echo $listingEmprunts['listingEmprunts'][$i]['dateRetourEffectiveEmprunt']; ?></span><?php
                    }
                    else
                    {
                        echo $listingEmprunts['listingEmprunts'][$i]['dateRetourEffectiveEmprunt'];
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
                        <a href="emprunts.php?r=1&idE=<?php echo $listingEmprunts['listingEmprunts'][$i]['idEmprunt'];?>"  class="btn_1 gray"><i class="fa fa-fw fa-undo"></i></a>        
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
        <!--<div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>-->
      </div>
	  <!-- /tables-->
	  </div>
	  <!-- /container-fluid-->
   	</div>
    <!-- /container-wrapper-->
    
   
    
       <?php include 'footer.php';?>
    
    
    
    

	</div>
    
    
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
                "order": [[ 5, "asc" ]],
      "iDisplayLength": 100,
        
    <?php if(isset($_GET['cbJeu']) &&  $_GET['cbJeu']!='')
{?>
        
  "search": 
        {
            "search": "#<?php echo $_GET['cbJeu'];?>"
        },
        
            
<?php
}
?>
        
} );
    </script>


    
	
</body>

<!-- Mirrored from www.ansonika.com/findoctor/admin_section/tables.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 29 Jan 2019 15:12:31 GMT -->
</html>
