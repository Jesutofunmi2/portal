<template>
    <div class="row match-height">
		<!-- Striped rows start -->
        <div class="row">
            <div class="col-xs-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Print Eligible Students</h4>
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

                            <form class="form" novalidate @submit.prevent="getStudents()">
           
                                <div class="form-group col-md-4">
                                    <label for="issueinput1">Class</label>
                                    <select id="issueinput1" v-model="class_id" :class="{'border-danger':validationErrors.class_id}" class="form-control" name="class_id" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Class" required>
                                        <option value="">Select Class</option>
                                        <option :value="clas.id" v-for ="(clas, index) in classes" :key ="index" >{{ clas.class_name }}</option>
                                    </select>
                                    <span  v-if="validationErrors.class_id" :class="['label text-danger']">{{ validationErrors.class_id[0] }}</span>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="issueinput3">Session</label>
                                    <select type="text" id="issueinput3" v-model="session_s" @change="students=''" :class="{'border-danger':validationErrors.session}" class="form-control" name="session" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Session" required>
                                        <option value="">Select Session</option>
                                        <option v-for="year in session()" :key="year" :value="year">{{year}}/{{year+1}}</option>
                                    </select>
                                    <span  v-if="validationErrors.session" :class="['label text-danger']">{{ validationErrors.session[0] }}</span>
                                </div>

                                <div class="col-md-4">
                                    <p style="padding-top:10px;"></p>
                                    <button type="submit" class="btn btn-success">
                                        <i class="icon-ios-search-strong"></i> Get Students
                                    </button>
                                </div>

                            </form>
                        </div>
                        <div class="table-responsive">
                            <div>
                                <div v-if="students && class_id && session_s" style="float: right">
                                    <button @click="getStudents(type='print')" class="btn btn-primary"> <i class="icon-download"></i>  Download Eligible Students </button>
                                </div>
                            </div>
                            
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Fullname</th>
                                        <th>Reg. Number</th>
                                        <th>Class</th>
                                        <th>Passport</th>
                                        <th v-if="school_sessions && school_sessions.third">{{school_sessions.third}}</th>
                                        <th v-if="school_sessions && school_sessions.second">{{school_sessions.second}}</th>
                                        <th v-if="school_sessions && school_sessions.first">{{school_sessions.first}}</th>
                                        <th>Mode of Admission</th>
                                        <th>Admission Year</th>
                                        <th>Remark</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(student , index) in students" :key="index" style="text-transform:uppercase;">
                                        <th scope="row">{{ index+1 }}</th>
                                        <td>{{ student.fullname }}</td>
                                        <td>{{ student.regnum }}</td>
                                        <td>{{ student.class }}</td>
                                        <td><img :src="baseUrl+student.passport" alt="Passport" style="max-height:100px; max-width:100px"></td>
                                        <td v-if="school_sessions && school_sessions.third">{{ student.third_payment }}</td>
                                        <td v-if="school_sessions && school_sessions.second">{{ student.second_payment }}</td>
                                        <td v-if="school_sessions && school_sessions.first">{{ student.first_payment }}</td>
                                        <td>{{ student.admission_mode }}</td>
                                        <td>{{ student.reg_date }}</td>
                                        <td>{{ student.remark }}</td>
                                        
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
                session_s: null,
                class_id : null,
                classes : '',
				students : '',  
                baseUrl:  '/public',
                validationErrors: [],
                school_sessions: null
			}
        },
        
        mounted() {
            this.getClasses();
        },

		methods : {
            
			getStudents(type = 'show') {
                
                const params = new URLSearchParams();

                if (!this.session_s || !this.class_id) {
                    this.flashMessage.error({title: 'Incomplete Data Supplied', 
                            message: 'Please select a Class and a Session.',
                            time: 15000, });
                    return ;
                }

                let class_cat = ''

                this.classes.forEach(element => {
                    if(element.id == this.class_id) {
                        class_cat = element.cat
                    }
                });
            
                params.append('session', this.session_s);
                params.append('class_id', this.class_id);
                params.append('class_cat', class_cat);
                params.append('type', type);

				this.$loading(true);
				axios.get(`/api/school/student/eligible`, {params: params})
				.then((res) => {
					if(type == 'show') {
                        this.students = res.data.data.students;
                        this.school_sessions = res.data.data.session;
                    }
                    if(type == 'print') {
                        if(res.data.data.url) {
                                window.open(res.data.data.url);
                        }
                    }
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

                    if(error.response.status === 400){
						this.$alert(error.response.data.message, "Error","error");
                        return ;
					}

                    if(error.response.status === 403){
						this.$alert("Sorry, you do not have the permission to perfrom this action","No Permission","error");
					}
				})
            },

            getClasses() {
                this.$loading(true)
                axios.get('/api/school/student/eligible/classes')
                .then((res) => {
                    this.classes = res.data.data
                    this.$loading(false)
                })
                .catch((error) => {
                    this.$loading(false)
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
