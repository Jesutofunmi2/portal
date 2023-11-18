<template>
   <div class="row match-height">
		<!-- Striped rows start -->
<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">School Payment Analysis</h4>
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
               
                <div class="card-block card-dashboard row" >
                    <div class="row">
                       <div class="col-md-12">
                            <h4 v-if="school_name"> {{school_name}} 's Digital Fee Analysis for {{s_session}} Academic
                                Session Paid Into Ondo State Public School Project Account
                            </h4>
                       </div>
                        <div class="col-md-3">
                            <fieldset style="width:100%;" class="row py-2">
                                <div class="input-group col-xs-12">
                                    <router-link :to="{ name: 'ministry-schools-wallet' }"><button style="width:100%;" class="btn btn-primary btn-lg"> &lt;&lt; Back To Wallet</button></router-link>
                                </div>
                            </fieldset> 
                        </div>
                        <div class="col-md-6">
                            <fieldset style="width:100%;" class="row py-2">
                                <div class="input-group col-xs-12">
                                    <select v-model="s_session" class="form-control form-control-lg input-lg border-grey border-lighten-1" placeholder="Session"  data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select Session" required>
                                        <option value="All" >All Session</option>
                                        <option v-for="year in session()" :key="year" :value="year">{{year}}/{{year+1}}</option>
                                    </select>
                                </div>
                            </fieldset> 
                        </div>
                        <div class="col-md-3">
                            <fieldset style="width:100%;" class="row py-2">
                                <div class="input-group col-xs-12">
                                    <button style="width:100%; background:#FF8C00; color:#fff;" class="btn btn-lg" @click="getAnalysis()">Fetch</button>
                                </div>
                            </fieldset> 
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th style="width:5%">#</th>
                                    <th style="width:15%">Date</th>
                                    <th style="width:15%">No of Student</th>
                                    <th style="width:10%">Amount</th>
                                    <th style="width:15%">Total Amount Remmitted Up To Date</th>
                                    <th style="width:25%">Remark</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(list , index) in analysis" :key="index">
                                    <th scope="row">{{ index+1 }}</th>
                                    <td>{{ list.created_at }}</td>
                                    <td>{{ getNoOfStudent(list.amount)}}</td>
                                    <td>{{ formatter.format(list.amount ) }}</td>
                                    <td>{{ formatter.format(list.total_amount ) }}</td>
                                    <td>{{ list.description }}</td>
                                </tr>
                            
                            </tbody>
                    </table>
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
				school_id : this.$route.params.schoolId,
                school_name : null,
                analysis : null,
                s_session : this.getYear(),
                total : 0,
                digital_fee : null,
                formatter : new Intl.NumberFormat('en-US', {
                                    style: 'currency',
                                    currency: 'NGN',
                                })
			}
		},
        mounted() {
			this.getAnalysis();
        },

		methods : {
		
            getAnalysis() {
                if(this.school_id == '') return ;
                let url;
                if(this.s_session == "All") {
                    url = '/api/ministry/wallet/analysis?school_id='+this.school_id;
                }
                else {
                    url = '/api/ministry/wallet/analysis?school_id='+this.school_id+'&session='+this.s_session
                }

				this.$loading(true);
				axios.get(url)
				.then((res) => {
					this.analysis = res.data.data.analysis,
                    this.school_name = res.data.data.school_name,
                     this.digital_fee = res.data.data.digital_fee,
                    
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

            getYear(){
				const d = new Date();
				const n = d.getFullYear();
				return n;
			},

            getNoOfStudent(amount) {
                if(amount <= 0) return 0;
				return Math.floor(amount / this.digital_fee);
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
