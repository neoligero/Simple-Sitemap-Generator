<?php
namespace SimpleSitemapGenerator
{
	class Sitemap
	{
		public static $header = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
		
		
		public static function URLsToArray( $sitelocation )
		{
			$arrayindexes = \SimpleSitemapGenerator\XMLTools::createArray( file_get_contents( $sitelocation ) );
			//if only one element, a trick to have all elements in the same level
			if( isset($arrayindexes["urlset"]["url"]["loc"]) ) 
			{
				return array($arrayindexes["urlset"]["url"]);
			}
			else
			{
				return $arrayindexes["urlset"]["url"];
			}
		}
		
		
		public static function createArrayURL( $siteurl, $priority )
		{
			$url = array();
			$url["loc"] = $siteurl;
			$url["lastmod"] = date("Y-m-d");
			$url["changefreq"] = "daily";
			$url["priority"] = $priority;
			
			return $url;
		}
		
		
		public static function createXMLURL( $sitearray )
		{
			$xml = "";
			$xml .= "<url>";
			$xml .= "<loc>".$sitearray["loc"]."</loc>";
			$xml .= "<lastmod>".$sitearray["lastmod"]."</lastmod>";
			$xml .= "<changefreq>".$sitearray["changefreq"]."</changefreq>";
			$xml .= "<priority>".$sitearray["priority"]."</priority>";
			$xml .= "</url>";
			
			return $xml;
		}
		
		public static function generateMapFiles( $urlset, $path, $isinsertion )
		{
			$nURLs = count($urlset);
			$filenumber = 1;
			$startpoint = 0;
			$currentoffset = 0;
			
			if( $isinsertion )
			{
				// the next integer, the file we start to write
				$filenumber = ceil( $nURLs / \SimpleSitemapGenerator\Sisigen::maxURL);
				$startpoint = ($filenumber - 1) * \SimpleSitemapGenerator\Sisigen::maxURL;
				$currentoffset = $startpoint;
			}
			
			$filenumber--;
			//secure to 1000 files to avoid create infinite files if an error occurs
			while( $currentoffset <  $nURLs && $filenumber < \SimpleSitemapGenerator\Sisigen::maxFILES ) 
			{
				// next file and we reset the start point
				$filenumber++;
				$startpoint = $currentoffset;
				
				// file creation
				$handle= fopen( $path."/sitemap".$filenumber.".xml", "w+" );
				fwrite($handle, self::$header);
				for ( $currentoffset; $currentoffset < $nURLs && $currentoffset < ($startpoint + \SimpleSitemapGenerator\Sisigen::maxURL); $currentoffset++ )
				{
					fwrite($handle, self::createXMLURL( $urlset[$currentoffset] ));
				}
				fwrite($handle, "</urlset>");
				fclose($handle);
			}
			
			if( !$isinsertion )
			{
				if( file_exists( $path."/sitemap".($filenumber + 1).".xml" ) )
				{
					unlink( $path."/sitemap".($filenumber + 1).".xml" );
				}
			}
			
			return $filenumber;
		}
	}
} 