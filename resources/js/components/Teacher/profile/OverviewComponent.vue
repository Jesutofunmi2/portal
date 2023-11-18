<template>
   <div class="row match-height">
		<div class="col-md-12 ">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-tooltip">Update Your Overview</h4>
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

						<form class="form" novalidate @submit.prevent="updateTeacher">
							<div class="form-body">

                                <div class="form-group col-md-6">
									<label for="issueinput5">Account Type</label>
									<select type="text" id="issueinput5" v-model="teacher.teacher_type" @change="validationErrors.teacher_type=null" :class="{'border-danger':validationErrors.teacher_type}" class="form-control" name="marital_status" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select Account Type" required>
										<option :value="null">Select Category</option>
										<option value="government teacher">Government Teacher</option>
                                        <option value="pta employed">PTA Employed</option>
                                        <option value="corper">Corper</option>
										<option value="npower teacher">NPower Teacher</option>
										<option value="other">Other</option>
									</select>
									<span  v-if="validationErrors.teacher_type" :class="['label text-danger']">{{ validationErrors.teacher_type[0] }}</span>
								</div>
								<div class="form-group col-md-6">
									<label for="issueinput7">Date Of Birth</label>
									<input type="date" id="issueinput7" @change="validationErrors.teacher_date_of_birth=null" :class="{'border-danger':validationErrors.teacher_date_of_birth}" v-model="teacher.teacher_date_of_birth" class="form-control" placeholder="Date of Birth" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Date of Birth">
									<span v-if="validationErrors.teacher_date_of_birth" :class="['label text-danger']">{{ validationErrors.teacher_date_of_birth[0] }}</span>
								</div>

								<div class="form-group col-md-6">
									<label for="issueinput7">Date Of First Appointment</label>
									<input type="date" id="issueinput7" @change="validationErrors.teacher_date_of_service=null" :class="{'border-danger':validationErrors.teacher_date_of_service}" v-model="teacher.teacher_date_of_service" class="form-control" placeholder="Date Of First Appointment" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Date Of First Appointment">
									<span v-if="validationErrors.teacher_date_of_service" :class="['label text-danger']">{{ validationErrors.teacher_date_of_service[0] }}</span>
								</div>

                                <div class="form-group col-md-6">
									<label for="issueinput6">Highest Qualification</label>
									<select type="text" id="issueinput6" v-model="teacher.teacher_highest_qualification" @change="validationErrors.teacher_highest_qualification=null" :class="{'border-danger':validationErrors.teacher_highest_qualification}" class="form-control" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Highest Level of Qualification" required>
										<option :value="null">Select Qualification</option>
										<option value="master degrees with tq">Master Degrees With TQ</option>
                                        <option value="graduate With tq">Graduate With TQ</option>
                                        <option value="graduate without tq">Graduate Without TQ</option>
										<option value="hnd with tq">HND With TQ</option>
										<option value="hnd without tq">HND Without TQ</option>
										<option value="nce">NCE</option>
										<option value="ond & equivalent">OND & Equivalent</option>
										<option value="other">Others (Specified)</option>
									</select>
									<span  v-if="validationErrors.teacher_highest_qualification" :class="['label text-danger']">{{ validationErrors.teacher_highest_qualification[0] }}</span>
								</div>

                                <div class="form-group col-md-6">
									<label for="issueinput8">Major Subject Specialization</label>
									<select type="text" id="issueinput6" v-model="teacher.teacher_subject_specialization_major" @change="validationErrors.teacher_subject_specialization_major=null" :class="{'border-danger':validationErrors.teacher_subject_specialization_major}" class="form-control" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Major Subject Specialization" required>
										<option :value="null">Select Qualification</option>
										<option v-for="special, index in specialization" :key="index" :value="convertToLowerCase(special.subject_name)">{{special.subject_name}}</option>
									</select>
									<span v-if="validationErrors.teacher_subject_specialization_major" :class="['label text-danger']">{{ validationErrors.teacher_subject_specialization_major[0] }}</span>
								</div>
								<div class="form-group col-md-6">
									<label for="issueinput8">Minor Subject Specialization</label>
									<select type="text" id="issueinput6" v-model="teacher.teacher_subject_specialization_minor" @change="validationErrors.teacher_subject_specialization_minor=null" :class="{'border-danger':validationErrors.teacher_subject_specialization_minor}" class="form-control" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Minor Subject Specialization" required>
										<option :value="null">Select Qualification</option>
										<option v-for="special, index in specialization" :key="index" :value="convertToLowerCase(special.subject_name)">{{special.subject_name}}</option>
									</select>
									<span v-if="validationErrors.teacher_subject_specialization_minor" :class="['label text-danger']">{{ validationErrors.teacher_subject_specialization_minor[0] }}</span>
								</div>

                                <div class="form-group col-md-6">
									<label for="issueinput22">Description</label>
									<textarea id="issueinput22" @keydown="validationErrors.teacher_description=null" :class="{'border-danger':validationErrors.teacher_description}" v-model="teacher.teacher_description" rows="5" class="form-control" placeholder="Description" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Description" required></textarea>
									<span  v-if="validationErrors.teacher_description" :class="['label text-danger']">{{ validationErrors.teacher_description[0] }}</span>
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

		data(){
			return {
				teacher : {
                    teacher_type : null,
					teacher_description : null,
					teacher_date_of_birth : null,
					teacher_date_of_service : null,
					teacher_highest_qualification : null,
					teacher_subject_specialization_major : null,
					teacher_subject_specialization_minor : null,
                },
				specialization : [],
				validationErrors: [],	
			}
		},
        mounted() {
			this.getTeacher()
        },

		methods : {
			
			getTeacher() {
				this.$loading(true);
				axios.get('/api/teacher/overview')
				.then((res) => {
					if (res.data.overview) {
						this.teacher.teacher_type = res.data.overview.teacher_type;
						this.teacher.teacher_description = res.data.overview.teacher_description;
						this.teacher.teacher_date_of_birth = res.data.overview.teacher_date_of_birth;
						this.teacher.teacher_date_of_service = res.data.overview.teacher_date_of_service;
						this.teacher.teacher_highest_qualification = res.data.overview.teacher_highest_qualification;
						this.teacher.teacher_subject_specialization_major = res.data.overview.teacher_subject_specialization_major;
						this.teacher.teacher_subject_specialization_minor = res.data.overview.teacher_subject_specialization_minor;
					}
					this.specialization = res.data.specialization
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
							name: 'teacher-login',
							params: { return_url: return_url }
							});
					}

                    if(error.response.status === 403){
						this.$alert("Sorry, you do not have the permission to perfrom this action","No Permission","error");
					}
				})
			},
			
            updateTeacher() {
				let data = new FormData;
				const obj = this.teacher;
				Object.keys(obj).forEach(key=>{
					
					if(obj[key] == null){
						data.append(key, "");
					}
					else{
						data.append(key, obj[key]);
					}	
				});
                
				this.$loading(true)

                axios.post('/api/teacher/overview/update', data)
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
					this.getTeacher()
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
							name: 'teacher-login',
							params: { return_url: return_url }
							});
					}
					if(error.response.status === 403){
						this.$alert("Sorry, you do not have the permission to perfrom this action","No Permission","error");
					}
				});
            },

			convertToLowerCase(str) {
				return str.toLowerCase();
			},

			convertToUpperCase(str) {
				return str.toUpperCase();
			},
		}
    }
</script>