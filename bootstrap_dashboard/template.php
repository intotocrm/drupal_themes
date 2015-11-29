<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 
 
 function bootstrap_dashboard_field($variables)
 {
	 if (isset($variables['internal']) && $variables['internal'] ||
			 isset($variables['element']['#entity_type']) && in_array ($variables['element']['#entity_type'], ['field_collection_item', 'taxonomy_term'])
		) //field colelction items should be seen as a whole field, subfields shouldn't have field wraps
	 {
//		 return "<pre>" . print_r($variables, true) . "</pre>";
		 $out = [];
		 foreach($variables['items'] as $item)
		 {
			 $out[] = render($item);
		 }
		 return join(" ", $out);
	 }
	 if (isset($variables['element']['#formatter']) && in_array($variables['element']['#formatter'] , ['intoto_caption_formatter', 'intoto_label_formatter', 'intoto_icon_formatter',]))
	 {
		$variables['element']["#label_display"] = 'hidden';
		$variables['label_hidden'] = true;
	 }
	 return theme_field($variables);
 }


function bootstrap_dashboard_preprocess_html(&$variables) {
    
    $is_admin = in_array("administrator",  $GLOBALS['user']->roles);
	$user_var = $GLOBALS['user'];
    $variables['classes_array'][] = $is_admin ? 'admin-user' : "non-admin-user";
    $variables['user_var'] = $user_var;

	
	if ( isset($_GET['overlay'])  ) { //&& $_GET['overlay'] == 'true'
		$variables['theme_hook_suggestions'][] = 'html__overlay';
	}
	
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


function bootstrap_dashboard_preprocess_page(&$variables)
{

	//file_save_data(print_r(array_keys($variables), true), 'public://vars_file');
	//
	//bible: https://www.drupal.org/node/933976
	
	
    $variables['is_authenticated_user'] = in_array("authenticated user",  $GLOBALS['user']->roles) ? 1 : 0;

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

	$request_path = drupal_parse_url(request_path())['path'];
	$args = arg();
	$count = count($args);
	$before_last = $count > 1 ? $args[$count - 2] : "";
	$last = $count > 0 ? $args[$count - 1] : "";
	if (
			$last == 'edit' || 
			(
					$before_last=='add' || $before_last=='edit'
			)&& 					
			(
				($last == 'comment') || ($last == 'household') 
			)
		)
	{ #&& $_GET['overlay'] == 'true'
		$variables['theme_hook_suggestions'][] = 'page__overlay';
	}
}



/**
 * Implements hook_preprocess_HOOK().
 */
function bootstrap_dashboard_preprocess_entity(&$variables, $hook)
{
//	watchdog("bootstrap_dashboard", "preprocess_entity". '_' . $variables['entity_type']);	

	$function = __FUNCTION__ . '_' . $variables['entity_type'];
	if (function_exists ($function)) {
		$function($variables, $hook);
	}
}

if(!function_exists("get_default_image")){
	function get_default_image($bundle)
	{
		$image_filename = "default_image_$bundle.jpg";
		///sites/default/files/styles/thumbnail_square/public/profile_images/default_images/' . $image_filename . '
		$file_uri = file_create_url(file_build_uri("pictures/$image_filename"));
		//$image_styled = theme_image_style(array("style_name"=>"thumb_small", "path" => "public:///sites/default/files/pictures/$image_filename" , "width"=>0, "height" => 0));
		return array(
			"#markup" => '<img src="' . $file_uri . '" width="100" height="100"/>',
//			"#markup" => $image_styled
		);
	}
}

function bootstrap_dashboard_preprocess_entity_crm_core_contact(&$variables, $hook)
{

//	file_save_data(print_r($variables['content']['field_instant_messaging_collecti'], true), 'public://vars_file');
//	watchdog("bootstrap_dashboard", "preprocess_contact:" . print_r($variables, true));	
	foreach (array('field_instant_messaging_collecti', 'field_phone', 'field_address') as $field)
	{
		if (empty($variables['content'][$field]['#items']))
		{
			$variables['content'][$field]['#access'] = 0;
		}
	}
//	print "<pre>" . print_r(array_key($variables), true). "</pre>";	
//  if ($variables['uid'] != 1) {
//    // You can call this variable any way you want, just put it into $variables['element'] and set as TRUE.
//    $variables['element']['hide_admin_field_group'] = TRUE;
//  }
//	drupal_add_region_content('contactheader', array('#type' => 'markup','#markup'=>'*******************************'));
		
	if (!isset($variables['content']['field_image']['#items']))
	{
		$variables['image_field_content'] = get_default_image($variables['crm_core_contact']->type);//array('#markup' => '<img src="' . "XXX" . '"/>');
	}
	else
	{
		$variables['image_field_content'] = $variables['content']['field_image'];
	}
}

//function bootstrap_dashboard_preprocess_region(&$variables) {
//	//print ("<pre>" . print_r($variables, true) . "</pre>");
//	file_save_data(print_r($variables, true), 'public://vars_file_new');
// // Create the $content variable that templates expect.
////  $variables ['content'] = $variables ['elements']['#children'];
////  $variables ['region'] = $variables ['elements']['#region'];
////
////  $variables ['classes_array'][] = drupal_region_class($variables ['region']);
////  $variables ['theme_hook_suggestions'][] = 'region__' . $variables ['region'];
//  
//  
// // $menu_object = menu_get_object();
////  if (isset($menu_object->type) && $vars['region'] == 'content') {
////    $vars['theme_hook_suggestions'][] = 'region__content__'.$menu_object->type;
////    $vars['attributes_array']['class'][] = 'region-content-'.$menu_object->type;
////  }
//}

function bootstrap_dashboard_field_group_build_pre_render_alter(&$element)
{
//  if (isset($element['hide_admin_field_group']) && isset($element['hide_admin_field_group'])) {
//    $element['hide_admin_field_group']['#access'] = FALSE;
//  }
}

function bootstrap_dashboard_preprocess_bef_checkbox(&$variables) 
{	
	if (($key = array_search('form-control', $variables['element']['#attributes']['class'])) !== false) {
		unset($variables['element']['#attributes']['class'][$key]);
	}
}


function bootstrap_dashboard_preprocess_select_as_checkboxes(&$variables) 
{	
	if (($key = array_search('form-control', $variables['element']['#attributes']['class'])) !== false) {
		unset($variables['element']['#attributes']['class'][$key]);
	}
}


function bootstrap_dashboard_preprocess_views_view(&$vars) {

  $name = $vars['name'];
  $display_id = $vars['display_id'];

  //print "view_name $name disp $display_id";
  if ($name=='siblings'){// && $display_id=='DISPLAYYOUWANT') {
    $vars['rows']='<div class="panel panel-default"><div class="panel-heading">Household Members</div><div class="panel-body">' . $vars['rows'] . '</div></div>';
  }
}


function bootstrap_dashboard_label_formatter($element)
{
//unset ($element['field_instance']['bundle']);
//unset ($element['field_instance']['bundle']);

	//return '<pre>display:'. print_r($element['display'], true).' </pre>';
	//return '<pre>field label:'. print_r($element['field_instance'], true).' </pre>^^^' .'<pre>field_inastance:'. print_r(array_keys($element['field_instance']), true).' </pre>^^^' . $element['value'] . '^^^';//<a class="mobile-tel" href="tel:' . $element['element']['number']  . '">Call</a>';

	$field_type = $element['field']['type'];
	$value = render($element['value']);
	$label = render($element['label']); //$element['field_instance']['label'];
	$label_hidden = $element['display']['label'] == 'hidden';
	
	$open = '<div class="label"><span>' . get_element_icon($element, []);
	$close = '</span></div>';
	
	$output = "";
	if($field_type  == 'list_boolean')
	{
		if (!empty($value))
		{
			$output .= $open . $label . $close;
		}
	}
	else
	{
		if (strlen(trim($value)) > 0)
		{
			$output .= $open;
			if (!$label_hidden)
			{
				$output .= $label . ':&nbsp;';
			}
			$output .=  "<span>$value</span>";
			$output .=  $close;
		}else
		{
			$output .= "empty value: ". $open .$label . ':&nbsp;' . $value. $close;
		}
	}

	$link = $element['link'];
	if (isset($link['uri']))
	{
		$options = isset($link['options']) ? $link['options'] : [];
		return l($output, $link['uri'], $options);
	}
	return $output;
}


function build_icon_field($element, $html)
{
		$value_string = $element['value'];
		$label = $element['field_instance']['label'];
		return "<div title=\"$label: $value_string\" class=\"field-display-icon\">$html</div>";
}


function generic_function_dispatcher($function_prefix, $element)
{
	$field_name = $element['field']['field_name'];
	$field_type = $element['field']['type'];

	$function = $function_prefix . '_' . $field_name;
	if (function_exists($function)) {
	  return $function($element);
	}

	$function = $function_prefix . '_' . $field_type;
	if (function_exists($function)) {
	  return $function($element);
	}
	
	$function = $function_prefix . '_default';
	
	return $function($element);

}

function bootstrap_dashboard_icon_formatter_image($element)
{
	// in 'icon' format - don't show the image, just the bundle-related 
//	return	'<div class="label label-primary ">'
//		.		'<div class="round_image">'
//		.			get_element_icon($element, ['badge-icon'])
//		.		'</div>'
//		.	'</div>'
	return 			""
					//.'<div class="label label-primary">'
					.		get_element_icon($element, ['badge-icon', 'icon-container', ])
//					."</div>"
			;
}

function bootstrap_dashboard_icon_formatter_name($element)
{
	// in 'icon' format - don't show the image, just the bundle-related 
//	return	'<div class="label label-primary ">'
//		.		'<div class="round_image">'
//		.			get_element_icon($element, ['badge-icon'])
//		.		'</div>'
//		.	'</div>'
	return 			""
					//.'<div class="label label-primary">'
					.		get_element_icon($element, ['badge-icon', 'icon-container', ])
//					."</div>"
			;
}


function bootstrap_dashboard_icon_formatter($element)
{
	return generic_function_dispatcher(__FUNCTION__, $element);
}

function bootstrap_dashboard_bootstrap_formatter($element)
{
	return generic_function_dispatcher(__FUNCTION__, $element);
}

function bootstrap_dashboard_caption_formatter($element)
{
	return generic_function_dispatcher(__FUNCTION__, $element);
}


function get_element_icon($element, $extra_classes)
{
	$field_type = $element['field']['type'];
	$field_name = $element['field']['field_name'];
	$class_list = [];

	switch ($field_type){
		case "email":
			$class_list = ['fa', 'fa-envelope-o',];
			break;
		case "field_collection":
			switch($field_name){
			case "field_phone":
				$class_list = ['fa', 'fa-phone',];
				break;
			}
			break;
		case "image":
		case "name":
			$class_list = get_element_icon_by_bundle($element);				
			break;
		default:
			return "";
			
	}
	
	return '<i class="' . join(" ", array_merge ($class_list, $extra_classes)) . '">' .  '</i>'; 
}

function get_element_icon_by_bundle($element, $extra_classes = [])
{
	$icon = "";
	
	switch ($element['bundle']){
		case 'ip': $icon = 'man';
			break;
		case 'customer': $icon = 'household';
			break;
		case 'child': $icon = 'child';
			break;
		case 'clinic': $icon = 'clinic';
			break;
		case 'doctor': $icon = 'doctor';
			break;
		case 'egg': $icon = 'egg';
			break;
		case 'egg_donor': $icon = 'eggdonor';
			break;
		case 'embryo': $icon = 'embryo';
			break;
		case 'journey': $icon = 'journey';
			break;
		case 'sperm_specimen': $icon = 'sperm';
			break;
		case 'surrogate': $icon = 'surrogate';
			break;
		case 'tammuz_staff': $icon = 'staff';
			break;
		default:
			$icon = 'clinic';
	}
	return ["icon-$icon", ];
}

function bootstrap_dashboard_caption_formatter_name($element)
{
	$value = $element['value'];
	$ret = "";
	
	if (isset($value['given'])) $ret[] = $value['given'];
	if (isset($value['family'])) $ret[] = $value['family'];
	return get_element_icon($element, [])
	. "<span class=\"caption-format\">" . join(" " , $ret) . "</span>";
	
}

function bootstrap_dashboard_caption_formatter_default($element)
{
	return "";
}

function bootstrap_dashboard_icon_formatter_default($element)
{
	$field_type = $element['field']['type'];
	//return '<pre>display:'. print_r($element['display'], true).' </pre>';
	//return '<pre>field label:'. print_r($element['field_instance'], true).' </pre>^^^' .'<pre>field_inastance:'. print_r(array_keys($element['field_instance']), true).' </pre>^^^' . $element['value'] . '^^^';//<a class="mobile-tel" href="tel:' . $element['element']['number']  . '">Call</a>';
	
	$value = $element['value'];
	if (is_array($value)){$value = print_r($value, true);}
	$label = $element['field_instance']['label'];
	$label_hidden = $element['display']['label'] == 'hidden';
	
	$open = '<div class="label label-primary "><span>';
	$close = '</span></div>';
	
	$output = "";
	if($field_type  == 'list_boolean')
	{
		if (!empty($value))
		{
			$output .= $open . $label . $close;
		}
	}
	else
	{
		if (strlen(trim($value)) > 0)
		{
			$output .= $open;
			if (!$label_hidden)
			{
				$output .= $label . ':&nbsp;';
			}
			$output .=  $value;
			$output .=  $close;
		}else
		{
			$output .= get_element_icon($element, []) .
					"empty value: ". $open .$label . ':&nbsp;' . $value. $close;
		}
	}

	return $output;
}



//
//<div class="chat-body clearfix">
//                                        <div class="header">
//                                            <small class=" text-muted">
//                                                <i class="fa fa-clock-o fa-fw"></i> 13 mins ago</small>
//                                            <strong class="pull-right primary-font">Bhaumik Patel</strong>
//                                        </div>
//                                        <p>
//                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare dolor, quis ullamcorper ligula sodales.
//                                        </p>
//                                    </div>
//		
//		
		
function bootstrap_dashboard_bootstrap_formatter_image($element)
{
	$image_tag = "";
	if (!$element['is_default'])
	{
		$image_tag = '<div class="round_image image-compound"><div class="thumb-tiny-container">'
						.'<img class="" src = "' . image_style_url('thumb_tiny', $element['value']) . '" alt="' . $element['comment'] .'"/>'
//						.get_element_icon($element, ['badge-icon'])
					.'</div></div>';
	}
	else
	{
		$image_tag =
					'<div class="round_image">'
					.	'<div class="thumb-tiny-default-container">'
					.		get_element_icon($element, ['thumb_tiny', ])
					.	"</div>"
					."</div>";
	}
	return $image_tag;
			
}


function bootstrap_dashboard_bootstrap_formatter_default($element)
{

//unset ($element['field_instance']['bundle']);
//unset ($element['field_instance']['bundle']);

	//return '<pre>display:'. print_r($element['display'], true).' </pre>';
	//return '<pre>field label:'. print_r($element['field_instance'], true).' </pre>^^^' .'<pre>field_inastance:'. print_r(array_keys($element['field_instance']), true).' </pre>^^^' . $element['value'] . '^^^';//<a class="mobile-tel" href="tel:' . $element['element']['number']  . '">Call</a>';

	$field_type = $element['field']['type'];
	$value = $element['value'];
	//$label = $element['field_instance']['label'];
	$label = $element['label'];
	$label_hidden = $element['display']['label'] == 'hidden';
	$comment = trim($element['comment']);
	$is_internal = $element['entity_type'] == 'field_collection_item'; // entity type itself is presented as a field, so all the field decoration is already there
	$open = "";//'<div class="list-group-item">';
	$close = "";'</div>';
	
	$output = "";
//	if($field_type  == 'list_boolean')
//	{
//		if (!empty($value))
//		{
//			$output .= $open . $label . $close;
//		}
//	}
//	else
	{
		if (strlen(trim($value)) > 0)
		{
			$output .= $open;
			if(!$is_internal)
			{
	//				$output .= "<span class=\"header\">
	//								<strong class=\"primary-font\">$label</strong>
	//							</span>";
				$output .= "<span>" . ((empty($label) || (strlen(trim($label)) == 0) || $label_hidden) ? "&nbsp;" : $label ) . "</span>";
				$output .= "<div class=\"pull-right\">";
			}
			$output .=  "<strong class=\"primary-font\">$value</strong>";
			if (strlen($comment) > 0){
				$output .= "<span class='text-muted small'> (" . $comment . ")</span>";
			}
			if(!$is_internal)
			{
				//$output .=  "<p>$value</p>";
				$output .= "</div>";
				$output .=  $close;
			}
		}else
		{
			$output .= "empty value: ". $open .$label . ':&nbsp;' . $value. $close;
		}
	}

	return $output;
	
}




//function bootstrap_dashboard_preprocess_field(&$variables, $hook)
//{
//	if(isset($variables['element']['#formatter']) && 
//				(
//					$variables['element']['#formatter'] == 'intoto_label_formatter' ||
//					$variables['element']['#formatter'] == 'intoto_bootstrap_formatter' 
//				)
//			)
//	{
////		print "<pre>".print_r($variables['element']['#formatter'], true )."</pre>";
////		print "<pre>".print_r($variables['label_hidden'], true )."</pre>";
////		$variables['label_hidden_internal'] = $variables['label_hidden'];
////		$variables['label_hidden'] = true;
//	}
//}

//THEMENAME_field__body__article
function KEEP_bootstrap_dashboard_field($variables)
{
	if(isset($variables['element']['#formatter']) && $variables['element']['#formatter'] == 'intoto_crm_field_formatters_label_formatter')
	{
		$open = '<div class="label label-primary "><span>';
		$close = '</span></div>';
		$output = " ";
		if (isset($variables['element']['#field_type']) &&
				$variables['element']['#field_type'] == 'list_boolean')
		{
			if (!empty($variables['items'][0]['#markup']))
			{
				$output .= $open . $variables['label'] . $close;
			}
		}
		else
		{
			if (isset($variables['items'][0]) && strlen(trim($variables['items'][0]['#markup'])) > 0)
			{
				$output .= $open;
				if (!$variables['label_hidden'])
				{
					$output .= $variables['label'] . ':&nbsp;';
				}
				$output .=  $variables['items'][0]['#markup'];
				$output .=  $close;
			}

		}
		return $output;
	}
	else
	{
		$open = '<div class="label label-primary "><span>';
		$close = '</span></div>';
		$output = " ";
		if (isset($variables['element']['#field_type']) &&
				$variables['element']['#field_type'] == 'list_boolean')
		{
			if (!empty($variables['items'][0]['#markup']))
			{
				$output .= $open . $variables['label'] . $close;
			}
		}
		else
		{
			if (isset($variables['items'][0]) && strlen(trim($variables['items'][0]['#markup'])) > 0)
			{
				$output .= $open;
				if (!$variables['label_hidden'])
				{
					$output .= $variables['label'] . ':&nbsp;';
				}
				$output .=  $variables['items'][0]['#markup'];
				$output .=  $close;
			}

		}
		return $output;	}
}


function bootstrap_dashboard_field_multiple_value_form($variables) {
 return theme_field_multiple_value_form($variables); //#todo: override this function (instead of calling it) in order:
	//A remove the 'show weights'
	//B rename button to "add phone" "add child" etc.	
}


//function bootstrap_dashboard_date_popup($vars) {
//  $element = $vars['element'];
//  $attributes = !empty($element['#wrapper_attributes']) ? $element['#wrapper_attributes'] : array('class' => array());
//  $attributes['class'][] = 'container-inline-date';
//  // If there is no description, the floating date elements need some extra padding below them.
//  $wrapper_attributes = array('class' => array('date-padding'));
//  if (empty($element['date']['#description'])) {
//    $wrapper_attributes['class'][] = 'clearfix';
//  }
//  // Add an wrapper to mimic the way a single value field works, for ease in using #states.
//  if (isset($element['#children'])) {
//    $element['#children'] = '<div id="' . $element['#id'] . '" ' . drupal_attributes($wrapper_attributes) .'>' . $element['#children'] . '</div>';
//  }
//  return '<div ' . drupal_attributes($attributes) .'>' . theme('form_element', $element) . '</div>';
//}


function fieldset_into_form_element($variables) //based on http://drupal.stackexchange.com/questions/52255/remove-fieldset-from-date-field
{
    $element = $variables['element'];
//    $field = field_info_field($element['#field_name']);
//    $instance = field_info_instance($element['#entity_type'], $element['#field_name'], $element['#bundle']);

    // Group start/end items together in fieldset.
    $fieldset = array(
            '#title' => t($element['#title']) . ' ' . (isset($element['#delta'])  && $element['#delta'] > 0 ? intval($element['#delta'] + 1) : ''),
            '#value' => '',
            '#description' => !empty($element['#fieldset_description']) ? $element['#fieldset_description'] : '',
            '#attributes' => array(),
            '#children' => $element['#children'],
    );

    // Fix required marker.
    if ($element['#required']) {
        $fieldset['#title'] .= " " . theme('form_required_marker');
    }
    return theme('form_element', array('element' => $fieldset));
}

function bootstrap_dashboard_date_combo($variables)
{
	return fieldset_into_form_element($variables);
}

function bootstrap_dashboard_fieldset($variables)
{
	return fieldset_into_form_element($variables);
}
