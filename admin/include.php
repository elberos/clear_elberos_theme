<?php

if (!class_exists(SiteTemplateAdmin::class))
{


class SiteTemplateAdmin
{
	
	/**
	 * Register hooks
	 */
	static function register_hooks()
	{
		add_action('init', 'SiteTemplateAdmin::init');
		add_action('admin_menu', 'SiteTemplateAdmin::register_admin_menu');
		add_filter('post_type_link', 'SiteTemplateAdmin::post_type_link', false, true);
		add_action(
			'admin_init', 
			function()
			{
			}
		);
	}
	
	
	
	/**
	 * Register Admin Menu
	 */
	public static function register_admin_menu()
	{
	}
	
	
	
	/**
	 * Init
	 */
	public static function init()
	{
	}
	
	
	
	/**
	 * Post type link
	 */
	static function post_type_link($post_link, $post = 0)
	{
		return $post_link;
	}
	
}

if ( class_exists( 'Timber' ) and class_exists( 'Elberos\Site' ) )
{
	SiteTemplateAdmin::register_hooks();
}

}