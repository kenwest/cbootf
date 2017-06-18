<?php

/**
 * @file
 * template.php
 */


/*
 * Derive the city name from the Drupal arguments or the URL
 */
function cbootf_city_string() {
  return cbf_city_string();
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
  $city = cbf_city_string();
  if ($city !== false) {
    $output = str_replace(' in ' . ucwords($city), '', $output);
  }
  return $output;
}

function cbootf_preprocess_html(&$variables) {
  // Is this page associated with a city? Add a CSS class accordingly.
  $city = cbf_city_string();
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
        $icon = 'send-o';
        $title = 'Contact Us';
        break;
      case 'episode':
        $icon = 'university';
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
      $icon = 'send-o';
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

  if (isset($icon)) {
    $title = '<i class="fa fa-fw fa-' . $icon . '"></i>' . $title;
  }

  $result = $title;
}

/*
 * A function to parse the exposed filters on the National Library view,
 * to extract the topics, and return a string containing them.
 */
function cbootf_library_view_topics_string(&$view) {
  if ( ! isset($view->exposed_input['field_topic_tid']) ) {
    return ' ';
  }

  $result = array();

  foreach ($view->exposed_input['field_topic_tid'] as $tid) {
    $queryResult = db_query(
        'select name from {taxonomy_term_data} where tid = :tid',
        array(':tid' => $tid));
    foreach ($queryResult as $row) {
      $result[] = $row->name;
    }
  }

  return implode(' | ', $result);
}

/*
 * When viewing a node or CiviCRM Event entity in 'full' mode, show contextual links.
 * The navigation tabs are hidden by CSS.
 */
function cbootf_entity_view_alter(&$build, $type) {
  if ($build['#view_mode'] == 'full') {
    switch ($type) {
      case 'node':
        if (isset($build['#node']) && !empty($build['#node']->nid)) {
          $id = $build['#node']->nid;
        }
        break;

      case 'civicrm_event':
        if (isset($build['#entity']) && !empty($build['#entity']->id)) {
          $id = $build['#entity']->id;
        }
        break;
    }

    if (isset($id)) {
      $link = str_replace('_', '-', $type);
      $build['#contextual_links'][$type] = array($link, array($id));
    }
  }
}
