<?php 
include 'api/bdd.php';
include 'api/fonctionsUtiles.php';
include 'verifAdmin.php';





//********CREATE EMPRUNT******************************************************
$returnCreateAdherent=NULL;
if(isset($_POST['createAdherent']) && $_POST['createAdherent']==1)
{
    $idAdherent=-1; $idAdherent=createAdherent($idLudotheque,$_POST['nomAdherent'],$_POST['prenomAdherent'],$_POST['emailAdherent'],$_POST['telephoneAdherent'],$_POST['accepteNewsAdherent'],$_POST['commentaireAdherent'],date('Y-m-d H:i:s'),$_POST['idProfil'],$dbh);
    if($idAdherent>0)
    {
        header('Location: detailAdherent.php?idA='.$idAdherent);
    }
}





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
              
 
      
      
      
      
      

        <form action="creerAdherent.php" method="post">
      <!-- Breadcrumbs-->
    <!--  <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Add listing</li>
      </ol>-->
        
        

            
            
		<div class="box_general padding_bottom">
			<div class="header_box version_2">
				<h2><i class="fa fa-id-card-o"></i>Informations nouvel adhérent </h2>
       
			</div>
			<div class="row">
				
				<div class="col-md-10 add_top_30">
					<div class="row">
						<div class="col-md-2">
							<div class="form-group">
								<label>Nom</label>
								<input type="text" class="form-control" name="nomAdherent">
							</div>
						</div>
						
                        <div class="col-md-2">
							<div class="form-group">
								<label>Prénom</label>
								<input type="text" class="form-control" name="prenomAdherent">
							</div>
						</div>
                        
                        <div class="col-md-2">
							<div class="form-group">
								<label>Email</label>
								<input type="text" class="form-control" name="emailAdherent">
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label>Téléphone</label>
								<input type="text" class="form-control" name="telephoneAdherent">
							</div>
						</div>
                 
                        <div class="col-md-2">
							<div class="form-group">
								<label>Abonné news</label>
								    <select class="form-control" name="accepteNewsAdherent">
                                        <option value="0">NON</option>
                                        <option value="1">OUI</option >
                                        
                                </select> 
							</div>
						</div>
                        
                        <div class="col-md-2">
							<div class="form-group">
								<label>Profil</label>
								    <select class="form-control" name="idProfil">
                                       <?php
                                        $listingProfil=getProfil($dbh);
                                        for($i=0;$i<sizeof($listingProfil);$i++)
                                        {
                                            ?><option value="<?php echo $listingProfil[$i]['idProfil'];?>"><?php echo $listingProfil[$i]['libelleProfil'];?></option ><?php
                                        }
                                        ?>
                                </select> 
							</div>
						</div>
                        
                        
                        
                 
                       
					</div>
					<!-- /row-->
					<div class="row">
							<div class="col-md-12">
							<div class="form-group">
								<label>Commentaire</label>
								  	<input type="text" class="form-control" name="commentaireAdherent" >
							</div>
						</div>	
					</div>
					<!-- /row-->
                    

                    
                    
				</div>
			</div>
		</div>
		<!-- /box_general-->
            
            

		<!-- /box_general-->
        
       
        <input type="hidden" value="1" name="createAdherent">
		<center><p><button type="submit" class="btn_1 medium">CREER L'ADHERENT</button></p></center>
    
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
