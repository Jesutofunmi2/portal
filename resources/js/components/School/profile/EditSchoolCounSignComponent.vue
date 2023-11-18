<template>
   <div class="row match-height">
		<div class="col-md-12 ">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-tooltip">Update Counsellor Signature</h4>
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

						<form class="form" novalidate @submit.prevent="updateSign">
							<div class="form-body">

								<div v-if="sign && !signPreview">
									<img :src="baseUrl+sign" style="max-width:200px">
								</div>

								<div v-if="signPreview">
									<img :src="signPreview" style="max-width:200px">
								</div>

								<div class="form-group">
									<label for="issueinput25">Counsellor Signature</label>
									<input ref="sign" type="file" @change="onSignChange" :class="{'border-danger':validationErrors.counsellor_sign}" accept="image/*"  class="form-control" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Signature">
									<span v-if="validationErrors.counsellor_sign" :class="['label text-danger']">{{ validationErrors.counsellor_sign[0] }}</span>
										<br />
									<span v-if="signError">
										{{ signError }}
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
				sign : '',
				signPreview : null,
				signError : null,
				validationErrors : [],
				baseUrl:  '/public',
			}
		},
        mounted() {
			this.getSign()
        },

		methods : {
			getSign() {
				this.$loading(true)
				axios.get('/api/school/profile/editcounsign')
				.then((res) => {
					this.sign = res.data.data

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
			
            updateSign() {
				let data = new FormData;
				data.append('counsellor_sign', this.sign)
				
				this.$loading(true)

                axios.post('/api/school/profile/updatecounsign', data)
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
					this.getSign()
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

			onSignChange(e) {

				this.validationErrors.counsellor_sign = null
				let sign = this.$refs.sign.files[0]
				this.sign = sign

				if((sign.type=='image/jpeg') || (sign.type=='image/jpg') || (sign.type=='image/png')) {
					this.showSign(sign)
				} else {
					this.signError = "Invalid Image File"
				}
			},

			showSign(file) {
				let reader = new FileReader();
				reader.onload = (e) => {
					this.signPreview = e.target.result;
				};
				reader.readAsDataURL(file);
			},
		}
    }
</script>