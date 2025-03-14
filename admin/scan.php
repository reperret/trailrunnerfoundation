<?php
include 'api/bdd.php';
include 'api/fonctionsUtiles.php';
include 'verifAdmin.php';

$dernierCaractereCode=NULL;
$code=NULL;
$id=NULL;

if(isset($_GET['code']) && $_GET['code']!='')
{
    $code=getAzertyFromQwerty($_GET['code']);
    $dernierCaractereCode=substr($code, -1, 1);
}

$id=getIdEFromCode($code,$dbh);
$redirection='detailJeu.php?idE='.$id;

header('Location: '.$redirection);
?>