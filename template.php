<?php

/**
 * @file
 * template.php
 */

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
				$icon = 'envelope-o';
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
		$icon = 'envelope-o';
	}

	if (isset($icon)) {
		if (!isset($title)) {
			$title = drupal_get_title();
		}
		$variables['title'] =
				'<i class="fa fa-fw fa-' . $icon . '"></i>'
				. '<div class="title-text">' . $title . '</div>';
	}
}
