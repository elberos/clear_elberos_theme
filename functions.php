<?php

include __DIR__ . "/admin/include.php";

define ( 'THEME_WP_SHOW', true );

if ( ! class_exists( 'Timber' ) or ! class_exists( 'Elberos\Site' ) ) {
	add_action( 'admin_notices', function() {
		echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php' ) ) . '</a></p></div>';
	});

	add_filter('template_include', function( $template ) {
		return get_stylesheet_directory() . '/static/no-timber.html';
	});

	return;
}

/**
 * Sets the directories (inside your theme) to find .twig files
 */
Timber::$dirname = array( 'templates' );


/**
 * By default, Timber does NOT autoescape values. Want to enable Twig's autoescape?
 * No prob! Just set this value to true
 */
Timber::$autoescape = true;


/**
 * Enable cache
 */
Timber::$cache = defined('TIMBER_CACHE') ? TIMBER_CACHE : false;


/**
 * We're going to configure our theme inside of a subclass of Timber\Site
 * You can move this to its own file and include here via php's include("MySite.php")
 */
class SiteTemplate extends Elberos\Site
{
	
	/** Theme settings **/
	
	public function action_widgets_init()
	{
		register_sidebar(
			array(
				'name'          => 'Blog Sidebar',
				'id'            => 'sidebar-1',
				'description'   => 'Add widgets here to appear in your sidebar on blog posts and archive pages.',
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			)
		);
	}
	
	public function action_theme_supports() 
	{
		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/**
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		// add_theme_support( 'title-tag' );

		/**
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		/**
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5', array(
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		/**
		 * Enable support for Post Formats.
		 *
		 * See: https://codex.wordpress.org/Post_Formats
		 */
		add_theme_support(
			'post-formats', array(
				'aside',
				'image',
				'video',
				'quote',
				'link',
				'gallery',
				'audio',
			)
		);
		
		add_theme_support( 'menus' );
	}
	
	
	
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
		
		// Add articles page
		$this->add_route
		(
			"site:articles", "/articles",
			"pages/category.twig",
			[
				'title' => 'Статьи',
				'description' => 'Статьи',
				'context' => function($site, $context)
				{
					return $context;
				}
			]
		);
		
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
	
}

global $timber_site;
if (!$timber_site)
{
	$timber_site = new SiteTemplate();
}
