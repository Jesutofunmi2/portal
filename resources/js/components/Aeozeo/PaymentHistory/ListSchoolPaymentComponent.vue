<template>
   <div class="row match-height">
		<!-- Striped rows start -->
<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">School Payment History</h4>
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
                   <div class="col-md-6">
                        <fieldset class="row py-2">
                            <div class="input-group col-xs-12">
                                <input v-model="query" type="text"  required class="form-control form-control-lg input-lg border-grey border-lighten-1 " placeholder="Search Keyword" aria-describedby="button-addon2">
                                <span class="input-group-btn" id="button-addon2">
                                    <button @click="searchByTerm" class="btn btn-lg btn-success border-grey border-lighten-1" type="submit"><i class="icon-ios-search-strong"></i></button>
                                </span>
                            </div>
                        </fieldset>
                   </div>
                   <div class="col-md-6">
                        
                             <fieldset style="width:100%;" class="row py-2">
                                <div class="input-group col-xs-12">
                                    <select v-model="lga_id" type="text" @change="searchByLga" required class="form-control form-control-lg input-lg border-grey border-lighten-1 " aria-describedby="button-addon2">
                                        <option selected value="">Search by L.G.A</option>
                                        <option  v-for="lga in lgas" :key="lga.id" :value="lga.id"> {{ lga.name }}</option>
                                    </select>
                                   
                                </div>
                            </fieldset>
                       
                   </div>
                </div>
                <div class="table-responsive">
                      <div v-if="pagination">
                          <button @click="getSchools(meta.current_page-1)" :class="pagination.prev ? '' : 'disabled'" class="btn btn-success"> &lt;&lt;  Prev </button> {{ meta.current_page }} of {{ meta.last_page }} <button @click="getSchools(meta.current_page+1)" :class="pagination.next ? '' : 'disabled'" class="btn btn-success"> Next &gt;&gt;  </button>
                      </div>
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>School Name</th>
                                <th>Logo</th>
                                <th>L.G.A</th>
                                <th>Address</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(school , index) in schools" :key="index">
                                <th scope="row">{{ index+1 }}</th>
                                <td>{{ school.name }}</td>
                                 <td>
                                     <img :src="baseUrl+school.logo" alt="" height="120px" width="120px">
                                 </td>
                                <td>{{ school.lga }}</td>
                                <td>{{ school.address }}</td>
                                <td>
                                    <button @click="viewHistory(school.id, school.name)"  class="btn btn-primary"><i class="icon-edit"></i> View Payment History </button>
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
<!-- Striped rows end -->
		<FlashMessage></FlashMessage>
        <Modal v-model="showModal" :title="schoolName"  @close="showModal = false" modal-style="max-width: 800px;">
            <div v-if="histories != null">

                <div class="row" style="padding:5px;" v-if="histories.length > 0">
                  <div class="table-responsive">
                        
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                    <th>PaidAt</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(history , index) in histories" :key="index">
                                    <th scope="row">{{ index+1 }}</th>
                                    <td>{{ history.title }}</td>
                                    <td>{{ history.description }}</td>
                                    <td>{{ formatter.format(history.amount )}}</td>
                                    <td>{{ history.paidAt }}</td>
                                </tr>
                            
                            </tbody>
                        </table>
                    </div>
                </div>
                <div v-else>
                    <h3>No transaction history available</h3>
                </div>
            </div>
             <div v-else>
                 <h3>Loading...</h3>
            </div>
        </Modal>

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
                showModal : false,
                histories : null,
                schoolName : null,
                baseUrl:  '/public',
                formatter : new Intl.NumberFormat('en-US', {
                                    style: 'currency',
                                    currency: 'NGN',
                                })
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
                    this.getSchools();
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

            getSchools(page = 1) {
                if(this.meta && (page > this.meta.last_page || page == 0)  ) return ;

                let url = '/api/ministry/payment-history/schools?page='+page;
                
                if(this.is_term === true) {
                    url += '&query='+this.query;
                }
                else if(this.is_lga_id === true) {
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

            searchByTerm(){
                if(this.query == null || this.query=='') return ;
                this.is_term = true;
                this.is_lga_id=false;
                this.getSchools();
            },

            searchByLga(){
                if(this.lga_id == null || this.lga_id=='') return ;
                 this.is_term = false;
                this.is_lga_id=true;
                this.getSchools();
            },

            viewHistory(id, name){
                this.schoolName = name + " payment history.";
                this.histories = null;
                this.showModal = true;
                
                axios.get('/api/ministry/payment-history/transactions?school_id='+id)
				.then((res) => {
					this.histories = res.data.data;
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

		}
    }
</script>
