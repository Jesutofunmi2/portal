<template>
   <div class="row match-height">
		<!-- Striped rows start -->
<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">School Survey List</h4>
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
                   <div class="form-group col-md-9">
						<select type="text" id="issueinput3" v-model="s_session" @change="validationErrors.session=null" :class="{'border-danger':validationErrors.session}" class="form-control" name="session" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Session" required>
							<option :value="null">Select Session</option>
							<option :value="session" v-for ="(session, index) in sessions()" :key ="index">{{ session }}/{{ session+1 }}</option>
						</select>
						<span  v-if="validationErrors.session" :class="['label text-danger']">{{ validationErrors.session[0] }}</span>
					</div>
					<div class="col-md-3">
						<button type="submit" class="btn btn-success" @click="startSurvey()">
							<i class="icon-edit"></i> Start Session Survey
						</button>
					</div>
                </div>
                <div class="table-responsive">
                      <div v-if="pagination">
                          <button @click="getSurveys(pagination.prev)" :class="pagination.prev ? '' : 'disabled'" class="btn btn-success"> &lt;&lt;  Prev </button> {{ meta.current_page }} of {{ meta.last_page }} <button @click="getSurveys(pagination.next)" :class="pagination.next ? '' : 'disabled'" class="btn btn-success"> Next &gt;&gt;  </button>
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
                                   <button v-if="survey.submit_status == 0" @click="continueSurvey(survey.id)"  class="btn btn-primary"><i class="icon-check"></i> Continue Survey</button>
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
                          <button @click="getSurveys(pagination.prev)" :class="pagination.prev ? '' : 'disabled'" class="btn btn-success"> &lt;&lt;  Prev </button> {{ meta.current_page }} of {{ meta.last_page }} <button @click="getSurveys(pagination.next)" :class="pagination.next ? '' : 'disabled'" class="btn btn-success"> Next &gt;&gt;  </button>
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
                surveys : [],
               	pagination : '',
                meta : '',
                validationErrors: [],
				s_session: null
			}
		},
        mounted() {
            this.getSurveys();
        },

		methods : {
            getSurveys(page = 1)
			{
				this.$loading(true);
				axios.get(`/api/school/surveys?page=${page}`)
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
							name: 'school-login',
							params: { return_url: return_url }
						});
					}
				})
			},

			startSurvey() {
				 if (! this.s_session || this.s_session == '') {
                    	this.flashMessage.error({title: 'Incomplete Data Supplied', 
                            message: 'Please select a session',
                            time: 15000
						});
					return;
				 }

				this.$loading(true);

				axios.post(`/api/school/surveys/create`, {'session': this.s_session})
				.then((res) => {
					this.$loading(false);
					this.getSurveys();
				})
				.catch((error) => {
                    this.$loading(false);
					if (!error.response) {
						this.$alert("You do not have internet access","Network Error","error");
						return ;
					}

					if (error.response.status == 422){
						this.validationErrors = error.response.data.errors;
						this.flashMessage.error({
							title: 'Validation Error', 
							message: 'There is an Error with the Data you supplied',
							time: 15000
						});
					}

                    if(error.response.status === 403){
						this.$alert("Sorry, you do not have the permission to perfrom this action","No Permission","error");
					}

					if(error.response.status === 400){
						this.$alert(error.response.data.message, "Request Error","error");
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

			continueSurvey(survey_id) 
			{
				this.$confirm("Are you sure you want to continue this survey?","Edit Survey",'question').then(() => {
                this.$router.push({
                        name: 'identities-school-survey',
                        params: { surveyId: survey_id }
                        });
                });
			},

			sessions() {
				const d = new Date();
				const n = d.getFullYear();
				const year = [];
				for (let index = 2010; index <= n; index++) {
					year.push(index);
				}
				return year;
			},

			surveySession(session){
				return parseInt(session) + 1;
			}
		}
    }
</script>
