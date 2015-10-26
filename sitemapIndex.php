<?php
namespace SimpleSitemapGenerator
{
	class SitemapIndex
	{
		public static $header = '<?xml version="1.0" encoding="UTF-8"?><sitemapindex xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/siteindex.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
		
		
		public static function indexToArray( $filepath )
		{
			if( file_exists($filepath) )
			{
				$arrayindexes = \SimpleSitemapGenerator\XMLTools::createArray( file_get_contents( $filepath ) );
			
				//if only one element
				if( isset($arrayindexes["sitemapindex"]["sitemap"]["loc"]) ) 
				{
					return array($arrayindexes["sitemapindex"]["sitemap"]);
				}
				else
				{
					return $arrayindexes["sitemapindex"]["sitemap"];
				}
			}
			else
			{
				return array();
			}
		}
		
		
		public static function generateIndexFile( $sitemapindex, $nfiles, $path )
		{
		    $handle= fopen( $path."/sitemap.xml", "w+" );
			fwrite($handle, self::$header);
			
			for ( $currentfile = 1; $currentfile <= $nfiles; $currentfile++ )
			{
				$islast = false;
				if($currentfile == $nfiles)
					$islast = true;
				
				fwrite($handle, self::generateSitesFileXML( $sitemapindex[$currentfile - 1], $islast, $currentfile ));
			}
			
			fwrite($handle, "</sitemapindex>");
			fclose($handle);
		}
		
		public static function generateSitesFileXML( $sitesfile, $islast, $currentfile )
		{
			$xml = "";
			$xml .= "<sitemap>";
			
			//location
			if( isset($sitesfile["loc"]) )
			{
				$xml .= "<loc>".$sitesfile["loc"]."</loc>";
			}
			else
			{
				$xml .= "<loc>".\SimpleSitemapGenerator\Sisigen::PROTOCOL."://".$_SERVER["HTTP_HOST"]."/sitemap".$currentfile.".xml</loc>";
			}
			
			//date
			if( $islast )
			{
				$xml .= "<lastmod>".date("Y-m-d")."</lastmod>";
			}
			else
			{
				$xml .= "<lastmod>".$sitesfile["lastmod"]."</lastmod>";
			}
			
			$xml .= "</sitemap>";
			return $xml;
		}
	}
}
?>