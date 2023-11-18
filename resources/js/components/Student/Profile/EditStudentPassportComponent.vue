<template>
   <div class="row match-height">
		<div class="col-md-12 ">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-tooltip">Student Update Passport</h4>
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

						<form class="form" novalidate @submit.prevent="updatePassport">
							<div class="form-body">
									
								<h4 class="form-section"><i class="icon-head"></i>Change Passport</h4>
								
								<div class="row">
									<div class="col-md-3">
										<img :src="baseUrl+student.passport" alt="" srcset="">
									</div>

									<div class="col-md-9">
										<div v-if="imagePreview">
											<img :src="imagePreview" style="max-height:200px; max-width:200px">
										</div>
										<div class="form-group">
											<label for="issueinput2">Passport</label>
											<input id="upImage" type="file" @change="onImageChange" :class="{'border-danger':validationErrors.passport}" accept="image/*"  class="form-control" placeholder="passport"  data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="passport">
											<span  v-if="validationErrors.passport" :class="['label text-danger']">{{ validationErrors.passport[0] }}</span>
												<br />
											<span v-if="imageError">
												{{ imageError }}
											</span> 
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
				student: null,
				baseUrl:  '/public',
				passport: null,
				imagePreview : null,
				imageError : null,
				validationErrors: []
			}
		},
        mounted() {
			this.getStudent();
        },

		methods : {
		
            updatePassport(){
				let data = new FormData;
				data.append('passport', this.passport);
				
				this.$loading(true)

                axios.post('/api/student/passport/update', data)
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
						window.location.reload();
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
					
				});
            },

			onImageChange(e) {
				this.validationErrors.passport=null
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
				if((files[0].type=='image/jpeg')|| (files[0].type=='image/jpg')||(files[0].type=='image/png')){
      				let max=2097152;

					if(files[0].size > max) {
						this.imageError = "File size too large, Maximum of 2MB"
					}

					this.createImage(files[0]);
    			}
				else{
					this.imageError = "Invalid Image File"
				}
                
            },

            createImage(file) {
                let reader = new FileReader();
                this.passport = file;
                reader.onload = (e) => {
                    this.imagePreview = e.target.result;
                };
                reader.readAsDataURL(file);
            },
			
			getStudent() {
				 this.$loading(true);
				axios.get('/api/student/profile/edit')
				.then((res) => {
					this.student  = res.data.data.student;
					
					this.$loading(false);
				})
				.catch((error) => {
                    this.$loading(false)
                    if (!error.response) {
						this.$alert("You do not have internet access","Network Error","error");
						return ;
					}

					if(error.response.status === 401){
						let return_url = window.location.pathname;
						this.$router.push({
							name: 'student-login',
							params: { return_url: return_url }
							});
					}
					
				})
			}

		}
    }
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>