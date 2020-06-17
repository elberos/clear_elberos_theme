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
		add_action('admin_menu', 'SiteTemplateAdmin::register_admin_menu');
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
	
}


}