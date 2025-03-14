<?php 
include 'api/bdd.php';
include 'api/fonctionsUtiles.php';
include 'verifAdmin.php';



$listingAdherents=getAdherent($idLudotheque,NULL,$dbh);

?>
<!DOCTYPE html>
<html lang="fr">

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
          <i class="fa fa-user"></i> Adhérents  <p class="inline-popups" style="display: inline;margin:0 !important;padding:0 !important"><a href="#listingEmail" data-effect="mfp-zoom-in" class="btn_1 gray">Listing emails</a></p>  <p style="display: inline;margin:0 !important;padding:0 !important"><a href="creerAdherent.php" data-effect="mfp-zoom-in" class="btn_1 gray">Créer un adhérent</a></p> </div>
        <div class="card-body">
            						

            
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                    <th>id</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Profil</th>
                    <th>Email</th>
                    <th>Tel</th>
                    <th>Comm.</th>
                    <th>Adhésion</th>
                    <th>Caution</th>
                    <th>En cours</th>
                    <th>En retard</th>
                    <th>Tot. Emp.</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                    <th>id</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Profil</th>
                    <th>Email</th>
                    <th>Tel</th>
                    <th>Comm.</th>
                    <th>Adhésion</th>
                    <th>Caution</th>
                    <th>En cours</th>
                    <th>En retard</th>
                    <th>Total Emprunts</th>
                </tr>
              </tfoot>
              <tbody>
                  
                  <?php
                  for($i=0;$i<sizeof($listingAdherents);$i++)
                  {

                  ?>
 
                <tr>
                    <td>#<?php echo $listingAdherents[$i]['idAdherent'];?></td>
                    <td><a class="libelleJeu" href="detailAdherent.php?idA=<?php echo $listingAdherents[$i]['idAdherent'];?>"><?php echo $listingAdherents[$i]['nomAdherent'];?></a></td>
                    <td><?php echo $listingAdherents[$i]['prenomAdherent'];?></td>
                    <td><?php echo $listingAdherents[$i]['profilAdherent'];?></td>
                    <td><?php echo $listingAdherents[$i]['emailAdherent'];?></td>
                    <td><?php echo $listingAdherents[$i]['telephoneAdherent'];?></td>
                     <td>
                        <?php 
                        if($listingAdherents[$i]['commentaireAdherent']!='')
                        {
                        ?>
                        <p class="inline-popups" style="margin:0 !important;padding:0 !important"><a href="#commentaireAdherent<?php echo $i;?>" data-effect="mfp-zoom-in" class="btn_1 gray"><i class="fa fa-fw fa-eye"></i></a></p>
                        <!-- Reply to review popup -->
                        <div id="commentaireAdherent<?php echo $i;?>" class="white-popup mfp-with-anim mfp-hide">
                            <div class="small-dialog-header">
                                <h3>Description</h3>
                            </div>
                            <div class="message-reply margin-top-0">
                                <?php echo $listingAdherents[$i]['commentaireAdherent'];?>
                            </div>
                        </div>
                        <?php
                        }
                        ?>
                    </td>
                    

                    
                    <td><?php if($listingAdherents[$i]['cotisationAJour']==1) 
                            { ?><span class="badge badge-success">OK</span><?php 
                            }
                        else {?><span class="badge badge-secondary">KO</span><?php }?></td>
                    
                
                        <td><?php if($listingAdherents[$i]['cautionVersee']==1) 
                            { ?><span class="badge badge-success">OK</span><?php 
                            }
                        else {?><span class="badge badge-secondary">KO</span><?php }?></td>
                    
                    <td>
                        <?php if($listingAdherents[$i]['nbEmpruntsRetard']>0)
                        {?>
                            <i class="pending"><?php echo $listingAdherents[$i]['nbEmpruntsEnCours'];?></i>
                        <?php
                        }?>
         
                    </td>
                    <td>
                    <?php if($listingAdherents[$i]['nbEmpruntsRetard']>0)
                        {?>
                            <i class="cancel"><?php echo $listingAdherents[$i]['nbEmpruntsRetard'];?></i>
                        <?php
                        }?>
                        
                    </td>
                    <td><?php echo $listingAdherents[$i]['nbEmpruntsTotal'];?></td>
                   
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
    
    
    
    

    <!-- POPUP LISTING EMAIL -->
	<!-- Reply to review popup -->
    <?php
    $listingEmail=getListingEmail($idLudotheque, $dbh);
    ?>
	<div id="listingEmail" class="white-popup mfp-with-anim mfp-hide">
		<div class="small-dialog-header">
			<h3>Listing emails contactables</h3>
		</div>
		<div class="message-reply margin-top-0">
			<div class="form-group">
				<textarea cols="40" rows="3" class="form-control"><?php for($i=0;$i<sizeof($listingEmail);$i++)
                {
                    echo $listingEmail[$i]['emailAdherent'].";";
                }
                ?></textarea>
			</div>
		
		</div>
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
        "order": [[ 1, "asc" ]],
            "iDisplayLength": 100,
         <?php if(isset($_GET['idA']) &&  $_GET['idA']!='')
{?>  
  "search": {
    "search": "#<?php echo $_GET['idA'];?>"
  }
     <?php   }
?>
} );
    </script>
    



    
	
</body>

<!-- Mirrored from www.ansonika.com/findoctor/admin_section/tables.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 29 Jan 2019 15:12:31 GMT -->
</html>
