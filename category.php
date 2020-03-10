<?php

$context = Timber::context();
$category = new Timber\Term();
$context['category'] = $category;
Timber::render( array( 'pages/category-' . $category->slug . '.twig', 'pages/category.twig' ), $context );
