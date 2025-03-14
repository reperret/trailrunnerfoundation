<?php 
try
{
    


include '../api/bdd.php';
include '../api/fonctions.php';
include 'verifAdmin.php';

//******SUPPRESSION D'UNE COURSE*************
$returnDeleteCourse=false;
if(isset($_GET['s']) && $_GET['s']==1 && $_GET['idCourse']!='')
{
    $returnDeleteCourse=deleteCourse(intval($_GET['idCourse']),$dbh);
}

$listingCourses=getCourses(NULL,NULL,NULL,NULL,NULL,NULL,$dbh);

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
                return confirm("Voulez vous supprimer définitivement cette course ?");
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
                    <i class="fa fa-trophy"></i> Courses <p style="display: inline;margin:0 !important;padding:0 !important">
                        <?php 
                        if(!$profilUtilisateur==0)
                        {
                        ?><a href="detailCourse.php?c=1" data-effect="mfp-zoom-in" class="btn_1 gray">Créer une course</a></p><?php
                        }
                    ?>



                </div>



                <?php if($returnDeleteCourse)        echo "<center><h3>Cette course a bien été supprimée</h3></center>";?>


                <br>


                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-bordered" style="font-size:0.9em" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>

                                    <th>Libellé</th>
                                    <th>Type</th>
                                    <th>GPS</th>
                                    <th>Debut</th>
                                    <th>Fin</th>
                                    <th>Site</th>
                                    <th>Ville</th>
                                    <th>CP</th>
                                    <th>Pays</th>
                                    <th>Dist. min/max</th>
                                    <th>activeCourse</th>
                                    <th>Description</th>
                                    <th>Supp.</th>

                                </tr>
                            </thead>
                            <tfoot>
                                <tr>

                                    <th>Libellé</th>
                                    <th>Type</th>
                                    <th>GPS</th>
                                    <th>Debut</th>
                                    <th>Fin</th>
                                    <th>Site</th>
                                    <th>Ville</th>
                                    <th>CP</th>
                                    <th>Pays</th>
                                    <th>Dist. min/max</th>
                                    <th>activeCourse</th>
                                    <th>Description</th>
                                    <th>Supp.</th>
                                </tr>
                            </tfoot>
                            <tbody>


                                <?php
                               
                  $listeDroits=getDroitsUtilisateur($idUtilisateur, $dbh);
                  foreach($listingCourses as $course)
                  {
                      
                     
                      if(in_array($course['idCourse'],$listeDroits) || $profilUtilisateur==1)
                      {
    
                  ?>
                                <tr>

                                    <td><a class="libelleJeu" href="detailCourse.php?idC=<?php echo $course['idCourse'] ;?>"><?php echo $course['libelleCourse'];?></a></td>
                                    <td><i class="<?php echo getClassCssTypeCourse($course['typeCourseCode']);?>" style="font-size:0.9em"><?php echo $course['typeCourse'];?></i></td>
                                    <td>
                                        <form action="https://maps.google.com/maps" method="get" target="_blank"><input name="saddr" value="' + markers[i].get_directions_start_address + '" type="hidden"><input type="hidden" name="daddr" value="<?php echo $course['latitudeCourse'];?>,<?php echo $course['longitudeCourse'];?>"><button type="submit" value="Localiser">GO</button></form>

                                    </td>
                                    <td><?php echo date_format(date_create($course['dateDebutCourse']), 'Y-m-d');?></td>
                                    <td><?php echo date_format(date_create($course['dateFinCourse']), 'Y-m-d');?></td>
                                    <td><a href="<?php echo $course['sitewebCourse'];?>" target="_blank">Voir</a></td>
                                    <td><?php echo $course['villeCourse'];?></td>
                                    <td><?php echo $course['codepostalCourse'];?></td>
                                    <td><?php echo $course['paysCourse'];?></td>
                                    <td><?php echo $course['distanceMinCourse']."/".$course['distanceMaxCourse'];?></td>
                                    <td><?php if($course['activeCourse']==0) echo "NON"; if($course['activeCourse']==1) echo "OUI"; ?></td>

                                    <td>
                                        <?php 
                        if($course['descriptionCourse']!='')
                        {
                        ?>
                                        <p class="inline-popups" style="margin:0 !important;padding:0 !important"><a href="#description<?php echo $i;?>" class="btn_1 gray" data-effect="mfp-zoom-in"><i class="fa fa-fw fa-eye"></i></a></p>
                                        <!-- Reply to review popup -->
                                        <div id="description<?php echo $i;?>" class="white-popup mfp-with-anim mfp-hide">
                                            <div class="small-dialog-header">
                                                <h3>Description</h3>
                                            </div>
                                            <div class="message-reply margin-top-0">
                                                <?php echo $course['descriptionCourse'];?>
                                            </div>
                                        </div>
                                        <?php
                        }
                        ?>

                                    </td>

                                    <td><a href="courses.php?s=1&idCourse=<?php echo $course['idCourse'];?>" onclick="return suppression();"><img src="img/supprimer.png"></a></td>
                                </tr>

                                <?php
                      $i++;
                     }
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
<?php
}
catch (Exception $e) {
    echo 'Exception reçue : ',  $e->getMessage(), "\n";
}
?>