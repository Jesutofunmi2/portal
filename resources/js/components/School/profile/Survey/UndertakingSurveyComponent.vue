<template>
   <div class="row match-height">
		<div class="col-md-12 ">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-tooltip">School Survey: Undertakings</h4>
					
					<SurveyProgress :currentPage="8"></SurveyProgress>
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
        <div class="col-md-1">
        </div>
        <div class="col-md-10" style="text-align: center;">
            <div class="border  border-danger">
                <h3>NOTICE</h3>
                <P>
                    Public officers completing this form are reminded that <b>Civil Service Rule 04107 Section 1</b> requires the recording and supply of accurate data. Failure to do so amounts to gross misconduct punishable by sanctions that may include dismissal.
                </P>
            </div>
        </div>
        <div class="col-md-1">
        </div>
    </div>
    <br>

    <div class="row">
        <div class="col-md-1">
        </div>
        <div class="col-md-10">
            <label for="">
                <b>Attestation by Principal</b> <br>
                <span style="font-size: small;">I certify that the information I have given in this form is correct to the best of my knowledge.

                </span>
            </label>
        </div>
        <div class="col-md-1">
        </div>
    </div>
    <div class="row">
        <div class="col-md-1">
        </div>
        <div class="col-md-10">
            <div class="input-group">
                <span class="input-group-addon" id="basic-addon1">Name</span>
                <input v-model="undertaking.attestation_head_teacher_name" type="text" class="form-control" style="margin-left: -3px">
            </div>
        </div>
        <div class="col-md-1">
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-1">
        </div>
        <div class="col-md-10">
            <div class="input-group">
                <span class="input-group-addon" id="basic-addon1">Telephone</span>
                <input v-model="undertaking.attestation_head_teacher_phone" type="text" class="form-control" style="margin-left: -3px">
            </div>
        </div>
        <div class="col-md-1">
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-1">
        </div>
        <div class="col-md-5">
            <div class="input-group">
                <span class="input-group-addon" id="basic-addon1">Signature</span>
                <input type="file" @change="onImageChange" accept="image/*" data-error="teacher_signature_error" data-model="teacher_signature" data-preview="teacher_signature_image" class="form-control " style="margin-left: -3px">
                
            </div>
            <span v-if="teacher_signature_error">
                {{ teacher_signature_error }}
            </span> 
            <div v-if="teacher_signature_image">
                <img :src="teacher_signature_image" style="max-height:50px; max-width:150px">
            </div>
        </div>
        <div class="col-md-5">
            <div class="input-group">
                <span class="input-group-addon" id="basic-addon1">dd/mm/yy</span>
                <input v-model="undertaking.attestation_head_teacher_date" type="text" class="form-control" style="margin-left: -3px">
            </div>
        </div>
        <div class="col-md-1">
        </div>
    </div>
    <br>

    <div class="row">
        <div class="col-md-1">
        </div>
        <div class="col-md-10">
            <label for="">
                <b>Attestation by SBMC Chairperson/member</b> <br>
                <span style="font-size: small;">I have checked the information in this form and can confirm that it is complete.</span>
            </label>
        </div>
        <div class="col-md-1">
        </div>
    </div>
    <div class="row">
        <div class="col-md-1">
        </div>
        <div class="col-md-10">
            <div class="input-group">
                <span class="input-group-addon" id="basic-addon1">Name</span>
                <input v-model="undertaking.attestation_enumerator_name" type="text" class="form-control" style="margin-left: -3px">
            </div>
        </div>
        <div class="col-md-1">
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-1">
        </div>
        <div class="col-md-10">
            <div class="input-group">
                <span class="input-group-addon" id="basic-addon1">Position</span>
                <input v-model="undertaking.attestation_enumerator_position" type="text" class="form-control" style="margin-left: -3px">
            </div>
        </div>
        <div class="col-md-1">
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-1">
        </div>
        <div class="col-md-10">
            <div class="input-group">
                <span class="input-group-addon" id="basic-addon1">Telephone</span>
                <input v-model="undertaking.attestation_enumerator_phone" type="text" class="form-control" style="margin-left: -3px">
            </div>
        </div>
        <div class="col-md-1">
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-1">
        </div>
        <div class="col-md-5">
            <div class="input-group">
                <span class="input-group-addon" id="basic-addon1">Signature</span>
                <input type="file" @change="onImageChange" accept="image/*" data-error="moderator_signature_error" data-model="moderator_signature" data-preview="moderator_signature_image"  class="form-control" style="margin-left: -3px">
            </div>
            <span v-if="moderator_signature_error">
                {{ moderator_signature_error }}
            </span> 
            <div v-if="moderator_signature_image">
                <img :src="moderator_signature_image" style="max-height:50px; max-width:150px">
            </div>
        </div>
        <div class="col-md-5">
            <div class="input-group">
                <span class="input-group-addon" id="basic-addon1">dd/mm/yy</span>
                <input v-model="undertaking.attestation_enumerator_date" type="text" class="form-control" style="margin-left: -3px">
            </div>
        </div>
        <div class="col-md-1">
        </div>
    </div>
    <br>

    <div class="row">
        <div class="col-md-1">
        </div>
        <div class="col-md-10">
            <label for="">
                <b>Attestation by Supervisor</b> <br>
                <span style="font-size: small;">I have checked the information in this form and can confirm that it is complete.</span>
            </label>
        </div>
        <div class="col-md-1">
        </div>
    </div>
    <div class="row">
        <div class="col-md-1">
        </div>
        <div class="col-md-10">
            <div class="input-group">
                <span class="input-group-addon" id="basic-addon1">Name</span>
                <input v-model="undertaking.attestation_supervisor_name" type="text" class="form-control" style="margin-left: -3px">
            </div>
        </div>
        <div class="col-md-1">
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-1">
        </div>
        <div class="col-md-10">
            <div class="input-group">
                <span class="input-group-addon" id="basic-addon1">Position</span>
                <input v-model="undertaking.attestation_supervisor_position" type="text" class="form-control" style="margin-left: -3px">
            </div>
        </div>
        <div class="col-md-1">
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-1">
        </div>
        <div class="col-md-10">
            <div class="input-group">
                <span class="input-group-addon" id="basic-addon1">Telephone</span>
                <input v-model="undertaking.attestation_supervisor_phone" type="text" class="form-control" style="margin-left: -3px">
            </div>
        </div>
        <div class="col-md-1">
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-1">
        </div>
        <div class="col-md-5">
            <div class="input-group">
                <span class="input-group-addon" id="basic-addon1">Signature</span>
                <input type="file" @change="onImageChange" accept="image/*" data-error="supervisor_signature_error" data-model="supervisor_signature" data-preview="supervisor_signature_image" class="form-control" style="margin-left: -3px">
            </div>
            <span v-if="supervisor_signature_error">
                {{ supervisor_signature_error }}
            </span> 
            <div v-if="supervisor_signature_image">
                <img :src="supervisor_signature_image" style="max-height:50px; max-width:150px">
            </div>
        </div>
        <div class="col-md-5">
            <div class="input-group">
                <span class="input-group-addon" id="basic-addon1">dd/mm/yy</span>
                <input v-model="undertaking.attestation_supervisor_date" type="text" class="form-control" style="margin-left: -3px">
            </div>
        </div>
        <div class="col-md-1">
        </div>
    </div>
    <br>
    <br>
    <!-- <div class="row">
        <div class="col-md-12">
            <table class="border table border-success">
                <tr>
                    <td colspan="3" style="text-align: center; font-weight: bold">
                        FOR OFFICIAL USE ONLY 
                    </td>
                </tr>
                <tr>
                    <th>
                        Check
                    </th>
                    <th>
                        Checked By
                    </th>
                    <th>
                        Date
                    </th>
                </tr>
                <tr>
                    <th>
                        Field Cordinator Check
                    </th>
                    <td>
                        <input v-model="undertaking.main_subject" type="text" name="" id="" class="form-control">
                    </td>
                    <td>
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">dd/mm/yy</span>
                            <input type="number" class="form-control" style="margin-left: -3px">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        Pre-Data Entry Check
                    </th>
                    <td>
                        <input v-model="undertaking.main_subject" type="text" name="" id="" class="form-control">
                    </td>
                    <td>
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">dd/mm/yy</span>
                            <input type="number" class="form-control" style="margin-left: -3px">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        Data Entry completed
                    </th>
                    <td>
                        <input v-model="undertaking.main_subject" type="text" name="" id="" class="form-control">
                    </td>
                    <td>
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">dd/mm/yy</span>
                            <input type="number" class="form-control" style="margin-left: -3px">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        Verification Check
                    </th>
                    <td>
                        <input v-model="undertaking.main_subject" type="text" name="" id="" class="form-control">
                    </td>
                    <td>
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">dd/mm/yy</span>
                            <input type="number" class="form-control" style="margin-left: -3px">
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div> -->
							</div>

						</form>
							<div class="form-actions">
								<button v-if="! is_submitted" type="submit" class="btn btn-success" 
								 @click="submitSurvey()">
									<i class="icon-check2"></i> Save
								</button>
								<button type="button" class="btn btn-warning mr-1" @click="previousStage()">
									&lt;&lt; Previous Stage
								</button>
								<button v-if="! is_submitted" type="button" @click="surveyFinalSubmit()" class="btn btn-primary mr-1">
									Submit Survey
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
				undertaking: {
                    attestation_head_teacher_name : null,
                    attestation_head_teacher_phone : null,
                    attestation_head_teacher_date : null,
                    attestation_head_teacher_signature : null,

                    attestation_enumerator_name : null,
                    attestation_enumerator_phone : null,
                    attestation_enumerator_date : null,
                    attestation_enumerator_position : null,
                    attestation_enumerator_signature : null,

                    attestation_supervisor_name : null,
                    attestation_supervisor_phone : null,
                    attestation_supervisor_date : null,
                    attestation_supervisor_position : null,
                    attestation_supervisor_signature : null,
                },
				validationErrors: [],
				survey: null,
                teacher_signature : null,
                moderator_signature : null,
                supervisor_signature : null,
                teacher_signature_image : null,
                moderator_signature_image : null,
                supervisor_signature_image : null,
                teacher_signature_error: null,
                moderator_signature_error : null,
                supervisor_signature_error : null,

                is_submitted : false,

                baseUrl : '/eportal/public',

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
			
					if(this.survey.undertaking) {
                         this.undertaking = this.survey.undertaking;
                         this.teacher_signature_image = this.baseUrl + this.survey.undertaking.attestation_head_teacher_signature;
                         this.moderator_signature_image = this.baseUrl + this.survey.undertaking.attestation_enumerator_signature;
                         this.supervisor_signature_image = this.baseUrl + this.survey.undertaking.attestation_supervisor_signature;
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

				data.append('survey', this.surveyId)
                data.append('teacher_signature', this.teacher_signature)
                data.append('moderator_signature', this.moderator_signature)
                data.append('supervisor_signature', this.supervisor_signature)

                const obj = this.undertaking;
				Object.keys(obj).forEach(key=>{
					
					if(obj[key]==null){
						data.append(key, "");
					}
					else{
						data.append(key, obj[key]);
					}
					
				});

				this.$loading(true)

                axios.post('/api/school/surveys/create/undertaking', data)
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
					this.$alert("This is the last step of the survey, kindly submit button to final submit this survey","Survey Completed","success");
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

            surveyFinalSubmit() {
                
                let data = {
                    'survey' : this.surveyId
                }

                this.$confirm("Are you sure you want to submit this survey? Note: You will not be able to edit again","Submit Confirrm",'question').then(() => {
                
                    this.$loading(true)
                    axios.post('/api/school/surveys/create/submit', data)
                    .then(response => {
                        this.survey = response.data.data;
                        this.is_submitted = this.survey.submit_status;
                        this.$loading(false)
                        this.flashMessage.success({
                            title: 'Successful',
                            message: 'Survey submitted successfully',
                            time: 15000,
                            flashMessageStyle: {
                                backgroundColor: 'linear-gradient(#e66465, #9198e5)'
                            }
                        });
                    })
                    .catch(error => {
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

                        if(error.response.status === 400){
                            this.$alert(error.response.data.message, "Request Error","error");
                        }
                        
                    });
                });

			},

			previousStage() {
				
				this.$router.push({
					name: 'flhe-school-survey',
					params: { surveyId: this.surveyId }
                });
			},

            onImageChange(e) {
                let model = e.target.getAttribute('data-model')
                let preview = e.target.getAttribute('data-preview')
                let error = e.target.getAttribute('data-error')

                if(error == 'teacher_signature_error') this.teacher_signature_error = null;
                if(error == 'moderator_signature_error') this.moderator_signature_error = null;
                if(error == 'supervisor_signature_error') this.supervisor_signature_error = null;

                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
				if((files[0].type=='image/jpeg')|| (files[0].type=='image/jpg')||(files[0].type=='image/png')){
      				let max=2097152;

					if(files[0].size > max) {
						this.error = "File size too large, Maximum of 2MB"
					}

					this.createImage(files[0], model, preview);
    			}
				else{
                    if(error == 'teacher_signature_error') this.teacher_signature_error = "Invalid Image File"
                    if(error == 'moderator_signature_error') this.moderator_signature_error = "Invalid Image File"
                    if(error == 'supervisor_signature_error') this.supervisor_signature_error = "Invalid Image File"
					
				}
                
            },

            createImage(file, model, preview) {
                let reader = new FileReader();

                if(model == 'teacher_signature') this.teacher_signature = file;
                if(model == 'moderator_signature') this.moderator_signature = file;
                if(model == 'supervisor_signature') this.supervisor_signature = file;

                reader.onload = (e) => {
                    if(preview == 'teacher_signature_image') this.teacher_signature_image = e.target.result;
                    if(preview == 'moderator_signature_image') this.moderator_signature_image = e.target.result;
                    if(preview == 'supervisor_signature_image') this.supervisor_signature_image = e.target.result;
                };
                reader.readAsDataURL(file);
            },
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