<template>
   <div class="row match-height">
		<div class="col-md-12 ">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-tooltip">Batch Student Registration</h4>
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

						<form class="form" novalidate @submit.prevent="createStudentBatch">
							<div class="form-body">
								<h4 class="form-section"><i class="icon-office"></i> Student Academic Information</h4>
								
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label for="issueinput1">School State</label>
											<select  type="text" class="form-control" placeholder="Select State"  data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select State" required >
												<option value="">Select State</option>
												<option selected="selected" >{{ state }}</option>
											</select>
											
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="issueinput1">School Local Govt Area.</label>
											<select  type="text" v-model="school_lga_id" @change="getSchools()" class="form-control" placeholder="Select Loca Govt Aarea."  data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select Local Govt Area." required>
												<option selected="selected" value="">Select LGA</option>
												<option :value="lga.id" v-for ="(lga ,index) in lgas" :key ="index" >{{ lga.name }}</option>
									
											</select>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="issueinput1">School </label>
											<select  type="text" @change="getClass()" v-model="student.school_id" class="form-control" placeholder="Select School" :class="{'border-danger':validationErrors.school_id}"  data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select School" required>
												<option value="">Select School</option>
												<option :value="school.id" v-for ="school in schools" :key ="school.id" >{{ school.name }}</option>
									
											</select>
											<span  v-if="validationErrors.school_id" :class="['label text-danger']">{{ validationErrors.school_id[0] }}</span>
										</div>
									</div>
								</div>
								<div class="row">
									
									<div class="col-md-4">
										<div class="form-group">
											<label for="projectinput1">Session</label>
											<select v-model="student.session"  @change="validationErrors.session=null" class="form-control" :class="{'border-danger':validationErrors.session}" placeholder="Session"  data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select Session" required>
												<option value="" >Select Session</option>
												<option v-for="year in session()" :key="year" :value="year">{{year}}/{{year+1}}</option>
											</select>
											<span  v-if="validationErrors.session" :class="['label text-danger']">{{ validationErrors.session[0] }}</span>
										</div>
									</div>
									<div class="col-md-4">
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
									<div class="col-md-4">
										<div class="form-group">
											<label for="projectinput1">Class</label>
											<select v-model="student.class_id"  @change="getClassArms()" class="form-control" :class="{'border-danger':validationErrors.class_id}"  data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select Class" required>
												<option value="" >Select Class</option>
												<option :value="clas.id" v-for ="clas in classes" :key ="clas.id" >{{ clas.class_name }}</option>
											</select>
											<span  v-if="validationErrors.class_id" :class="['label text-danger']">{{ validationErrors.class_id[0] }}</span>
										</div>
									</div>
								</div>
								<div class="row">
									
									<div class="col-md-6">
										<div class="form-group">
											<label for="projectinput1">Class Arm</label>
											<select v-model="student.class_arm_id"  @change="validationErrors.class_arm_id=null" class="form-control" :class="{'border-danger':validationErrors.class_arm_id}"  data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select Class Arm" required>
												<option value="" >Select Class Arm</option>
												<option :value="class_arm.id" v-for ="class_arm in class_arms" :key ="class_arm.id" >{{ class_arm.class_arm }}</option>
											</select>
											<span  v-if="validationErrors.class_arm_id" :class="['label text-danger']">{{ validationErrors.class_arm_id[0] }}</span>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="projectinput1">Select  File</label>
											<input type="file" @change="onFileChange"  :class="{'border-danger':validationErrors.batch_file}" class="form-control"  data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select File" required>
											<span  v-if="fileError" :class="['label text-danger']">{{ fileError }}</span>
											<span  v-if="validationErrors.batch_file" :class="['label text-danger']">{{ validationErrors.batch_file[0] }}</span>
										</div>
									</div>
								</div>
								<div class="mb-2" v-if="failures.length > 0">
									<ul>
										<li v-for="(fail, index) in failures" :key="index" class="text-danger">
											<span v-if="fail.row">There was an issue on row: {{ fail.row }}, for {{ fail.attrib }}.</span>  
									
										</li>
									</ul>
								</div>
								<div class="mb-2" v-if="errors.length > 0">
									<ul>
										<li v-for="(error, index) in errors" :key="index" class="text-danger">
											<span class="text-danger">{{ error }}</span>
										</li>
									</ul>
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
				classes:null,
				class_arms:null,
				
				student : {
					school_id :null,
					session:null,
					house_id:null,
					term:null,
					class_id:null,
					class_arm_id:null,
					batch_file :null
				},
				validationErrors: [],
				fileError : '',
				failures : '',
				errors : ''
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
					if(error.response.status === 401){
						let return_url = window.location.pathname;
						this.$router.push({
									name: 'ministry-login',
									params: { return_url: return_url }
									});
					}
	
				})
			},

            createStudentBatch(){
				let data = new FormData;
				const obj = this.student;
				Object.keys(obj).forEach(key=>{
					
					if(obj[key]==null){
						data.append(key, "");
					}
					else{
						data.append(key, obj[key]);
					}
					
				});
	
				this.$loading(true)

                axios.post('/api/ministry/student/create/batch',data)
				.then(response => {
                    if(response) {
						this.$loading(false)
						this.$alert(response.data.data.message,"Imported Successfully",'success');
						this.failures = response.data.data.failures
                    	this.errors = response.data.data.errors
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
					if (error.response.status == 400){
						this.$alert(error.response.data.data.message,"Importing Error",'error');
						this.duplicacy = error.response.data.data.duplicacy;
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
			},

			getClass(){
				if(this.validationErrors && this.validationErrors.school_id!=null) this.validationErrors.school_id=null;
				if(this.student.school_id == null || this.student.school_id=='') return ;
                this.$loading(true);
				axios.get('/api/general/school/getClasses/'+this.student.school_id)
				.then((res) => {
					this.classes = res.data.data.classes,
					this.houses = res.data.data.houses,
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
									name: 'ministry-login',
									params: { return_url: return_url }
									});
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
					if(error.response.status === 401){
						let return_url = window.location.pathname;
						this.$router.push({
									name: 'ministry-login',
									params: { return_url: return_url }
									});
					}
				})
			},
			onFileChange(e) {
				this.fileError = null;
				if(this.validationErrors && this.validationErrors.batch_file != null) this.validationErrors.batch_file = null;
				
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
				
				let filename =files[0].name;
				let ext=/^.+\.([^.]+)$/.exec(filename);
				ext == null ? "" :ext[1];
				let extn=['xls','xlsx','csv'];
				if(extn.includes(ext[1])){
      				let max=5242880;

					if(files[0].size > max) {
						this.fileError = "File size too large, Maximum of 5MB";
						this.$alert(this.fileError,"File Error",'error');
					}
					
					this.student.batch_file = files[0];
    			}
				else{
					this.fileError = "Invalid File, Only Excel file is allowed (csv, xls, xlsx)";
					this.$alert(this.fileError,"File Error",'error');
				}
                
            },

		}
    }
</script>