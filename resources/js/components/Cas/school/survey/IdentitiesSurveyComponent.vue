<template>
   <div class="row match-height">
		<div class="col-md-12 ">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-tooltip">School Survey: School Identification</h4>
					
					<SurveyProgress :currentPage="0"></SurveyProgress>
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
									<div class="form-group col-md-6">
										<label for="issueinput48">School Code</label>
										<input readonly type="text" @keydown="validationErrors.school_code=null" :class="{'border-danger':validationErrors.school_code}" v-model="school_code" class="form-control"  placeholder="Enter School Code" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Enter School Code">
										<span  v-if="validationErrors.school_code" :class="['label text-danger']">{{ validationErrors.school_code[0] }}</span>
									</div>

									<div class="form-group col-md-6">
										<label for="issueinput48">School Name</label>
										<input readonly type="text" @keydown="validationErrors.name=null" :class="{'border-danger':validationErrors.name}" v-model="school_name" class="form-control"  placeholder="Enter School Name" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Enter School Name">
										<span  v-if="validationErrors.name" :class="['label text-danger']">{{ validationErrors.name[0] }}</span>
									</div>
								</div>

								<div class="row">
									<div class="form-group col-md-4">
										<label for="issueinput48">Elevation (Meter)</label>
										<input readonly type="text" @keydown="validationErrors.elevation=null" :class="{'border-danger':validationErrors.elevation}" v-model="elevation" class="form-control"  placeholder="Enter Elevation (Meter)" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Enter Elevation (Meter)">
										<span  v-if="validationErrors.elevation" :class="['label text-danger']">{{ validationErrors.elevation[0] }}</span>
									</div>
									<div class="form-group col-md-4">
										<label for="issueinput48">Longitude East</label>
										<input readonly type="text" @keydown="validationErrors.school_lat=null" :class="{'border-danger':validationErrors.school_lat}" v-model="school_lat" class="form-control"  placeholder="Enter School Longitude East" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Enter School Longitude East">
										<span  v-if="validationErrors.school_lag" :class="['label text-danger']">{{ validationErrors.school_lag[0] }}</span>
									</div>
									<div class="form-group col-md-4">
										<label for="issueinput48">Longitude East</label>
										<input readonly type="text" @keydown="validationErrors.school_long=null" :class="{'border-danger':validationErrors.school_long}" v-model="school_long" class="form-control"  placeholder="Enter School Longitude East" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Enter School Longitude East">
										<span  v-if="validationErrors.school_long" :class="['label text-danger']">{{ validationErrors.school_long[0] }}</span>
									</div>
								</div>

								<div class="row">
									<div class="form-group col-md-6">
										<label for="issueinput08">School Phone</label>
										<input readonly type="text" @keydown="validationErrors.phone=null" :class="{'border-danger':validationErrors.phone}" v-model="phone" class="form-control"  placeholder="Enter Phone Number" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Enter Phone Number">
										<span  v-if="validationErrors.phone" :class="['label text-danger']">{{ validationErrors.phone[0] }}</span>
									</div>
									<div class="form-group col-md-6">
										<label for="issueinput08">School Email Address</label>
										<input readonly type="email" @keydown="validationErrors.email=null" :class="{'border-danger':validationErrors.email}" v-model="email" class="form-control"  placeholder="Enter School Email" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Enter School Email">
										<span  v-if="validationErrors.email" :class="['label text-danger']">{{ validationErrors.email[0] }}</span>
									</div>
								</div>

								<div class="row">
									<div class="form-group col-md-4">
										<label for="issueinput10">Local Goverment Area</label>
										<select readonly id="issueinput10" v-model="lga_id" :class="{'border-danger':validationErrors.lga_id}" class="form-control" name="lga_id" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Local Goverment Area" required>
											<option :value="lga.id" v-for ="(lga ,index) in lgas" :key ="index" >{{ lga.name }}</option>
										</select>
										<span  v-if="validationErrors.lga_id" :class="['label text-danger']">{{ validationErrors.lga_id[0] }}</span>
									</div>
									<div class="form-group col-md-4">
										<label for="issueinput08">Ward</label>
										<input readonly type="text" @keydown="validationErrors.ward=null" :class="{'border-danger':validationErrors.ward}" v-model="ward" class="form-control"  placeholder="Enter Ward" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Enter Ward">
										<span  v-if="validationErrors.ward" :class="['label text-danger']">{{ validationErrors.ward[0] }}</span>
									</div>

									<div class="form-group col-md-4">
										<label for="issueinput08">Village/Town</label>
										<input readonly type="text" @keydown="validationErrors.town=null" :class="{'border-danger':validationErrors.town}" v-model="town" class="form-control"  placeholder="Enter Village/Town" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Enter Village/Town">
										<span  v-if="validationErrors.town" :class="['label text-danger']">{{ validationErrors.town[0] }}</span>
									</div>
								</div>

								<div class="row">
									<div class="form-group col-md-12">
										<label for="issueinput17">Address</label>
										<textarea readonly id="issueinput17" @keydown="validationErrors.address=null" :class="{'border-danger':validationErrors.address}" v-model="address" rows="5" class="form-control" name="address" placeholder="Address" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Address"></textarea>
										<span  v-if="validationErrors.address" :class="['label text-danger']">{{ validationErrors.address[0] }}</span>
									</div>
								</div>
								
							</div>

						</form>
							<div class="form-actions">
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
				school_name: '',
				school_code: '',
				elevation: '',
				school_lat: '',
				school_long: '',
				phone: '',
				address: '',
				lga_id: '',
				ward: '',
				town: '',
				email: '',
				lga_name: '',
				lgas: [],
				validationErrors: [],
				survey: null,
				data_exist: false,

				is_submitted : false
			}
		},
        mounted() {
			window.scrollTo(0, 0);
			this.getState();
        },

		methods : {
			getState() {
				this.$loading(true)
				axios.get('/api/general/get_state')
				.then((res) => {
					this.state = res.data.state;
					this.lgas = res.data.data;
					this.getSurvey();
					this.$loading(false);
				})
				.catch((error) => {
					this.$loading(false)
					if (!error.response) {
						this.$alert("You do not have internet access","Network Error","error");
						this.$router.go(-1) ;
						return ;
					}
					if(error.response.status === 401){
						let return_url = window.location.pathname;
						this.$router.push({
									name: 'cas-login',
									params: { return_url: return_url }
									});
					}

				})
			},
			getSurvey() {
				this.$loading(true)
				axios.get(`/api/ministry/school/survey/show?survey=${this.surveyId}`)
				.then((res) => {
					this.survey = res.data.data;
					let identities = this.survey.identities;
					this.is_submitted = this.survey.submit_status;
					
					if(identities) {
						this.data_exist = true;
						this.school_name = identities.school_name;
						this.school_code = identities.school_code;
						this.elevation = identities.elevation;
						this.school_lat = identities.school_lat;
						this.school_long = identities.school_long;
						this.phone = identities.phone;
						this.address = identities.address;
						this.lga_id = identities.lga_id;
						this.lga_name = identities.lga_name;
						this.ward = identities.ward;
						this.town = identities.town;
						this.email = identities.email;
					}
					
					this.$loading(false)
				})
				.catch((error) => {
                    this.$loading(false);
					if (!error.response) {
						this.$alert("You do not have internet access","Network Error","error");
						return ;
					}

					if(error.response.status === 400){
						this.$alert(error.response.data.message, "Request Error","error");
					}

					if(error.response.status === 401){
						let return_url = window.location.pathname;
						this.$router.push({
							name: 'cas-login',
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
					name: 'cas-characteristics-school-survey',
					params: { surveyId: this.surveyId }
                });
			}
		}
    }
</script>