(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
    
    
    $(document).ready(function($){
        let loader = $('.cosBooking-loader-box');
		
		let is_able_to_book = 1;
		
		var startDate = "2021-12-15", // some start date
			endDate  = "2021-12-21",  // some end date
			dateRange = cos_booking_object.blocked_dates; // array to hold the range

		// populate the array
		//for (var d = new Date(startDate); d <= new Date(endDate); d.setDate(d.getDate() + 1)) {
			//dateRange.push($.datepicker.formatDate('yy-mm-dd', d));
		//}
		
		$(".transfer_date").datepicker({
			beforeShowDay: function (date) {
				var dateString = jQuery.datepicker.formatDate('yy-mm-dd', date);
				return [dateRange.indexOf(dateString) == -1];
			}
		});
		
        $(document).on('change keyup','#cosBookingForm select, #cosBookingForm input', function(){
            $(this).removeClass('c-error');
            $(this).parent().find('.c-required').remove();
        });

        $(document).on('change','.cos_time_hours, .cos_time_minutes', function(){
            var time_picker__ = $(this).parent();
            var hours__ = time_picker__.find('.cos_time_hours').val();
            var minutes__ = time_picker__.find('.cos_time_minutes').val();
            time_picker__.prev().val(hours__+':'+minutes__);
			
			cos_get_route_price();
        });
        
        $(document).on('click','.cosEditStep2',function(){
            $('.cosStep1Handel').show();
            $('.cosStep2Handel').hide();
        });
        
        $(document).on('click','.cosStep1Handel.Next-button a', function(){
			if(is_able_to_book == 0){
				var s = $(".cosFormError-route").offset().top;
				$(window).scrollTop(s - 50);
				return;
			}
             var validate = 1;
             //console.log('shdjsa');
            var valFrom = $('#cos_place_from').val();
            var valTo = $('#cos_place_to').val();
            var valArrDatetime = $('.transfer_date._one').val()+ ' ' +$('.transfer_time._one').val();
            var valPassengers = $('#cos_adults_').val() +' Adults'+' '+$('#cos_childrens_').val()+ ' Childrens';
            var valprice_total = $('input[name="cos_route_price_total"]').val();
            
            $('#valFrom').text(valFrom);
            $('#valTo').text(valTo);
            $('#valArrDatetime').text(valArrDatetime);
            $('#valPassengers').text(valPassengers);
            $('#valprice_total').text('€ '+ valprice_total);
			$('.cos_amount-via-stripe').text('€ '+ valprice_total);
             
             $('.c-required').remove();
            $('.cosStep1Handel input:required, .cosStep1Handel select:required').each(function(){
                if($(this).val() == ''){
                    validate = 0;
                    var err_text = $(this).attr('data-text');
                    $(this).addClass('c-error');
                    $(this).after('<span class="c-required">please enter '+err_text+'</span>');
                }
                else{
                    $(this).removeClass('c-error');
                   
                }
                
            });
            
            if(validate == 1){
                $('.cosStep1Handel').hide();
                $('.cosStep2Handel').show();
            }
        });
		
		$(document).on('change', '.cos_payment_via_stripe', function(){
			var amount_ = $('input[name="cos_route_price_total"]').val();
			var payment_via_stripe_ = $('.cos_payment_via_stripe:checked').val();
			if( amount_ > 0 ){
			  amount_ = amount_ * ( payment_via_stripe_ / 100 );
			} 
			$('.cos_amount-via-stripe').text('€ '+ amount_);
		});
    
        
        $(document).on('click','.cosStep2Handel.order-button a', function(){
			
             var validate = 1;
             $('.c-required').remove();
            $('.cosStep2Handel input:required, .cosStep2Handel select:required').each(function(){
                if($(this).val() == ''){
                    validate = 0;
                    var err_text = $(this).attr('data-text');
                    $(this).addClass('c-error');
                    $(this).after('<span class="c-required">please enter '+err_text+'</span>');
                }
                else if( $(this).attr('type') == 'radio' && $('input[name="cos_i_agree"]').prop('checked') == false ){
                    validate = 0;
                    var err_text = $(this).attr('data-text');
                    $(this).addClass('c-error');
                    $(this).after('<span class="c-required">Please select I agree with Terms & Conditions.</span>');
                }
                else{
                    $(this).removeClass('c-error');
                    
                }
            });
            
        
            if(validate == 1){
				var payment_via_stripe = $('.cos_payment_via_stripe:checked').val();
				if( payment_via_stripe > 0 ){
					$('.cosStep2Handel').hide();
				
					$('html, body').animate({
						
						scrollTop: $('#cosBookingForm').submit().top
					}, 1000);
				}
				else{
					$('#cosBookingForm').submit();
				}
            }
        });
        
        
        $(document).on('change','#cosBookingForm input[name="cosb_trip_type"]', function(){
            $('.cosFormError-route').remove();
			is_able_to_book = 1;
            var cos_place_from = $('#cosBookingForm #cos_place_from').val();
            var cos_place_to = $('#cosBookingForm #cos_place_to').val();
            
            /*if( cos_place_from != '' && cos_place_to != '' ){*/
                if( $('#cosBookingForm input[name="cosb_trip_type"]:checked').val() == 'Round trip' ){
                    $('#cosBookingForm .date-time-round').show();
                    $('#cosBookingForm input[name="date_round"]').prop('required',true);
                    $('#cosBookingForm input[name="time_round"]').prop('required',true);
                    
					if( cos_place_from != '' && cos_place_to != '' ){
						var booking_data = $('#cosBookingForm').serialize();
						loader.show();
						$.ajax({
							url: cos_booking_object.ajaxurl,
							data: {action:'cos_api_check_round_routes_ajax',booking_data:booking_data},                         
							type: 'post',
							success: function(response_){
								loader.hide();
								if(response_.status == 0){
									$('#cosBookingForm .date-time-round').hide();
									$('#cosBookingForm .transfer-type #one').prop('checked',true);
									$('#cosBookingForm .transfer-type #two').prop('checked',false);
									alert(response_.msg);
								}
								else{
									$('#cosBookingForm input[name="cos_route_id_round"]').val(response_.route_id_round);
								}
								$('#promo_code_field').val('');
								 cos_get_route_price();
							}
						});
					}
                }
                else{
                    $('#cosBookingForm input[name="date_round"]').val('');
                    $('#cosBookingForm input[name="time_round"]').val('00:00');
					$('.date-time-round .cos_time_hours').val('00');
					$('.date-time-round .cos_time_minutes').val('00');
                    
                    $('#cosBookingForm input[name="date_round"]').prop('required',false);
                    $('#cosBookingForm input[name="time_round"]').prop('required',false);
                    
                    $('#cosBookingForm input[name="cos_route_id_round"]').val('');
                    $('#cosBookingForm .date-time-round').hide();
					$('#promo_code_field').val('');
                     cos_get_route_price();
                }
                
            /*}*/
            /*else{
                $('#cosBookingForm .transfer-type #one').prop('checked',true);
                $('#cosBookingForm .transfer-type #two').prop('checked',false);
				is_able_to_book = 0;
                $('#cosBookingForm').before('<span class="cosFormError-route" style="color:red;">Please select Transfer from and Transfer to</span>');
            }*/
            
        });
        
        $(document).on('change','#cosBookingForm #cos_place_from', function(){
            $('#cosBookingForm #cos_place_to').html('');
            $('.cosBookingForm-main .order-price bdi').text('€0.00');
            $('input[name="cos_route_price_total"]').val(0);
			$('#promo_code_field').val('');
            //$('#cosBookingForm .transfer-type #one').prop('checked',true);
            //$('#cosBookingForm .transfer-type #two').prop('checked',false);
            
            $('#cosBookingForm input[name="cos_route_id_one"]').val('');
            $('#cosBookingForm input[name="cos_route_id_round"]').val('');
            
            var booking_data = $('#cosBookingForm').serialize();
            $('.cosFormError-route').remove();
			is_able_to_book = 1;
            loader.show();
             $.ajax({
                url: cos_booking_object.ajaxurl,
                data: {action:'cos_api_get_routes_ajax',booking_data:booking_data},                         
                type: 'post',
                success: function(response_){
                    loader.hide();
                    if(response_.status == 0){
						is_able_to_book = 0;
                        $('#cosBookingForm #cos_place_from').after('<span class="cosFormError-route" style="color:red;">'+response_.msg+'</span>');
                    }
                    $('#cosBookingForm #cos_place_to').html(response_.routes_list_html);
                }
             });
        });
        
        $(document).on('change','#cos_place_to',function(){
            //$('#cosBookingForm .transfer-type #one').prop('checked',true);
            //$('#cosBookingForm .transfer-type #two').prop('checked',false);
            $('#cosBookingForm input[name="cos_route_id_round"]').val('');
            
            var route_id_ = '';
            var place_to = $(this).val();
            if(place_to != ''){
                route_id_ = $('#cosBookingForm #cos_place_to option[value="'+place_to+'"]').attr('data-RouteId');
            }
            
            $('#cosBookingForm input[name="cos_route_id_one"]').val(route_id_);
			$('#cosBookingForm input[name="cos_route_id_round"]').val(route_id_);
			$('#promo_code_field').val('');
            
            cos_get_route_price();
            
        });
        
        $(document).on('change','#cosBookingForm input[name="date_one"], #cos_adults_, #cos_childrens_',function(){
			$('#promo_code_field').val('');
             cos_get_route_price();
        });
        
        $(document).on('change','#cosBookingForm input[name="date_round"]',function(){
			$('#promo_code_field').val('');
             cos_get_route_price();
        });
		
		$(document).on('change','#promo_code_field', function(){
			var amount = $('input[name="cos_route_price_total"]').val();
			if( $(this).val() != '' ){
				cos_apply_promo_code( $(this).val(), amount );
			}
			else{
				$('.cos_invalid_promo').remove();
				$('.cos_applied_promo').remove();
				cos_get_route_price();
			}
			
		});
		
		
		// stripe script start
		// Set your publishable key: remember to change this to your live publishable key in production
        // See your keys here: https://dashboard.stripe.com/apikeys
        var stripe = Stripe(cos_booking_object.stripe_publishable_key);
        var elements = stripe.elements();
        
        // Custom styling can be passed to options when creating an Element.
        var style = {
          base: {
            // Add your base input styles here. For example:
            fontSize: '20px',
            color: '#32325d',
			border:'1px solid #000',
			background: '#ffffff',
			padding:'20px'
          },
        };
        
        // Create an instance of the card Element.
        var card = elements.create('card', {style: style});
        
        // Add an instance of the card Element into the `card-element` <div>.
        card.mount('#card-element');
        
        // Create a token or display an error when the form is submitted.
        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function(event) {
          event.preventDefault();
        
			cos_confirm_payment(card);
		// script to stripe charge API - start
          /*stripe.createToken(card).then(function(result) {
            if (result.error) {
              // Inform the customer that there was an error.
              var errorElement = document.getElementById('card-errors');
              errorElement.textContent = result.error.message;
            } else {
              // Send the token to your server.
              stripeTokenHandler(result.token);
            }
          });*/
		// End
		
        });
		
		function cos_confirm_payment(card_element){
			var amount = $('input[name="cos_route_price_total"]').val();
			var first_name = $('input[name="cos_name"]').val();
			var last_name = $('input[name="cos_surname"]').val();
			var full_name = first_name+' '+last_name;
			var user_email = $('input[name="cos_email"]').val();
			var payment_via_stripe = $('.cos_payment_via_stripe:checked').val();
			if( amount > 101 ){
			  amount = amount * ( payment_via_stripe / 100 );
			}
			loader.show();
			$.ajax({
				url: cos_booking_object.ajaxurl,
				data: {action:'cos_stripe_ajax',amount:amount,user_email:user_email,full_name:full_name},                         
				type: 'post',
				success: function(response_){
					loader.hide();
					
					
					if(response_.id){
						var clientSecret = response_.client_secret;
						stripe.confirmCardPayment(clientSecret, {
							payment_method: {
							  card: card_element,
							  billing_details: {
								name: full_name,
								email: user_email,
							  },
							},
						  })
						  .then(function(result) {
								console.log(result);
								if( result.error ){
									var msg = 'Payment Failed! <a href="#" onclick="location.reload()">Retry</a>';
									
									var msg = result.error.message;
									
									$('#card-element').parent().before('<p style="color:red">'+msg+'</p>');
								}
								else{
									if(result.paymentIntent.status == 'succeeded'){
										$('#cosBookingForm').submit();
									}
								}
						  });
					}
					else{
						var msg = 'Payment Failed! <a href="#" onclick="location.reload()">Retry</a>';
						if(response_.status == 'error' && response_.response != ''){
							var msg = response_.response;
						}
						$('#card-element').parent().before('<p style="color:red">'+msg+'</p>');
					}
					
					
				}
			 });
		}
        
        function stripeTokenHandler(token) {
          // Insert the token ID into the form so it gets submitted to the server
          var form = document.getElementById('payment-form');
          var hiddenInput = document.createElement('input');
          hiddenInput.setAttribute('type', 'hidden');
          hiddenInput.setAttribute('name', 'stripeToken');
          hiddenInput.setAttribute('value', token.id);
          form.appendChild(hiddenInput);
        
          // Submit the form
          //form.submit();
		  var amount = $('input[name="cos_route_price_total"]').val();
		  var first_name = $('input[name="cos_name"]').val();
		  var last_name = $('input[name="cos_surname"]').val();
		  var full_name = first_name+' '+last_name;
		  var user_email = $('input[name="cos_email"]').val();
		  var payment_via_stripe = $('.cos_payment_via_stripe:checked').val();
		  if( amount > 0 ){
			  amount = amount * ( payment_via_stripe / 100 );
		  }
		  loader.show();
		  $.ajax({
			url: cos_booking_object.ajaxurl,
			data: {action:'cos_stripe_ajax',stripeToken:token.id,amount:amount,user_email:user_email,full_name:full_name},                         
			type: 'post',
			success: function(response_){
				loader.hide();
				if(response_.paid){
					$('#cosBookingForm').submit();
				}
				else{
					var msg = 'Payment Failed! <a href="#" onclick="location.reload()">Retry</a>';
					if(response_.status == 'error' && response_.response != ''){
						var msg = response_.response;
					}
					$('#card-element').parent().before('<p style="color:red">'+msg+'</p>');
				}
			}
		 });
        }
		// stripe script end
        
        function cos_get_route_price(){
            $('.cosFormError-route').remove();
			is_able_to_book = 1;
            $('.cosBookingForm-main .order-price bdi').text('€0.00');
            $('input[name="cos_route_price_total"]').val(0);
			$('#promo_code_field').val('');
            var date_one = $('#cosBookingForm input[name="date_one"]').val();
            var time_one = $('#cosBookingForm input[name="time_one"]').val();
            
            var cos_place_to = $('#cosBookingForm #cos_place_to').val();
             var cos_route_id_one = $('#cosBookingForm input[name="cos_route_id_one"]').val();
            
            if( date_one != '' && cos_place_to != '' && cos_route_id_one != '' ){
                var booking_data = $('#cosBookingForm').serialize();
                loader.show();
                $.ajax({
                    url: cos_booking_object.ajaxurl,
                    data: {action:'cos_api_get_route_price_ajax',booking_data:booking_data},                         
                    type: 'post',
                    success: function(response_){
                        loader.hide();
                        if(response_.status == 0){
							is_able_to_book = 0;
                            $('#cosBookingForm').before('<span class="cosFormError-route" style="color:red;">'+response_.msg+'</span>');
                        }
                        else{
							$('#promo_code_field').val('');
                            $('input[name="cos_route_price_total"]').val(response_.price);
                            $('.cosBookingForm-main .order-price bdi').text('€'+response_.price);
                        }
                    }
                 });
            }
            
        }
		
		function cos_apply_promo_code( promo_code, amount ){
			$('.cos_invalid_promo').remove();
			$('.cos_applied_promo').remove();
			loader.show();
			$.ajax({
				url: cos_booking_object.ajaxurl,
				data: {action:'cos_apply_promo_code_ajax',promo_code:promo_code, amount:amount},                         
				type: 'post',
				success: function(response_){
					loader.hide();
					if( response_.validate){
						$('#promo_code_field').before('<p class="cos_applied_promo">'+response_.msg+'</p>');
						$('input[name="cos_route_price_total"]').val(response_.final_amount);
						$('.cosBookingForm-main .order-price bdi').text('€'+response_.final_amount);
					}
					else{
						$('#promo_code_field').before('<p class="cos_invalid_promo">'+response_.msg+'</p>');
					}
				}
			 });
			
		}
        $('#two').prop('checked', true);
		$('#two').change();
    });
})( jQuery );
