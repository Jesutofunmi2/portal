<template>
   <div class="row match-height">
		<!-- Striped rows start -->
<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"><span v-if="school_name"> {{school_name}}</span> School Transaction</h4>
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
                <p></p>
                <router-link :to="{ name: 'ministry-schools-wallet' }">&nbsp; <button class="btn btn-primary"> &lt;&lt; Back</button></router-link>
                
                <div class="card-block card-dashboard row"  v-if="wallet_list">
                  <div class="row" v-for="(list, index) in wallet_list" :key="index" style="border:solid 1px #ccc; padding:5px; margin:5px;">
                      <div style="float:left;">
                          <img :src="baseUrl+school_logo" alt="" width="60px" height="60px" style="border-radius:30px">
                      </div>
                      <div style="float:left; margin-left:10px;">
                          <h5>{{list.title}}</h5>
                          <span>{{list.time}}</span> <br>
                          <strong>{{list.description}}</strong>
                      </div>
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
                school_logo : null,
                wallet_list : null,
                baseUrl:  '/public',
			}
		},
        mounted() {
			this.getTransaction();
        },

		methods : {
		
            getTransaction() {
                if(this.school_id == '') return ;

				this.$loading(true);
				axios.get('/api/ministry/wallet/transaction?school_id='+this.school_id)
				.then((res) => {
					this.wallet_list = res.data.data.wallet_list,
                    this.school_logo = res.data.data.school_logo,
                    this.school_name = res.data.data.school_name,
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
		}
    }
</script>
