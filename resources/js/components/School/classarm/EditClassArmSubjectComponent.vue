<template>
   <div class="row match-height">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-tooltip">Edit Class Arm Subjects for <span v-if="classarm.classes !== undefined">{{ classarm.classes.class_name }}</span> <span v-if="classarm.class_arm !== undefined">{{ classarm.class_arm }}</span> </h4>
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

						<form class="form" @submit.prevent="updateArmSubjects">

							<div class="form-body">
								 <div class="form-group col-md-5">
									<label for="issueinput12">Subjects</label>
									<select id="issueinput12" v-model="subject_id" @change="subjectChanged()" :class="{'border-danger':validationErrors.subject_id}" class="form-control" name="subject_id" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Subject" required>
										<option value="">Select Subjects</option>
										<option :value="subj.id" v-for ="(subj ,index) in subjects" :key ="index" >{{ subj.subject_name }}</option>
									</select>
									<span  v-if="validationErrors.subject_id" :class="['label text-danger']">{{ validationErrors.subject_id[0] }}</span>
								</div>
								<div class="form-group col-md-5">
									<label for="issueinput12">Teachers</label>
									<select id="issueinput12" v-model="teacher_id" @change="validationErrors.teacher_id=null" :class="{'border-danger':validationErrors.subject_id}" class="form-control" name="subject_id" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Subject" required>
										<option value="">Select Subjects</option>
										<option :value="teacher.id" v-for ="(teacher ,index) in teachers" :key ="index" >{{ teacher.title }} {{ teacher.surname }} {{ teacher.firstname }} {{ teacher.middlename }}</option>
										
									</select>
									<span  v-if="validationErrors.subject_id" :class="['label text-danger']">{{ validationErrors.subject_id[0] }}</span>
								</div>
								<div v-if="teacher_id != '' && teacher_id != null && subject_id != '' && subject_id != null" class="form-group col-md-2" style="padding-top:25px;">
									
									<button type="button" @click="updateArmSubjects()" class="btn btn-success mr-1">
										<i class="icon-check2"></i> Add Subject
									</button>
								</div>
								
							</div>

						</form>

						<table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Subject Name</th>
                                        <th>Subject Category</th>
										<th>Subject Code</th>
										<th>Teacher</th>
                                        <th colspan="2">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(subject , index) in class_subjects" :key="index">
                                        <th scope="row">{{ index+1 }}</th>
                                        <td>{{ subject.subject_name }}</td>
                                        <td>{{ subject.class_category }}</td>
										<td>{{ subject.subject_code }}</td>
										<td>{{ subject.title }} {{ subject.surname }} {{ subject.firstname }} {{ subject.middlename }}</td>
                                        <td>
                                            <button @click="deleteArmSubject(subject.classarm_subject_id)" class="btn btn-danger"><i class="icon-trash4"></i> Delete</button>
                                        </td>
                                    </tr>
                                
                                </tbody>
						</table>
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
				subjects_all : '',
				subjects : '',
				classarm : '',
				class_subjects : [],
				subject_id : null,
				teacher_id : null,
				teachers : '',
				validationErrors: [],
			}
		},
        mounted() {
			this.getSubjects();
			
        },

		methods : {
			getSubjects() {
				this.$loading(true)
				axios.get('/api/general/getSubjects/byCategory')
				.then((res) => {
					this.subjects_all = res.data.data

					this.$loading(false);
					this.getArmSubjects();
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

			getArmSubjects() {
				this.$loading(true)
				axios.get(`/api/school/classarm/subject/${this.classArmID}/edit`)
				.then((res) => {
					this.classarm = res.data.data.classes;
					this.class_subjects = res.data.data.subjects;
					
					this.setSubjects(this.classarm.classes.class_name)

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

            updateArmSubjects() {
				if(this.teacher_id == '' || this.teacher_id == null || this.subject_id == '' || this.subject_id == null) {
					this.flashMessage.error({title: 'Data Error', 
							message: 'Select a subject and a teacher to add subject',
							time: 15000, });
					return;
				}
				let data = new FormData;
				data.append('subject_id', this.subject_id);
				data.append('teacher_id', this.teacher_id);
				
				this.$loading(true)

                axios.post(`/api/school/classarm/subject/${this.classArmID}/update`, data)
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
						this.teacher_id = null;
						this.subject_id = null;
						this.getArmSubjects();
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
						this.flashMessage.error({title: 'Data Error', 
							message: error.response.data.message,
							time: 15000, });
					}
				});
            },

			deleteArmSubject(id) {
                this.$confirm("Are you sure you want delete this Class Arm's Subjects?","Delete Class Arm Subjects",'warning').then(() => {
                    this.$loading(true)
                    axios.delete(`/api/school/classarm/subjects/${id}/delete`)
                    .then((response) => {
                        this.$loading(false);
                        this.$alert(response.data.data.message,"Successful","success");
                        this.getArmSubjects();
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

                        if(error.response.status === 400){
						this.$alert(error.response.data.message, "Request Error","error");
					}
                    })
                });
			},

			setSubjects(class_category) {
				if(class_category.includes('j') || class_category.includes('J')) {
					this.subjects = this.subjects_all.jss_subjects;
				}
				else {
					this.subjects = this.subjects_all.sss_subjects;
				}
			},

			subjectChanged() {
				this.$loading(true)
				this.teacher_id = null;

				axios.get(`/api/school/classarm/subject/${this.subject_id}/teachers`)
				.then((res) => {
					this.teachers = res.data.data

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
						this.teachers = '';
						
						this.flashMessage.error({title: 'Data Error', 
							message: error.response.data.message,
							time: 15000, });
					
					}
				})
			}
		}
    }
</script>