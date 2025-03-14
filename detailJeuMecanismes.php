<?php 
include 'api/bdd.php';
include 'api/fonctionsUtiles.php';
include 'verifAdmin.php';

$idJeu=-1;
if(isset($_GET['idJ']) && $_GET['idJ']!='')
{
    $idJeu=$_GET['idJ'];
}

$idExemplaire=-1;
if(isset($_GET['idE']) && $_GET['idE']!='')
{
    $idExemplaire=$_GET['idE'];
}

if(isset($_POST['idJ']) && $_POST['idJ']!='')
{
    $idJeu=$_POST['idJ'];
}

if(isset($_POST['idE']) && $_POST['idE']!='')
{
    $idExemplaire=$_POST['idE'];
}


if(isset($_POST['updateMecanismes']) && $_POST['updateMecanismes']==1)
{
    $returnUpdate=updateMecanismesJeu($idJeu,$_POST['listeMecanismesJeu'],$dbh);
    if($returnUpdate) header('Location: detailJeu.php?idE='.$idExemplaire);
}

$listingMecanismes=getMecanismes($dbh);
$listingMecanismesJeu=getMecanismesJeu($idJeu,$dbh);




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
          <i class="fa fa-paper-plane"></i> Mécanismes du jeu   
  
   
          
          </div>
            <?php 
              $chaineMecanismes=NULL;
              foreach($listingMecanismesJeu as $idMecanisme)
              {
                  $chaineMecanismes.= getMecanismeFromIdMecanisme($idMecanisme,$dbh)." . ";
              }
             
             ?>
   
        
          
          <div class="card-body">
            				
         <strong>Mécanismes : </strong><?php   echo substr($chaineMecanismes,0,-2);?> 
              <br><br>

    
          <div class="table-responsive">
           <form action="detailJeuMecanismes.php" method="post">
            <table class="table table-bordered"  id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                 
                    <th></th>
                    <th>Mécanisme</th>
   
                    
                </tr>
              </thead>
              <tfoot>
                <tr>
                    <th></th>
                    <th>Mécanisme</th>
                </tr>
              </tfoot>
              <tbody>
                  
                  <?php
                  for($i=0;$i<sizeof($listingMecanismes);$i++)
                  {

                  ?>
 
                <tr>
                    
                    <td><input type="checkbox" name="listeMecanismesJeu[]" value="<?php echo $listingMecanismes[$i]['idMecanisme'];?>" <?php if(in_array($listingMecanismes[$i]['idMecanisme'], $listingMecanismesJeu)) echo " checked";?>></td>
                    <td><?php echo $listingMecanismes[$i]['libelleMecanisme'];?></td>
                 
                </tr>
                  
                  <?php
                  }
                  ?>
                
              </tbody>
            </table>
           <input type="hidden" value="<?php echo $idJeu;?>" name="idJ">
           <input type="hidden" value="<?php echo $idExemplaire;?>" name="idE">
           <input type="hidden" value="1" name="updateMecanismes">
            <button class="btn_1 medium" type="submit">ENREGISTRER</button>   
            </form>
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
        
      "iDisplayLength": 200,
        
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
