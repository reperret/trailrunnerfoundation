<?php
include 'api/bdd.php';
include 'api/fonctions.php';
//************RECUPERATION / DEFINITION PARAMETRES RECHERCHES***********************/
$dateDebut = NULL;
$dateFin = NULL;
$typeCourse = NULL;
$keyWord = NULL;
$departement = NULL;

/*****GESTION DATES******/
if (isset($_POST['dates']) && $_POST['dates'] != '') {
    $dateDebutFin = explode(" > ", $_POST['dates']);
    if ($dateDebutFin[0] != '') {
        $transform = explode("/", $dateDebutFin[0]);
        $dateDebut = $transform[2] . "-" . $transform[1] . "-" . $transform[0];
    }
    if ($dateDebutFin[1] != '') {
        $transform = explode("/", $dateDebutFin[1]);
        $dateFin = $transform[2] . "-" . $transform[1] . "-" . $transform[0];
    }
}

/*****GESTION TYPE COURSE******/
if (isset($_POST['typeCourse']) && $_POST['typeCourse'] != '' && $_POST['typeCourse'] != '-1') {
    $typeCourse = $_POST['typeCourse'];
}

/*****GESTION DEPARTEMENT******/
if (isset($_POST['departement']) && $_POST['departement'] != '' && $_POST['departement'] != '-1') {
    $departement = $_POST['departement'];
}

/*****GESTION KEY WORD*********/
if (isset($_POST['keyWord']) && $_POST['keyWord'] != '') {
    $keyWord = $_POST['keyWord'];
}


//**********************************************************************************/

$courses = getCourses(NULL, $keyWord, $dateDebut, $dateFin, $typeCourse, $departement, $dbh); //getCourses($idCourse,$keyWord,$dateDebut,$dateFin,$typeCourse,$dbh)
$gps = array();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="Retrouvez l'ensemble des courses Trail Runner Foundation adhérentes et labélisées">
    <meta name="author" content="Trail Runner Foundation">
    <title>Annuaire : Courses Trail Runner Foundation</title>

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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- BASE CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/vendors.css" rel="stylesheet">

    <!-- YOUR CUSTOM CSS -->
    <link href="css/custom.css" rel="stylesheet">

    <style>
    html,
    body {
        height: 100%;
    }
    </style>

</head>

<body>

    <div id="page">

        <?php include 'header.php'; ?>
        <main>
            <div class="container-fluid full-height">
                <div class="row row-height">
                    <div class="col-lg-5 content-left order-md-last order-sm-last order-last">
                        <div id="results_map_view">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-10">
                                        <h4><strong><?php echo sizeof($courses); ?></strong> résultats</h4>


                                    </div>
                                    <div class="col-2">
                                        <a href="#0" class="search_map btn_search_map_view"></a>
                                        <!-- /open search panel -->
                                    </div>
                                </div>
                                <!-- /row -->
                                <form action="index.php" method="post">
                                    <div class="search_map_wp" style="display: block;">
                                        <div class="custom-search-input-2 map_view">
                                            <div class="form-group">
                                                <input class="form-control" type="text" name="keyWord"
                                                    placeholder="Nom, ville, mots clefs... "
                                                    value="<?php if (isset($_POST['keyWord']) && $_POST['keyWord'] != '') echo $_POST['keyWord']; ?>">
                                                <i class="icon_search"></i>
                                            </div>

                                            <div class="form-group">
                                                <input class="form-control" type="text" name="dates" placeholder="Dates"
                                                    value="<?php if (isset($_POST['dates']) && $_POST['dates'] != '') echo $_POST['dates']; ?>"
                                                    autocomplete="off">
                                                <i class="icon_calendar"></i>
                                            </div>


                                            <select class="wide" name="departement">
                                                <option value="-1"
                                                    <?php if ($_POST['departement'] == "-1") echo "selected"; ?>>Tous
                                                    les départements</option>
                                                <?php
                                                $dep = getDepartements($dbh);

                                                foreach ($dep as $numDepartement => $libelleDepartement) {
                                                ?>
                                                <option value="<?php echo $numDepartement; ?>"
                                                    <?php if ($_POST['departement'] == $numDepartement) echo "selected"; ?>>
                                                    <?php echo $numDepartement . " - " . $libelleDepartement; ?>
                                                </option>
                                                <?php
                                                }
                                                ?>
                                            </select>

                                            <select class="wide" name="typeCourse">
                                                <option value="-1"
                                                    <?php if ($_POST['typeCourse'] == "-1") echo "selected"; ?>>Toutes
                                                    les courses</option>
                                                <option value="0"
                                                    <?php if ($_POST['typeCourse'] == "0") echo "selected"; ?>>Courses
                                                    adhérentes</option>
                                                <option value="1"
                                                    <?php if ($_POST['typeCourse'] == "1") echo "selected"; ?>>Courses
                                                    labelisées</option>
                                            </select>

                                            <input type="submit" value="Rechercher">
                                        </div>
                                    </div>
                                </form>
                                <!-- /search_map_wp -->
                            </div>
                            <!-- /container -->
                        </div>
                        <!-- /results -->


                        <!--
                        <div class="filters_listing version_3">
                            <div class="container-fluid">
                                <ul class="clearfix">
                                    <li>
                                        <div class="switch-field">
                                            <input type="radio" id="all" name="listing_filter" value="all" checked>
                                            <label for="all">Tout</label>
                                            <input type="radio" id="popular" name="listing_filter" value="popular">
                                            <label for="popular">Nouveautés</label>
                                            <input type="radio" id="latest" name="listing_filter" value="latest">
                                            <label for="latest">Les plus fidèles</label>
                                        </div>
                                    </li>
                                    <li><a class="btn_filt_map" data-bs-toggle="collapse" href="#filters" aria-expanded="false" aria-controls="filters" data-text-swap="Less filters" data-text-original="More filters">Plus de filtres</a></li>
                                </ul>
                            </div>
                            
                    </div>
                 


                    <div class="collapse map_view" id="filters">
                        <div class="container-fluid margin_30_5">
                            <h6>Particularités</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="filter_type">
                                        <ul>
                                            <li>
                                                <label class="container_check">Tout
                                                    <input type="checkbox">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="container_check">Zéro plastoc
                                                    <input type="checkbox">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="filter_type">
                                        <ul>
                                            <li>
                                                <label class="container_check">Je sais pas quoi
                                                    <input type="checkbox">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="container_check">Autre chose
                                                    <input type="checkbox">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="add_bottom_30">
                                        <h6>Distance</h6>
                                        <div class="distance"> Distance maximale de la course <span></span></div>
                                        <input type="range" min="0" max="300" step="10" value="300" data-orientation="horizontal">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    -->
                        <!-- /Filters -->



                        <?php
                        foreach ($courses as $course) {

                            //****RECUPERATION VIGNETTE PHOTO
                            $vignette = getPhotosCourseFile($course['photosCourse'])[0];
                            if ($vignette == "" || $vignette == NULL) $vignette = "defaut_vignette.jpg";
                            //********************************

                        ?>
                        <!-- DEBUT ELEMENT : COURSE -->
                        <div class="box_list map_view">
                            <div class="row g-0 add_top_20">
                                <div class="col-4">
                                    <figure>
                                        <small><?php echo $course['typeCourse']; ?></small>

                                        <a href="detailscourse.php?idC=<?php echo $course['idCourse']; ?>"><img
                                                src="admin/images/<?php echo $vignette; ?>" class="img-fluid" alt=""
                                                width="800" height="533"></a>
                                    </figure>
                                </div>
                                <div class="col-8">
                                    <div class="wrapper">
                                        <!-- <a href="#0" class="wish_bt"></a>-->
                                        <h3><a
                                                href="detailscourse.php?idC=<?php echo $course['idCourse']; ?>"><?php echo $course['libelleCourse']; ?></a>
                                        </h3>
                                        <span class="price">
                                            <strong>
                                                <?php
                                                    if ($course['dateFinCourse'] != $course['dateDebutCourse']) {
                                                        echo "Du " . date_format(date_create($course['dateDebutCourse']), 'd/m/Y') . " au " . date_format(date_create($course['dateFinCourse']), 'd/m/Y');
                                                    } else {
                                                        echo date_format(date_create($course['dateDebutCourse']), 'd/m/Y');
                                                    }
                                                    ?>
                                            </strong>
                                        </span>
                                        <p><?php echo $course['villeCourse']; ?>
                                            <?php if ($course['codepostalCourse'] != '') echo "(" . $course['codepostalCourse'] . ")"; ?>
                                        </p>
                                    </div>
                                    <ul>
                                        <li>
                                            <a href="#0" data-id="<?php echo $course['idCourse']; ?>"
                                                class="address">Voir sur la carte</a>
                                        </li>
                                        <li>
                                            <div class="score">
                                                <span><a href="<?php echo $course['sitewebCourse']; ?>"
                                                        target="_blank">Site web</a>
                                                    <em>

                                                    </em>
                                                </span>
                                                <!--<strong>69</strong>-->
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- FIN ELEMENT : COURSE -->
                        <?php
                        }
                        ?>






                        <!--<p class="text-center add_top_30"><a href="#0" class="btn_1 rounded"><strong>Load more</strong></a></p>-->
                    </div>
                    <!-- /content-left-->

                    <div class="col-lg-7 map-right">
                        <div id="map"></div>
                        <!-- map-->
                    </div>
                    <!-- /map-right-->

                </div>
                <!-- /row-->
            </div>
            <!-- /container-fluid -->

        </main>
        <!--/main-->

    </div>
    <!-- page -->



    <!-- COMMON SCRIPTS -->
    <script src="js/common_scripts.js"></script>
    <script src="js/main.js"></script>
    <script src="assets/validate.js"></script>

    <!-- Map LeafLet + Mapbox-->
    <script src="js/leaflet_map/leaflet.min.js"></script>
    <script src="js/leaflet_map/leaflet_markercluster.min.js"></script>
    <!--<script src="js/leaflet_map/leaflet_tours_markers.js"></script>-->
    <script>
    var markers = [
        <?php
            foreach ($courses as $course) {

                //****RECUPERATION VIGNETTE PHOTO
                $vignette = getPhotosCourseFile($course['photosCourse'])[0];
                if ($vignette == "" || $vignette == NULL) $vignette = "defaut_vignette.jpg";
                //********************************

                $gps[] = array($course['latitudeCourse'], $course['longitudeCourse']);
            ?> {
            "id": <?php echo $course['idCourse']; ?>,
            "type_point": "<?php echo $course['typeCourse']; ?>",
            "location_latitude": <?php echo $course['latitudeCourse']; ?>,
            "location_longitude": <?php echo $course['longitudeCourse']; ?>,
            "map_image_url": "admin/images/<?php echo $vignette; ?>",
            "typecourse": "<?php echo $course['typeCourse']; ?>",
            "nomcourse": "<?php echo $course['libelleCourse']; ?>",
            "datescourse": "<?php
                                    if ($course['dateFinCourse'] != '') {
                                        echo "Du " . date_format(date_create($course['dateDebutCourse']), 'd/m/Y') . " au " . date_format(date_create($course['dateDebutCourse']), 'd/m/Y');
                                    } else {
                                        echo date_format(date_create($course['dateDebutCourse']), 'd/m/Y');
                                    }
                                    ?>",
            "get_directions_start_address": "",
            "urldetailcourse": "detailscourse.php?idC=<?php echo $course['idCourse']; ?>"
        },
        <?php
            }
            ?>

    ];


    $(function() {
        'use strict';
        $('input[name="dates"]').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Effacer'
            }
        });
        $('input[name="dates"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' > ' + picker.endDate.format(
                'DD/MM/YYYY'));
        });
        $('input[name="dates"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
    });
    </script>
    <!-- <script src="js/leaflet_map/leaflet_no_mapbox_tours_half_screen_func.js"></script>-->
    <?php


    //$center=getCenterLatLng($gps);   si besoin d'utiliser une fonction intelligente pour centrer sur le barycentre de toutes les courses
    $center = array(46.83926901079315, 1.9512817592296343);
    ?>
    <script>
    var map = L.map('map', {
        center: [<?php echo $center[0]; ?>, <?php echo $center[1]; ?>],
        minZoom: 2,
        zoomControl: false,
        zoom: 6
    });

    function getParameterByName(name) {
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        const regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
            results = regex.exec(location.search);
        return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    }

    var POPUP_MARKER_ID = getParameterByName('markerid');

    L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Street_Map/MapServer/tile/{z}/{y}/{x}', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
        subdomains: ['a', 'b', 'c']
    }).addTo(map);


    var myIcon2 = L.icon({
        iconUrl: 'img/pins/picto_classique.png',
        iconRetinaUrl: 'img/pins/picto_classique.png',
        iconSize: [30, 42],
        iconAnchor: [9, 21],
        popupAnchor: [7, -15]
    });

    var myIcon = L.icon({
        iconUrl: 'img/pins/picto_label.png',
        iconRetinaUrl: 'img/pins/picto_label.png',
        iconSize: [30, 42],
        iconAnchor: [9, 21],
        popupAnchor: [7, -15]
    });

    var markerClusters = L.markerClusterGroup({
        polygonOptions: {
            opacity: 0,
            fillOpacity: 0
        }
    });
    var monCss = "infobox_rate2";



    for (var i = 0; i < markers.length; ++i) {

        if (markers[i].typecourse == "Labelisée") {
            monCss = "infobox_rate";
        };

        var popup =
            '<img src="' + markers[i].map_image_url + '" width="240" alt=""/>' +
            '<span>' +
            '<span class="' + monCss + '">' + markers[i].typecourse + '</span>' +

            '<h3><a href="' + markers[i].urldetailcourse + '">' + markers[i].nomcourse + '</a>' + '</h3>' +
            '<em>' + markers[i].datescourse + '</em><br>' +

            '<a href="' + markers[i].urldetailcourse + '" class="btn_infobox_detail"></a>' +
            '<form action="https://maps.google.com/maps" method="get" target="_blank"><input name="saddr" value="' +
            markers[i].get_directions_start_address + '" type="hidden"><input type="hidden" name="daddr" value="' +
            markers[i].location_latitude + ',' + markers[i].location_longitude +
            '"><button type="submit" value="Itinéraire" class="btn_infobox_get_directions">Itinéraire</button></form>' +
            '</span>';

        if (markers[i].typecourse == "Labelisée") {
            var m = L.marker([markers[i].location_latitude, markers[i].location_longitude], {
                id: markers[i].id,
                icon: myIcon
            }).bindPopup(popup);
        } else {
            var m = L.marker([markers[i].location_latitude, markers[i].location_longitude], {
                id: markers[i].id,
                icon: myIcon2
            }).bindPopup(popup);
        }


        markerClusters.addLayer(m);
    }

    map.addLayer(markerClusters);

    //Link on the same page
    var classname = document.getElementsByClassName("address");

    var openMarkerPopup = function() {
        var id = this.getAttribute("data-id");
        markerClusters.eachLayer(function(layer) {
            if (layer.options.id && layer.options.id == id) {
                if (!layer._icon) layer.__parent.spiderfy();
                layer.openPopup();
            }
        });
    };

    for (var i = 0; i < classname.length; i++) {
        classname[i].addEventListener('click', openMarkerPopup, false);
    }
    </script>
    <!--<script src="js/leaflet_map/leaflet_tours_half_screen_func.js"></script>-->

</body>

</html>