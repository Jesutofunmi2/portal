<template>
    <div class="row match-height">
		<!-- Striped rows start -->
        <div class="row">
            <div class="col-xs-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            School Wallet <span v-if="s_session">for {{s_session}}/{{s_session + 1}} Session</span>
                        </h4>
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
                            <div class="form-group col-md-4">
								<select v-model="s_session" @change="getWallet()"  class="form-control  border-grey border-lighten-1" placeholder="Session"  data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select Session">
                                        <option :value="null" >Select Session</option>
                                        <option v-for="year in session()" :key="year" :value="year">{{year}}/{{year+1}}</option>
                                </select>
							</div>
                            <div class="col-md-8" v-if="available_balance" >
                                <div class="form-group col-md-9" style="border-left:1px solid">
									<select id="issueinput19" v-model="class_id" class="form-control" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Class" required>
										<option :value="null">Select Class</option>
										<option :value="clas.id" v-for ="(clas, index) in classes" :key ="index" >{{ clas.class_name }}</option>
									</select>
                                </div>
                                <div class="form-group col-md-3">
                                        <button class="btn btn-success" @click="createWallet()"> Create Class Wallet</button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th colspan="3" v-if="available_balance">
                                            <h3>Available Balance: &#8358;{{ available_balance }}</h3> 
                                        </th>
                                        <th colspan="3" v-if="last_payment">
                                           <h3>Last Payment: &#8358;{{ last_payment }}</h3> 
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>#</th>
                                        <th>Class</th>
                                        <th>Available Balance</th>
                                        <th>Last Credit Amount</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(wallet , index) in wallets" :key="index">
                                        <th scope="row">{{ index+1 }}</th>
                                        <td><span v-if="wallet.classes"> {{ wallet.classes.class_name }} </span> <span v-else> No Class Found</span></td>
                                        <td>
                                            &#8358;{{ new Intl.NumberFormat('en-US').format(wallet.available_balance) }}
                                        </td>
                                         <td>
                                              &#8358;{{ new Intl.NumberFormat('en-US').format(wallet.last_amount) }}
                                         </td>
                                         <td>
                                             <input type="text" class="form-control" :id="wallet.id" placeholder="Enter Amount" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Enter Amount">
                                        </td>
                                         <td>
                                              <button @click="addToWallet(wallet.id)"  class="btn btn-success"> Add To Wallet </button>
                                               &nbsp;&nbsp; <a href="javascript:void(0)" class="text-primary" @click="viewTransaction(wallet.id)"> View Trasaction</a> 
                                         </td>
                                    </tr>
                                    <tr v-if="s_session == null && wallets == null">
                                        <td colspan="6"> <h4>Select Session to load wallet</h4> </td>
                                    </tr>
                                </tbody>
                            </table>
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

		data() {
			return {
                classes : null,
                class_id : null,
                wallets : null,
                available_balance : '',
                last_payment : '',
                query : null,
                pagination : '',
                meta : '',
                validationErrors: [],
                s_session: null,
			}
        },
        
        mounted() {
            this.getClasses();
        },

		methods : {
			getClassWallet() {
                if(this.s_session == '' || this.s_session == null ) {
                    alert('Please select a session');
                    return;
                }
                
				this.$loading(true);
				axios.get('/api/school/class-wallet?session='+this.s_session)
				.then((res) => {
					this.wallets = res.data,
                    this.$loading(false);
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
									name: 'school-login',
									params: { return_url: return_url }
									});
					}

                    if(error.response.status === 403){
						this.$alert("Sorry, you do not have the permission to perfrom this action","No Permission","error");
					}
				})
            },

            getWallet() {
                if(this.s_session == '' || this.s_session == null ) {
                    alert('Please select a session');
                    return;
                }

                this.wallets = null;
                this.available_balance = null;
                this.last_payment = null;
                
				this.$loading(true);
				axios.get('/api/school/wallet/view?session='+this.s_session)
				.then((res) => {
                    let wallet = res.data.data
                    this.last_payment = new Intl.NumberFormat('en-US').format(wallet.last_payment);
                    this.available_balance = new Intl.NumberFormat('en-US').format(wallet.available_balance);
                    this.$loading(false);
                    this.getClassWallet();
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
									name: 'school-login',
									params: { return_url: return_url }
									});
					}

                    if(error.response.status === 400){
						this.$alert(error.response.data.message,"Error","error");
					}

                    if(error.response.status === 403){
						this.$alert("Sorry, you do not have the permission to perfrom this action","No Permission","error");
					}
				})
            },

            getClasses() {
                this.$loading(true)
                axios.get('/api/school/class/view/all')
                .then((res) => {
                    this.classes = res.data.data;
                    this.$loading(false);
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
                                    name: 'school-login',
                                    params: { return_url: return_url }
                                    });
                    }

                })
            },

            createWallet() {
                if(this.class_id == null) {
                    this.$alert("Select a class","Error","error");
                    return;
                }
                if(this.s_session == '' || this.s_session == null ) {
                    alert('Please select a session');
                    return;
                }

                this.$loading(true);

				axios.post('/api/school/class-wallet/create', {
                    class_id : this.class_id,
                    session: this.s_session})
				.then((res) => {
                    this.$alert('Wallet Created Successfully', "Successful","success");
                    this.$loading(false);
                    this.getClassWallet();
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
									name: 'school-login',
									params: { return_url: return_url }
									});
					}

                    if(error.response.status === 403){
						this.$alert("Sorry, you do not have the permission to perfrom this action","No Permission","error");
					}

                    if(error.response.status === 400){
						this.$alert(error.response.data.message, "Request Error","error");
					}
				})
            },

            addToWallet(wallet_id) {
                if(this.s_session == '' || this.s_session == null ) {
                    alert('Please select a session');
                    return;
                }

                let amount = document.getElementById(wallet_id).value;

                if(amount == null || amount=='') {
                    this.$alert("Enter Amount","Error","error");
                    return;
                }

                if(amount < 0 ) {
                    this.$alert('Please enter a positive integer');
                    return;
                }

                this.$loading(true);

				axios.post('/api/school/class-wallet/add', {
                    wallet_id : wallet_id,
                    amount : amount,
                    session : this.s_session})
				.then((res) => {
                    this.$loading(false);
                    this.$alert(res.data.message, "Added Successful","success");
                    document.getElementById(wallet_id).value = null;
                    this.getWallet();
                    this.getClassWallet();
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
									name: 'school-login',
									params: { return_url: return_url }
									});
					}

                    if(error.response.status === 403){
						this.$alert("Sorry, you do not have the permission to perfrom this action","No Permission","error");
					}

                    if(error.response.status === 400){
						this.$alert(error.response.data.message, "Request Error","error");
					}
				})
            },

            viewTransaction(wallet_id) {
                this.$router.push({
									name: 'class-wallet-transaction',
									params: { walletId: wallet_id }
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