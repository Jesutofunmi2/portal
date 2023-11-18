<template>
   <div class="row match-height">
		<div class="col-md-12 ">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-tooltip">Process Teacher Transfer</h4>
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

						<form class="form" novalidate @submit.prevent="processTeacherTransfer">
							<div class="form-body">

								<div class="ml-1 mb-1" v-if="teacher.passport">
									<img :src="baseUrl+teacher.passport" style="max-width:200px">
								</div>

								<div class="form-group col-md-12">
									<label for="issueinput1">Full Name</label>
									<input type="text" id="issueinput1" @keydown="validationErrors.surname=null" class="form-control" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Full Name" :value="teacher.surname+' '+teacher.firstname+' '+teacher.middlename" readonly>
									<span v-if="validationErrors.surname" :class="['label text-danger']">{{ validationErrors.surname[0] }}</span>
								</div>

								<div class="form-group col-md-6">
									<label for="issueinput16">State</label>
									<select id="issueinput16" v-model="state" class="form-control" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select State" required>
										<option selected="selected" :value="state">{{ state }}</option>
									</select>
                                    <span  v-if="validationErrors.state_id" :class="['label text-danger']">{{ validationErrors.state_id[0] }}</span>
								</div>

								<div class="form-group col-md-6">
									<label for="issueinput17">Local Goverment Area (To transfer to)</label>
									<select id="issueinput17" v-model="lga_id" @change="lgaChange" :class="{'border-danger':validationErrors.lga_id}" class="form-control" name="lga_id" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Local Goverment Area" required>
										<option value="">Select LGA</option>
										<option :value="lga.id" v-for ="(lga ,index) in lgas" :key ="index" >{{ lga.name }}</option>
									</select>
									<span  v-if="validationErrors.lga_id" :class="['label text-danger']">{{ validationErrors.lga_id[0] }}</span>
								</div>

								<div class="form-group col-md-6">
									<label for="issueinput20">Last Session as a Teacher</label>
									<select type="text" id="issueinput20" v-model="teacher.session" @change="validationErrors.session=null" :class="{'border-danger':validationErrors.session}" class="form-control" name="session" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Session" required>
										<option value="">Select Session</option>
                                        <option :value="session" v-for ="(session, index) in sessions" :key ="index">{{ session }}/{{ session+1 }}</option>
									</select>
									<span  v-if="validationErrors.session" :class="['label text-danger']">{{ validationErrors.session[0] }}</span>
								</div>

                                <div class="form-group col-md-6">
									<label for="issueinput28">Last Term as a Teacher</label>
									<select type="text" id="issueinput28" v-model="teacher.term" @change="validationErrors.term=null" :class="{'border-danger':validationErrors.term}" class="form-control" name="term" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Term" required>
										<option value="">Select Term</option>
										<option value="First">First</option>
                                        <option value="Second">Second</option>
                                        <option value="Third">Third</option>
									</select>
									<span  v-if="validationErrors.term" :class="['label text-danger']">{{ validationErrors.term[0] }}</span>
								</div>

								<div class="form-group col-md-6">
									<label for="issueinput17">School (To Transfer to)</label>
									<select id="issueinput17" v-model="teacher.new_school" @change="validationErrors.school_id=null" :class="{'border-danger':validationErrors.school_id}" class="form-control" name="school" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="School" required>
										<option value="">Select School</option>
										<option :value="sch.id" v-for ="(sch ,index) in schools" :key ="index" >{{ sch.name }}</option>
									</select>
									<span  v-if="validationErrors.school_id" :class="['label text-danger']">{{ validationErrors.school_id[0] }}</span>
								</div>

								<div class="form-group col-md-6">
									<label for="issueinput17">Transfer Status</label>
									<select id="issueinput17" v-model="teacher.transfer_status" @change="validationErrors.transfer_status=null" :class="{'border-danger':validationErrors.transfer_status}" class="form-control" name="transfer_status" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Status" disabled>
										<option value="">Select Status</option>
										<option value="0">Pending</option>
										<option value="1">Approved</option>
									</select>
									<span  v-if="validationErrors.transfer_status" :class="['label text-danger']">{{ validationErrors.transfer_status[0] }}</span>
								</div>

                                <div class="form-group col-md-12">
									<label for="issueinput22">Reason for Transfer</label>
									<textarea id="issueinput22" @keydown="validationErrors.reason_for_transfer=null" :class="{'border-danger':validationErrors.reason_for_transfer}" v-model="teacher.reason_for_transfer" rows="5" class="form-control" name="reason_for_transfer" placeholder="Reason for Transfer" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Reason for Transfer" required></textarea>
									<span  v-if="validationErrors.reason_for_transfer" :class="['label text-danger']">{{ validationErrors.reason_for_transfer[0] }}</span>
								</div>

							</div>

							<div class="form-actions">
								<button type="button" class="btn btn-warning mr-1">
									<i class="icon-cross2"></i> Cancel
								</button>
								<button type="submit" class="btn btn-primary">
									<i class="icon-check2"></i> Submit Transfer
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
				teacherId : this.$route.params.teacherID,
				state : '',
				state_id : '',
				lgas : '',
				lga_id : '',
				sessions : [],
				schools : '',
                teacher : {
                    surname : '',
                    firstname : '',
					middlename : '',
					staff_no : '',
					passport : '',
					session : '',
					term : '',
					reason_for_transfer : '',
					new_school : '',
					transfer_status : 0,
				},
                validationErrors: [],
				baseUrl:  '/public',
			}
		},
        mounted() {
			this.getState(),
			this.getSessions()
        },

		methods : {
			getState() {
                this.$loading(true)
                axios.get('/api/general/get_state')
                .then((res) => {
                    this.state = res.data.state,
                    this.lgas = res.data.data
                    this.$loading(false);
					this.getTeacher();
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

					if(error.response.status === 400){
						this.$alert(error.response.data.message, "Request Error","error");
					}
                })
			},
			
			getTeacher() {
				this.$loading(true);
				axios.get(`/api/school/transfer/processteacher/${this.teacherId}`)
				.then((res) => {
                    this.teacher.surname = res.data.data.teacher.surname;
                    this.teacher.firstname = res.data.data.teacher.firstname;
					this.teacher.middlename = res.data.data.teacher.middlename;
					this.teacher.passport = res.data.data.teacher.passport;
					this.teacher.staff_no = res.data.data.teacher.staff_no;
					this.teacher.session = res.data.data.teacher.session;
					this.teacher.term = res.data.data.teacher.term;
					this.teacher.reason_for_transfer = res.data.data.teacher.reason_for_transfer;
					this.teacher.new_school = res.data.data.teacher.new_school;
					if (res.data.data.teacher.transfer_status === null) {
						this.teacher.transfer_status = 0;
					} else {
						this.teacher.transfer_status = res.data.data.teacher.transfer_status;
					}
					if (res.data.data.lga_id !== null) {
						this.lga_id = res.data.data.lga_id
						this.getSchools()
					}					
										
					this.$loading(false);
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

					if(error.response.status === 400){
						this.$alert(error.response.data.message, "Request Error","error");
					}
				})
			},

			getSessions() {
				for (let i = 2010; i <= 2050; i++) {
					this.sessions.push(i);
				}
			},

			lgaChange() {
				this.validationErrors.lga_id=null
				this.getSchools()
			},

			getSchools() {
				this.$loading(true);
				axios.get(`/api/school/lgaschools/view/${this.lga_id}`)
				.then((res) => {
                    this.schools = res.data.data;
										
					this.$loading(false);
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
			
            processTeacherTransfer() {
				let data = new FormData;
                data.append('former_staff_no', this.teacher.staff_no);
                data.append('reason_for_transfer', this.teacher.reason_for_transfer);
                data.append('school_id' ,this.teacher.new_school);
                data.append('session' ,this.teacher.session);
				data.append('term', this.teacher.term);
				data.append('transfer_status', this.teacher.transfer_status);
				
				this.$loading(true)

                axios.post(`/api/school/transfer/processteacher/${this.teacherId}/update`, data)
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
						
						this.getTeacher()
                    }
                })
				.catch(error => {
					this.$loading(false)
					if (!error.response) {
						this.$alert("You do not have internet access","Network Error","error");
						return ;
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
							name: 'school-login',
							params: { return_url: return_url }
							});
					}
					if(error.response.status === 403){
						this.$alert("Sorry, you do not have the permission to perform this action","No Permission","error");
					}
					
				});
            },

		}
    }
</script>