<?php
/**
 * Timber starter-theme
 * https://github.com/vistoyn/timber_theme
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.1
 */

if ( ! class_exists( 'Timber' ) ) {
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
Timber::$dirname = array( 'templates', 'views' );


/**
 * By default, Timber does NOT autoescape values. Want to enable Twig's autoescape?
 * No prob! Just set this value to true
 */
Timber::$autoescape = false;


/**
 * Enable cache
 */
//Timber::$cache = true;




/**
 * We're going to configure our theme inside of a subclass of Timber\Site
 * You can move this to its own file and include here via php's include("MySite.php")
 */
class StarterSite extends Timber\Site 
{
	
	public $routes;
	public $route_name = null;
	public $route_matches = null;
	public $route_template = null;
	public $route_params = null;
	
	
	/** Add timber support. */
	public function __construct() 
	{
		parent::__construct();
		
		add_action( 'after_setup_theme', array( $this, 'theme_supports' ) );
		add_filter( 'timber/context', array( $this, 'add_to_context' ) );
		add_filter( 'timber/twig', array( $this, 'add_to_twig' ) );
		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'init', array( $this, 'register_taxonomies' ) );
		
		// Register routes
		$this->register_routes();
		
		// Title
		add_filter('wp_title', [$this, 'filter_page_title'], 20, 1);
		add_filter('thematic_doctitle', [$this, 'filter_page_title'], 20, 1);
		add_filter('pre_get_document_title', [$this, 'filter_page_title'], 20, 1);	
		add_filter('rank_math/json_ld', [$this, 'filter_json_ld'], 99999, 1);
		add_filter('rank_math/frontend/title', [$this, 'filter_page_title'], 10, 1);

		// RankMath plugin
		if (function_exists('rank_math'))
		{
			// Disable replace vars
			remove_action( 'init', [ '\RankMath\Replace_Vars', 'setup' ], 99 );
			
			// Disable robots
			$head = isset(rank_math()->head) ? rank_math()->head : null;
			if ($head != null) remove_action('rank_math/head', [$head, 'robots'], 10);
			add_action('rank_math/head', [$this, 'filter_page_robots'], 10);
		}
	}
	
	function filter_json_ld($data)
	{
		if ($this->route_name != null) return null;
		return $data;
	}
	
	function filter_page_robots()
	{
		echo '<meta name="robots" content="follow,index"/>';
	}
	
	function filter_page_title($orig_title)
	{
		$title = $this->getTitle();
		if ($title == "") return $orig_title;
		$site_name = get_bloginfo("", "name");
		return $title . " - " . $site_name;
	}
	
	function get_route_title()
	{
		if ($this->route_params == null) return "";
		if (!isset($this->route_params['params'])) return "";
		if (!isset($this->route_params['params']['title'])) return "";
		return $this->route_params['params']['title'];
	}
	
	/** This is where you can register custom routes. */
	public function register_routes()
	{
		/* Site index */
		$this->add_route
		(
			"site:index", "/",
			"pages/index.twig",
			[
				'title' => 'Index page',
				// 'keywords' => '',
				// 'description' => '',
			]
		);
	}
	
	/** This is where you can register custom post types. */
	public function register_post_types()
	{
		
	}
	
	/** This is where you can register custom taxonomies. */
	public function register_taxonomies()
	{

	}
	
	
	/** This is where you add some context
	 *
	 * @param string $context context['this'] Being the Twig's {{ this }}.
	 */
	public function add_to_context( $context ) 
	{
		$context['menu'] = new Timber\Menu();
		$context['site'] = $this;
		$context['site_f_inc'] = 30;
		$context['route'] = [
			'template' => $this->route_template,
			'matches' => $this->route_matches,
			'name' => $this->route_name,
		];
		return $context;
	}

	public function theme_supports() 
	{
		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		/*
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

		/*
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
	

	/** This is where you can add your own functions to twig.
	 *
	 * @param string $twig get extension.
	 */
	public function add_to_twig( $twig )
	{
		$twig->addExtension( new Twig_Extension_StringLoader() );		
		$twig->registerUndefinedFunctionCallback(function ($name) {
			if (method_exists($this, $name))
			{
				return new \Twig_Function_Function( array( $this, $name ) );
			}
			if (!function_exists($name))
			{
				return false;
			}
			return new \Twig_Function_Function($name);
		});
		
		$twig->registerUndefinedFilterCallback(function ($name) {
			if (!function_exists($name))
				return false;
			return new \Twig_Function_Function($name);
		});
		
		$twig->addFunction( new Twig_SimpleFunction( 'url', array( $this, 'url_new' ) ) );
		
		return $twig;
	}
	
	
	/**
	 * Add route
	 */
	public function add_route($route_name, $match, $template = null, $params=[])
	{
		if ($template != null)
		{
			Routes::map(
				$match,
				function($matches) use ($route_name, $template, $params)
				{
					$this->route_name = $route_name;
					$this->route_matches = $matches;
					$this->route_template = $template;
					$this->route_params = $params;
					
					query_posts('post_type=route&posts_per_page=0');
					
					Routes::load(
						'route.php', 
						[
							"timber_site" => $this,
						], 
						"/",
						200
					);
				}
			);
		}
		$this->routes[$route_name] = $match;
	}
	
	
	/* Twig functions */
	function url_new($name, $params=null)
	{
		return isset($this->routes[$name]) ? $this->routes[$name] : '';
	}

	function isRouteNameBegins()
	{
		return false;
	}

	function isUrlsEquals()
	{
		return false;
	}
	
}

global $timber_site;
$timber_site = new StarterSite();



/* Other functions */

