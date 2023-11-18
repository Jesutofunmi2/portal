<template>
    <div class="row match-height">
		<!-- Striped rows start -->
        <div class="row">
            <div class="col-xs-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Registered Students</h4>
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

                            <form class="form" novalidate @submit.prevent="getStudentsByParams">
							    
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
                                        <select id="issueinput2" v-model="class_arm_id" @change="validationErrors.class_arm_id=null" :class="{'border-danger':validationErrors.class_arm_id}" class="form-control" name="class_arm_id" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Class Arm" required>
                                            <option value="">Select Class Arm</option>
                                            <option :value="clasarm.id" v-for ="(clasarm, index) in classArms" :key ="index" >{{ clasarm.class_arm }}</option>
                                        </select>
                                        <span  v-if="validationErrors.class_arm_id" :class="['label text-danger']">{{ validationErrors.class_arm_id[0] }}</span>
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
                                        <select type="text" id="issueinput4" v-model="term" @change="validationErrors.term=null" :class="{'border-danger':validationErrors.term}" class="form-control" name="term" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Term" required>
                                            <option value="">Select Term</option>
                                            <option value="First">First</option>
                                            <option value="Second">Second</option>
                                            <option value="Third">Third</option>
                                        </select>
                                        <span  v-if="validationErrors.term" :class="['label text-danger']">{{ validationErrors.term[0] }}</span>
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <button type="submit" class="btn btn-success">
                                        <i class="icon-ios-search-strong"></i> Search By Class Arms and Session
                                    </button>
                                </div>

                            </form>

                            <div class="col-md-12">
                                <fieldset class="row py-2">
                                    <div class="input-group col-xs-12">
                                        <input v-model="query" type="text" required class="form-control form-control-lg input-lg border-grey border-lighten-1 " placeholder="Search By Name" aria-describedby="button-addon2">
                                        <span class="input-group-btn" id="button-addon2">
                                            <button @click="searchByTerm" class="btn btn-lg btn-success border-grey border-lighten-1" type="submit"><i class="icon-ios-search-strong"></i></button>
                                        </span>
                                    </div>
                                </fieldset>
                            </div>                         
                        </div>
                        <div class="table-responsive">
                            <div>
                                <div v-if="pagination" style="float: left">
                                    <button @click="getStudents(pagination.prev)" :class="pagination.prev ? '' : 'disabled'" class="btn btn-success"> &lt;&lt;  Prev </button> {{ meta.current_page }} of {{ meta.last_page }} <button @click="getStudents(pagination.next)" :class="pagination.next ? '' : 'disabled'" class="btn btn-success"> Next &gt;&gt;  </button>
                                </div>
                                <div v-if="students && class_id && class_arm_id && session_s && term" style="float: right">
                                    <button @click="printNorminalRoll()" class="btn btn-primary"> <i class="icon-download"></i>  Download Norminal Roll </button>
                                </div>
                            </div>
                            
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Surname</th>
                                        <th>First Name</th>
                                        <th>Middle Name</th>
                                        <th>Class(Arm)</th>
                                        <th>Reg. Number</th>
                                        <th>Passport</th>
                                        <th>Action</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(student , index) in students" :key="index" style="text-transform:uppercase;">
                                        <th scope="row">{{ index+1 }}</th>
                                        <td>{{ student.surname }}</td>
                                        <td>{{ student.firstname }}</td>
                                        <td>{{ student.middlename }}</td>
                                        <td>
                                            {{ student.clas }}<span v-if="student.arm"> (</span>{{ student.arm }}<span v-if="student.arm">)</span></td>
                                        <td>{{ student.regnum }}</td>
                                        <td><img :src="baseUrl+student.passport" alt="Passport" style="max-height:100px; max-width:100px"></td>
                                    
                                        <td>
                                            <button @click="editStudent(student.id)"  class="btn btn-primary"><i class="icon-edit"></i> Edit </button>
                                        </td>
                                        <td>
                                        <button @click="deleteStudent(student.id)"  class="btn btn-danger"><i class="icon-trash4"></i> Delete</button>
                                        </td>
                                    </tr>
                                
                                </tbody>
                            </table>
                            <div v-if="pagination">
                                <button @click="getStudents(pagination.prev)" :class="pagination.prev ? '' : 'disabled'" class="btn btn-success"> &lt;&lt;  Prev </button> {{ meta.current_page }} of {{ meta.last_page }} <button @click="getStudents(pagination.next)" :class="pagination.next ? '' : 'disabled'" class="btn btn-success"> Next &gt;&gt;  </button>
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
                class_arm_id : null,
                classes : '',
                classArms : '',
				students : '',
                query : null,
                pagination : '',
                meta : '',
                validationErrors: [],
                baseUrl:  '/public',
			}
        },
        
        mounted() {
            this.getClasses();
        },

		methods : {
            
			getStudents($url = '/api/school/student/view') {
                if($url == null) return;
                
				this.$loading(true);
				axios.get($url)
				.then((res) => {
					this.students = res.data.data,
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

            getStudentsByParams() {
                //if($url == null) return;
                const $url = '/api/school/student/view';
                if (!this.session_s || !this.class_id || !this.class_arm_id) {
                    this.flashMessage.error({title: 'Incomplete Data Supplied', 
                            message: 'Please select a Class, a Class Arm, a Session, and a Term',
                            time: 15000, });
                } else {
                    const params = new URLSearchParams();
                    params.append('class', this.class_id);
                    params.append('arm', this.class_arm_id);
                    params.append('session', this.session_s);
                    params.append('term', this.term);

                    if (this.query) {
                        params.append('query', this.query);
                    }
                
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

            searchByTerm() {

                if(this.query == null || this.query == '') return ;
                this.$loading(true);
                
                const params = new URLSearchParams();
                params.append('query', this.query);
                
                if (this.session_s && this.class_id && this.class_arm_id) {
                    params.append('class', this.class_id);
                    params.append('arm', this.class_arm_id);
                    params.append('session', this.session_s);
                }
                
				axios.get('/api/school/student/view', { 
                    params: params })
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
                this.students = null
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
            
            editStudent(id){
                this.$confirm("Are you sure you want to edit this student?","Edit Student",'question').then(() => {
                this.$router.push({
                        name: 'edit-student',
                        params: { studentID: id }
                        });
                });
            },

            deleteStudent(id){
                this.$confirm("Are you sure you want delete this student?","Delete Student",'warning').then(() => {
                this.$loading(true)
                axios.delete(`/api/school/student/${id}/delete`)
                .then((response) => {
                    this.$loading(false);
                    this.$alert(response.data.data.message,"Successful","success");
                    this.getStudents();
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
                });
            },

            printNorminalRoll(){
                if(this.class_id == null || this.class_id=="") {
                    this.flashMessage.error({title: 'Validation Error', 
											message: 'class not selected',
											time: 15000, });
                    return;
                }
                if(this.class_arm_id == null || this.class_arm_id=="") {
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
                params.append('class', +this.class_id);
                params.append('arm', this.class_arm_id);
                params.append('term', this.term);

                axios.get(`/api/school/student/norminal-roll/download`, {params: params})
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
						this.$alert(error.response.data.message, "Error","error");
                        return ;
					}
				});
            },

		}
    }
</script>
