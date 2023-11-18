@extends('layouts.auth')
@section('title')
	Student Login
@endsection
@section('content')
<div class="card-header no-border">
    <div class="card-title text-xs-center">
        <div class="p-1"><img src="{{ env('BASE_PATH') }}{{ env('SITE_LOGO_URL') }}" style="max-width: 100px; max-height: 100px;" alt="branding logo"></div>
    </div>
    <h6 class="card-subtitle line-on-side text-muted text-xs-center font-small-3 pt-2"><span>Student Login</span></h6>
</div>
<div class="card-body collapse in">
	<div id="login-form" class="card-block">
	

			<fieldset class="form-group position-relative has-icon-left mb-0">
				<input type="text" class="form-control form-control-lg input-lg" id="regnum" placeholder="Enter OSSI Number" name="regnum" value="{{old('regnum') }}" required autofocus>
				<div class="form-control-position">
					<i class="icon-head"></i>
				</div>
				@if ($errors->has('regnum'))
					<span class="invalid-feedback">
						<strong>{{ $errors->first('regnum') }}</strong>
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
					<strong id="error"></strong>
				</span>
				
			</fieldset>
			<button type="button" style="background-color: #{{ env('APP_COLOR')}}; color:#fff" onclick="loginUser()" id="login_btn" class="btn btn-lg btn-block"><i class="icon-unlock2"></i> Login</button>

	</div>
	
  </div>
<script type="text/javascript">
	
	function loginUser(){
		$("#error").html('');
		let regnum=$('#regnum').val();
		let password=$('#password').val();
		let _token='{{ csrf_token() }}';
		$('#login_btn').text('Loading...');
		$.ajax({
                    url: "{{ route('student_login_page_post') }}",
                    type:"POST",
                    data:{
                        regnum:regnum,
                        password:password,
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
						$("#error").html(response['message']);
						$('#login_btn').text('Login');
        			}
                });
	}

	function apiLogin(){
		$("#otp-error").html('');
		let regnum=$('#regnum').val();
		let password=$('#password').val();
		if(regnum=='' || password=='') {
			$("#otp-error").html('Unknown Error Occur, please refresh this page');
			return;
		}
		
		$.ajax({
                    url: "{{ route('student_api_login') }}",
                    type:"POST",
                    data:{
                        regnum:regnum,
                        password:password,
                    },
                    success:function(response){
                    	//console.log(response);
						
                    if(response) {
					
						localStorage.setItem('user', JSON.stringify(response['token']));
						localStorage.setItem('raw_password', response['raw_password']);
						
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