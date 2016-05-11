/* ALL THE SCRIPTS IN THIS FILE ARE MADE BY KROWNTHEMES.COM AND ARE LICENSED UNDER ENVATO'S REGULAR/EXTENDED LICENSE --- REDISTRIBUTION IS NOT ALLOWED! */

(function($) {

    $(document).ready(function(){

        "use strict";

/* ----------------------------------------------------
---------- !! GENERAL STUFF !! -----------------
------------------------------------------------------- */
    
    var $html = $('html'),
        $body = $('body'),
        $menu = $('#main-menu'),
        $search = $('#main-search #searchform'),

        touchM = "ontouchstart" in window;

    if(touchM) {
        $body.removeClass('no-touch')
            .addClass('touch');
    }

    $body.removeClass('no-js');

    /* -------------------------------
    -----   Menu (responsive)  -----
    ---------------------------------*/

    var optionsString = '';

    // Create responsive navigaton based on menu items

    $menu.children('.top-menu').children('li').each(function(){

        var $a = $(this).children('a');

        optionsString += '<option data-href="' + $a.prop('href') + '"' + ($a.prop('target') == 'blank' ? ' data-target="_blank"' : '') + '>' + $a.text() + '</option>';

        if($(this).hasClass('parent')) {
            $(this).find('ul').find('a').each(function(){

                optionsString += '<option data-href="' + $(this).prop('href') + '"' + ($(this).prop('target') == 'blank' ? ' data-target="_blank"' : '') + '> -- ' + $(this).text() + '</option>';

            });

        }

    });

    // Append the navigation from above

    $menu.append('<div class="responsive-menu"><select class="responsive-select"><option>' + $menu.data('nav-text') + '</option>' + optionsString + '</select></div>');

    // Bind proper events for it

    $('.responsive-menu').children('select').on('change', function(){

        var href = $(this).find('option:selected').data('href'),
        target = $(this).find('option:selected').data('target');

        if(target == undefined) {
            document.location.href = href;
        } else {
            window.open(href, '_blank');
        }

    });

    // Basic menu animation (regular menu)

    $menu.find('li').hover(function(){
        if($(this).children('div').length > 0)
            $(this).children('div').stop().slideDown(150, function(){
                $(this).css('overflow', 'visible');
            });
    }, function(){
        if($(this).children('div').length > 0)
            $(this).children('div').stop().slideUp(100);
    }).each(function(){

        // This iteration takes each submenu and modifies it's width according to the content present in there

        var $submenu = $(this).children('div');

        if($submenu.length > 0){

            var minW = 200;

            $submenu.css('display', 'block');

            $submenu.children('li').each(function(){
                $(this).addClass('menu-fix');
                if($(this).width() > minW)
                minW = $(this).width();
                $(this).removeClass('menu-fix');
            });

            $submenu.css('display', 'none').width(minW);
            $submenu.find('div').css('left', minW);

        }

    });

    // Search form handling

    $search.find('.krown-icon-search').click(function(e){
        
        if($search.hasClass('opened')) {
            $search.removeClass('opened');
            $('html').off('click.searchout');
        } else {
            $search.addClass('opened');
            $('html').on('click.searchout', function(){
            	$search.removeClass('opened');
            });
        }
        e.stopPropagation();

    });

     $search.find('#s').each(function(){

        $(this)
            .data('value', $(this).val())
            .focus(function(){
                $(this).addClass('focusInput');
                if($(this).val() == $(this).data('value')){
                  $(this).val('');
                } else {
                  $(this).select();
                }
            })
            .blur(function(){
                $(this).removeClass('focusInput');
                if($(this).val() == ''){
                  $(this).val($(this).data('value'));
                }
            })
            .click(function(e){
        		e.stopPropagation();
            });
      
    });

    /* -------------------------------
    -----   CTA Header  -----
    ---------------------------------*/

    if ( $('#custom-header .cta').length > 0 && touchM ) {

    	var $selectedCTA = null;

    	$('#custom-header .cta').click(function(){

    		if ( $(this).hasClass('hover') ) {

    			$selectedCTA = null;
    			$(this).removeClass('hover');

    		} else {

	    		if ( $selectedCTA != null )
	    			$selectedCTA.removeClass('hover');
	    		$selectedCTA = $(this);
	    		$selectedCTA.addClass('hover');

    		}


    	});

	}

/* ----------------------------------------------------
---------- !! CROWDFUNDING !! -----------------
------------------------------------------------------- */

    /* -------------------------------
    -----   Projects Grid  -----
    ---------------------------------*/

    var $krownGrid = $('.krown-id-grid');

    function setProjectGrid(){

	    $krownGrid.each(function(){

	    	var id = '#' + $(this).attr('id');

    		$('.krown-tabs').children('.contents').children('div').css('display', 'block');

	    	if ( $(this).hasClass('carousel') ) {



		    	var $carousel = $(this),
		    		$holder = $(this).find('.carousel-holder'),
		    		$items = $(this).find('.krown-id-item'),
		    		$btnNext = $(this).find('.btn-next'),
		    		$btnPrev = $(this).find('.btn-prev');

		    	var visNo = 0;

		    	if ( $p580.css('display') == 'block' ) {
		    		visNo = 2;
		    	} else if ( $p780.css('display') == 'block' ) {
		    		visNo = 3;
		    	} else {
		    		visNo = parseInt($holder.data('visible'));
		    	}

		    	var visWidth = $carousel.width()+parseInt($items.eq(0).css('marginLeft'))*2,
		    		page = 0,
		    		pages = Math.ceil($items.length / visNo)-1,
		    		enableBtn = true;

		    	$holder.css('position', 'absolute');
		    	$holder.parent().css('height', $holder.height());

		    	$items.css('left', 0);

		    	$carousel.data({
		    		'items': $items,
		    		'visNo': $holder.data('visible'),
		    		'visWidth': $carousel.width()+parseInt($items.eq(0).css('marginLeft'))*2,
		    		'page': 0,
		    		'pages': Math.ceil($items.length / visNo)-1
		    	});

		    	$carousel.cjSwipe('on', function(swipedRight){

	    			if ( swipedRight ) {
	    				$btnNext.trigger('click');
	    			} else {
	    				$btnPrev.trigger('click');
	    			}

		    	});

		    	$btnNext.on('click', function(e){

    				var $carousel = $(this).closest('.carousel'),
    					$items = $carousel.data('items'),
    					page = $carousel.data('page'),
    					pages = $carousel.data('pages'),
    					visNo = $carousel.data('visNo'),
    					visWidth = $carousel.data('visWidth');

		    		if ( enableBtn && page + 1 <= pages ) {

		    			enableBtn = false;
						$carousel.data('page', ++page);

						if ( page + 1 <= pages ) {
							$btnNext.removeClass('disabled');
						} else {
							$btnNext.addClass('disabled');
						}
						if ( page - 1 >= 0 ) {
							$btnPrev.removeClass('disabled');
						} else {
							$btnPrev.addClass('disabled');
						}

			    		var dI = 0,
			    			oldI = (page-1)*visNo;

						$.grep( $items, function( n, i ) {

							if ( i >= oldI ) {

								$items.eq(i).stop().delay(dI++*50).animate({
									'left': -visWidth*page
								}, 200, 'easeInQuint');

							} else {

								$items.eq(i).stop().animate({
									'left': -visWidth*page
								}, 0);

							}

						});

						setTimeout(function(){
							enableBtn = true;
						}, visNo*2*50+200);

					}

		    		e.preventDefault();

		    	});

		    	$btnPrev.on('click', function(e){

    				var $carousel = $(this).closest('.carousel'),
    					$items = $carousel.data('items'),
    					page = $carousel.data('page'),
    					pages = $carousel.data('pages'),
    					visNo = $carousel.data('visNo'),
    					visWidth = $carousel.data('visWidth');

		    		if ( enableBtn && page - 1 >= 0 ) {

		    			enableBtn = false;
						$carousel.data('page', --page);

						if ( page + 1 <= pages ) {
							$btnNext.removeClass('disabled');
						} else {
							$btnNext.addClass('disabled');
						}
						if ( page - 1 >= 0 ) {
							$btnPrev.removeClass('disabled');
						} else {
							$btnPrev.addClass('disabled');
						}

			    		var dI = (page+2)*visNo-1,
			    			oldI = dI+1;

						$.grep( $items, function( n, i ) {

							if ( i < oldI ) {

								$items.eq(i).stop().delay(dI--*50).animate({
									'left': -visWidth*page
								}, 200, 'easeInQuint');

							} else {
								$items.eq(i).stop().animate({
									'left': -visWidth*page
								}, 0);

							}

						});

						setTimeout(function(){
							enableBtn = true;
						}, visNo*2*50+200);

					}

		    		e.preventDefault();

		    	}).addClass('disabled');

		    } else {
		    	
		    	$(this).imagesLoaded(function(){

			    	$(id).isotope({
			    		itemSelector: '.krown-id-item',
			    		layoutMode: 'masonry'
			    	});

			    });

		    }

	    	setTimeout(function(){
	    		$('.krown-tabs').children('.contents').children('div:nth-child(1n+2)').css('display', 'none');
	    	}, $(this).hasClass('carousel') ? 100 : 1000);

	    });

	}

	if( $('.krown-id-grid').length>0 ){

		$body.append('<div id="responsive-test"><div id="p780"></div><div id="p580"></div><div>');

		var $p780 = $('#p780'),
			$p580 = $('#p580');

		$('.krown-id-grid').imagesLoaded(function(){
			setProjectGrid();
		});

		var gT = 0;

		var oldSize = $(window).width();

		$(window).on('resize', function(){

			if ( oldSize != $(window).width() ) {

				oldSize = $(window).width();

				$krownGrid.each(function(){

					if ( $(this).hasClass('carousel') ) {

				    	var $holder = $(this).find('.carousel-holder'),
				    		$items = $(this).find('.krown-id-item'),
				    		visNo = 0;

				    	var $tabs = $(this).closest('.krown-tabs'),
				    		$tab = $tabs.children('.contents').children('div');

			    		$tab.each(function(){
			    			$(this).data('display', $(this).css('display'))
			    				.css('display', 'block');
			    		});

				    	$holder.css('position', 'absolute');
				    	$holder.parent().css('height', $holder.height());

				    	if ( $p580.css('display') == 'block' ) {
				    		visNo = 2;
				    	} else if ( $p780.css('display') == 'block' ) {
				    		visNo = 3;
				    	} else {
				    		visNo = parseInt($holder.data('visible'));
				    	}

				    	$(this).data({
				    		'items': $items,
				    		'visNo': visNo,
				    		'visWidth': $(this).width()+parseInt($items.eq(0).css('marginLeft'))*2,
				    		'page': 0,
				    		'pages': Math.ceil($items.length / visNo)-1
				    	});

				    	$items.css('left', 0);

				    	$(this).find('.btn-prev').addClass('disabled');
				    	$(this).find('.btn-next').removeClass('disabled');

			    		$tab.each(function(){
			    			$(this).css('display', $(this).data('display'));
			    		});

			    	} else {
			    		
				    	var $tabs = $(this).closest('.krown-tabs'),
				    		$tab = $tabs.children('.contents').children('div');

			    		$tab.each(function(){
			    			if ( $(this).data('lock') != 'yes' ) {
				    			$(this).data('lock', 'yes');
				    			$(this).data('display', $(this).css('display'))
				    				.css('display', 'block');
			    			}
			    		});

				    	gT = setTimeout(function(){
				    		$tab.each(function(){
				    			$(this).css('display', $(this).data('display'))
				    				.data('lock', 'no');
				    		});
				    	}, 1000);

			    	}

				});

			}
	
		});

	}

    /* -------------------------------
    -----   Single Project  -----
    ---------------------------------*/

    if ( $body.hasClass('single-ignition_product') ) {

    	var $projectSidebar = $('#project-sidebar');

    	// Wrap some divs, append others, change some classes, etc.. Mostly structural changes in the original plugin

		$projectSidebar.find('.product-wrapper, .id-product-proposed-end, .btn-container').wrapAll('<div class="panel clearfix">');
		$projectSidebar.find('.id-widget.ignitiondeck').removeClass('ignitiondeck');
		$projectSidebar.find('#project-p-author').appendTo($projectSidebar.find('.separator'));
		$projectSidebar.find('.poweredbyID').appendTo($projectSidebar);
		$projectSidebar.find('.main-btn').addClass('krown-button medium color');
		$projectSidebar.find('.id-progress-raised, .id-product-funding, .id-product-total, .id-product-pledges, .id-product-days, .id-product-days-to-go').wrapAll('<div class="rholder">');
		$projectSidebar.find('.id-progress-raised, .id-product-funding').wrapAll('<div class="rpdata">');
		$projectSidebar.find('.id-product-total, .id-product-pledges').wrapAll('<div class="rpdata">');
		$projectSidebar.find('.id-product-days, .id-product-days-to-go').wrapAll('<div class="rpdata">');
		$projectSidebar.find('.product-wrapper').addClass('clearfix');
		$('.id-level-desc:empty').remove();
		$('.ignitiondeck.idstretch').prev().addClass('idst');

		// Pie charts animation

		$('.id-widget .progress-percentage, .idstretch-percentage').each(function(){

			var perc = parseInt($(this).text().replace(',', '')),
				color = perc > 99 ? themeObjects.pieColor3 : themeObjects.pieColor2;

			if ($(this).hasClass('idstretch-percentage')) {
				color = perc > 99 ? themeObjects.pieColor3 : themeObjects.pieColor1;
			}

			$(this).parent().html('<div class="krown-pie ' + ( $(this).hasClass('idstretch-percentage') ? 'small' : 'large' ) + '" data-color="' + color + '"><div class="holder"><span class="value" data-percent="' + perc + '">' + perc + '</span></div></div>');

		});

		// Duplicate pie for responsive mode

		$projectSidebar.find('.id-widget .krown-pie').clone().prependTo($projectSidebar.find('.rtitle'));

		$projectSidebar.find('.rtitle').find('.krown-pie').removeClass('large').addClass('small');

		// Responsive sidebar behavior

		var $projectTitle = $('#page-title'),
			$projectBtn = $projectSidebar.find('.btn-container'),
			hasButton = $projectBtn.find('a').length > 0 ? true : false,
			sP = 90,
			openedSidebar = false,
			enableSidebar = true;

		$body.append('<div id="responsive-test"><div id="p780"></div><div id="p580"></div><div>');

		var $p780 = $('#p780'),
			$p580 = $('#p580');

		if (!hasButton) {
			$projectSidebar.css('paddingBottom', '0');
			sP = -10;
		}

		$projectSidebar.find('.rtitle').click(function(){

			if (enableSidebar) {

				enableSidebar = false;
			
				if (!openedSidebar){

					$(this).addClass('opened');

					$projectSidebar.css('height', 'auto');
					var pH = $projectSidebar.outerHeight();
					$projectSidebar.css('height', 100);

					$projectSidebar.stop().animate({
						'height': pH
					}, {
						duration: 350,
						easing: 'easeInQuad',
						step: function(nH){
							$projectTitle.css('paddingTop', nH-10);
						},
						complete: function(){
							enableSidebar = true;
							$projectBtn.css({
								'top': $projectSidebar.outerHeight()-225,
								'display': 'block'
							});
						}
					});

					openedSidebar = true;

				} else {

					$(this).removeClass('opened');
					$projectBtn.css('display', 'none');

					$projectSidebar.stop().animate({
						'height': 100
					}, {
						duration: 250,
						easing: 'easeInQuad',
						step: function(nH){
							$projectTitle.css('paddingTop', nH-10);
						},
						complete: function(){
							enableSidebar = true;
						}
					});

					openedSidebar = false;

				}

			}

		});

		$(window).resize(function(){

			if ($p780.css('display') == 'block' || $p580.css('display') == 'block') {

				if (!hasButton) {
					$projectSidebar.css('paddingBottom', '0');
					sP = -10;
				}

				if (openedSidebar) {

					$projectSidebar.css('height', 'auto');
					$projectTitle.css('paddingTop', $projectSidebar.height()+sP);
					$projectBtn.css('top', $projectSidebar.height()-125);
					$projectBtn.css('display', 'block');

				} else {

					$projectSidebar.css('height', 100);
					$projectTitle.css('paddingTop', 90);
					$projectBtn.css('display', 'none');

				}

			} else {

				$projectTitle.css('paddingTop', 0);
				$projectSidebar.css('height', 'auto');
				$projectBtn.css('display', 'block');

			}

			enableSidebar = true;

		});

	}

    /* -------------------------------
    -----   Dashboard  -----
    ---------------------------------*/

	$('.backer_title .id-backer-links').appendTo('.backer_title');

	if ($('.dashboardmenu').length > 0) {

	    var $dashboardLinks = $('.dashboardmenu').find('li'),
	    	optionsString = '<div class="tabs-select"><select>';

		$dashboardLinks.each(function(){

	        optionsString += '<option>' + $(this).find('a').text() + '</option>'

		});
	    
	    optionsString += '</select></div>';

		$('.dashboardmenu').append(optionsString).find('.tabs-select').find('select').change(function(){
			document.location.href = $dashboardLinks.eq($(this).find('option:selected').index()).find('a').prop('href');
		});

		$('#edit-profile').find('.form-row:nth-of-type(1), .form-row:nth-of-type(4), .form-row:nth-of-type(6), .form-row:nth-of-type(8), .form-row:nth-of-type(11)').addClass('first');

	}

/* ----------------------------------------------------
---------- !! CONTACT PAGE !! -----------------
------------------------------------------------------- */
    
    if($('.insert-map').length>0) {

        $('.insert-map').each(function(){

            var $mapInsert = $(this);

            var map;

            var stylez = [
                {
                  featureType: "all",
                  elementType: "all",
                  stylers: [
                    { saturation: -100 }
                  ]
                }
            ];
            
            var mapOptions = {
                zoom: $mapInsert.data('zoom'),
                center: new google.maps.LatLng($mapInsert.data('map-lat'), $mapInsert.data('map-long')),
                streetViewControl: false,
                scrollwheel: false,
                panControl: true,
                mapTypeControl: false,
                overviewMapControl: false,
                zoomControl: false,
                draggable: touchM ? false : true,
                zoomControlOptions: {
                    style: google.maps.ZoomControlStyle.LARGE
                },
                mapTypeControlOptions: {
                     mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'krownMap']
                }
            };

            map = new google.maps.Map(document.getElementById($mapInsert.attr('id')), mapOptions);

            if($mapInsert.data('greyscale') == 'd-true') {

                var mapType = new google.maps.StyledMapType(stylez, { name:"Grayscale" });    
                map.mapTypes.set('krownMap', mapType);
                map.setMapTypeId('krownMap');

            }

            if($mapInsert.data('marker') == 'd-true') {

                var myLatLng = new google.maps.LatLng($mapInsert.data('map-lat'), $mapInsert.data('map-long'));
                var beachMarker = new google.maps.Marker({
                    position: myLatLng,
                    map: map,
                    icon: $mapInsert.data('marker-img')
                });

            }

            setTimeout(function(){
            	$mapInsert.animate({'opacity': 1}, 400)
            		.parent().addClass('remove-preloader');
            }, 2000);

        });

    }

/* ----------------------------------------------------
---------- !! VARIOUS SHORTCODES !! -----------------
------------------------------------------------------- */

    // Dirty but working

    $('p:empty').remove();

    // Iframes resize

    $("#content").fitVids();

    /* -------------------------------
    -----   Accordions   -----
    ---------------------------------*/

    $('.krown-accordion').each(function(){

        var toggle = $(this).hasClass('toggle') ? true : false,
            $sections = $(this).children('section'),
            $opened = $(this).data('opened') == '-1' ? null : $sections.eq(parseInt($(this).data('opened')));

        if($opened != null){
            $opened.addClass('opened');
            $opened.children('div').slideDown(0);
        }

        $(this).children('section').children('h5').click(function(){

            var $this = $(this).parent();

            if(!toggle){
                if($opened != null){
                    $opened.removeClass('opened');
                    $opened.children('div').stop().slideUp(300);
                }
            }

            if($this.hasClass('opened') && toggle){
                $this.removeClass('opened');
                $this.children('div').stop().slideUp(300);
            } else if(!$this.hasClass('opened')){
                $opened = $this;
                $this.addClass('opened');
                $this.children('div').stop().slideDown(300);
            }

        });

    });

    /* -------------------------------
    -----   Contact Forms   -----
    ---------------------------------*/

    $('.krown-form').each(function(){

        var $form = $(this).find('form'),
        $name = $(this).find('.name'),
        $email = $(this).find('.email'),
        $subject = $(this).find('.subject'),
        $message = $(this).find('.message'),
        $success = $(this).find('.success-message'),
        $error = $(this).find('.error-message');

        $name.focus(function(){resetError($(this))});
        $email.focus(function(){resetError($(this))});
        $subject.focus(function(){resetError($(this))});
        $message.focus(function(){resetError($(this))});

        function resetError($input){
            $input.removeClass('contact-error-border');
            $error.fadeOut();
        }

        $form.submit(function(e){

            var ok = true;
            var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

            if($name.val().length < 3 || $name.val() == $name.data('value')){
                showError($name);
                ok = false;
            }

            if($email.val() == '' || $email.val() == $email.data('value') || !emailReg.test($email.val())){
                showError($email);
                ok = false;
            }

            if($message.val().length < 5 || $message.val() == $message.data('value')){
                showError($message);
                ok = false;
            }

            if($(this).hasClass('full') && ($subject.val().length < 3 || $subject.val() == $subject.data('value'))){
                showError($subject);
                ok = false;
            }

            function showError($input){
                $input.val($input.data('value'));
                $input.addClass('contact-error-border');
                $error.fadeIn();
            }

            if(ok){

                $form.fadeOut();

                $.ajax({
                    type: $form.prop('method'),
                    url: $form.prop('action'),
                    data: $form.serialize(),
                    success: function(){
                      $success.fadeIn();
                  }
              });

            }

            e.preventDefault();

        });

    });

    /* -------------------------------
    -----   Fancybox   -----
    ---------------------------------*/

    $('img.alignleft, img.alignright, img.aligncenter').parent('a').each(function(){
        $(this).attr('class', 'fancybox fancybox-thumb ' + $(this).children('img').attr('class'));
    });

    if($('.fancybox').length > 0 || $('div[id*="attachment"]').length > 0){

        $('.fancybox, div[id*="attachment"] > a').fancybox({
            padding: 0,
            margin: 50,
            aspectRatio: true,
            scrolling: 'no',
            mouseWheel: false,
            openMethod: 'zoomIn',
            closeMethod: 'zoomOut',
            nextEasing: 'easeInQuad',
            prevEasing: 'easeInQuad'
        }).append('<span></span>');
    }

    /* -------------------------------
    -----   Pies   -----
    ---------------------------------*/

    function animatePies(){

        $('.krown-pie').each(function(){

            // This is the function which creates a pie and animates it. It animates the circle and the value

            var $value = $(this).find('.value'),
                pieCanvas = $(this).find('.pie-canvas')[0],
                color = $(this).data('color');

            if($(this).hasClass('large')) {

                var circle = new ProgressCircle({
                    canvas: pieCanvas,
                    minRadius: 115,
                    arcWidth: 18,
                    centerX: 136,
                    centerY: 136
                });

            } else {

                var circle = new ProgressCircle({
                    canvas: pieCanvas,
                    minRadius: 52,
                    arcWidth: 6,
                    centerX: 62,
                    centerY: 60
                });

            }

            var pI,
                p = 0,
                s = 0;

            circle.addEntry({
                fillColor: color,
                progressListener: function() {
                    return p;
                }
            });

            function initPie(percent, value){
            	
                p = 0;
                clearInterval(pI);
                circle.stop();

                var t = 0, 
                    tI = value/percent;
                circle.start(5);

                pI = setInterval(function(){

                    p = p + 0.0025;
                    t = Math.floor(p*100*tI);

                    if(p >= percent/100){
                        circle.stop();
                        clearInterval(pI);
                        p = 0;
                    }
                    
                    $value.html(t + '<sup>%</sup>');

                }, 5);

            }

            if( parseInt($value.data('percent')) != '0' ) {
            	initPie(Math.min(parseInt($value.data('percent')),100), parseInt($value.text()));
            }


        });

    }

    if($('.krown-pie').length > 0 && !$html.hasClass('ie8')){

        // For all the pies...

        $('.krown-pie').each(function(){

            // Prep for animation

            var size = $(this).hasClass('large') ? 274 : 122;

            $(this).find('.holder').append('<div class="pie-holder"><canvas class="pie-canvas" width="' + size + '" height="' + size + '"></canvas></div>');

        });
        
        animatePies();

    }

    /* -------------------------------
    -----   Tabs   -----
    ---------------------------------*/

    $('.krown-tabs').each(function(){

        var $titles = $(this).children('.titles').children('li'),
	        $contents = $(this).children('.contents').children('div'),
	        $openedT = $titles.eq(0),
	        $openedC = $contents.eq(0),
	        style = $(this).hasClass('fade') ? 'fade' : 'tab';

        $openedT.addClass('opened');
        $openedC.stop().slideDown(0);

        $titles.find('a').prop('href', '#').off('click');

        $titles.click(function(e){

            $openedT.removeClass('opened');
            $openedT = $(this);
            $openedT.addClass('opened');

            if ( style == 'fade' ) {
	        	$openedC.stop().fadeOut(250);
	            $openedC = $contents.eq($(this).index());
	            $openedC.stop().delay(250).fadeIn(300);
	        } else {
	        	$openedC.stop().slideUp(250);
	            $openedC = $contents.eq($(this).index());
	            $openedC.stop().delay(250).slideDown(300);
	        }

	        if ( responsiveOn ) {
	        	$responsiveSelect.val($(this).text());
	        }

            e.preventDefault();

        });

        // Responsive fallback for some of the tabs

        if ( $(this).hasClass('responsive-on') ) {

        	var optionsString = '<div class="tabs-select"><select>';

        	$titles.each(function(){
        		optionsString += '<option>' + $(this).find('h5').text() + '</option>'
        	});

        	optionsString += '</select></div>';

    		$(this).children('.titles').append(optionsString).find('.tabs-select').find('select').change(function(){
    			$titles.eq($(this).find('option:selected').index()).trigger('click');
    		});

        }

        var $responsiveSelect = $(this).find('.tabs-select').find('select'),
        	responsiveOn = $(this).hasClass('responsive-on') ? true : false;

    });

    /* -------------------------------
    -----   Twitter Widget   -----
    ---------------------------------*/

    $('.krown-twitter.rotenabled').each(function(){

        var $tW = $(this).children('ul').children('li'),
            tI = 0,

        tV = setInterval(function(){

            $tW.eq(tI).fadeOut(250);

            if(++tI == $tW.length)
                tI = 0;

            $tW.eq(tI).delay(260).fadeIn(300);

        }, 6000);

    });

    /* -------------------------------
    -----   Slider   -----
    ---------------------------------*/

    $('.flexslider.mini').each(function(){

   		var $slider = $(this);

    	if ( $slider.find('li').length > 1 ) {

	        $(this).flexslider({
	            animation: 'slider',
	            easing: 'easeInQuad',
	            animationSpeed: 300,
	            slideshow: true,
	            directionNav: true,
	            controlNav: false,
	            keyboard: false,
	            prevText: '',
	            nextText: '',
	            start: function(e){
	                e.container.delay(300).animate({'opacity': 1}, 300);
	            }
	        });

    	} else {

    		$slider.removeClass('flexslider');

    	}

    });

    /* -------------------------------
    -----   Video / Audio elements   -----
    ---------------------------------*/

    $('.rev_slider_wrapper').find('video').data('no-mejs', 'true');

    if($('#content').find('audio, video').length > 0 ) {

    	$('#content').find('video').attr({
    		'width': '100%',
    		'height': '100%',
    		'style': 'width:100%;height:100%'
    	});

        $('#content').find('audio, video').each(function(){

            if($(this).data('no-mejs') != 'true'){
                $(this).mediaelementplayer({
                    alwaysShowControls: false,
                    iPadUseNativeControls: false,
                    iPhoneUseNativeControls: false,
                    AndroidUseNativeControls: false,
                    enableKeyboard: false,
                    pluginPath: themeObjects.base + '/js/mediaelement/',
                    success: function() {
                        $(window).trigger('resize');
                    }
                });
            }

        });
    }

    /* -------------------------------
    -----   OTHER   -----
    ---------------------------------*/

    // Style select boxes

    $('select.responsive-select').styledSelect({
        coverClass: 'responsive-design-cover',
        innerClass: 'responsive-design-inner'
    });

    $('.tabs-select select').styledSelect({
        coverClass: 'tabs-select-cover',
        innerClass: 'tabs-select-inner'
    });

    // Set retina cookie

    var retina = window.devicePixelRatio > 1;
    $.cookie('dpi', retina, {expires: 365, path: '/'});

    // Go to top button

    var $top = $('#top');

    $top.click(function(e){
        $('html,body').animate({scrollTop: 0}, 500, 'easeInQuad');
        e.preventDefault();
    });

    $(window).on('scroll.menu', checkMenu);
    $(window).trigger('scroll');

    function checkMenu(){
        if($(this).scrollTop() < 500 && $top.hasClass('show')) {
            $top.removeClass('show');
        } else if ($(this).scrollTop() > 500 && !$top.hasClass('show')) {
            $top.addClass('show');
        }
    }

///////////////

    });

})(jQuery);