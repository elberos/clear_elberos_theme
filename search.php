<?php

$context = Timber::context();
$args = array( 'posts_per_page' => 4, 's'=>isset($_GET['s'])?$_GET['s']:'' );
$context['query'] = $args;
$query = new Timber\PostQuery( $args );
$context['posts'] = $query->get_posts();
Timber::render( 'pages/category.twig', $context );
