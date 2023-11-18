<template>
   <div class="row match-height">
		<div class="col-md-12 ">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-tooltip">School Survey: Staff</h4>
					
					<SurveyProgress :currentPage="3"></SurveyProgress>
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

						<form class="form" novalidate @submit.prevent="submitSurvey">
							<div class="form-body">
								<div class="row">
									<!-- code goes here -->
									<table class="table" width="100%">
                        <tr>
                            <td>
                                
                            </td>
                            <td>
                                Male
                            </td>
                            <td>
                                Female
                            </td>
                            <td>
                                Total
                            </td>
                        </tr>
                        <tr>
                            <td>
                                How many non-teaching staff are working at the school?
                            </td>
                            <td>
                                <input type="text" v-model="staffs.non_teaching_staff_male" size="6" name="" id="">
                            </td>
                            <td>
                                <input type="text" v-model="staffs.non_teaching_staff_female" size="6" name="" id="">
                            </td>
                            <td>
                                <input type="text" v-model="staffs.non_teaching_staff_total" size="6" name="" id="">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                How many teachers are working at the school regardless of whether they are currently present or on Course or Absent?
                            </td>
                            <td>
                                <input type="text" v-model="staffs.teaching_staff_male" size="6" name="" id="">
                            </td>
                            <td>
                                <input type="text" v-model="staffs.teaching_staff_female" size="6" name="" id="">
                            </td>
                            <td>
                                <input type="text" v-model="staffs.teaching_staff_total" size="6" name="" id="">
                            </td>
                        </tr>
                    </table><br>
								</div>
                    <div class="row form-group">
                        <div class="col-md-12">
                            <h5>Information on all staff during the current school year</h5><br>
                        </div>
                        
                        <div class="col-md-4">
                            <label for="">Staff File Number</label>
                            <input type="text" v-model="teacher.staff_no" name="" id="" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="">Name of Staff</label>
                            <input type="text" v-model="teacher.staff_name" name="" id=""  class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="">Gender</label>
                            <select name="" id="" v-model="teacher.gender" class="form-control">
                                <option selected disabled>Select</option>
                                <option>Male</option>
                                <option>Female</option>
                            </select>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-4">
                            <label for="">Type of Staff</label>
                            <select name="" v-model="teacher.staff_type" id="" class="form-control">
                                <option selected disabled>Choose...</option>
                                <option>Principal</option>
                                <option>Vice Principal</option>
                                <option>Teacher</option>
                                <option>Other(Non-Teaching)</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="">Source of Salary</label>
                            <select name="" v-model="teacher.salary_source" id="" class="form-control">
                                <option selected disabled>Choose...</option>
                                <option>Federal Goverment-FTS</option>
                                <option>State Government-On this School's Payroll</option>
                                <option>State Government-On another School's Payroll</option>
                                <option>Others e.g (Community, PTA)</option>
                                <option>No Salary e.g (Volunteer, NYSC)</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="">Year of Birth</label>
                            <input type="number" v-model="teacher.yob" name="" id="" class="form-control">
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-4">
                            <label for="">Year of First Appointment</label>
                            <input type="number" v-model="teacher.yofa" name="" id="" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="">Year of Present Appointment</label>
                            <input type="number" v-model="teacher.yopa" name="" id="" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="">Year of Posting to this School</label>
                            <input type="number" v-model="teacher.yopts" name="" id="" class="form-control">
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-4">
                            <label for="">Grade Level / Step</label>
                            <input type="text" name="" v-model="teacher.grade" id="" class="form-control" placeholder="E.g 7/2">
                        </div>
                        <div class="col-md-4">
                            <label for="">Present</label>
                            <select name="" id="" v-model="teacher.present" class="form-control">
                                <option>Presnt or Temporarily Absent</option>
                                <option>Absent for more than 1 Month-Maternity Leave</option>
                                <option>Absent for more than 1 Month-Sick Leave</option>
                                <option>Absent for more than 1 Month-Training</option>
                                <option>Absent for more than 1 Month-Unautorised</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="">Accademic Qualification</label>
                            <select name="" id="" v-model="teacher.a_qualification" class="form-control">
                                <option>Below SSCE</option>
                                <option>SSCE / WASCE</option>
                                <option>OND / Diploma</option>
                                <option>NCE</option>
                                <option>Degree / HND/ Graduate</option>
                                <option>Ph/d / Masters Degree</option>
                            </select>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-4">
                            <label for="">Teaching Qualification</label>
                            <select name="" id="" v-model="teacher.t_qualification" class="form-control">
                                <option>NCE</option>
                                <option>PGDE</option>
                                <option>B.Ed or Equivalent</option>
                                <option>M.Ed or Equivalent</option>
                                <option>Grade II or Equivalent</option>
                                <option>none</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="">Subject of Qualification</label>
                            <select name="" id="" v-model="teacher.area_specialization" class="form-control">
                                <option>English</option>
                                <option>Mathematics</option>
                                <option>Science</option>
                                <option>Business</option>
                                <option>Humanities</option>
                                <option>Technology</option>
                                <option>Other</option>
                                <Option>none</Option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="">Area of Specialisation</label>
                            <select name="" id="" v-model="teacher.area_specialization" class="form-control">
                                <option>English</option>
                                <option>Mathematics</option>
                                <option>Science</option>
                                <option>Business</option>
                                <option>Humanities</option>
                                <option>Technology</option>
                                <option>Other</option>
                                <Option>none</Option>
                            </select>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-4">
                            <label for="">Main Subject Taught</label>
                            <select name="" id="" v-model="teacher.main_subject" class="form-control">
                                <option>English</option>
                                <option>Mathematics</option>
                                <option>Science</option>
                                <option>Business</option>
                                <option>Humanities</option>
                                <option>Technology</option>
                                <option>Other</option>
                                <Option>none</Option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="">Teaching Type</label>
                            <select name="" id="" v-model="teacher.teaching_type" class="form-control">
                                <option>Full Time</option>
                                <option>Part Time</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <br>
                            <label for="">Tick box if teacher teaches both junior & senior secondary classes in this school &nbsp;&nbsp; <span>
                                <input type="checkbox" v-model="teacher.attend_seminar" name="" id="" class="custom-checkbox"></span></label>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-4">
                            <br>
                            <label for="">Tick box if teacher attended training workshop / seminar in last 12 months &nbsp;&nbsp; <span>
                                <input type="checkbox" v-model="teacher.attend_seminar" name="" id="" class="custom-checkbox"></span></label>
                        </div>
                    </div>
							</div>

						</form>
							<div class="form-actions">
                                <button type="submit" v-if="! is_submitted" class="btn btn-info" 
								 @click="addStaff()">
									<i class="icon-plus3"></i> Add New Teacher
								</button>
								<button type="submit" v-if="! is_submitted" class="btn btn-success" 
								 @click="submitSurvey()">
									<i class="icon-check2"></i> Save
								</button>
								<button type="button" class="btn btn-warning mr-1" @click="previousStage()">
									&lt;&lt; Previous Stage
								</button>
								<button type="button" class="btn btn-primary mr-1" @click="nextStage()">
									Next Stage &gt;&gt;
								</button>
							</div>
						
                        <section id="accordion">
                            <div class="row">
                                <div class="col-xs-12 mt-1">
                                    <h4>List of Staff</h4>
                                    <hr>
                                </div>
                            </div>
                            <div class="row match-height">
                                <div class="col-lg-12 col-xl-12">
                        
                                    <div id="accordionWrapa1" role="tablist" aria-multiselectable="true">
                                        <div class="card">
                                            
                                            <div v-for="teacher, index in staffs.staff_data" :key="index">
                                                <div :id="'heading'+index"  class="card-header">
                                                    <a data-toggle="collapse" data-parent="#accordionWrapa1" :href="'#accordion'+index" aria-expanded="true" aria-controls="accordion1" class="card-title lead">{{teacher.staff_name}}</a>
                                                </div>
                                                <div :id="'accordion'+index" role="tabpanel" :aria-labelledby="'heading'+index" class="card-collapse collapse in" aria-expanded="true">
                                                    <div class="card-body">
                                                        <div class="card-block">
                                                            <table class="table table-striped mb-0">
                                                                <tr>
                                                                    <td>Staff File Number: {{teacher.staff_no}}</td>
                                                                    <td>Name of Staff: {{teacher.staff_name}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Gender: {{teacher.gender}}</td>
                                                                    <td>Type of Staff: {{teacher.staff_type}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Source of Salary: {{teacher.salary_source}}</td>
                                                                    <td>Year of birth: {{teacher.yob}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Year of first apointment: {{teacher.yofa}}</td>
                                                                    <td>Year of present apointment: {{teacher.yopa}}</td>
                                                                </tr>
                                                                 <tr>
                                                                    <td>Year of posting to this school: {{teacher.yopts}}</td>
                                                                    <td>Grade Level / Step: {{teacher.grade}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Present: {{teacher.present}}</td>
                                                                    <td>Accademic Qualification: {{teacher.a_qualification}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Teaching Qualification: {{teacher.t_qualification}}</td>
                                                                    <td>Area of Specialisation: {{teacher.area_specialization}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Main Subject Taught: {{teacher.main_subject}}</td>
                                                                    <td>Teaching Type: {{teacher.teaching_type}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2">Traing Workshop / Seminar in the last 12 Months : <span v-if="teacher.attend_seminar">Yes</span> <span v-else>No</span></td>
                                                                </tr>
                                                                 <tr>
                                                                   <button class="btn btn-danger" @click="removeRecord(index)">Remove Record</button>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <!-- Accordion end -->
					</div>
				</div>
			</div>
		</div>
		<FlashMessage></FlashMessage>

	</div>
	
</template>

<script>
	import SurveyProgress from '../../../Shared/School/SurveyProgress.vue';
    export default {
		components: {
			SurveyProgress
		},

		data(){
			return {
				surveyId : this.$route.params.surveyId,
                staffs : {
                    non_teaching_staff_male: null,
                    non_teaching_staff_female: null,
                    non_teaching_staff_total: null,
                    teaching_staff_male: null,
                    teaching_staff_female: null,
                    teaching_staff_total: null,
                    care_giver_male: null,
                    care_giver_female: null,
                    care_giver_total: null,
                    staff_data : []
                },
                teacher : {
                    staff_no : null,
                    staff_name : null,
                    gender : null,
                    staff_type : null,
                    salary_source : null,
                    yob : null,
                    yofa : null,
                    yopa : null,
                    yopts : null,
                    grade : null,
                    present : null,
                    a_qualification : null,
                    t_qualification : null,
                    area_specialization : null,
                    main_subject : null,
                    teaching_type : null,
                    attend_seminar : null,
                },
				survey: null,

                is_submitted : false
			}
		},
        mounted() {
			window.scrollTo(0, 0);
			this.getSurvey();
        },

		methods : {
			getSurvey() {
				this.$loading(true)
				axios.get(`/api/school/surveys/show?survey=${this.surveyId}`)
				.then((res) => {
					this.survey = res.data.data;
                    this.is_submitted = this.survey.submit_status;
                    
					if(this.survey.staffs) {
                         this.staffs = this.survey.staffs;
                    }

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
			
            submitSurvey() {
				let data = {
                    'survey' : this.surveyId,
                    'staffs' : this.staffs
                }

				this.$loading(true)

                axios.post('/api/school/surveys/create/staffs', data)
				.then(response => {
					this.survey = response.data.data;
					this.$loading(false)
					this.flashMessage.success({
						title: 'Successful',
						message: 'Survey saved successfully',
						time: 15000,
						flashMessageStyle: {
							backgroundColor: 'linear-gradient(#e66465, #9198e5)'
						}
					});
					this.nextStage();
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

			nextStage() {
				// if(this.survey.staffs == null) {
				// 	this.$alert("Sorry, you have to complete this stage.","Not Allowed","error");
				// 	return;
				// }

				this.$router.push({
					name: 'classrooms-school-survey',
					params: { surveyId: this.surveyId }
                });
			},

            addStaff() {
                if(this.teacher.staff_no == null || this.teacher.staff_name == null) {
                    this.$alert("Please fill all required field", "Data Error","error");
                    return;
                }

                let teacher_data = {};

				Object.keys(this.teacher).forEach(key => {
                    teacher_data[key] = this.teacher[key]
                    this.teacher[key] = null;
                });

                this.staffs.staff_data.push(teacher_data);

                 this.flashMessage.success({
                    title: "Successful",
                    message: "Teacher added successfully",
                    time: 15000,
                    flashMessageStyle: {
                        backgroundColor: "linear-gradient(#e66465, #9198e5)"
                    }
                });
               
            },

            removeRecord(index) {
                if (index > -1) {
                    this.staffs.staff_data.splice(index, 1); // 2nd parameter means remove one item only
                    this.flashMessage.success({
                    title: "Successful",
                    message: "Teacher reoved successfully",
                    time: 15000,
                    flashMessageStyle: {
                        backgroundColor: "linear-gradient(#e66465, #9198e5)"
                    }
                });
                }
            },

			previousStage() {
				
				this.$router.push({
					name: 'enrollment-school-survey',
					params: { surveyId: this.surveyId }
                });
			}
		}
    }
</script>

<style scoped>
.small_text {
	font-size: 0.8rem;
}
.move_down {
	padding-top: 20px;
}
</style>