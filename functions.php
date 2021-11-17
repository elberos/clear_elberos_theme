<?php

define ( 'THEME_WP_SHOW', true );

if ( ! class_exists( 'Elberos\Site' ) ) {
	add_action( 'admin_notices', function() {
		echo '<div class="error"><p>Elberos Core is not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php' ) ) . '</a></p></div>';
	});

	add_filter('template_include', function( $template ) {
		return get_stylesheet_directory() . '/templates/no-core.html';
	});
	
	return;
}


require_once __DIR__ . "/admin/include.php";
require_once __DIR__ . "/controllers/DefaultController.php";



/**
 * Site template
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
	 * Register hooks
	 */
	function register_hooks()
	{
		parent::register_hooks();
	}
	
	
	
	/**
	 * Init
	 */
	public function setup_init()
	{
		/**
		 * Enable cache
		 */
		$this->twig_cache = defined('TWIG_CACHE') ? TWIG_CACHE : true;
	}
	
	
	
	/**
	 * After setup
	 */
	function setup_after()
	{
		// $this->page_vars["wp_show"] = false;
	}
	
	
	
	/**
	 * Returns current title
	 */
	public function get_current_title()
	{
		return parent::get_current_title();
	}
	
	
	
	/**
	 * Returns current description
	 */
	public function get_current_description()
	{
		return parent::get_current_description();
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
	 * Custom routes
	 */
	function register_routes()
	{
		$this->addController(new \App\DefaultController());
	}
}

global $site_template;
if (!$site_template)
{
	$site_template = new SiteTemplate();
}
