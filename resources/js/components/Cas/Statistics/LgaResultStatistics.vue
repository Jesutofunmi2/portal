<template>
   <div class="row match-height">
		<!-- Striped rows start -->
<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">L.G.A. School Result Statistics</h4>
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
											<span>Term</span>
											<select v-model="term"  @change="validationErrors.term=null" class="form-control form-control-lg input-lg border-grey border-lighten-1" :class="{'border-danger':validationErrors.term}"  data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select Term" required>
												<option value="" >Select Term</option>
												<option value="First" >First Term</option>
												<option value="Second" >Second Term</option>
												<option value="Third" >Third Term</option>
											</select>
											<span  v-if="validationErrors.term" :class="['label text-danger']">{{ validationErrors.term[0] }}</span>
										</div>
									</fieldset> 
							</div>
							<div style="padding-top:40px;" class="col-md-3">
									
									<button @click="getData()" class="btn btn-success btn-lg">Generate Statistics Table</button>
							</div>
						</div>
						<div class="col-md-12" v-if="schools_data">
							<div class="col-md-12">
								<div class="">
									<h4 style="text-transform : uppercase;"> <strong> {{ s_session +'/'+parseFloat(s_session + 1) }} {{ term }} Term Result Statistic for {{lga_name}}'s LGA </strong></h4>
									<h5>NOTE: GREEN indicate Result Available and RED indicate NO Result Available </h5> 
									
								</div>
							</div>
							
							<div class="table-responsive">
								
								
								<table class="table table-striped mb-0">
									<thead>
										<tr>
											<th style="width:5%;">#</th>
											<th style="width:25%;">School Name </th>
											<th style="width:8%;">School Population </th>
											<th style="width:7%;">Total Results (By Student) </th>
											<th style="width:25%;">Total Results (By Calss Arm) </th>
											<th style="width:25%;">Released Results</th>
											<th style="width:5%;">Indicator</th>
										</tr>
									</thead>
									<tbody>
										<tr v-for="(school , index) in schools_data" :key="index">
											<th scope="row">{{ index+1 }}</th>
											<td>{{ school.name }}</td>
											<td>{{ school.total_students }}</td>
											<td>{{ school.total_result_by_student }}</td>
											<td>
												<div v-for="classs, index in school.total_result_by_arm" :key="index">
													<strong> {{ classs }} </strong><br>
												</div>
											</td>
											<td>
												<div v-for="classs, index in school.release_result" :key="index">
													<strong> {{ classs }} </strong><br>
												</div>
											</td>
											<td>
												<img :src="school.indicator" alt="">
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
			    term : null,
				validationErrors : [],
				schools_data : null,
			
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

			getData(){
				if ((this.lga_id == null) || (this.lga_id == "")) return;
				if ((this.s_session == null) || (this.s_session == "")) return;
				if ((this.term == null) || (this.term == "")) return;

				this.lgas.forEach(lga => {
					if (lga.id == this.lga_id) this.lga_name = lga.name;
				});
				
				this.$loading(true);
				this.schools_data = null;
		
				axios.get('/api/ministry/lga/result-statistics?session='+this.s_session+'&lga_id='+this.lga_id+'&term='+this.term)
				.then((res) => {
					this.schools_data = res.data.data,
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

