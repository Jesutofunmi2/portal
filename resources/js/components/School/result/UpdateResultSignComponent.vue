<template>
   <div class="row match-height">
		<div class="col-md-12 ">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-tooltip">Update Result Signatures</h4>
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

								<div class="pl-1" v-if="sign && !signPreview">
									<img :src="baseUrl+sign" style="max-width:200px">
								</div>

								<div class="pl-1" v-if="signPreview">
									<img :src="signPreview" style="max-width:200px">
								</div>

								<div class="form-group pl-1 pr-1">
									<label for="issueinput25">Principal Signature</label>
									<input ref="sign" type="file" @change="onSignChange" :class="{'border-danger':validationErrors.principal_sign}" accept="image/*"  class="form-control" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Signature">
									<span v-if="validationErrors.principal_sign" :class="['label text-danger']">{{ validationErrors.principal_sign[0] }}</span>
										<br />
									<span v-if="signError">
										{{ signError }}
									</span>
								</div>

								<div class="form-group col-md-6">
									<label for="issueinput38">Principal Name</label>
									<input type="text" @keydown="validationErrors.principal_name=null" :class="{'border-danger':validationErrors.principal_name}" v-model="principal_name" class="form-control"  placeholder="Enter Principal Name" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Enter Principal Name">
									<span  v-if="validationErrors.principal_name" :class="['label text-danger']">{{ validationErrors.principal_name[0] }}</span>
								</div>

								<div class="form-group col-md-6">
									<label for="issueinput4">Next Session Resumption Date</label>
									<input type="date" id="issueinput4" @keydown="validationErrors.next_session_date=null" :class="{'border-danger':validationErrors.next_session_date}" v-model="next_session_date" class="form-control" placeholder="YYYY-mm-dd" name="next_session_date" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Next Session Resumption Date">
									<span v-if="validationErrors.next_session_date" :class="['label text-danger']">{{ validationErrors.next_session_date[0] }}</span>
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
				principal_name : '',
				next_session_date : '',
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
				axios.get('/api/school/result/editsign')
				.then((res) => {
					this.sign = res.data.data.principal_sign
					this.principal_name = res.data.data.principal_name
					this.next_session_date = res.data.data.next_session_date

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
				data.append('principal_sign', this.sign)
				data.append('principal_name', this.principal_name)
				data.append('next_session_date', this.next_session_date)
				
				this.$loading(true)

                axios.post('/api/school/result/updatesign', data)
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

				this.validationErrors.principal_sign = null
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