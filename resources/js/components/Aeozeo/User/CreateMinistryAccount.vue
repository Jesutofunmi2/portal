<template>
   <div class="row match-height">
		<!-- Striped rows start -->
<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Create Ministry Account</h4>
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

						<form class="form" novalidate @submit.prevent="createAdmin">
							<div class="row form-body">

								<div class="form-group col-md-6">
									<label for="issueinput8">Full Name</label>
									<input type="text" @keydown="validationErrors.fullname=null" :class="{'border-danger':validationErrors.fullname}" v-model="admin.fullname" class="form-control"  placeholder="Enter Full Name" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Enter Full Name">
									<span  v-if="validationErrors.fullname" :class="['label text-danger']">{{ validationErrors.fullname[0] }}</span>
								</div>

								<div class="form-group col-md-6">
									<label for="issueinput8">Email</label>
									<input type="email" @keydown="validationErrors.email=null" :class="{'border-danger':validationErrors.email}" v-model="admin.email" class="form-control"  placeholder="Enter Email" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Enter Email">
									<span  v-if="validationErrors.email" :class="['label text-danger']">{{ validationErrors.email[0] }}</span>
								</div>

								<div class="form-group col-md-6">
									<label for="issueinput8">Username</label>
									<input type="text" @keydown="validationErrors.username=null" :class="{'border-danger':validationErrors.username}" v-model="admin.username" class="form-control"  placeholder="Enter Username" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Enter Username">
									<span  v-if="validationErrors.username" :class="['label text-danger']">{{ validationErrors.username[0] }}</span>
								</div>

								<div class="form-group col-md-6">
									<label for="issueinput8">Phone</label>
									<input type="text" @keydown="validationErrors.phone=null" :class="{'border-danger':validationErrors.phone}" v-model="admin.phone" class="form-control"  placeholder="Enter Phone Number" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Enter Phone Number">
									<span  v-if="validationErrors.phone" :class="['label text-danger']">{{ validationErrors.phone[0] }}</span>
								</div>

								<div class="form-group col-md-6">
									<label for="issueinput8">Password</label>
									<input type="password" @keydown="validationErrors.password=null" :class="{'border-danger':validationErrors.password}" v-model="admin.password" class="form-control"  placeholder="Enter Password" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Enter Password">
									<span  v-if="validationErrors.password" :class="['label text-danger']">{{ validationErrors.password[0] }}</span>
								</div>

								<div class="form-group col-md-6">
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
                    fullname : null,
                    username : null,
                    email : null,
                    phone : null,
                    password : null,
                    password_confirmation : null,
                },
               validationErrors : [],
			}
		},
        mounted() {
         
        },

		methods : {
          
            createAdmin(){
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

                axios.post('/api/ministry/user/create',data)
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
					if (error.response.status == 409){
					this.flashMessage.error({title: 'Registration Error', 
											message: error.response.data.message,
											time: 15000, });
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

