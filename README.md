# Simple-Sitemap-Generator
A pure PHP class that allows add or remove automatically pages from your sitesmap and generate too your sitemap index, anytime you create a new one


Usage:

include($_SERVER["DOCUMENT_ROOT"]."/simplySitemapGenerator/sisigen.php");
$ssg = new \SimpleSitemapGenerator\Sisigen();
$ssg->addSite( "http://www.newsite.com/newpos/id", "0.8" );
