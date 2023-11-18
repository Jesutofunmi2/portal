<template>
   <div class="row match-height">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-tooltip">Edit Student Subjects </h4>
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

						<form class="form" @submit.prevent="updateStudentSubjects">
							
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
									<label for="issueinput12">Subjects Not Offered</label>
									<select id="issueinput12" v-model="subjIDs" @change="validationErrors.subjects=null" :class="{'border-danger':validationErrors.subjects}" class="form-control" name="subjects" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Subject" required size="10" multiple>
										<option value="">Select Subject</option>
										<option :value="subj.id" v-for ="(subj ,index) in subjects" :key ="index">
											{{ subj.subject_name }}
										</option>
									</select>
									<span  v-if="validationErrors.subjects" :class="['label text-danger']">{{ validationErrors.subjects[0] }}</span>
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
				studentID : this.$route.params.studentID,
				subjects : '',
				sessions : [],
				subjIDs : [],
				student : '',
				session : '',
				validationErrors: [],
			}
		},
        mounted() {
			this.getStudentSubjects();
			//this.getSubjects();
			this.getSessions();
        },

		methods : {
			getSessions() {
				for (let i = 2010; i <= 2050; i++) {
					this.sessions.push(i);
				}
			},

			getStudentSubjects() {
				this.$loading(true)
				axios.get(`/api/school/student/subject/${this.studentID}/edit`)
				.then((res) => {
					this.student = res.data.data
					this.subjects = res.data.data.classarms[0].subjects

					let subjects = this.student.subjects_unoffered

					if (Array.isArray(subjects) && subjects.length > 0) {
						subjects.forEach(subj => {
							this.subjIDs.push(subj.id);
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
				})
			},

            updateStudentSubjects() {
				let data = new FormData;
				data.append('subjects', JSON.stringify(this.subjIDs));
				data.append('session', this.session);
				
				this.$loading(true)

                axios.post(`/api/school/student/subject/${this.studentID}/update`, data)
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
						this.getStudentSubjects();
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
				});
            }
		}
    }
</script>