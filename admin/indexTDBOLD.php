<?php 
include '../api/bdd.php';
include '../api/fonctions.php';
include 'verifAdmin.php';


  //$infosTdb=getTdb($idLudotheque, $dbh);  



?>
<!DOCTYPE html>
<html lang="fr">

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
    <!-- Main styles -->
    <link href="css/admin.css" rel="stylesheet">
    <!-- Your custom styles -->
    <link href="css/custom.css" rel="stylesheet">

</head>

<body class="fixed-nav sticky-footer" id="page-top">

    <?php include 'nav.php';?>



    <div class="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#">Tableau de bord</a>
                </li>

            </ol>
            <!-- Icon Cards-->
            <div class="row">
                <div class="col-xl-2 col-sm-6 mb-2">
                    <div class="card dashboard text-white bg-secondary o-hidden h-100">
                        <div class="card-body">

                            <div class="mr-5">
                                <h5><?php echo $infosTdb['nbJeux'];?> jeux</h5>
                            </div>
                        </div>
                        <a class="card-footer text-white clearfix small z-1" href="exemplaires.php">
                            <span class="float-left">Accéder aux jeux</span>
                            <span class="float-right">
                                <i class="fa fa-angle-right"></i>
                            </span>
                        </a>
                    </div>
                </div>


                <div class="col-xl-2 col-sm-6 mb-2">
                    <div class="card dashboard text-white bg-success o-hidden h-100">
                        <div class="card-body">

                            <div class="mr-5">
                                <h5><?php echo $infosTdb['nbJeuxEmpruntables'];?> jeux empruntables
                            </div>
                        </div>
                        <a class="card-footer text-white clearfix small z-1" href="exemplaires.php?empruntable=1">
                            <span class="float-left">Accéder aux jeux</span>
                            <span class="float-right">
                                <i class="fa fa-angle-right"></i>
                            </span>
                        </a>
                    </div>
                </div>

                <div class="col-xl-2 col-sm-6 mb-2">
                    <div class="card dashboard text-white bg-success o-hidden h-100">
                        <div class="card-body">

                            <div class="mr-5">
                                <h5><?php echo $infosTdb['nbAdherentsActifs'];?> adhérents actifs
                            </div>
                        </div>
                        <a class="card-footer text-white clearfix small z-1" href="adherents.php">
                            <span class="float-left">Voir les adhérents</span>
                            <span class="float-right">
                                <i class="fa fa-angle-right"></i>
                            </span>
                        </a>
                    </div>
                </div>



                <div class="col-xl-2 col-sm-6 mb-2">
                    <div class="card dashboard text-white bg-warning o-hidden h-100">
                        <div class="card-body">

                            <div class="mr-5">
                                <h5><?php echo $infosTdb['nbJeuxSortis'];?> jeux sortis</h5>
                            </div>
                        </div>
                        <a class="card-footer text-white clearfix small z-1" href="emprunts.php?filtre=enCours">
                            <span class="float-left">Voir les emprunts en cours</span>
                            <span class="float-right">
                                <i class="fa fa-angle-right"></i>
                            </span>
                        </a>
                    </div>
                </div>




                <div class="col-xl-2 col-sm-6 mb-2">
                    <div class="card dashboard text-white bg-danger o-hidden h-100">
                        <div class="card-body">

                            <div class="mr-5">
                                <h5><?php echo $infosTdb['nbJeuxRetard'];?> retours en retard</h5>
                            </div>
                        </div>
                        <a class="card-footer text-white clearfix small z-1" href="emprunts.php?filtre=enRetard">
                            <span class="float-left">Voir les retours en retard</span>
                            <span class="float-right">
                                <i class="fa fa-angle-right"></i>
                            </span>
                        </a>
                    </div>
                </div>

            </div>
            <!-- /cards -->
            <br><br><bR>
            <center>
                <a href="adherents.php" class="btn btn-secondary btn-lg">Nouveau prêt</a> <br><br>
                <a href="emprunts.php?filtre=enCours" class="btn btn-secondary btn-lg">Nouveau retour</a> <br><br>
                <a href="creerAdherent.php" class="btn btn-secondary btn-lg">Nouvel adhérent</a> <br><br>


            </center>

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
    <script src="vendor/chart.js/Chart.js"></script>
    <script src="vendor/datatables/jquery.dataTables.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.js"></script>
    <script src="vendor/jquery.selectbox-0.2.js"></script>
    <script src="vendor/retina-replace.min.js"></script>
    <script src="vendor/jquery.magnific-popup.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/admin.js"></script>
    <!-- Custom scripts for this page-->
    <script src="js/admin-charts.js"></script>

</body>

<!-- Mirrored from www.ansonika.com/findoctor/admin_section/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 29 Jan 2019 15:07:05 GMT -->

</html>
