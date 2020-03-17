<?php

if (!class_exists(StarterSite::class))
{

trait StarterSiteRoutes
{
	
	/**
	 * Custom routes
	 */
	function register_routes()
	{
		$this->add_route
		(
			"site:articles2", "/articles",
			"pages/category.twig",
			[
				'title' => 'Index page',
				'description' => 'Страница 1',
			]
		);
	}
		
	/**
	 * Extend context
	 */
	function extend_context()
	{
		
	}
	
	
	
	/**
	 * Render custom route
	 */
	function route_render()
	{
		$template = $this->route_info['template'];
		$context = Timber::context();

		if (!$this->breadcrumbs)
		{
			$this->breadcrumbs = 
			[
				[
					"Главная",
					"/"
				],
				[
					$this->route_info['params']['title'],
					$this->site_url
				]
			];
		}

		//var_dump( $this->site_url );
		//var_dump( $this->route_info );

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