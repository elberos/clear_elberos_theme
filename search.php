<?php

$args = array( 'posts_per_page' => 10, 's'=>isset($_GET['s']) ? $_GET['s']: '' );
query_posts($args);

global $site_template;
echo $site_template->render_page([ 'pages/category.twig' ]);
