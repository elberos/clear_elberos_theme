<?php

global $site_template;
$site_template->context["post"] = $site_template->post;

if ( post_password_required( $site_template->post->ID ) )
{
	echo $site_template->render_page
	([
		'pages/page_password.twig',
	]);
}
else
{
	echo $site_template->render_page
	([
		'pages/page_' . $site_template->post->ID . '.twig',
		'pages/post_type_' . $site_template->post->post_type . '.twig',
		'pages/page.twig'
	]);
}