<template>
   <div class="row match-height">
		<div class="col-md-12 ">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-tooltip">Student Transfer Form</h4>
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

						<form class="form" novalidate @submit.prevent="submitForm">
							<div class="form-body">
									
								<h4 class="form-section"><i class="icon-head"></i>Select School</h4>
								
								<div class="row">
									<div class="col-md-12">
										<div v-if="current_school" class="form-group">
											<label for="projectinput1">Current School</label>
											<input type="text" :value="current_school.school_name" readonly class="form-control" data-toggle="tooltip" data-trigger="hover" data-placement="top">
											
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<label for="issueinput1">Transfer to School </label>
											<select  type="text" @change="validationErrors.school_id=null" v-model="school_id" class="form-control" placeholder="Select School" :class="{'border-danger':validationErrors.school_id}"  data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select School">
												<option value="">Select School</option>
												<option :value="school.id" v-for ="school in schools" :key ="school.id" >{{ school.name }}</option>
									
											</select>
											<span  v-if="validationErrors.school_id" :class="['label text-danger']">{{ validationErrors.school_id[0] }}</span>
										</div>
									</div>

									<div class="col-md-12">
										<div class="form-group">
											<label for="projectinput1">Reason for transfer</label>
											<textarea @keydown="validationErrors.reason=null" v-model="reason" class="form-control" :class="{'border-danger':validationErrors.reason}" placeholder="Enter Reason" name="reason" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Enter Reason"></textarea>
											<span  v-if="validationErrors.reason" :class="['label text-danger']">{{ validationErrors.reason[0] }}</span>
										</div>
									</div>
									
								</div>
								
							</div>

							<div class="form-actions">
								<button type="button" class="btn btn-warning mr-1">
									<i class="icon-cross2"></i> Cancel
								</button>
								<button type="submit" class="btn btn-primary">
									<i class="icon-check2"></i> Submit
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
				school_id: null,
				schools: null,
				current_school: null,
				reason: null,
				validationErrors: []
			}
		},
        mounted() {
			this.getSchools()
        },

		methods : {
            submitForm() {
				if(this.current_school && this.current_school.school_id == this.school_id) {
					this.$alert("You can not select your current school","Error","error");
					return;
				}

				this.$loading(true)
                axios.post('/api/student/transfer/submit', {
					school_id: this.school_id,
					reason: this.reason
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
					this.school_id = null;
					this.reason = null;
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
            },

			getSchools(){
                this.$loading(true);
				axios.get('/api/general/school/secondary/view')
				.then((res) => {
					this.schools = res.data.data.schools;
					this.getCurrentSchool();
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
            },

			getCurrentSchool(){
                this.$loading(true);
				axios.get('/api/student/transfer/current-school')
				.then((res) => {
					this.current_school = res.data.data,
					this.$loading(false)
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
            },
			
		}
    }
</script>