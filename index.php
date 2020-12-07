<?php

global $timber_site;
if ($timber_site)
{
	$timber_site->route_render();
}
else
{
	$context = Timber::context();
	//$context['posts'] = new Timber\PostQuery();
	Timber::render( 'pages/index.twig', $context );
}