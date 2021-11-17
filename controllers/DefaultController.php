<?php

namespace App;


class DefaultController
{
	
	function registerRoutes($site)
	{
		$site->add_route
		(
			"site:index", "/",
			"pages/index.twig",
			[
				'title' => 'Главная страница',
				'description' => 'Главная страница',
				'render' => [$this, 'actionIndex'],
			]
		);
		
		/*
		$site->add_route
		(
			"site:articles", "/",
			"pages/articles.twig",
			[
				'title' => 'Статьи',
				'description' => 'Статьи',
				'render' => [$this, 'actionArticles'],
			]
		);
		*/
	}
	
	
	
	/**
	 * Action index
	 */
	function actionIndex($site)
	{
	}
	
	
	/**
	 * Action articles
	 */
	function actionArticles($site)
	{
	}
}