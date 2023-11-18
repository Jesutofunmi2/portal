<template>
   <div class="row match-height">
		<div class="col-md-12 ">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-tooltip">Edit Subject</h4>
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

						<form class="form" novalidate @submit.prevent="updateSubject">
							<div class="form-body">
									
								<h4 class="form-section"><i class="icon-head"></i>Edit Subject</h4>
								<div class="row">
									
									<div class="col-md-3">
										<div class="form-group">
											<label for="projectinput1">Subject Name</label>
											<input type="text" @keydown="validationErrors.subject_name=null" v-model="subject.subject_name" :class="{'border-danger':validationErrors.subject_name}" class="form-control" placeholder="Surname" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Enter Surname" required>
											<span  v-if="validationErrors.subject_name" :class="['label text-danger']">{{ validationErrors.subject_name[0] }}</span>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label for="projectinput2">Subject Code</label>
											<input v-model="subject.subject_code" @keydown="validationErrors.subject_code=null" type="text" :class="{'border-danger':validationErrors.subject_code}" class="form-control" placeholder="First Name" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Enter First Name" required>
											<span  v-if="validationErrors.subject_code" :class="['label text-danger']">{{ validationErrors.subject_code[0] }}</span>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label for="projectinput1">Class Category</label>
											<select v-model="subject.class_category" @change="validationErrors.class_category=null" class="form-control" :class="{'border-danger':validationErrors.class_category}" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select Blood Group" required>
												<option selected value="">Select Category</option>
												<option value="JSS">JSS</option>
												<option value="SSS">SSS</option>
												
											</select>
											<span  v-if="validationErrors.class_category" :class="['label text-danger']">{{ validationErrors.class_category[0] }}</span>
										</div>
									</div>
									<div class="col-md-3">
											<fieldset style="width:100%;" class="row py-2">
												<div class="input-group col-xs-12">
													<button type="submit" style="width:100%; background:#FF8C00; color:#fff;" class="btn btn-lg">Save</button>
												</div>
											</fieldset> 
									</div>
								</div>
								
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
				subjectId: this.$route.params.subjectId,
				
				subject : {
					id :this.$route.params.subjectId,
					subject_name :null,
					subject_code: null,
					class_category:null,
				},
				validationErrors: []
			}
		},
        mounted() {
			this.getSubject();
        },

		methods : {
			
			getSubject(){
				this.$loading(true)
				axios.get('/api/general/getSubjects/byId/'+this.subjectId)
				.then((res) => {
					if(res.data.data.subject){
						this.subject.subject_name = res.data.data.subject.subject_name;
						this.subject.subject_code = res.data.data.subject.subject_code;
						this.subject.class_category = res.data.data.subject.class_category;
					}
					
					this.$loading(false)
				})
				.catch((error) => {
					this.$loading(false)
					if (!error.response) {
						this.$alert("You do not have internet access","Network Error","error");
						this.$router.go(-1) ;
						return ;
					}
					if(error.response.status === 401){
						let return_url = window.location.pathname;
						this.$router.push({
									name: "aeo_zeo-login",
									params: { return_url: return_url }
									});
					}
	
				})
			},

            updateSubject(){
				let data = new FormData;
				const obj = this.subject;
				Object.keys(obj).forEach(key=>{
					
					if(obj[key]==null){
						data.append(key, "");
					}
					else{
						data.append(key, obj[key]);
					}
					
				});
	
				this.$loading(true)

                axios.post('/api/ministry/subject/update',data)
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
						this.$router.go(-1) ;
	
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

			editSubject(id){
                this.$confirm("Are you sure you want to edit subject?","Edit Subject",'question').then(() => {
                this.$router.push({
                        name: 'edit-subject',
                        params: { subjectId: id }
                        });
                });
            },

		}
    }
</script>