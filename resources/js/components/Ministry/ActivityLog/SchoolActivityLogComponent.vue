<template>
   <div class="row match-height">
		<!-- Striped rows start -->
<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">School Activities Log</h4>
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
                <div class="card-block card-dashboard row">
                    <div class="col-md-3">
                       <div class="form-body">
                            <div class="form-group">
                                <select v-model="lga_id" type="text" @change="getSchools()" required class="form-control border-grey border-lighten-1 " aria-describedby="button-addon2">
                                    <option selected :value="null">Filter School by L.G.A</option>
                                    <option  v-for="lga in lgas" :key="lga.id" :value="lga.id"> {{ lga.name }}</option>
                                </select>
                            </div>
                        </div>
                   </div>

                   <div class="col-md-3">
                       <div class="form-body">
                            <div class="form-group">
                                <select v-model="school_id" type="text" @change="validationErrors.school_id=null" :class="{'border-danger':validationErrors.school_id}" class="form-control border-grey border-lighten-1 " aria-describedby="button-addon2">
                                    <option selected :value="null">Select School</option>
                                   <option :value="school.id" v-for ="school in schools" :key ="school.id" >{{ school.name }}</option>
                                </select>
                                <span  v-if="validationErrors.school_id" :class="['label text-danger']">{{ validationErrors.school_id[0] }}</span>
                            </div>
                        </div>
                   </div>

                   <div class="col-md-2">
                       <div class="form-body">
                            <div class="form-group">
                                <input type="date" @change="validationErrors.start_date=null" :class="{'border-danger':validationErrors.start_date}" v-model="start_date" class="form-control border-grey border-lighten-1 " data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Start date">
                                <span  v-if="validationErrors.start_date" :class="['label text-danger']">{{ validationErrors.start_date[0] }}</span>
                            </div>
                        </div>
                   </div>
                   <div class="col-md-2">
                         <div class="form-body">
                            <div class="form-group">
                                <input type="date" @change="validationErrors.end_date=null" :class="{'border-danger':validationErrors.end_date}" v-model="end_date" class="form-control border-grey border-lighten-1 " data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="End date">
                                <span  v-if="validationErrors.end_date" :class="['label text-danger']">{{ validationErrors.end_date[0] }}</span>
                            </div>
                        </div>
                   </div>
                   <div class="col-md-2">
                         <div class="form-body">
                            <button class="btn btn-success border-grey border-lighten-1 " @click="getLogs()">Filter</button>
                        </div>
                   </div>
                </div>
                <div class="table-responsive">
                      <div v-if="pagination">
                          <button @click="getLogs(meta.current_page-1)" :class="pagination.prev ? '' : 'disabled'" class="btn btn-success"> &lt;&lt;  Prev </button> {{ meta.current_page }} of {{ meta.last_page }} <button @click="getLogs(meta.current_page+1)" :class="pagination.next ? '' : 'disabled'" class="btn btn-success"> Next &gt;&gt;  </button>
                      </div>
                      <p></p>
                   <div class="" v-if="logs">
                       <div v-for="log, index in logs" :key="index" class="card">
                            <div class="card-body">
                                <div class="media">
                                    <div class="p-2 text-xs-center bg-success media-left media-middle">
                                        <img :src="baseUrl+log.logo" alt="School Logo" width="60px" height="60px" style="border-radius:30px;" >
                                    </div>
                                    <div class="p-2 media-body">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <h5 > <span style="text-transform:capitalize;"><strong class="text-success">{{log.fullname}}</strong> - {{log.message}}</span> {{log.created_at}}</h5>
                                            </div>
                                            <div class="col-md-2">
                                                <a href="javascript:void(0)" @click="viewLogs(log.admin_id)">View Activity Logs</a>
                                            </div>
                                        </div>
                                        
                                        <h6 class="text-bold-400">Visited: {{log.type}} {{log.path}}</h6>
                                        <h6 class="text-bold-400">IP: {{log.ip}} <a target="_blank" :href="'https://whatismyipaddress.com/ip/'+log.ip"><i class="icon-eye"></i></a></h6>
                                        <h6 class="text-bold-400">Device: {{log.device}}</h6>
                                    </div>
                                </div>
                            </div>
                       </div>
                   </div>
                      <div v-if="pagination">
                          <button @click="getLogs(meta.current_page-1)" :class="pagination.prev ? '' : 'disabled'" class="btn btn-success"> &lt;&lt;  Prev </button> {{ meta.current_page }} of {{ meta.last_page }} <button @click="getLogs(meta.current_page+1)" :class="pagination.next ? '' : 'disabled'" class="btn btn-success"> Next &gt;&gt;  </button>
                      </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Striped rows end -->
		<FlashMessage></FlashMessage>

	</div>
	
</template>

<script>

    export default {

		data(){
			return {
				logs : null,
                lgas : null,
                lga_id : null,
                start_date : null,
                end_date : null,
                pagination : '',
                meta : '',
                validationErrors : [],
                schools : null,
                school_id : null,
                baseUrl : '/public',
			}
		},
        mounted() {
            this.getState();
        },

		methods : {
            getLogs(page = 1) {
                if(this.meta && (page > this.meta.last_page || page == 0)  ) return ;

                let url = '/api/ministry/activities-log/school?page='+page;
                
                if(this.start_date != null) {
                    if(this.end_date == null){
                        alert('End date is empty');
                        return;
                    } 
                    url += '&start_date='+this.start_date;
                }
                if(this.end_date != null) {
                    if(this.start_date == null){
                        alert('Start date is empty');
                        return;
                    } 
                    url += '&end_date='+this.end_date;
                }

                if(this.school_id != null) {
                    url += '&school_id='+this.school_id;
                }

                if(url==null) return ;

                this.validationErrors = [];

				this.$loading(true);
				axios.get(url)
				.then((res) => {
					this.logs = res.data.data,
                    this.pagination = res.data.links,
                    this.meta = res.data.meta,
					this.$loading(false)
				})
				.catch((error) => {
                    this.$loading(false);
					if (!error.response) {
						this.$alert("You do not have internet access","Network Error","error");
						return ;
					}

                    if (error.response.status == 422){
					this.validationErrors = error.response.data.errors;
					this.flashMessage.error({title: 'Validation Error', 
											message: 'Their is Error with the Data you supplied',
											time: 15000, });
					}

                    if (error.response.status === 401) {
                        let return_url = window.location.pathname;
                        this.$router.push({
                        name: "ministry-login",
                        params: { return_url: return_url },
                        });
                    }


                    if(error.response.status === 403){
						this.$alert("Sorry, you do not have the permission to perfrom this action","No Permission","error");
					}
				})
			},

            viewLogs(id){
                this.$router.push({
                        name: 'view-school-activities-log',
                        params: { adminId: id }
                        });
            },

            getState() {
				this.$loading(true)
				axios.get('/api/general/get_state')
				.then((res) => {
					this.state = res.data.state,
					this.lgas = res.data.data;
					this.getLogs();
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

            getSchools(){
                if(this.lga_id == null || this.lga_id=='') return ;
                this.$loading(true);
				axios.get('/api/general/school/secondary/view?lga_id='+this.lga_id)
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

		}
    }
</script>
