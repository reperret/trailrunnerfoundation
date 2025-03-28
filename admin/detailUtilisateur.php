<?php 
try {
   

include '../api/bdd.php';
include '../api/fonctions.php';
include 'verifAdmin.php';

//********CREATION D'UNE UTILISATEUR VIDE*******************
if(isset($_GET['c']) &&  $_GET['c']==1)
{
    $idUtilisateur=createUtilisateur($dbh);
}
    
//********SUPPRESSION DROIT COURSE*******************
if(isset($_GET['dd']) &&  $_GET['dd']==1 && isset($_GET['idD']) &&  $_GET['dd']!='')
{
    $returnDeleteDroit=deleteDroit($_GET['idD'],$dbh);
}
    
//********RECUPERATION ID UTILISATEUR POST OU GET*******************
if(isset($_POST['idU']) && $_POST['idU']!='' ) $idUtilisateur=$_POST['idU'];
if(isset($_GET['idU'])  && $_GET['idU']!=''  ) $idUtilisateur=$_GET['idU'];


//********UPDATE INFOS******************************************************
$returnUpdateUtilisateur=false;
$updateRefusee=false;

if(isset($_POST['updateUtilisateur']) && $_POST['updateUtilisateur']==1)
{
    if($_POST['passUtilisateur']=='mdpImprobableuhhhhhhh' || ($_POST['passUtilisateur']!='' && ($_POST['passUtilisateur']!='mdpImprobableuhhhhhhh' && $_POST['passUtilisateur']==$_POST['passUtilisateurBIS'])))
       {
           $returnUpdateUtilisateur=updateUtilisateur($idUtilisateur,$_POST,$dbh);
       }
       else
       {
           $updateRefusee=true;
       }
       
    
}
    
    
//********REDIRECTION ERREUR SI PARAMETRE ERRONE*****************************
if($idUtilisateur==NULL || $idUtilisateur==NULL)
{
    header('Location: erreur.php');
    exit(); 
}

//********RECUPERATION INFOS UTILISATEUR*****************
$infosUtilisateur=getUtilisateurs($idUtilisateur,NULL,NULL,$dbh);
$infosUtilisateur=$infosUtilisateur[0];


?>
<!DOCTYPE html>
<html lang="fr">


<!-- Mirrored from www.ansonika.com/findoctor/admin_section/user-profile.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 29 Jan 2019 15:12:29 GMT -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>TRF - Détail Utilisateur</title>

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

    <script src='https://cdn.tiny.cloud/1/g4bo14zvgqzihl9jvzssk5qvy600e3si654wr1w7in8fi9km/tinymce/5/tinymce.min.js' referrerpolicy="origin">
    </script>
    <script>
        tinymce.init({
            selector: '#mytextarea'
        });

    </script>

    <script>
        function suppression() {
            return confirm("Voulez vous supprimer le droit ?");
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
            <form action="detailUtilisateur.php" method="post">
                <!-- Breadcrumbs-->
                <!--  <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Add listing</li>
      </ol>-->

                <?php if($returnUpdateUtilisateur){ ?><div class="alert alert-success" role="alert">Mise à jour réussie</div><?php } ?>
                <?php if($returnDeleteDroit){ ?><div class="alert alert-success" role="alert">Le droit a bien été retiré</div><?php } ?>
                <?php if($updateRefusee){ ?><div class="alert alert-danger" role="alert">Mise à jour impossible, les 2 deux mots de passes sont différents</div><?php } ?>



                <div class="box_general padding_bottom">
                    <div class="header_box version_2">
                        <h2><i class="fa fa-id-card-o"></i>Informations </h2>
                        <p style="display: inline;margin:0 !important;padding:0 !important"></p>
                    </div>
                    <div class="row">

                        <div class="col-md-12 add_top_30">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Nom</label>
                                        <input type="text" class="form-control" name="nomUtilisateur" value="<?php echo $infosUtilisateur['nomUtilisateur'];?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Prénom</label>
                                        <input type="text" class="form-control" name="prenomUtilisateur" value="<?php echo $infosUtilisateur['prenomUtilisateur'];?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Profil</label>
                                        <select class="form-control" name="profilUtilisateur" id="profilUtilisateur">
                                            <option value="1" <?php if($infosUtilisateur['profilUtilisateur']==1) echo "selected";?>>Admin</option>
                                            <option value="0" <?php if($infosUtilisateur['profilUtilisateur']==0) echo "selected";?>>Organisateur</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <!-- /row-->
                            <div class="row">

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="text" class="form-control" name="emailUtilisateur" value="<?php echo $infosUtilisateur['emailUtilisateur'];?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Mobile</label>
                                        <input type="text" class="form-control" name="mobileUtilisateur" value="<?php echo $infosUtilisateur['mobileUtilisateur'];?>">
                                    </div>
                                </div>

                            </div>
                            <!-- /row-->


                        </div>
                    </div>
                </div>
                <!-- /box_general-->




                <div class="box_general padding_bottom">
                    <div class="header_box version_2">
                        <h2><i class="fa fa-id-card-o"></i>Courses associées </h2>
                        <p style="display: inline;margin:0 !important;padding:0 !important"></p>
                    </div>
                    <div class="row">

                        <div class="col-md-12 add_top_30">
                            <div class="row">

                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Libellé</th>
                                            <th>Ville</th>
                                            <th>CP</th>
                                            <th>Suppr.</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        <?php
                                    foreach($infosUtilisateur['droits'] as $idCourse)
                                    {
                                        $course=getCoursesFromIdCourse($idCourse,$dbh);
                                        ?>
                                        <tr>
                                            <td><?php echo $course['libelleCourse'] ;?></td>
                                            <td><?php echo $course['villeCourse'] ;?></td>
                                            <td><?php echo $course['codepostalCourse'] ;?></td>
                                            <td><a href="detailUtilisateur.php?idU=<?php echo $idUtilisateur;?>&dd=1&idD=<?php echo $course['idDroit'];?>">Supprimer le droit</a></td>
                                        </tr>
                                        <?php   
                                    }
                                    ?>
                                    </tbody>
                                </table>





                            </div>
                            <!-- /row-->


                        </div>
                    </div>
                </div>










                <div class="box_general padding_bottom">
                    <div class="header_box version_2">
                        <h2><i class="fa fa-id-card-o"></i>Mot de passe </h2>
                        <p style="display: inline;margin:0 !important;padding:0 !important"></p>
                    </div>
                    <div class="row">

                        <?php
        //********CREATION D'UNE UTILISATEUR VIDE*******************
        if(isset($_GET['c']) &&  $_GET['c']==1)
        {
            ?>Un mot de passe sera généré automatiquement et les informations seront envoyées par mail une fois que vous aurez cliqué sur "Mettre à jour"<?php
        }

        ?>

                        <div class="col-md-12 add_top_30">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Mot de passe</label>
                                        <?php
    
    
        $passAleatoire=uniqid();
        //********CREATION D'UNE UTILISATEUR VIDE*******************
        if(isset($_GET['c']) &&  $_GET['c']==1)
        {
            ?><input type="password" class="form-control" name="passUtilisateur" value="<?php echo $passAleatoire;?>"><?php
        }
        else
        {
            ?><input type="password" class="form-control" name="passUtilisateur" value="mdpImprobableuhhhhhhh"><?php
        }

        ?>

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Mot de passe BIS</label>

                                        <?php
        //********CREATION D'UNE UTILISATEUR VIDE*******************
        if(isset($_GET['c']) &&  $_GET['c']==1)
        {
            ?><input type="password" class="form-control" name="passUtilisateurBIS" value="<?php echo $passAleatoire;?>"><?php
        }
        else
        {
            ?><input type="password" class="form-control" name="passUtilisateurBIS" value="mdpImprobableuhhhhhhh"><?php
        }

        ?>



                                    </div>
                                </div>


                            </div>
                            <!-- /row-->



                        </div>
                    </div>
                </div>







                <!-- /row-->
                <input type="hidden" name="updateUtilisateur" value="1">
                <input type="hidden" name="idU" value="<?php echo $idUtilisateur;?>">

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
