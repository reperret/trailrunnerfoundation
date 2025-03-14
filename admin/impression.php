<?php

// Counting number of checked checkboxes.
$checked_count = count($_POST['listeJeuxAImprimer']);
echo "You have selected following ".$checked_count." option(s): <br/>";

foreach($_POST['listeJeuxAImprimer'] as $selected) 
{
    echo $selected;
    echo "<br>";
}

?>