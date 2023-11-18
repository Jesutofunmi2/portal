<template>
   <div class="row match-height">
		<!-- Striped rows start -->
<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Third Term Result Summary</h4>
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
                                <select v-model="lga_id" @change="getSchools" type="text" required class="form-control form-control-lg input-lg border-grey border-lighten-1 " aria-describedby="button-addon2">
                                    <option selected :value=null>Select LGA</option>
                                    <option  v-for="lga in lgas" :key="lga.id" :value="lga.id"> {{ lga.name }}</option>
                                </select>
                            </div>
                        </fieldset> 
                   </div>
                   <div class="col-md-3">
                        <fieldset style="width:100%;" class="row py-2">
                            <div class="input-group col-xs-12">
                                <select  type="text" @change="getClass()" v-model="school_id" class="form-control form-control-lg input-lg border-grey border-lighten-1" placeholder="Select School" :class="{'border-danger':validationErrors.school_id}"  data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select School" required>
                                    <option :value=null>Select School</option>
                                    <option :value="school.id" v-for ="school in schools" :key ="school.id" >{{ school.name }}</option>
                        
                                </select>
                                <span  v-if="validationErrors.school_id" :class="['label text-danger']">{{ validationErrors.school_id[0] }}</span>
                            </div>
                        </fieldset> 
                   </div>
                    <div class="col-md-3">
                        <fieldset style="width:100%;" class="row py-2">
                            <div class="input-group col-xs-12">
                                <select v-model="class_id"  @change="getClassArms()" class="form-control form-control-lg input-lg border-grey border-lighten-1" :class="{'border-danger':validationErrors.class_id}"  data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select Class" required>
                                    <option :value=null >Select Class</option>
                                    <option :value="clas.id" v-for ="clas in classes" :key ="clas.id" >{{ clas.class_name }}</option>
                                </select>
                                <span  v-if="validationErrors.class_id" :class="['label text-danger']">{{ validationErrors.class_id[0] }}</span>
                            </div>
                        </fieldset> 
                   </div>
                    <div class="col-md-3">
                        <fieldset style="width:100%;" class="row py-2">
                            <div class="input-group col-xs-12">
                                <select v-model="class_arm_id" class="form-control form-control-lg input-lg border-grey border-lighten-1" @change="validationErrors.class_arm_id = null" :class="{'border-danger':validationErrors.class_arm_id}"  data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select Class Arm" required>
                                    <option :value=null >Select Class Arm</option>
                                    <option :value="class_arm.id" v-for ="class_arm in class_arms" :key ="class_arm.id" >{{ class_arm.class_arm }}</option>
                                </select>
                                <span  v-if="validationErrors.class_arm_id" :class="['label text-danger']">{{ validationErrors.class_arm_id[0] }}</span>
                            </div>
                        </fieldset> 
                   </div>
                   <div class="col-md-3">
                        <fieldset style="width:100%;" class="row py-2">
                            <div class="input-group col-xs-12">
                                <select v-model="s_session"  @change="validationErrors.session=null" class="form-control form-control-lg input-lg border-grey border-lighten-1" :class="{'border-danger':validationErrors.session}" placeholder="Session"  data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select Session" required>
                                    <option :value=null >Select Session</option>
                                    <option v-for="year in session()" :key="year" :value="year">{{year}}/{{year+1}}</option>
                                </select>
                                <span  v-if="validationErrors.session" :class="['label text-danger']">{{ validationErrors.session[0] }}</span>
                            </div>
                        </fieldset> 
                   </div>
                   <div class="col-md-3">
                        <fieldset style="width:100%;" class="row py-2">
                            <div class="input-group col-xs-12">
                                <select v-model="status"  class="form-control form-control-lg input-lg border-grey border-lighten-1" :class="{'border-danger':validationErrors.status}"  data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select Status" required>
                                    <option :value=null>Select Status</option>
                                    <option value="2">Promoted</option>
                                    <option value="5">Promoted on trial</option>
                                    <option value="3">To Repeat</option>
                                    <option value="4">Withdraw</option>
                                </select>
                                <span  v-if="validationErrors.status" :class="['label text-danger']">{{ validationErrors.status[0] }}</span>
                            </div>
                        </fieldset> 
                   </div>
                   <div class="col-md-3">
                        <fieldset style="width:100%;" class="row py-2">
                            <div class="input-group col-xs-12">
                                <button style="width:100%; background:#FF8C00; color:#fff;" class="btn btn-lg" @click="getStudentResults()">Download Result Summary</button>
                            </div>
                        </fieldset> 
                   </div>
                </div>
               
                <div class="table-responsive">
                   
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
                school_id : null,
                lga_id : null,
				schools : [],
                classes :[],
                class_id : null,
                class_arms: [],
                class_arm_id: null,
                s_session: null,
				lgas : [],
                meta : null,
                status : null,
                validationErrors: []
			}
		},
        mounted() {
            this.getState();
        },

		methods : {
			
            getSchools() {
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
						this.$alert("You do not have internet access or Unknown Error","Network Error","error");this.$router.go(-1) ;
						return ;
					}
					if(error.response.status === 401){
						let return_url = window.location.pathname;
						this.$router.push({
									name: 'cas-login',
									params: { return_url: return_url }
									});
					}
				})
            },

            getState(){
				this.$loading(true)
				axios.get('/api/general/get_state')
				.then((res) => {
					this.lgas = res.data.data
					this.$loading(false)
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
                            name: 'cas-login',
                            params: { return_url: return_url }
                            });
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

            getClass(){
				if(this.validationErrors && this.validationErrors.school_id!=null) this.validationErrors.school_id=null;
				if(this.school_id == null || this.school_id=='') return ;
                this.$loading(true);
				axios.get('/api/general/school/getClasses/'+this.school_id)
				.then((res) => {
					this.classes = res.data.data.classes,
					this.$loading(false)
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
									name: 'cas-login',
									params: { return_url: return_url }
									});
					}
				})
			},
			getClassArms(){
				if(this.validationErrors && this.validationErrors.class_id!=null) this.validationErrors.class_id=null;
				if(this.class_id == null || this.class_id=='') return ;
                this.$loading(true);
				axios.get('/api/general/school/getClassArms/'+this.class_id)
				.then((res) => {
					this.class_arms = res.data.data.class_arms,
					this.$loading(false)
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
									name: 'cas-login',
									params: { return_url: return_url }
									});
					}
				})
			},

            getStudentResults() {
                const $url = '/api/ministry/result/summary';
                if (!this.s_session || !this.class_id || !this.class_arm_id || !this.status || !this.school_id) {
                    this.flashMessage.error({title: 'Incomplete Data Supplied', 
                            message: 'Please select a School, a Class, a Class Arm, a Session, and a Status',
                            time: 15000, });
                } else {
                    const params = new URLSearchParams();
                    params.append('class_id', this.class_id);
                    params.append('classarm_id', this.class_arm_id);
                    params.append('session', this.s_session);
                    params.append('status', this.status);
                    params.append('school_id', this.school_id);

                    this.$loading(true);

                    axios({
                        url: $url,
                        method: 'GET',
                        params: params
                    }).then((response) => {

                        this.$loading(false)

                        if(response.data.url) {
                            window.open(response.data.url);
                        }
                    })
                    .catch((error) => {
                        this.$loading(false);
                        if (!error.response) {
                            this.$alert("You do not have internet access","Network Error","error");
                            return ;
                        }

                        if (error.response.status == 422) {
                            this.validationErrors = error.response.data.errors;
                            this.flashMessage.error({title: 'Validation Error', 
                                                message: 'There is an Error with the Data you supplied',
                                                time: 15000, });
                        }
                        
                        if(error.response.status === 401){
                            let return_url = window.location.pathname;
                            this.$router.push({
                                        name: 'cas-login',
                                        params: { return_url: return_url }
                                        });
                        }

                        if(error.response.status === 400){
						    this.$alert(error.response.data.message, "Request Error","error");
					    }

                        if(error.response.status === 403){
                            this.$alert("Sorry, you do not have the permission to perfrom this action","No Permission","error");
                        }
                    })
                }
            },
		}
    }
</script>
