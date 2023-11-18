@extends('layouts.auth')
@section('title')
	Liberian Reset Password
@endsection
@section('content')
<div  class="card-header no-border">
    <div class="card-title text-xs-center">
        <div class="p-1"><img src="{{ env('BASE_PATH') }}{{ env('SITE_LOGO_URL') }}" style="max-width: 100px; max-height: 100px;" alt="branding logo"></div>
    </div>
    <h6 class="card-subtitle line-on-side text-muted text-xs-center font-small-3 pt-2"><span>Liberian Reset Password</span></h6>
		@if(session('success'))
			<div class="col-md-12 alert alert-success mb-2" role="alert">
				{{ session('success') }}
			</div>
		@endif
		@if(session('errors'))
				@foreach ($errors->all() as $error)
					<div class="col-md-12 alert alert-danger mb-2" role="alert">
						{{ $error }}
					</div>
				@endforeach
			
		@endif
</div>
<div class="card-body collapse in">
	<div id="login-form" class="card-block">
	
		<fieldset class="form-group position-relative has-icon-left">
			<input type="text" class="form-control form-control-lg input-lg" readonly value="{{ $username }}" placeholder="Username">
			<div class="form-control-position">
				<i class="icon-user"></i>
			</div>
		</fieldset>
		<fieldset class="form-group position-relative has-icon-left">
			<input type="password" class="form-control form-control-lg input-lg" id="password" placeholder="Enter New Password">
			<div class="form-control-position">
				<i class="icon-key3"></i>
			</div>
		</fieldset>
		<fieldset class="form-group position-relative has-icon-left">
			<input type="password" class="form-control form-control-lg input-lg" id="confirm-password" placeholder="Confirm New Password">
			<div class="form-control-position">
				<i class="icon-key3"></i>
			</div>
		</fieldset>
		
			<fieldset class="form-group row">
				<span class="invalid-feedback">
					<strong class="text-danger" id="error"></strong>
				</span>
				
			</fieldset>
			<button type="button" style="background-color: #{{ env('APP_COLOR')}}; color:#fff" onclick="resetPassword()" id="login_btn" class="btn btn-lg btn-block"><i class="icon-check"></i> Submit</button>

	</div>
	
  </div>
<script type="text/javascript">
	function resetPassword(){
		$("#error").html('');
		let password = $('#password').val();
		let c_password = $('#confirm-password').val();
		let email = '{{ $email }}';
		let reset_token = '{{ $reset_token }}';
		let _token = '{{ csrf_token() }}';
		if(password == '' || c_password == '') {
			$("#error").html('All fields are required');
			return;
		}
		if(password != c_password) {
			$("#error").html('Password must be match');
			return;
		}
		
		$('#login_btn').text('Loading...');
		
		$.ajax({
                    url: "{{ route('liberian_set_password') }}",
                    type:"POST",
                    data:{
                        email : email,
						reset_token : reset_token,
						password : password,
						password_confirmation : c_password,
                        _token : _token,
                    },
                    success:function(response){
                    	//console.log(response);
						if(response) {
							$("#error").html(response['message']);
							window.location = '{{ route("liberian_login_page") }}';
						}
                    },
					error:function(XMLHttpRequest,textStatus,errorThrown){
						//console.log(XMLHttpRequest);
						var response = XMLHttpRequest.responseJSON;
						let responseCode = XMLHttpRequest.status;

						if (responseCode == 422) {
							$("#error").html(response['errors']);
						}
						if (responseCode == 400) {
							$("#error").html(response['message']);
						}
						if (responseCode == 419) {
							$("#error").html(response['message']);
							window.location = '{{ route("liberian_forget_password") }}';
						}
						else {
							$("#error").html(response['message']);
						}
						$('#login_btn').text('Submit');
						
        			}
         });
	}

	
</script>
@endsection