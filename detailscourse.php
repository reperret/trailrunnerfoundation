<?php
include 'api/bdd.php';
include 'api/fonctions.php';

$detailsCourse=getCourses($_GET['idC'],NULL,NULL,NULL,NULL,NULL,$dbh); //getCourses($idCourse,$keyWord,$dateDebut,$dateFin,$typeCourse,$dbh)
$detailsCourse=$detailsCourse[0];
$photos=getPhotosCourseFile($detailsCourse['photosCourse']);
$bandeau=$photos[1];
if($photos[1]=="" || $photos[1]==NULL) $bandeau="dcdbee831b568274ddde8a44ec86b21c.jpeg";
$vignette=$photos[0];
if($photos[0]=="" || $photos[0]==NULL) $vignette="defaut_vignette.jpg";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Retrouvez l'ensemble des courses Trail Runner Foundation adhérentes et labélisées">
    <meta name="author" content="Trail Runner Foundation">
    <title>Annuaires Courses Trail Runner Foundation</title>

    <!-- Favicons-->
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <!-- GOOGLE WEB FONT -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- BASE CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/vendors.css" rel="stylesheet">

    <!-- YOUR CUSTOM CSS -->
    <link href="css/custom.css" rel="stylesheet">
    <style>
        .hero_in.hotels_detail:before {
            background: url(admin/images/<?php echo $bandeau;?>) center center no-repeat;
             !important
        }

        .imageHelper img {
            margin: auto;
            max-width: 100%;
            max-height: 100%;
            text-align: center;
            margin-bottom: 40px;
        }

    </style>
</head>

<body class="datepicker_mobile_full">
    <!-- Remove this class to disable datepicker full on mobile -->

    <div id="page" class="theia-exception">

        <?php include 'header.php';?>
        <main>
            <section class="hero_in hotels_detail">
                <div class="wrapper">
                    <div class="container">
                        <h1 class="fadeInUp"><span></span><?php echo $detailsCourse['libelleCourse'];?></h1>
                    </div>
                    <?php
                    $first=true;
                    if(sizeof($photos[2])>0)
                    {
                        ?>
                    <span class="magnific-gallery">

                        <?php
                        foreach($photos[2] as $diapo)
                        {
                            if($first)
                            {
                                ?><a href="admin/images/<?php echo $diapo;?>" class="btn_photos" title="Photo title" data-effect="mfp-zoom-in">Album photos</a><?php
                                $first=false;
                            }
                            else
                            {
                                ?><a href="admin/images/<?php echo $diapo;?>" title="Photo title" data-effect="mfp-zoom-in"></a><?php
                            }
                        }
                        ?>
                    </span><?php
                    }
                    ?>

                </div>
            </section>
            <!--/hero_in-->



            <div class="bg_color_1">
                <nav class="secondary_nav sticky_horizontal">
                    <div class="container">
                        <ul class="clearfix">
                            <li><a href="#reviews">Résumé</a></li>
                            <li><a href="#description" class="active">Description</a></li>
                            <li><a href="#test">Localisation</a></li>
                        </ul>
                    </div>
                </nav>

                <div class="container margin_60_35">

                    <div class="row">
                        <div class="col-lg-8">

                            <div class="imageHelper">
                                <img src="admin/images/<?php echo $vignette;?>" alt="image" />
                            </div>

                            <section id="reviews">
                                <h2>Résumé</h2>
                                <p>
                                    <strong>Date : </strong>
                                    <?php 
                                                if($detailsCourse['dateFinCourse']!='')
                                                {                                                    
                                                    echo "Du ".date_format(date_create($detailsCourse['dateDebutCourse']), 'd/m/Y')." au ".date_format(date_create($detailsCourse['dateDebutCourse']), 'd/m/Y');
                                                }
                                                else
                                                {
                                                    echo date_format(date_create($detailsCourse['dateDebutCourse']), 'd/m/Y');
                                                }
                                                ?>
                                    <br>
                                    <strong>Lieu : </strong><?php echo $detailsCourse['villeCourse'] ;?>
                                    <?php if($detailsCourse['codepostalCourse']!='') echo "(".$detailsCourse['codepostalCourse'].")" ;?><br>
                                    <strong>Site web : </strong><a href="<?php echo $detailsCourse['sitewebCourse'] ;?>"><?php echo $detailsCourse['sitewebCourse'] ;?></a>
                                </p>
                            </section>
                            <!-- /section -->


                            <section id="description">
                                <h2>Description</h2>
                                <p>
                                    <?php echo $detailsCourse['descriptionCourse'] ;?>
                                </p>
                            </section>


                            <section id="test">
                                <h2>Localisation</h2>
                                <p>
                                    <form action="https://maps.google.com/maps" method="get" target="_blank"><input name="saddr" value="" type="hidden">
                                        <input type="hidden" name="daddr" value="<?php echo $detailsCourse['latitudeCourse'].",".$detailsCourse['longitudeCourse'] ;?>">
                                        <button type="submit" value="Itinéraire" class="btn_1">Lancer le gps</button>
                                    </form>
                                </p>
                            </section>
                            <!-- /section -->





                        </div>
                        <!-- /col -->


                    </div>
                    <!-- /row -->
                </div>
                <!-- /container -->
            </div>
            <!-- /bg_color_1 -->

        </main>
        <!--/main-->

        <footer>
            <div class="container margin_60_35">

                <div class="row">

                    <div class="col-lg-12">
                        <ul id="additional_links">
                            <li><a href="https://www.trailrunnerfoundation.co">Retour au site Trail Runner Foundation</a></li>
                        </ul>
                        
                       <div class="follow_us">
						<ul>
							<li>Nous suivre</li>
							<li><a href="https://www.facebook.com/trailrunnerfoundation/"  target="_blank"><i class="ti-facebook"></i></a></li>
							<li><a href="https://twitter.com/TRF_Foundation"  target="_blank"><i class="ti-twitter-alt"></i></a></li>
							<li><a href="https://www.linkedin.com/groups/7413173" target="_blank"><i class="ti-linkedin"  ></i></a></li>
							<li><a href="https://www.youtube.com/channel/UCmWbjC_9mJTTefu3GQtKuFg" target="_blank"><i class="ti-youtube"  ></i></a></li>
							<li><a href="https://www.instagram.com/trailrunnerfoundation" target="_blank"><i class="ti-instagram"></i></a></li>
						</ul>
					</div>
                        
                        
                    </div>
                </div>
            </div>
        </footer>
        <!--/footer-->
    </div>
    <!-- page -->

    <!-- Sign In Popup -->
    <div id="sign-in-dialog" class="zoom-anim-dialog mfp-hide">
        <div class="small-dialog-header">
            <h3>Sign In</h3>
        </div>
        <form>
            <div class="sign-in-wrapper">
                <a href="#0" class="social_bt facebook">Login with Facebook</a>
                <a href="#0" class="social_bt google">Login with Google</a>
                <div class="divider"><span>Or</span></div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email" id="email">
                    <i class="icon_mail_alt"></i>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" name="password" id="password" value="">
                    <i class="icon_lock_alt"></i>
                </div>
                <div class="clearfix add_bottom_15">
                    <div class="checkboxes float-start">
                        <label class="container_check">Remember me
                            <input type="checkbox">
                            <span class="checkmark"></span>
                        </label>
                    </div>
                    <div class="float-end mt-1"><a id="forgot" href="javascript:void(0);">Forgot Password?</a></div>
                </div>
                <div class="text-center"><input type="submit" value="Log In" class="btn_1 full-width"></div>
                <div class="text-center">
                    Don’t have an account? <a href="register.html">Sign up</a>
                </div>
                <div id="forgot_pw">
                    <div class="form-group">
                        <label>Please confirm login email below</label>
                        <input type="email" class="form-control" name="email_forgot" id="email_forgot">
                        <i class="icon_mail_alt"></i>
                    </div>
                    <p>You will receive an email containing a link allowing you to reset your password to a new preferred one.</p>
                    <div class="text-center"><input type="submit" value="Reset Password" class="btn_1"></div>
                </div>
            </div>
        </form>
        <!--form -->
    </div>
    <!-- /Sign In Popup -->

    <div id="toTop"></div><!-- Back to top button -->

    <!-- COMMON SCRIPTS -->
    <script src="js/common_scripts.js"></script>
    <script src="js/main.js"></script>
    <script src="assets/validate.js"></script>

    <!-- Map -->
    <script src="http://maps.googleapis.com/maps/api/js"></script>
    <script src="js/map_single_hotel.js"></script>
    <script src="js/infobox.js"></script>

    <!-- DATEPICKER  -->
    <script>
        $(function() {
            $('input[name="dates"]').daterangepicker({
                autoUpdateInput: false,
                parentEl: '.scroll-fix',
                minDate: new Date(),
                opens: 'left',
                locale: {
                    cancelLabel: 'Effacer'
                }
            });
            $('input[name="dates"]').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('MM-DD-YY') + ' > ' + picker.endDate.format('MM-DD-YY'));
            });
            $('input[name="dates"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
        });

    </script>

    <!-- INPUT QUANTITY  -->
    <script src="js/input_qty.js"></script>

</body>

</html>
