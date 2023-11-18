<template>
    <div class="row match-height">
		<!-- Striped rows start -->
        <div class="row">
            <div class="col-xs-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"> <button class="btn btn-primary" @click="back()"> &lt;&lt; Back</button> <span v-if="class_name">{{ class_name }}</span> Class Transaction Logs</h4>
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

                        <div class="table-responsive">
                            <div v-if="pagination">
                                <button @click="getTransactions(pagination.prev)" :class="pagination.prev ? '' : 'disabled'" class="btn btn-success"> &lt;&lt;  Prev </button> {{ meta.current_page }} of {{ meta.last_page }} <button @click="getTransactions(pagination.next)" :class="pagination.next ? '' : 'disabled'" class="btn btn-success"> Next &gt;&gt;  </button>
                            </div>
                            <table class="table table-striped mb-0">
                                <thead>
                                   
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(trans , index) in transactions" :key="index">
                                        <th scope="row">{{ index+1 }}</th>
                                        <td>{{ trans.title }}</td>
                                        <td>{{ trans.message }}</td>
                                        <td>
                                            &#8358;{{ new Intl.NumberFormat('en-US').format(trans.amount) }}
                                        </td>
                                        <td>{{ trans.created_at }}</td>
                                    </tr>
                                
                                </tbody>
                            </table>
                            <div v-if="pagination">
                                <button @click="getTransactions(pagination.prev)" :class="pagination.prev ? '' : 'disabled'" class="btn btn-success"> &lt;&lt;  Prev </button> {{ meta.current_page }} of {{ meta.last_page }} <button @click="getTransactions(pagination.next)" :class="pagination.next ? '' : 'disabled'" class="btn btn-success"> Next &gt;&gt;  </button>
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

		data() {
			return {
                wallet_id : this.$route.params.walletId,
                class_name : null,
                transactions : '',
                pagination : '',
                meta : '',
			}
        },
        
        mounted() {
            this.getTransactions()
        },

		methods : {
			getTransactions(url = '/api/school/class-wallet/transactions?wallet_id='+this.wallet_id) {

                if(url == null) return;
               
				this.$loading(true);
				axios.get(url)
				.then((res) => {
					this.transactions = res.data.data,
                    this.class_name = res.data.class_name,
                    this.pagination = res.data.links,
                    this.meta = res.data.meta,
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

            back() {
                this.$router.back();
            }
		}
    }
</script>