<?php 
include 'api/bdd.php';
include 'api/fonctionsUtiles.php';
include 'verifAdmin.php';
$return=NULL;

//********RECUPERATION IDADHERENTPARAMETRE POST OU GET*******************
$idAdherent=NULL;
if(isset($_POST['idA']) && $_POST['idA']!='' ) $idAdherent=$_POST['idA'];
if(isset($_GET['idA'])  && $_GET['idA']!=''  ) $idAdherent=$_GET['idA'];


//********REDIRECTION ERREUR SI PARAMETRE ERRONE*****************************
if($idAdherent==NULL)
{
    $return='Location: erreur.php';
}

//********CREATION D'UNE ADHESION*****************************
$returnCreateAdhesion=-1;
if(   isset($_POST['createAdhesion'])  && $_POST['createAdhesion']==1 
   && isset($_POST['dateAdhesion'])  && $_POST['dateAdhesion']!=''
   && isset($_POST['cautionVerseeAdhesion'])  && $_POST['cautionVerseeAdhesion']!='')
{
    $dateAdhesion=NULL;
    if($_POST['cautionVerseeAdhesion']!=0) $cautionVerseeAdhesion=$_POST['cautionVerseeAdhesion'];
    $returnCreateAdhesion=createAdhesion($idAdherent,$_POST['dateAdhesion'],$cautionVerseeAdhesion, $dbh);
    if($returnCreateAdhesion==1)
    {
        $return='Location: detailAdherent.php?idA='.$idAdherent.'&successCreateAdhesion=1';
    }
    else
    {
         $return='Location: detailAdherent.php?idA='.$idAdherent.'&successCreateAdhesion=0';
    }
}

if($return!=NULL)
{
    header($return);
    exit(); 
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
              
        <?php if($returnCreateAdhesion==0){ ?><div class="alert alert-danger" role="alert">La création a échoué. Veuillez recommencer</div><?php } ?>
              
     <div class="box_general padding_bottom">
			<div class="header_box version_2">
                <h2><i class="fa fa-id-card-o"></i>Créer une nouvelle adhésion</h2>
			</div>
			<div class="row">
				<div class="col-md-4">
                    
              
					<div class="row">
                        
        <form action="creerAdhesion.php" method="post">
             
                        
						<div class="col-md-12">
							<div class="form-group">
								<label>Date Adhésion</label>
								<input type="text" class="form-control" name="dateAdhesion" value="<?php echo date('Y-m-d H:i:s');?>">
							</div>
						</div>
						
                        <div class="col-md-12">
							<div class="form-group">
								<label>Caution versée</label>
								 <select class="form-control" name="cautionVerseeAdhesion">
                                        <option value="<?php echo date('Y-m-d H:i:s');?>">OUI</option>
                                        <option value="0">NON</option>
                                </select>
							</div>
						</div>
              
            <input type="hidden" name="createAdhesion" value="1">
            <input type="hidden" name="idA" value="<?php echo $idAdherent;?>">
              <button type="submit" class="btn btn-secondary">Créer l'adhésion</button>
          </form>
                        
                        
                        
                 
                       
					</div>
					<!-- /row-->
				
                    

                    
                    
		
                    
                    
                    
				</div>
               
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
