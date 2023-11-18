<template>
   <div class="row match-height">
		<!-- Striped rows start -->
<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Search School Survey</h4>
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
                    <div class="col-md-2"> 
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

                   <div class="col-md-3">
                        <fieldset style="width:100%;" class="row py-2">
                            <div class="input-group col-xs-12">
                                <select v-model="lga_id" @change="getSchools" type="text" required class="form-control form-control-lg input-lg border-grey border-lighten-1 " aria-describedby="button-addon2">
                                    <option selected value="">Select LGA</option>
                                    <option  v-for="lga in lgas" :key="lga.id" :value="lga.id"> {{ lga.name }}</option>
                                </select>
                            </div>
                        </fieldset> 
                   </div>
                    <div class="col-md-3">
                        <fieldset style="width:100%;" class="row py-2">
                            <div class="input-group col-xs-12">
                                <select v-model="school_id" @change="getSurveys()" type="text" required class="form-control form-control-lg input-lg border-grey border-lighten-1 " aria-describedby="button-addon2">
                                    <option selected value="">Select School</option>
                                   <option :value="school.id" v-for ="school in schools" :key ="school.id" >{{ school.name }}</option>
                                </select>
                            </div>
                        </fieldset> 
                   </div>
                   
                   <div class="col-md-2">
                        <fieldset style="width:100%;" class="row py-2">
                            <div class="input-group col-xs-12">
                                <button style="width:100%; background:#FF8C00; color:#fff;" class="btn btn-lg" @click="getSurveys()">Fetch Survey</button>
                            </div>
                        </fieldset> 
                   </div>

                    <div class="col-md-2">
                        <fieldset style="width:100%;" class="row py-2">
                            <div class="input-group col-xs-12">
                                <button style="width:100%; color:#fff;" class="btn btn-lg btn-primary" @click="exportSurveys()">Export All Survey</button>
                            </div>
                        </fieldset> 
                   </div>

                </div>
                <div class="table-responsive">
                      <div v-if="pagination">
                          <button @click="getSurveys(meta.current_page-1)" :class="pagination.prev ? '' : 'disabled'" class="btn btn-success"> &lt;&lt;  Prev </button> {{ meta.current_page }} of {{ meta.last_page }} <button @click="getSurveys(meta.current_page+1)" :class="pagination.next ? '' : 'disabled'" class="btn btn-success"> Next &gt;&gt;  </button>
                      </div>
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Session</th>
                                <th>Survey Status</th>
                                <th>Approve Status</th>
                                <th colspan="2">Action</th>
                            </tr>
                        </thead>
                        <tbody v-if="surveys.length > 0">
                            <tr v-for="(survey , index) in surveys" :key="index">
                                <th scope="row">{{ index+1 }}</th>
                                <td>{{ survey.session }}/{{ surveySession(survey.session) }}</td>
                                <td>{{ survey.submit_status ? 'Submitted' : 'On-Going' }}</td>
                                <td>{{ survey.approve_status ? 'Approved': 'Pending' }}</td>
                                <td>
                                   <button  @click="viewSurvey(survey.id)"  class="btn btn-primary"><i class="icon-check"></i> Preview Survey</button>
                                   <button @click="printSurvey(survey.id)"  v-if="survey.submit_status == true && survey.approve_status == true"  class="btn btn-success"><i class="icon-print"></i> Print Survey</button>
                                </td>
                            </tr>
                        </tbody>
						<tbody v-else>
                            <tr>
								<td colspan="5">
									No Survey Record Available
								</td>
							</tr>
						</tbody>
                    </table>
                   
                     <div v-if="pagination">
                          <button @click="getSurveys(meta.current_page-1)" :class="pagination.prev ? '' : 'disabled'" class="btn btn-success"> &lt;&lt;  Prev </button> {{ meta.current_page }} of {{ meta.last_page }} <button @click="getSurveys(meta.current_page+1)" :class="pagination.next ? '' : 'disabled'" class="btn btn-success"> Next &gt;&gt;  </button>
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
                school_id : null,
                lga_id : '',
				schools : [],
                surveys :[],
                state : '',
				lgas : [],
                s_session: null,
                pagination : '',
                meta : '',
                baseUrl:  '/public',
                validationErrors : []
                
			}
		},
        mounted() {
            this.getState();
        },

		methods : {
			
            getSurveys(page = 1){
                if(this.meta && (page > this.meta.last_page || page == 0)  ) return ;

                let url = '/api/ministry/school/survey/list?&page='+page

                if(this.school_id == null) {
                    this.$alert("Please select school","School is required","error");
                    return;
                }

                if(this.school_id) url += '&school_id='+this.school_id
                if(this.s_session) url += '&session='+this.s_session
                
				this.$loading(true);
				axios.get(url)
				.then((res) => {
					this.surveys = res.data.data,
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

                    if(error.response.status === 403){
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

            getSchools(){
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
						this.$alert("You do not have internet access","Network Error","error");this.$router.go(-1) ;
						return ;
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

            getState() {
				this.$loading(true)
				axios.get('/api/general/get_state')
				.then((res) => {
					this.state = res.data.state,
					this.lgas = res.data.data
					this.$loading(false)
				})
				.catch((error) => {
					this.$loading(false)
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
	
				})
			},

            exportSurveys() {
                if(this.s_session == null) {
                    this.$alert("Please select a session","Session is required","error");
                    return;
                }

                this.$loading(true)

                let data = {'session' : this.s_session}

                axios.post('/api/ministry/school/survey/export', data)
				.then(response => {
                    this.$loading(false)
                    
					if(response.data.url) {
                        window.open(response.data.url);
                    }
                })
				.catch(error => {
					this.$loading(false)
					if (!error.response) {
						this.$alert("You do not have internet access","Network Error","error");
						return ;
					}

                    if(error.response.status === 400){
						this.$alert(error.response.data.message, "Request Error","error");
					}

					if (error.response.status == 422){
					this.validationErrors = error.response.data.errors;
					this.flashMessage.error({title: 'Validation Error', 
											message: 'There is an Error with the Data you supplied',
											time: 15000, });
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
				});
            },

            printSurvey(survey_id) {

                this.$loading(true)

                axios.get(`/api/ministry/school/survey/print?survey=${survey_id}`)
				.then(response => {
                    this.$loading(false)
                    
					if(response.data.url) {
                        window.open(response.data.url);
                    }
                })
				.catch(error => {
					this.$loading(false)
					if (!error.response) {
						this.$alert("You do not have internet access","Network Error","error");
						return ;
					}

                    if(error.response.status === 400){
						this.$alert(error.response.data.message, "Request Error","error");
					}

					if (error.response.status == 422){
					this.validationErrors = error.response.data.errors;
					this.flashMessage.error({title: 'Validation Error', 
											message: 'There is an Error with the Data you supplied',
											time: 15000, });
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
				});
            },

            viewSurvey(survey_id) 
			{
                this.$router.push({
                    name: 'ministry-identities-school-survey',
                    params: { surveyId: survey_id }
                });
			},

            surveySession(session){
				return parseInt(session) + 1;
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
