<template>
   <div class="row match-height">
		<div class="col-md-12 ">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-tooltip">School Survey: Pupil / Teachers Books</h4>
					
					<SurveyProgress :currentPage="7"></SurveyProgress>
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
                <div class="col-md-12">
                    <label for="" style="font-weight: bold;">Number of students' core subjects textbooks available in the school provided by government</label>
                    <table border="1px" style="border-collapse: collapse; width: 100%;">
                        <tr>
                            <th width="13%">
                                Subject Area
                            </th>
                            <th width="87%">
                                Number of Students’ Textbooks
                                <table border="1px" style="border-collapse: collapse; width: 100%;">
                                    <tr>
                                        <th width="14%">
                                           JSS 1
                                        </th>
                                        <th width="14%">
                                            JSS 2
                                        </th>
                                        <th width="14%">
                                            JSS 3
                                        </th>
                                        <th width="14%">
                                            SSS 1
                                        </th>
                                        <th width="14%">
                                            SSS 2
                                        </th>
                                        <th width="14%">
                                            SSS 3
                                        </th>
                                    </tr>
                                </table>
                            </th>
                        </tr>
                        <tr>
                            <th>
                               English
                            </th>
                            <td>
                                <input v-model="books.subject_textbook_social_pre_primary" type="number" name="" id="" style="width: 16.5%; ">
                                <input v-model="books.subject_textbook_social_primary_one" type="number" name="" id=""   style="width: 16.5%; margin-left: -3px;">
                                <input v-model="books.subject_textbook_social_primary_two" type="number" name="" id=""   style="width: 16.5%; margin-left: -3px;">
                                <input v-model="books.subject_textbook_social_primary_three" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input v-model="books.subject_textbook_social_primary_four" type="number" name="" id=""  style="width: 16.5%; margin-left: -3px;">
                                <input v-model="books.subject_textbook_social_primary_five" type="number" name="" id=""  style="width: 16.5%; margin-left: -3px;">
                            </td>
                        </tr>
                        <tr>
                            <th>
                               Mathematics
                            </th>
                            <td>
                                <input v-model="books.subject_textbook_social_pre_primary" type="number" name="" id="" style="width: 16.5%; ">
                                <input v-model="books.subject_textbook_social_primary_one" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input v-model="books.subject_textbook_social_primary_two" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input v-model="books.subject_textbook_social_primary_three" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input v-model="books.subject_textbook_social_primary_four" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input v-model="books.subject_textbook_social_primary_five" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                            </td>
                        </tr>
                        <tr>
                            <th>
                               Biology
                            </th>
                            <td>
                                <input v-model="books.subject_textbook_social_pre_primary" type="number" name="" id="" style="width: 16.5%; ">
                                <input v-model="books.subject_textbook_social_primary_one" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input v-model="books.subject_textbook_social_primary_two" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input v-model="books.subject_textbook_social_primary_three" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input v-model="books.subject_textbook_social_primary_four" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input v-model="books.subject_textbook_social_primary_five" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                            </td>
                        </tr>
                        <tr>
                            <th>
                               Physics
                            </th>
                            <td>
                                <input v-model="books.subject_textbook_social_pre_primary" type="number" name="" id="" style="width: 16.5%; ">
                                <input v-model="books.subject_textbook_social_primary_one" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input v-model="books.subject_textbook_social_primary_two" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input v-model="books.subject_textbook_social_primary_three" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input v-model="books.subject_textbook_social_primary_four" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input v-model="books.subject_textbook_social_primary_five" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                            </td>
                        </tr>
                         <tr>
                            <th>
                               Chemistry
                            </th>
                            <td>
                                <input v-model="books.subject_textbook_social_pre_primary" type="number" name="" id="" style="width: 16.5%; ">
                                <input v-model="books.subject_textbook_social_primary_one" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input v-model="books.subject_textbook_social_primary_two" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input v-model="books.subject_textbook_social_primary_three" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input v-model="books.subject_textbook_social_primary_four" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input v-model="books.subject_textbook_social_primary_five" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                            </td>
                        </tr>
                         <tr>
                            <th>
                               Basic Technology
                            </th>
                            <td>
                                <input v-model="books.subject_textbook_social_pre_primary" type="number" name="" id="" style="width: 16.5%; ">
                                <input v-model="books.subject_textbook_social_primary_one" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input v-model="books.subject_textbook_social_primary_two" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input v-model="books.subject_textbook_social_primary_three" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input v-model="books.subject_textbook_social_primary_four" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input v-model="books.subject_textbook_social_primary_five" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <br>

            <div class="row">
                <div class="col-md-12">
                    <label for="" style="font-weight: bold;">Number of Teachers’ Core subjects Textbooks available in the School provided by government</label>
                    <table border="1px" style="border-collapse: collapse; width: 100%;">
                        <tr>
                            <th width="13%">
                                Subject Area
                            </th>
                            <th width="87%">
                                Number of Teachers’ Textbooks
                                <table border="1px" style="border-collapse: collapse; width: 100%;">
                                    <tr>
                                        <th width="14%">
                                           JSS 1
                                        </th>
                                        <th width="14%">
                                            JSS 2
                                        </th>
                                        <th width="14%">
                                            JSS 3
                                        </th>
                                        <th width="14%">
                                            SSS 1
                                        </th>
                                        <th width="14%">
                                            SSS 2
                                        </th>
                                        <th width="14%">
                                            SSS 3
                                        </th>
                                    </tr>
                                </table>
                            </th>
                        </tr>
                        <tr>
                            <th>
                               English
                            </th>
                            <td>
                                <input v-model="books.subject_textbook_social_pre_primary" type="number" name="" id="" style="width: 16.5%; ">
                                <input v-model="books.subject_textbook_social_primary_one" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input v-model="books.subject_textbook_social_primary_two" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input v-model="books.subject_textbook_social_primary_three" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input v-model="books.subject_textbook_social_primary_four" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input v-model="books.subject_textbook_social_primary_five" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                            </td>
                        </tr>
                        <tr>
                            <th>
                               Mathematics
                            </th>
                            <td>
                                <input v-model="books.subject_textbook_social_pre_primary" type="number" name="" id="" style="width: 16.5%; ">
                                <input v-model="books.subject_textbook_social_primary_one" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input v-model="books.subject_textbook_social_primary_two" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input v-model="books.subject_textbook_social_primary_three" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input v-model="books.subject_textbook_social_primary_four" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input v-model="books.subject_textbook_social_primary_five" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                            </td>
                        </tr>
                        <tr>
                            <th>
                               Biology
                            </th>
                            <td>
                                <input v-model="books.subject_textbook_social_pre_primary" type="number" name="" id="" style="width: 16.5%; ">
                                <input v-model="books.subject_textbook_social_primary_one" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input v-model="books.subject_textbook_social_primary_two" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input v-model="books.subject_textbook_social_primary_three" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input v-model="books.subject_textbook_social_primary_four" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input v-model="books.subject_textbook_social_primary_five" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                            </td>
                        </tr>
                        <tr>
                            <th>
                               Physics
                            </th>
                            <td>
                                <input v-model="books.subject_textbook_social_pre_primary" type="number" name="" id="" style="width: 16.5%; ">
                                <input v-model="books.subject_textbook_social_primary_one" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input v-model="books.subject_textbook_social_primary_two" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input v-model="books.subject_textbook_social_primary_three" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input v-model="books.subject_textbook_social_primary_four" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input v-model="books.subject_textbook_social_primary_five" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                            </td>
                        </tr>
                         <tr>
                            <th>
                               Chemistry
                            </th>
                            <td>
                                <input v-model="books.subject_textbook_social_pre_primary" type="number" name="" id="" style="width: 16.5%; ">
                                <input v-model="books.subject_textbook_social_primary_one" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input v-model="books.subject_textbook_social_primary_two" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input v-model="books.subject_textbook_social_primary_three" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input v-model="books.subject_textbook_social_primary_four" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input v-model="books.subject_textbook_social_primary_five" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                            </td>
                        </tr>
                         <tr>
                            <th>
                               Basic Technology
                            </th>
                            <td>
                                <input v-model="books.subject_textbook_social_pre_primary" type="number" name="" id="" style="width: 16.5%; ">
                                <input v-model="books.subject_textbook_social_primary_one" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input v-model="books.subject_textbook_social_primary_two" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input v-model="books.subject_textbook_social_primary_three" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input v-model="books.subject_textbook_social_primary_four" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input v-model="books.subject_textbook_social_primary_five" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                            </td>
                        </tr>
                    </table>
                </div>
            </div> 
            <br>
		
							</div>

						</form>
							<div class="form-actions">
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
				books : {
                    subject_textbook_eng_pre_primary: null,
                    subject_textbook_eng_primary_one: null,
                    subject_textbook_eng_primary_two: null,
                    subject_textbook_eng_primary_three: null,
                    subject_textbook_eng_primary_four: null,
                    subject_textbook_eng_primary_five: null,
                    subject_textbook_eng_primary_six: null,

                    subject_textbook_maths_pre_primary: null,
                    subject_textbook_maths_primary_one: null,
                    subject_textbook_maths_primary_two: null,
                    subject_textbook_maths_primary_three: null,
                    subject_textbook_maths_primary_four: null,
                    subject_textbook_maths_primary_five: null,
                    subject_textbook_maths_primary_six: null,

                    subject_textbook_science_pre_primary: null,
                    subject_textbook_science_primary_one: null,
                    subject_textbook_science_primary_two: null,
                    subject_textbook_science_primary_three: null,
                    subject_textbook_science_primary_four: null,
                    subject_textbook_science_primary_five: null,
                    subject_textbook_science_primary_six: null,

                    subject_textbook_social_pre_primary: null,
                    subject_textbook_social_primary_one: null,
                    subject_textbook_social_primary_two: null,
                    subject_textbook_social_primary_three: null,
                    subject_textbook_social_primary_four: null,
                    subject_textbook_social_primary_five: null,
                    subject_textbook_social_primary_six: null,

                    teacher_textbook_eng_pre_primary: null,
                    teacher_textbook_eng_primary_one: null,
                    teacher_textbook_eng_primary_two: null,
                    teacher_textbook_eng_primary_three: null,
                    teacher_textbook_eng_primary_four: null,
                    teacher_textbook_eng_primary_five: null,
                    teacher_textbook_eng_primary_six: null,

                    teacher_textbook_maths_pre_primary: null,
                    teacher_textbook_maths_primary_one: null,
                    teacher_textbook_maths_primary_two: null,
                    teacher_textbook_maths_primary_three: null,
                    teacher_textbook_maths_primary_four: null,
                    teacher_textbook_maths_primary_five: null,
                    teacher_textbook_maths_primary_six: null,

                    teacher_textbook_science_pre_primary: null,
                    teacher_textbook_science_primary_one: null,
                    teacher_textbook_science_primary_two: null,
                    teacher_textbook_science_primary_three: null,
                    teacher_textbook_science_primary_four: null,
                    teacher_textbook_science_primary_five: null,
                    teacher_textbook_science_primary_six: null,

                    teacher_textbook_social_pre_primary: null,
                    teacher_textbook_social_primary_one: null,
                    teacher_textbook_social_primary_two: null,
                    teacher_textbook_social_primary_three: null,
                    teacher_textbook_social_primary_four: null,
                    teacher_textbook_social_primary_five: null,
                    teacher_textbook_social_primary_six: null,

                    hand_book : null,
                    national_policy : null,
                    national_curriculum : null,
                    manuals: null
                },
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
				axios.get(`/api/school/surveys/show?survey=${this.surveyId}`)
				.then((res) => {
					this.survey = res.data.data;
                    this.is_submitted = this.survey.submit_status;
			
					if(this.survey.books) {
                         this.books = this.survey.books;
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
                    'books' : this.books
                }

				this.$loading(true)

                axios.post('/api/school/surveys/create/books', data)
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
				// if(this.survey.books == null) {
				// 	this.$alert("Sorry, you have to complete this stage.","Not Allowed","error");
				// 	return;
				// }

				this.$router.push({
					name: 'teacherqualification-school-survey',
					params: { surveyId: this.surveyId }
                });
			},

			previousStage() {
				
				this.$router.push({
					name: 'studentsbysubject-school-survey',
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
table,
tr,
td, 
th {
    text-align: center;
}
</style>