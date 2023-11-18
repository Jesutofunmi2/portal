<template>
   <div class="row match-height">
		<div class="col-md-12 ">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-tooltip">School Survey: FLHE</h4>
					
					<SurveyProgress :currentPage="9"></SurveyProgress>
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
								<label for="" Style="Font-weight:bold">School Rules, Regulations and Guidelines.</label> <br>
<span class="small">Do the rules, regulations and guidelines in your school cover the following aspects of FLHE?</span>    
<div class="row">
    <div class="col-md-10">
        Physical safety in school?
    </div>
    <div class="col-md-1">
        <input  type="checkbox" name="" id="" >
        <label for="" class="mr-2">Yes</label>
    </div>
    <div class="col-md-1">
        <input  type="checkbox" name="" id="" >
        <label for="" class="mr-2">No</label>
    </div>
</div>
<div class="row">
    <div class="col-md-10">
        Stigma and discrimination towards staff or pupils/living with/affected by HIV, or based on sex, race or ethnicity, religion or any other grounds, sexual harassment and abuse.
    </div>
    <div class="col-md-1">
        <input  type="checkbox" name="" id="" >
        <label for="" class="mr-2">Yes</label>
    </div>
    <div class="col-md-1">
        <input  type="checkbox" name="" id="" >
        <label for="" class="mr-2">No</label>
    </div>
</div>
<div class="row">
    <div class="col-md-10">
        Grievance/disciplinary procedures in case of breach of the regulations described in the rules and guidelines.
    </div>
    <div class="col-md-1">
        <input  type="checkbox" name="" id="" >
        <label for="" class="mr-2">Yes</label>
    </div>
    <div class="col-md-1">
        <input  type="checkbox" name="" id="" >
        <label for="" class="mr-2">No</label>
    </div>
</div><hr>

<div class="row">
    <div class="col-md-10">
        Has your school communicated information about the rules, regulations and guidelines to relevant stakeholders such as pupils, parents, teachers etc?
    </div>
    <div class="col-md-1">
        <input  type="checkbox" name="" id="" >
        <label for="" class="mr-2">Yes</label>
    </div>
    <div class="col-md-1">
        <input  type="checkbox" name="" id="" >
        <label for="" class="mr-2">No</label>
    </div>
</div><hr>

<label for="" Style="Font-weight:bold">Life Skills-based Family Life HIV/AIDS Education (FLHE)</label> <br>
<div class="row">
    <div class="col-md-10">
        Did students of your school receive any form of life skills-based Family Life Health Education (FLHE) in the previous academic year?
    </div>
    <div class="col-md-1">
        <input  type="checkbox" name="" id="" >
        <label for="" class="mr-2">Yes</label>
    </div>
    <div class="col-md-1">
        <input  type="checkbox" name="" id="" >
        <label for="" class="mr-2">No</label>
    </div>
</div><hr>

<label for="" Style="Font-weight:bold">If yes, indicate which of these topics were covered in the FLHE programme:</label> <br>
<div class="row">
    <div class="col-md-10">
        Teaching on generic life skills (e.g. decision-making, communication, refusal skills).
    </div>
    <div class="col-md-1">
        <input  type="checkbox" name="" id="" >
        <label for="" class="mr-2">Yes</label>
    </div>
    <div class="col-md-1">
        <input  type="checkbox" name="" id="" >
        <label for="" class="mr-2">No</label>
    </div>
</div>
<div class="row">
    <div class="col-md-10">
        Teaching on reproductive health/FLHE (e.g. teaching on human growth and development, family life, sexual abuse and transmission of STIs)    </div>
    <div class="col-md-1">
        <input  type="checkbox" name="" id="" >
        <label for="" class="mr-2">Yes</label>
    </div>
    <div class="col-md-1">
        <input  type="checkbox" name="" id="" >
        <label for="" class="mr-2">No</label>
    </div>
</div>
<div class="row">
    <div class="col-md-10">
        Teaching on HIV transmission and prevention.
    </div>
    <div class="col-md-1">
        <input  type="checkbox" name="" id="" >
        <label for="" class="mr-2">Yes</label>
    </div>
    <div class="col-md-1">
        <input  type="checkbox" name="" id="" >
        <label for="" class="mr-2">No</label>
    </div>
</div><hr>

<div class="row">
    <div class="col-md-8">
        Number of students that received/participated in Life Skills-based Family Life HIV/AIDS Education (FLHE) in the previous year?  
    </div>  
    <div class="col-md-2">
        <div class="input-group">
            <span class="input-group-addon" id="basic-addon1">Male</span>
            <input type="text" class="form-control" style="margin-left: -3px">
        </div>
    </div>
    <div class="col-md-2">
        <div class="input-group">
            <span class="input-group-addon" id="basic-addon1">Female</span>
            <input type="text" class="form-control" style="margin-left: -3px">
        </div>
    </div>
</div><hr>

<label for="" Style="Font-weight:bold">Orientation Process for Parents or Guardians of Pupils</label> <br>
<div class="row">
    <div class="col-md-9">
        How many times have your school organised orientation programme for parents or guardians of pupils regarding FLHE programmes in the previous academic year?
    </div>
    <div class="col-md-3">
        <div class="input-group"> 
            <input type="text" class="form-control" style="margin-left: -3px">
            <span class="input-group-addon" id="basic-addon1">Number</span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-7">
        At what forums were the orientation programmes provided?   
     </div>
    <div class="col-md-1">
        <input  type="checkbox" name="" id="" >
        <label for="" class="mr-2">PTA</label>
    </div>
    <div class="col-md-2">
        <input  type="checkbox" name="" id="" >
        <label for="" class="mr-2">Open Day</label>
    </div>
    <div class="col-md-2">
        <input  type="checkbox" name="" id="" >
        <label for="" class="mr-2">Special Session(s)</label>
    </div>
</div><hr>

<label for="" Style="Font-weight:bold">Date of Last Orientation</label> <br>
<div class="row">
    <div class="col-md-9">
        When was the last orientation Programme on FLHE conducted?
    </div>
    <div class="col-md-3">
        <div class="input-group"> 
            <span class="input-group-addon" id="basic-addon1">dd/mm/yyyy</span>
            <input type="text" class="form-control" style="margin-left: -3px">
        </div>
    </div>
</div><hr>

<label for="" Style="Font-weight:bold">Life skills-based FLHE: Teacher training and teaching</label> <br>
<div class="row">
    <div class="col-md-8">
        How many teachers in your school received formal training on FLHE?  
    </div>  
    <div class="col-md-2">
        <div class="input-group">
            <span class="input-group-addon" id="basic-addon1">Male</span>
            <input type="text" class="form-control" style="margin-left: -3px">
        </div>
    </div>
    <div class="col-md-2">
        <div class="input-group">
            <span class="input-group-addon" id="basic-addon1">Female</span>
            <input type="text" class="form-control" style="margin-left: -3px">
        </div>
    </div>
</div><hr>


<div class="row">
    <div class="col-md-8">
        How many teachers in your school who received formal training in the previous year also taught related topics on FLHE? 
    </div>  
    <div class="col-md-2">
        <div class="input-group">
            <span class="input-group-addon" id="basic-addon1">Male</span>
            <input type="text" class="form-control" style="margin-left: -3px">
        </div>
    </div>
    <div class="col-md-2">
        <div class="input-group">
            <span class="input-group-addon" id="basic-addon1">Female</span>
            <input type="text" class="form-control" style="margin-left: -3px">
        </div>
    </div>
</div><br><br>
							</div>

						</form>
							<div class="form-actions">
								<button type="submit" class="btn btn-success" 
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
					let characteristics = this.survey.characteristic;
					if(characteristics != null) {
					
						this.data_exist = true;
						this.est_year = characteristics.est_year;
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
				let data = new FormData;
				data.append('inspect_by', this.inspect_by)
				
				this.$loading(true)

                axios.post('/api/school/surveys/create/characteristics', data)
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
				// if(this.survey.characteristic == null) {
				// 	this.$alert("Sorry, you have to complete this stage.","Not Allowed","error");
				// 	return;
				// }

				this.$router.push({
					name: 'undertaking-school-survey',
					params: { surveyId: this.surveyId }
                });
			},

			previousStage() {
				
				this.$router.push({
					name: 'teacherqualification-school-survey',
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