<template>
    <div class="row match-height">
		<div class="col-md-12 ">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-tooltip">Register Student</h4>
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

						<form class="form" novalidate @submit.prevent="registerStudent">
							<div class="form-body">

                                <div class="form-group col-md-6">
									<label for="issueinput1">Surname</label>
									<input type="text" id="issueinput1" @keydown="validationErrors.surname=null" :class="{'border-danger':validationErrors.surname}" v-model="student.surname" class="form-control" placeholder="Surname" name="surname" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Surname" required>
									<span v-if="validationErrors.surname" :class="['label text-danger']">{{ validationErrors.surname[0] }}</span>
								</div>

                                <div class="form-group col-md-6">
									<label for="issueinput2">First Name</label>
									<input type="text" id="issueinput2" @keydown="validationErrors.firstname=null" :class="{'border-danger':validationErrors.firstname}" v-model="student.firstname" class="form-control" placeholder="First Name" name="firstname" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="First Name" required>
									<span v-if="validationErrors.firstname" :class="['label text-danger']">{{ validationErrors.firstname[0] }}</span>
								</div>

                                <div class="form-group col-md-6">
									<label for="issueinput3">Middle Name</label>
									<input type="text" id="issueinput3" @keydown="validationErrors.middlename=null" :class="{'border-danger':validationErrors.middlename}" v-model="student.middlename" class="form-control" placeholder="Middle Name" name="middlename" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Middle Name">
									<span v-if="validationErrors.middlename" :class="['label text-danger']">{{ validationErrors.middlename[0] }}</span>
								</div>

                                <div class="form-group col-md-6">
									<label for="issueinput4">Date of Birth</label>
									<input type="text" id="issueinput4" @keydown="validationErrors.dob=null" :class="{'border-danger':validationErrors.dob}" v-model="student.dob" class="form-control" placeholder="YYYY-mm-dd" name="dob" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Date of Birth">
									<span v-if="validationErrors.dob" :class="['label text-danger']">{{ validationErrors.dob[0] }}</span>
								</div>

                                <div class="form-group col-md-6">
									<label for="issueinput5">Password</label>
									<input type="password" id="issueinput5" @keydown="validationErrors.password=null" :class="{'border-danger':validationErrors.password}" v-model="student.password" class="form-control" placeholder="Password" name="password" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Password" required>
									<span v-if="validationErrors.password" :class="['label text-danger']">{{ validationErrors.password[0] }}</span>
								</div>

                                <div class="form-group col-md-6">
									<label for="issueinput6">Confirm Password</label>
									<input type="password" id="issueinput6" @keydown="validationErrors.password_confirmation=null" :class="{'border-danger':validationErrors.password_confirmation}" v-model="student.password_confirmation" class="form-control" placeholder="Confirm Password" name="password_confirmation" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Confirm Password" required>
									<span v-if="validationErrors.password_confirmation" :class="['label text-danger']">{{ validationErrors.password_confirmation[0] }}</span>
								</div>

                                <div class="form-group col-md-6">
									<label for="issueinput19">Class</label>
									<select id="issueinput19" v-model="student.class_id" @change="changeClass($event)" :class="{'border-danger':validationErrors.class_id}" class="form-control" name="class_id" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Class" required>
										<option value="">Select Class</option>
										<option :value="clas.id" v-for ="(clas, index) in classes" :key ="index" >{{ clas.class_name }}</option>
									</select>
									<span  v-if="validationErrors.class_id" :class="['label text-danger']">{{ validationErrors.class_id[0] }}</span>
								</div>

                                <div class="form-group col-md-6">
									<label for="issueinput20">Class Arm</label>
									<select id="issueinput20" v-model="student.class_arm_id" @change="validationErrors.class_arm_id=null" :class="{'border-danger':validationErrors.class_arm_id}" class="form-control" name="class_arm_id" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Class Arm" required>
										<option value="">Select Class Arm</option>
										<option :value="clasarm.id" v-for ="(clasarm, index) in classArms" :key ="index" >{{ clasarm.class_arm }}</option>
									</select>
									<span  v-if="validationErrors.class_arm_id" :class="['label text-danger']">{{ validationErrors.class_arm_id[0] }}</span>
								</div>

                                <div class="form-group col-md-6">
									<label for="issueinput21">Session</label>
									<select type="text" id="issueinput21" v-model="student.session" @change="validationErrors.session=null" :class="{'border-danger':validationErrors.session}" class="form-control" name="session" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Session" required>
										<option value="">Select Session</option>
                                        <option :value="session" v-for ="(session, index) in sessions" :key ="index">{{ session }}/{{ session+1 }}</option>
									</select>
									<span  v-if="validationErrors.session" :class="['label text-danger']">{{ validationErrors.session[0] }}</span>
								</div>

                                <div class="form-group col-md-6">
									<label for="issueinput22">Term</label>
									<select type="text" id="issueinput22" v-model="student.term" @change="validationErrors.term=null" :class="{'border-danger':validationErrors.term}" class="form-control" name="term" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Term" required>
										<option value="">Select Term</option>
										<option value="First">First</option>
                                        <option value="Second">Second</option>
                                        <option value="Third">Third</option>
									</select>
									<span  v-if="validationErrors.term" :class="['label text-danger']">{{ validationErrors.term[0] }}</span>
								</div>

                                <div class="form-group col-md-6">
									<label for="issueinput7">Gender</label>
									<select type="text" id="issueinput7" v-model="student.gender" @change="validationErrors.gender=null" :class="{'border-danger':validationErrors.gender}" class="form-control" name="gender" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Gender" required>
										<option value="">Select Gender</option>
										<option value="Male">Male</option>
                                        <option value="Female">Female</option>
									</select>
									<span  v-if="validationErrors.gender" :class="['label text-danger']">{{ validationErrors.gender[0] }}</span>
								</div>

                                <div class="form-group col-md-6">
									<label for="issueinput8">Religion</label>
									<select type="text" id="issueinput8" v-model="student.religion" @change="validationErrors.religion=null" :class="{'border-danger':validationErrors.religion}" class="form-control" name="religion" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Religion" required>
										<option value="">Select Religion</option>
										<option value="Christian">Christian</option>
                                        <option value="Muslim">Muslim</option>
                                        <option value="Traditional">Traditional</option>
									</select>
									<span v-if="validationErrors.religion" :class="['label text-danger']">{{ validationErrors.religion[0] }}</span>
								</div>

								<div class="form-group col-md-6">
									<label for="issueinput9">State</label>
									<select id="issueinput9" v-model="student.state_id" class="form-control" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select State" required>
										<option selected="selected">{{ state }}</option>
									</select>
                                    <span  v-if="validationErrors.state_id" :class="['label text-danger']">{{ validationErrors.state_id[0] }}</span>
								</div>

								<div class="form-group col-md-6">
									<label for="issueinput10">Local Goverment Area</label>
									<select id="issueinput10" v-model="student.lga_id" @change="validationErrors.lga_id=null" :class="{'border-danger':validationErrors.lga_id}" class="form-control" name="lga_id" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Local Goverment Area" required>
										<option value="">Select LGA</option>
										<option :value="lga.id" v-for ="(lga ,index) in lgas" :key ="index" >{{ lga.name }}</option>
									</select>
									<span  v-if="validationErrors.lga_id" :class="['label text-danger']">{{ validationErrors.lga_id[0] }}</span>
								</div>

                                <div class="form-group col-md-6">
									<label for="issueinput11">School House</label>
									<select id="issueinput11" v-model="student.house_id" @change="validationErrors.house_id=null" :class="{'border-danger':validationErrors.house_id}" class="form-control" name="house_id" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="School House" required>
										<option value="">Select School House</option>
										<option :value="house.id" v-for ="(house ,index) in houses" :key ="index" >{{ house.name }}</option>
									</select>
									<span  v-if="validationErrors.house_id" :class="['label text-danger']">{{ validationErrors.house_id[0] }}</span>
								</div>

                                <div class="form-group col-md-6">
									<label for="issueinput12">Blood Group</label>
									<select id="issueinput12" v-model="student.blood_group" @change="validationErrors.blood_group=null" :class="{'border-danger':validationErrors.blood_group}" class="form-control" name="blood_group" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Blood Group" required>
										<option value="">Select Blood Group</option>
										<option value="A-">A-</option>
                                        <option value="A+">A+</option>
                                        <option value="AB-">AB-</option>
                                        <option value="AB+">AB+</option>
                                        <option value="B-">B-</option>
                                        <option value="B+">B+</option>
                                        <option value="O-">O-</option>
                                        <option value="O+">O+</option>
									</select>
									<span  v-if="validationErrors.blood_group" :class="['label text-danger']">{{ validationErrors.blood_group[0] }}</span>
								</div>

                                <div class="form-group col-md-6">
									<label for="issueinput13">Phone</label>
									<input type="text" id="issueinput13" @keydown="validationErrors.phone=null" :class="{'border-danger':validationErrors.phone}" v-model="student.phone" class="form-control" placeholder="234xxxxxxxxxx" name="phone" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Phone">
									<span v-if="validationErrors.phone" :class="['label text-danger']">{{ validationErrors.phone[0] }}</span>
								</div>

                                <div class="form-group col-md-6">
									<label for="issueinput14">Parent Full Name</label>
									<input type="text" id="issueinput14" @keydown="validationErrors.parent_fullname=null" :class="{'border-danger':validationErrors.parent_fullname}" v-model="student.parent_fullname" class="form-control" placeholder="Parent Full Name" name="parent_fullname" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Parent Full Name">
									<span v-if="validationErrors.parent_fullname" :class="['label text-danger']">{{ validationErrors.parent_fullname[0] }}</span>
								</div>

                                <div class="form-group col-md-6">
									<label for="issueinput15">Parent Phone</label>
									<input type="text" id="issueinput15" @keydown="validationErrors.parent_phone=null" :class="{'border-danger':validationErrors.parent_phone}" v-model="student.parent_phone" class="form-control" placeholder="234xxxxxxxxxx" name="parent_phone" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Parent Phone">
									<span v-if="validationErrors.parent_phone" :class="['label text-danger']">{{ validationErrors.parent_phone[0] }}</span>
								</div>

                                <div class="form-group col-md-6">
									<label for="issueinput16">Parent Email</label>
									<input type="text" id="issueinput16" @keydown="validationErrors.parent_email=null" :class="{'border-danger':validationErrors.parent_email}" v-model="student.parent_email" class="form-control" placeholder="Parent Email" name="parent_email" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Parent Email">
									<span v-if="validationErrors.parent_email" :class="['label text-danger']">{{ validationErrors.parent_email[0] }}</span>
								</div>

                                <div class="form-group col-md-6">
									<label for="issueinput17">Address</label>
									<textarea id="issueinput17" @keydown="validationErrors.address=null" :class="{'border-danger':validationErrors.address}" v-model="student.address" rows="5" class="form-control" name="address" placeholder="Address" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Address" required></textarea>
									<span  v-if="validationErrors.address" :class="['label text-danger']">{{ validationErrors.address[0] }}</span>
								</div>

                                <div class="form-group col-md-6">
									<label for="issueinput18">Parent Address</label>
									<textarea id="issueinput18" @keydown="validationErrors.parent_address=null" :class="{'border-danger':validationErrors.parent_address}" v-model="student.parent_address"  rows="5" class="form-control" name="parent_address" placeholder="Parent Address" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Parent Address" required></textarea>
									<span  v-if="validationErrors.parent_address" :class="['label text-danger']">{{ validationErrors.parent_address[0] }}</span>
								</div>

                                <div class="col-md-6" v-if="imagePreview">
									<img :src="imagePreview" style="max-height:200px; max-width:200px">
								</div>

                                <div class="form-group col-md-6">
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
									<i class="icon-check2"></i> Register
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
            currDate : new Date().getFullYear(),
            state : '',
            lgas : '',
            houses : '',
            classes : '',
            classArms : '',
            sessions : [],
            student : {
                surname : '',
                firstname : '',
                middlename : '',
                dob : '',
                gender : '',
                country : '',
                address : '',
                lga_id : '',
                religion : '',
                password : '',
                password_confirmation : '',
                class_id : '',
                class_arm_id : '',
                phone : '',
                parent_fullname : '',
                parent_address : '',
                parent_email : '',
                parent_phone : '',
                session : '',
                term : '',
                house_id : '',
                blood_group : '',
                passport : '',
            },
            imagePreview : null,
			imageError : null,
            validationErrors: [],
        }
    },

    mounted() {
        this.getState(),
        this.getSessions()
    },

    methods: {
        getState() {
            this.$loading(true)
            axios.get('/api/general/get_state')
            .then((res) => {
                this.state = res.data.state,
                this.lgas = res.data.data
                this.$loading(false);
                this.getClasses();
                this.getHouses();
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

        getHouses() {
            this.$loading(true)
            axios.get('/api/school/schoolhouse/view/all')
            .then((res) => {
                this.houses = res.data.data
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
                this.student.passport = file;
            reader.onload = (e) => {
                this.imagePreview = e.target.result;
            };
            reader.readAsDataURL(file);
        },
            
        registerStudent() {
            let data = new FormData;
            data.append('surname', this.student.surname);
            data.append('firstname', this.student.firstname);
            data.append('middlename', this.student.middlename);
            data.append('dob', this.student.dob);
            data.append('gender', this.student.gender);
            data.append('country', 'NIGERIA');
            data.append('religion', this.student.religion);
            data.append('password', this.student.password);
            data.append('password_confirmation', this.student.password_confirmation);
            data.append('class_id', this.student.class_id);
            data.append('class_arm_id', this.student.class_arm_id);
            data.append('parent_fullname', this.student.parent_fullname); 
            data.append('parent_address', this.student.parent_address);
            data.append('parent_email', this.student.parent_email);
            data.append('parent_phone', this.student.parent_phone);
            data.append('session', this.student.session);
            data.append('term', this.student.term);
            data.append('house_id', this.student.house_id);
            data.append('blood_group', this.student.blood_group);
            data.append('lga_id' ,this.student.lga_id);
            data.append('address' ,this.student.address);
            data.append('phone' ,this.student.phone);
            data.append('passport', this.student.passport);
            
            this.$loading(true)

            axios.post('/api/school/student/register',data)
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
                this.student.surname=null;
                this.student.firstname=null;
                this.student.middlename=null;
                this.student.address=null;
                this.student.dob=null;
                this.student.gender=null;
                this.student.state_id=null;
                this.student.lga_id=null;
                this.student.religion=null;
                this.student.password=null;
                this.student.password_confirmation=null;
                this.student.class_id=null;
                this.student.class_arm_id=null;
                this.student.phone=null;
                this.student.parent_fullname=null;
                this.student.parent_address=null;
                this.student.parent_email=null;
                this.student.parent_phone=null;
                this.student.session=null;
                this.student.term=null;
                this.student.house_id=null;
                this.student.blood_group=null;
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
                    this.$alert("Sorry, you do not have the permission to perfrom this action","No Permission","error");
                }
                
            });
        }
    },

}
</script>