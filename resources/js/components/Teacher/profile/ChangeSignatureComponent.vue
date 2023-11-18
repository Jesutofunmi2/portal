<template>
   <div class="row match-height">
		<div class="col-md-12 ">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-tooltip">Change My Signature</h4>
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
						<div class="row" v-if="signature">
							<h4>Current Signature</h4>
							<img :src="baseUrl+signature" alt="current signature">
						</div>
						<div class="row">
							<div class="col-12 mt-2">
								<h4><span>Sign Here </span><i class="icon-arrow-down"></i></h4>
							<VueSignaturePad
								id="signature"
								width="60%"
								height="80%"
								ref="signaturePad"
								name="test"
							/>
							</div>
							<div class="col-6 mt-2">
							<button class="btn btn-outline-secondary float-right" @click="undo">
								Undo
							</button>
				
							<button class="btn btn-outline-primary float-left" @click="save">
								Save
							</button>
							</div>
						</div>
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
				signature : null,
				validationErrors: [],
				baseUrl:  '/public',
			}
		},
        mounted() {
			this.getTeacher();
        },

		methods : {
			getTeacher() {
				this.$loading(true);
				axios.get('/api/teacher/profile/signature')
				.then((res) => {
					this.signature = res.data.data;
					this.$loading(false);
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
							name: 'teacher-login',
							params: { return_url: return_url }
							});
					}

                    if(error.response.status === 403){
						this.$alert("Sorry, you do not have the permission to perfrom this action","No Permission","error");
					}
				})
			},

			undo() {
				this.$refs.signaturePad.undoSignature();
				},

			save() {
				const { isEmpty, data } = this.$refs.signaturePad.saveSignature();
				if (isEmpty) {
					alert("Signature pad is empty");
					return;
				}
				let form = new FormData;
				form.append('image_uri', data);
				
				this.$loading(true)

                axios.post('/api/teacher/profile/change-signature',form)
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
						this.signature = response.data.data.signature;
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
											message: 'There is an Error with the Data you supplied',
											time: 15000, });
					}
					if(error.response.status === 401){
						let return_url = window.location.pathname;
						this.$router.push({
							name: 'teacher-login',
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
<style scoped>
#signature {
  border: double 3px transparent;
  border-radius: 5px;
  background-image: linear-gradient(white, white),
    radial-gradient(circle at top left, #4bc5e8, #9f6274);
  background-origin: border-box;
  background-clip: content-box, border-box;
}
</style>
