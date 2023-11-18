$(function(){
	Verification.payWithPaystack();
	$('#paymentAlert').slideUp('fast');
	$('#paymentAlert').html('');
	Verification.form.removeClass('hidden');
	Verification.payWithPaystack();
});


const Verification = {
	form: $('.verificationForm'),

	makePayment: function(reference, btn, oldBtn, message){
		var token, url;
		token = Verification.form.attr('data-token');
		url = $('span.user-data').attr('data-submit');
		$.ajax({
			url: url,
			type: 'POST',
			data: {_token: token, ref: reference},
			dataType: "json",
			success: function(res){
				if(res.status && res.status == true){
	                btn.html('Paid <i class="fa fa-check ml-2"></i>');
	                message.html('Congratulations '+res.data.surname.toUpperCase()+' '+res.data.firstname.toUpperCase()+', Your account has been activated.');
	                message.removeClass('red'); message.removeClass('yellow'); message.addClass('green');
	                message.slideDown('fast');
					setTimeout(function(){
						window.location = $('.redirect-to').attr('data-url');
					}, 5000);
				}else{
			    	btn.removeAttr('disabled');
	                btn.html(oldBtn);

                    message.html(res.message);
                    message.removeClass('yellow'); message.removeClass('green'); message.addClass('red');
                    message.slideDown('fast');
				}
			},
			error: function(err){
		    	btn.removeAttr('disabled');
                btn.html(oldBtn);

                message.html('Opps, something went wrong');
                message.removeClass('yellow'); message.removeClass('green'); message.addClass('red');
                message.slideDown('fast');
			}
		});
	},

	payWithPaystack: function(){
  		Verification.form.submit(function(e){
			e.preventDefault();
			
			var btn, oldBtn, userUsername, userEmail, userPhone, userFullname, handler, message;
        	btn = $(this).find('button[type=submit]');
        	message = $('#paymentAlert');
        	oldBtn = btn.html();
        	userUsername = $('span.user-data').attr('data-username');
        	userEmail = $('span.user-data').attr('data-email');
        	userPhone = $('span.user-data').attr('data-phone');
        	userFullname = $('span.user-data').attr('data-fullname');

        	btn.html('<i class="ui active mini centered inline loader inverted"></i>');
			btn.attr('disabled', 'disabled');
            
			handler = PaystackPop.setup({
			    key: pk_test_4nc9wbc9wbcyw97wt99e86e86q880q9e038683q6yd88,
			    email: userEmail,
			    amount: 140000,
			    currency: "NGN",
			    ref: 'odsgmoe-'+Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
			    metadata: {
			        custom_fields: [
			            {
			                display_name: userUsername,
			                variable_name: userFullname,
			                value: userPhone
			            }
			         ]
			    },
			    callback: function(res){
		        	if (res.status != 'success') {
	                    btn.removeAttr('disabled');
	                    btn.html(oldBtn);
	                   	
    	                message.html(res.message);
    	                message.removeClass('green'); message.removeClass('yellow'); message.addClass('red');
    	                message.slideDown('fast');
					}else{
	                    btn.html('Processed <i class="fa fa-check ml-2"></i>');
	                   	
    	                message.html('Verifying Payment...');
    	                message.removeClass('red'); message.removeClass('yellow'); message.addClass('green');
    	                message.slideDown('fast');
	                    setTimeout(function(){
        	                message.html('Please wait...');
        	                message.removeClass('green'); message.removeClass('red'); message.addClass('yellow');
        	                message.slideDown('fast');
	                    }, 5000);
	                    Verification.makePayment(res.reference, btn, oldBtn, message);
					}
			    },
			    onClose: function(){
			    	btn.removeAttr('disabled');
	                btn.html(oldBtn);

	                message.html('Please complete payment to verify your account');
	                message.removeClass('green'); message.removeClass('yellow'); message.addClass('red');
	                message.slideDown('fast');
			     }
		    });
		    handler.openIframe();
  		});
	}
}

