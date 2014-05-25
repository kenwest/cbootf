<?php

/**
 * @file
 * template.php
 */


/*
 * Derive the city name from the Drupal arguments or the URL
 */
function cbootf_city_string() {
	/*
	 * The city name is initially unknown, but only needs to be calculated
	 * once per request
	 */
	static $cbootf_city = null;

	if ( !isset($cbootf_city) ) {
		/*
		 * There is no $city unless specified in the Drupal args or URL
		 */
		$city = false;

		if (arg(0) == 'city' && arg(1) != '') {
			$city = arg(1);
		} else {
			$uri = explode('/', $_SERVER['REQUEST_URI']);
			if($uri[1] == 'city' && isset($uri[2]) ){
				$city = $uri[2];
			}
		}

		switch ($city) {
			// The cities
			case 'sydney':
			case 'melbourne':
			case 'brisbane':
			case 'perth':
			case 'adelaide':
				$cbootf_city = $city;
				break;

			// The areas in Sydney
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
				$cbootf_city = 'sydney';
				break;

			// Anything else is not a city
			default:
				$cbootf_city = false;
				break;
		}
	}

	return $cbootf_city;
}


/*
 * If the $output string is being displayed on a page associated with a
 * particular $city, then remove strings of the form ' in $city'.
 *
 * Purpose:
 *    To avoid blocks having repeating references to ' in $city' when
 *    the page context tells us we are ' in $city'.
 *
 * Examples:
 *  - On the page /city/sydney remove the string ' in Sydney' from
 *    the 'node'/'title' of Activities listed in views.
 *  - On the page /city/activity/public-forum don't change the titles
 *    of sub-activities, which are ' in Sydney', ' in Perth' etc.
 *
 * Potential issues:
 *  - May need to restrict logic to blocks.
 *  - $output is HTML so may contain ' in $city' as part of the markup.
 *    This is unlikely given the current conventions for URLs, CSS class
 *    names etc.
 */
function cbootf_trim_in_city_string($output) {
	$city = cbootf_city_string();
	if ($city !== false) {
		$output = str_replace(' in ' . ucwords($city), '', $output);
	}
	return $output;
}

function cbootf_preprocess_html(&$variables) {
	// Is this page associated with a city? Add a CSS class accordingly.
	$city = cbootf_city_string();
	if ($city !== false) {
		$variables['classes_array'][] = 'city-' . $city;
	}
}


function cbootf_preprocess_page(&$variables) {
	$icon = null;
	$title = null;

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

	_cbootf_set_title($variables['title'], $title, drupal_get_title(), $icon);
}

function cbootf_preprocess_block(&$variables) {
	_cbootf_set_title($variables['block']->subject, $variables['block']->subject, null, null);
}

/*
 * This function sets the title text.
 *  - Adds an icon if one is supplied and the title doesn't already include one
 *  - Puts the title text into a DIV element
 *  - Use the alternate title if it is set and the title isn't
 *  - Do nothing if the title is empty
 */
function _cbootf_set_title(&$result, $title, $alternateTitle, $icon) {
	$iconEnd = '</i>';

	if (!isset($title) && isset($alternateTitle)) {
		$title = $alternateTitle;
	}

	if (empty($title)) {
		return;
	}

	$position = strpos($title, $iconEnd);
	if ($position === false) {
		$start = 0;
	} else {
		$start = $position + strlen($iconEnd);
		$icon = null;
	}

	$title = substr($title, 0, $start) . '<div class="title-text">' . substr($title, $start) . '</div>';

	if (isset($icon)) {
		$title = '<i class="fa fa-fw fa-' . $icon . '"></i>' . $title;
	}

	$result = $title;
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
