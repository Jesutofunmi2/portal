<template>
   <div class="row match-height">
		<div class="col-md-12 ">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-tooltip">Student Registration</h4>
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

						<form class="form" novalidate @submit.prevent="updateStudent">
							<div class="form-body">
									
								<h4 class="form-section"><i class="icon-head"></i>Student Personal Info</h4>
								<div class="row">
									
									<div class="col-md-4">
										<div class="form-group">
											<label for="projectinput1">Surname</label>
											<input type="text" @keydown="validationErrors.surname=null" v-model="student.surname" :class="{'border-danger':validationErrors.surname}" class="form-control" placeholder="Surname" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Enter Surname" required>
											<span  v-if="validationErrors.surname" :class="['label text-danger']">{{ validationErrors.surname[0] }}</span>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="projectinput2">First Name</label>
											<input v-model="student.firstname" @keydown="validationErrors.firstname=null" type="text" :class="{'border-danger':validationErrors.firstname}" class="form-control" placeholder="First Name" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Enter First Name" required>
											<span  v-if="validationErrors.firstname" :class="['label text-danger']">{{ validationErrors.firstname[0] }}</span>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="projectinput2">Other Name</label>
											<input type="text" v-model="student.middlename" @keydown="validationErrors.middlename=null" :class="{'border-danger':validationErrors.middlename}"  class="form-control" placeholder="Other Name" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Enter Othername">
											<span  v-if="validationErrors.middlename" :class="['label text-danger']">{{ validationErrors.middlename[0] }}</span>
											
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-3">
										<div class="form-group">
											<label for="projectinput2">Date Of Birth</label>
											<input type="date" v-model="student.dob" @change="validationErrors.dob=null" :class="{'border-danger':validationErrors.dob}"  class="form-control" placeholder="Date of Birth" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Pick Date of Birth">
											<span  v-if="validationErrors.dob" :class="['label text-danger']">{{ validationErrors.dob[0] }}</span>
											
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label for="projectinput1">Gender</label>
											<select v-model="student.gender" @change="validationErrors.gender=null" class="form-control" :class="{'border-danger':validationErrors.gender}" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select Gender" required>
												<option selected value="">Select Gender</option>
												<option value="Male">Male </option>
												<option value="Female">Female </option>
											</select>
											<span  v-if="validationErrors.gender" :class="['label text-danger']">{{ validationErrors.gender[0] }}</span>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label for="projectinput1">Country</label>
											<select v-model="student.country" @change="validationErrors.country=null" class="form-control" :class="{'border-danger':validationErrors.country}" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select Country" required>
												<option selected value="">Select Country</option>
												<option value="Nigeria">Nigeria </option>
												<option value="Others">Others </option>
											</select>
											<span  v-if="validationErrors.country" :class="['label text-danger']">{{ validationErrors.country[0] }}</span>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label for="projectinput1">Blood Group</label>
											<select v-model="student.blood_group" @change="validationErrors.blood_group=null" class="form-control" :class="{'border-danger':validationErrors.blood_group}" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select Blood Group" required>
												<option selected value="">Blood Group</option>
												<option value="O+">O+</option>
												<option value="O-">O-</option>
												<option value="A+">A+</option>
												<option value="A-">A-</option>
												<option value="B+">B+</option>
												<option value="B-">B-</option>
												<option value="AB+">AB+</option>
												<option value="AB-">AB-</option>
											</select>
											<span  v-if="validationErrors.blood_group" :class="['label text-danger']">{{ validationErrors.blood_group[0] }}</span>
										</div>
									</div>
									
								</div>
								<div class="row">
									
									<div class="col-md-3">
										<div class="form-group">
											<label for="issueinput1">State of Origin</label>
											<select type="text" v-model="student.state_id" @change="getLga()" :class="{'border-danger':validationErrors.state_id}" class="form-control" placeholder="Select State of Origin"  data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select State of Origin" required>
												<option value="">Select State of Origin</option>
												<option v-for="state in states" :key="state.id" :value="state.id" >{{ state.name }}</option>
											</select>
											<span  v-if="validationErrors.state_id" :class="['label text-danger']">{{ validationErrors.state_id[0] }}</span>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label for="issueinput1">Local Govt Area. of Origin</label>
											<select  type="text" @change="validationErrors.lga_id=null" v-model="student.lga_id" class="form-control" :class="{'border-danger':validationErrors.lga_id}" placeholder="Select L.G.A. of origin"  data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select L.G.A. of Origin" required>
												<option value="">Select LGA</option>
												<option :value="lga.id" v-for ="(lga ,index) in state_lga" :key ="index" >{{ lga.name }}</option>
									
											</select>
											<span  v-if="validationErrors.lda_id" :class="['label text-danger']">{{ validationErrors.lga_id[0] }}</span>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="projectinput1">Contact Address</label>
											<input type="text" @keydown="validationErrors.address=null" v-model="student.address" class="form-control" :class="{'border-danger':validationErrors.address}" placeholder="Contact Address" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Enter Address" required>
										</div>
										<span  v-if="validationErrors.address" :class="['label text-danger']">{{ validationErrors.address[0] }}</span>
									</div>
									
								</div>
								<div class="row">
									<div class="col-md-3">
										<div class="form-group">
											<label for="projectinput1">Religion</label>
											<select v-model="student.religion" @change="validationErrors.religion=null" class="form-control" :class="{'border-danger':validationErrors.religion}" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select Religion" required>
												<option selected value="">Religion</option>
												<option value="Christian">Christian</option>
												<option value="Muslim">Muslim</option>
												<option value="Traditional">Traditional</option>
											</select>
											<span  v-if="validationErrors.religion" :class="['label text-danger']">{{ validationErrors.religion[0] }}</span>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label for="projectinput1">Student's  Phone No</label>
											<input type="text" @keydown="validationErrors.phone=null" v-model="student.phone" class="form-control" :class="{'border-danger':validationErrors.phone}" placeholder="Phone Number" name="phone_number" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Phone Number" required>
											<span  v-if="validationErrors.phone" :class="['label text-danger']">{{ validationErrors.phone[0] }}</span>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label for="projectinput1">Student's  Password</label>
											<input type="password" @keydown="validationErrors.password=null" v-model="student.password" class="form-control" :class="{'border-danger':validationErrors.password}" placeholder="Enter Student's Password" name="password" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Enter Student's Password" required>
											<span  v-if="validationErrors.password" :class="['label text-danger']">{{ validationErrors.password[0] }}</span>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label for="projectinput1">Confirm  Password</label>
											<input type="password" @keydown="validationErrors.password_confirmation=null" v-model="student.password_confirmation" :class="{'border-danger':validationErrors.password_confirmation}" class="form-control" placeholder="Confirm Password" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Confirm Password" required>
											<span  v-if="validationErrors.password_confirmation" :class="['label text-danger']">{{ validationErrors.password_confirmation[0] }}</span>
										</div>
									</div>
									
								</div>
								<h4 class="form-section"><i class="icon-head"></i>Parent or Guardian Information</h4>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="">Parent or Guardian Fullname </label>
											<input type="text" @keydown="validationErrors.parent_fullname=null" v-model="student.parent_fullname" :class="{'border-danger':validationErrors.parent_fullname}" class="form-control" placeholder="Parent or Guardian Fullname" name="" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Parent or Guardian Fullname" required>
											<span  v-if="validationErrors.parent_fullname" :class="['label text-danger']">{{ validationErrors.parent_fullname[0] }}</span>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="">Contact Address </label>
											<input type="text" @keydown="validationErrors.parent_address=null" v-model="student.parent_address" :class="{'border-danger':validationErrors.parent_address}" class="form-control" placeholder="Contact Address" name="" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Contact Address" required>
											<span  v-if="validationErrors.parent_address" :class="['label text-danger']">{{ validationErrors.parent_address[0] }}</span>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="">Parent or Guardian Phone Number </label>
											<input type="text" @keydown="validationErrors.parent_phone=null" v-model="student.parent_phone" :class="{'border-danger':validationErrors.parent_phone}" class="form-control" placeholder="Parent or Guardian Phone Number" name="" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Parent or Guardian Phone Number" required>
											<span  v-if="validationErrors.parent_phone" :class="['label text-danger']">{{ validationErrors.parent_phone[0] }}</span>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="">Parent or Guardian Email</label>
											<input type="email" @keydown="validationErrors.parent_email=null" v-model="student.parent_email" :class="{'border-danger':validationErrors.parent_email}" class="form-control" placeholder="Parent or Guardian Email" name="" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Parent or Guardian Email" required>
											<span  v-if="validationErrors.parent_email" :class="['label text-danger']">{{ validationErrors.parent_email[0] }}</span>
										</div>
									</div>
								</div>
							
								<h4 class="form-section"><i class="icon-office"></i>Student Academic Information</h4>
								<div class="row">
									
									<div class="col-md-3">
										<div class="form-group">
											<label for="issueinput1">School State</label>
											<select  type="text" class="form-control" placeholder="Select State"  data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select State" required >
												<option value="">Select State</option>
												<option selected="selected" >{{ state }}</option>
											</select>
											
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label for="issueinput1">School Local Govt Area.</label>
											<select  type="text" v-model="school_lga_id" @change="getSchools()" class="form-control" placeholder="Select Loca Govt Aarea."  data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select Local Govt Area." required>
												<option selected="selected" value="">Select LGA</option>
												<option :value="lga.id" v-for ="(lga ,index) in lgas" :key ="index" >{{ lga.name }}</option>
									
											</select>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label for="issueinput1">School </label>
											<select  type="text" @change="getClass()" v-model="student.school_id" class="form-control" placeholder="Select School" :class="{'border-danger':validationErrors.school_id}"  data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select School" required>
												<option value="">Select School</option>
												<option :value="school.id" v-for ="school in schools" :key ="school.id" >{{ school.name }}</option>
									
											</select>
											<span  v-if="validationErrors.school_id" :class="['label text-danger']">{{ validationErrors.school_id[0] }}</span>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label for="issueinput1">School House</label>
											<select  type="text" @change="validationErrors.house_id=null" v-model="student.house_id" class="form-control" :class="{'border-danger':validationErrors.house_id}"  data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select School House" required>
												<option value="">Select School</option>
												<option :value="house.id" v-for ="house in houses" :key ="house.id" >{{ house.name }}</option>
									
											</select>
											<span  v-if="validationErrors.house_id" :class="['label text-danger']">{{ validationErrors.house_id[0] }}</span>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-3">
										<div class="form-group">
											<label for="projectinput1">Session</label>
											<select v-model="student.session"  @change="validationErrors.session=null" class="form-control" :class="{'border-danger':validationErrors.session}" placeholder="Session"  data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select Session" required>
												<option value="" >Select Session</option>
												<option v-for="year in session()" :key="year" :value="year">{{year}}/{{year+1}}</option>
											</select>
											<span  v-if="validationErrors.session" :class="['label text-danger']">{{ validationErrors.session[0] }}</span>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label for="projectinput1">Term</label>
											<select v-model="student.term" @change="validationErrors.term=null" class="form-control" :class="{'border-danger':validationErrors.term}" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select Term" required>
												<option selected value="">Select Term</option>
												<option value="First">First Term</option>
												<option value="Second">Second Term</option>
												<option value="Third">Third Term</option>
											</select>
											<span  v-if="validationErrors.term" :class="['label text-danger']">{{ validationErrors.term[0] }}</span>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label for="projectinput1">Class</label>
											<select v-model="student.class_id"  @change="getClassArms()" class="form-control" :class="{'border-danger':validationErrors.class_id}"  data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select Class" required>
												<option value="" >Select Class</option>
												<option :value="clas.id" v-for ="clas in classes" :key ="clas.id" >{{ clas.class_name }}</option>
											</select>
											<span  v-if="validationErrors.class_id" :class="['label text-danger']">{{ validationErrors.class_id[0] }}</span>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label for="projectinput1">Class Arm</label>
											<select v-model="student.class_arm_id"  @change="validationErrors.class_arm_id=null" class="form-control" :class="{'border-danger':validationErrors.class_arm_id}"  data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select Class Arm" required>
												<option value="" >Select Class Arm</option>
												<option :value="class_arm.id" v-for ="class_arm in class_arms" :key ="class_arm.id" >{{ class_arm.class_arm }}</option>
											</select>
											<span  v-if="validationErrors.class_arm_id" :class="['label text-danger']">{{ validationErrors.class_arm_id[0] }}</span>
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

    export default {
	components: {
		
		},
		data(){
			return {
				state : '',
				states : [],
				lgas : [],
				school_lga_id : null,
				state_lga : [],
				schools: [],
				houses:null,
				classes:null,
				class_arms:null,
				studentId: this.$route.params.studentId,
				
				student : {
					surname :null,
					firstname: null,
					middlename:null,
					school_id :null,
					dob:null,
					phone:null,
					gender:null,
					country:null,
					address:null,
					state_id:null,
					lga_id:null,
					religion:null,
					password:null,
					password_confirmation:null,
					parent_fullname:null,
					parent_address:null,
					parent_email:null,
					parent_phone:null,
					session:null,
					house_id:null,
					blood_group:null,
					term:null,
					class_id:null,
					class_arm_id:null
				},
				validationErrors: []
			}
		},
        mounted() {
			this.getState();
        },

		methods : {
			
			getState(){
				this.$loading(true)
				axios.get('/api/general/get_state')
				.then((res) => {
					this.state = res.data.state;
					this.lgas = res.data.data;
					this.$loading(false);
					this.getAllState();
					this.getStudent();
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

			getAllState(){
				this.$loading(true)
				axios.get('/api/general/get_state/all')
				.then((res) => {
					this.states = res.data.data.states,
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

			getLga(){
				if(this.validationErrors && this.validationErrors.state_id!=null) this.validationErrors.state_id=null;
				this.$loading(true);
				axios.get('/api/general/get_lga?state_id='+this.student.state_id)
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
					
				})
			},

            updateStudent(){
				let data = new FormData;
				const obj = this.student;
				Object.keys(obj).forEach(key=>{
					
					if(obj[key]==null){
						//data.append(key, "");
					}
					else{
						data.append(key, obj[key]);
					}
					
				});
	
				this.$loading(true)

                axios.post('/api/ministry/student/'+this.studentId+'/update',data)
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
							name: 'cas-login',
							params: { return_url: return_url }
							});
					}
					if(error.response.status === 403){
						this.$alert("Sorry, you do not have the permission to perfrom this action","No Permission","error");
					}
					
				});
            },

			getSchools(){
                if(this.school_lga_id == null || this.school_lga_id=='') return ;
                this.$loading(true);
				axios.get('/api/general/school/secondary/view?lga_id='+this.school_lga_id)
				.then((res) => {
					this.schools = res.data.data.schools,
					this.$loading(false)
				})
				.catch((error) => {
                    this.$loading(false)
                    if (!error.response) {
						this.$alert("You do not have internet access","Network Error","error");
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
			session(){
				const d = new Date();
				const n = d.getFullYear();
				const year = [];
				for (let index = 2010; index <= n; index++) {
					year.push(index);
				}
				return year;
			},

			getClass(){
				if(this.validationErrors && this.validationErrors.school_id!=null) this.validationErrors.school_id=null;
				if(this.student.school_id == null || this.student.school_id=='') return ;
                this.$loading(true);
				axios.get('/api/general/school/getClasses/'+this.student.school_id)
				.then((res) => {
					this.classes = res.data.data.classes;
					this.houses = res.data.data.houses;
					this.$loading(false);
					this.student.class_arm_id = null;
					this.student.class_id = null;

				})
				.catch((error) => {
                    this.$loading(false)
                    if (!error.response) {
						this.$alert("You do not have internet access","Network Error","error");
						return ;
					}
			
				})
			},
			getClassArms(){
				if(this.validationErrors && this.validationErrors.class_id!=null) this.validationErrors.class_id=null;
				if(this.student.class_id == null || this.student.class_id=='') return ;
                this.$loading(true);
				axios.get('/api/general/school/getClassArms/'+this.student.class_id)
				.then((res) => {
					this.class_arms = res.data.data.class_arms,
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
			getStudent(){
				 this.$loading(true);
				axios.get('/api/ministry/student/'+this.studentId+'/edit')
				.then((res) => {
					const obj  = res.data.data.student;
					Object.keys(obj).forEach(key=>{
							this.student[key] = obj[key];
					});
					if (res.data.data.class_arms) this.class_arms = res.data.data.class_arms;
					if (res.data.data.classes) this.classes = res.data.data.classes;
					if (res.data.data.school_houses) this.houses = res.data.data.school_houses;
					if (res.data.data.student_class) this.student.class_id = res.data.data.student_class.class_id;
					if (res.data.data.student_class) this.student.class_arm_id = res.data.data.student_class.pivot.classarm_id;
					if (res.data.data.student_class) this.student.session = res.data.data.student_class.pivot.session;
					if (res.data.data.student_class) this.student.term = res.data.data.student_class.pivot.term;
					if (res.data.data.school) this.schools = res.data.data.school;
					if (res.data.data.school.lga_id) this.school_lga_id = res.data.data.school.lga_id;
					this.$loading(false);
					this.getLga();
					this.getSchools();
				})
				.catch((error) => {
                    this.$loading(false)
                    if (!error.response) {
						this.$alert("You do not have internet access","Network Error","error");
						return ;
					}
					
				})
			}

		}
    }
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>