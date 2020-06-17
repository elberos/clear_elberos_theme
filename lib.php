<?php

if (!class_exists(SiteTemplate::class))
{

include __DIR__ . "/admin/include.php";


class SiteTemplate extends StarterSite
{
	
	/**
	 * Assets increment
	 */
	function get_f_inc()
	{
		return 1; /* + */
	}
	
	
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
	 * Register hooks
	 */
	function register_hooks()
	{
		parent::register_hooks();
	}
	
	
	
	/**
	 * After setup
	 */
	function setup_after()
	{
		// $this->page_vars["wp_show"] = false;
	}
	
	
	
	/**
	 * Extend context
	 */
	function extend_context($context)
	{
		global $wpdb;
		
		/* Setup menu */
		/* $context['site_main_menu'] = new Timber\Menu('main-' . $this->language_code); */
		
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