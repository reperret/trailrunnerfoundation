<?php 
include '../api/bdd.php';
include '../api/fonctions.php';
include 'verifAdmin.php';

//******SUPPRESSION D'UNE UTILISATEUR*************
$returnDeleteUtilisateur=false;
if(isset($_GET['s']) && $_GET['s']==1 && $_GET['idU']!='')
{
    $returnDeleteUtilisateur=deleteUtilisateur($_GET['idU'],$dbh);
}

$listingUtilisateurs=getUtilisateurs(NULL,NULL,NULL,$dbh);

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>TRF - Admin</title>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="Ansonika">
        <title>TRF - Admin</title>

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

        <script>
            function suppression() {
                return confirm("Voulez vous supprimer définitivement cet utilisateur ?");
            }

        </script>
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
                    <i class="fa fa-users"></i> Utilisateurs <p style="display: inline;margin:0 !important;padding:0 !important"><a href="detailUtilisateur.php?c=1" data-effect="mfp-zoom-in" class="btn_1 gray">Créer un utilisateur</a></p>




                </div>



                <?php if($returnDeleteUtilisateur)        echo "<center><h3>Cet utilisateur a bien été supprimé</h3></center>";?>


                <br>


                <div class="card-body">



                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <?php
                                    if(isset($_GET['d']) && $_GET['d']==1)
                                    {
                                        ?><th>Droit</th><?php
                                    }
                                    ?>
                                    <th>Nom</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Profil</th>
                                    <th>Suppr.</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <?php
                                    if(isset($_GET['d']) && $_GET['d']==1)
                                    {
                                        ?><th>Droit</th><?php
                                    }
                                    ?>

                                    <th>Nom</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Profil</th>
                                    <th>Suppr.</th>
                                </tr>
                            </tfoot>
                            <tbody>


                                <?php
                  $i=0;
                  foreach($listingUtilisateurs as $utilisateur)
                  {

                  ?>

                                <tr>
                                    <?php
                                    if(isset($_GET['d']) && $_GET['d']==1)
                                    {
                                        ?><td><a href="detailCourse.php?idC=<?php echo $_GET['idC'];?>&au=1&idU=<?php echo $utilisateur['idUtilisateur'];?>">AJOUTER A LA COURSE : <?php echo $_GET['lb'];?></a></td><?php
                                    }
                                    ?>

                                    <td><a class="libelleJeu" href="detailUtilisateur.php?idU=<?php echo $utilisateur['idUtilisateur'] ;?>"><?php echo $utilisateur['nomUtilisateur']." ".$utilisateur['prenomUtilisateur'];?></a></td>
                                    <td><?php echo $utilisateur['emailUtilisateur'];?></td>
                                    <td><?php echo $utilisateur['mobileUtilisateur'];?></td>
                                    <td>
                                        <?php 
                                        if($utilisateur['profilUtilisateur']==1)
                                        {
                                            ?><span class="badge badge-success">ADMIN</span><?php
                                        }
                                          elseif($utilisateur['profilUtilisateur']==0)
                                          {
                                                ?><span class="badge badge-primary">ORGA</span><?php
                                          }
                                        
                                        ?>
                                    </td>


                                    <td><a href="utilisateurs.php?s=1&idU=<?php echo $utilisateur['idUtilisateur'];?>" onclick="return suppression();"><img src="img/supprimer.png"></a></td>
                                </tr>

                                <?php
                      $i++;
                  }
                  ?>

                            </tbody>
                        </table>
                        <br><br>

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
        $('#dataTable').dataTable({
            "order": [
                [1, "asc"]
            ],
            "iDisplayLength": 200,

            <?php if(isset($_GET['cbJeu']) &&  $_GET['cbJeu']!='')
{?>

            "search": {
                "search": "#<?php echo $_GET['cbJeu'];?>"
            },


            <?php
}

?>

            <?php if(isset($_GET['empruntable']) &&  $_GET['empruntable']==1)
{?>

            "search": {
                "search": "Empruntable"
            },


            <?php
}

?>



        });



        $('#select-all').click(function(event) {
            if (this.checked) {
                // Iterate each checkbox
                $(':checkbox').each(function() {
                    this.checked = true;
                });
            } else {
                $(':checkbox').each(function() {
                    this.checked = false;
                });
            }
        });

    </script>





</body>

<!-- Mirrored from www.ansonika.com/findoctor/admin_section/tables.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 29 Jan 2019 15:12:31 GMT -->

</html>
