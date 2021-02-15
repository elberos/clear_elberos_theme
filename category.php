<?php

global $site_template;

/* Render term */
echo $site_template->render_page
([
	'pages/category_' . $site_template->term->slug . '.twig',
	'pages/category.twig'
]);
