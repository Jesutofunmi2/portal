@extends('layouts.auth')
@section('title')
	Ministry Email Verification
@endsection
@section('content')
<div  class="card-header no-border">
    <div class="card-title text-xs-center">
        <div class="p-1"><img src="{{ env('BASE_PATH') }}{{ env('SITE_LOGO_URL') }}" style="max-width: 100px; max-height: 100px;" alt="branding logo"></div>
    </div>
    <h6 class="card-subtitle line-on-side text-muted text-xs-center font-small-3 pt-2"><span>Ministry Email Verification</span></h6>
	<h6 class="card-subtitle text-muted text-xs-center"><span>Welcome {{ $user['firstname'] }}, please continue to verify your email. You can provide new email if this is no longer accessible. </span></h6>
</div>
<div class="card-body collapse in">
	<div id="login-form" class="card-block">
	

			<fieldset class="form-group position-relative has-icon-left mb-0">
				<input type="email" class="form-control form-control-lg input-lg" id="email" placeholder="Enter your email" name="username" value="{{ $user['email'] }}" required autofocus>
				<div class="form-control-position">
					<i class="icon-mail"></i>
				</div>
				
			</fieldset>
		
			<fieldset class="form-group row">
				<span class="invalid-feedback">
					<strong class="text-danger" id="error"></strong>
				</span>
				
			</fieldset>
			<button type="button" style="background-color: #{{ env('APP_COLOR')}}; color:#fff" onclick="sendMail()" id="login_btn" class="btn btn-lg btn-block"><i class="icon-link"></i> Send Verification Link</button>

	</div>
	
  </div>
<script type="text/javascript">
	function sendMail(){
		$("#error").html('');
		let email = $('#email').val();
		let user_id = '{{ $user["id"] }}';
		let _token = '{{ csrf_token() }}';
		if(email =='') {
			$("#error").html('Email can not be empty');
			return;
		}
		$('#login_btn').text('Loading...');
		
		$.ajax({
                    url: "{{ route('teacherEmailVerification') }}",
                    type:"POST",
                    data:{
						user_id : user_id,
                        email : email,
                        _token : _token,
                    },
                    success:function(response){
                    	//console.log(response);
						if(response) {
							$("#error").html(response['message']);
							$('#login_btn').text('Send Verification Link');
						}
                    },
					error:function(XMLHttpRequest,textStatus,errorThrown){
						//console.log(XMLHttpRequest);
						var response = XMLHttpRequest.responseJSON;
						let responseCode = XMLHttpRequest.status;

						if (responseCode == 422) {
							$("#error").html(response['errors'].email);
						}
						else if (responseCode == 400) {
							$("#error").html(response['message']);
							window.location = '{{ route("teacherUpdateEmail") }}';
						}
						else if (responseCode == 419) {
							$("#error").html(response['message']);
							window.location = '{{ route("teacherUpdateEmail") }}';
						}
						else {
							$("#error").html(response['message']);
						}
						$('#login_btn').text('Send Verification Link');
						
        			}
         });
	}

	
</script>
@endsection