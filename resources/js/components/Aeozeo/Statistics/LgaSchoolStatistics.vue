<template>
   <div class="row match-height">
		<!-- Striped rows start -->
<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">L.G.A. School Statistics</h4>
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
					<div class="row">
						<div class="col-md-12">
							
							<div class="col-md-3">
									<fieldset style="width:100%;" class="row py-2">
										<div class="input-group col-xs-12">
											<span>L.G.A</span>
											<select v-model="lga_id" @change="validationErrors.lga_id=null" type="text" required class="form-control form-control-lg input-lg border-grey border-lighten-1 " aria-describedby="button-addon2">
												<option selected value="">Select LGA</option>
												<option  v-for="lga in lgas" :key="lga.id" :value="lga.id"> {{ lga.name }}</option>
											</select>
											<span  v-if="validationErrors.lga_id" :class="['label text-danger']">{{ validationErrors.lga_id[0] }}</span>
										</div>
									</fieldset> 
							</div>
							<div class="col-md-3">
									<fieldset style="width:100%;" class="row py-2">
										<div class="input-group col-xs-12">
											<span>Session</span>
											<select v-model="s_session"  @change="validationErrors.session=null" class="form-control form-control-lg input-lg border-grey border-lighten-1" :class="{'border-danger':validationErrors.session}" placeholder="Session"  data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select Session" required>
												<option value="" >Select Session</option>
												<option v-for="year in session()" :key="year" :value="year">{{year}}/{{year+1}}</option>
											</select>
											<span  v-if="validationErrors.session" :class="['label text-danger']">{{ validationErrors.session[0] }}</span>
										</div>
									</fieldset> 
							</div>
							<div class="col-md-3">
									<fieldset style="width:100%;" class="row py-2">
										<div class="input-group col-xs-12">
											<span>User Type</span>
											<select v-model="userType"  @change="validationErrors.userType=null" class="form-control form-control-lg input-lg border-grey border-lighten-1" :class="{'border-danger':validationErrors.userType}"  data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select User Type" required>
												<option value="" >Select User Type</option>
												<option value="student" >Student</option>
												<option value="teacher" >Teacher</option>
											</select>
											<span  v-if="validationErrors.userType" :class="['label text-danger']">{{ validationErrors.userType[0] }}</span>
										</div>
									</fieldset> 
							</div>
							<div style="padding-top:40px;" class="col-md-3">
									
									<button @click="getData()" class="btn btn-success btn-lg">Generate Statistics Table</button>
							</div>
						</div>
						<div class="col-md-12" v-if="student_data">
							<div class="col-md-12">
								<div class="">
									<h4><strong> Statistic for {{lga_name}}'s LGA </strong></h4>
									<h5>Total Students: {{student_data.lga_students}} </h5> 
									<h5>Total Male Students: {{student_data.lga_male_students}} </h5> 
									<h5>Total Females Teachers: {{student_data.lga_female_students}} </h5> 
									<h5>Unknown Gender: {{student_data.lga_unknown_gender}} </h5> 
								</div>
							</div>
							
							<div class="table-responsive">
								
								
								<table class="table table-striped mb-0">
									<thead>
										<tr>
											<th>#</th>
											<th>School Name </th>
											<th>Total Students </th>
											<th>Male Students </th>
											<th>Feamale Students </th>
											<th>Unknowm Gender </th>
										</tr>
									</thead>
									<tbody>
										<tr v-for="(school , index) in student_data.schools" :key="index">
											<th scope="row">{{ index+1 }}</th>
											<td>{{ school.name }}</td>
											<td>{{ school.total_students }}</td>
											<td>{{ school.male_students }}</td>
											<td>{{ school.female_students }}</td>
											<td>{{ school.unknown_gender }}</td>
										</tr>
									
										</tbody>
									</table>
									
								</div>
						</div>
						<!--///////////////////////////////////////////-->
						<div class="col-md-12" v-if="teacher_data">
							<div class="col-md-12">
								<div class="">
									<h4><strong>Statistic for {{lga_name}}'s LGA </strong></h4>
									<h5>Total Teachers: {{teacher_data.total_teachers}} </h5> 
									<h5>Total Male Teachers: {{teacher_data.lga_male_teachers}} </h5>
									<h5>Total Females Teachers: {{teacher_data.lga_female_teachers}} </h5> 
									
								</div>
							</div>
							
							<div class="table-responsive">
								
								<table class="table table-striped mb-0">
									<thead>
										<tr>
											<th>#</th>
											<th>Name</th>
											<th>Total Teacher</th>
											<th>Subject Teacher</th>
											<th>Class Teacher</th>
											<th>Male Teacher</th>
											<th>Female Teacher</th>
											<th>Subjects</th>
										</tr>
									</thead>
									<tbody>
										<tr v-for="(school , index) in teacher_data.schools" :key="index">
											<th scope="row">{{ index+1 }}</th>
											<td>{{ school.name }}</td>
											<td>{{ school.total_teachers }}</td>
											<td>{{ school.subject_teachers }}</td>
											<td>{{ school.class_teachers }}</td>
											<td>{{ school.male_teachers }}</td>
											<td>{{ school.female_teachers }}</td>
											<td>
												<div style="max-height:150px; overflow: scroll; ">
													<div style="border: 1px solid #666; border-radius:5px; padding: 2px; margin-bottom:2px" v-for="subject, index in school.subjects" :key="index">
														{{ subject.subject }} <br />
													</div> 

												</div>
												
											</td>
										</tr>
									
										</tbody>
									</table>
									
								</div>
						</div>

					</div>
						
				</div>
            </div>
        </div>
    </div>
</div>
   </div>
</template>

<script>

    export default {

		data(){
			return {
               	lgas : null,
				lga_id : null,
				lga_name : null,
				s_session : null,
			    userType : null,
				validationErrors : [],
				teacher_data : null,
				student_data : null,
			
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
					this.state = res.data.state,
					this.lgas = res.data.data;
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
									name: "aeo_zeo-login",
									params: { return_url: return_url }
									});
					}

                    if(error.response.status === 403){
						this.$alert("Sorry, you do not have the permission to perfrom this action","No Permission","error");
					}
				})
			},

			getStudentData(){
				
				this.$loading(true);
				this.teacher_data = null;
		
				axios.get('/api/ministry/lga/school-statistics/student?session='+this.s_session+'&lga_id='+this.lga_id)
				.then((res) => {
					this.student_data = res.data.data,
					this.$loading(false);
				})
				.catch((error) => {
                    this.$loading(false);
					if (!error.response) {
						this.$alert("You do not have internet access","Network Error","error");
						return ;
					}

                    if(error.response.status === 403){
						this.$alert("Sorry, you do not have the permission to perfrom this action","No Permission","error");
					}
					if(error.response.status === 401){
						let return_url = window.location.pathname;
						this.$router.push({
									name: "aeo_zeo-login",
									params: { return_url: return_url }
									});
					}
				})
			},
			
			getTeacherData(){
				
				this.$loading(true);
				this.student_data = null;
		
				axios.get('/api/ministry/lga/school-statistics/teacher?session='+this.s_session+'&lga_id='+this.lga_id)
				.then((res) => {
					this.teacher_data = res.data.data,
					this.$loading(false);
				})
				.catch((error) => {
                    this.$loading(false);
					if (!error.response) {
						this.$alert("You do not have internet access","Network Error","error");
						return ;
					}

                    if(error.response.status === 403){
						this.$alert("Sorry, you do not have the permission to perfrom this action","No Permission","error");
					}
					if(error.response.status === 401){
						let return_url = window.location.pathname;
						this.$router.push({
									name: "aeo_zeo-login",
									params: { return_url: return_url }
									});
					}
				})
			},

			getData () {
				if ((this.lga_id == null) || (this.lga_id == "")) return;
				if ((this.s_session == null) || (this.s_session == "")) return;
				if ((this.userType == null) || (this.userType == "")) return;

				this.lgas.forEach(lga => {
					if (lga.id == this.lga_id) this.lga_name = lga.name;
				});

				if (this.userType == 'student') this.getStudentData();

				if (this.userType == 'teacher') this.getTeacherData();
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

		}
    }
</script>

