jQuery(document).ready(function($) {
	
	// For style guide use. Remove this when in production
	if ( $('.tblStyleGuide').length>0 ) {
		$('.tblStyleGuide tbody tr').each(function(index, element) {
			$(this).children('td').eq(1).html( '<pre>'+htmlEntities($(this).children('td').eq(0).html())+'</pre>' );
		});
	}
	function htmlEntities(str) {
		return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
	}
	// end of style guide
	
	
	// Leaderboard tabs
	$('.nav-tabs a').click(function (e) {
		e.preventDefault();
		$(this).tab('show');
	});
	
	
	//event to pause video play on side
    $('.carousel').on("slide.bs.carousel", function (event) {
        var $currentSlide = $(this).find(".active iframe");
        
        var idx = $currentSlide.parent().index();
        if($currentSlide.parent().attr('id') == null || $currentSlide.parent().attr('id') == ""){            
            $currentSlide.parent().attr('id',('bsCarousel-'+idx));
        }
        
        // exit if there's no iframe, i.e. if this is just an image and not a video player
        if (!$currentSlide.length) { return; }
        
        // pass that iframe into Froogaloop, and call api("pause") on it.
        var player = Froogaloop($currentSlide[0]);
        player.api("pause");
        
        callYoutube($currentSlide,'pauseVideo');
    });
	
	
	// Regional Events tab
	$activeDetail = $('.details.active').attr('id').split('-');
	$('#completed-'+$activeDetail[2]).show();
	$('#event-summary .tab').click(function(){
	
		var num = $(this).text();
		
		// set active tab
		$('.tab').removeClass('active');
		$(this).addClass('active');
		
		// set date display
		$('.tab-display').hide();
		$('#event-tab-'+num).removeClass('hide').show();
		
		// content display
		$('.details').removeClass('active').hide();
		$('.completed').hide();
		$('#event-details-'+num).removeClass('hide').addClass('active').show();
		$('#completed-'+num).removeClass('hide').show();
		
		// set background
		var bg = $('#event-details-'+num).data('bg');
		if (bg!=undefined) {
			$('#event-summary .info').css('background', 'url(' +bg +')');
		} else {
			$('#event-summary .info').css('background', '#f5f5f5');
		}
		
		// set title and subnav 
		$('.subpagenav').hide().removeClass('active');
		$('.subpagenav-'+num).removeClass('hide').show();
		$('.subpagenav-'+num+':first a').addClass('active');
		$('#event-pages .tab-title').text('OVERVIEW');
		
		// show active subpage
		var subpage_id = $('.subpagenav-'+num+' a.active').data('page');
		$('.subpage').hide();
		$('#subpage-'+subpage_id).removeClass('hide').show();
		
	});
	
	$('.subpagenav a').click(function(){
		
		if ( !$(this).hasClass('external') ) {
		
			// set active nav
			$('.subpagenav a').removeClass('active');
			$(this).addClass('active');
			
			// show page
			var subpage_id = $(this).data('page');
			$('.subpage').hide();
			$('#subpage-'+subpage_id).removeClass('hide').show();
			
			// set title
			$('#event-pages .tab-title').text($(this).text());
		}
	});
	
	// set initial display
	var reg_event_bg = $('.details.active').data('bg');
	if (reg_event_bg!=undefined) {
		$('#event-summary .info').css('background', 'url(' +reg_event_bg +')');
	} else {
		$('#event-summary .info').css('background', '#f5f5f5s');
	}
	
	// show subpages nav
	var reg_event_active_tab = $('.tab.active').text();
	$('.subpagenav-'+reg_event_active_tab).removeClass('hide');
	
	
	// Latest News
	$('#latest-news-popup').css('left', $('header .container').offset().left + 15);
	if ( $('#latest-news-popup').css('display')=='block' ) {
		$(window).resize(function(){
			$('#latest-news-popup').css('left', $('header .container').offset().left + 15);
		});
	}
	
	if ( $('#wpadminbar').length>0 ) {
		$('#latest-news-popup').css('top','92px');
	}
	
	$('#latest-news-popup .news-close').click(function(){
		$('#latest-news-popup').slideUp(300);
	});
	
	
	// Regional Events direct link
	if ( $('#regional-events-page').length>0 ) {
		var tab = window.location.hash;
		tab = tab.replace('#', '');
		tab = tab.replace(/\//g, '');
		
		if ( tab!='' ) {
			$("a[data-tab='"+tab+"']").trigger('click');
		}
	}
});