<?php
/**
 * HTML2PDF Library - example
 *
 * HTML => PDF convertor
 * distributed under the LGPL License
 *
 * @package   Html2pdf
 * @author    Laurent MINGUET <webmaster@html2pdf.fr>
 * @copyright 2016 Laurent MINGUET
 *
 * isset($_GET['vuehtml']) is not mandatory
 * it allow to display the result in the HTML format
 */


include '../../api/bdd.php';
include '../../api/fonctionsUtiles.php';
include '../../verifAdmin.php';


$nbAGenerer = count($_POST['listeJeuxAImprimer']);
$listingExemplaires=array();
$i=0;
foreach($_POST['listeJeuxAImprimer'] as $idExemplaire) 
{
    $infoExemplaire=getExemplaire($idLudotheque,$idExemplaire,NULL,$dbh);
    $infoExemplaire=$infoExemplaire[0];
    $listingExemplaires[$i]['libelleJeu']=$infoExemplaire['libelleJeu'];
    $listingExemplaires[$i]['mecanismesJeu']=$infoExemplaire['mecanismesJeu'];
    $listingExemplaires[$i]['cbJeu']=$infoExemplaire['cbJeu'];
    $listingExemplaires[$i]['descriptionJeu']=$infoExemplaire['descriptionJeu'];
    $listingExemplaires[$i]['ageMinimumJeu']=$infoExemplaire['ageMinimumJeu'];
    $listingExemplaires[$i]['joueursMinJeu']=$infoExemplaire['joueursMinJeu'];
    $listingExemplaires[$i]['joueursMaxJeu']=$infoExemplaire['joueursMaxJeu'];
    $listingExemplaires[$i]['dureeJeu']=$infoExemplaire['dureeJeu'];
    $listingExemplaires[$i]['litteratieJeu']=$infoExemplaire['litteratieJeu'];
    $listingExemplaires[$i]['typeJeu']=$infoExemplaire['typeJeu'];
    $listingExemplaires[$i]['difficulteJeu']=$infoExemplaire['difficulteJeu'];
    $listingExemplaires[$i]['idJeu']=$infoExemplaire['idJeu'];
    $i++;
}



    ob_start();
    include('/var/www/remyperret.org/cabaneajeux/etiquettes/examples/res/new2.php');
    $content = ob_get_clean();

    // convert to PDF
    require_once('/var/www/remyperret.org/cabaneajeux/etiquettes/html2pdf.class.php');
    try
    {
        //$html2pdf->addFont("Roboto", "", "roboto.ttf");
        $html2pdf = new HTML2PDF('P', 'A4', 'en', true, 'UTF-8', array(0, 0, 0, 0));
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('etiquettes.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
