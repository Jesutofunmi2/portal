<template>
   <div class="row match-height">
		<div class="col-md-12 ">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-tooltip">Student Update Password</h4>
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
									
								<h4 class="form-section"><i class="icon-head"></i>Change Password</h4>
								
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label for="projectinput1">Current Password</label>
											<input type="password" @keydown="validationErrors.old_password=null" v-model="old_password" class="form-control" :class="{'border-danger':validationErrors.old_password}" placeholder="Enter Current Password" name="old_password" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Enter Password">
											<span  v-if="validationErrors.old_password" :class="['label text-danger']">{{ validationErrors.old_password[0] }}</span>
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label for="projectinput1">New Password</label>
											<input type="password" @keydown="validationErrors.new_password=null" v-model="new_password" class="form-control" :class="{'border-danger':validationErrors.new_password}" placeholder="Enter New Password" name="new_password" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Enter New Password">
											<span  v-if="validationErrors.new_password" :class="['label text-danger']">{{ validationErrors.new_password[0] }}</span>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="projectinput1">Confirm  Password</label>
											<input type="password" @keydown="validationErrors.confirm_password=null" v-model="confirm_password" :class="{'border-danger':validationErrors.confirm_password}" class="form-control" placeholder="Confirm Password" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Confirm Password">
											<span  v-if="validationErrors.confirm_password" :class="['label text-danger']">{{ validationErrors.confirm_password[0] }}</span>
										</div>
									</div>
									
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
		<FlashMessage></FlashMessage>

	</div>
	
</template>

<script>

    export default {
	components: {
		
		},
		data(){
			return {
				old_password: null,
				new_password: null,
				confirm_password: null,
				validationErrors: []
			}
		},
        mounted() {
			
        },

		methods : {
            changePassword(){
				
				this.$loading(true)

                axios.put('/api/student/password/update', {
					old_password: this.old_password,
					new_password: this.new_password,
					confirm_password: this.confirm_password
				})
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
                    }
				
                })
				.catch(error => {
					this.$loading(false)
					if (!error.response) {
						this.$alert("You do not have internet access","Network Error","error");
						return ;
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
							name: 'student-login',
							params: { return_url: return_url }
							});
					}

					if(error.response.status === 400){
						this.$alert(error.response.data.data.message,"Error","error");
					}
					
				});
            }
		}
    }
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>