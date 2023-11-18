@extends('layouts.auth')
@section('title')
	CAS Reset Password
@endsection
@section('content')
<div  class="card-header no-border">
    <div class="card-title text-xs-center">
        <div class="p-1"><img src="{{ env('BASE_PATH') }}{{ env('SITE_LOGO_URL') }}" style="max-width: 100px; max-height: 100px;" alt="branding logo"></div>
    </div>
    <h6 class="card-subtitle line-on-side text-muted text-xs-center font-small-3 pt-2"><span>Ministry Reset Password</span></h6>
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
	

			<fieldset class="form-group position-relative has-icon-left mb-0">
				<input type="text" class="form-control form-control-lg input-lg" id="username" placeholder="Enter your username" name="username" value="" required autofocus>
				<div class="form-control-position">
					<i class="icon-user"></i>
				</div>
				
			</fieldset>
		
			<fieldset class="form-group row">
				<span class="invalid-feedback">
					<strong class="text-danger" id="error"></strong>
				</span>
				
			</fieldset>
			<button type="button" style="background-color: #{{ env('APP_COLOR')}}; color:#fff" onclick="sendMail()" id="login_btn" class="btn btn-lg btn-block"><i class="icon-link"></i> Send Reset Link</button>

	</div>
	
  </div>
<script type="text/javascript">
	function sendMail(){
		$("#error").html('');
		let username = $('#username').val();
		let _token = '{{ csrf_token() }}';
		if(username =='') {
			$("#error").html('Username can not be empty');
			return;
		}
		$('#login_btn').text('Loading...');
		
		$.ajax({
                    url: "{{ route('ministry_forget_password') }}",
                    type:"POST",
                    data:{
                        username : username,
                        _token : _token,
                    },
                    success:function(response){
                    	//console.log(response);
						if(response) {
							$("#error").html(response['message']);
							$('#login_btn').text('Send Reset Link');
						}
                    },
					error:function(XMLHttpRequest,textStatus,errorThrown){
						//console.log(XMLHttpRequest);
						var response = XMLHttpRequest.responseJSON;
						let responseCode = XMLHttpRequest.status;

						if (responseCode == 400) {
							$("#error").html(response['message']);
						}
						if (responseCode == 419) {
							$("#error").html(response['message']);
							window.location = '{{ route("ministry_forget_password") }}';
						}
						else {
							$("#error").html(response['message']);
						}
						$('#login_btn').text('Send Reset Link');
						
        			}
         });
	}

	
</script>
@endsection