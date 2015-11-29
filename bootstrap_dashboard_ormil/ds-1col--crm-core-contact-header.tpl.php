<?php

/**
 * @file
 * Display Suite 1 column template.
 */

$btn_class = $can_edit ? "btn btn-xs btn-primary" : "btn btn-xs btn-primary disabled";
//$btn_class = "btn btn-xs btn-primary" ;//: "btn btn-xs btn-primary disabled";
$contact = isset($vars['crm_core_contact']) ? $vars['crm_core_contact'] : NULL;
$base_url = "/crm-core/contact/$contact_id";

?>
<<?php print $ds_content_wrapper; print $layout_attributes; ?> class="ds-1col <?php print $classes;?> clearfix">

	<?php if (isset($title_suffix['contextual_links'])): ?>
	<?php print render($title_suffix['contextual_links']); ?>
	<?php endif; ?>
	<?php
		$image_rendered = render($variables['elements']['field_image']);  //render in advance so it is marked "#printed" 
//		$caption_rendered = render($variables['elements']['field_caption']);
		$caption_rendered = render($variables['elements']['contact_name']);
	?>

	<div class="panel panel-primary">
		<div class="panel-heading">
			<div class='profile_data_container'>
					<div class="clearfix"></div>
				<?php foreach ($variables['elements'] as $field_key=>$field_renderable)
				{
					if ($field_key[0] != "#" && !isset($field_renderable['#printed'])){
						print render($field_renderable);
						}
					}
				?>
			</div>
			<a href="<?php print "/crm-core/contact/$contact_id";?>">
			<!--<i class="fa fa-comments fa-5x"></i>-->
				<?php print $caption_rendered; ?>
				<?php print $image_rendered;   ?>
				<small><?php print $contact_type_label ; ?></small>
			</a>
			<div class="clearfix"></div>
		</div>
		<div class="panel-footer">
			<!--
			<span class="pull-left">View Details</span>
			<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
			-->
				<a href="<?php print link_check_access("$base_url/edit"); ;?>">
					<button type="button" class="<?php print $btn_class;?> ">Edit</button>
				</a>
				<?php if ($contact_type <> 'ip'){ ?>
					<a href="<?php print link_check_access("$base_url/activity/add/comment?destination=$base_url");?>">
						<button type="button" class="<?php print $btn_class;?>">Comment</button>
					</a>

					<a href="<?php print link_check_access("$base_url/activity/add/email?destination=$base_url");?>">
						<button type="button" class="<?php print $btn_class;?>">Email</button>
					</a>
					<a href="<?php print link_check_access("$base_url/activity/add/phone_call?destination=$base_url");?>">
						<button type="button" class="<?php print $btn_class;?>">Phone</button>
					</a>
				<?php } ?>
			<div class="clearfix"></div>
		</div>		
	</div>



	<?php //print $ds_content; ?>
</<?php print $ds_content_wrapper ?>>

<?php if (!empty($drupal_render_children)): ?>
	<?php print $drupal_render_children ?>
<?php endif; ?>
