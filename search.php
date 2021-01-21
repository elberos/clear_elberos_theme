<?php

$context = Timber::context();
$args = array( 'posts_per_page' => 10, 's'=>isset($_GET['s'])?$_GET['s']:'' );
$context['query'] = $args;
$query = new Timber\PostQuery( $args );
$context['posts'] = $query;
Timber::render( 'pages/category.twig', $context );
