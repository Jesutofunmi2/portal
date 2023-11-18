<template>
   <div class="row match-height">
		<div class="col-md-12 ">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-tooltip">Change My Password</h4>
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

								<div class="form-group col-md-6">
									<label for="issueinput5">New Password</label>
									<input id="issueinput5" type="password" @keydown="validationErrors.password=null" :class="{'border-danger':validationErrors.password}" v-model="password" class="form-control"  placeholder="Enter Password" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Enter Password">
									<span  v-if="validationErrors.password" :class="['label text-danger']">{{ validationErrors.password[0] }}</span>
								</div>

								<div class="form-group col-md-6">
									<label for="issueinput6">Confirm New Password</label>
									<input id="issueinput6" type="password" @keydown="validationErrors.password_confirmation=null" :class="{'border-danger':validationErrors.password_confirmation}" v-model="password_confirmation" class="form-control"  placeholder="Confirm Password" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Confirm Password">
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
		<FlashMessage></FlashMessage>

	</div>
	
</template>

<script>

    export default {

		data(){
			return {
				password : '',
				password_confirmation :'',
				validationErrors: [],
				
			}
		},
        mounted() {
        },

		methods : {
            changePassword() {
				let data = new FormData;
				data.append('password', this.password);
				data.append('password_confirmation', this.password_confirmation);
				
				this.$loading(true)

                axios.post('/api/school/profile/changepass',data)
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
					this.password = null;
					this.password_confirmation = null;
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
											message: 'There is an Error with the Data you supplied',
											time: 15000, });
					}
					if(error.response.status === 401){
						let return_url = window.location.pathname;
						this.$router.push({
							name: 'school-login',
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
