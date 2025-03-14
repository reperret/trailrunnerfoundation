<?php
// Nb Adhérent 
$numAdherentSimule=1;
$nbParPage=21;
// Préparation pagination
$nbBouclesCourrantes=0;
$start=0;
$nbPagesBoucles=(int)($nbAGenerer/$nbParPage);
$end=$nbParPage;
$nbEtiquettesEnPlusDernierePage=$nbAGenerer%$nbParPage;
if($nbPagesBoucles==0) $end=$nbEtiquettesEnPlusDernierePage;
if($nbEtiquettesEnPlusDernierePage>0) $nbPagesBoucles++;

echo "arf";
?>

