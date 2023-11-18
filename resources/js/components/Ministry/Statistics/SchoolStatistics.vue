<template>
   <div class="row match-height">
		<!-- Striped rows start -->
<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">School Statistics</h4>
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
						<div class="col-md-3" style="border:solid 1px #ccc;">
								<fieldset style="width:100%;" class="row py-2">
									<div class="input-group col-xs-12">
										<span>Filter By L.G.A</span>
										<select v-model="lga_id" type="text" @change="getSchools()" required class="form-control form-control-lg input-lg border-grey border-lighten-1 " aria-describedby="button-addon2">
											<option selected value="">Search by L.G.A</option>
											<option  v-for="lga in lgas" :key="lga.id" :value="lga.id"> {{ lga.name }}</option>
										</select>
									
									</div>
                            </fieldset>
							<hr />
							<div v-if="overall" class="">
								<h4>{{ state }} Statistic Overview</h4>
								<span>Total Schools: {{overall.total_schools}} </span> <br />
								<hr>
								<span>Total Teachers: {{overall.total_teachers}} </span> <br />
								<span>Total Male Teachers: {{overall.total_male_teachers}} </span> <br />
								<span>Total Females Teachers: {{overall.total_female_teachers}} </span> <br />
								<hr>
								<span>Total Students: {{overall.total_students}} </span> <br />
								<span>Total Male Students:  {{overall.total_male_students}} </span> <br />
								<span>Total Females Students:  {{overall.total_female_students}} </span> <br />
								<span>Unknown-Gender Students:  {{overall.unknown_gender_students}} </span> <br />
							</div>
						</div>
						<div class="col-md-9">
							<div class="col-md-12">
								<img src="" alt="" style="height:240px; width:100%" :srcset="baseUrl+'/images/ill-stats.png'">
								<hr>
							</div>
							
							<div class="table-responsive">
								<div v-if="pagination">
									<button @click="getSchools(meta.current_page-1)" :class="pagination.prev ? '' : 'disabled'" class="btn btn-success"> &lt;&lt;  Prev </button> {{ meta.current_page }} of {{ meta.last_page }} <button @click="getSchools(meta.current_page+1)" :class="pagination.next ? '' : 'disabled'" class="btn btn-success"> Next &gt;&gt;  </button>
								</div>
								
								<table class="table table-striped mb-0">
									<thead>
										<tr>
											<th>#</th>
											<th>Name</th>
											<th>Logo</th>
											<th>L.G.A</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<tr v-for="(school , index) in schools" :key="index">
											<th scope="row">{{ index+1 }}</th>
											<td>{{ school.name }}</td>
											<td><img alt="" :src="baseUrl+school.logo" :srcset="baseUrl+school.logo" style="max-heigth:100px; max-width:100px;"  /> </td>
											<td>{{ school.lga }}</td>
											<td>
											<button @click="showSchoolStat(school.id)"  class="btn btn-success"><i class="icon-stats-bars"></i> View School Statistics</button>
											</td>
										</tr>
									
										</tbody>
									</table>
									<div v-if="pagination">
										<button @click="getSchools(meta.current_page-1)" :class="pagination.prev ? '' : 'disabled'" class="btn btn-success"> &lt;&lt;  Prev </button> {{ meta.current_page }} of {{ meta.last_page }} <button @click="getSchools(meta.current_page+1)" :class="pagination.next ? '' : 'disabled'" class="btn btn-success"> Next &gt;&gt;  </button>
									</div>
								</div>
						</div>

					</div>
						
				</div>
            </div>
        </div>
    </div>
</div>
<!-- Striped rows end -->
<Modal v-model="showModal" :title="school_stat != null ? school_stat.school.name +'\'s Statistics' : `School Statistics`"  @close="showModal = false">
  	<div v-if="school_stat != null">
		  <div class="width:100%; text-align:center;" >
			   <img alt="" :src="baseUrl+school_stat.school.logo" :srcset="baseUrl+school_stat.school.logo" style="max-heigth:100px; max-width:100px; border-radius:15px;"  />
			   <p></p>
		  </div>
		 
		  <h4><i class="icon-library"></i> {{ school_stat.school.name }}</h4>
		  <h5><i class="icon-ios-location"></i><span> {{school_stat.school.address}} </span></h5>
		  <h5><i class="icon-social-buffer"></i><span> {{school_stat.school.category}} </span></h5>
		  <h5><i class="icon-clock3"></i><span> {{school_stat.school.time}} </span></h5> 
		<hr>
		<h4><i class="icon-user"></i><span> Total Admin: {{school_stat.schoolAdmin}} </span></h4>
		<h4><i class="icon-man-woman"></i><span> Total Teachers: {{school_stat.total_teachers}} </span> </h4>
		<h4><i class="icon-man2"></i> <span>Total Male Teachers: {{school_stat.total_male_teachers}} </span> </h4>
		<h4><i class="icon-woman2"></i> <span>Total Females Teachers: {{school_stat.total_female_teachers}} </span> </h4>
		<hr>
		<h4><i class="icon-ios-people"></i> <span> Total Students: {{school_stat.total_students}} </span> </h4>
		<h4><i class="icon-male"></i> <span> Total Male Students:  {{school_stat.total_male_students}} </span> </h4>
		<h4><i class="icon-female"></i> <span> Total Females Students:  {{school_stat.total_female_students}} </span> </h4>
		<h4><i class="icon-ios-body"></i> <span> Unknown-Gender :  {{school_stat.unknown_gender_students}} </span> </h4>
	</div>
	<div v-else>
		<h3> Loading... </h3>
	</div>
</Modal>

	</div>
	
</template>

<script>

    export default {

		data(){
			return {
				state : null,
               	lgas : null,
				lga_id : null,
				overall : null,
			    schools : null,
				pagination : null,
				meta : null,
				showModal: false,
				school_stat : null,
				baseUrl:  '/public',
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
					this.getSchoolOverall();
				})
				.catch((error) => {
                    this.$loading(false);
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

                    if(error.response.status === 403){
						this.$alert("Sorry, you do not have the permission to perfrom this action","No Permission","error");
					}
				})
			},

			getSchoolOverall(){
				
				this.$loading(true)
				axios.get('/api/ministry/school-statistics/overall')
				.then((res) => {
					this.overall = res.data.data,
					this.getSchools();
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
				})
			},

			getSchools (page = 1) {
				if(this.meta && (page > this.meta.last_page || page == 0)  ) return ;

				this.$loading(true)
				let url = '/api/ministry/school-statistics/schools?page='+page;

				if(this.lga_id != null ) {
					url += '&lga_id='+this.lga_id;
				}
				axios.get(url)
				.then((res) => {
					this.schools = res.data.data,
					this.pagination = res.data.links
					this.meta = res.data.meta
					this.$loading(false)
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

			showSchoolStat(id){
				this.school_stat = null;
				this.showModal = true;

				let url = '/api/ministry/school-statistics/schools/'+id;
	
				axios.get(url)
				.then((res) => {
					this.school_stat = res.data.data;
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
			}
		}
    }
</script>

