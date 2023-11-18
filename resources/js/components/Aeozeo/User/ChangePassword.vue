<template>
   <div class="row match-height">
		<!-- Striped rows start -->
<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Change Password</h4>
                <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="collapse"><i class="icon-minus4"></i></a></li>
                        <li><a data-action="reload"><i class="icon-reload"></i></a></li>
                        <li><a data-action="expand"><i class="icon-expand2"></i></a></li>
                        <li><a data-action="close"><i class="icon-cross2"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="card-body collapse in">
                <div class="card-block">
                    <form class="form" novalidate @submit.prevent="changePassword">
							<div class="form-body">

								<div class="form-group">
									<label for="issueinput8">Current Password</label>
									<input type="password" @keydown="validationErrors.current_password=null" :class="{'border-danger':validationErrors.current_password}" v-model="admin.current_password" class="form-control"  placeholder="Enter Current Password" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Enter Current Password">
									<span  v-if="validationErrors.current_password" :class="['label text-danger']">{{ validationErrors.current_password[0] }} <br /></span>
                                    <span  v-if="current_password_error" :class="['label text-danger']">{{ current_password_error }}</span>

								</div>

								<div class="form-group">
									<label for="issueinput8">Password</label>
									<input type="password" @keydown="validationErrors.password=null" :class="{'border-danger':validationErrors.password}" v-model="admin.password" class="form-control"  placeholder="Enter Password" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Enter Password">
									<span  v-if="validationErrors.password" :class="['label text-danger']">{{ validationErrors.password[0] }}</span>
								</div>

								<div class="form-group">
									<label for="issueinput8">Confirm Password</label>
									<input type="password" @keydown="validationErrors.password_confirmation=null" :class="{'border-danger':validationErrors.password_confirmation}" v-model="admin.password_confirmation" class="form-control"  placeholder="Confirm Password" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Confirm Password">
									<span  v-if="validationErrors.password_confirmation" :class="['label text-danger']">{{ validationErrors.password_confirmation[0] }}</span>
								</div>

							</div>

							<div class="form-actions">
								<button type="button" class="btn btn-warning mr-1">
									<i class="icon-cross2"></i> Cancel
								</button>
								<button type="submit" class="btn btn-primary">
									<i class="icon-check2"></i> Save
								</button>
							</div>
						</form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Striped rows end -->
		<FlashMessage></FlashMessage>

	</div>
	
</template>

<script>

    export default {

		data(){
			return {
               admin : {
                   current_password : null,
                   password : null,
                   password_confirmation : null,
               },
               validationErrors : [],
               current_password_error : null,
			}
		},
        mounted() {
         
        },

		methods : {
           changePassword(){
               this.current_password_error = null;
               let data = new FormData;
				const obj = this.admin;
				Object.keys(obj).forEach(key=>{
					
					if(obj[key] == null){
						data.append(key, "");
					}
					else{
						data.append(key, obj[key]);
					}
					
				});
	
				this.$loading(true)

                axios.post('/api/ministry/user/password/change',data)
				.then(response => {
                    if(response) {
						this.$loading(false)
                        this.flashMessage.success({
                            title: 'Successful',
                            message: response.data.data.message,
                            time: 15000,
                            flashMessageStyle: {
                                backgroundColor: 'linear-gradient(#e66465, #9198e5)'
                            }
                        });
						Object.keys(this.admin).forEach(key=>{
							this.admin[key] = null;
						});
	
                    }
				
                })
				.catch(error => {
					this.$loading(false)
					if (!error.response) {
						this.$alert("You do not have internet access or Unknown Error","Network Error","error");
						return ;
					}
					if (error.response.status == 400){
					    this.flashMessage.error({title: 'Password Error', 
											message: error.response.data.data.message,
											time: 15000, });
                        this.current_password_error = error.response.data.data.message;
					}

					if (error.response.status == 422){
					    this.validationErrors = error.response.data.errors;
					    this.flashMessage.error({title: 'Validation Error', 
											message: 'Their is Error with the Data you supplied',
											time: 15000, });
					}

					if(error.response.status === 401){
						let return_url = window.location.pathname;
						this.$router.push({
							name: "aeo_zeo-login",
							params: { return_url: return_url }
							});
					}
					if(error.response.status === 403){
						this.$alert("Sorry, you do not have the permission to perfrom this action","No Permission","error");
					}
					
				});
           },
           
		}
    }
</script>

