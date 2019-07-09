<?php
/**
 * Timber Clear theme
 * https://github.com/vistoyn/timber_theme
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.1
 */

global $timber_site;
$template = $timber_site->route_template;
$context = Timber::context();
Timber::render( $template, $context );
