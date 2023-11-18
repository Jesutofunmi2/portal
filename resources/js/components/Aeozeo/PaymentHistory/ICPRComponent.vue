<template>
   <div class="row match-height">
		<!-- Striped rows start -->
<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">ID Card Payment Report</h4>
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
                       <h6><span class="text-warning font-weight-bold">
                           <i class="icon-warning"></i> Note: Definition of the used acronyms
                       </span></h6>
                       <h6><span class="text-warning font-weight-bold">TNOICR: TOTAL NUMBER OF ID CARDS REQUESTED</span></h6>
                       <h6><span class="text-warning font-weight-bold">TNOPIC: TOTAL NUMBER OF PENDING ID CARDS</span></h6>
                       <h6><span class="text-warning font-weight-bold">TNOAIC: TOTAL NUMBER OF APPROVED ID CARDS</span></h6>
                       <h6><span class="text-warning font-weight-bold">TNOICD: TOTAL NUMBER OF ID CARDS DISTRIBUTED</span></h6>
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
                <div class="table-responsive">
                      <div v-if="pagination">
                          <button @click="getReports(meta.current_page-1)" :class="pagination.prev ? '' : 'disabled'" class="btn btn-success"> &lt;&lt;  Prev </button> {{ meta.current_page }} of {{ meta.last_page }} <button @click="getReports(meta.current_page+1)" :class="pagination.next ? '' : 'disabled'" class="btn btn-success"> Next &gt;&gt;  </button>
                      </div>
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>School Name</th>
                                <th>TNOICR</th>
                                <th>TNOPIC</th>
                                <th>TNOAIC</th>
                                <th>TNOICD</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(report , index) in reports" :key="index">
                                <th scope="row">{{ index+1 }}</th>
                                <td>{{ report.name }}</td>
                                <td>{{ report.total }}</td>
                                <td>{{ report.pending }}</td>
                                <td>{{ report.approved }}</td>
                                <td>{{ report.downloaded }}</td>
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
				reports : '',
                lgas : [],
                lga_id : null,
                query : null,
                pagination : '',
                meta : '',
                s_session : null,
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

                let url = '/api/ministry/payment-history/report/icpr?page='+page;
                
                if(this.lga_id != null) {
                    url += '&lga_id='+this.lga_id;
                }

                if(this.s_session != null) {
                    url += '&session='+this.s_session;
                }

                if(url == null) return ;

				this.$loading(true);
				axios.get(url)
				.then((res) => {
					this.reports = res.data.data,
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
