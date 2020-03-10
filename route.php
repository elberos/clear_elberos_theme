<?php

global $timber_site;
$template = $timber_site->route_template;
$context = Timber::context();
Timber::render( $template, $context );
