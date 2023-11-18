<template>
    <div class="row match-height">
		<!-- Striped rows start -->
        <div class="row">
            <div class="col-xs-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Assign Subjects to Teacher</h4>
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
                        
                        <div class="card-block card-dashboard row">
                            
                            <form class="form" novalidate @submit.prevent="updateTeacherSubject">
							    
                                <div class="form-body" style="height:300px;">
                                    <div class="form-group col-md-6">
                                        <label for="issueinput1">Teacher</label>
                                        <select id="issueinput1" v-model="teacher" :class="{'border-danger':validationErrors.teacher_id}" class="form-control" name="class_id" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Class" required>
                                            <option value="">Select Teacher</option>
                                            <option :value="teacher" v-for ="(teacher, index) in teachers" :key ="index" >{{ teacher.fullname }}</option>
                                        </select>
                                        <span  v-if="validationErrors.teacher_id" :class="['label text-danger']">{{ validationErrors.teacher_id[0] }}</span>
                                    </div>

                                    <div class="form-group col-md-6">
                                       <div class="form-group">
											<label for="projectinput1">Subject Area</label>
                                            <multiselect v-model="teacher.subjects" tag-placeholder="Select Subject" :class="{'border-danger':validationErrors.subjects}" placeholder="Select Subject" :options="subjects" :multiple="true" :taggable="true" @tag="addTag" label="subject_name" track-by="id"></multiselect>
                                            <span  v-if="validationErrors.subjects" :class="['label text-danger']">{{ validationErrors.subjects[0] }}</span>
										</div>
                                    </div>

                                </div>

                                <div class="form-actions">
                                    <button type="submit" class="btn btn-success">
                                         Save Teacher Subjects
                                    </button>
                                </div>

                            </form>
       
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
        <!-- Striped rows end -->
		<FlashMessage></FlashMessage>

	</div>
	
</template>

<script>
    import Multiselect from 'vue-multiselect'
    export default {

        components: {
		    Multiselect
		},

		data() {
			return {
                subjects: [],
                teacher_subjects : [],
                teachers: '',
                validationErrors: [],
                teacher : []
			}
        },
        
        mounted() {
            this.getSubjects();
        },

		methods : {
            addTag(newTag) {
				this.teacher.subjects.push(newTag);
			},

            getSubjects() {
				this.$loading(true)
				axios.get('/api/general/getSubjects')
				.then((res) => {
					this.subjects = res.data.data;
                    this.getTeachers();

					this.$loading(false);
				})
				.catch((error) => {
					this.$loading(false)
					if (!error.response) {
						this.$alert("You do not have internet access","Network Error","error");
						return ;
					}

                    if (error.response.status == 422) {
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

                    if(error.response.status === 400){
						this.$alert(error.response.data.message, "Error","error");
                        return ;
					}
				})
			},

            getTeachers() {
                
				this.$loading(true);

				axios.get('/api/school/teacher/view/formatted')
				.then((res) => {
					this.teachers = res.data.data;
					this.$loading(false);
				})
				.catch((error) => {
                    this.$loading(false);
					if (!error.response) {
						this.$alert("You do not have internet access","Network Error","error");
						return ;
					}

                    if (error.response.status == 422) {
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

                    if(error.response.status === 400){
						this.$alert(error.response.data.message, "Error","error");
                        return ;
					}
				})
            },

            updateTeacherSubject() {

                this.$loading(true);

                let data = new FormData;

                data.append('teacher_id', this.teacher.id )

                if(this.teacher.subjects.length !=0) {
                    const subjects = this.teacher.subjects;
                    for (let index = 0; index < subjects.length; index++) {
                        const element = subjects[index];
                        data.append('subjects[]', element.id );
                    }
                }
                else{
                    data.append('subjects[]', "");
                }

				axios.post('/api/school/classarm/assign/teacher/subject', data)
				.then((response) => {
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
                    this.getTeachers();
				})
				.catch((error) => {
                    this.$loading(false);
					if (!error.response) {
						this.$alert("You do not have internet access","Network Error","error");
						return ;
					}

                    if (error.response.status == 422) {
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

                    if(error.response.status === 400){
						this.$alert(error.response.data.message, "Error","error");
                        return ;
					}
				})
            },
		}
        
    }
</script>