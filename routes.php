<?php

if (!class_exists(SiteTemplate::class))
{

class SiteTemplate extends StarterSite
{
	
	/**
	 * Custom routes
	 */
	function register_routes()
	{
		/*
		$this->add_route
		(
			"site:articles", "/articles",
			"pages/category.twig",
			[
				'title' => 'Статьи',
				'description' => 'Статьи',
			]
		);
		*/
	}
	
	
	/**
	 * After setup
	 */
	function setup_after()
	{
		
	}
	
	
	/**
	 * Extend context
	 */
	function extend_context($context)
	{
		return $context;
	}
	
	
	
	/**
	 * Render custom route
	 */
	function route_render()
	{
		$template = $this->route_info['template'];
		$context = Timber::context();
		Timber::render( $template, $context );
	}
}


}
else
{
	global $timber_site;
	if ($timber_site)
	{
		$timber_site->route_render();
	}
}