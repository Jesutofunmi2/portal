<template>
   <div class="row match-height">
		<div class="col-md-12 ">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-tooltip">Update School Logo</h4>
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

						<form class="form" novalidate @submit.prevent="updateLogo">
							<div class="form-body">

								<div v-if="logo && !logoPreview">
									<img :src="baseUrl+logo" style="max-width:200px">
								</div>

								<div v-if="logoPreview">
									<img :src="logoPreview" style="max-width:200px">
								</div>

								<div class="form-group">
									<label for="issueinput25">Logo</label>
									<input ref="logo" type="file" @change="onLogoChange" :class="{'border-danger':validationErrors.logo}" accept="image/*"  class="form-control" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Logo">
									<span v-if="validationErrors.logo" :class="['label text-danger']">{{ validationErrors.logo[0] }}</span>
										<br />
									<span v-if="logoError">
										{{ logoError }}
									</span>
								</div>

							</div>

							<div class="form-actions">
								<button type="button" class="btn btn-warning mr-1">
									<i class="icon-cross2"></i> Cancel
								</button>
								<button type="submit" class="btn btn-primary">
									<i class="icon-check2"></i> Update
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

		data() {
			return {
				logo : '',
				logoPreview : null,
				logoError : null,
				validationErrors : [],
				baseUrl:  '/public',
			}
		},
        mounted() {
			this.getLogo()
        },

		methods : {
			getLogo() {
				this.$loading(true)
				axios.get('/api/school/profile/editlogo')
				.then((res) => {
					this.logo = res.data.data

					this.$loading(false)
				})
				.catch((error) => {
                    this.$loading(false);
					if (!error.response) {
						this.$alert("You do not have internet access","Network Error","error");
						return ;
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
				})
			},
			
            updateLogo() {
				let data = new FormData;
				data.append('logo', this.logo)
				
				this.$loading(true)

                axios.post('/api/school/profile/updatelogo', data)
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
					this.getLogo()
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

			onLogoChange(e) {

				this.validationErrors.logo = null
				let logo = this.$refs.logo.files[0]
				this.logo = logo

				if((logo.type=='image/jpeg') || (logo.type=='image/jpg') || (logo.type=='image/png')) {
					this.showLogo(logo)
				} else {
					this.logoError = "Invalid Image File"
				}
			},

			showLogo(file) {
				let reader = new FileReader();
				reader.onload = (e) => {
					this.logoPreview = e.target.result;
				};
				reader.readAsDataURL(file);
			},
		}
    }
</script>