<template>
   <div class="row match-height">
		<div class="col-md-12 ">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-tooltip">Edit My Profile</h4>
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

								<div style="text-align: center;">
									<img :src="baseUrl+passport" style="max-height:200px; max-width:200px">
								</div>

								<div class="form-group col-md-6">
									<label for="issueinput1">Surname</label>
									<input type="text" id="issueinput1" @keydown="validationErrors.surname=null" :class="{'border-danger':validationErrors.surname}" v-model="teacher.surname" class="form-control" placeholder="Surname" name="surname" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Surname" required>
									<span v-if="validationErrors.surname" :class="['label text-danger']">{{ validationErrors.surname[0] }}</span>
								</div>

                                <div class="form-group col-md-6">
									<label for="issueinput2">First Name</label>
									<input type="text" id="issueinput2" @keydown="validationErrors.firstname=null" :class="{'border-danger':validationErrors.firstname}" v-model="teacher.firstname" class="form-control" placeholder="First Name" name="firstname" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="First Name" required>
									<span v-if="validationErrors.firstname" :class="['label text-danger']">{{ validationErrors.firstname[0] }}</span>
								</div>

                                <div class="form-group col-md-6">
									<label for="issueinput3">Middle Name</label>
									<input type="text" id="issueinput3" @keydown="validationErrors.middlename=null" :class="{'border-danger':validationErrors.middlename}" v-model="teacher.middlename" class="form-control" placeholder="Middle Name" name="middlename" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Middle Name">
									<span v-if="validationErrors.middlename" :class="['label text-danger']">{{ validationErrors.middlename[0] }}</span>
								</div>

                                <div class="form-group col-md-6">
									<label for="issueinput4">Extra Curricular Activities</label>
									<input type="text" id="issueinput4" @keydown="validationErrors.extra_curricular_activities=null" :class="{'border-danger':validationErrors.extra_curricular_activities}" v-model="teacher.extra_curricular_activities" class="form-control" placeholder="Extra Curricular Activities" name="extra_curricular_activities" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Extra Curricular Activities">
									<span v-if="validationErrors.extra_curricular_activities" :class="['label text-danger']">{{ validationErrors.extra_curricular_activities[0] }}</span>
								</div>

                                <div class="form-group col-md-6">
									<label for="issueinput5">Marital Status</label>
									<select type="text" id="issueinput5" v-model="teacher.marital_status" @change="validationErrors.marital_status=null" :class="{'border-danger':validationErrors.marital_status}" class="form-control" name="marital_status" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Marital Status" required>
										<option value="">Select Marital Status</option>
										<option value="Single">Single</option>
                                        <option value="Married">Married</option>
                                        <option value="Divorce">Divorced</option>
									</select>
									<span  v-if="validationErrors.marital_status" :class="['label text-danger']">{{ validationErrors.marital_status[0] }}</span>
								</div>

                                <div class="form-group col-md-6">
									<label for="issueinput6">Title</label>
									<select type="text" id="issueinput6" v-model="teacher.title" @change="validationErrors.title=null" :class="{'border-danger':validationErrors.title}" class="form-control" name="title" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Title" required>
										<option value="">Select Title</option>
										<option value="MR">MR</option>
                                        <option value="MRS">MRS</option>
                                        <option value="MISS">MISS</option>
									</select>
									<span  v-if="validationErrors.title" :class="['label text-danger']">{{ validationErrors.title[0] }}</span>
								</div>

                                <div class="form-group col-md-6">
									<label for="issueinput7">Qualification</label>
									<input type="text" id="issueinput7" @keydown="validationErrors.qualification=null" :class="{'border-danger':validationErrors.qualification}" v-model="teacher.qualification" class="form-control" placeholder="qualification" name="qualification" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Qualification">
									<span v-if="validationErrors.qualification" :class="['label text-danger']">{{ validationErrors.qualification[0] }}</span>
								</div>

                                <div class="form-group col-md-6">
									<label for="issueinput8">Email</label>
									<input type="text" id="issueinput8" @keydown="validationErrors.email=null" :class="{'border-danger':validationErrors.email}" v-model="teacher.email" class="form-control" placeholder="Email Address" name="email" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Email">
									<span v-if="validationErrors.email" :class="['label text-danger']">{{ validationErrors.email[0] }}</span>
								</div>

                                <div class="form-group">
									<label for="issueinput13">Health Status Description</label>
									<input type="text" id="issueinput13" @keydown="validationErrors.health_status_desc=null" :class="{'border-danger':validationErrors.health_status_desc}" v-model="teacher.health_status_desc" class="form-control" placeholder="Health Status Description" name="health_status_desc" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Health Status Description">
									<span v-if="validationErrors.health_status_desc" :class="['label text-danger']">{{ validationErrors.health_status_desc[0] }}</span>
								</div>

                                <div class="form-group col-md-6">
									<label for="issueinput14">Health Status</label>
									<select type="text" id="issueinput14" v-model="teacher.health_status" @change="validationErrors.health_status=null" :class="{'border-danger':validationErrors.health_status}" class="form-control" name="health_status" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Health Status" required>
										<option value="">Select Health Status</option>
										<option value="Normal">Normal</option>
                                        <option value="Disable">Disabled</option>
									</select>
									<span v-if="validationErrors.health_status" :class="['label text-danger']">{{ validationErrors.health_status[0] }}</span>
								</div>

                                <div class="form-group col-md-6">
									<label for="issueinput15">Gender</label>
									<select type="text" id="issueinput15" v-model="teacher.gender" @change="validationErrors.gender=null" :class="{'border-danger':validationErrors.gender}" class="form-control" name="gender" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Gender" required>
										<option value="">Select Gender</option>
										<option value="Male">Male</option>
                                        <option value="Female">Female</option>
									</select>
									<span  v-if="validationErrors.gender" :class="['label text-danger']">{{ validationErrors.gender[0] }}</span>
								</div>

								<div class="form-group col-md-6">
									<label for="issueinput16">State</label>
									<select id="issueinput16" v-model="teacher.state_id" class="form-control" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select State" required>
										<option selected="selected">{{ state }}</option>
									</select>
                                    <span  v-if="validationErrors.state_id" :class="['label text-danger']">{{ validationErrors.state_id[0] }}</span>
								</div>

								<div class="form-group col-md-6">
									<label for="issueinput17">Local Goverment Area</label>
									<select id="issueinput17" v-model="teacher.lga_id" @change="validationErrors.lga_id=null" :class="{'border-danger':validationErrors.lga_id}" class="form-control" name="lga_id" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Local Goverment Area" required>
										<option value="">Select LGA</option>
										<option :value="lga.id" v-for ="(lga ,index) in lgas" :key ="index" >{{ lga.name }}</option>
									</select>
									<span  v-if="validationErrors.lga_id" :class="['label text-danger']">{{ validationErrors.lga_id[0] }}</span>
								</div>

                                <div class="form-group col-md-6">
									<label for="issueinput18">Phone</label>
									<input type="text" id="issueinput18" @keydown="validationErrors.phone=null" :class="{'border-danger':validationErrors.phone}" v-model="teacher.phone" class="form-control" placeholder="234xxxxxxxxxx" name="phone" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Phone">
									<span v-if="validationErrors.phone" :class="['label text-danger']">{{ validationErrors.phone[0] }}</span>
								</div>

                                <div class="form-group col-md-6">
									<label for="issueinput19">Next of Kin</label>
									<input type="text" id="issueinput19" @keydown="validationErrors.next_of_kins=null" :class="{'border-danger':validationErrors.next_of_kins}" v-model="teacher.next_of_kins" class="form-control" placeholder="Next of Kin" name="next_of_kins" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Next of Kin">
									<span v-if="validationErrors.next_of_kins" :class="['label text-danger']">{{ validationErrors.next_of_kins[0] }}</span>
								</div>

                                <div class="form-group col-md-6">
									<label for="issueinput20">Next of Kin Phone</label>
									<input type="text" id="issueinput20" @keydown="validationErrors.next_of_kins_phone=null" :class="{'border-danger':validationErrors.next_of_kins_phone}" v-model="teacher.next_of_kins_phone" class="form-control" placeholder="234xxxxxxxxxx" name="next_of_kins_phone" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Next of Kin Phone">
									<span v-if="validationErrors.next_of_kins_phone" :class="['label text-danger']">{{ validationErrors.next_of_kins_phone[0] }}</span>
								</div>

                                <div class="form-group col-md-6">
									<label for="issueinput21">Next of Kin Email</label>
									<input type="text" id="issueinput21" @keydown="validationErrors.next_of_kins_email=null" :class="{'border-danger':validationErrors.next_of_kins_email}" v-model="teacher.next_of_kins_email" class="form-control" placeholder="Next of Kin Email" name="next_of_kins_email" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Next of Kin Email">
									<span v-if="validationErrors.next_of_kins_email" :class="['label text-danger']">{{ validationErrors.next_of_kins_email[0] }}</span>
								</div>

                                <div class="form-group col-md-6">
									<label for="issueinput22">Address</label>
									<textarea id="issueinput22" @keydown="validationErrors.address=null" :class="{'border-danger':validationErrors.address}" v-model="teacher.address" rows="5" class="form-control" name="address" placeholder="Address" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Address" required></textarea>
									<span  v-if="validationErrors.address" :class="['label text-danger']">{{ validationErrors.address[0] }}</span>
								</div>

                                <div class="form-group col-md-6">
									<label for="issueinput23">Next of Kin Address</label>
									<textarea id="issueinput23" @keydown="validationErrors.next_of_kins_address=null" :class="{'border-danger':validationErrors.next_of_kins_address}" v-model="teacher.next_of_kins_address"  rows="5" class="form-control" name="next_of_kins_address" placeholder="Next of Kin Address" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Next of Kin Address" required></textarea>
									<span  v-if="validationErrors.next_of_kins_address" :class="['label text-danger']">{{ validationErrors.next_of_kins_address[0] }}</span>
								</div>

                                <div v-if="imagePreview">
									<img :src="imagePreview" style="max-height:200px; max-width:200px">
								</div>

                                <div class="form-group">
									<label for="issueinput25">Passport Photograph</label>
									<input id="upImage" type="file" @change="onImageChange" :class="{'border-danger':validationErrors.passport}" accept="image/*"  class="form-control" placeholder="Passport Photograph"  data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Passport Photograph" required>
									<span  v-if="validationErrors.passport" :class="['label text-danger']">{{ validationErrors.passport[0] }}</span>
										<br />
									<span v-if="imageError">
										{{ imageError }}
									</span> 
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
				state : '',
				lgas : '',
				passport : '',
				teacher : {
                    surname : '',
                    firstname : '',
                    middlename : '',
                    gender : '',
                    address : '',
                    lga_id : '',
                    phone : '',
                    next_of_kins_fullname : '',
                    next_of_kins_address : '',
                    next_of_kins_email : '',
                    next_of_kins_phone : '',
                    extra_curricular_activities : '',
                    health_status : '',
                    health_status_desc : '',
                    passport : '',
                    title : '',
                    marital_status : '',
                    email : '',
                    qualification : '',
                },
                imagePreview : null,
                imageError : null,
				validationErrors: [],
				baseUrl:  '/public',
				
			}
		},
        mounted() {
			this.getState()
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
                        this.$router.go(-1) ;
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

			getTeacher() {
				this.$loading(true);
				axios.get('/api/teacher/profile/edit')
				.then((res) => {
					this.teacher.surname = res.data.data.surname;
                    this.teacher.firstname = res.data.data.firstname;
                    this.teacher.middlename = res.data.data.middlename;
                    this.teacher.gender = res.data.data.gender;
                    this.teacher.email = res.data.data.email;
                    this.teacher.qualification = res.data.data.qualification;
                    this.teacher.next_of_kins = res.data.data.next_of_kins; 
                    this.teacher.next_of_kins_address = res.data.data.next_of_kins_address;
                    this.teacher.next_of_kins_email = res.data.data.next_of_kins_email;
                    this.teacher.next_of_kins_phone = res.data.data.next_of_kins_phone;
                    this.teacher.extra_curricular_activities = res.data.data.extra_curricular_activites;
                    this.teacher.health_status = res.data.data.health_status;
                    this.teacher.health_status_desc = res.data.data.health_status_desc;
                    this.teacher.marital_status = res.data.data.marital_status;
                    this.teacher.title = res.data.data.title;
                    this.teacher.lga_id = res.data.data.lga_id;
                    this.teacher.address = res.data.data.address;
                    this.teacher.phone = res.data.data.phone;
					this.passport = res.data.data.passport;

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

			onImageChange(e) {
                this.validationErrors.passport=null
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                if((files[0].type=='image/jpeg')|| (files[0].type=='image/jpg')||(files[0].type=='image/png')){
                    let max=2097152;

                    if(files[0].size > max) {
                        this.imageError = "File size too large, Maximum of 2MB"
                    }

                    this.createImage(files[0]);
                }
                else{
                    this.imageError = "Invalid Image File"
                }
                
            },

            createImage(file) {
                let reader = new FileReader();
                    this.teacher.passport = file;
                reader.onload = (e) => {
                    this.imagePreview = e.target.result;
                };
                reader.readAsDataURL(file);
            },
			
            updateTeacher() {
				let data = new FormData;
				data.append('surname', this.teacher.surname);
                data.append('firstname', this.teacher.firstname);
                data.append('middlename', this.teacher.middlename);
                data.append('gender', this.teacher.gender);
                data.append('email', this.teacher.email);
                data.append('qualification', this.teacher.qualification);
                data.append('next_of_kins', this.teacher.next_of_kins); 
                data.append('next_of_kins_address', this.teacher.next_of_kins_address);
                data.append('next_of_kins_email', this.teacher.next_of_kins_email);
                data.append('next_of_kins_phone', this.teacher.next_of_kins_phone);
                data.append('extra_curricular_activites', this.teacher.extra_curricular_activities);
                data.append('health_status', this.teacher.health_status);
                data.append('health_status_desc', this.teacher.health_status_desc);
                data.append('marital_status', this.teacher.marital_status);
                data.append('title', this.teacher.title);
                data.append('lga_id' ,this.teacher.lga_id);
                data.append('address' ,this.teacher.address);
                data.append('phone' ,this.teacher.phone);
				data.append('passport', this.teacher.passport);
				
				this.$loading(true)

                axios.post('/api/teacher/profile/update', data)
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
		}
    }
</script>