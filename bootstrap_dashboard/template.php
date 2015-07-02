<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function bootstrap_dashboard_preprocess_html(&$variables) {
    
    $is_admin = in_array("administrator",  $GLOBALS['user']->roles);
    $variables['classes_array'][] = $is_admin ? 'admin-user' : "non-admin-user";
}



//function theme_get_setting_ALL($theme = NULL) {
//  $cache = &drupal_static(__FUNCTION__, array());
//
//  // If no key is given, use the current theme if we can determine it.
//  if (!isset($theme)) {
//    $theme = !empty($GLOBALS ['theme_key']) ? $GLOBALS ['theme_key'] : '';
//  }
//
//  if (empty($cache [$theme])) {
//    // Set the default values for each global setting.
//    // To add new global settings, add their default values below, and then
//    // add form elements to system_theme_settings() in system.admin.inc.
//    $cache [$theme] = array(
//      'default_logo' => 1,
//      'logo_path' => '',
//      'default_favicon' => 1,
//      'favicon_path' => '',
//      // Use the IANA-registered MIME type for ICO files as default.
//      'favicon_mimetype' => 'image/vnd.microsoft.icon',
//    );
//    // Turn on all default features.
//    $features = _system_default_theme_features();
//    foreach ($features as $feature) {
//      $cache [$theme]['toggle_' . $feature] = 1;
//    }
//
//    // Get the values for the theme-specific settings from the .info files of
//    // the theme and all its base themes.
//    if ($theme) {
//      $themes = list_themes();
//      $theme_object = $themes [$theme];
//
//      // Create a list which includes the current theme and all its base themes.
//      if (isset($theme_object->base_themes)) {
//        $theme_keys = array_keys($theme_object->base_themes);
//        $theme_keys [] = $theme;
//      }
//      else {
//        $theme_keys = array($theme);
//      }
//      foreach ($theme_keys as $theme_key) {
//        if (!empty($themes [$theme_key]->info['settings'])) {
//          $cache [$theme] = array_merge($cache [$theme], $themes [$theme_key]->info['settings']);
//        }
//      }
//    }
//
//    // Get the saved global settings from the database.
//    $cache [$theme] = array_merge($cache [$theme], variable_get('theme_settings', array()));
//
//    if ($theme) {
//      // Get the saved theme-specific settings from the database.
//      $cache [$theme] = array_merge($cache [$theme], variable_get('theme_' . $theme . '_settings', array()));
//
//      // If the theme does not support a particular feature, override the global
//      // setting and set the value to NULL.
//      if (!empty($theme_object->info ['features'])) {
//        foreach ($features as $feature) {
//          if (!in_array($feature, $theme_object->info ['features'])) {
//            $cache [$theme]['toggle_' . $feature] = NULL;
//          }
//        }
//      }
//
//      // Generate the path to the logo image.
//      if ($cache [$theme]['toggle_logo']) {
//        if ($cache [$theme]['default_logo']) {
//          $cache [$theme]['logo'] = file_create_url(dirname($theme_object->filename) . '/logo.png');
//        }
//        elseif ($cache [$theme]['logo_path']) {
//          $cache [$theme]['logo'] = file_create_url($cache [$theme]['logo_path']);
//        }
//      }
//
//      // Generate the path to the favicon.
//      if ($cache [$theme]['toggle_favicon']) {
//        if ($cache [$theme]['default_favicon']) {
//          if (file_exists($favicon = dirname($theme_object->filename) . '/favicon.ico')) {
//            $cache [$theme]['favicon'] = file_create_url($favicon);
//          }
//          else {
//            $cache [$theme]['favicon'] = file_create_url('misc/favicon.ico');
//          }
//        }
//        elseif ($cache [$theme]['favicon_path']) {
//          $cache [$theme]['favicon'] = file_create_url($cache [$theme]['favicon_path']);
//        }
//        else {
//          $cache [$theme]['toggle_favicon'] = FALSE;
//        }
//      }
//    }
//  }
//
//  return isset($cache [$theme]) ? $cache [$theme] : NULL;
//}


function bootstrap_dashboard_preprocess_page(&$variables) {
	
	$variables['content_column_class'] = ' class="col-sm-12"'; //not as planned in bootstrap while there might be sidebar-first and sidebr-second each of which 
																// take 3 columns out of the 12 but it's more suitable with this hacked theme
	
	
	$navbar_position = theme_get_setting('bootstrap_navbar_position');
	if ($navbar_position != 'fixed-top')
	{
		print "error in theme: please set navbar position = navbar-fixed-top\nnow is is $navbar_position<br>";
	}

	
	$side_bar_well = theme_get_setting('well-sidebar_first');
	if (isset($side_bar_well) )
	{
		print "error in theme: please unset bootstrap_region_well-sidebar_first<br>";
	}
	
	
}