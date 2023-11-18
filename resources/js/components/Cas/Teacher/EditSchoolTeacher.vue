<template>
   <div class="row match-height">
		<div class="col-md-12 ">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-tooltip">Edit Teacher</h4>
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

						<form class="form" @submit.prevent="updateTeacher">
							<div class="form-body">
									
								<h4 class="form-section"><i class="icon-head"></i>Teacher Personal Info</h4>
								<div class="row">
									<div class="col-md-3">
										<div class="form-group">
											<label for="projectinput1">Title</label>
											<select class="form-control"  @change="validationErrors.title=null" v-model="teacher.title" :class="{'border-danger':validationErrors.title}"  data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select Title" required>
												
												<option value="MR">MR </option>
												<option value="MRS">MRS </option>
												<option value="MS">MS </option>
												<option value="MISS">MISS </option>
												<option value="DR">DR </option>
												<option value="ENGR">ENGR </option>
												<option value="PROF">PROF </option>
											</select>
											<span  v-if="validationErrors.title" :class="['label text-danger']">{{ validationErrors.title[0] }}</span>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label for="projectinput1">Surname</label>
											<input type="text" @keydown="validationErrors.surname=null" v-model="teacher.surname" :class="{'border-danger':validationErrors.surname}" class="form-control" placeholder="Surname" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Enter Surname" required>
											<span  v-if="validationErrors.surname" :class="['label text-danger']">{{ validationErrors.surname[0] }}</span>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label for="projectinput2">First Name</label>
											<input v-model="teacher.firstname" @keydown="validationErrors.firstname=null" type="text" :class="{'border-danger':validationErrors.firstname}" class="form-control" placeholder="First Name" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Enter First Name" required>
											<span  v-if="validationErrors.firstname" :class="['label text-danger']">{{ validationErrors.firstname[0] }}</span>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label for="projectinput2">Other Name</label>
											<input type="text" v-model="teacher.middlename" @keydown="validationErrors.middlename=null" :class="{'border-danger':validationErrors.middlename}"  class="form-control" placeholder="Other Name" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Enter Othername">
											<span  v-if="validationErrors.middlename" :class="['label text-danger']">{{ validationErrors.middlename[0] }}</span>
											
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label for="projectinput1">Gender</label>
											<select v-model="teacher.gender" @change="validationErrors.gender=null" class="form-control" :class="{'border-danger':validationErrors.gender}" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select Gender" required>
												<option selected value="">Select Gender</option>
												<option value="Male">Male </option>
												<option value="Female">Female </option>
											</select>
											<span  v-if="validationErrors.gender" :class="['label text-danger']">{{ validationErrors.gender[0] }}</span>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="projectinput1">Qualification</label>
											<input type="text" v-model="teacher.qualification" @keydown="validationErrors.qualification=null" :class="{'border-danger':validationErrors.qualification}" class="form-control" placeholder="Qualification" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Enter Qualification" required>
											<span  v-if="validationErrors.qualification" :class="['label text-danger']">{{ validationErrors.qualification[0] }}</span>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="projectinput1">Subject Area</label>
												<multiselect v-model="teacher.subjects" tag-placeholder="Select Subject" :class="{'border-danger':validationErrors.subjects}" placeholder="Select Subject" :options="subjects" :multiple="true" :taggable="true" @tag="addTag" label="subject_name" track-by="id"></multiselect>
												<span  v-if="validationErrors.subjects" :class="['label text-danger']">{{ validationErrors.subjects[0] }}</span>
										</div>
									</div>
									
								</div>
								<div class="row">
									
									<div class="col-md-3">
										<div class="form-group">
											<label for="issueinput1">State of Origin</label>
											<select type="text" v-model="teacher.state_id" @change="getLga()" :class="{'border-danger':validationErrors.state_id}" class="form-control" placeholder="Select State of Origin"  data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select State of Origin" required>
												<option value="">Select State of Origin</option>
												<option v-for="state in states" :key="state.id" :value="state.id" >{{ state.name }}</option>
											</select>
											<span  v-if="validationErrors.state_id" :class="['label text-danger']">{{ validationErrors.state_id[0] }}</span>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label for="issueinput1">Local Govt Area. of Origin</label>
											<select  type="text" @change="validationErrors.lga_id=null" v-model="teacher.lga_id" class="form-control" :class="{'border-danger':validationErrors.lga_id}" placeholder="Select L.G.A. of origin"  data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select L.G.A. of Origin" required>
												<option value="">Select LGA</option>
												<option :value="lga.id" v-for ="(lga ,index) in state_lga" :key ="index" >{{ lga.name }}</option>
									
											</select>
											<span  v-if="validationErrors.lda_id" :class="['label text-danger']">{{ validationErrors.lga_id[0] }}</span>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="projectinput1">Contact Address</label>
											<input type="text" @keydown="validationErrors.address=null" v-model="teacher.address" class="form-control" :class="{'border-danger':validationErrors.address}" placeholder="Contact Address" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Enter Address" required>
										</div>
										<span  v-if="validationErrors.address" :class="['label text-danger']">{{ validationErrors.address[0] }}</span>
									</div>
									
								</div>
								<div class="row">
									
									<div class="col-md-4">
										<div class="form-group">
											<label for="projectinput1">Teacher's  Phone No</label>
											<input type="text" @keydown="validationErrors.phone=null" v-model="teacher.phone" class="form-control" :class="{'border-danger':validationErrors.phone}" placeholder="Phone Number" name="phone_number" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Phone Number" required>
											<span  v-if="validationErrors.phone" :class="['label text-danger']">{{ validationErrors.phone[0] }}</span>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="projectinput1">Teacher's  Email</label>
											<input type="email" @keydown="validationErrors.email=null" v-model="teacher.email" class="form-control" :class="{'border-danger':validationErrors.email}" placeholder="Enter Teacher's Email" name="email" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Enter Teacher's Email" required>
											<span  v-if="validationErrors.email" :class="['label text-danger']">{{ validationErrors.email[0] }}</span>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="issueinput1">Marital Status</label>
											<select  v-model="teacher.marital_status" @change="validationErrors.marital_status=null" class="form-control" :class="{'border-danger':validationErrors.marital_status}"  data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select Marital Status" required>
												<option value="">Marital Status</option>
												<option value="Single">Single</option>
												<option value="Married">Married</option>
												<option value="Divorce">Divorce</option>
											</select>
											<span  v-if="validationErrors.marital_status" :class="['label text-danger']">{{ validationErrors.marital_status[0] }}</span>
										</div>
									</div>
								</div>
								<div class="row">
									
									<div class="col-md-4">
										<div class="form-group">
											<label for="projectinput1">Session</label>
											<select v-model="teacher.session"  @change="validationErrors.session=null" class="form-control" :class="{'border-danger':validationErrors.session}" placeholder="Session"  data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select Session" required>
												<option value="" >Select Session</option>
												<option v-for="year in session()" :key="year" :value="year">{{year}}/{{year+1}}</option>
											</select>
											<span  v-if="validationErrors.session" :class="['label text-danger']">{{ validationErrors.session[0] }}</span>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="projectinput1">Teacher's  Password</label>
											<input type="password" @keydown="validationErrors.password=null" v-model="teacher.password" class="form-control" :class="{'border-danger':validationErrors.password}" placeholder="Enter Teacher's Password" name="password" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Enter Teacher's Password">
											<span  v-if="validationErrors.password" :class="['label text-danger']">{{ validationErrors.password[0] }}</span>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="projectinput1">Confirm  Password</label>
											<input type="password" @keydown="validationErrors.password_confirmation=null" v-model="teacher.password_confirmation" :class="{'border-danger':validationErrors.password_confirmation}" class="form-control" placeholder="Confirm Password" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Confirm Password">
											<span  v-if="validationErrors.password_confirmation" :class="['label text-danger']">{{ validationErrors.password_confirmation[0] }}</span>
										</div>
									</div>
								</div>
								<h4 class="form-section"><i class="icon-medkit"></i>Teacher Health Information</h4>
								<div class="row">
									
									<div class="col-md-4">
										<div class="form-group">
											<label for="projectinput1">Health</label>
											<select v-model="teacher.health_status" @change="validationErrors.health_status=null" class="form-control" placeholder="Select Health" :class="{'border-danger':validationErrors.health_status}"  data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select Health" required>
												<option value="">Select Health</option>
												<option value="Normal">Normal</option>
												<option value="Disable">Disable</option>
											</select>
											<span  v-if="validationErrors.health_status" :class="['label text-danger']">{{ validationErrors.health_status[0] }}</span>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="projectinput1">Extra Curricular Activities</label>
											<input type="text" @keydown="validationErrors.extra_curricular_activites=null" v-model="teacher.extra_curricular_activites" class="form-control" placeholder="Extra Curricular Activities"  data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Extra Curricular Activities">
											<span  v-if="validationErrors.extra_curricular_activites" :class="['label text-danger']">{{ validationErrors.extra_curricular_activites[0] }}</span>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="projectinput1">Health Status Description</label>
											<textarea @keydown="validationErrors.health_status_desc=null" v-model="teacher.health_status_desc" class="form-control" :class="{'border-danger':validationErrors.health_status_desc}"  name="" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Health Status Description" required></textarea>
											<span  v-if="validationErrors.health_status_desc" :class="['label text-danger']">{{ validationErrors.health_status_desc[0] }}</span>
										</div>
									</div>
								</div>
								<h4 class="form-section"><i class="icon-ios-personadd"></i>Next of Kin Information</h4>
								<div class="row">
									
									<div class="col-md-4">
										<div class="form-group">
											<label for="">Next of Kins Fullname</label>
											<input v-model="teacher.next_of_kins" @keydown="validationErrors.next_of_kins=null" type="text" id="" :class="{'border-danger':validationErrors.next_of_kins}" class="form-control" placeholder="Next of Kins Fullname" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Next of Kins Fullname" required>
											<span  v-if="validationErrors.next_of_kins" :class="['label text-danger']">{{ validationErrors.next_of_kins[0] }}</span>
										</div>
									</div>
									<div class="col-md-8">
										<div class="form-group">
											<label for="">Next of kins Contact Address </label>
											<input type="text" @keydown="validationErrors.next_of_kins_address=null" v-model="teacher.next_of_kins_address" :class="{'border-danger':validationErrors.next_of_kins_address}" class="form-control" placeholder="Next of kins Contact Address" name="" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Next of kins Contact Address" required>
											<span  v-if="validationErrors.next_of_kins_address" :class="['label text-danger']">{{ validationErrors.next_of_kins_address[0] }}</span>
										</div>
									</div>
									
								</div>
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label for="">Next of kins Phone Number </label>
											<input type="text" @keydown="validationErrors.next_of_kins_phone=null" v-model="teacher.next_of_kins_phone" :class="{'border-danger':validationErrors.next_of_kins_phone}" class="form-control" placeholder="Next of kins Phone Number" name="" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Next of kins Phone Number" required>
											<span  v-if="validationErrors.next_of_kins_phone" :class="['label text-danger']">{{ validationErrors.next_of_kins_phone[0] }}</span>
										</div>
									</div>
									<div class="col-md-8">
										<div class="form-group">
											<label for="">Next of Kins Email</label>
											<input type="email" v-model="teacher.next_of_kins_email" class="form-control" placeholder="Next of Kins Email" name="" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Next of Kins Email">
										</div>
									</div>
									
								</div>
								


							</div>

							<div class="form-actions">
								<button type="button" class="btn btn-warning mr-1">
									<i class="icon-cross2"></i> Cancel
								</button>
								<button type="submit" class="btn btn-primary">
									<i class="icon-check2"></i> Save
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<FlashMessage></FlashMessage>

	</div>
	
</template>

<script>
import Multiselect from 'vue-multiselect'

    export default {
	components: {
		Multiselect
		},
		data(){
			return {
				states : [],
				state_lga : [],
				subjects: [],
				teacherId : this.$route.params.teacherId,
				dbTeacher : [],
		
				teacher : {
					title : null,
					surname : null,
					firstname : null,
					middlename : null,
					school_id : null,
					staff_no : null,
					staff_no_digit : null,
					qualification : null,
					gender : null,
					address : null,
					email : null,
					phone : null,
					session : null,
					state_id : null,
					lga_id : null,
					subjects : [],
					password : null,
					password_confirmation : null,
					next_of_kins : null,
					next_of_kins_address : null,
					next_of_kins_phone : null,
					next_of_kins_email : null,
					health_status : null,
					extra_curricular_activites : null,
					health_status_desc : null,
					marital_status : null,
				},
				validationErrors: []
			}
		},
        mounted() {
			this.getAllState();
        },

		methods : {
			addTag(newTag) {
				this.teacher.subjects.push(newTag);
				},
			
			getAllState(){
				this.$loading(true)
				axios.get('/api/general/get_state/all')
				.then((res) => {
					this.states = res.data.data.states;
					this.$loading(false);
					this.getSubjects();
					this.getTeacher();
				})
				.catch((error) => {
					this.$loading(false)
					if (!error.response) {
						this.$alert("You do not have internet access","Network Error","error");
						return ;
					}
	
				})
			},

			getLga(){
				if(this.validationErrors && this.validationErrors.state_id!=null) this.validationErrors.state_id=null;
				this.$loading(true);
				axios.get('/api/general/get_lga?state_id='+this.teacher.state_id)
				.then((res) => {
					this.state_lga = res.data.data,
					this.$loading(false)
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
									name: 'ministry-login',
									params: { return_url: return_url }
									});
					}
	
				})
			},

			getSubjects(){
				this.$loading(true)
				axios.get('/api/general/getSubjects')
				.then((res) => {
					this.subjects = res.data.data,
					this.$loading(false)
				})
				.catch((error) => {
					this.$loading(false)
					if (!error.response) {
						this.$alert("You do not have internet access","Network Error","error");
						return ;
					}
				})
			},
			
            updateTeacher(){
				let data = new FormData;
				const obj = this.teacher;
				Object.keys(obj).forEach(key=>{
					if(key=='subjects'){
						if(obj[key].length !==0){
							const subjects = obj[key];
							for (let index = 0; index < subjects.length; index++) {
								const element = subjects[index];
								data.append('subjects[]',element.id );
							}
						}
						else{
							data.append('subjects[]', "");
						}
						
					}
					else if((key=='password') && (obj[key]!=null)){
						data.append(key, obj[key]);
					}
					else if(obj[key]!=null){
						data.append(key, obj[key]);
					}
					
				});
	
				this.$loading(true)

                axios.post('/api/ministry/school/teacher/'+this.teacherId+'/update',data)
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
	
                    }
				
                })
				.catch(error => {
					this.$loading(false)
					if (!error.response) {
						this.$alert("You do not have internet access","Network Error","error");
						return ;
					}
					if (error.response.status == 409){
					this.flashMessage.error({title: 'Registration Error', 
											message: error.response.data.message,
											time: 15000, });
					}

					if (error.response.status == 422){
					this.validationErrors = error.response.data.errors;
					this.flashMessage.error({title: 'Validation Error', 
											message: 'Their is Error with the Data you supplied',
											time: 15000, });
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
					
				});
            },

			getTeacher(){
                this.$loading(true);
				axios.get('/api/ministry/school/teacher/'+this.teacherId+'/edit')
				.then((res) => {
					const obj  = res.data.data;
					Object.keys(obj).forEach(key=>{
							this.teacher[key] = obj[key];
					});
					this.$loading(false);
					this.getLga();
				})
				.catch((error) => {
                    this.$loading(false)
                    if (!error.response) {
						this.$alert("You do not have internet access","Network Error","error");this.$router.go(-1) ;
						return ;
					}
					if(error.response.status === 401){
						let return_url = window.location.pathname;
						this.$router.push({
									name: 'ministry-login',
									params: { return_url: return_url }
									});
					}
				})
            },
			session(){
				const d = new Date();
				const n = d.getFullYear();
				const year = [];
				for (let index = 2010; index <= n; index++) {
					year.push(index);
				}
				return year;
			}

		}
    }
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>