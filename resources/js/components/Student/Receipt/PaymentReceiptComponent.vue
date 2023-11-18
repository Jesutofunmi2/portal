<template>
   <div class="row match-height">
		<!-- Striped rows start -->
<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Student Receipt</h4>
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
                  
                   <div class="col-md-9">
                        <fieldset style="width:100%;" class="row py-2">
                            <div class="input-group col-xs-12">
                                <select v-model="s_session"  @change="validationErrors.session=null" class="form-control form-control-lg input-lg border-grey border-lighten-1" :class="{'border-danger':validationErrors.session}" placeholder="Session"  data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select Session" required>
                                    <option value="" >Select Session</option>
                                    <option v-for="year in session()" :key="year" :value="year">{{year}}/{{year+1}}</option>
                                </select>
                                <span  v-if="validationErrors.session" :class="['label text-danger']">{{ validationErrors.session[0] }}</span>
                            </div>
                        </fieldset> 
                   </div>
                   
                    
                   <div class="col-md-3" style="padding:0px; margin:0px;">
                        <fieldset style="width:100%;" class="row py-2">
                            <div class="input-group col-xs-12">
                                <button style="background:#FF8C00; color:#fff;" class="btn btn-lg" @click="printReceipt()">Print Receipt</button>
                            </div>
                        </fieldset> 
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
                s_session:'',
                validationErrors: [],
			}
		},
        mounted() {
            
        },

		methods : {
			
            session(){
				const d = new Date();
				const n = d.getFullYear();
				const year = [];
				for (let index = 2010; index <= n; index++) {
					year.push(index);
				}
				return year;
			},
            
            printReceipt() {
                if(this.s_session == '' || this.s_session == null) {
                    alert('Please select session');
                    return;
                }

                this.$loading(true);
				axios.get('/api/student/payment-receipt?session='+this.s_session)
				.then((res) => {
                   if(res.data.data.status == true) {
                       //this.$alert(res.data.data.message, "Success","success");
                       window.open('/student/payment-receipt?student_id='+res.data.data.id+'&session='+this.s_session+'&type='+1, 
                       '_blank');
                   }
                   else {
                    this.$alert(res.data.data.message, "Error","error");
                   }
					this.$loading(false);
				})
				.catch((error) => {
                    this.$loading(false)
                    if (!error.response) {
						this.$alert("You do not have internet access or Unknown Error","Network Error","error");
						return ;
					}
					if(error.response.status === 401){
						let return_url = window.location.pathname;
						this.$router.push({
									name: 'student-login',
									params: { return_url: return_url }
									});
					}

                    if(error.response.status === 400){
						this.$alert(error.response.data.message, "Request Error","error");
					}
				})
            },

		}
    }
</script>
