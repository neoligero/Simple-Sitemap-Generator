<?php

namespace SimpleSitemapGenerator

{

	class Sisigen

	{

		CONST maxURL = 500;

		CONST maxFILES = 1000;

		CONST PROTOCOL = "http";
 
		

		private $sitemapindex = array();

		private $urlset = array();

		private $nfiles = 1;

		private $path;

		

		

		function __construct()

		{

			require_once("sitemap.php");

			require_once("sitemapIndex.php");

			require_once("xmlTools.php");

			$this->path = $_SERVER["DOCUMENT_ROOT"];

		}

		

		

		public function getSitemaps()

		{

			$this->sitemapindex = \SimpleSitemapGenerator\SitemapIndex::indexToArray( $this->path."/sitemap.xml" );

		}

		

		

		public function getAllURLs()

		{

			foreach ( $this->sitemapindex as $sitesfile )

			{

				$this->urlset = array_merge( $this->urlset, \SimpleSitemapGenerator\Sitemap::URLsToArray( $sitesfile["loc"] ) );

			}

			

			if( count($this->urlset) == 0 )

				$this->urlset = array( \SimpleSitemapGenerator\Sitemap::createArrayURL( self::PROTOCOL."://".$_SERVER["HTTP_HOST"], "1" ) );

		}

		

		

		public function addSite( $siteurl, $priority = "0.8" )

		{

			$this->getSitemaps();

			$this->getAllURLs();

			$this->urlset[] = \SimpleSitemapGenerator\Sitemap::createArrayURL( $siteurl, $priority );

			$this->generateFiles( true );

		}

		

		

		public function removeSite( $siteurl )

		{

			$this->getSitemaps();

			$this->getAllURLs();

			foreach ($this->urlset as $key => $value)

			{
				if( $value["loc"] == $siteurl )

				{

					unset( $this->urlset[$key] );

				}
			}

			$this->urlset = array_values($this->urlset);

			$this->generateFiles( false );

		}

		

		

		public function generateFiles( $isinsertion )

		{

			if( count($this->urlset) > 0 )

			{

				$this->nfiles = \SimpleSitemapGenerator\Sitemap::generateMapFiles( $this->urlset, $this->path, $isinsertion );

				\SimpleSitemapGenerator\SitemapIndex::generateIndexFile( $this->sitemapindex, $this->nfiles, $this->path );

			}

		}

	}

}

?>