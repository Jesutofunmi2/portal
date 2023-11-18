@extends('layouts.auth')
@section('title')
	Burser Login
@endsection
@section('content')
<div class="card-header no-border">
    <div class="card-title text-xs-center">
        <div class="p-1"><img src="{{ env('BASE_PATH') }}{{ env('SITE_LOGO_URL') }}" style="max-width: 100px; max-height: 100px;" alt="branding logo"></div>
    </div>
    <h6 class="card-subtitle line-on-side text-muted text-xs-center font-small-3 pt-2"><span>Burser Login</span></h6>
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
				<input type="text" class="form-control form-control-lg input-lg" id="username" placeholder="Your Username" name="username" value="{{old('username') }}" required autofocus>
				<div class="form-control-position">
					<i class="icon-head"></i>
				</div>
				@if ($errors->has('username'))
					<span class="invalid-feedback">
						<strong>{{ $errors->first('username') }}</strong>
					</span>
        		@endif
			</fieldset>
			<fieldset class="form-group position-relative has-icon-left">
				<input type="password" class="form-control form-control-lg input-lg" id="password" placeholder="Enter Password" name="password" required autocomplete="current-password">
				<div class="form-control-position">
					<i class="icon-key3"></i>
				</div>
				@error('password')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
			</fieldset>
			<fieldset class="form-group row">
				<span class="invalid-feedback">
					<strong class="text-danger" id="error"></strong>
				</span>
				
			</fieldset>
			<button type="button" onclick="sendOTP()" id="login_btn" style="background-color: #{{ env('APP_COLOR')}}; color:#fff" class="btn btn-lg btn-block"><i class="icon-unlock2"></i> Login</button>
			<br>
			<a href="{{ route('burser_forget_password') }}">Forget Password?</a>

	</div>
	<div id="otp-form" class="hidden">
	

		<fieldset class="form-group position-relative has-icon-left">
			<input type="text" class="form-control form-control-lg input-lg" id="otp" placeholder="Enter OTP" name="otp" required >
			<div class="form-control-position">
				<i class="icon-key3"></i>
			</div>
		</fieldset>
		<fieldset class="form-group row">
			<span class="invalid-feedback">
				<strong class="text-danger" id="otp-error"></strong>
			</span>
			<div class="hidden" id='timer'><span id="count">0</span> seconds to resend OTP</div>
			<button class="hidden" id="resend-otp" onclick="sendOTP()" type="button">Resend OTP</button>

		</fieldset>
		<button type="button" onclick="loginUser()" style="background-color: #{{ env('APP_COLOR')}}; color:#fff" id="login_otp_btn" class="btn btn-lg btn-block"><i class="icon-unlock2"></i> Continue</button>
		
</div>
  </div>
  <script type="text/javascript">
	function sendOTP(){
		$("#error").html('');
		let username=$('#username').val();
		let password=$('#password').val();
		let _token='{{ csrf_token() }}';
		if(username=='' || password=='') {
			$("#error").html('Username and Password can not be empty');
			return;
		}
		$('#login_btn').text('Loading...');
		$('#count').text(0);
		
		$.ajax({
                    url: "{{ route('burser_login_otp') }}",
                    type:"POST",
                    data:{
                        username:username,
                        password:password,
                        _token:_token,
                    },
                    success:function(response){
						$('#login-form').attr('class','hidden');
						$('#otp-form').attr('class','card-block');
						$("#otp-error").html(response['message']);
						$('#count').text(120);
                    	//console.log(response);
                    if(response) {
						$("#error").html(response['message']);
						$('#resend-otp').attr('class','hidden');
                    }
                    },
					error:function(XMLHttpRequest,textStatus,errorThrown){
						//console.log(XMLHttpRequest);
						var response = XMLHttpRequest.responseJSON;
						let responseCode = XMLHttpRequest.status;
						if (responseCode == 400){
							$("#error").html(response['message'] + " you will be redirected to email verification page");
							window.location = '{{ route("burserUpdateEmail") }}';
						}
					
						$("#error").html(response['message']);
						$('#login_btn').text('Login');
						
        			}
                });
	}

	function loginUser(){
		$("#otp-error").html('');
		let username=$('#username').val();
		let password=$('#password').val();
		let otp=$('#otp').val();
		let _token='{{ csrf_token() }}';
		if(username=='' || password=='') {
			$("#otp-error").html('Unknown Error Occur, please refresh this page');
			return;
		}
		if(otp=='') {
			$("#otp-error").html('OTP Field can not be empty');
			return;
		}
		$('#login_otp_btn').text('Loading...');
		$.ajax({
                    url: "{{ route('burser_login_page_post') }}",
                    type:"POST",
                    data:{
                        username:username,
                        password:password,
						otp:otp,
                        _token:_token,
                    },
                    success:function(response){
                    	//console.log(response);
						
                    if(response) {
						apiLogin();
                    }
                    },
					error:function(XMLHttpRequest,textStatus,errorThrown){
						//console.log(XMLHttpRequest);
						var response=XMLHttpRequest.responseJSON;
						$("#otp-error").html(response['message']);
						$('#count').text(0);
						$('#resend-otp').attr('class','btn btn-secondary');
						$('#login_otp_btn').text('Continue');
						$('#timer').attr('class','hidden');
        			}
                });
	}
	window.onload=function(){
		setInterval(() => {
			var left=$('#count').text();
			if(left > 0){
				$('#timer').attr('class','');
				left--;
				$('#count').text(left);
				
				if(left==0){
					$('#resend-otp').attr('class','btn btn-secondary');
					$('#timer').attr('class','hidden');
					$("#otp-error").html('');
				}
			}
		}, 1000);
	}

	function apiLogin(){
		$("#otp-error").html('');
		let username=$('#username').val();
		let password=$('#password').val();
		if(username=='' || password=='') {
			$("#otp-error").html('Unknown Error Occur, please refresh this page');
			return;
		}
		if(otp=='') {
			$("#otp-error").html('OTP Field can not be empty');
			return;
		}
		$.ajax({
                    url: "{{ route('burser_api_login') }}",
                    type:"POST",
                    data:{
                        username:username,
                        password:password,
                    },
                    success:function(response){
                    	//console.log(response);
						
                    if(response) {
					
						localStorage.setItem('user', JSON.stringify(response['token']));
						
						window.location = response['url'];
					
                    	}
                    },
					error:function(XMLHttpRequest,textStatus,errorThrown){
						//console.log(XMLHttpRequest);
						var response=XMLHttpRequest.responseJSON;
						$("#otp-error").html(response['message']);
        			}
                });
	}
	
</script>
@endsection