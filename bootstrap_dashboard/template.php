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


// change to field__field_collection ?
function bootstrap_dashboard_preprocess_field(&$variables, $hook) {
//  $element = $variables['element'];
//  if (isset($element['#field_name'])) {
//    if ($element['#field_name'] == 'field_instant_messaging_collecti') {
//      //$variables['classes_array'][] = 'aClassName';
//		print "<pre>" . print_r(array_keys($variables), true). "</pre>";
//		print "<pre>" . print_r($variables['field_name_css'], true). "</pre>";
//		print "<pre>" . print_r($variables['field_type_css'], true). "</pre>";
//		print "<pre>" . print_r($variables['classes_array'], true). "</pre>";
//		print "<pre>" . print_r($variables['theme_hook_suggestions'], true). "</pre>";
//		
//		$variables['classes_array'][] = 'hidden';
//    }
//  }
}

/**
 * Implements hook_preprocess_HOOK().
 */
function bootstrap_dashboard_preprocess_entity(&$variables, $hook)
{
	watchdog("bootstrap_dashboard", "preprocess_entity". '_' . $variables['entity_type']);	

	$function = __FUNCTION__ . '_' . $variables['entity_type'];
	if (function_exists ($function)) {
		$function($variables, $hook);
	}
}
function bootstrap_dashboard_preprocess_entity_crm_core_contact(&$variables, $hook)
{
//	file_save_data(print_r($variables['content']['field_instant_messaging_collecti'], true), 'public://vars_file');
//	watchdog("bootstrap_dashboard", "preprocess_contact:" . print_r($variables, true));	
	foreach (array('field_instant_messaging_collecti', 'field_phone', 'field_address') as $field)
	if (empty($variables['content'][$field]['#items']))
		$variables['content'][$field]['#access'] = 0;
//	print "<pre>" . print_r(array_key($variables), true). "</pre>";	
//  if ($variables['uid'] != 1) {
//    // You can call this variable any way you want, just put it into $variables['element'] and set as TRUE.
//    $variables['element']['hide_admin_field_group'] = TRUE;
//  }
}

function bootstrap_dashboard_field_group_build_pre_render_alter(&$element) {
	watchdog("bootstrap_dashboard", "AAA");	
//  if (isset($element['hide_admin_field_group']) && isset($element['hide_admin_field_group'])) {
//    $element['hide_admin_field_group']['#access'] = FALSE;
//  }
}