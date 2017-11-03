var mp_checkout;

( function( $ ) {

	/**
	 * Fix jqueryui * bootstrap tooltip conflict
	 * @since 3.0
	 */
	 
	$.widget.bridge('mptooltip', $.ui.tooltip);
	
    mp_checkout = {
        /**
         * Initialize event listeners
         *
         * @since 3.0
         */
        initListeners: function() {
            this.initShippingAddressListeners();
			this.initAccountRegistrationListeners();
            this.initPaymentOptionListeners();
            this.initUpdateStateFieldListeners();
            this.initCardValidation();
            this.initCheckoutSteps();
            this.listenToLogin();
            $( document ).on( 'mp_checkout/step_changed', this.lastStep );
        },
        /**
         * Update state list/zipcode field when country changes
         *
         * @since 3.0
         */
        initUpdateStateFieldListeners: function() {
            $( '[name="billing[country]"], [name="shipping[country]"]' ).on( 'change', function() {
                var $this = $( this );
                var url = mp_i18n.ajaxurl + '?action=mp_update_states_dropdown';

                if ( $this.attr( 'name' ).indexOf( 'billing' ) == 0 ) {
                    var $state = $( '[name="billing[state]"]' );
                    var $zip = $( '[name="billing[zip]"]' );
                    var type = 'billing';
                    var $row = $state.closest( '.mp_checkout_fields' );
                } else {
                    var $state = $( '[name="shipping[state]"]' );
                    var $zip = $( '[name="shipping[zip]"]' )
                    var type = 'shipping';
                    var $row = $state.closest( '.mp_checkout_fields' );
                }

                var data = {
                    country: $this.val(),
                    type: type
                }

                $row.ajaxLoading( 'show' );

                $.post( url, data ).done( function( resp ) {
                    if ( resp.success ) {
                        $row.ajaxLoading( 'false' );
                        if ( resp.data.states ) {
                            $state.html( resp.data.states );
                            $state.trigger( 'change' ).closest( '.mp_checkout_column' ).show();
                        } else {
                            $state.closest( '.mp_checkout_column' ).hide();
                        }

                        if ( resp.data.show_zipcode ) {
                            $zip.closest( '.mp_checkout_column' ).show();
                        } else {
                            $zip.closest( '.mp_checkout_column' ).hide();
                        }
                    }
                } );
            } );
        },
        /**
         * Show the checkout form
         *
         * @since 3.0
         */
        showForm: function() {
            $( '#mp-checkout-form' ).show();
        },
        /**
         * Get a value from a hashed query string
         *
         * @since 3.0
         * @param string what The name of the variable to retrieve.
         * @param mixed defaultVal Optional, what to return if the variable doesn't exist. Defaults to false.
         * @return mixed
         */
        getHash: function( what, defaultVal ) {
            var hash = window.location.hash;

            if ( undefined === defaultVal ) {
                defaultVal = false;
            }

            if ( 0 > hash.indexOf( '#!' ) || undefined === defaultVal ) {
                return defaultVal;
            }

            var hashParts = hash.substr( 2 ).split( '&' ), hashPairs = { };

            $.each( hashParts, function( index, value ) {
                var tmp = value.split( '=' );
                hashPairs[ tmp[0] ] = tmp[1];
            } );

            if ( undefined === hashPairs[ what ] ) {
                return defaultVal;
            }

            return hashPairs[ what ];
        },
        /**
         * Show/hide checkout section error summary
         *
         * @since 3.0
         * @param string action Either "show" or "hide".
         * @param int count The number of errors.
         */
        errorSummary: function( action, count ) {
            var $section = $( '.mp_checkout_section' ).filter( '.current' ).find( '.mp_checkout_section_errors' );
            var $checkout = $( '#mp-checkout-form' );

            if ( undefined === $checkout.data( 'mp-submitted' ) ) {
                /* form hasn't been submitted so bail. fixes issue with error summary
                 being hidden when generated by PHP */
                return;
            }

            if ( 'show' == action ) {
                var errorVerb = ( count > 1 ) ? mp_checkout_i18n.error_plural : mp_checkout_i18n.error_singular;
                var errorString = mp_checkout_i18n.errors.replace( '%d', count ).replace( '%s', errorVerb );
                $section.html( errorString ).addClass( 'show' );
            } else {
                $section.removeClass( 'show' );
            }
        },
        /**
         * Execute when on the last step of checkout
         *
         * @since 3.0
         * @event mp_checkout/step_changed
         */
        lastStep: function( evt, $out, $in ) {
            var $checkout = $( '#mp-checkout-form' );

            if ( $in.next( '.mp_checkout_section' ).length == 0 ) {
                $checkout.addClass( 'last-step' );
            } else {
                $checkout.removeClass( 'last-step' );
            }
        },
        /**
         * Go to next step in checkout
         *
         * @since 3.0
         */
        nextStep: function() {
            var $current = $( '.mp_checkout_section' ).filter( '.current' );
            var $next = $current.next( '.mp_checkout_section' );
            this.changeStep( $current, $next );
        },
        /**
         * Change checkout steps
         *
         * @since 3.0
         * @param jQuery $out The jquery object being transitioned FROM
         * @param jQuery $in The jquery object being transitioned TO
         */
        changeStep: function( $out, $in ) {
            $out.find( '.mp_tooltip' ).mptooltip( 'close' );
            $out.find( '.mp_checkout_section_content' ).slideUp( 500, function() {
                $out.removeClass( 'current' );
                $in.find( '.mp_checkout_section_content' ).slideDown( 500, function() {
                    $in.addClass( 'current' );

                    /**
                     * Fires after a step change
                     *
                     * @since 3.0
                     * @param jQuery $out The jquery object being transitioned FROM
                     * @param jQuery $in The jquery object being transitioned TO
                     */
                    $( document ).trigger( 'mp_checkout/step_changed', [ $out, $in ] );

                    mp_checkout.initActivePaymentMethod();
                } );
            } );
        },
        /**
         * Initialize checkout steps
         *
         * @since 3.0
         */
        initCheckoutSteps: function() {
            var $checkout = $( ' #mp-checkout-form' );
            var formSubmitted = false;

            // Trim values before validating
            $.each( $.validator.methods, function( key, val ) {
                $.validator.methods[ key ] = function() {
                    if ( arguments.length > 0 ) {
                        var $el = $( arguments[1] );
                        var newVal = $.trim( $el.val() );

                        $el.val( newVal );
                        arguments[0] = newVal;
                    }

                    return val.apply( this, arguments );
                }
            } );

            // Go to step when clicking on section heading
            $checkout.find( '.mp_checkout_section_heading-link' ).on( 'click', function( e ) {
                var $this = $( this );
                var $section = $this.closest( '.mp_checkout_section' );
                var $current = $('.mp_form-checkout').find('.current');

                if ( $current.length > 0 ) {
                    // section is before the current step - ok to proceed
                    mp_checkout.changeStep( $current, $section );
                }
            } );

            // Validate form
            $checkout.validate( {
                rules: {
                    shipping_method: "required",
                },
                onkeyup: false,
                onclick: false,
                ignore: function( index, element ) {
                    return ( $( element ).is( ':hidden' ) || $( element ).prop( 'disabled' ) );
                },
                highlight: function( element, errorClass ) {
                    $( element ).addClass( 'mp_form_input_error' ).prev( 'label' ).addClass( 'mp_form_label_error' );
                },
                unhighlight: function( element, errorClass, validClass ) {
                    var $tip = $( element ).siblings( '.mp_tooltip' );
                    if ( $tip.length > 0 ) {
                        $tip.mptooltip( 'close' );
                    }

                    $( element ).removeClass( 'mp_form_input_error' ).prev( 'label' ).removeClass( 'mp_form_label_error' );

                    if ( this.numberOfInvalids() == 0 ) {
                        mp_checkout.errorSummary( 'hide' );
                    }
                },
                submitHandler: function( form ) {
                    $checkout.data( 'mp-submitted', true );

                    var $form = $( form );
                    var $email = $form.find( '[name="mp_login_email"]' );
                    var $pass = $form.find( '[name="mp_login_password"]' );

                    if ( $form.valid() ) {
                        var checkout_as_guest = false;
                        if ($form.find('#is_checkout_as_guest').size() > 0) {
                            checkout_as_guest = true;
                        }

                        if ( $checkout.hasClass( 'last-step' ) ) {
                            var gateway = $( '[name="payment_method"]' ).filter( ':checked' ).val();

                            /**
                             * Trigger checkout event
                             *
                             * For gateways to tie into and process checkout.
                             *
                             * @since 3.0
                             * @param jQuery $form The checkout form object.
                             */
                            $( document ).trigger( 'mp_checkout_process_' + gateway, [ $form ] );
                        } else if ( $.trim( $email.val() ).length > 0 && $.trim( $pass.val() ).length > 0 && checkout_as_guest==false) {
                            var $btn = $( '#mp-button-checkout-login' );
                            $btn.ajaxLoading();

                            // Destroy any tooltips
                            if ( $( '#mp-login-tooltip' ).length > 0 ) {
                                $( '#mp-login-tooltip' ).remove();
                            }

                            var data = {
                                action: "mp_ajax_login",
                                email: $email.val(),
                                pass: $pass.val(),
                                mp_login_nonce: $form.find( '[name="mp_login_nonce"]' ).val()
                            };

                            $.post( mp_i18n.ajaxurl, data ).done( function( resp ) {
                                if ( resp.success ) {
                                    window.location.href = window.location.href;
                                } else {
                                    $btn.ajaxLoading( 'hide' );
                                    $email.before( '<a id="mp-login-tooltip"></a>' );
                                    $( '#mp-login-tooltip' ).mptooltip( {
                                        items: '#mp-login-tooltip',
                                        content: resp.data.message,
                                        tooltipClass: "error",
                                        open: function( event, ui ) {
                                            setTimeout( function() {
                                                $( '#mp-login-tooltip' ).mptooltip( 'destroy' );
                                            }, 4000 );
                                        },
                                        position: {
                                            of: $email,
                                            my: "center bottom-10",
                                            at: "center top"
                                        },
                                        show: 300,
                                        hide: 300
                                    } ).mptooltip( 'open' );
                                }
                            } );
                        } else if ( $form.find('.mp_checkout_section-login-register').hasClass('current') ) {
                            // continue as guest to billing/shipping address
                            marketpress.loadingOverlay( 'hide' );
                            mp_checkout.nextStep();
                        } else {
                            // continue to review/order payment
                            var url = mp_i18n.ajaxurl + '?action=mp_update_checkout_data';
                            marketpress.loadingOverlay( 'show' );

                            $.post( url, $form.serialize() ).done( function( resp ) {
                                if ( resp.success ) {
                                    $.each( resp.data, function( index, value ) {
                                        $( '#' + index ).find( '.mp_checkout_section_content' ).html( value );
                                    } );

                                    if( resp.data.mp_checkout_nonce ){
                                        $( "input#mp_checkout_nonce" ).replaceWith( resp.data.mp_checkout_nonce );
                                    }

                                    mp_checkout.initCardValidation();
                                    marketpress.loadingOverlay( 'hide' );
                                    mp_checkout.nextStep();
                                } else {
                                    $checkout.validate().showErrors( resp.data.messages );
                                    mp_checkout.errorSummary( 'show', resp.data.count );
                                    marketpress.loadingOverlay( 'hide' );
                                }

                            } );
                        }
                    }
                },
                showErrors: function( errorMap, errorList ) {
                    if ( this.numberOfInvalids() > 0 ) {
                        mp_checkout.errorSummary( 'show', this.numberOfInvalids() );
                    }

                    $.each( errorMap, function( inputName, message ) {
                        var $input = $( '[name="' + inputName + '"]' );
                        var $tip = $input.siblings( '.mp_tooltip' );

                        if ( $tip.length == 0 ) {
                            $input.after( '<div class="mp_tooltip" />' );
                            $tip = $input.siblings( '.mp_tooltip' );
                            $tip.uniqueId().mptooltip( {
                                content: "",
                                items: "#" + $tip.attr( 'id' ),
                                tooltipClass: "error",
                                show: 300,
                                hide: 300
                            } );
                        }

                        $tip.mptooltip( 'option', 'content', message );
                        $tip.mptooltip( 'option', 'position', {
                            of: $input,
                            my: "center bottom-10",
                            at: "center top"
                        } );

                        $input.on( 'focus', function() {
                            if ( $input.hasClass( 'mp_form_input_error' ) ) {
                                //$tip.tooltip( 'open' );
                            }
                        } );

                        $input.on( 'blur', function() {
                            $tip.mptooltip( 'close' );
                        } );
                    } );

                    this.defaultShowErrors();
                }
            } );
        },
        /**
         * Initialize the active/selected payment method
         *
         * @since 3.0
         */
        initActivePaymentMethod: function() {
            var $input = $( 'input[name="payment_method"]' );
            if ( $input.filter( ':checked' ).length ) {
                $input.filter( ':checked' ).trigger( 'click' );
            } else {
                $input.eq( 0 ).trigger( 'click' );
            }
        },
        /**
         * Initialize credit card validation events/rules
         *
         * @since 3.0
         */
        initCardValidation: function() {
            $( '.mp-input-cc-num' ).payment( 'formatCardNumber' );
            $( '.mp-input-cc-exp' ).payment( 'formatCardExpiry' );
            $( '.mp-input-cc-cvc' ).payment( 'formatCardCVC' );

            // Validate card fullname
            $.validator.addMethod( 'cc-fullname', function( val, element ) {
                var pattern = /^([a-z]+)([ ]{1})([a-z]+)$/ig;
                return this.optional( element ) || pattern.test( val );
            }, mp_checkout_i18n.cc_fullname );

            // Validate card numbers
            $.validator.addMethod( 'cc-num', function( val, element ) {
                return this.optional( element ) || $.payment.validateCardNumber( val );
            }, mp_checkout_i18n.cc_num );

            // Validate card expiration
            $.validator.addMethod( 'cc-exp', function( val, element ) {
                var dateObj = $.payment.cardExpiryVal( val );
                return this.optional( element ) || $.payment.validateCardExpiry( dateObj.month, dateObj.year );
            }, mp_checkout_i18n.cc_exp );

            // Validate card cvc
            $.validator.addMethod( 'cc-cvc', function( val, element ) {
                return this.optional( element ) || $.payment.validateCardCVC( val );
            }, mp_checkout_i18n.cc_cvc );
        },
        /**
         * Init events related to toggling payment options
         *
         * @since 3.0
         * @access public
         */
        initPaymentOptionListeners: function() {
            $( '.mp_checkout_section' ).on( 'click change', 'input[name="payment_method"]', function() {
                var $this = $( this ),
                    $target = $( '#mp-gateway-form-' + $this.val() ),
                    $checkout = $( '#mp-checkout-form' ),
                    $submit = $checkout.find( ':submit' ).filter( ':visible' );

                if ( !$checkout.hasClass( 'last-step' ) ) {
                    return;
                }

                $target.show().siblings( '.mp_gateway_form' ).hide();

                if ( $target.find( '.mp_form_input.error' ).filter( ':visible' ).length > 0 ) {
                    $checkout.valid();
                } else {
                    mp_checkout.errorSummary( 'hide' );
                }

                if ( undefined === $submit.data( 'data-mp-original-html' ) ) {
                    $submit.data( 'data-mp-original-html', $submit.html() )
                }

                if ( 'true' == $this.attr( 'data-mp-use-confirmation-step' ) ) {
                    $submit.html( $submit.attr( 'data-mp-alt-html' ) );
                } else {
                    $submit.html( $submit.data( 'data-mp-original-html' ) );
                }
            } );

            this.initActivePaymentMethod();
        },
        /**
         * Enable/disable shipping address fields
         *
         * @since 3.0
         */
        toggleShippingAddressFields: function() {
            var $cb = $( 'input[name="enable_shipping_address"]' );
            var $shippingInfo = $( '#mp-checkout-column-shipping-info' );
            var $billingInfo = $( '#mp-checkout-column-billing-info' );

            if ( $cb.prop( 'checked' ) ) {
                //$billingInfo.removeClass( 'fullwidth' );
                setTimeout( function() {
                    $shippingInfo.fadeIn( 500 );
                }, 550 );
            } else {
                $shippingInfo.fadeOut( 500, function() {
                    //$billingInfo.addClass( 'fullwidth' );
                } );
            }
        },
		/**
         * Enable/disable registration fields
         *
         * @since 3.0
         */
        toggleRegistrationFields: function() {
            var $cb = $( 'input[name="enable_registration_form"]' );
            var $account_container = $( '#mp-checkout-column-registration' );

            if ( $cb.prop( 'checked' ) ) {
                $account_container.fadeIn( 500 );
            } else {
                $account_container.fadeOut( 500 );
            }
		},
		/**
         * Initialize events related to registration fields
         *
         * @since 3.0
         */
        initAccountRegistrationListeners: function() {
            var $enableRegistration = $( 'input[name="enable_registration_form"]' );

            // Enable account registration fields
            $enableRegistration.change( mp_checkout.toggleRegistrationFields );
        },
        /**
         * Initialize events related to shipping address fields
         *
         * @since 3.0
         */
        initShippingAddressListeners: function() {
            var $enableShippingAddress = $( 'input[name="enable_shipping_address"]' );

            // Enable billing address fields
            $enableShippingAddress.change( mp_checkout.toggleShippingAddressFields );

            // Copy billing field to shipping field (if shipping address isn't enabled)
            $( '[name^="billing["]' ).on( 'change keyup', function() {
                if ( $enableShippingAddress.is( ':checked' ) ) {
                    // Shipping address checkbox is checked - bail
                    return;
                }

                var $this = $( this );
                var name = $this.attr( 'name' );
                var $target = $( '[name="' + name.replace( 'billing', 'shipping' ) + '"]' );

                if ( $target.length == 0 ) {
                    // Input doesn't exist - bail
                    return;
                }

                $target.val( $this.val() ).trigger( 'change' );
            } );
        },
        /**
         * Trigger step change event
         *
         * @since 3.0
         */
        triggerStepChange: function() {
            var $current = $( '.mp_checkout_section' ).filter( '.current' );
            $( document ).trigger( 'mp_checkout/step_changed', [ $current, $current ] );
        },
        /**
         * Because we have 2 context in login pharse, so we will have to determine which button click to add/removerules
         *
         */
        listenToLogin: function() {
            //if login click, we will add those rules
            $( document ).on( 'click', '.mp_button-checkout-login', function() {
                $( 'input[name="mp_login_email"]' ).rules( 'add', {
                    required: true
                } );
                $( 'input[name="mp_login_password"]' ).rules( 'add', {
                    required: true
                } );
                var form = $(this).closest('form');
                form.find('#is_checkout_as_guest').remove();
                $( this ).closest( 'form' ).submit();
            } );
            //else, we have to remove the rules
            $( document ).on( 'click', '.mp_continue_as_guest', function( e ) {
                $( 'input[name="mp_login_email"]' ).rules( 'remove' );
                $( 'input[name="mp_login_password"]' ).rules( 'remove' );
                var form = $(this).closest('form');
                if (form.find('#is_checkout_as_guest').size() == 0) {
                    form.append($('<input id="is_checkout_as_guest"/>'));
                }
                //$( '.mp_checkout_section_errors' ).hide();
                $( this ).closest( 'form' ).submit();
            } )
            //our form is multiple next/pre button, so we unbind the enter trigger
            $( '#mp-checkout-form' ).on( 'keyup keypress', function( e ) {
                var code = e.keyCode || e.which;
                if ( code == 13 ) {
                    e.preventDefault();
                    return false;
                }
            } );
        }
    };
}( jQuery ) );

jQuery( document ).ready( function( $ ) {
    mp_checkout.showForm();
    mp_checkout.initListeners();
    mp_checkout.toggleShippingAddressFields();
	mp_checkout.toggleRegistrationFields();
    mp_checkout.triggerStepChange();
} );