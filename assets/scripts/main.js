/* ========================================================================
 * DOM-based Routing
 * Based on http://goo.gl/EUTi53 by Paul Irish
 *
 * Only fires on body classes that match. If a body class contains a dash,
 * replace the dash with an underscore when adding it to the object below.
 *
 * .noConflict()
 * The routing is enclosed within an anonymous function so that you can
 * always reference jQuery with $, even when in .noConflict() mode.
 * ======================================================================== */

(function($) {

  // Use this variable to set up the common and page specific functions. If you
  // rename this variable, you will also need to rename the namespace below.
  var Sage = {
    // All pages
    'common': {
      init: function() {
		// JavaScript to be fired on all pages
		//$(document).ready(function() {
		 	
		// 	     	OWL CAROUSEL on WORKS
	 	// refer http://poligon.pro/owl/ and https://github.com/smashingboxes/OwlCarousel2/issues/132
	 	// http://stackoverflow.com/questions/20031525/owl-carousel-still-transitions-when-only-1-slide-in-carousel
	    var $sync1 = $("#work_slider"),
	    $sync2 = $("#work_slider_description"),
		$sync3 = $("#work_slider_navigation"),
		flag = false,
		duration = 10;
		duration_text = 0;
	
		$sync1
			.owlCarousel({
				items: 1,
				margin: 0,
				lazyLoad : true,
				nav: false,
				navClass: ['btn btn-default owl-carousel-left disabled','btn btn-default owl-carousel-right'],
			    navText: ['<i class="icon-arrow-left2""></i>', '<i class="icon-arrow-right2"></i>'],
				dots: false,
				autoHeight : true,
				animateOut: 'fadeOut',
				startPosition: $('#final-state').index('.item'),
				onInitialized: function() {
					
				}
			});
			// Remove the owl-loaded class after initialisation 
			$sync1.owlCarousel().removeClass('owl-loaded');
			
			// Show the carousel and trigger refresh
			$sync1.show(function() {
			  $(this).addClass('owl-loaded').trigger('refresh.owl.carousel');
			})
			.on('changed.owl.carousel', function (e) {
				if (!flag) {
					flag = true;
					$sync3.trigger('to.owl.carousel', [e.item.index, duration, true]);
					flag = false;
				}
			});	
		
		$sync2
			.owlCarousel({
				items: 1,
				margin: 0,
				nav: false,
				dots: false,
				autoHeight : true,
				animateOut: 'fadeOut',
				startPosition: $('#final-state').index('.item'),
				
			})
			.on('changed.owl.carousel', function (e) {
				if (!flag) {
					flag = true;
					$sync3.trigger('to.owl.carousel', [e.item.index, duration_text, true]);
					flag = false;
				}
			});
			
	
	
		$sync3
			.owlCarousel({
				margin: 5,
				nav: true,
				navClass: ['btn btn-default owl-carousel-left disabled','btn btn-default owl-carousel-right'],
			    navText: ['<i class="icon-arrow-left""></i>', '<i class="icon-arrow-right"></i>'],
				center: false,
				dots: false,
				animateOut: 'fadeOut',
				responsive:{	
				    480:{
				      items:4
				    },

				    960:{
				      items:5
				    }
				
				  }
			})
			.on('click', '.owl-item', function () {
				$sync1.trigger('to.owl.carousel', [$(this).index(), duration, true]);
				$sync2.trigger('to.owl.carousel', [$(this).index(), duration, true]);
	
			})
			.on('changed.owl.carousel', function (e) {
				if (!flag) {
					flag = true;		
					$sync1.trigger('to.owl.carousel', [e.item.index, duration, true]);
					$sync2.trigger('to.owl.carousel', [e.item.index, duration, true]);
					flag = false;
				}
			});
				
/*
			$('#work_slider_navigation').on('initialized.owl.carousel change.owl.carousel changed.owl.carousel', function(e) { 
		        if (!e.namespace || e.type != 'initialized' && e.property.name != 'position') return;
		
		        var current = e.relatedTarget.current();
		        var items = $(this).find('.owl-stage').children();
		        var add = e.type == 'changed' || e.type == 'initialized';
		
		        items.eq(e.relatedTarget.normalize(current)).toggleClass('current', add);
		    }).owlCarousel({
		        items : 2,        
		        nav: true,
		        loop: true,        
		    });
*/
		//}); // $(document).ready(function()
		
		// 		    MORPH BUTTON on WORKS
		(function() {	
			var docElem = window.document.documentElement, didScroll, scrollPosition;
			
			// trick to prevent scrolling when opening/closing button
			function noScrollFn() {
				window.scrollTo( scrollPosition ? scrollPosition.x : 0, scrollPosition ? scrollPosition.y : 0 );
			}

			function noScroll() {
				window.removeEventListener( 'scroll', scrollHandler );
				window.addEventListener( 'scroll', noScrollFn );
			}

			function scrollFn() {
				window.addEventListener( 'scroll', scrollHandler );
			}

			function canScroll() {
				window.removeEventListener( 'scroll', noScrollFn );
				scrollFn();
			}

			function scrollHandler() {
				if( !didScroll ) {
					didScroll = true;
					setTimeout( function() { scrollPage(); }, 60 );
				}
			}

			function scrollPage() {
				scrollPosition = { x : window.pageXOffset || docElem.scrollLeft, y : window.pageYOffset || docElem.scrollTop };
				didScroll = false;
			}

			scrollFn();
			
			var el = document.querySelector( '.morph-button' );
			
			new UIMorphingButton( el, {
				closeEl : '.icon-close',
				onBeforeOpen : function() {
					// don't allow to scroll
					noScroll();
				},
				onAfterOpen : function() {
					// can scroll again
					canScroll();
					// add class "noscroll" to body
					classie.addClass( document.body, 'noscroll' );
					// add scroll class to main el
					classie.addClass( el, 'scroll' );
				},
				onBeforeClose : function() {
					// remove class "noscroll" to body
					classie.removeClass( document.body, 'noscroll' );
					// remove scroll class from main el
					classie.removeClass( el, 'scroll' );
					// don't allow to scroll
					noScroll();
				},
				onAfterClose : function() {
					// can scroll again
					canScroll();
				}
			} );
			
		})(); // function
		
		$(document).ready(function() {
			
			jQuery('.print-work').click(function() {
				window.print();
				return false;
			});
			
			$(function () {
			    $(".print-states").click(function () {
			        var contents = $("#print-states").html();
			        var frame1 = $('<iframe />');
			        frame1[0].name = "frame1";
			        frame1.css({ "position": "absolute", "top": "-1000000px" });
			        $("body").append(frame1);
			        var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
			        frameDoc.document.open();
			        //Create a new HTML document.
			        frameDoc.document.write('<html><head>');
			        frameDoc.document.write('</head><body>');
			        //Append the external CSS file.
			        frameDoc.document.write('<link href="http://catalogue.rickamor.com.au/wp-content/themes/RM/dist/styles/print-states.css" rel="stylesheet" type="text/css" media="print" /> <script src="https://use.typekit.net/ibs1zlz.js"></script>
	<script>try{Typekit.load({ async: true });}catch(e){}</script>');
			        //Append the DIV contents.
			        frameDoc.document.write(contents);
			        frameDoc.document.write('</body></html>');
			        frameDoc.document.close();
			        setTimeout(function () {
			            window.frames.frame1.focus();
			            window.frames.frame1.print();
			            frame1.remove();
			        }, 500);
			    });
			});
			
		});	 
		
		// Masonry

		// Trigger masonry after Typekit has finished loading
		// http://masonry.desandro.com/appendix.html#imagesloaded
		
/*
		var $container;
		
		function triggerMasonry() {
			// don't proceed if $grid has not been selected
			if ( !$container ) {
				return;
			}
			
			// init Masonry
			$container.imagesLoaded( function() {
				$container.masonry({
					// options...
					isAnimated: true,
					isFitWidth: true,
					columnWidth: 4,
					itemSelector: '.grid_item',
					animationOptions: {
					    duration: 700,
					    easing: 'linear',
					    queue: false
					}
				});
			});
		}
		
		// trigger masonry on document ready
		$(function(){
			$container = $('.masonry_container');
			triggerMasonry();
		});
		
		// trigger masonry when fonts have loaded
		Typekit.load({
			active: triggerMasonry,
			inactive: triggerMasonry
		});
*/


		
      },
      finalize: function() {
        // JavaScript to be fired on all pages, after page specific JS is fired
                

        
      }
    },
    // Home page
    'home': {
      init: function() {
	      

	      
      },
      finalize: function() {
        // JavaScript to be fired on the home page, after the init JS
      }
    },
    // About us page, note the change from about-us to about_us.
    'about_us': {
      init: function() {
        // JavaScript to be fired on the about us page
      }
    }
  };

  // The routing fires all common scripts, followed by the page specific scripts.
  // Add additional events for more control over timing e.g. a finalize event
  var UTIL = {
    fire: function(func, funcname, args) {
      var fire;
      var namespace = Sage;
      funcname = (funcname === undefined) ? 'init' : funcname;
      fire = func !== '';
      fire = fire && namespace[func];
      fire = fire && typeof namespace[func][funcname] === 'function';

      if (fire) {
        namespace[func][funcname](args);
      }
    },
    loadEvents: function() {
      // Fire common init JS
      UTIL.fire('common');

      // Fire page-specific init JS, and then finalize JS
      $.each(document.body.className.replace(/-/g, '_').split(/\s+/), function(i, classnm) {
        UTIL.fire(classnm);
        UTIL.fire(classnm, 'finalize');
      });

      // Fire common finalize JS
      UTIL.fire('common', 'finalize');
    }
  };

  // Load Events
  $(document).ready(UTIL.loadEvents);

})(jQuery); // Fully reference jQuery after this point.


jQuery(window).load(function() {
	var $container = jQuery('.masonry_container');
		
	//$container.imagesLoaded( function() {
	
		// Extra step is for Safari
		//$(".grid_item img").load(function() {
		$container.masonry({
			 // options...
			isAnimated: true,
			percentPosition: true,
            transitionDuration: 0,
			columnWidth: '.grid_item',
			itemSelector: '.grid_item',
			animationOptions: {
			    duration: 700,
			    easing: 'linear',
			    queue: false
			}
		});
		//});
	
	//});
});