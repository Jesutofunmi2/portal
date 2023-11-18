<template>
   <div class="row match-height">
		<!-- Striped rows start -->
<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">L.G.A. Broad Subject Statistics</h4>
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
							
							<div class="col-md-8">
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
							<div style="padding-top:40px;" class="col-md-4">
									
									<button @click="getData()" class="btn btn-success btn-lg">Generate Statistics Table</button>
							</div>
						</div>
						<div class="col-md-12" v-if="lga_data">
							<div class="col-md-12">
								<div class="">
									<h4 style="text-transform : capitalize;"> <strong> Subject Statistics for {{ lga_name }}'s LGA </strong></h4>
									
								</div>
							</div>
							
							<div class="table-responsive">
								
								
								<table class="table table-striped mb-0">
									<thead>
										<tr>
											<th>#</th>
											<th>School Name </th>
											<th> Subject Statistics</th>
										</tr>
									</thead>
									<tbody>
										<tr v-for="(school , index) in lga_data" :key="index">
											<th scope="row">{{ index+1 }}</th>
											<td>{{ school.name }}</td>
											<td >
												<div style="max-height:350px; overflow: scroll; ">
													<table>
													<tr v-for="subject, index in school.subjects" :key="index">
														<td>{{subject.class}}</td>
														<td>{{subject.class_arm}}</td>
														<td>{{subject.subject_name}}</td>
														<td>{{subject.teacher_name}}</td>
													</tr>
												</table>
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
				validationErrors : [],
				lga_data : null,
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
									name: 'ministry-login',
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

				this.lgas.forEach(lga => {
					if (lga.id == this.lga_id) this.lga_name = lga.name;
				});
				
				this.$loading(true);
				this.lga_data = null;
		
				axios.get('/api/ministry/lga/broad-subject-statistics?lga_id='+this.lga_id)
				.then((res) => {
					this.lga_data = res.data.data,
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
									name: 'ministry-login',
									params: { return_url: return_url }
									});
					}
				})
			},

		}
    }
</script>

