<template>
   <div class="row match-height">
		<!-- Striped rows start -->
<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Create School Wallet</h4>
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
                        <fieldset style="width:100%;" class="row py-2">
                            <div class="input-group col-xs-12">
                                <select v-model="s_session" @change="getSchools()"  class="form-control form-control-lg input-lg border-grey border-lighten-1" placeholder="Session"  data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select Session">
                                    <option value="" >Select Session</option>
                                    <option v-for="year in session()" :key="year" :value="year">{{year}}/{{year+1}}</option>
                                </select>
                            </div>
                        </fieldset> 
                   </div>
                   <div class="col-md-3">
                        <fieldset class="row py-2">
                            <div class="input-group col-xs-12">
                                <input v-model="query" type="text"  required class="form-control form-control-lg input-lg border-grey border-lighten-1 " placeholder="Enter School Name" aria-describedby="button-addon2">
                                <span class="input-group-btn" id="button-addon2">
                                    <button @click="searchByTerm" class="btn btn-lg btn-success border-grey border-lighten-1" type="submit"><i class="icon-ios-search-strong"></i></button>
                                </span>
                            </div>
                        </fieldset>
                   </div>
                   <div class="col-md-3">
                        <fieldset style="width:100%;" class="row py-2">
                            <div class="input-group col-xs-12">
                                <select v-model="lga_id" type="text" @change="searchByLga" required class="form-control form-control-lg input-lg border-grey border-lighten-1 " aria-describedby="button-addon2">
                                    <option selected value="">Search by L.G.A</option>
                                    <option  v-for="lga in lgas" :key="lga.id" :value="lga.id"> {{ lga.name }}</option>
                                </select>
                            </div>
                        </fieldset>
                   </div>
                   <div class="col-md-3">
                        <fieldset style="width:100%;" class="row py-2">
                            <div class="input-group col-xs-12">
                                <button style="width:100%; background:#FF8C00; color:#fff;" class="btn btn-lg" @click="getSchools()">Fetch</button>
                            </div>
                        </fieldset> 
                   </div>
                </div>
                <div class="table-responsive">
                    <div class="row">
                         <div v-if="pagination" class="col-md-4">
                            <button @click="getSchools(meta.current_page-1)" :class="pagination.prev ? '' : 'disabled'" class="btn btn-success"> &lt;&lt;  Prev </button> {{ meta.current_page }} of {{ meta.last_page }} <button @click="getSchools(meta.current_page+1)" :class="pagination.next ? '' : 'disabled'" class="btn btn-success"> Next &gt;&gt;  </button>
                        </div>
                        <div class="col-md-8" v-if="schools">
                           <button @click="createAll()" style="float:right;" class="btn btn-primary">Create {{s_session}}/{{ s_session + 1 }} Wallet for All Schools </button>
                        </div>
                    </div>
                     
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th style="width:5%">#</th>
                                <th style="width:15%">Name</th>
                                <th style="width:15%">L.G.A</th>
                                <th style="width:15%">Session</th>
                                <th style="width:10%">Balance</th>
                                <th style="width:15%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(school , index) in schools" :key="index">
                                <th scope="row">{{ index+1 }}</th>
                                <td>{{ school.name }}</td>
                                <td>{{ school.lga }}</td>
                                <td>
                                     <span v-if="school.session">{{ school.session }}/{{ school.session + 1 }}</span>
                                    <span v-else>N/A</span>
                                </td>
                                <td>
                                    <span v-if="school.balance">NGN{{ school.balance }}</span>
                                    <span v-else>N/A</span>
                                </td>
                                <td>
                                    <span v-if="school.wallet_id"></span>
                                    <span v-else><button @click="create(school.id)"  class="btn btn-success"> Create Wallet </button></span>
                                </td>
                            </tr>
                          <tr v-if="s_session == null && schools == ''">
                              <td colspan="7"> <h4>Select Session to load wallet</h4> </td>
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
<!-- Striped rows end -->
		<FlashMessage></FlashMessage>

	</div>
	
</template>

<script>

    export default {

		data(){
			return {
				schools : '',
                lgas : [],
                lga_id : null,
                query : null,
                pagination : '',
                meta : '',
                is_term : false,
                is_lga_id : false,
                s_session:'',
			}
		},
        mounted() {
			this.getState();
        },

		methods : {
			getState() {
				this.$loading(true)
				axios.get('/api/general/get_state')
				.then((res) => {
					this.state = res.data.state,
					this.lgas = res.data.data;
                    this.$loading(false);
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

            getSchools(page = 1) {
                if(this.meta && (page > this.meta.last_page || page == 0)  ) return ;
                if(this.s_session == '' || this.s_session == null ) {
                    alert('Please select a session');
                    return;
                }

                let url = '/api/ministry/created/wallet/view?page='+page+'&session='+this.s_session;
                
                if(this.is_term===true){
                    url += '&query='+this.query;
                }
                else if (this.is_lga_id===true) {
                    url += '&lga_id='+this.lga_id;
                }

                if(url==null) return ;

				this.$loading(true);
				axios.get(url)
				.then((res) => {
					this.schools = res.data.data,
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

                    if(error.response.status === 403) {
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

            searchByTerm() {
                if(this.query == null || this.query=='') {
                    alert('Search term is required');
                    return;
                }
                this.is_term = true;
                this.is_lga_id=false;
                this.getSchools();
            },

            searchByLga(){
                if(this.lga_id == null || this.lga_id=='') {
                    alert('Please select valid LGA');
                    return;
                }
                 this.is_term = false;
                this.is_lga_id=true;
                this.getSchools();
            },

            create(school_id) {
                 if(this.s_session == '' || this.s_session == null ) {
                    alert('Please select a session');
                    return;
                }

                this.$confirm("Are you sure you want to create this wallet?","Create Wallet",'question').then(() => {
                    let data = {
                        'school_id' : school_id,
                        'session' : this.s_session,
                    }

                    this.$loading(true);
                    axios.post('/api/ministry/wallet/create', data)
                    .then((res) => {
                        if(res.data.data.status) {
                            this.$alert(res.data.data.message,"Successful","success");
                             this.getSchools();
                        }
                        else {
                            this.$alert(res.data.data.message,"Error","error");
                            this.$loading(false);
                        }
                    })
                    .catch((error) => {
                        this.$loading(false);
                        if (!error.response) {
                            this.$alert("You do not have internet access","Network Error","error");
                            return ;
                        }

                        if(error.response.status === 403) {
                            this.$alert("Sorry, you do not have the permission to perfrom this action","No Permission","error");
                        }
                        if(error.response.status === 422) {
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
                    })
                
                });
            },

            createAll() {
                 if(this.s_session == '' || this.s_session == null ) {
                    alert('Please select a session');
                    return;
                }

                this.$confirm("Are you sure you want to create wallet for all schools ?","Create Wallet",'question').then(() => {
                    let data = {
                        'session' : this.s_session,
                    }

                    this.$loading(true);
                    axios.post('/api/ministry/wallet/create/all', data)
                    .then((res) => {
                        if(res.data.data.status) {
                            this.$alert(res.data.data.message,"Successful","success");
                             this.getSchools();
                        }
                        else {
                            this.$alert(res.data.data.message,"Error","error");
                            this.$loading(false);
                        }
                    })
                    .catch((error) => {
                        this.$loading(false);
                        if (!error.response) {
                            this.$alert("You do not have internet access","Network Error","error");
                            return ;
                        }

                        if(error.response.status === 403) {
                            this.$alert("Sorry, you do not have the permission to perfrom this action","No Permission","error");
                        }
                        if(error.response.status === 422) {
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
                    })
                
                });
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
