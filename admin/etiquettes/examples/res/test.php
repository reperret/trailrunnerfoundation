<?php
$nbAGenerer=$_GET['nb'];
    
$nbBouclesCourrantes=0;
$start=0;
$nbPagesBoucles=(int)($nbAGenerer/24);
$end=24;
$nbEtiquettesEnPlusDernierePage=$nbAGenerer%24;
if($nbPagesBoucles==0) $end=$nbEtiquettesEnPlusDernierePage;
if($nbEtiquettesEnPlusDernierePage>0) $nbPagesBoucles++;


echo "nb Pages = nb boucle : ".$nbPagesBoucles; echo "<br>";
echo "étiquette en plus dernière page : ".$nbEtiquettesEnPlusDernierePage; echo "<br>";
echo "start : ".$start; echo "<br>";
echo "end : ".$end;
echo "<br><br><br>";
for($i=0;$i<$nbPagesBoucles;$i++)
{
    $nbBouclesCourrantes++;
    
    
    
    
    
    echo "start :".$start; echo "<br>";
    echo "end :".$end; echo "<br>";
    
    
    
    if($nbPagesBoucles==($nbBouclesCourrantes+1))
    {
        $end=$end+$nbEtiquettesEnPlusDernierePage;
    }
    else
    {
        $end=$end+24;
    }
    $start=$start+24;


}

?>