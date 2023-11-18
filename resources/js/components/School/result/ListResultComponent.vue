<template>
    <div class="row match-height">
		<!-- Striped rows start -->
        <div class="row">
            <div class="col-xs-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">List Student Results</h4>
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
                                        <select id="issueinput2" v-model="classarm_id" @change="students=''" :class="{'border-danger':validationErrors.classarm_id}" class="form-control" name="classarm_id" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Class Arm" required>
                                            <option value="">Select Class Arm</option>
                                            <option :value="clasarm.id" v-for ="(clasarm, index) in classArms" :key ="index" >{{ clasarm.class_arm }}</option>
                                        </select>
                                        <span  v-if="validationErrors.classarm_id" :class="['label text-danger']">{{ validationErrors.classarm_id[0] }}</span>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="issueinput3">Session</label>
                                        <select type="text" id="issueinput3" v-model="session_s" @change="students=''" :class="{'border-danger':validationErrors.session}" class="form-control" name="session" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Session" required>
                                            <option value="">Select Session</option>
                                           <option v-for="year in session()" :key="year" :value="year">{{year}}/{{year+1}}</option>
                                        </select>
                                        <span  v-if="validationErrors.session" :class="['label text-danger']">{{ validationErrors.session[0] }}</span>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="issueinput4">Term</label>
                                        <select type="text" id="issueinput4" v-model="term" @change="students=''" :class="{'border-danger':validationErrors.term}" class="form-control" name="term" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Term" required>
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
                                        <i class="icon-ios-search-strong"></i> Display Results
                                    </button>
                                    
                                </div>

                            </form>

                        </div>
                        <div v-if="class_id === null" class="px-2">
                         
                            <p>
                                <b><i>Please select a Session, Term, Class, and Arm to display the Results</i></b>
                            </p>
                        </div>
                        <div v-if="students.length === 0 && class_id !== null" class="px-2">
                            <p>
                                <b><i>There are no results available</i></b>
                            </p>
                        </div>
                        <div class="px-2 mb-2" v-for="(student, index) in students" :key="index">
                            <div style="float: left">
                                <h3>{{ index + 1 }}. {{ student.surname }} {{ student.firstname }} {{ student.middlename }}</h3>
                            </div>
                            <div style="float:right;">
                                <div v-if="student.student_results.length > 0">
                                    <button class="btn btn-success" @click="printResultHtml(student.id)">Print Result in HTML</button>
                                    <button class="btn btn-primary" @click="printResultPdf(student.id)">Print Result PDF</button>
                                </div>
                                
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Subject</th>
                                            <th>CA-1 Score</th>
                                            <th>CA-2 Score</th>
                                            <th>Exam Score</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="student.student_results.length > 0">
                                        <tr v-for="(result, ind) in student.student_results" :key="ind">
                                            <th scope="row">{{ ind+1 }}</th>
                                            <td>{{ result.subject.subject_name }}</td>
                                            <td>
                                                <input data-score="ca" @change="updateResult($event, result.id)" name="ca_score" type="text" :readonly="result.status == 1" :value="result.ca_score">
                                            </td>
                                            <td>
                                                <input data-score="ca2" @change="updateResult($event, result.id)" name="ca2_score" type="text" :readonly="result.status == 1" :value="result.ca2_score">
                                            </td>
                                            <td>
                                                <input data-score="exam" @change="updateResult($event, result.id)" name="exam_score" type="text" :readonly="result.status == 1" :value="result.exam_score">
                                            </td>
                                            <td>
                                            <div v-if="result.status == 0">
                                                <button @click="deleteResult(result.id)"  class="btn btn-danger"><i class="icon-trash4"></i> Delete</button>
                                            </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="5">No results have been recorded</td> 
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

		data() {
			return {
                session_s : null,
                term : null,
                class_id : null,
                classarm_id : null,
                classes : '',
                classArms : '',
                sessions : [],
                students : '',
                validationErrors: [],
			}
        },
        
        mounted() {
            this.getClasses();
        },

		methods : {
            getStudentResults() {
                const $url = '/api/school/result/view';
                if (!this.session_s || !this.class_id || !this.classarm_id || !this.term) {
                    this.flashMessage.error({title: 'Incomplete Data Supplied', 
                            message: 'Please select a Class, a Class Arm, a Session, and a Term',
                            time: 15000, });
                } else {
                    const params = new URLSearchParams();
                    params.append('class_id', this.class_id);
                    params.append('classarm_id', this.classarm_id);
                    params.append('session', this.session_s);
                    params.append('term', this.term);

                    this.$loading(true);
                    axios.get($url, {
                        params : params
                    })
                    .then((res) => {
                        this.students = res.data.data,
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

                        if(error.response.status === 403){
                            this.$alert("Sorry, you do not have the permission to perfrom this action","No Permission","error");
                        }
                    })
                }
            },

            getClasses() {
                this.$loading(true);

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
                this.validationErrors.class_id=null;
                let classID = event.target.value;
                this.students = '';
                this.getClassArms(classID);
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
            
            editResult(id){
                this.$confirm("Are you sure you want to update this result?","Edit Result",'question')
                .then(() => {
                    this.$router.push({
                        name: 'edit-student',
                        params: { studentID: id }
                    });
                });
            },

            updateResult(event, id) {
                let name = event.target.name
                let value = event.target.value

                let data = new FormData
                data.append('result_id', id)
                data.append('score_type', name)
                data.append('value', value)

				this.$loading(true)

                axios.post('/api/school/result/update', data)
				.then(response => {
                    if(response) {
						this.$loading(false)
                        this.flashMessage.success({
                            title: 'Successful',
                            message: response.data.data.message,
                            time: 15000,
                            flashMessageStyle: {
                                backgroundColor: 'linear-gradient(#e66465, #9198e5)'
                            }
                        })
                    }
					
                })
				.catch(error => {
					this.$loading(false)
					if (!error.response) {
						this.$alert("You do not have internet access","Network Error","error");
						return
					}
					if (error.response.status == 422){
					this.validationErrors = error.response.data.errors;
					this.flashMessage.error({title: 'Validation Error', 
											message: 'There is an Error with the Data you supplied',
											time: 15000, })
					}
					if(error.response.status === 401){
						let return_url = window.location.pathname;
						this.$router.push({
							name: 'school-login',
							params: { return_url: return_url }
							})
					}
					if(error.response.status === 403){
						this.$alert("Sorry, you do not have the permission to perfrom this action","No Permission","error")
					}
					
				})
            },

            deleteResult(id){
                this.$confirm("Are you sure you want delete this result?","Delete Result",'warning').then(() => {
                this.$loading(true)
                axios.delete(`/api/school/result/${id}/delete`)
                .then((response) => {
                    this.$loading(false);
                    this.$alert(response.data.data.message,"Successful","success");
                    this.getStudentResults();
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
							})
					}
				})
                });
            },

            printResultPdf(student_id){
        
                if(this.class_id == null || this.class_id=="") {
                    this.flashMessage.error({title: 'Validation Error', 
											message: 'class not selected',
											time: 15000, });
                    return;
                }
                if(this.classarm_id == null || this.classarm_id=="") {
                    this.flashMessage.error({title: 'Validation Error', 
											message: 'class arm not selected',
											time: 15000, });
                    return;
                }
                if(this.session_s == null || this.session_s=="") {
                    this.flashMessage.error({title: 'Validation Error', 
											message: 'session not selected',
											time: 15000, });
                    return;
                }
                if(this.term == null || this.term=="") {
                    this.flashMessage.error({title: 'Validation Error', 
											message: 'term not selected',
											time: 15000, });
                    return;
                }

                this.$loading(true);
                const paramss = new URLSearchParams();
            
                paramss.append('session', this.session_s);
                paramss.append('student_id', student_id);
                paramss.append('class_id', +this.class_id);
                paramss.append('classarm_id', this.classarm_id);
                paramss.append('term', this.term);

                axios.get(`/api/school/result/check/print`, {params: paramss})
                .then((response) => {
                    if(response.data.data.status == true) {
                        const params = new URLSearchParams();
                        params.append('class_id', this.class_id);
                        params.append('classarm_id', this.classarm_id);
                        params.append('session', this.session_s);
                        params.append('term', this.term);
                        params.append('student_id', student_id);
                        params.append('print_type', 'pdf');

                        axios({
                                url: `/api/school/result/print`,
                                method: 'GET',
                                params: params,
                            })
                        .then((response) => {

                            this.$loading(false);

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

                            if(error.response.status === 403){
                                this.$alert("Sorry, you do not have the permission to perfrom this action","No Permission","error");
                            }
                        })
                    }
                    if(response.data.data.status == false) {
                       this.$alert(response.data.data.message, "Error","error");
                       this.$loading(false);
                      return;
                   }
				})
				.catch((error) => {
                    this.$loading(false);
					if (!error.response) {
						this.$alert("You do not have internet access","Network Error","error");
						return ;
					}

                    if(error.response.status === 403){
						this.$alert("Sorry, you do not have the permission to perfrom this action","No Permission","error");
                        return ;
					}

                    if(error.response.status === 401){
						let return_url = window.location.pathname;
						this.$router.push({
							name: 'school-login',
							params: { return_url: return_url }
							})
					}

                    if(error.response.status === 400){
						this.$alert(response.data.data.message, "Error","error");
                        return ;
					}
				});
                
            },

            printResultHtml(student_id){
                
                if(this.class_id == null || this.class_id=="") {
                    this.flashMessage.error({title: 'Validation Error', 
											message: 'class not selected',
											time: 15000, });
                    return;
                }
                if(this.classarm_id == null || this.classarm_id=="") {
                    this.flashMessage.error({title: 'Validation Error', 
											message: 'class arm not selected',
											time: 15000, });
                    return;
                }
                if(this.session_s == null || this.session_s=="") {
                    this.flashMessage.error({title: 'Validation Error', 
											message: 'session not selected',
											time: 15000, });
                    return;
                }
                if(this.term == null || this.term=="") {
                    this.flashMessage.error({title: 'Validation Error', 
											message: 'term not selected',
											time: 15000, });
                    return;
                }

                this.$loading(true);
                const params = new URLSearchParams();
            
                params.append('session', this.session_s);
                params.append('student_id', student_id);
                params.append('class_id', +this.class_id);
                params.append('classarm_id', this.classarm_id);
                params.append('term', this.term);

                axios.get(`/api/school/result/check/print`, {params: params})
                .then((response) => {
                    
                    if(response.data.data.status == true) {
                        this.$loading(false);
                
                        window.open('/api/school/result/print?student_id='+student_id+'&class_id='+this.class_id+'&classarm_id='+this.classarm_id+'&session='+this.session_s+'&term='+this.term+'&print_type=html',
                        'Student '+student_id+' Result','directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=850,height=900');
                   }
                   if(response.data.data.status == false) {
                       this.$alert(response.data.data.message, "Error","error");
                       this.$loading(false);
                      return;
                   }
				})
				.catch((error) => {
                    this.$loading(false);
					if (!error.response) {
						this.$alert("You do not have internet access","Network Error","error");
						return ;
					}

                    if(error.response.status === 400){
						this.$alert(response.data.data.message, "Error","error");
                        return ;
					}

                    if(error.response.status === 401){
						let return_url = window.location.pathname;
						this.$router.push({
							name: 'school-login',
							params: { return_url: return_url }
							})
					}

                    if(error.response.status === 403){
						this.$alert("Sorry, you do not have the permission to perfrom this action","No Permission","error");
                        return ;
					}
				});
               
            },

		}
    }
</script>