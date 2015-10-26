# Simple-Sitemap-Generator
A pure PHP class that allows add or remove automatically pages from your sitesmap and generate too your sitemap index, anytime you create a new one


Usage:

include($_SERVER["DOCUMENT_ROOT"]."/simplySitemapGenerator/sisigen.php");

$ssg = new \SimpleSitemapGenerator\Sisigen();

$ssg->addSite( "http://www.newsite.com/newpos/id", "0.8" );


FAQs:

You need to put the 4 classes files in the same directory to work.

It generates a sitemap.xml (index) and all necesarys sitemap1.xml, sitemap2.xml with 500 urls each one.

For work it has to have the same format of http://www.sitemaps.org/, or you can use it without files, and it will generate the files it needs.

Care when you use it, becouse it can delete your currents sitemaps if you dont have the same format.
