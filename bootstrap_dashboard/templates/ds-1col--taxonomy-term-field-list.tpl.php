<?php

/**
 * @file
 * Display Suite 1 column template.
 */
	foreach ($variables['elements'] as $field_key=>$field_renderable)
	{
		if ($field_key[0] != "#" && !isset($field_renderable['#printed']))
		{
			print drupal_render($field_renderable);
		}
	}
?>
