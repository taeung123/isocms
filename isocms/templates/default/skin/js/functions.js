(function ($) {
	'use strict';

	// Template Helper Function
	$.fn.hasAttr = function(attribute) {
		var obj = this;

		if (obj.attr(attribute) !== undefined) {
			return true;
		} else {
			return false;
		}
	};

	function checkVisibility (object) {
		var el = object[0].getBoundingClientRect(),
			wHeight = $(window).height(),
			scrl =  wHeight - (el.bottom - el.height),
			condition = wHeight + el.height;

		if (scrl > 0  && scrl < condition) {
			return true;
		} else {
			return false;
		}
	};

	// Scroll Events
	var keys = {37: 1, 38: 1, 39: 1, 40: 1};
	function preventDefault(e) {
		e = e || window.event;
		if (e.preventDefault)
			e.preventDefault();
		e.returnValue = false;
	};
	function preventDefaultForScrollKeys(e) {
	    if (keys[e.keyCode]) {
	        preventDefault(e);
	        return false;
	    }
	};
	function disableScroll() {
		if (window.addEventListener) window.addEventListener('DOMMouseScroll', preventDefault, false);
		window.onwheel = preventDefault; // modern standard
		window.onmousewheel = document.onmousewheel = preventDefault; // older browsers, IE
		window.ontouchmove  = preventDefault; // mobile
		document.onkeydown  = preventDefaultForScrollKeys;
	};
	function enableScroll() {
		if (window.removeEventListener) window.removeEventListener('DOMMouseScroll', preventDefault, false);
		window.onmousewheel = document.onmousewheel = null;
		window.onwheel = null;
		window.ontouchmove = null;
		document.onkeydown = null;
	};

	var nextGenWPTheme = {
		init: function () {
			this.checkInputsForValue();
			this.nrOnlyInputs();
			this.slickInit();
			this.scrollEvent();
			this.toggles();
			this.tabs();
			this.flickrInit();
			this.isotopeInit();
			this.googleMaps();
			this.noUiInit();
		},

		// Template Custom Functions
		checkInputsForValue: function () {
			$(document).on('focusout', '.check-value', function () {
				var text_val = $(this).val();
				if (text_val === "" || text_val.replace(/^\s+|\s+$/g, '') === "") {
					$(this).removeClass('has-value');
				} else {
					$(this).addClass('has-value');
				}
			});
		},

		nrOnlyInputs: function () {
			$('.nr-only').keypress(function (e) {
				if (e.which !== 8 && e.which !== 0 && (e.which < 48 || e.which > 57)) {
					return false;
				}
			});
		},

		slickInit: function () {
			// Get All Carousels from the page
			var carousel = $('.theme-carousel');

			// Get All Sliders from the page
			var slider = $('.theme-slider');

			// Init Carousels
			carousel.each(function () {
				var obj = $(this),
					items = obj.find('.carousel-items');

				items.slick({
					focusOnSelect: true,
					speed: obj.hasAttr('data-speed') ? obj.data('speed') : 600,
					slidesToShow: obj.hasAttr('data-items-desktop') ? obj.data('items-desktop') : 4,
					arrows: obj.hasAttr('data-arrows') ? obj.data('arrows') : true,
					dots: obj.hasAttr('data-dots') ? obj.data('dots') : true,
					infinite: obj.hasAttr('data-infinite') ? obj.data('infinite') : false,
					slidesToScroll: obj.hasAttr('data-items-to-slide') ? obj.data('items-to-slide') : 1,
					initialSlide: obj.hasAttr('data-start') ? obj.data('start') : 0,
					asNavFor: obj.hasAttr('data-as-nav-for') ? obj.data('as-nav-for') : '',
					centerMode: obj.hasAttr('data-center-mode') ? obj.data('center-mode') : '',
					vertical: obj.hasAttr('data-vertical') ? obj.data('vertical') : false,
					responsive: [
                        {
                            breakpoint: 1200,
                            settings: {
                                slidesToShow: obj.hasAttr('data-items-small-desktop') ? obj.data('items-small-desktop') : 3,
                                slidesToScroll: obj.hasAttr('data-items-small-desktop') ? obj.data('items-small-desktop') : 3
                            }
                        },
                        {
                            breakpoint: 800,
                            settings: {
                                slidesToShow: obj.hasAttr('data-items-tablet') ? obj.data('items-tablet') : 2,
                                slidesToScroll: obj.hasAttr('data-items-tablet') ? obj.data('items-tablet') : 2
                            }
                        },
                        {
                            breakpoint: 600,
                            settings: {
                                slidesToShow: obj.hasAttr('data-items-phone') ? obj.data('items-phone') : 2,
                                slidesToScroll: obj.hasAttr('data-items-phone') ? obj.data('items-phone') : 2
                            }
                        }
                    ]
				});
			});

			// Init Sliders
			slider.each(function () {
				var obj = $(this),
					items = obj.find('.slides-list');

				items.slick({
					slidesToShow: 1,
					slidesToScroll: 1,
					focusOnSelect: true,
					pauseOnHover: obj.hasAttr('data-pause-on-hover') ? obj.data('pause-on-hover') : true,
					autoplay: obj.hasAttr('data-autoplay') ? obj.data('autoplay') : false,
					autoplaySpeed: obj.hasAttr('data-autoplay-speed') ? obj.data('autoplay-speed') : 2000,
					fade: obj.hasAttr('data-fade') ? obj.data('fade') : false,
					dots: obj.hasAttr('data-dots') ? obj.data('dots') : true,
					speed: obj.hasAttr('data-speed') ? obj.data('speed') : 500,
					arrows: obj.hasAttr('data-arrows') ? obj.data('arrows') : true,
					infinite: obj.hasAttr('data-infinite') ? obj.data('infinite') : false,
					initialSlide: obj.hasAttr('data-start') ? obj.data('start') : 0,
					asNavFor: obj.hasAttr('data-as-nav-for') ? obj.data('as-nav-for') : ''
				});
			});

			// Hot Offer Slider
			// Custom Navigation
			$('.hot-offer-slider-arrow').on('click', function () {
				var obj = $(this);
				var direction = obj.hasClass('arrow-next') ? 'slickNext' : 'slickPrev';
				$('.hot-offer-block .theme-slider .slides-list').slick(direction);
			});

			// Hot Offer Slider
			// Description Load

			$('.hot-offer-block .theme-slider .slides-list').on('beforeChange', function () {
				$('.hot-offer-block .hot-offer-description').addClass('loading');
			});

			$('.hot-offer-block .theme-slider .slides-list').on('afterChange', function (slick, currentSlide) {
				$('.hot-offer-block .hot-offer-description h3').text($('.hot-offer-block .theme-slider .slide').eq(currentSlide.currentSlide).data('title'));
				$('.hot-offer-block .hot-offer-description p').text($('.hot-offer-block .theme-slider .slide').eq(currentSlide.currentSlide).data('description'));

				$('.hot-offer-block .hot-offer-description').removeClass('loading');
			});
		},

		scrollEvent: function () {
			// Main Scroll Event
			$(window).on('scroll', function () {
				var st = $(window).scrollTop();

				// Show Visible Elements
				$('.check-screen-visibility').each(function () {
					var obj = $(this);

					if (obj.visible()) {
						setTimeout(function () {
							obj.addClass('visible');
						}, 250);
					}
				});
			});
		},

		toggles: function () {
			// jQuery Datepicker
			// Calendar Init
			$('#calendar-checkin, #calendar-checkout').datepicker({
				onSelect: function (date) {
					$(this).parent().find('.form-input').attr('value', date);
					$(this).parent().removeClass('open').addClass('has-value');
				}
			});

			// Calendar Popup
			$('.main-search-form .calendar-box').each(function () {
				var obj = $(this),
					trigger = obj.find('.form-input');

				trigger.on('click', function () {
					$('.main-search-form .calendar-box').removeClass('open');
					obj.addClass('open');

					return false;
				});
			});

			$('.main-search-form .calendar-box .calendar').on('click', function (e) {
				e.stopPropagation();
			});

			$(document).on('click', function () {
				$('.main-search-form .calendar-box').removeClass('open');
			});

			// Custom Select Box
			$('.select-box').each(function () {
				var obj = $(this),
					trigger = obj.find('.form-input');

				trigger.on('click', function () {
					obj.addClass('visible');
					return false;
				});

				obj.find('.select-options li').on('click', function () {
					trigger.attr('value', $(this).hasAttr('data-value')  ? $(this).data('value') : $(this).text());
					obj.addClass('has-value');
				});
			});

			$(document).on('click', function () {
				$('.select-box').removeClass('visible');
			});

			// Main Navigation Toggle
			$('.main-nav-toggle').on('click', function () {
				$('.main-nav').addClass('open');
				return false;
			});

			$('.main-nav').on('click', function (e) {
				e.stopPropagation();
			})

			$('html, .close-main-nav').on('click', function () {
				$('.main-nav').removeClass('open');
			});

			// Advanced filters box
			$('.advanced-filters-toggle').on('click', function () {
				var obj = $(this);
				obj.toggleClass('focused');
				if (obj.hasClass('focused')) {
					obj.html(obj.data('focus'));
				} else {
					obj.html(obj.data('unfocus'));
				}

				$('.advanced-filters-box').slideToggle(400);
				$('.advanced-filters-box').toggleClass('open');
			});
		},

		tabs: function () {
			var tabs = $('.tabed-content');
         tabs.each(function () {
             var tab = $(this),
                 option = tab.find('.tabs-header .tab-link'),
                 content = tab.find('.tab-item');

             option.on('click', function () {
                 var obj = $(this);

                 if (!obj.hasClass('current')) {
                     option.removeClass('current');
                     obj.addClass('current');

                     if (tabs.hasClass('gallery-tabs')) {
                         tab.addClass('switching');

                         setTimeout(function () {
                             content.removeClass('current');
                             $('#' + obj.data('tab-link')).addClass('current');

                             tabs.removeClass('switching');
                         }, 1795);
                     } else {
                         content.removeClass('current');
                         $('#' + obj.data('tab-link')).addClass('current');
                     }
                 }
             });
         });
		},

		accordionInit: function () {
			var accordion = $('.accordion-group');

			accordion.each(function () {
				var accordion = $(this).find('.accordion-box');

				accordion.each(function () {
					var obj = $(this),
						header = $(this).find('.box-header h4'),
						body = $(this).find('.box-body');

					header.on('click', function () {
						if (obj.hasClass('open')) {
							body.velocity('slideUp', {
								duration: 150,
								complete: function () {
									obj.removeClass('open');
								}
							});
						} else {
							obj.addClass('open');
							body.velocity('slideDown', {duration: 195});
						}
					});
				});
			});
		},

		isotopeInit: function () {
			$('.isotope-container').imagesLoaded(function () {
				$('.isotope-container').isotope({
					itemSelector: '.isotope-item'
				});
			});
		},

		flickrInit: function () {
			$('.flickr_widget').each(function () {
				var stream = $(this);
				var stream_userid = stream.attr('data-userid');
				var stream_items = parseInt(stream.attr('data-items'), 10);
				jQuery.getJSON("http://api.flickr.com/services/feeds/photos_public.gne?lang=en-us&format=json&id=" + stream_userid + "&jsoncallback=?", function (stream_feed) {
					var i;
					var stream_function = function (i) {
						if (stream_feed.items[i].media.m) {
							var stream_a = $('<a>').addClass('PhotostreamLink').attr('href', stream_feed.items[i].link).attr('target', '_blank');
							var stream_img = $('<img>').addClass('PhotostreamImage').attr('src', stream_feed.items[i].media.m).attr('alt', '').each(function () {
								var t_this = this;
								var j_this = $(this);
								var t_loaded_function = function () {
									stream_a.append(t_this);
								};
								var t_loaded_ready = false;
								var t_loaded_check = function () {
									if (!t_loaded_ready) {
										t_loaded_ready = true;
										t_loaded_function();
									}
								};
								var t_loaded_status = function () {
									if (t_this.complete && j_this.height() !== 0)
										t_loaded_check();
								};
								t_loaded_status();
								jQuery(this).load(function () {
									t_loaded_check();
								});
							});
							stream.append($('<li>').append(stream_a));
						}
					};
					for (i = 0; i < stream_items && i < stream_feed.items.length; i++) {
						stream_function(i);

						if (i === stream_feed.items.length-1) {
							setTimeout(function () {
								jQuery('body').trigger('sidebarIsotope');
							}, 400);
						}
					}
				});
			});
		},

		googleMaps: function () {
			// Info Box Init
			if ($('#room-contact-popup').length) {
				var infobox = new InfoBox({
					content: document.getElementById('room-contact-popup'),
					closeBoxURL: ""
				});
			}

			if ($('#hotel-contact-popup').length) {
				var infobox = new InfoBox({
					content: document.getElementById('hotel-contact-popup'),
					closeBoxURL: ""
				});
			}

			// Describe Google Maps Init Function
			function initialize_contact_map (customOptions) {
            var mapOptions = {
                  center: new google.maps.LatLng(customOptions.map_center.lat, customOptions.map_center.lon),
                  zoom: parseInt(customOptions.zoom),
                  scrollwheel: false,
                  disableDefaultUI: true,
                  mapTypeId: google.maps.MapTypeId.ROADMAP
					};

         	var contact_map = new google.maps.Map($('#map-canvas')[0], mapOptions),
					marker = new google.maps.Marker({
						map: contact_map,
						position: new google.maps.LatLng(customOptions.marker_coord.lat, customOptions.marker_coord.lon),
						animation: google.maps.Animation.DROP,
						icon: customOptions.marker
					});

				infobox.open(contact_map, marker);

				marker.addListener('click', function () {
					$(this).css({
						'transform': 'scale(.5)'
					});
				});
         }

         if ($('#map-canvas').length) {
         	var customOptions = $('#map-canvas').data('options');
             google.maps.event.addDomListener(window, 'load', initialize_contact_map(customOptions));
         }
		},

		noUiInit: function () {
			var priceSlider = $('.price-slider')[0],
				step = $(priceSlider).data('step'),
				start = $(priceSlider).data('start'),
				stop = $(priceSlider).data('stop'),
				min = $(priceSlider).data('min'),
				max = $(priceSlider).data('max');

			if ($('.price-slider').length) {
				noUiSlider.create(priceSlider, {
					start: [start, stop],
					connect: true,
					step: step,
					range: {
						'min': min,
						'max': max
					}
				});

				// Adding Tooltips to slider
				var tipHandles = $('.values-block span');
				priceSlider.noUiSlider.on('update', function( values, handle ){
					tipHandles.eq(handle).html(Math.floor(values[handle]));
				});
			}
		}
	};

	$(document).ready(function(){
		nextGenWPTheme.init();

		setTimeout(function () {
			$('body').addClass('dom-ready');
		}, 300);
	});
}(jQuery));
