<template>
   <div class="row match-height">
		<div class="col-md-12 ">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-tooltip">School Survey: School Characteristics</h4>
					
					<SurveyProgress :currentPage="1"></SurveyProgress>
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
									<div class="form-group col-md-4">
										<label for="issueinput48">Year of Establishment</label>
										<input readonly type="text" v-model="est_year" class="form-control" @keydown="validationErrors.est_year=null" :class="{'border-danger':validationErrors.name}"  placeholder="Enter Year of Establishment" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Enter Year of Establishment">
										<span  v-if="validationErrors.est_year" :class="['label text-danger']">{{ validationErrors.est_year[0] }}</span>
									</div>

									<div class="form-group col-md-4">
										<label for="issueinput48">Location</label>
										<select readonly id="issueinput10" v-model="location_type" :class="{'border-danger':validationErrors.location_type}" class="form-control" data-toggle="tooltip" data-trigger="hover" data-placement="top">
											<option :value="null">Select School Location</option>
											<option>Urban</option>
											<option>Rural</option>
										</select>
										<span  v-if="validationErrors.location_type" :class="['label text-danger']">{{ validationErrors.location_type[0] }}</span>
									</div>
									<div class="form-group col-md-4">
										<label for="issueinput48">Levels of Education Offered</label>
										<select readonly id="issueinput10" v-model="education_level" :class="{'border-danger':validationErrors.education_level}" class="form-control" data-toggle="tooltip" data-trigger="hover" data-placement="top">
											<option :value="null">Select Levels of Education Offered</option>
											<option>Pre-Primary Only</option>
											<option>Pre-Primary Only and Primary</option>
											<option>Primary Only</option>
										</select>
										<span  v-if="validationErrors.education_level" :class="['label text-danger']">{{ validationErrors.education_level[0] }}</span>
									</div>
								</div>

								<div class="row">
									<div class="form-group col-md-4 move_down">
										<label for="issueinput48">Type of School</label>
										<select readonly id="issueinput10" v-model="school_type" :class="{'border-danger':validationErrors.school_type}" class="form-control" data-toggle="tooltip" data-trigger="hover" data-placement="top">
											<option :value="null">Select Type of School</option>
											<option>Regular</option>
											<option>Islamiyya Integrated</option>
											<option>Nomadic (Migrants)</option>
											<option>Specials Needs</option>
										</select>
										<span  v-if="validationErrors.school_type" :class="['label text-danger']">{{ validationErrors.school_type[0] }}</span>
									</div>
									<div class="form-group col-md-4 move_down">
										<label for="issueinput48">Shifts: <span class="small_text">Does the school operate shift system? </span></label>
										<select readonly id="issueinput10" v-model="school_shift" :class="{'border-danger':validationErrors.school_shift}" class="form-control" data-toggle="tooltip" data-trigger="hover" data-placement="top">
											<option :value="null">Select Answer</option>
											<option>Yes</option>
											<option>No</option>
										</select>
										<span  v-if="validationErrors.school_shift" :class="['label text-danger']">{{ validationErrors.school_shift[0] }}</span>
									</div>
									<div class="form-group col-md-4">
										<label for="issueinput48">Multi-grade Teaching: <span class="small_text">Does any teacher teach more than one class at the same time </span></label>
										<select readonly id="issueinput10" v-model="multi_grade" :class="{'border-danger':validationErrors.multi_grade}" class="form-control" data-toggle="tooltip" data-trigger="hover" data-placement="top">
											<option :value="null">Select Answer</option>
											<option>Yes</option>
											<option>No</option>
										</select>
										<span  v-if="validationErrors.multi_grade" :class="['label text-danger']">{{ validationErrors.multi_grade[0] }}</span>
									</div>
								</div>

								<div class="row">
									<div class="form-group col-md-6">
										<label for="issueinput48">Shared Facilities: <span class="small_text"> Does the school share facilities/teacher/premises with any other school </span></label>
										<select readonly id="issueinput10" v-model="share_facilities" :class="{'border-danger':validationErrors.share_facilities}" class="form-control" data-toggle="tooltip" data-trigger="hover" data-placement="top">
											<option :value="null">Select Answer</option>
											<option>Yes</option>
											<option>No</option>
										</select>
										<span  v-if="validationErrors.share_facilities" :class="['label text-danger']">{{ validationErrors.share_facilities[0] }}</span>
									</div>
									<div class="form-group col-md-6" v-if="share_facilities == 'Yes'">
										<label for="issueinput08">How many school are sharing facilities</label>
										<input readonly type="text" @keydown="validationErrors.facilities_sharing=null" :class="{'border-danger':validationErrors.facilities_sharing}" v-model="facilities_sharing" class="form-control" data-toggle="tooltip" data-trigger="hover" data-placement="top">
										<span  v-if="validationErrors.facilities_sharing" :class="['label text-danger']">{{ validationErrors.facilities_sharing[0] }}</span>
									</div>
								</div>

								<div class="row">
									<div class="form-group col-md-6">
										<label for="issueinput08">Average distance of school from catchment communities</label>
										<input readonly type="text" @keydown="validationErrors.ave_distance=null" :class="{'border-danger':validationErrors.ave_distance}" v-model="ave_distance" class="form-control"  placeholder="Enter 0 if within 1km" data-toggle="tooltip" data-trigger="hover" data-placement="top">
										<span  v-if="validationErrors.ave_distance" :class="['label text-danger']">{{ validationErrors.ave_distance[0] }}</span>
									</div>
									<div class="form-group col-md-6">
										<label for="issueinput08">How many pupils live further than 3km from the school</label>
										<input readonly type="text" @keydown="validationErrors.long_distance=null" :class="{'border-danger':validationErrors.long_distance}" v-model="long_distance" class="form-control"  placeholder="Enter number of pupils" data-toggle="tooltip" data-trigger="hover" data-placement="top">
										<span  v-if="validationErrors.long_distance" :class="['label text-danger']">{{ validationErrors.long_distance[0] }}</span>
									</div>
								</div>

								<div class="row">
									
									<div class="form-group col-md-6 move_down">
										<label for="issueinput08">How many pupils board at the school premises</label>
										<input readonly type="text" @keydown="validationErrors.student_boarding=null" :class="{'border-danger':validationErrors.student_boarding}" v-model="student_boarding" class="form-control"  placeholder="2 Males and 4 Females" data-toggle="tooltip" data-trigger="hover">								<span  v-if="validationErrors.student_boarding" :class="['label text-danger']">{{ validationErrors.student_boarding[0] }}</span>
									</div>

									<div class="form-group col-md-6">
										<label for="issueinput08">Did the school prepare SPD in the last school year</label> <br />
										<span class="small_text">SPD: School Development Plan</span>
										<select readonly id="issueinput10" v-model="spd" :class="{'border-danger':validationErrors.spd}" class="form-control" data-toggle="tooltip" data-trigger="hover" data-placement="top">
											<option :value="null">Select Answer</option>
											<option>Yes</option>
											<option>No</option>
										</select>
										<span  v-if="validationErrors.spd" :class="['label text-danger']">{{ validationErrors.spd[0] }}</span>
									</div>
								</div>

								<div class="row">
									
									<div class="form-group col-md-6">
										<label for="issueinput08">Does the school have SBMC, which met at least once last year</label> <br />
										<span class="small_text">SBMC: School Based Management Committee</span>
										<select readonly id="issueinput10" v-model="sbmc" :class="{'border-danger':validationErrors.sbmc}" class="form-control" data-toggle="tooltip" data-trigger="hover" data-placement="top">
											<option :value="null">Select Answer</option>
											<option>Yes</option>
											<option>No</option>
										</select>
										<span  v-if="validationErrors.sbmc" :class="['label text-danger']">{{ validationErrors.sbmc[0] }}</span>
									</div>
									<div class="form-group col-md-6">
										<label for="issueinput08">Does the school have PTA/PF/MA, which met at least once last year</label> <br />
										<span class="small_text">PTA: Parent Teacher Association, PF: Parent Forum, MA: Mother's Association</span>
										<select readonly id="issueinput10" v-model="pta" :class="{'border-danger':validationErrors.pta}" class="form-control" data-toggle="tooltip" data-trigger="hover" data-placement="top">
											<option :value="null">Select Answer</option>
											<option>Yes</option>
											<option>No</option>
										</select>
										<span  v-if="validationErrors.pta" :class="['label text-danger']">{{ validationErrors.pta[0] }}</span>
									</div>
								</div>

								<div class="row">
									
									<div class="form-group col-md-6">
										<label for="issueinput08">When was the school last inspected</label> <br />
										<input readonly type="date" @keydown="validationErrors.last_inspect=null" :class="{'border-danger':validationErrors.last_inspect}" v-model="last_inspect" class="form-control"  placeholder="Last inspection date" data-toggle="tooltip" data-trigger="hover">
										<span  v-if="validationErrors.last_inspect" :class="['label text-danger']">{{ validationErrors.last_inspect[0] }}</span>
									</div>
									<div class="form-group col-md-6">
										<label for="issueinput08">Number of inspection visit in the last academic session</label> <br />
										<input readonly type="number" @keydown="validationErrors.inspect_number=null" :class="{'border-danger':validationErrors.inspect_number}" v-model="inspect_number" class="form-control"  placeholder="Number of time inspected" data-toggle="tooltip" data-trigger="hover">
										<span  v-if="validationErrors.inspect_number" :class="['label text-danger']">{{ validationErrors.inspect_number[0] }}</span>
									</div>
								</div>

								<div class="row">
									<div class="form-group col-md-6">
										<label for="issueinput08">Which Authority conduct the last inspection</label>
										<select readonly id="issueinput10" v-model="inspect_by" :class="{'border-danger':validationErrors.inspect_by}" class="form-control" data-toggle="tooltip" data-trigger="hover" data-placement="top">
											<option :value="null">Select Answer</option>
											<option>Federal</option>
											<option>State</option>
											<option>LGEA</option>
										</select>
										<span  v-if="validationErrors.inspect_by" :class="['label text-danger']">{{ validationErrors.inspect_by[0] }}</span>
									</div>
									<div class="form-group col-md-6">
										<label for="issueinput08">How many pupils benefit from conditional cash transfer?</label> <br />
										<input readonly type="number" @keydown="validationErrors.conditional_cash=null" :class="{'border-danger':validationErrors.conditional_cash}" v-model="conditional_cash" class="form-control"  placeholder="Enter number" data-toggle="tooltip" data-trigger="hover">
										<span  v-if="validationErrors.conditional_cash" :class="['label text-danger']">{{ validationErrors.conditional_cash[0] }}</span>
									</div>
								</div>

								<div class="row">
									<div class="form-group col-md-4">
										<label for="issueinput08">Has your school ever receive grants in the last 2 academic sessions</label>
										<select readonly id="issueinput10" v-model="receive_grant" :class="{'border-danger':validationErrors.receive_grant}" class="form-control" data-toggle="tooltip" data-trigger="hover" data-placement="top">
											<option :value="null">Select Answer</option>
											<option>Yes</option>
											<option>No</option>
										</select>
										<span  v-if="validationErrors.receive_grant" :class="['label text-danger']">{{ validationErrors.receive_grant[0] }}</span>
									</div>
									<div class="form-group col-md-4 move_down">
										<label for="issueinput08">Does the shool has security gate?</label>
										<select readonly id="issueinput10" v-model="security_gate" :class="{'border-danger':validationErrors.security_gate}" class="form-control" data-toggle="tooltip" data-trigger="hover" data-placement="top">
											<option :value="null">Select Answer</option>
											<option>Yes</option>
											<option>No</option>
										</select>
										<span  v-if="validationErrors.security_gate" :class="['label text-danger']">{{ validationErrors.security_gate[0] }}</span>
									</div>

									<div class="form-group col-md-4 move_down">
										<label for="issueinput08">Which of the tier of Government owned this school</label>
										<select readonly id="issueinput10" v-model="school_owner" :class="{'border-danger':validationErrors.school_owner}" class="form-control" data-toggle="tooltip" data-trigger="hover" data-placement="top">
											<option :value="null">Select Answer</option>
											<option>Federal</option>
											<option>State</option>
											<option>LGEA</option>
											<option>Community</option>
										</select>
										<span  v-if="validationErrors.school_owner" :class="['label text-danger']">{{ validationErrors.school_owner[0] }}</span>
									</div>
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
				est_year: null,
				location_type: null,
				share_facilities: null,
				education_level: null,
				school_type: null,
				school_shift: null,
				multi_grade: null,
				facilities_sharing: null,
				ave_distance: null,
				spd: null,
				student_boarding: null,
				sbmc: null,
				pta: null,
				last_inspect: null,
				conditional_cash: null,
				receive_grant: null,
				security_gate: null,
				school_owner: null,
				long_distance: null,
				inspect_number: null,
				inspect_by: null,
				validationErrors: [],
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
					let characteristics = this.survey.characteristic;
					if(characteristics != null) {
					
						this.data_exist = true;
						this.est_year = characteristics.est_year;
						this.location_type =characteristics.location_type;
						this.share_facilities = characteristics.share_facilities;
						this.education_level = characteristics.education_level;
						this.school_type = characteristics.school_type;
						this.school_shift = characteristics.school_shift;
						this.multi_grade = characteristics.multi_grade;
						this.facilities_sharing =characteristics.facilities_sharing;
						this.ave_distance = characteristics.ave_distance;
						this.spd = characteristics.spd;
						this.student_boarding = characteristics.student_boarding;
						this.sbmc = characteristics.sbmc;
						this.pta = characteristics.pta;
						this.last_inspect = characteristics.last_inspect;
						this.conditional_cash = characteristics.conditional_cash;
						this.receive_grant = characteristics.receive_grant;
						this.security_gate = characteristics.security_gate;
						this.school_owner = characteristics.school_owner;
						this.long_distance = characteristics.long_distance;
						this.inspect_number = characteristics.inspect_number;
						this.inspect_by = characteristics.inspect_by;
					}
					this.is_submitted = this.survey.submit_status;
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
					name: 'ministry-enrollment-school-survey',
					params: { surveyId: this.surveyId }
                });
			},

			previousStage() {
				this.$router.push({
					name: 'ministry-identities-school-survey',
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