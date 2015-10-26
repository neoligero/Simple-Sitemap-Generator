<?php
ini_set('display_errors', 1);

include("classes/sisigen.php");

$ssg = new \SimpleSitemapGenerator\Sisigen();
$ssg->addSite( "http://www.yoursite.com", "0.8" );
?>