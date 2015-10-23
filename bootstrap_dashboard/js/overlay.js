// JavaScript Document

jQuery(document).ready(function () {

	// set overlay-wrap to be hidden from view
	jQuery('#overlay-wrap').css('height', '0px');

	// find all overlay links and add overlay functionality
	jQuery('a.overlay').each( function() {
//	jQuery('input.overlay:button').each( function() {
		jQuery(this).click( function() {
//		alert("AA");
		  var href=jQuery(this).attr('href');	  // page url to load
		  var name=jQuery(this).attr('name');	  // new page name
		  var rel =jQuery(this).attr('rel');	   // new page group
		  
		  updateHash(name);
		  loadPage(href);
		  updateActive(href, rel);
		  return false; // important to keep the page from loading in a new window
		});
	});

	// If hashtag exists, load the appropriate page and slide on page load.
	if(hash = parseHash()) {
		if(hash['page']) {
		  var href = jQuery('a[name="'+hash['page']+'"]').attr('href');
		  var rel = jQuery('a[name="'+hash['page']+'"]').attr('rel');
		  var slide = hash['slide'];
		  loadPage(href, rel, slide);
		  updateActive(href, rel);
		}
	}

});

/* UTILITY FUNCTIONS FOR OVERLAY MANAGEMENT */

// function to update which link is active for styling purposes
function updateActive(href, rel) {
	// remove active from all links
	jQuery('a.active').removeClass('active');
	// add active to all links with same destination
	jQuery('a[href= "'+href+'"]').addClass('active');
	// add active to main level link regardless of destination
	jQuery('#main-menu a[name="'+rel+'"]').addClass('active');
}

// function to update the Hash after the content has changed
function updateHash(page, slide) {
	var list = 'page='+page;					 // add page hash
	if (slide) list += '&amp;slide='+slide;		  // add slide hash if exists
	window.location.hash = list;				 // update hash
}

// function to load the content via ajax and animate the overlay
function loadPage(href, rel, slide) {
	// fade out current content
	jQuery('#overlay').stop(true,true).fadeTo('fast', 0, function() {
		// determine if overlay is already open, if not animate it immediately
		if (!jQuery('#overlay-wrap').height()) {
		  jQuery('#overlay-wrap').stop(true,true).animate({ height: 200 }, 'slow');
		}
/** 
*   NOTE: the additional '?overlay=true' is added to trigger the new 
*   templates in the template.php file
**/
		jQuery('#overlay').load( href+'?overlay=true', function () {
		  if (slide) jQuery('#'+slide).click();  // cycle to correct slide
		  // animate the height to fit the new content (within callback after load)
		  jQuery('#overlay-wrap').stop(true,true).animate({ 
			height: jQuery('#overlay').height()+10 
		  }, 'fast', function() { 
			jQuery('#overlay').stop(true,true).fadeTo('fast', 1.0); // fade in
		  });
		});
	});
}

// function to extract data from the existing hash
function parseHash() {
	hash = window.location.hash.substring(1);   // load hash string
	if (!hash) return false;					// return false if no hash
	var varlist= hash.split("&amp;");			   // break hash into variables
	for (i=0; i &lt; varlist.length; i++) {		// cycle through variables
		var vars = varlist[i].split("=");		 // split variable name from value
		varlist[vars[0]] = vars[1];			   // assign variable value to array
												  // indexed by variable name
	}
	return varlist;							 // return variable array
}

// function to close the overlay
function closePage() {
	jQuery('#overlay').stop(true,true).fadeTo('fast', 0, function() {
		jQuery('#overlay-wrap').stop(true,true).animate({
		  height: 0
		}, 'fast', function() {
		  jQuery('#overlay').html('');
		  jQuery('a.active').removeClass('active');
		  window.location.hash = '';
		});
	});
}