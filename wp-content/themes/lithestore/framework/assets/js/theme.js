/**
 * theme.js
 * Scripts for the theme.
 * 
 */

/**
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
( function() {

	var container, button, menu, links, subMenus, i, len;

	container = document.getElementById( 'site-navigation' );
	if ( ! container ) {
		return;
	}

	button = container.getElementsByTagName( 'button' )[0];
	if ( 'undefined' === typeof button ) {
		return;
	}

	menu = container.getElementsByTagName( 'ul' )[0];

	// Hide menu toggle button if menu is empty and return early.
	if ( 'undefined' === typeof menu ) {
		button.style.display = 'none';
		return;
	}

	menu.setAttribute( 'aria-expanded', 'false' );
	if ( -1 === menu.className.indexOf( 'nav-menu' ) ) {
		menu.className += ' nav-menu';
	}

	button.onclick = function() {
		if ( -1 !== container.className.indexOf( 'toggled' ) ) {
			container.className = container.className.replace( ' toggled', '' );
			button.setAttribute( 'aria-expanded', 'false' );
			menu.setAttribute( 'aria-expanded', 'false' );
		} else {
			container.className += ' toggled';
			button.setAttribute( 'aria-expanded', 'true' );
			menu.setAttribute( 'aria-expanded', 'true' );
		}
	};

	// Get all the link elements within the menu.
	links    = menu.getElementsByTagName( 'a' );
	subMenus = menu.getElementsByTagName( 'ul' );

	// Set menu items with submenus to aria-haspopup="true".
	for ( i = 0, len = subMenus.length; i < len; i++ ) {
		subMenus[i].parentNode.setAttribute( 'aria-haspopup', 'true' );
	}

	// Each time a menu link is focused or blurred, toggle focus.
	for ( i = 0, len = links.length; i < len; i++ ) {
		links[i].addEventListener( 'focus', toggleFocus, true );
		links[i].addEventListener( 'blur', toggleFocus, true );
	}

	/**
	 * Sets or removes .focus class on an element.
	 */
	function toggleFocus() {
		var self = this;

		// Move up through the ancestors of the current link until we hit .nav-menu.
		while ( -1 === self.className.indexOf( 'nav-menu' ) ) {

			// On li elements toggle the class .focus.
			if ( 'li' === self.tagName.toLowerCase() ) {
				if ( -1 !== self.className.indexOf( 'focus' ) ) {
					self.className = self.className.replace( ' focus', '' );
				} else {
					self.className += ' focus';
				}
			}

			self = self.parentElement;
		}
	}

	/**
	 * Toggles `focus` class to allow submenu access on tablets.
	 */
	( function( container ) {
		var touchStartFn, i,
			parentLink = container.querySelectorAll( '.menu-item-has-children > a, .page_item_has_children > a' );

		if ( 'ontouchstart' in window ) {
			touchStartFn = function( e ) {
				var menuItem = this.parentNode, i;

				if ( ! menuItem.classList.contains( 'focus' ) ) {
					e.preventDefault();
					for ( i = 0; i < menuItem.parentNode.children.length; ++i ) {
						if ( menuItem === menuItem.parentNode.children[i] ) {
							continue;
						}
						menuItem.parentNode.children[i].classList.remove( 'focus' );
					}
					menuItem.classList.add( 'focus' );
				} else {
					menuItem.classList.remove( 'focus' );
				}
			};

			for ( i = 0; i < parentLink.length; ++i ) {
				parentLink[i].addEventListener( 'touchstart', touchStartFn, false );
			}
		}
	}( container ) );
} )();




jQuery(document).ready(function($){
	/*-------------------------
	Basic Theme Related Scripts	
	--------------------------*/
	$(window).load(function(){
	    // Remove the # from the hash, as different browsers may or may not include it
	    var hash = location.hash.replace('#','');

	    if(hash != ''){

	       // Clear the hash in the URL
	       // location.hash = '';   // delete front "//" if you want to change the address bar
	        $('html, body').animate({ scrollTop: $('#'+hash).offset().top-250}, 1000);

	     }else{
	     	$('html, body').animate({ scrollTop:0});
	     }
    });

    $("a.woocommerce-review-link").click(function(e){
        e.preventDefault(); //Prevents hash to be appended at the end of the current URL.
        $("div.woocommerce-tabs>ul.tabs>li>a[href='" + $(this).attr("href") + "']").click(); //Opens up the particular tab
        $('html, body').animate({
            scrollTop: $("div.woocommerce-tabs").offset().top-110
        }, 1000); //Change to whatever you want, this value is in milliseconds.
    });


	/*Clone Primary menu items to the mobile menu*/
	$('#mobile_menu .menu-item-has-children').addClass('pushy-submenu');
	
	$('.pushy .menu-item-has-children > a').each(function(){
		$(this).after('<a href="javascript:void(0);" class="open-submeu"><i class="fa fa-plus"></i></a>');
	});
	
	  $('.pushy ul li a.open-submeu').toggle(function(){
		  $(this).next().slideDown();
		  $(this).children('i').removeClass('fa-plus').addClass('fa-minus');
	  },function(){
		  $(this).next().slideUp();
		  $(this).children('i').removeClass('fa-minus').addClass('fa-plus');
	  });
	
	/*Sticky Top*/
	$(window).on('scroll',function(){
	
	        /*Sticky Top*/
	        if($(document).scrollTop() > 20){
		      $('#ls-topbar').addClass('withbg');
			}else{
			  $('#ls-topbar').removeClass('withbg');
			}
	});
	
	/*Apply the post format to the comment content elements*/
	$('.comment-content').addClass('entry-content');
	
	/*Popup*/
    function lithestore_popup(button,obj,status){
	    $(button).on('click',function(){
	      if(status=='open'){
		   $(obj).add('.ls_popup_overlay').fadeIn();
		  }else{
		   $(obj).add('.ls_popup_overlay').fadeOut();  
		  }
	    });
    }
    lithestore_popup('#product_search','#ls_popup','open');
    lithestore_popup('.ls_popup_overlay','#ls_popup','close');
	
	
	/*-------------------------
	WooCommerce Related Scripts	
	--------------------------*/
	
	/*Center the cart button in the product thumbnail*/
	$('.woocommerce ul.products li.product .button.add_to_cart_button').each(function(){
		var buttonWidth=$(this).width();
		var imageHeight=$(this).prev().children('img').height();
		var containerHeight=$(this).parent().height();
		var buttonLeftOffset=buttonWidth/2;
		var buttonTopOffset=(containerHeight-imageHeight)/2
		$(this).css({
		   marginLeft: '-'+buttonLeftOffset+'px',
		   marginTop: '-'+buttonTopOffset+'px'
		});
	});
	$('.woocommerce ul.products li.product .button.add_to_cart_button').prepend('<i class="fa fa-shopping-cart"></i>');
	
    /*When hover on the product thumbnail, display the cart button*/
    $('.woocommerce ul.products li.product a img').hover(
      function(){$(this).parent().next().show();$(this).css('opacity',.3);},
      function(){$(this).parent().next().hide();$(this).css('opacity',1);}
    );
    
    $('.woocommerce ul.products li.product .button.add_to_cart_button').hover(
       function(){$(this).show();$(this).prev().children('img').css('opacity',.3);},
       function(){$(this).hide();$(this).prev().children('img').css('opacity',1);}
    );
	
});