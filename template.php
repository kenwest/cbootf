<?php

/**
 * @file
 * template.php
 */


function cbootf_preprocess_html(&$variables, $hook) {

	// Attempts to see if a city is set in the URL. Adds a class accordingly.

	$city = '';
	if(arg(0) == 'city' && arg(1) != '') {
		if(!in_array('city-' . arg(1), $variables['classes_array'])){
			$city = arg(1);
		}
	} else {
		$uri = explode('/', $_SERVER['REQUEST_URI']);
		if($uri[1] == 'city' && $uri[2] != ''){
			if(!in_array('city-' . $uri[2], $variables['classes_array'])){
				$city = $uri[2];
			}
		}
	}

	switch ($city) {
		case 'sydney-cbd':
		case 'sydney-cbd-north':
		case 'sydney-cbd-south':
		case 'sydney-legal':
		case 'sydneys-north-shore':
		case 'north-sydney':
		case 'st-leonards':
		case 'chatswood':
		case 'macquarie-park':
		case 'parramatta':
			$city = 'sydney';
			break;
	}

	if ($city != '') {
		$variables['classes_array'][] = 'city-' . $city;
	}
}


function cbootf_preprocess_page(&$variables, $hook) {

	if (isset($variables['node'])) {
		switch ($variables['node']->type) {
			case 'activity':
				$icon = 'group';
				break;
			case 'blog':
				$icon = 'comment-o';
				break;
			case 'campus_connect':
				$icon = 'chain';
				break;
			case 'campus_explore':
				$icon = 'compass';
				break;
			case 'contact_webform':
				$icon = 'exchange';
				$title = 'Contact Us';
				break;
			case 'episode':
				$icon = 'youtube-play';
				break;
			case 'event':
				$icon = 'calendar';
				break;
			case 'story':
				$icon = 'bullhorn';
				break;
			default;
				break;
		}
	} else if (isset($variables['page']['content']['system_main']['search_form'])) {
		$icon = 'search';
	} else if (isset($variables['page']['content']['system_main']['#attributes']['class'][0])) {
		if ($variables['page']['content']['system_main']['#attributes']['class'][0] == 'contact-form') {
			$icon = 'exchange';
		}
	}

	if (isset($icon)) {
		if (!isset($title)) {
			$title = drupal_get_title();
		}
		$variables['title'] = '<i class="fa fa-fw fa-' . $icon . '"></i>' . $title;
	}
}

/*
 * Implementation of hook_views_pre_render
 *   -- Ensures that GMap is centered within the campus_homepage view.
 */
function cbootf_views_pre_render(&$view) {
	$watch = array('city_to_address');
	$displays = array('block_address');

	if ( in_array($view->name, $watch) ) {

		// Modifies the GMap Macro to ensure that the map gets properly centered.
		if ( in_array($view->current_display, $displays)
			 && isset($view->result[0]->gmap_lat)
			 && isset($view->result[0]->gmap_lon) ) {

			$macro = $view->display[$view->current_display]->handler->view->style_plugin->options['macro'];
			if ( !strstr('|center=', $macro) ) {
				$latlong = "{$view->result[0]->gmap_lat},{$view->result[0]->gmap_lon}";

				$macro  = str_replace(']', ' |center=' . $latlong . ']', $macro);
				$view->display[$view->current_display]->handler->view->style_plugin->options['macro'] = $macro;
			}
		}
	}
}

