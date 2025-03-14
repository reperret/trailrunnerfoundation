<?php 
try {
   

include '../api/bdd.php';
include '../api/fonctions.php';
include 'verifAdmin.php';

//********CREATION D'UNE COURSE VIDE*******************
if(isset($_GET['c']) &&  $_GET['c']==1)
{
    $idCourse=createCourse($dbh);
}

//********RECUPERATION ID COURSE POST OU GET*******************
if(isset($_POST['idC']) && $_POST['idC']!='' ) $idCourse=$_POST['idC'];
if(isset($_GET['idC'])  && $_GET['idC']!=''  ) $idCourse=$_GET['idC'];

//********UPDATE INFOS******************************************************
$returnUpdateCourse=-1;

if(isset($_POST['updateCourse']) && $_POST['updateCourse']==1)
{
    $returnUpdateCourse=updateCourse($idCourse,$_POST,$dbh);
       // $returnUpdateCourse=updateCourse($idCourse,$_POST['latitudeCourse'],$_POST['longitudeCourse'],$_POST['dateDebutCourse'],$_POST['dateFinCourse'],$_POST['libelleCourse'],$_POST['descriptionCourse'],$_POST['sitewebCourse'],$_POST['villeCourse'],$_POST['codepostalCourse'],$_POST['paysCourse'],$_POST['distanceMinCourse'],$_POST['distanceMaxCourse'],$_POST['typeCourse'],$_POST['activeCourse']$dbh);
}

//********REDIRECTION ERREUR SI PARAMETRE ERRONE*****************************
if($idCourse==NULL || $idCourse==NULL)
{
    header('Location: erreur.php');
    exit(); 
}

//********RECUPERATION INFOS COURSE*****************
$infosCourse=getCourses($idCourse,NULL,NULL,NULL,NULL,NULL,$dbh);
$infosCourse=$infosCourse[0];
    
    
//********RECUPERATION UTILISATEURS******************
$listingUtilisateurs=getUtilisateurs(NULL,NULL,$dbh);

    

?>
<!DOCTYPE html>
<html lang="fr">


<!-- Mirrored from www.ansonika.com/findoctor/admin_section/user-profile.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 29 Jan 2019 15:12:29 GMT -->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Retrouverez l'ensemble des courses Trail Runner Foundation adhérentes et labélisées">
    <meta name="author" content="Trail Runner Foundation">
    <title>Annuaires Courses Trail Runner Foundation</title>

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


    <script>
        function suppression() {
            return confirm("Voulez vous supprimer définitivement l'exemplaire ?");
        }

    </script>

    <style>
        .vert {
            background-color: forestgreen !important;
        }

        .gris {
            background-color: lightgrey !important;
            ;
        }

    </style>

</head>

<body class="fixed-nav sticky-footer" id="page-top">

    <?php include 'nav.php';?>


    <div class="content-wrapper">
        <div class="container-fluid">
            <form action="detailCourse.php" method="post">
                <!-- Breadcrumbs-->
                <!--  <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Add listing</li>
      </ol>-->

                <?php if($returnUpdateCourse==1){ ?><div class="alert alert-success" role="alert">Mise à jour réussie</div><?php } ?>
                <?php if($returnUpdateCourse==0){ ?><div class="alert alert-danger" role="alert">La mise à jour a échoué. Veuillez recommencer</div><?php } ?>



                <div class="box_general padding_bottom">
                    <div class="header_box version_2">
                        <h2><i class="fa fa-id-card-o"></i>Caractéristiques </h2>
                        <p style="display: inline;margin:0 !important;padding:0 !important"></p>
                    </div>
                    <div class="row">

                        <div class="col-md-12 add_top_30">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Libellé</label>
                                        <input type="text" class="form-control" name="libelleCourse" value="<?php echo $infosCourse['libelleCourse'];?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Type</label>
                                        <select class="form-control" name="typeCourse" id="typeCourse">
                                            <option value="0" <?php if($infosCourse['typeCourseCode']==0) echo "selected";?>>Adhérente</option>
                                            <option value="1" <?php if($infosCourse['typeCourseCode']==0) echo "selected";?>>Labelisée</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>latitude</label>
                                        <input type="text" class="form-control" name="latitudeCourse" value="<?php echo $infosCourse['latitudeCourse'];?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Longitude</label>
                                        <input type="text" class="form-control" name="longitudeCourse" value="<?php echo $infosCourse['longitudeCourse'];?>">
                                    </div>
                                </div>
                            </div>
                            <!-- /row-->
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Date Début </label>
                                        <input type="text" class="form-control" name="dateDebutCourse" value="<?php echo $infosCourse['dateDebutCourse'];?>">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Date Fin </label>
                                        <input type="text" class="form-control" name="dateFinCourse" value="<?php echo $infosCourse['dateFinCourse'];?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Site web</label>
                                        <input type="text" class="form-control" name="sitewebCourse" value="<?php echo $infosCourse['sitewebCourse'];?>">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Course activée </label>
                                        <select class="form-control" name="activeCourse" id="activeCourse">
                                            <option value="0" <?php if($infosCourse['activeCourse']==0) echo "selected";?>>NON</option>
                                            <option value="1" <?php if($infosCourse['activeCourse']==1) echo "selected";?>>OUI</option>
                                        </select>
                                    </div>
                                </div>


                            </div>
                            <!-- /row-->

                            <div class="row">

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Ville</label>
                                        <input type="text" class="form-control" name="villeCourse" value="<?php echo $infosCourse['villeCourse'];?>">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Code postal</label>
                                        <input type="text" class="form-control" name="codepostalCourse" value="<?php echo $infosCourse['codepostalCourse'];?>">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Pays</label>
                                        <input type="text" class="form-control" name="paysCourse" value="<?php echo $infosCourse['paysCourse'];?>">
                                    </div>
                                </div>


                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Distance Min</label>
                                        <input type="text" class="form-control" name="distanceMinCourse" value="<?php echo $infosCourse['distanceMinCourse'];?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Distance Max</label>
                                        <input type="text" class="form-control" name="distanceMaxCourse" value="<?php echo $infosCourse['distanceMaxCourse'];?>">
                                    </div>
                                </div>

                            </div>


                        </div>
                    </div>
                </div>
                <!-- /box_general-->

                <div class="row">
                    <div class="col-md-12">
                        <div class="box_general padding_bottom">
                            <div class="header_box version_2">
                                <h2><i class="fa fa-info-circle"></i>Description</h2>
                            </div>


                            <div class="form-group">
                                <textarea class="form-control" name="descriptionCourse" rows="25"><?php echo $infosCourse['descriptionCourse'];?></textarea>
                            </div>

                        </div>




                    </div>



                </div>


                <div class="row">
                    <div class="col-md-12">
                        <div class="box_general padding_bottom">
                            <div class="header_box version_2">
                                <h2><i class="fa fa-info-circle"></i>Photos</h2>
                            </div>


                            <div class="col-md-3">
                                <div class="form-group">
                                    Photo 1<br>Photo 2
                                </div>
                            </div>

                        </div>




                    </div>



                </div>



                <!--
                <div class="row">
                    <div class="col-md-12">
                        <div class="box_general padding_bottom">
                            <div class="header_box version_2">
                                <h2><i class="fa fa-info-circle"></i>Utilisateurs</h2>
                            </div>


                            <div class="table-responsive">
                                <table class="table table-bordered" style="font-size:0.8em" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>

                                            <th>Nom</th>
                                            <th>Prénom</th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <th>Droit</th>

                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>

                                            <th>Nom</th>
                                            <th>Prénom</th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <th>Droit</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>


                                        <?php
                  foreach($listingUtilisateurs as $utilisateur)
                  {

                  ?>

                                        <tr>

                                            <td><?php echo $utilisateur['nomUtilisateur'];?></td>
                                            <td><?php echo $utilisateur['prenomUtilisateur'];?></td>
                                            <td><?php echo $utilisateur['emailUtilisateur'];?></td>
                                            <td><?php echo $utilisateur['mobileUtilisateur'];?></td>
                                            <td>
                                                <?php 
              
                                                if(in_array($idCourse,$utilisateur['droits']))
                                                {
                                                    ?><a href="#0" class="btn_1 vert"><i class="fa fa-fw fa-check-circle-o"></i> OK</a><?php
                                                }
                                                else
                                                {
                                                    ?><a href="#0" class="btn_1 gris"><i class="fa fa-fw fa-check-circle-o"></i> KO</a><?php
                                                }
                                                    
                                                    ;
                                                ?></td>

                                        </tr>

                                        <?php
                  }
                  ?>

                                    </tbody>
                                </table>
                                <br><br>

            </form>
        </div>



    </div>




    </div>



    </div>

-->

                <!-- /row-->
                <input type="hidden" name="updateCourse" value="1">
                <input type="hidden" name="idC" value="<?php echo $idCourse;?>">

                <center>
                    <p><button type="submit" class="btn_1 medium">METTRE A JOUR</button></p>
                </center>

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

    <script src="https://static.codepen.io/assets/common/stopExecutionOnTimeout-de7e2ef6bfefd24b79a3f68b414b87b8db5b08439cac3f1012092b2290c719cd.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>

</body>

<!-- Mirrored from www.ansonika.com/findoctor/admin_section/user-profile.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 29 Jan 2019 15:12:29 GMT -->

</html>
<?php
} catch (Exception $e) {
    echo 'Exception reçue : ',  $e->getMessage(), "\n";
}

?>
