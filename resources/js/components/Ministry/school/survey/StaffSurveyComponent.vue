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
                                How many Non-Teaching Staffs are working at the school?
                            </td>
                            <td>
                                <input readonly type="text" v-model="staffs.non_teaching_staff_male" size="6" name="" id="">
                            </td>
                            <td>
                                <input readonly type="text" v-model="staffs.non_teaching_staff_female" size="6" name="" id="">
                            </td>
                            <td>
                                <input readonly type="text" v-model="staffs.non_teaching_staff_total" size="6" name="" id="">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                How many teachers are working at the school regardless of whether they are currently present or on course or absent?
                            </td>
                            <td>
                                <input readonly type="text" v-model="staffs.teaching_staff_male" size="6" name="" id="">
                            </td>
                            <td>
                                <input readonly type="text" v-model="staffs.teaching_staff_female" size="6" name="" id="">
                            </td>
                            <td>
                                <input readonly type="text" v-model="staffs.teaching_staff_total" size="6" name="" id="">
                            </td>
                        </tr>
							<tr>
                                <td>
                                    How many Care Givers are in the School for ECCD?
                                </td>
                                <td>
                                    <input readonly type="text" v-model="staffs.care_giver_male" size="6" name="" id="">
                                </td>
                                <td>
                                    <input readonly type="text" v-model="staffs.care_giver_female" size="6" name="" id="">
                                </td>
                                <td>
                                    <input readonly type="text" v-model="staffs.care_giver_total" size="6" name="" id="">
                                </td>
                            </tr>
                    </table>
					</div>
                   
						</div>

						</form>
							<div class="form-actions">
                               
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
				axios.get(`/api/ministry/school/survey/show?survey=${this.surveyId}`)
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
							name: 'ministry-login',
							params: { return_url: return_url }
							});
					}

                    if(error.response.status === 403){
						this.$alert("Sorry, you do not have the permission to perfrom this action","No Permission","error");
					}
				})
			},
			
			nextStage() {
				
				this.$router.push({
					name: 'ministry-classrooms-school-survey',
					params: { surveyId: this.surveyId }
                });
			},

			previousStage() {
				
				this.$router.push({
					name: 'ministry-enrollment-school-survey',
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