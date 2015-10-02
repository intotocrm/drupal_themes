<?php

/**
 * @file
 * Display Suite 1 column template.
 */
	$vars = get_defined_vars ();
	$content = isset($vars['content'])? $vars['content'] : array("title"=>'missing information');
	if(!function_exists("safe_var_export")){
		function safe_var_export($var_name, $variables)
		{
			return isset($variables[$var_name]) ? $variables[$var_name] : NULL;  
		}
	}
	
	if(!function_exists("print_label_if_exists")){
		function print_label_if_exists($field_name, $content)
		{
			$field_content = safe_var_export($field_name, $content);
			if (isset($field_content))
			{
				print render($field_content); 
			}
		}
	}
	$entity_info = $crm_core_contact->entityInfo();
	$image = safe_var_export('field_image', $content);
	//$image_field_content;
	$name = safe_var_export('contact_name', $content);
	$contact_id = isset($crm_core_contact->contact_id) ? $crm_core_contact->contact_id : NULL;
	$contact_type_label = isset($crm_core_contact->type) ?
			isset($entity_info['bundles'][$crm_core_contact->type]['label']) ? $entity_info['bundles'][$crm_core_contact->type]['label'] : "NULL"
			: NULL;

	$title = $name ? render($name) : $contact_type_label;
	$contact_url = "/crm-core/contact/$contact_id";
?>
<<?php print $ds_content_wrapper; print $layout_attributes; ?> class="ds-1col <?php print $classes;?> clearfix">

	<?php if (isset($title_suffix['contextual_links'])): ?>
	<?php print render($title_suffix['contextual_links']); ?>
	<?php endif; ?>

	<div class="panel panel-default">
		<div class="panel-heading">
			<div class='profile_data_container'>
				<div class="frame">							
					<div class="crop">
						<?php //print render($image_field_content); 
						print render($variables['elements']['field_image'])?>
					</div>								
				</div>								
			</div>
			<div class='profile_data_container'>
				<a href="<?php print $contact_url;?>">
					<h4>*
					<?php //print $title; 
								print render($variables['elements']['contact_name']);
							?>
^					</h4>
				</a>
				<small><?php print $contact_type_label ; ?></small>
			</div>
			<div class='profile_data_container profile_data_fields'>
				<?php print_label_if_exists('field_customer_type', $content);?>
				<?php print_label_if_exists('field_program', $content);?>
				<?php print_label_if_exists('field_bedford', $content);?>
				<?php print_label_if_exists('field_mhb', $content);?>
				<?php 
					foreach($disconnect_links as $link){
						print l($link['text'], $link['path']);
					}
				?>

			</div>

			<div class="clearfix"></div>
		</div>				
	</div>



	<?php //print $ds_content; ?>
</<?php print $ds_content_wrapper ?>>

<?php if (!empty($drupal_render_children)): ?>
	<?php print $drupal_render_children ?>
<?php endif; ?>