<template>
   <div class="row match-height">
		<div class="col-md-12 ">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-tooltip">School Survey: Pupil / Teachers Books</h4>
					
					<SurveyProgress :currentPage="6"></SurveyProgress>
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
                    <label for="" style="font-weight: bold;">Number of  core subject textbooks available to pupils provided by government</label>
                    <table border="1px" style="border-collapse: collapse; width: 100%;">
                        <tr>
                            <th width="13%">
                                Subject Area
                            </th>
                            <th width="87%">
                                Number of Pupils Book Made Available for each Subject
                                <table border="1px" style="border-collapse: collapse; width: 100%;">
                                    <tr>
                                        <th width="14%">
                                           Pre-Primary
                                        </th>
                                        <th width="14%">
                                            Primary 1
                                        </th>
                                        <th width="14%">
                                            Primary 2
                                        </th>
                                        <th width="14%">
                                            Primary 3
                                        </th>
                                        <th width="14%">
                                            Primary 4
                                        </th>
                                        <th width="14%">
                                            Primary 5
                                        </th>
                                        <th width="14%">
                                            Primary 6
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
                                <input readonly v-model="books.subject_textbook_eng_pre_primary" type="number" name="" id="" style="width: 14%; ">
                                <input readonly v-model="books.subject_textbook_eng_primary_one" type="number" name="" id="" style="width: 14.5%; margin-left: -3px;">
                                <input readonly v-model="books.subject_textbook_eng_primary_two" type="number" name="" id="" style="width: 14%; margin-left: -3px;">
                                <input readonly v-model="books.subject_textbook_eng_primary_three" type="number" name="" id="" style="width: 14%; margin-left: -3px;">
                                <input readonly v-model="books.subject_textbook_eng_primary_four" type="number" name="" id="" style="width: 14%; margin-left: -3px;">
                                <input readonly v-model="books.subject_textbook_eng_primary_five" type="number" name="" id="" style="width: 14.5%; margin-left: -3px;">
                                <input readonly v-model="books.subject_textbook_eng_primary_six" type="number" name="" id="" style="width: 14%; margin-left: -2px;">
                            </td>
                        </tr>
                        <tr>
                            <th>
                               Mathematics
                            </th>
                            <td>
                                <input readonly v-model="books.subject_textbook_maths_pre_primary" type="number" name="" id="" style="width: 14%; ">
                                <input readonly v-model="books.subject_textbook_maths_primary_one" type="number" name="" id="" style="width: 14.5%; margin-left: -3px;">
                                <input readonly v-model="books.subject_textbook_maths_primary_two" type="number" name="" id="" style="width: 14%; margin-left: -3px;">
                                <input readonly v-model="books.subject_textbook_maths_primary_three" type="number" name="" id="" style="width: 14%; margin-left: -3px;">
                                <input readonly v-model="books.subject_textbook_maths_primary_four" type="number" name="" id="" style="width: 14%; margin-left: -3px;">
                                <input readonly v-model="books.subject_textbook_maths_primary_five" type="number" name="" id="" style="width: 14.5%; margin-left: -3px;">
                                <input readonly v-model="books.subject_textbook_maths_primary_six" type="number" name="" id="" style="width: 14%; margin-left: -2px;">
                            </td>
                        </tr>
                        <tr>
                            <th>
                               Basic Science / Technology
                            </th>
                            <td>
                                <input readonly v-model="books.subject_textbook_science_pre_primary" type="number" name="" id="" style="width: 14%; height: 50px;">
                                <input readonly v-model="books.subject_textbook_science_primary_one" type="number" name="" id="" style="width: 14.5%; margin-left: -3px; height: 50px;">
                                <input readonly v-model="books.subject_textbook_science_primary_two" type="number" name="" id="" style="width: 14%; margin-left: -3px; height: 50px;">
                                <input readonly v-model="books.subject_textbook_science_primary_three" type="number" name="" id="" style="width: 14%; margin-left: -3px; height: 50px;">
                                <input readonly v-model="books.subject_textbook_science_primary_four" type="number" name="" id="" style="width: 14%; margin-left: -3px; height: 50px;">
                                <input readonly v-model="books.subject_textbook_science_primary_five" type="number" name="" id="" style="width: 14.5%; margin-left: -3px; height: 50px;">
                                <input readonly v-model="books.subject_textbook_science_primary_six" type="number" name="" id="" style="width: 14%; margin-left: -2px; height: 50px;">
                            </td>
                        </tr>
                        <tr>
                            <th>
                               Social Studies
                            </th>
                            <td>
                                <input readonly v-model="books.subject_textbook_social_pre_primary" type="number" name="" id="" style="width: 14%; ">
                                <input readonly v-model="books.subject_textbook_social_primary_one" type="number" name="" id="" style="width: 14.5%; margin-left: -3px;">
                                <input readonly v-model="books.subject_textbook_social_primary_two" type="number" name="" id="" style="width: 14%; margin-left: -3px;">
                                <input readonly v-model="books.subject_textbook_social_primary_three" type="number" name="" id="" style="width: 14%; margin-left: -3px;">
                                <input readonly v-model="books.subject_textbook_social_primary_four" type="number" name="" id="" style="width: 14%; margin-left: -3px;">
                                <input readonly v-model="books.subject_textbook_social_primary_five" type="number" name="" id="" style="width: 14.5%; margin-left: -3px;">
                                <input readonly v-model="books.subject_textbook_social_primary_six" type="number" name="" id="" style="width: 14%; margin-left: -2px;">
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <br>

            <div class="row">
                <div class="col-md-12">
                    <label for="" style="font-weight: bold;">Number of core subject Teachers’ Textbooks available in the School provided by government</label>
                    <table border="1px" style="border-collapse: collapse; width: 100%;">
                        <tr>
                            <th width="13%">
                                Subject Area
                            </th>
                            <th width="87%">
                                Number of Teachers Book Made Available for each Subject
                                <table border="1px" style="border-collapse: collapse; width: 100%;">
                                    <tr>
                                        <th width="14%">
                                           Pre-Primary
                                        </th>
                                        <th width="14%">
                                            Primary 1
                                        </th>
                                        <th width="14%">
                                            Primary 2
                                        </th>
                                        <th width="14%">
                                            Primary 3
                                        </th>
                                        <th width="14%">
                                            Primary 4
                                        </th>
                                        <th width="14%">
                                            Primary 5
                                        </th>
                                        <th width="14%">
                                            Primary 6
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
                                <input readonly v-model="books.teacher_textbook_eng_pre_primary" type="number" name="" id="" style="width: 14%; ">
                                <input readonly v-model="books.teacher_textbook_eng_primary_one" type="number" name="" id="" style="width: 14.5%; margin-left: -3px;">
                                <input readonly v-model="books.teacher_textbook_eng_primary_two" type="number" name="" id="" style="width: 14%; margin-left: -3px;">
                                <input readonly v-model="books.teacher_textbook_eng_primary_three" type="number" name="" id="" style="width: 14%; margin-left: -3px;">
                                <input readonly v-model="books.teacher_textbook_eng_primary_four" type="number" name="" id="" style="width: 14%; margin-left: -3px;">
                                <input readonly v-model="books.teacher_textbook_eng_primary_five" type="number" name="" id="" style="width: 14.5%; margin-left: -3px;">
                                <input readonly v-model="books.teacher_textbook_eng_primary_six" type="number" name="" id="" style="width: 14%; margin-left: -2px;">
                            </td>
                        </tr>
                        <tr>
                            <th>
                               Mathematics
                            </th>
                            <td>
                                <input readonly v-model="books.teacher_textbook_maths_pre_primary" type="number" name="" id="" style="width: 14%; ">
                                <input readonly v-model="books.teacher_textbook_maths_primary_one" type="number" name="" id="" style="width: 14.5%; margin-left: -3px;">
                                <input readonly v-model="books.teacher_textbook_maths_primary_two" type="number" name="" id="" style="width: 14%; margin-left: -3px;">
                                <input readonly v-model="books.teacher_textbook_maths_primary_three" type="number" name="" id="" style="width: 14%; margin-left: -3px;">
                                <input readonly v-model="books.teacher_textbook_maths_primary_four" type="number" name="" id="" style="width: 14%; margin-left: -3px;">
                                <input readonly v-model="books.teacher_textbook_maths_primary_five" type="number" name="" id="" style="width: 14.5%; margin-left: -3px;">
                                <input readonly v-model="books.teacher_textbook_maths_primary_six" type="number" name="" id="" style="width: 14%; margin-left: -2px;">
                            </td>
                        </tr>
                        <tr>
                            <th>
                               Basic Science / Technology
                            </th>
                            <td>
                                <input readonly v-model="books.teacher_textbook_science_pre_primary" type="number" name="" id="" style="width: 14%; height: 50px;">
                                <input readonly v-model="books.teacher_textbook_science_primary_one" type="number" name="" id="" style="width: 14.5%; margin-left: -3px; height: 50px;">
                                <input readonly v-model="books.teacher_textbook_science_primary_two" type="number" name="" id="" style="width: 14%; margin-left: -3px; height: 50px;">
                                <input readonly v-model="books.teacher_textbook_science_primary_three" type="number" name="" id="" style="width: 14%; margin-left: -3px; height: 50px;">
                                <input readonly v-model="books.teacher_textbook_science_primary_four" type="number" name="" id="" style="width: 14%; margin-left: -3px; height: 50px;">
                                <input readonly v-model="books.teacher_textbook_science_primary_five" type="number" name="" id="" style="width: 14.5%; margin-left: -3px; height: 50px;">
                                <input readonly v-model="books.teacher_textbook_science_primary_six" type="number" name="" id="" style="width: 14%; margin-left: -2px; height: 50px;">
                            </td>
                        </tr>
                        <tr>
                            <th>
                               Social Studies
                            </th>
                            <td>
                                <input readonly v-model="books.teacher_textbook_social_pre_primary" type="number" name="" id="" style="width: 14%; ">
                                <input readonly v-model="books.teacher_textbook_social_primary_one" type="number" name="" id="" style="width: 14.5%; margin-left: -3px;">
                                <input readonly v-model="books.teacher_textbook_social_primary_two" type="number" name="" id="" style="width: 14%; margin-left: -3px;">
                                <input readonly v-model="books.teacher_textbook_social_primary_three" type="number" name="" id="" style="width: 14%; margin-left: -3px;">
                                <input readonly v-model="books.teacher_textbook_social_primary_four" type="number" name="" id="" style="width: 14%; margin-left: -3px;">
                                <input readonly v-model="books.teacher_textbook_social_primary_five" type="number" name="" id="" style="width: 14.5%; margin-left: -3px;">
                                <input readonly v-model="books.teacher_textbook_social_primary_six" type="number" name="" id="" style="width: 14%; margin-left: -2px;">
                            </td>
                        </tr>
                    </table>
                </div>
            </div> 
            <br>
            <div class="row">
                <div class="col-md-12">
                    <label for="" style="font-weight: bold">Care Giver Manuals Provided by the School in  the current Academic Year</label>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3"><br>
                    <label for="">
                        Care Giver Guide / Hand Book
                    </label>
                    <select readonly v-model="books.hand_book" name="" id="" class="form-control">
                        <option value="none" selected disabled>Select</option>
                        <option value="1">Yes</option>
                        <option value="2">No</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="">
                        National Policy on ECCDE/Pre-primary School
                    </label>
                    <select readonly v-model="books.national_policy" name="" id="" class="form-control">
                        <option value="none" selected disabled>Select</option>
                        <option value="1">Yes</option>
                        <option value="2">No</option>
                    </select>
                </div>
                <div class="col-md-3"><br>
                    <label for="">
                        National Curriculum
                    </label>
                    <select readonly v-model="books.national_curriculum" name="" id="" class="form-control">
                        <option value="none" selected disabled>Select</option>
                        <option value="1">Yes</option>
                        <option value="2">No</option>
                    </select>
                </div>
                <div class="col-md-3"><br>
                    <label for="">
                        Toy Making Manuals
                    </label>
                    <select readonly v-model="books.manuals" name="" id="" class="form-control">
                        <option value="none" selected disabled>Select</option>
                        <option value="1">Yes</option>
                        <option value="2">No</option>
                    </select>
                </div>
            </div>
			<br>
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
				axios.get(`/api/ministry/school/survey/show?survey=${this.surveyId}`)
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
					name: 'ministry-undertaking-school-survey',
					params: { surveyId: this.surveyId }
                });
			},

			previousStage() {
				
				this.$router.push({
					name: 'ministry-facilities-school-survey',
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