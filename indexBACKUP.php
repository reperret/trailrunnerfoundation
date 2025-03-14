<?php
include 'api/bdd.php';
include 'api/fonctions.php';


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Panagea - Premium site template for travel agencies, hotels and restaurant listing.">
    <meta name="author" content="Ansonika">
    <title>Panagea | Premium site template for travel agencies, hotels and restaurant listing.</title>

    <!-- Favicons-->
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" type="image/x-icon" href="img/apple-touch-icon-57x57-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="img/apple-touch-icon-72x72-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="img/apple-touch-icon-114x114-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="img/apple-touch-icon-144x144-precomposed.png">

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
        html,
        body {
            height: 100%;
        }

    </style>

</head>

<body>

    <div id="page">

        <?php include 'header.php';?>
        <main>
            <div class="container-fluid full-height">
                <div class="row row-height">
                    <div class="col-lg-5 content-left order-md-last order-sm-last order-last">
                        <div id="results_map_view">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-10">
                                        <h4><strong>4</strong> résultats</h4>
                                        <?php print_r(getCourses(NULL,NULL,NULL,NULL,$dbh));?>
                                    </div>
                                    <div class="col-2">
                                        <a href="#0" class="search_map btn_search_map_view"></a> <!-- /open search panel -->
                                    </div>
                                </div>
                                <!-- /row -->
                                <div class="search_map_wp">
                                    <div class="custom-search-input-2 map_view">
                                        <div class="form-group">
                                            <input class="form-control" type="text" placeholder="Que recherchez vous...?">
                                            <i class="icon_search"></i>
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control" type="text" placeholder="Département">
                                            <i class="icon_pin_alt"></i>
                                        </div>
                                        <select class="wide">
                                            <option>Toutes les courses</option>
                                            <option>Courses adhérentes</option>
                                            <option>Courses labelisées</option>
                                        </select>
                                        <input type="submit" value="Rechercher">
                                    </div>
                                </div>
                                <!-- /search_map_wp -->
                            </div>
                            <!-- /container -->
                        </div>
                        <!-- /results -->

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
                            <!-- /container -->
                        </div>
                        <!-- /filters -->

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
                                <!-- /row -->
                            </div>
                        </div>
                        <!-- /Filters -->

                        <div class="box_list map_view">
                            <div class="row g-0 add_top_20">
                                <div class="col-4">
                                    <figure>
                                        <small>Adhérente</small>
                                        <a href="detailscourse.php"><img src="img/C1.jpg" class="img-fluid" alt="" width="800" height="533"></a>
                                    </figure>
                                </div>
                                <div class="col-8">
                                    <div class="wrapper">
                                        <a href="#0" class="wish_bt"></a>
                                        <h3><a href="detailscourse.php">Duo de l'Hermitage</a></h3>
                                        <span class="price">Date : <strong>14/05/2022</strong> au <strong>15/05/2022</strong></span>
                                    </div>
                                    <ul>
                                        <li>
                                            <a href="#0" data-id="1" class="address">Voir sur la carte</a>
                                        </li>
                                        <li>
                                            <div class="score"><span><a href="">Site web</a>
                                                    <em>350 Crozes Hermitage – Tain l’Hermitage (26)</em></span>
                                                <!--<strong>69</strong>-->
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- /box_list -->


                        <div class="box_list map_view">
                            <div class="row g-0 add_top_20">
                                <div class="col-4">
                                    <figure>
                                        <small>Labelisée</small>
                                        <a href="detailscourse.php"><img src="img/C2.jpg" class="img-fluid" alt="" width="800" height="533"></a>
                                    </figure>
                                </div>
                                <div class="col-8">
                                    <div class="wrapper">
                                        <a href="#0" class="wish_bt"></a>
                                        <h3><a href="detailscourse.php">Semi-Marathon du Patrimoine Oloronais</a></h3>
                                        <span class="price">Date : <strong>15/05/2022</strong></span>
                                    </div>
                                    <ul>
                                        <li>
                                            <a href="#0" data-id="1" class="address">Voir sur la carte</a>
                                        </li>
                                        <li>
                                            <div class="score"><span><a href="">Site web</a>
                                                    <em> Oloron Ste Marie (64)</em></span>
                                                <!--<strong>69</strong>-->
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- /box_list -->


                        <div class="box_list map_view">
                            <div class="row g-0 add_top_20">
                                <div class="col-4">
                                    <figure>
                                        <small>Adhérente</small>
                                        <a href="detailscourse.php"><img src="img/C3.jpg" class="img-fluid" alt="" width="800" height="533"></a>
                                    </figure>
                                </div>
                                <div class="col-8">
                                    <div class="wrapper">
                                        <a href="#0" class="wish_bt"></a>
                                        <h3><a href="detailscourse.php">Drop Zone Girls</a></h3>
                                        <span class="price">Date : <strong>15/05/2022</strong></span>
                                    </div>
                                    <ul>
                                        <li>
                                            <a href="#0" data-id="1" class="address">Voir sur la carte</a>
                                        </li>
                                        <li>
                                            <div class="score"><span><a href="">Site web</a>
                                                    <em>St Pée sur Nivelle (64)</em></span>
                                                <!--<strong>69</strong>-->
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- /box_list -->


                        <div class="box_list map_view">
                            <div class="row g-0 add_top_20">
                                <div class="col-4">
                                    <figure>
                                        <small>Adhérente</small>
                                        <a href="detailscourse.php"><img src="img/C4.jpg" class="img-fluid" alt="" width="800" height="533"></a>
                                    </figure>
                                </div>
                                <div class="col-8">
                                    <div class="wrapper">
                                        <a href="#0" class="wish_bt"></a>
                                        <h3><a href="detailscourse.php">Raid Hannibal </a></h3>
                                        <span class="price">Date : <strong>26/05/2022</strong> au <strong>29/05/2022</strong></span>
                                    </div>
                                    <ul>
                                        <li>
                                            <a href="#0" data-id="1" class="address">Voir sur la carte</a>
                                        </li>
                                        <li>
                                            <div class="score"><span><a href="">Site web</a>
                                                    <em>Raid multisports dans les Alpes</em></span>
                                                <!--<strong>69</strong>-->
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- /box_list -->




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

    <!-- COMMON SCRIPTS -->
    <script src="js/common_scripts.js"></script>
    <script src="js/main.js"></script>
    <script src="assets/validate.js"></script>

    <!-- Map LeafLet + Mapbox-->
    <script src="js/leaflet_map/leaflet.min.js"></script>
    <script src="js/leaflet_map/leaflet_markercluster.min.js"></script>
    <!--<script src="js/leaflet_map/leaflet_tours_markers.js"></script>-->
    <script>
        var markers = [{
                "id": 1,
                "type_point": "Labelisée",
                "location_latitude": 45.070280000000025,
                "location_longitude": 4.837610000000041,
                "map_image_url": "img/thumb_map_single_tour.jpg",
                "rate": "Site web",
                "name_point": "Blablabla",
                "get_directions_start_address": "",
                "phone": "04 50 58 55 90",
                "url_point": "detailscourse.php"
            },
            {
                "id": 2,
                "type_point": "Labelisée",
                "location_latitude": 43.19283000000007,
                "location_longitude": -0.60576999999995,
                "map_image_url": "img/thumb_map_single_tour.jpg",
                "rate": "Site web",
                "name_point": "Blablabla",
                "get_directions_start_address": "",
                "phone": "04 50 58 55 90",
                "url_point": "detailscourse.php"
            },
            {
                "id": 3,
                "type_point": "Museum",
                "location_latitude": 43.356670000000065,
                "location_longitude": -1.548689999999965,
                "map_image_url": "img/thumb_map_single_tour.jpg",
                "rate": "Superb | 7.5",
                "name_point": "Louvre",
                "get_directions_start_address": "",
                "phone": "+3934245255",
                "url_point": "detailscourse.php"
            },
            {
                "id": 4,
                "type_point": "Museum",
                "location_latitude": 45.194000000000074,
                "location_longitude": 5.732010000000059,
                "map_image_url": "img/thumb_map_single_tour.jpg",
                "rate": "Superb | 7.5",
                "name_point": "Pompidou",
                "get_directions_start_address": "",
                "phone": "+3934245255",
                "url_point": "detailscourse.php"
            }
        ];

    </script>
    <!-- <script src="js/leaflet_map/leaflet_no_mapbox_tours_half_screen_func.js"></script>-->
    <?php
    $gps=array();
    $gps[]=array("45.070280000000025","4.837610000000041");
    $gps[]=array("43.19283000000007","-0.60576999999995");
    $gps[]=array("43.356670000000065","-1.548689999999965");
    $gps[]=array("45.194000000000074","5.732010000000059");
    $center=getCenterLatLng($gps);
    ?>
    <script>
        var map = L.map('map', {
            center: [<?php echo $center[0];?>, <?php echo $center[1];?>],
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


        var myIcon = L.icon({
            iconUrl: 'img/pins/Marker.png',
            iconRetinaUrl: 'img/pins/Marker.png',
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

        for (var i = 0; i < markers.length; ++i) {
            var popup =
                '<img src="' + markers[i].map_image_url + '" alt=""/>' +
                '<span>' +
                '<span class="infobox_rate">' + markers[i].rate + '</span>' +
                '<em>' + markers[i].type_point + '</em>' +
                '<h3>' + markers[i].name_point + '</h3>' +
                '<a href="' + markers[i].url_point + '" class="btn_infobox_detail"></a>' +
                '<form action="http://maps.google.com/maps" method="get" target="_blank"><input name="saddr" value="' + markers[i].get_directions_start_address + '" type="hidden"><input type="hidden" name="daddr" value="' + markers[i].location_latitude + ',' + markers[i].location_longitude + '"><button type="submit" value="Get directions" class="btn_infobox_get_directions">Get directions</button></form>' +
                '<a href="tel://' + markers[i].phone + '" class="btn_infobox_phone">' + markers[i].phone + '</a>' +
                '</span>';


            var m = L.marker([markers[i].location_latitude, markers[i].location_longitude], {
                id: markers[i].id,
                icon: myIcon
            }).bindPopup(popup);

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
