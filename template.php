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
	} else if ($variables['page']['content']['system_main']['#attributes']['class'][0] == 'contact-form') {
		$icon = 'exchange';
	}

	if (isset($icon)) {
		if (!isset($title)) {
			$title = drupal_get_title();
		}
		$variables['title'] = '<i class="fa fa-fw fa-' . $icon . '"></i>' . $title;
	}
}
