<template>
    <div class="row match-height">
		<!-- Striped rows start -->
        <div class="row">
            <div class="col-xs-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Lock/Release Students Results</h4>
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

                            <form class="form" novalidate @submit.prevent="getStudents">
							    
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
                                        <select type="text" id="issueinput3" v-model="session" @change="validationErrors.session=null" :class="{'border-danger':validationErrors.session}" class="form-control" name="session" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Session" required>
                                            <option value="">Select Session</option>
                                            <option :value="session" v-for ="(session, index) in sessions" :key ="index">{{ session }}/{{ session+1 }}</option>
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
                                    <button type="reset" class="btn btn-warning mr-1">
                                        <i class="icon-cross2"></i> Cancel
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="icon-check2"></i> Show Students
                                    </button>
                                </div>

                            </form>                      
                        </div>
                        <div v-if="this.students.length > 0" class="table-responsive">
                            <div class="mb-1 ml-1">
                                <button class="btn btn-danger mr-1" @click="lockReleaseAll('lock')">Lock All Results</button>
                                <button class="btn btn-primary" @click="lockReleaseAll('release')">Release All Results</button>
                            </div>

                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Full Name</th>
                                        <th>Reg. Number</th>
                                        <th>Passport</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(student , index) in students" :key="index">
                                        <th scope="row">{{ index+1 }}</th>
                                        <td>
                                            {{ student.surname }} 
                                            {{ student.firstname }}
                                            {{ student.middlename }}
                                        </td>
                                        <td>{{ student.regnum }}</td>
                                        <td><img :src="baseUrl+student.passport" alt="Passport" style="max-height:100px; max-width:100px"></td>
                                    
                                        <td>
                                            <div class="form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="radio" @change="lockRelease(student.id, 'lock')" class="form-check-input lockclass" :name="`lockrelease${student.id}`"> Lock
                                                </label>
                                            </div>
                                            <div class="form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="radio" @change="lockRelease(student.
                                                    id, 'release')" class="form-check-input lockclass" :name="`lockrelease${student.id}`"> Release
                                                </label>
                                            </div>
                                        </td>
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
                session : '',
                term : '',
                class_id : '',
                classarm_id : '',
                classes : '',
                classArms : '',
                sessions : [],
				students : '',
                validationErrors: [],
                baseUrl:  '/public',
			}
        },
        
        mounted() {
            this.getClasses();
            this.getSessions();
        },

		methods : {
            getStudents() {
                const $url = '/api/school/student/view/class';
                if (!this.session || !this.class_id || !this.classarm_id || !this.term) {
                    this.flashMessage.error({title: 'Incomplete Data Supplied', 
                            message: 'Please select a Class, a Class Arm, a Session, and a Term',
                            time: 15000, });
                } else {
                    const params = new URLSearchParams();
                    params.append('class_id', this.class_id);
                    params.append('classarm_id', this.classarm_id);
                    params.append('session', this.session);
                    params.append('term', this.term);
                
                    this.$loading(true);
                    axios.get($url, {
                        params : params
                    })
                    .then((res) => {
                        this.students = res.data.data,
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

            getSessions() {
                for (let i = 2010; i <= 2050; i++) {
                    this.sessions.push(i);
                }
            },

            lockRelease(id, type) {
                let data = new FormData
                data.append('student_id', id)
                data.append('class_id', this.class_id)
                data.append('classarm_id', this.classarm_id)
                data.append('session', this.session)
                data.append('term', this.term)
                data.append('type', type)

				this.$loading(true)

                axios.post('/api/school/result/lockrelease', data)
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

            lockReleaseAll(type) {
                let data = new FormData
                data.append('class_id', this.class_id)
                data.append('classarm_id', this.classarm_id)
                data.append('session', this.session)
                data.append('term', this.term)
                data.append('type', type)

                let lockInputs = document.querySelectorAll('.lockclass')
                
                lockInputs.forEach(input => {
                    input.checked = false
                })

				this.$loading(true)

                axios.post('/api/school/result/lockreleaseall', data)
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
		}
    }
</script>