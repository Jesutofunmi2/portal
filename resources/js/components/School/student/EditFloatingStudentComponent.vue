<template>
   <div class="row match-height">
		<div class="col-md-12 ">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-tooltip">
                        Move {{ surname }} {{ firstname }} {{ middlename }} to a Class
                    </h4>
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
					<div class="card-block">

						<form class="form" novalidate @submit.prevent="updateStudent">
							<div class="form-body">

                                <div class="form-group col-md-6">
									<label for="issueinput19">Class</label>
									<select id="issueinput19" v-model="class_id" @change="changeClass($event)" :class="{'border-danger':validationErrors.class_id}" class="form-control" name="class_id" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Class" required>
										<option value="">Select Class</option>
										<option :value="clas.id" v-for ="(clas, index) in classes" :key ="index" >{{ clas.class_name }}</option>
									</select>
									<span  v-if="validationErrors.class_id" :class="['label text-danger']">{{ validationErrors.class_id[0] }}</span>
								</div>

                                <div class="form-group col-md-6">
									<label for="issueinput20">Class Arm</label>
									<select id="issueinput20" v-model="classarm_id" @change="validationErrors.classarm_id=null" :class="{'border-danger':validationErrors.classarm_id}" class="form-control" name="classarm_id" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Class Arm" required>
										<option value="">Select Class Arm</option>
										<option :value="clasarm.id" v-for ="(clasarm, index) in classArms" :key ="index" >{{ clasarm.class_arm }}</option>
									</select>
									<span  v-if="validationErrors.classarm_id" :class="['label text-danger']">{{ validationErrors.classarm_id[0] }}</span>
								</div>

                                <div class="form-group col-md-6">
									<label for="issueinput21">Session</label>
									<select type="text" id="issueinput21" v-model="session" @change="validationErrors.session=null" :class="{'border-danger':validationErrors.session}" class="form-control" name="session" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Session" required>
										<option value="">Select Session</option>
                                        <option :value="session" v-for ="(session, index) in sessions" :key ="index">{{ session }}/{{ session+1 }}</option>
									</select>
									<span  v-if="validationErrors.session" :class="['label text-danger']">{{ validationErrors.session[0] }}</span>
								</div>

                                <div class="form-group col-md-6">
									<label for="issueinput22">Term</label>
									<select type="text" id="issueinput22" v-model="term" @change="validationErrors.term=null" :class="{'border-danger':validationErrors.term}" class="form-control" name="term" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Term" required>
										<option value="">Select Term</option>
										<option value="First">First</option>
                                        <option value="Second">Second</option>
                                        <option value="Third">Third</option>
									</select>
									<span  v-if="validationErrors.term" :class="['label text-danger']">{{ validationErrors.term[0] }}</span>
								</div>

							</div>

							<div class="form-actions">
								<button type="button" class="btn btn-warning mr-1">
									<i class="icon-cross2"></i> Cancel
								</button>
								<button type="submit" class="btn btn-primary">
									<i class="icon-check2"></i> Save
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<FlashMessage></FlashMessage>

	</div>
	
</template>

<script>

    export default {

		data() {
			return {
				studentId : this.$route.params.studentID,
                currDate : new Date().getFullYear(),
                classes : '',
                classArms : '',
                sessions : [],
                surname : '',
                firstname : '',
                middlename : '',
                session : '',
                term : '',
                class_id : '',
                classarm_id : '',
                validationErrors: [],
			}
		},
        mounted() {
            this.getSessions()
			this.getStudent()
        },

		methods : {
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
			
			getStudent(){
				this.$loading(true);
				axios.get(`/api/school/student/${this.studentId}/editfloating`)
				.then((res) => {
                    this.surname = res.data.data.surname;
                    this.firstname = res.data.data.firstname;
                    this.middlename = res.data.data.middlename;
					
					this.$loading(false);
					this.getClasses();
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
			},
			
            updateStudent(){
				let data = new FormData;
                data.append('class_id', this.class_id)
                data.append('classarm_id', this.classarm_id)
                data.append('session', this.session)
                data.append('term', this.term)

				this.$loading(true)

                axios.post(`/api/school/student/${this.studentId}/updatefloating`, data)
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
                        });
                    }
                })
				.catch(error => {
					this.$loading(false)
					if (!error.response) {
						this.$alert("You do not have internet access","Network Error","error")
						return
					}
					if (error.response.status == 422){
					this.validationErrors = error.response.data.errors
					this.flashMessage.error({title: 'Validation Error', 
											message: 'There is an Error with the Data you supplied',
											time: 15000, })
					}
					if(error.response.status === 401){
						let return_url = window.location.pathname;
						this.$router.push({
							name: 'student-login',
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