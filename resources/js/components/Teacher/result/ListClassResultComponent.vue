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
                                        <label for="issueinput21">Session</label>
                                        <select type="text" id="issueinput21" v-model="session" @change="getClass" :class="{'border-danger':validationErrors.session}" class="form-control" name="session" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Session" required>
                                            <option value="">Select Session</option>
                                            <option :value="session" v-for ="(session, index) in sessions" :key ="index">{{ session }}/{{ session+1 }}</option>
                                        </select>
                                        <span  v-if="validationErrors.session" :class="['label text-danger']">{{ validationErrors.session[0] }}</span>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="issueinput22">Term</label>
                                        <select type="text" id="issueinput22" v-model="term" @change="validationErrors.term=null" :class="{'border-danger':validationErrors.term}" class="form-control" name="term" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Term" required>
                                            <option value="">Select Term</option>
                                            <option value="First">First</option>
                                            <option value="Second">Second</option>
                                            <option value="Third">Third</option>
                                        </select>
                                        <span  v-if="validationErrors.term" :class="['label text-danger']">{{ validationErrors.term[0] }}</span>
                                    </div>

                                   <div class="form-group col-md-6">
                                        <label for="issueinput1">Available Class & Arms</label>
                                        <select id="issueinput1" v-model="selected_class_arms" @change="classChange()" class="form-control" name="class_id" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Class" required>
                                            <option :value="null">Select Class arms</option>
                                            <option :value="class_arm" v-for ="(class_arm, index) in class_arms_list" :key ="index" >{{ class_arm.class_name }} {{ class_arm.class_arm }}</option>
                                        </select>
                                    
                                    </div>

                                </div>

                                <div class="form-actions pl-1">
                                    <button type="submit" class="btn btn-success">
                                        <i class="icon-ios-search-strong"></i> Display Results
                                    </button>
                                </div>

                            </form>

                        </div>
                        <div v-if="class_id === ''" class="px-2">
                            <p>
                                <b><i>Please select a Session, Term, Class, and Arm to display the Results</i></b>
                            </p>
                        </div>
                        <div v-if="students.length === 0 && class_id !== ''" class="px-2">
                            <p>
                                <b><i>There are no results available</i></b>
                            </p>
                        </div>
                        <div class="px-2 mb-2" v-for="(student, index) in students" :key="index">
                            <h3>{{ index + 1 }}. {{ student.surname }} {{ student.firstname }} {{ student.middlename }}</h3>
                            <div class="table-responsive">
                                <table class="table table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Subject</th>
                                            <th>CA Score</th>
                                            <th>Exam Score</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="student.student_results.length > 0">
                                        <tr v-for="(result, ind) in student.student_results" :key="ind">
                                            <th scope="row">{{ ind+1 }}</th>
                                            <td>{{ result.subject.subject_name }}</td>
                                            <td>
                                                {{ result.ca_score }}
                                            </td>
                                            <td>
                                                {{ result.exam_score }}
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
                session : '',
                term : '',
                class_id : '',
                classarm_id : '',
                class_name : '',
                class_arm : '',
                class_arms_list : '',
                selected_class_arms : null,
                sessions : [],
                students : '',
                validationErrors: [],
			}
        },
        
        mounted() {
            this.getSessions();
        },

		methods : {
            getStudentResults() {
                const $url = '/api/teacher/result/view';
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
                                        name: 'teacher-login',
                                        params: { return_url: return_url }
                                        });
                        }

                        if(error.response.status === 403){
                            this.$alert("Sorry, you do not have the permission to perfrom this action","No Permission","error");
                        }
                    })
                }
            },

            getClass() {
                this.validationErrors.session = null
                this.$loading(true)
                axios.get(`/api/teacher/class/${this.session}`)
                .then((res) => {
                  if(res.data.data && res.data.data.length > 0) {
                    this.class_arms_list = res.data.data
                }
                else {
                     this.flashMessage.error({title: 'Error', 
                        message: 'No data retrived',
                        time: 15000, });
                }

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
                                    name: 'teacher-login',
                                    params: { return_url: return_url }
                                    });
                    }

                })
            },

            classChange() {
            if (this.selected_class_arms == null)
            {
                this.class_id = "";
                this.classarm_id = "";
                this.class_name = "";
                this.class_arm = "";
            }

            this.class_id = this.selected_class_arms.class_id;
            this.classarm_id = this.selected_class_arms.classarm_id;
            this.class_name = this.selected_class_arms.class_name;
            this.class_arm = this.selected_class_arms.class_arm;
        },

            getSessions() {
                for (let i = 2010; i <= 2050; i++) {
                    this.sessions.push(i);
                }
            },
		}
    }
</script>
