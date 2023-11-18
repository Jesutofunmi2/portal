<template>
    <div class="row match-height">
		<!-- Striped rows start -->
        <div class="row">
            <div class="col-xs-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Term Broadsheet</h4>
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

                            <form class="form" novalidate @submit.prevent="getStudentResults">
							    
                                <div class="form-body">
                                    <div class="form-group col-md-3">
                                        <label for="issueinput1">Class</label>
                                        <select id="issueinput1" v-model="class_id" @change="changeClass($event)" :class="{'border-danger':validationErrors.class_id}" class="form-control" name="class_id" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Class" required>
                                            <option value="">Select Class</option>
                                            <option :value="clas.id" v-for ="(clas, index) in classes" :key ="index" >{{ clas.class_name }}</option>
                                        </select>
                                        <span  v-if="validationErrors.class_id" :class="['label text-danger']">{{ validationErrors.class_id[0] }}</span>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="issueinput2">Class Arm</label>
                                        <select id="issueinput2" v-model="classarm_id" @change="validationErrors.classarm_id=null" :class="{'border-danger':validationErrors.classarm_id}" class="form-control" name="classarm_id" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Class Arm" required>
                                            <option value="">Select Class Arm</option>
                                            <option :value="clasarm.id" v-for ="(clasarm, index) in classArms" :key ="index" >{{ clasarm.class_arm }}</option>
                                        </select>
                                        <span  v-if="validationErrors.classarm_id" :class="['label text-danger']">{{ validationErrors.classarm_id[0] }}</span>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="issueinput3">Session</label>
                                        <select v-model="s_session" class="form-control border-grey border-lighten-1" placeholder="Session"  data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select Session" required>
                                            <option :value="null" >Select Session</option>
                                            <option v-for="year in session()" :key="year" :value="year">{{year}}/{{year+1}}</option>
                                        </select>
                                        <span  v-if="validationErrors.session" :class="['label text-danger']">{{ validationErrors.session[0] }}</span>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="issueinput4">Term</label>
                                        <select type="text" id="issueinput4" v-model="term" @change="validationErrors.term=null" :class="{'border-danger':validationErrors.term}" class="form-control" name="term" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Term" required>
                                            <option value="">Select Term</option>
                                            <option value="First">First</option>
                                            <option value="Second">Second</option>
                                            <option value="Third">Third</option>
                                        </select>
                                        <span  v-if="validationErrors.term" :class="['label text-danger']">{{ validationErrors.term[0] }}</span>
                                    </div>
                                </div>

                                <div class="form-actions pl-1">
                                    <button type="submit" class="btn btn-success">
                                        <i class="icomoon icon-file-pdf"></i> Download Broadsheet
                                    </button>
                                </div>

                            </form>

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
                s_session: null,
                term : null,
                class_id : null,
                classarm_id : null,
                classes : '',
                classArms : '',
                sessions : [],
                validationErrors: [],
			}
        },
        
        mounted() {
            this.getClasses();
        },

		methods : {
            getStudentResults() {
                const $url = '/api/school/result/termbroadsheet';
                if (!this.s_session || !this.class_id || !this.classarm_id || !this.term) {
                    this.flashMessage.error({title: 'Incomplete Data Supplied', 
                            message: 'Please select a Class, a Class Arm, a Session, and a Term',
                            time: 15000, });
                } else {
                    const params = new URLSearchParams();
                    params.append('class_id', this.class_id);
                    params.append('classarm_id', this.classarm_id);
                    params.append('session', this.s_session);
                    params.append('term', this.term);

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
                                        name: 'school-login',
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

            getClasses() {
                this.$loading(true)
                axios.get('/api/school/class/view/all')
                .then((res) => {
                    this.classes = res.data.data
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
                                    name: 'school-login',
                                    params: { return_url: return_url }
                                    });
                    }

                })
            },

            changeClass(event) {
                this.validationErrors.class_id=null
                let classID = event.target.value
                this.getClassArms(classID)
            },

            getClassArms(classID) {
                this.$loading(true)
                axios.get(`/api/school/classarm/view/${classID}`)
                .then((res) => {
                    this.classArms = res.data.data
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
                                    name: 'school-login',
                                    params: { return_url: return_url }
                                    });
                    }

                })
            },

            session() {
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