<?php

/**
 * @file
 * Display Suite 1 column template.
 */
	$type_rendered = "";
	$type_field_name = NULL;
	if (isset($variables['elements']['field_address_type'])){
		$type_field_name = 'field_address_type';
	}
	elseif (isset($variables['elements']['field_type']))
	{
		$type_field_name = 'field_type';
	}
	if ($type_field_name)
	{
		$variables['elements'][$type_field_name]['#internal'] = true;
		$type_rendered = render($variables['elements'][$type_field_name]);  //render in advance so it is marked "#printed" 
		print $type_rendered;
	}

	foreach ($variables['elements'] as $field_key=>$field_renderable)
	{
		if ($field_key[0] != "#" && !isset($field_renderable['#printed']))
		{
			$field_renderable['#internal'] = true;
			print drupal_render($field_renderable);
		}
	}
?>
