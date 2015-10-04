/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


//$(function(){
//
////	if ( (/iPhone|iPod|iPad|Android|BlackBerry/).test(navigator.userAgent) !== true )
////	{
//		$(".callto").attr("href", "#");
////	}
//});

//$(document).ready(function(){
//alert("AAAA");
//	$(".callto").attr("href", "#");
//});

(function($) {
    Drupal.behaviors.phone_link_behvior = {
      attach: function (context, settings) {
			if ( (/iPhone|iPod|iPad|Android|BlackBerry/).test(navigator.userAgent) !== true )
			{
				$(".callto").removeAttr("href");
				$(".callto").addClass("nolink");
			}
      }
  };
})(jQuery);
