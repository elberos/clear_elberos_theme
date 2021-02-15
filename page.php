<?php

global $site_template;
$site_template->context["post"] = $site_template->post;

/* Render page */
echo $site_template->render_page
([
	'pages/page_' . $site_template->post->ID . '.twig',
	'pages/post_type_' . $site_template->post->post_type . '.twig',
	'pages/page.twig'
]);