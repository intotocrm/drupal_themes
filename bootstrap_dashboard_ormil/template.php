<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */






function bootstrap_dashboard_icon_formatter_field_status($element)
{
	if (isset($element['element']['value']))
	{
		$competitor = "<i class=\"fa fa-exclamation\"></i>";
		$value = $element['element']['value'];
		
		$ret = "";
		switch ($value){
			case 'potential' : $ret = "<i class=\"fa fa-question-circle\"></i>";
				break;
			case 'past_patient' : $ret = "<i class=\"fa fa-heart-o\"></i>";
				break;
			case 'patient' : $ret = "<i class=\"fa fa-rocket\"></i>";
				break;
			case 'competitor' : $ret = "<i class=\"fa fa-exclamation-circle\"></i>";
				break;
			default:
			return bootstrap_dashboard_icon_formatter_default($element);
		}
		return build_icon_field($element, $ret);
	}
	return bootstrap_dashboard_icon_formatter_default($element);
}

function bootstrap_dashboard_icon_formatter_field_sales_category($element)
{
	if (isset($element['element']['value']))
	{
		$fire = "<i class=\"fa fa-fire\"></i>";
		$cold_fire = "<i class=\"outline-text fa fa-fire \"></i>";
		$flash = "<i class=\"fa fa-bolt\"></i>";
		$value = $element['element']['value'];
		
		$ret = "";
		switch ($value){
			case 'cold' : $ret = $cold_fire;
				break;
			case 'warm' : $ret = str_repeat($fire, 1);
				break;
			case 'moderate' : $ret = str_repeat($fire, 2);
				break;
			case 'hot' : $ret = str_repeat($fire, 3);
				break;
			case 'new' : $ret = $flash;
				break;
			default:
			return bootstrap_dashboard_icon_formatter_default($element);
		}
		return build_icon_field($element, $ret);
	}
	return bootstrap_dashboard_icon_formatter_default($element);
}
