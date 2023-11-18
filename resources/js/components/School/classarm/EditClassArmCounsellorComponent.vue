<template>
   <div class="row match-height">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-tooltip">Edit Class Arm Counsellors for <span v-if="classarm.classes !== undefined">{{ classarm.classes.class_name }}</span> <span v-if="classarm.class_arm !== undefined">{{ classarm.class_arm }}</span> </h4>
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

						<form class="form" @submit.prevent="updateArmCounsellors">
							
							<div class="form-body">
								<div class="form-group col-md-6">
									<label for="issueinput21">Session</label>
									<select type="text" id="issueinput21" v-model="session" @change="validationErrors.session=null" :class="{'border-danger':validationErrors.session}" class="form-control" name="session" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Session" required>
										<option value="">Select Session</option>
										<option :value="sess" v-for ="(sess, index) in sessions" :key ="index">{{ sess }}/{{ sess+1 }}</option>
									</select>
									<span  v-if="validationErrors.session" :class="['label text-danger']">{{ validationErrors.session[0] }}</span>
								</div>

								<div class="form-group col-md-6">
									<label for="issueinput12">Counsellors</label>
									<select id="issueinput12" v-model="teachIDs" @change="validationErrors.teacher_id=null" :class="{'border-danger':validationErrors.teacher_id}" class="form-control" name="teacher_id" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Teacher" required size="10" multiple>
										<option value="">Select Counsellor</option>
										<option :value="teach.id" v-for ="(teach ,index) in teachers" :key ="index">
											{{ teach.title }}
											{{ teach.surname }}
											{{ teach.firstname }}
											{{ teach.middlename }}
										</option>
									</select>
									<span  v-if="validationErrors.teacher_id" :class="['label text-danger']">{{ validationErrors.teacher_id[0] }}</span>
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
				classArmID : this.$route.params.classArmID,
				teachers : '',
				sessions : [],
				teachIDs : [],
				classarm : '',
				session : '',
				validationErrors: [],
			}
		},
        mounted() {
			this.getSessions();
			this.getTeachers();
        },

		methods : {
			getTeachers() {
				this.$loading(true)
				axios.get('/api/school/teacher/view')
				.then((res) => {
					this.teachers = res.data.data

					this.$loading(false);
					this.getArmCounsellors();
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
									name: 'school-login',
									params: { return_url: return_url }
									});
					}

					if(error.response.status === 403){
						this.$alert("Sorry, you do not have the permission to perform this action","No Permission","error");
					}
				})	
			},

			getSessions() {
				for (let i = 2010; i <= 2050; i++) {
					this.sessions.push(i);
				}
			},

			getArmCounsellors() {
				this.$loading(true)
				axios.get(`/api/school/classarm/counsellor/${this.classArmID}/edit`)
				.then((res) => {
					this.classarm = res.data.data
					let teachers = this.classarm.counsellors
					
					if (Array.isArray(teachers) && teachers.length > 0) {
						teachers.forEach(teach => {
							this.teachIDs.push(teach.id);
						});
					}

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
									name: 'school-login',
									params: { return_url: return_url }
									});
					}

					if(error.response.status === 403){
						this.$alert("Sorry, you do not have the permission to perform this action","No Permission","error");
					}

					if(error.response.status === 400){
						this.$alert(error.response.data.message, "Request Error","error");
					}
				})
			},

            updateArmCounsellors() {
				let data = new FormData;
				data.append('teachers', JSON.stringify(this.teachIDs));
				data.append('session', this.session);
				
				this.$loading(true)

                axios.post(`/api/school/classarm/counsellor/${this.classArmID}/update`, data)
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
						this.getArmCounsellors();
                    }
                })
				.catch(error => {
					this.$loading(false)
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
						this.$alert("Sorry, you do not have the permission to perform this action","No Permission","error");
					}

					if(error.response.status === 400){
						this.$alert(error.response.data.message, "Request Error","error");
					}
				});
            }
		}
    }
</script>