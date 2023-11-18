<template>
   <div class="row match-height">
		<!-- Striped rows start -->
<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">L.G.A. Subject Teachers Statistics</h4>
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
							
							<div class="col-md-4">
									<fieldset style="width:100%;" class="row py-2">
										<div class="input-group col-xs-12">
											<span>L.G.A</span>
											<select v-model="lga_id" @change="validationErrors.lga_id=null" type="text" required class="form-control form-control-lg input-lg border-grey border-lighten-1 " aria-describedby="button-addon2">
												<option selected value="all">All</option>
												<option  v-for="lga in lgas" :key="lga.id" :value="lga.id"> {{ lga.name }}</option>
											</select>
											<span  v-if="validationErrors.lga_id" :class="['label text-danger']">{{ validationErrors.lga_id[0] }}</span>
										</div>
									</fieldset> 
							</div>
							<div class="col-md-4">
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
							<div style="padding-top:40px;" class="col-md-4">	
								<button @click="getData()" class="btn btn-success btn-lg">Generate Statistics Table</button>
							</div>
						</div>
						<div class="col-md-12" v-if="url">
							<h4> <a :href="url" download>Click here to download Excel format of these result</a> </h4>
						</div>
						<div class="col-md-12" v-if="subject_data">
							<div class="col-md-12">
								<div class="">
									<h4><strong> Subject Teachers Statistic for {{lga_name}}'s LGA </strong></h4>
								</div>
							</div>
							
							<div class="table-responsive">
								
								
								<table class="table table-striped mb-0">
									<thead>
										<tr>
											<th>#</th>
											<th>School Name </th>
											<th>Subject Teachers Statistics</th>
										</tr>
									</thead>
									<tbody>
										<tr v-for="(school , index) in subject_data" :key="index">
											<th scope="row">{{ index+1 }}</th>
											<td>{{ school.name }}</td>
											<td>
												<div style="width:100%; overflow-x:scroll; max-height:250px;" v-if="school.categories">
													<div v-for="category, index in school.categories" :key="index"  style="border:1px solid #ccc;">
														<h4><strong>{{category.name}}</strong></h4>
														<hr>
														<div v-for="subject_data, index in category.subject_data" :key="index">
															<h5>{{subject_data.subject}}</h5>
															<strong> {{subject_data.teacher_count}}</strong>
														</div>
														
													</div>
												</div>
											</td>
										</tr>
									
										</tbody>
									</table>
									
								</div>
						</div>
						<!--///////////////////////////////////////////-->
						<div class="col-md-12" v-if="subject_data_all">
							
							<div class="table-responsive">
								
								<table class="table table-striped mb-0">
									<thead>
										<tr>
											<th>#</th>
											<th>Lga Name</th>
											<th>Class</th>
										</tr>
									</thead>
									<tbody>
										<tr v-for="(school , index) in subject_data_all" :key="index">
											<th scope="row">{{ index+1 }}</th>
											<td>{{ school.lga_name }}</td>
											<td>
												<div style="width:100%; overflow-x:scroll; max-height:250px;" v-if="school.categories">
													<div v-for="category, index in school.categories" :key="index"  style="border:1px solid #ccc;">
														<h4><strong>{{category.name}}</strong></h4>
														<hr>
														<div v-for="subject_data, index in category.subject_data" :key="index">
															<h5>{{subject_data.subject}}</h5>
															<strong> {{subject_data.teacher_count}}</strong>
														</div>
														
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
				validationErrors : [],
				subject_data : null,
				subject_data_all : null,
				url : null,
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
									name: 'cas-login',
									params: { return_url: return_url }
									});
					}

                    if(error.response.status === 403){
						this.$alert("Sorry, you do not have the permission to perfrom this action","No Permission","error");
					}
				})
			},

			getSubjectData(){
				
				this.$loading(true);
				this.subject_data_all = null;
		
				axios.get('/api/ministry/lga/subject-teachers-statistics?session='+this.s_session+'&lga_id='+this.lga_id)
				.then((res) => {
					this.subject_data = res.data.data,
					this.url = res.data.url;
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
									name: 'cas-login',
									params: { return_url: return_url }
									});
					}
				})
			},

			getSubjectDataAll(){
				
				this.$loading(true);
				this.subject_data = null;
		
				axios.get('/api/ministry/lga/subject-teachers-statistics/all?session='+this.s_session)
				.then((res) => {
					this.subject_data_all = res.data.data,
					this.url = res.data.url;
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
									name: 'cas-login',
									params: { return_url: return_url }
									});
					}
				})
			},
			
			getData () {
				if ((this.lga_id == null) || (this.lga_id == "")) return;
				if ((this.s_session == null) || (this.s_session == "")) return;

				this.lgas.forEach(lga => {
					if (lga.id == this.lga_id) this.lga_name = lga.name;
				});

				if (this.lga_id == 'all') {
					this.getSubjectDataAll();
				}
				else {
					this.getSubjectData();
				}
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

