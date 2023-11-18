<template>
   <div class="row match-height">
		<!-- Striped rows start -->
<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Schools Remittance Report </h4>
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
                   <div class="col-md-12 border-2 border-warning" style="border-radius:10px; ">
                       <div class="row">
                           <div class="col-md-6">
                               <h6><span class="text-warning font-weight-bold">
                                    <i class="icon-warning"></i> Note: Definition of the used acronyms
                                </span></h6>
                           </div>
                           <div class="col-md-6">
                              
                           </div>
                       </div>
                       <div class="row">
                           <div class="col-md-6">
                                <h6><span class="text-warning font-weight-bold">JSS: JUNIOR SECONDARY SCHOOL</span></h6>
                           </div>
                           <div class="col-md-6">
                               <h6><span class="text-warning font-weight-bold">SS: SENIOR SECONDARY SCHOOL</span></h6>
                           </div>
                       </div>
                       <div class="row">
                           <div class="col-md-6">
                               <h6><span class="text-warning font-weight-bold">STS: STUDENT STATISTICS</span></h6>
                           </div>
                           <div class="col-md-6">
                                <h6><span class="text-warning font-weight-bold">MP: MONEY PAID</span></h6>
                           </div>
                       </div>
                       <div class="row">
                           <div class="col-md-6">
                               <h6><span class="text-warning font-weight-bold">NOS: NAME OF SCHOOLS</span></h6>
                           </div>
                           <div class="col-md-6">
                               <h6><span class="text-warning font-weight-bold">TNOS: TOTAL NUMER OF STUDENT</span></h6>
                           </div>
                       </div>
                       <div class="row">
                           <div class="col-md-6">
                               <h6><span class="text-warning font-weight-bold">TAP: TOTAL AMOUNT PAID</span></h6>
                           </div>
                           <div class="col-md-6">
                              <h6><span class="text-warning font-weight-bold">TOSP: TOTAL OUT STANDING PAYMENT</span></h6>
                           </div>
                       </div>
                       <div class="row">
                           <div class="col-md-12">
                               <h6><span class="text-danger font-weight-bold">
                                    <i class="icon-warning"></i> Note: This page takes longer time to load due to complex computation, Data will be added to the table one at a time, You can go to next page after the table list is up to 10
                                </span></h6>
                           </div>
                
                       </div>
                       
                   </div>
                   <div class="col-md-5">
                             <fieldset style="width:100%;" class="row py-2">
                                <div class="input-group col-xs-12">
                                    <select v-model="lga_id" type="text" required class="form-control form-control-lg input-lg border-grey border-lighten-1 " aria-describedby="button-addon2">
                                        <option selected :value="null">Search by L.G.A</option>
                                        <option  v-for="lga in lgas" :key="lga.id" :value="lga.id"> {{ lga.name }}</option>
                                    </select>
                                </div>
                            </fieldset>
                   </div>
                   <div class="col-md-5">
                        <fieldset class="row py-2">
                            <select v-model="s_session" class="form-control form-control-lg input-lg border-grey border-lighten-1" placeholder="Session"  data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select Session" required>
                                <option :value="null" >All Session</option>
                                <option v-for="year in session()" :key="year" :value="year">{{year}}/{{year+1}}</option>
                            </select>
                        </fieldset>
                   </div>
                   <div class="col-md-2">
                       <p></p>
                       <p></p>
                        <button @click="getReports()" class="btn btn-success btn-lg"> Filter </button>
                   </div>
                </div>
                <div class="table-responsive" style="max-height:500px; overflow:scroll;">
                      <div v-if="pagination">
                          <button @click="getReports(meta.current_page-1)" :class="pagination.prev ? '' : 'disabled'" class="btn btn-success"> &lt;&lt;  Prev </button> {{ meta.current_page }} of {{ meta.last_page }} <button @click="getReports(meta.current_page+1)" :class="pagination.next ? '' : 'disabled'" class="btn btn-success"> Next &gt;&gt;  </button>
                      </div>
                    <table class="table table-striped mb-0" border="1">
                        <thead>
                            <tr>
                                <th rowspan="2"></th>
                                <th rowspan="2">NOS</th>
                                <th colspan="2">JSS1</th>
                                <th colspan="2">JSS2</th>
                                <th colspan="2">JSS3</th>
                                <th colspan="2">SS1</th>
                                <th colspan="2">SS2</th>
                                <th colspan="2">SS3</th>
                                <th rowspan="2">TNOS</th>
                                <th rowspan="2">TAP</th>
                                <th rowspan="2">TOSP</th>
                            </tr>
                            <tr>
                                <th>STS</th>
                                <th>MP</th>
                                <th>STS</th>
                                <th>MP</th>
                                <th>STS</th>
                                <th>MP</th>
                                <th>STS</th>
                                <th>MP</th>
                                <th>STS</th>
                                <th>MP</th>
                                <th>STS</th>
                                <th>MP</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(report , index) in reports" :key="index">
                                <th scope="row">{{ index+1 }}</th>
                                <th>{{ report.name }}</th>
                                <th>{{ report.jss1_sts }}</th>
                                <th>{{ report.jss1_mp }}</th>
                                <th>{{ report.jss2_sts }}</th>
                                <th>{{ report.jss2_mp }}</th>
                                <th>{{ report.jss3_sts }}</th>
                                <th>{{ report.jss3_mp }}</th>
                                <th>{{ report.sss1_sts }}</th>
                                <th>{{ report.sss1_mp }}</th>
                                <th>{{ report.sss2_sts }}</th>
                                <th>{{ report.sss2_mp }}</th>
                                <th>{{ report.sss3_sts }}</th>
                                <th>{{ report.sss3_mp }}</th>
                                <th>{{ report.tnos }}</th>
                                <th>{{ report.tap }}</th>
                                <th>{{ report.tosp }}</th>
                            </tr>
                          
                        </tbody>
                    </table>
                      <div v-if="pagination">
                          <button @click="getReports(meta.current_page-1)" :class="pagination.prev ? '' : 'disabled'" class="btn btn-success"> &lt;&lt;  Prev </button> {{ meta.current_page }} of {{ meta.last_page }} <button @click="getReports(meta.current_page+1)" :class="pagination.next ? '' : 'disabled'" class="btn btn-success"> Next &gt;&gt;  </button>
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
				reports : [],
                lgas : [],
                lga_id : null,
                query : null,
                pagination : '',
                meta : '',
                s_session : null,
                schools : null,
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
					this.lgas = res.data.data,
                    this.getReports();
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
									name: "aeo_zeo-login",
									params: { return_url: return_url }
									});
					}

                    if(error.response.status === 403){
						this.$alert("Sorry, you do not have the permission to perfrom this action","No Permission","error");
					}
				})
			},

            getReports(page = 1) {
                if(this.meta && (page > this.meta.last_page || page == 0)  ) return ;

                let url = '/api/ministry/payment-history/report/srr?page='+page;
                
                if(this.lga_id != null) {
                    url += '&lga_id='+this.lga_id;
                }

                if(this.s_session != null) {
                    url += '&session='+this.s_session;
                }

                if(url == null) return ;

				this.$loading(true);
                this.schools = [];
                this.reports = [];
				axios.get(url)
				.then((res) => {
                    this.schools = res.data.data,
                    this.pagination = res.data.links,
                    this.meta = res.data.meta,
					this.$loading(false);
                    alert("Kindly wait patiently on this page, data is loading in the background and will be one at a time,");
                    this.schoolReport();
				})
				.catch((error) => {
                    this.$loading(false);
					if (!error.response) {
						this.$alert("You do not have internet access","Network Error","error");
						return ;
					}

                    if (error.response.status === 401) {
                        let return_url = window.location.pathname;
                        this.$router.push({
                        name: "aeo_zeo-login",
                        params: { return_url: return_url },
                        });
                    }


                    if(error.response.status === 403){
						this.$alert("Sorry, you do not have the permission to perfrom this action","No Permission","error");
					}
				})
			},

            async schoolReport() {

                for (let index = 0; index < this.schools.length; index++) {

                        const school = this.schools[index];
                        let url = '/api/ministry/payment-history/report/school/srr?school_id='+school.id;
                    
                        if(this.s_session != null) {
                            url += '&session='+this.s_session;
                        }
                        
                        if(url == null) return ;

                        await this.getData(url)
                        .then((res) => {
                            this.reports.push(res.data.data);
                            this.flashMessage.success({
                                title: 'Successful',
                                message: 'New row has been added',
                                time: 5000,
                                flashMessageStyle: {
                                    backgroundColor: 'linear-gradient(#e66465, #9198e5)'
                                }
                            });
                        })
                        .catch((error) => {
                            if (!error.response) {
                                this.$alert("You do not have internet access","Network Error","error");
                                return ;
                            }

                            if (error.response.status === 401) {
                                let return_url = window.location.pathname;
                                this.$router.push({
                                name: "aeo_zeo-login",
                                params: { return_url: return_url },
                                });
                            }


                            if(error.response.status === 403){
                                this.$alert("Sorry, you do not have the permission to perfrom this action","No Permission","error");
                            }
                        });
                        
                }
          
			},

            getData(url) {
                return axios.get(url);
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
