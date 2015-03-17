jQuery(document).ready(function($){
	
	// fix nav height
	if ( $(".main-nav .dropdown li.active").length>0 || $(".main-nav .active .open").length>0 ) {
		$("header").addClass('with-secondary-nav');
	}
	if ( $(".main-nav .dropdown li.active .dropdown li").length>0 ) {
		$("header").addClass('with-tertiary-nav');
	}
	
	
	// upcoming events	
	if ( typeof $calendar_events!= 'undefined') {
		$(".tco-calendar").kalendar({ 
			events: $calendar_events,
			color: "green",
			firstDayOfWeek: "Sunday",
			eventcolors: {
				yellow: {
					background: "#FC0",
					text: "#000",
					link: "#000"
				},
				green: {
					background: "#1C8F4C",
					text: "#FFF",
					link: "#FFF"
				}
			},
			tracking: false
		});
	}		
	
	
	// tco init events
	/* arena launch */
	$('.navbar-nav .arena').on('click',function(){
		window.open('http://community.topcoder.com/tc?module=Static&d1=applet&d2=detect', 'Launch', 'top=2,left=2,width=400,height=400,resizable=yes,status=1'); 
		return false;
	});


  /* carousel touch support */
  $(".carousel").swipe({
      //Generic swipe handler for all directions
      swipeLeft:function(event, direction, distance, duration, fingerCount) {
          $(this).carousel('next');
      },
      swipeRight: function(event, direction, distance, duration, fingerCount) {
          $(this).carousel('prev');
      },
      //Default is 75px, set to 0 for demo so any distance triggers swipe
      threshold:0
  }) 

    
  if($('.lvl4Menu a.active:visible').length>1){
	  $('.lvl4Menu a.active:visible:first').removeClass('active');
  }
 
   
  if($('.navbar-nav .dropdown.open a.active').length>1){
		$('.navbar-nav .dropdown.open a.active:eq(0)').removeClass('active');
  }
  
   $('.nav-tabs a').click(function (e) {
      e.preventDefault();
      $(this).tab('show');
    }) 


	callYoutube = function(frame_id, func, args) {
		var iframe = frame_id[0];
		var fid = frame_id.parent().attr('id');
		if (iframe) {
			// Frame exists, 
			iframe.contentWindow.postMessage(JSON.stringify({
				"event": "command",
				"func": func,
				"args": args || [],
				"id": fid
			}), "*");
		}
	}
    
	
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
	

	// get user ID
	function getUID() {
		var name = 'tcsso=';
		var ca = document.cookie.split(';');		
		for (var i = 0; i < ca.length; i++) {
			var c = $.trim(ca[i]);
			if (c.indexOf(name) == 0) {				
				var uid = c.substring(name.length, c.length).split("|");
				return uid[0];
			}
		}
		return "";
	}	
		

	// if Member Form page
	if ( $(".member-data").length>0 ) {
		var uid = getUID();
		var handle = '';
		if (uid>0) {		
			$.getJSON("http://community.topcoder.com/tc?module=BasicData&c=get_handle_by_id&dsid=30&uid=" + uid + "&json=true", 
				function(data) {
					handle = data['data'][0]['handle'];	
					$("#member_handle").val(handle);
					$("#member_handle_label").html(handle);
					$("#form_member").show();
					
					var current_url = window.location.href + '?h='+handle;
										
					$.getJSON(current_url, 
						function(obj){
							
							$("#member_name").val(obj.name);
							$("#member_email").val(obj.email);								
							$("#member_country").val(obj.country);
							
							$.each(obj.track, function(i){
								$(".track[value='"+obj.track[i]+"']").attr('checked', true);								
							});
							
							if (obj.attendance=='on') $("#confirm_attendance").attr('checked', true);
							if (obj.arrival=='on') $("#confirm_arrival").attr('checked', true);
							if (obj.documents=='on') $("#confirm_documents").attr('checked', true);							

							if ( obj.id_card!=undefined ) {								
								$("#member_identification_card").removeAttr('required');
								$("#member_identification_card_placeholder").html('<img src="'+obj.id_card+'" class="img-responsive" />');								
							}
							
							if ( obj.photo!=undefined ) {								
								$("#member_photo").removeAttr('required');
								$("#member_photo_placeholder").html('<img src="'+obj.photo+'" class="img-responsive" />');								
							}
							
							$("input:radio[name='legal_age'][value='"+obj.legal_age+"']").attr('checked', true);
							
							$("#member_description").html(obj.description);
							$("#member_history").html(obj.history);							
						}
					);
				}
			);
		} else {
			$(".registerBtn").trigger('click');
		}
	}	
	
	// if Staff Form page
	if ( $(".staff-data").length>0 ) {
		var uid = getUID();
		var handle = '';
		if (uid>0) {		
			$.getJSON("http://community.topcoder.com/tc?module=BasicData&c=get_handle_by_id&dsid=30&uid=" + uid + "&json=true", 
				function(data) {
					handle = data['data'][0]['handle'];	
					$("#staff_handle").val(handle);
					$("#staff_handle_label").html(handle);					
					$("#form_staff").show();
					
					var current_url = window.location.href + '?h='+handle;
										
					$.getJSON(current_url, 
						function(obj){
							
							$("#staff_name").val(obj.name);
							$("#staff_email").val(obj.email);
							
							if ( obj.photo!=undefined ) {								
								$("#staff_photo").removeAttr('required');
								$("#staff_photo_placeholder").html('<img src="'+obj.photo+'" class="img-responsive" />');								
							}
							
							$("#staff_talent").html(obj.talent);
						}
					);
				}
			);
		} else {
			$(".registerBtn").trigger('click');
		}
	}		
	
	
	// if Travel Form page
	if ( $("#travel_form").length>0 ) {
		var uid = getUID();
		var handle = '';
		if (uid>0) {		
			$.getJSON("http://community.topcoder.com/tc?module=BasicData&c=get_handle_by_id&dsid=30&uid=" + uid + "&json=true", 
				function(data) {
					handle = data['data'][0]['handle'];	
					$("#member_handle").val(handle);
					$("#member_handle_label").html(handle);					
					$("#travel_form").show();
					
					var current_url = window.location.href + '?h='+handle;
										
					$.getJSON(current_url, 
						function(obj){							
							$("#travel_first_name").val(obj.first_name);
							$("#travel_middle_name").val(obj.middle_name);
							$("#travel_surname").val(obj.surname);
							$("#travel_street").val(obj.street);
							$("#travel_city").val(obj.city);
							$("#travel_state").val(obj.state);
							$("#travel_postal").val(obj.postal);
							$("#travel_country").val(obj.country);
							$("#travel_mobile_phone").val(obj.mobile_phone);
							$("#travel_emergency_name").val(obj.emergency_name);
							$("#travel_phone_or_email").val(obj.phone_or_email);
							$("#member_email").val(obj.email);
							$("#travel_relationship").val(obj.relationship);
							
							$("input:radio[name='gender'][value='"+obj.gender+"']").attr('checked', true);
							
							$("#travel_dob").val(obj.dob);
							$("#travel_passport").val(obj.passport);
							$("#travel_passport_expiration").val(obj.passport_expiration);
							$("#travel_passport_country").val(obj.passport_country);
							$("#travel_food_allergies").val(obj.food_allergies);
							$("#travel_meal_consideration").val(obj.meal_consideration);
							$("#travel_special_assistance").val(obj.special_assistance);
							$("#travel_handle_phonetic_spelling").val(obj.handle_phonetic_spelling);
							$("#travel_name_phonetic_spelling").val(obj.name_phonetic_spelling);
							$("#travel_departure_airport").val(obj.departure_airport);
							$("#travel_departure_home").val(obj.departure_home);
							$("#travel_departure_location").val(obj.departure_location);
							$("#travel_airplane_seating").val(obj.airplane_seating);
							$("#travel_special_request").html(obj.special_request);														
						}
					);
				}
			);
		} else {
			$(".registerBtn").trigger('click');
		}
	}		
	
	
	// if VISA Form page
	if ( $("#form_visa").length>0 ) {
		var uid = getUID();
		var handle = '';
		if (uid>0) {		
			$.getJSON("http://community.topcoder.com/tc?module=BasicData&c=get_handle_by_id&dsid=30&uid=" + uid + "&json=true", 
				function(data) {
					handle = data['data'][0]['handle'];	
					$("#member_handle").val(handle);
					$("#member_handle_label").html(handle);					
					$("#form_visa").show();
					
					var current_url = window.location.href + '?h='+handle;
										
					$.getJSON(current_url, 
						function(obj){							
							$("#member_name").val(obj.name);
							$("#member_phone_number").val(obj.phone);
							$("#member_email").val(obj.email);
							
							$("#passport_address1").val(obj.passport_address1);
							$("#passport_address2").val(obj.passport_address2);
							$("#passport_address3").val(obj.passport_address2);
							$("#passport_city").val(obj.passport_city);
							$("#passport_state").val(obj.passport_state);
							$("#passport_postal").val(obj.passport_postal);
							$("#passport_province").val(obj.passport_province);
							$("#passport_country").val(obj.passport_country);
							
							$("#shipping_address1").val(obj.shipping_address1);
							$("#shipping_address2").val(obj.shipping_address2);
							$("#shipping_address3").val(obj.shipping_address3);
							$("#shipping_city").val(obj.shipping_city);
							$("#shipping_state").val(obj.shipping_state);
							$("#shipping_postal").val(obj.shipping_postal);
							$("#shipping_province").val(obj.shipping_province);
							$("#shipping_country").val(obj.shipping_country);
						}
					);
				}
			);
		} else {
			$(".registerBtn").trigger('click');
		}
	}	
	$("#btnSameAddress").click(function(){
		$("#shipping_address1").val( $("#passport_address1").val() );
		$("#shipping_address2").val( $("#passport_address2").val() );
		$("#shipping_address3").val( $("#passport_address3").val() );
		$("#shipping_city").val( $("#passport_city").val() );
		$("#shipping_state").val( $("#passport_state").val() );
		$("#shipping_postal").val( $("#passport_postal").val() );
		$("#shipping_province").val( $("#passport_province").val() );
		$("#shipping_country").val( $("#passport_country").val() );
		return false;
	});
	$(".viewVisaRequestDetails").toggle(
		function(){
			var id = $(this).attr('href');
			var span = $(this).find('span');
			$(id).removeClass('hide');
			span.removeClass('glyphicon-chevron-right').addClass('glyphicon-chevron-down');
		},
		function(){
			var id = $(this).attr('href');
			var span = $(this).find('span');
			$(id).addClass('hide');
			span.removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-right');
		}
	);
	$(".visaCheckAll").change(function(){
		if ( $(this).attr('checked') ) {
			$(".visaCheck").attr('checked', true);	
		} else {
			$(".visaCheck").attr('checked', false);
		}
	});
	$(".visaFilterStatus").change(function(){
		var tr = $(this).val();
		if ( $(this).attr('checked') ) {
			$(".tr"+tr).show();	
		} else {
			$(".tr"+tr).hide();
		}
	});
	
	function redirectMember() {
		if ( $(".member-data").length>0 || $(".staff-data").length>0 || $("#travel_form").length>0 || $("#form_visa").length>0 ) {
			location.reload();
		} 
	}
	
	
	// format title
	formatTitle = function(elTitle){
			var h = elTitle.text();
			h = h.split(' ');
			var len = h.length;
			var str = '';
			var hlen = Math.ceil(len/2)
			for(var x =0;x < hlen;x++){
				str += h[x] + ' ';
			}
			str += '<em>';
			for(var x=hlen ;x<len;x++){
				str += h[x]+' ';
			}
			str += '</em>';
			elTitle.html(str);
	}	
	
	$('pTitleBar dt, .pTitleBar h1').each(function(){
		formatTitle($(this));
	});	
	
	/* twitter carousel */
	if($('.Twitter_widget').length>0){
		$('.Twitter_widget ul').bxSlider({
			pager:true,
			infiniteLoop: false
		});
	}
	if($('.forum_widget').length>0){
		$('.forum_widget ol').bxSlider({
			pager:true,
			infiniteLoop: false//,
			//mode: 'fade'
		});
	}
	
	/* renderTable */
	if ($('.userTable').length > 0) {
		window.gDataType = $('.userTable').attr('id');
		listUser(window.gDataType, userId);
	}
	
	if ($('.dataTable').length > 0 && $('.userTable').length <= 0) {
		var sortField = '';
		window.leadData = new ListData(0, 30, 0);
		window.gDataType = $('.dataTable').attr('id');
		if ($('.periodBtn').length > 0) {
			$('.periodBtn').each(function() {
				var idx = $(this).attr('rel');
				if (idx != 'all') {
					listLeadboard(window.gDataType, idx, '');
				}
				$(this).click(function() {
					var p = $(this).parent();
					if (p.hasClass('current')) {
						return;
					}
					var id = $(this).attr('rel');
					window.leadData.setCurrentId(id);
					$('.topTh .current').removeClass('current');
					p.addClass('current');
					$('.goBtn').trigger('click');
				});
			});
		} else {
			listLeadboard(window.gDataType, '123', '');
		}
		
		$('.searchBtn').click(function() {
			window.leadData.search($(".search").val());
		});
		$('.search').keyup(function(e){
			var key = e.keycode || e.which;
			if(key == 13){
				window.leadData.search($(".search").val());
			}
		})
		$(".goBtn").click(function() {
			$('.search').val('');
			window.leadData.startIndex = TryParse($(".startIndex").val(),0);
			window.leadData.record = TryParse($(".viewAmount").val(),30);
			window.leadData.page = 0;
			window.leadData.render();
		});
		$('.dataTable').on('click','.num', function() {
			// Fetch the page information.
			var num = TryParse($(this).text(), 0);
			if (num > 0) {
				var text = TryParse($(this).text(), 1) - 1;
				window.leadData.page = text;
				window.leadData.render();
			}
		});
		$(".next").click(function(){
			if ($(this).hasClass('disabled')) {
				return;
			}
			window.leadData.page++;
			window.leadData.render();
		});
		$(".prev").click(function(){
			if ($(this).hasClass('disabled')) {
				return;
			}
			window.leadData.page--;
			window.leadData.render();
		});
		$('.startIndex').change(function() {
			var value = $(this).val();
			$('.startIndex').each(function() {
				$(this).val(value);
			});
		});
		$('.viewAmount').change(function() {
			var value = $(this).val();
			$('.viewAmount').each(function() {
				$(this).val(value);
			});
		});
	}
	
	
	// Modal Init
	var Modal = {
	
		// Save the modal trigger
		modalTrigger : null,
	
		// Load modal with dialog
		loadDirectModal : function(trigger,dialog,fixed){
	
			this.modalTrigger = trigger;
			var iWidth = $(document).width();
			var iHeight = $(document).height();
			var iHeight1 = $(window).height();
			var iWidth1 = $(window).width();
			$('#modalBg').css({
				'height':iHeight + "px",
				'opacity':'0.4'
			 }).show();
			if(iWidth > iWidth1){
				 $('#modalBg').css({
					"min-width":iWidth + "px"
				 })
			}
			dialog.show();
			var top = (iHeight1 - dialog.height())/2;
			if(top<45){
				top = 45;
			}
			if(fixed){
				 $("#modalContent").css({
					"position":"fixed",
					 "top": top + "px"
				 });
			}else{
			  var scrollTop = $(document).scrollTop();
				$("#modalContent").css({
					"position":"absolute",
					 "top": scrollTop + top + "px"
				});
			}
		},
	
		// Load the modal with trigger rel attribute
		loadModal : function(trigger,fixed){
			var dialog = $(trigger.attr("rel"));
			this.loadDirectModal(trigger, dialog, fixed);
		},
	
		// Close the modal
		closeModal : function(trigger){
			trigger.parents(".modalBox").hide();
			$('#modalBg').hide();
		},
	
		// Initialize the modal related function
		init :function($){
			var _this = this;
			
			$(".modal-dialog .closeModal, .modalBox .cancel").click(function(event){
				if ($(this).hasClass('closeAndClean')) {
					$('.registerBtn').removeClass('visible').hide();
				}
				$('#registerModal').modal('hide');
			});
			$('.modalBox .closeAndClean').click(function(event){
				$('.registerBtn').removeClass('visible').hide();
				$('#registerModal').modal('hide');
			});
	
			$("#modalContent").on("click", ".closeModal", function(event){
				_this.closeModal($(this));
				return false;
			});
	
			$("#modalContent").on("click", ".modalBtn", function(event){
				_this.closeModal($(this));
				_this.loadModal($(this));
				return false;
			});
	
			$("#modalContent").on("click", ".modalFixedBtn", function(event){
				_this.closeModal($(this));
				_this.loadModal($(this),true);
				 return false;
			});
	
			$("body").on("click", ".modalTrigger", function(event){
				_this.loadModal($(this));
				 return false;
			});
	
			$("body").on("click", ".modalFixedTrigger", function(event){
				_this.loadModal($(this),true);
				 return false;
			});
						
			$('.mainRail .rules').each(function() {
				$(this).find('h3:first').addClass('first');
			});
			
			$('#submitForm').click(function() {
				$('#frmSponsorshipContact').submit();
			});
	
		}
	};
	
	
	
	// Parse the string.
	function TryParse(str, defaultValue) {
		return /^\d+$/.test(str) ? parseInt(str) : defaultValue; 
	}


	// share this key
  	stLight.options({publisher: "12345"});
	
	
	// data tables
	if ( $('table.algorithm-leaderboard').length>0 ) {
		$('table.algorithm-leaderboard').dataTable( {
			"iDisplayLength": 30,
			"bSort": false,
			"oLanguage": {"sSearch": "Search Handle:"},
			"bLengthChange": false
		});
	}
	
	if ($('#tbl-leaderboard').length>0 ) {
		$.ajax({
			type: 'GET',
			url: "http://tc-leaderboard.herokuapp.com/referral?page_size=10",
			success: function(data) {
				var html = '';
				for(var i = 0; i < data.length; i++) {
					html += '<tr><td>'+data[i].rank+'</td>';
					pic   = ( data[i].pic != null ) ? data[i].pic : "http://www.topcoder.com/wp-content/uploads/2014/06/placeholder_image.png";
			        html += '<td><img src="'+pic+'" width="50"></td>';					
					html += '<td><a href="http://www.topcoder.com/member-profile/'+data[i].handle+'/" target="_blank">'+data[i].handle+'</a></td>';
					html += '<td>'+data[i].score+'</td>';
				}
				$('#tbl-leaderboard tr').first().after(html);
			},
			failure: function(err) {
				console.log('Could not fetch leaderboard: ' + err);    
			}
		});	
	}
	
	
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
	
})