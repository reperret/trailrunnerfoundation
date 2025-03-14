<?php 
include '../api/bdd.php';
include '../api/fonctions.php';
include 'verifAdmin.php';

//******SUPPRESSION JEU ET TOUS SES EXEMPLAIRES*************
$returnDeleteJeu=false;
if(isset($_GET['s']) && $_GET['s']==1 && $_GET['idJeu']!='')
{
    $returnDeleteJeu=deleteJeu($_GET['idJeu'],$dbh);
}

//******SUPPRESSION D'UN EXEMPLAIRE*************
$returnDeleteExemplaire=false;
if(isset($_GET['se']) && $_GET['se']==1 && $_GET['idEx']!='')
{
    $returnDeleteExemplaire=deleteExemplaire($_GET['idEx'],$dbh);
}

//****Vérification filtre HS et à réparer*********
$actifs=0;
$hs=0;
$areparer=0;
if(!isset($_POST['hs']) && !isset($_POST['areparer'])) $actifs=1;

if(isset($_POST['hs']) && $_POST['hs']==1)
{
    $hs=1;
}
if(isset($_POST['areparer']) && $_POST['areparer']==1)
{
    $areparer=1;
}

if(isset($_POST['actifs']) && $_POST['actifs']==1)
{
    $actifs=1;
}


//$listingExemplaires=getExemplaire($idLudotheque,NULL,$actifs."$".$hs."$".$areparer,$dbh);


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

        <script>
            function suppression() {
                return confirm("Voulez vous supprimer définitivement le jeu et tous ses exemplaires ?");
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
                    <i class="fa fa-paper-plane"></i> Jeux <p style="display: inline;margin:0 !important;padding:0 !important"><a href="detailJeu.php?c=1" data-effect="mfp-zoom-in" class="btn_1 gray">Créer un jeu</a></p>



                </div>



                <?php if($returnDeleteJeu)        echo "<center><h3>Le jeu et ses exemplaires ont bien été supprimés</h3></center>";?>
                <?php if($returnDeleteExemplaire) echo "<center><h3>L'exemplaire a bien été supprimé</h3></center>";?>


                <br>
                <div id="filtresPerso">
                    <form action="exemplaires.php" method="post">
                        <input type="checkbox" value="1" name="actifs" onChange="this.form.submit()" <?php if($actifs==1) echo " checked";?>>
                        Actifs

                        <input type="checkbox" value="1" name="hs" onChange="this.form.submit()" <?php if($hs==1) echo " checked";?>>
                        HS

                        <input type="checkbox" value="1" name="areparer" onChange="this.form.submit()" <?php if($areparer==1) echo " checked";?>>
                        A réparer
                    </form>

                </div>


                <div class="card-body">




                    <div class="table-responsive">
                        <form action="etiquettes/examples/new2.php" method="post">
                            <table class="table table-bordered" style="font-size:0.8em" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>

                                        <th>Code</th>
                                        <th>Nom</th>
                                        <th>Statut</th>
                                        <th>Age mini</th>
                                        <th>J. min</th>
                                        <th>J. max</th>
                                        <th>Durée</th>
                                        <th>Type</th>
                                        <th>Mécani.</th>
                                        <th>Littera.</th>
                                        <th>Diffi.</th>
                                        <th>Descr.</th>
                                        <th>Règles</th>
                                        <th>Rem.</th>
                                        <th>Contenu</th>
                                        <th>Check</th>
                                        <th>Date ajout</th>
                                        <th>Supp.</th>

                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>

                                        <th>Code</th>
                                        <th>Nom</th>
                                        <th>Statut</th>
                                        <th>Age min</th>
                                        <th>J.min</th>
                                        <th>J.max</th>
                                        <th>Durée</th>
                                        <th>Type</th>
                                        <th>Mécan.</th>
                                        <th>Litte.</th>
                                        <th>Diff.</th>
                                        <th>Desc.</th>
                                        <th>Règl.</th>
                                        <th>Rem.</th>
                                        <th>Cont.</th>
                                        <th>Check</th>
                                        <th>Date ajout</th>
                                        <th>Supp.</th>
                                    </tr>
                                </tfoot>
                                <tbody>

                                    <?php
                  for($i=0;$i<sizeof($listingExemplaires);$i++)
                  {

                  ?>

                                    <tr>

                                        <td><input type="checkbox" name="listeJeuxAImprimer[]" value="<?php echo $listingExemplaires[$i]['idExemplaire'];?>">#<?php echo $listingExemplaires[$i]['cbJeu'];?></td>
                                        <td><a class="libelleJeu" href="detailJeu.php?idE=<?php echo $listingExemplaires[$i]['idExemplaire'] ;?>"><?php echo $listingExemplaires[$i]['libelleJeu'];?></a></td>
                                        <td><i class="<?php echo getClassCssStatut($listingExemplaires[$i]['statutExemplaire']);?>" style="font-size:0.9em"><?php echo $listingExemplaires[$i]['statutExemplaire'];?></i></td>
                                        <td><?php echo $listingExemplaires[$i]['ageMinimumJeu'];?></td>
                                        <td><?php echo $listingExemplaires[$i]['joueursMinJeu'];?></td>
                                        <td><?php echo $listingExemplaires[$i]['joueursMaxJeu'];?></td>
                                        <td><?php echo $listingExemplaires[$i]['dureeJeu'];?></td>
                                        <td><?php echo $listingExemplaires[$i]['typeJeu'];?></td>
                                        <td>
                                            <?php 
                        $listingMecanismesJeu=getMecanismesJeu($listingExemplaires[$i]['idJeu'],$dbh);
                        $chaineMecanismes=NULL;
                        foreach($listingMecanismesJeu as $idMecanisme)
                        {
                            $chaineMecanismes.= getMecanismeFromIdMecanisme($idMecanisme,$dbh)." . ";
                        }
                         echo $chaineMecanismes;
                        ?>

                                        </td>
                                        <td>
                                            <span style="font-weight: bold;  color: #<?php echo getCouleurLitteratie($listingExemplaires[$i]['litteratieJeu']);?>;padding: 0px; margin :0px; "><?php echo getLibelleLitteratie($listingExemplaires[$i]['litteratieJeu']);?>
                                            </span></td>
                                        </td>
                                        <td>
                                            <span style="font-weight: bold;  color: #<?php echo getCouleurJeu($listingExemplaires[$i]['difficulteJeu']);?>;padding: 0px; margin :0px; "><?php echo $listingExemplaires[$i]['difficulteJeu'];?>
                                            </span></td>
                                        <td>
                                            <?php 
                        if($listingExemplaires[$i]['descriptionJeu']!='')
                        {
                        ?>
                                            <p class="inline-popups" style="margin:0 !important;padding:0 !important"><a href="#description<?php echo $i;?>" class="btn_1 gray" data-effect="mfp-zoom-in"><i class="fa fa-fw fa-eye"></i></a></p>
                                            <!-- Reply to review popup -->
                                            <div id="description<?php echo $i;?>" class="white-popup mfp-with-anim mfp-hide">
                                                <div class="small-dialog-header">
                                                    <h3>Description</h3>
                                                </div>
                                                <div class="message-reply margin-top-0">
                                                    <?php echo $listingExemplaires[$i]['descriptionJeu'];?>
                                                </div>
                                            </div>
                                            <?php
                        }
                        ?>

                                        </td>
                                        <td>
                                            <?php 
                        if($listingExemplaires[$i]['reglesJeu']!='')
                        {
                        ?>
                                            <a href="<?php echo $listingExemplaires[$i]['reglesJeu'];?>" data-effect="mfp-zoom-in" class="btn_1 gray" target="_blank"><i class="fa fa-fw fa-eye"></i></a>
                                            <!-- Reply to review popup -->

                                            <?php
                        }
                        ?>

                                        </td>
                                        <td>
                                            <?php 
                        if($listingExemplaires[$i]['remarqueExemplaire']!='')
                        {
                        ?>
                                            <p class="inline-popups" style="margin:0 !important;padding:0 !important"><a href="#remarques<?php echo $i;?>" data-effect="mfp-zoom-in" class="btn_1 gray"><i class="fa fa-fw fa-eye"></i></a></p>
                                            <!-- Reply to review popup -->
                                            <div id="remarques<?php echo $i;?>" class="white-popup mfp-with-anim mfp-hide">
                                                <div class="small-dialog-header">
                                                    <h3>Remarques</h3>
                                                </div>
                                                <div class="message-reply margin-top-0">
                                                    <?php echo $listingExemplaires[$i]['remarqueExemplaire'];?>
                                                </div>
                                            </div>
                                            <?php
                        }
                        ?>

                                        </td>

                                        <td>
                                            <?php 
                        if($listingExemplaires[$i]['contenuJeu']!='')
                        {
                        ?>
                                            <p class="inline-popups" style="margin:0 !important;padding:0 !important"><a href="#contenu<?php echo $i;?>" data-effect="mfp-zoom-in" class="btn_1 gray"><i class="fa fa-fw fa-eye"></i></a></p>
                                            <!-- Reply to review popup -->
                                            <div id="contenu<?php echo $i;?>" class="white-popup mfp-with-anim mfp-hide">
                                                <div class="small-dialog-header">
                                                    <h3>Contenu</h3>
                                                </div>
                                                <div class="message-reply margin-top-0">
                                                    <?php echo $listingExemplaires[$i]['contenuJeu'];?>
                                                </div>
                                            </div>
                                            <?php
                        }
                        ?>

                                        </td>

                                        <td>
                                            <?php 
                        if($listingExemplaires[$i]['checkinJeu']!='')
                        {
                        ?>
                                            <p class="inline-popups" style="margin:0 !important;padding:0 !important"><a href="#checkin<?php echo $i;?>" data-effect="mfp-zoom-in" class="btn_1 gray"><i class="fa fa-fw fa-eye"></i></a></p>
                                            <!-- Reply to review popup -->
                                            <div id="checkin<?php echo $i;?>" class="white-popup mfp-with-anim mfp-hide">
                                                <div class="small-dialog-header">
                                                    <h3>Check-in</h3>
                                                </div>
                                                <div class="message-reply margin-top-0">
                                                    <?php echo $listingExemplaires[$i]['checkinJeu'];?>
                                                </div>
                                            </div>
                                            <?php
                        }
                        ?>

                                        </td>
                                        <td><?php echo $listingExemplaires[$i]['dateAjoutExemplaire'] ;?></td>
                                        <td><a href="exemplaires.php?s=1&idJeu=<?php echo $listingExemplaires[$i]['idJeu'];?>" onclick="return suppression();"><img src="img/supprimer.png"></a></td>
                                    </tr>

                                    <?php
                  }
                  ?>

                                </tbody>
                            </table>
                            <br><br>
                            <input type="checkbox" name="select-all" id="select-all" /> tout sélectionner <br>
                            <button class="btn_1 medium" type="submit">IMPRIMER LES ETIQUETTES</button>
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
