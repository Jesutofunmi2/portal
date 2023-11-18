<template>
   <div>
        <div  class="card-header no-border">
    
    <h6 class="card-subtitle line-on-side text-muted text-xs-center font-small-3 pt-2"><span>Dear {{  $user.fullname }}, Please Enter Login Details to continue activity.</span></h6>
    <div class="login-page">

            
			<fieldset class="form-group position-relative has-icon-left mb-0">
				<input type="text" v-model="username" class="form-control form-control-lg input-lg" id="username" placeholder="Your Username" name="username" required autofocus>
				<div class="form-control-position">
					<i class="icon-head"></i>
				</div>
			</fieldset>

            <p/>
			<fieldset class="form-group position-relative has-icon-left">
				<input type="password" v-model="password" class="form-control form-control-lg input-lg" id="password" placeholder="Enter Password" name="password" required autocomplete="current-password">
				<div class="form-control-position">
					<i class="icon-key3"></i>
				</div>	
                  
			</fieldset>
                    <div v-if="error_message" class="alert alert-danger">
                        {{ error_message }}
                    </div>
		
			<button @click="loginUser" type="button" id="login_btn" style=" background:#1d2b36; color:#eee;" class="btn btn-lg btn-dark btn-block"><i class="icon-unlock2"></i> Login</button>

        </div>
</div>
<div class="card-body collapse in">
	<div id="login-form" class="card-block">
        
	

	</div>

  </div>
   </div>

</template>

<script>
export default {

    data(){
        return {
            username: '',
            password : '',
            error_message : ''
        }

    },
    mounted(){
     
    },

    methods:{
        loginUser(){
           
             if(this.username==null || this.username=='' || this.password==null || this.password==''){
                 this.error_message = 'Username and Password is required';
                 return;
             }
            this.$loading(true);
            let data = new FormData;
			data.append('username', this.username);
            data.append('password', this.password);
			
				axios.post('/api/parent/login',data)
				.then((res) => {
                    localStorage.setItem('user', JSON.stringify(res.data.token));
                    this.$loading(false)	
                    //this.$router.push(this.$route.params.return_url);
                    window.location = this.$route.params.return_url;
                    
				})
				.catch((error) => {
					this.$loading(false)
                    if (!error.response) {
						this.$alert("You do not have internet access","Network Error","error");
						return ;
					}
					if(error.response.status === 401){
						this.error_message = error.response.data.message
					}
				});
        }
    } 
}
</script>

<style scoped>
.login-page {
    width:60%;
    margin: 0px auto 0px;
}
</style>