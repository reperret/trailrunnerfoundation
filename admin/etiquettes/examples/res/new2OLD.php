<?php

// Nb Adhérent 
$numAdherentSimule=1;

// Préparation pagination
$nbBouclesCourrantes=0;
$start=0;
$nbPagesBoucles=(int)($nbAGenerer/24);
$end=24;
$nbEtiquettesEnPlusDernierePage=$nbAGenerer%24;
if($nbPagesBoucles==0) $end=$nbEtiquettesEnPlusDernierePage;
if($nbEtiquettesEnPlusDernierePage>0) $nbPagesBoucles++;

for($b=0;$b<$nbPagesBoucles;$b++)
{
    $nbBouclesCourrantes++;
    ?>


<page>
        <style type="text/css">
            table, html
            {
                width:  100%;
                margin:0px;
                padding:0px;
            }
         
            .contour
            {
                text-align: left;
                border: solid 1px #CCC;
            }
            .tg  {border-collapse:collapse;border-spacing:0; margin: 0px; padding: 0px}
            .tg td{font-family: Arial; sans-serif;font-size:14px;overflow:hidden; margin:0px;
            padding:0px; }
            .tg th{font-family: Arial, sans-serif; sans-serif;font-size:14px;font-weight:normal;overflow:hidden;border-color:black;margin: 0px}
            .tg .tg-cly1{text-align:left; padding: 0px; margin: 0px}
            .tg .tg-0lax{text-align:left;vertical-align:bottom; padding: 0px; margin: 0px}
            img{padding:0px;margin:0px}
        </style>
      

        
        
         <!--
       <div style="rotate:90;margin:0px;padding:0px;text-align:center;font-size:8px;color: #984807;   position: absolute;  top: 1000px;  left: 50px; ">www.cabaneajeux.fr<br><barcode type="C39" value="1"  label="label" style="width:27mm; height:8mm; color: #000; font-size: 2.5mm; font-weight: bold; margin:auto;color: #984807;" ></barcode></div>

        <div style="rotate:90;margin:0px;padding:0px;text-align:center;font-size:8px;color: #984807;   position: absolute;  top: 19px;  left: 470px; ">www.cabaneajeux.fr<br><barcode type="C39" value="2"  label="label" style="width:27mm; height:8mm; color: #000; font-size: 2.5mm; font-weight: bold; margin:auto;color: #984807;" ></barcode></div>
        
        <div style="rotate:90;margin:0px;padding:0px;text-align:center;font-size:8px;color: #984807;   position: absolute;  top: 19px;  left: 731px; ">www.cabaneajeux.fr<br><barcode type="C39" value="3"  label="label" style="width:27mm; height:8mm; color: #000; font-size: 2.5mm; font-weight: bold; margin:auto;color: #984807;" ></barcode></div>
        
        <div style="rotate:90;margin:0px;padding:0px;text-align:center;font-size:8px;color: #984807;   position: absolute;  top: 153px;  left: 209px; ">www.cabaneajeux.fr<br><barcode type="C39" value="3"  label="label" style="width:27mm; height:8mm; color: #000; font-size: 2.5mm; font-weight: bold; margin:auto;color: #984807;" ></barcode></div>

-->
        <?php
        $xOffset=array();
        $xOffset[0]=212;
        $xOffset[1]=478;
        $xOffset[2]=740;
        $yOffset=134;
        $xInit=212;
        $yInit=19;
        $i=0;
        $first=true;
        $trOuvrant=true;
        $trFermant=false;
        $nbElementsParLigne=0;
        
        for($j=$start; $j<$end; $j++) 
        {
            
            if($first)
            {
                $yInit=19;  
                $first=false;
            }
            elseif($trOuvrant)
            {
                $yInit=$yInit+$yOffset;
            }
          
            
             if($trOuvrant){  $trOuvrant=false;} 
            
                        ?><div style="rotate:90;margin:0px;padding:0px;text-align:center;font-size:8px;color: #984807;   position: absolute;  top: <?php echo $yInit;?>px;  left: <?php echo $xOffset[$nbElementsParLigne];?>px; ">www.cabaneajeux.fr<br><barcode type="C39" value="<?php echo $listingExemplaires[$j]['cbJeu'];?>"  label="label" style="width:27mm; height:8mm; color: #000; font-size: 2.5mm; font-weight: bold; margin:auto;color: #984807;" ></barcode></div><?php
            
                $nbElementsParLigne++;
                if($nbElementsParLigne==3) $trFermant=true;
              if($trFermant){  $trFermant=false; $trOuvrant=true;$nbElementsParLigne=0;} 
            $numAdherentSimule++;
            
        }
        

        
              
        
        $xOffset=array();
        $xOffset[0]=209;
        $xOffset[1]=470;
        $xOffset[2]=731;
        $yOffset=134;
        $xInit=209;
        $yInit=19;
        $i=0;
        $first=true;
        $trOuvrant=true;
        $trFermant=false;
        $nbElementsParLigne=0;
                       
        for($j=$start; $j<$end; $j++) 
        {
        
                
            if($first) 
            { ?><table>
            <col style="width: 33.33%">
            <col style="width: 33.33%">
            <col style="width: 33.33%"><?php $first=false;
            }?>

            
        
                
                <?php if($trOuvrant){ echo "<tr>"; $trOuvrant=false;} ?>
                <td class="contour">
                    <table class="tg">
                        <tr>
                            <td class="tg-cly1" colspan="5" style="padding-left: 3px;">
                                <span style="font-size: 16px; font-weight: bold;  color: #984807;padding: 0px; margin :0px; "><?php echo $listingExemplaires[$j]['libelleJeu'];?>
                                </span>
                            </td>
                            <td class="tg-0lax" colspan="3" rowspan="5"></td>
                        </tr>
                        <tr>
                            <td class="tg-cly1" style="height:30px;width:80%;font-size: 12px; padding-left: 3px;font-style: italic; color: #984807;padding: 0px; margin :0px" colspan="5">
                                <?php echo $listingExemplaires[$j]['mecanismesJeu'];?>
                            </td>
                        </tr>
                        <tr>
                            <td class="tg-cly1" style="height:45px;width:70%;font-size: 10px;padding-left: 3px; margin :0px " colspan="5">
                                <?php 
                                    if(strlen($listingExemplaires[$j]['descriptionJeu'])>110)
                                    {
                                        echo substr($listingExemplaires[$j]['descriptionJeu'],0, 110)." [...]";
                                    }
                                    else
                                    {
                                        echo $listingExemplaires[$j]['descriptionJeu'];
                                    }
                                
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="tg-cly1" style="width:16%;padding: 0px; margin :0px; text-align:center"><img src="/var/www/html/cabaneajeux/html2pdf-4.4.0/html2pdf-4.4.0/examples/res/picto1.png"></td>
                            <td class="tg-cly1" style="width:16%;padding: 0px; margin :0px; text-align:center"><img src="/var/www/html/cabaneajeux/html2pdf-4.4.0/html2pdf-4.4.0/examples/res/picto2.png"></td>
                            <td class="tg-cly1" style="width:16%;padding: 0px; margin :0px; text-align:center"><img src="/var/www/html/cabaneajeux/html2pdf-4.4.0/html2pdf-4.4.0/examples/res/picto3.png"></td>
                            <td class="tg-cly1" style="width:16%;padding: 0px; margin :0px; text-align:center"><img src="/var/www/html/cabaneajeux/html2pdf-4.4.0/html2pdf-4.4.0/examples/res/picto3.png"></td>
                            <td class="tg-cly1" style="width:16%;padding: 0px; margin :0px; text-align:center" rowspan="2"><img src="/var/www/html/cabaneajeux/html2pdf-4.4.0/html2pdf-4.4.0/examples/res/picto4.png"></td>
                        </tr>
                        <tr>
                            <td class="tg-0lax" style="font-size: 14px; font-weight: bold; font-style: italic; color: #984807;padding: 0px; margin :0px; color: #4a8522; text-align:center"><?php echo $listingExemplaires[$j]['ageMinimumJeu'];?>+</td>
                            <td class="tg-0lax" style="font-size: 14px; font-weight: bold; font-style: italic; color: #984807;padding: 0px; margin :0px; color: #4a8522; text-align:center"><?php echo $listingExemplaires[$j]['joueursMinJeu'];?>-<?php echo $listingExemplaires[$j]['joueursMaxJeu'];?></td>
                            <td class="tg-0lax" style="font-size: 14px; font-weight: bold; font-style: italic; color: #984807;padding: 0px; margin :0px; color: #4a8522; text-align:center"><?php echo $listingExemplaires[$j]['dureeJeu'];?>'</td>
                            
                        </tr>
                    </table>        
                </td>
                <?php 
                $nbElementsParLigne++;
                if($nbElementsParLigne==3) $trFermant=true;
                ?>
              
          
                <?php if($trFermant){ echo "</tr>"; $trFermant=false; $trOuvrant=true;$nbElementsParLigne=0;} ?>
        <?php

        }
        if($nbElementsParLigne!=0) echo '</tr>';
        ?>

        </table>
    
    <?php
    
      if($nbPagesBoucles==($nbBouclesCourrantes+1))
    {
        $end=$end+$nbEtiquettesEnPlusDernierePage;
    }
    else
    {
        $end=$end+24;
    }
    $start=$start+24;
    
    ?>

</page>

<?php

    
}
?>

