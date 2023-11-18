$(function(){
	Verification.payWithPaystack();
});


const Verification = {
	form: $('.verificationForm'),

	makePayment: function(reference, btn, oldBtn){
		var token, url;
		token = $('#app').attr('data-token');
		url = $('span.user-data').attr('data-submit');
		$.ajax({
			url: url,
			type: 'POST',
			data: {_token: token, ref: reference},
			dataType: "json",
			success: function(res){
				if(res.data.status == true){
	                btn.html('Paid <i class="fa fa-check ml-2"></i>');
	                alert('Congratulations '+res.data.data.customer.email+', Your account has been activated.');
					setTimeout(function(){
	                	alert('Please wait...');
					}, 2000);
					setTimeout(function(){
						window.location = '/community';
					}, 5000);
				}else{
			    	btn.removeAttr('disabled');
	                btn.html(oldBtn);
	                alert(res.message);
				}
			},
			error: function(err){
		    	btn.removeAttr('disabled');
                btn.html(oldBtn);
                alert('Opps, something went wrong');
			}
		});
	},

	payWithPaystack: function(){
  		Verification.form.submit(function(e){
			e.preventDefault();
			
			alert('this feature is unavailable try later');
			return false;
			
			var btn, oldBtn, userUsername, userEmail, userPhone, userFullname, handler;
        	btn = $(this).find('button[type=submit]');
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
			    amount: 14000,
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
	                   	alert(res.message);
					}else{
	                    btn.html('Processed <i class="fa fa-check ml-2"></i>');
	                   	Helper.success('Verifying Payment...');
	                    setTimeout(function(){
	                    	alertify.warning('Please wait...');
	                    }, 1000);
	                    Verification.makePayment(res.reference, btn, oldBtn);
					}
			    },
			    onClose: function(){
			    	btn.removeAttr('disabled');
	                btn.html(oldBtn);
                    alert('Please complete payment to verify your account');
			     }
		    });
		    handler.openIframe();
  		});
	}
}

