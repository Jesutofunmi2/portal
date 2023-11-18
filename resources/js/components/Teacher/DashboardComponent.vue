<template>
    <div>
        <div class="row" >
          <div class="col-md-3">
            <div class="row" style="border:solid 1px; border-radius:15px 15px 0px 0px; box-shadow:1px 1px 3px #888888;" v-if="teacher">
              <div class="col-md-12" style="border-bottom:1px solid #333">
                <span class=""> Fullname</span>
                <h5 > <strong> {{teacher.title}} {{teacher.surname}} {{teacher.firstname}} {{teacher.middlename}} </strong></h5>
              </div>
              <div class="col-md-12" style="border-bottom:1px solid #333">
                <span class="">Teacher ID</span>
                <h5><strong> {{teacher.staff_no}}</strong></h5>
              </div>
               <div class="col-md-12" style="border-bottom:1px solid #333">
                <span class="">Email</span>
                <h5><strong>{{teacher.email}}</strong></h5>
              </div>
              <div class="col-md-12" style="border-bottom:1px solid #333">
                <span class="">Phone Number</span>
                <h5><strong>{{teacher.phone}}</strong></h5>
              </div>
              <div class="col-md-12" style="border-bottom:1px solid #333">
                <span class="">Cantact Address</span>
                <h5><strong>{{teacher.address}}</strong></h5>
              </div>
              <div class="col-md-12" style="border-bottom:1px solid #333">
                <span class="">Qualification</span>
                <h5><strong>{{teacher.qualification}}</strong></h5>
              </div>
              <div class="col-md-12" style="border-bottom:1px solid #333">
                <span class="">Gender</span>
                <h5><strong>{{teacher.gender}}</strong></h5>
              </div>
              <div class="col-md-12" style="border-bottom:1px solid #333">
                <span class="">State of Origin</span>
                <h5><strong>{{state}}</strong></h5>
              </div>
              <div class="col-md-12" style="border-bottom:1px solid #333">
                <span class="">State Local Government Area</span>
                <h5><strong>{{statelga}}</strong></h5>
              </div>
              <div class="col-md-12" style="border-bottom:1px solid #333">
                <span class="">Signature</span>
                <img :src="baseUrl+teacher.signature" alt="" width="140px" height="50px">
              </div>
              <div class="col-md-12" v-if="subjects" style="border-bottom:1px solid #333">
                <span class="">Subject Area</span>
                <h6 v-for="sub, index in subjects" :key="index"><strong>{{sub.subject_name}} ({{sub.class_category}})</strong></h6>
              </div>
              <div class="col-md-12" v-if="assigned_class" style="border-bottom:1px solid #333">
                <span class="">Subject Teacher Area</span>
                <h6 v-for="subject, index in assigned_class" :key="index"><strong style="text-transform: uppercase;">
                  {{subject.subject_name}} - {{subject.class_name}} ({{subject.class_arm}})
                  </strong>
                </h6>
              </div>
               <div  class="col-md-12" v-if="class_teacher" style="border-bottom:1px solid #333;">
                <span class="">Class Teacher Area</span>
                <h6 v-for="subject, index in class_teacher" :key="index"><strong style="text-transform: uppercase;">{{subject.class_name}} ({{subject.class_arm}})</strong></h6>
              </div>
            </div>
          </div>
          <div class="col-md-9">
            <div class="row">

                <div class="col-md-3 col-sm-4 col-xs-6">
                  <router-link :to="{ name: 'edit-teacher-profile' }">
                    <div style="border-radius: 15px;" class="card">
                      <img class="ui fuild image" height="150" width="100%" :src="url+'assets/images/icons/edit-profile.png'">
                      <div style="background-color: orange; padding: 5px; text-align: center;" class="text-white">
                        <h6><strong>Edit My Profile</strong></h6>
                      </div>
                    </div>
                  </router-link>
                </div>

                <div class="col-md-3 col-sm-4 col-xs-6">
                  <router-link :to="{ name: 'change-teacher-password' }">
                    <div style="border-radius: 15px;" class="card">
                      <img class="ui fuild image" height="150" width="100%" :src="url+'assets/images/icons/change-password.png'">
                      <div style="background-color: orange; padding: 5px; text-align: center;" class="text-white">
                        <h6><strong>Change My Password</strong></h6>
                      </div>
                    </div>
                  </router-link>
                </div>

                <div class="col-md-3 col-sm-4 col-xs-6">
                 <router-link :to="{ name: 'edit-teacher-overview' }">
                    <div style="border-radius: 15px;" class="card">
                      <img class="ui fuild image" height="150" width="100%" :src="url+'assets/images/icons/symbols-analytics-icon-1.png'">
                      <div style="background-color: orange; padding: 5px; text-align: center;" class="text-white">
                        <h6><strong>Your Overview</strong></h6>
                      </div>
                    </div>
                  </router-link>
                </div>

                <div class="col-md-3 col-sm-4 col-xs-6">
                  <router-link :to="{ name: 'change-teacher-signature' }">
                    <div style="border-radius: 15px;" class="card">
                      <img class="ui fuild image" height="150" width="100%" :src="url+'assets/images/icons/signature.png'">
                      <div style="background-color: orange; padding: 5px; text-align: center;" class="text-white">
                        <h6><strong>Change Signature</strong></h6>
                      </div>
                    </div>
                  </router-link>
                </div>

                <div class="col-md-3 col-sm-4 col-xs-6">
                  <router-link :to="{ name: 'update-teacher-subject' }">
                    <div style="border-radius: 15px;" class="card">
                      <img class="ui fuild image" height="150" width="100%" :src="url+'assets/images/icons/subject.png'">
                      <div style="background-color: orange; padding: 5px; text-align: center;" class="text-white">
                        <h6><strong>Update Subjects</strong></h6>
                      </div>
                    </div>
                  </router-link>
                </div>

                <div class="col-md-3 col-sm-4 col-xs-6">
                  <router-link :to="{ name: 'list-teacher-subject' }">
                    <div style="border-radius: 15px;" class="card">
                      <img class="ui fuild image" height="150" width="100%" :src="url+'assets/images/icons/subject.png'">
                      <div style="background-color: orange; padding: 5px; text-align: center;" class="text-white">
                        <h6><strong>List Subjects</strong></h6>
                      </div>
                    </div>
                  </router-link>
                </div>

                <div class="col-md-3 col-sm-4 col-xs-6">
                  <router-link :to="{ name: 'teacher-upload-subject-result'}">
                    <div style="border-radius: 15px;" class="card">
                      <img class="ui fuild image" height="150" width="100%" :src="url+'assets/images/icons/result_checker.png'">
                      <div style="background-color: orange; padding: 5px; text-align: center;" class="text-white">
                        <h6><strong>Upload Subjects Result</strong></h6>
                      </div>
                    </div>
                  </router-link>
                </div>

                <div class="col-md-3 col-sm-4 col-xs-6">
                  <router-link :to="{ name: 'teacher-upload-class-result' }">
                    <div style="border-radius: 15px;" class="card">
                      <img class="ui fuild image" height="150" width="100%" :src="url+'assets/images/icons/result_checker.png'">
                      <div style="background-color: orange; padding: 5px; text-align: center;" class="text-white">
                        <h6><strong>Upload Class Result</strong></h6>
                      </div>
                    </div>
                  </router-link>
                </div>

                <div class="col-md-3 col-sm-4 col-xs-6">
                  <router-link :to="{ name: 'teacher-upload-class-comment' }">
                    <div style="border-radius: 15px;" class="card">
                      <img class="ui fuild image" height="150" width="100%" :src="url+'assets/images/icons/result_checker.png'">
                      <div style="background-color: orange; padding: 5px; text-align: center;" class="text-white">
                        <h6><strong>Upload Class Comment</strong></h6>
                      </div>
                    </div>
                  </router-link>
                </div>

                <div class="col-md-3 col-sm-4 col-xs-6">
                  <router-link :to="{ name: 'teacher-list-class-result' }">
                    <div style="border-radius: 15px;" class="card">
                      <img class="ui fuild image" height="150" width="100%" :src="url+'assets/images/icons/view-result.png'">
                      <div style="background-color: orange; padding: 5px; text-align: center;" class="text-white">
                        <h6><strong>View Class Result</strong></h6>
                      </div>
                    </div>
                  </router-link>
                </div>

                <div class="col-md-3 col-sm-4 col-xs-6" @click="switchToAttendance()">
                    <div style="border-radius: 15px;" class="card">
                      <img class="ui fuild image" height="150" width="100%" :src="url+'assets/images/icons/view-result.png'">
                      <div style="background-color: orange; padding: 5px; text-align: center;" class="text-white">
                        <h6><strong>Switch to Attendance App</strong></h6>
                      </div>
                    </div>
                </div>
               
            </div>
            
          </div>
        </div>
  
    </div>
</template>

<script>
export default {

  data() {
    return {
      teacher : null,
      url : '/',
      state : null,
      statelga : null,
      subjects : null,
      assigned_class : null,
      class_teacher : null,
      baseUrl:  '/public',
    }
  },
    mounted(){
      this.getTeacher();
    },

    methods: {
      getTeacher() {
				this.$loading(true);
				axios.get('/api/teacher/dashboard')
				.then((res) => {
					this.teacher = res.data.teacher;
          this.state = res.data.state;
          this.statelga = res.data.statelga;
          this.subjects = res.data.subjects;
					this.$loading(false);
          
          this.getSubjectArea();
          this.getClassArea();
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

      getSubjectArea() {
				this.$loading(true);
				axios.get('/api/teacher/classarms/class/subjects')
				.then((res) => {
					this.assigned_class = res.data.data;
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

      getClassArea() {
				this.$loading(true);
				axios.get('/api/teacher/class')
				.then((res) => {
					this.class_teacher = res.data.data;
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

      switchToAttendance() {

        let raw_password = localStorage.getItem('raw_password');
        let username = localStorage.getItem('username');

      if(username == null || username== '' || raw_password == null || raw_password == '') {
        this.$alert("Sorry, login credentails not found, you can logout and login again then retry.","No Credentails","error");
        return;
      }

        let method = 'post';
        
        let form = document.createElement('form');
        form.setAttribute('method', method);
        form.setAttribute('action', 'https://yoursms.com.ng/attendance/portal-connect-login');
        form.setAttribute('target', "_blank");

        let usernameInput = document.createElement("input");
        usernameInput.value=username;
        usernameInput.name="username"; 
        usernameInput.type="hidden";

        let passwordInput = document.createElement("input");
        passwordInput.value=raw_password;
        passwordInput.name="password";
        passwordInput.type="hidden";

        let userType = document.createElement("input");
        userType.value=2;
        userType.name="user_type";
        userType.type="hidden";

        form.appendChild(usernameInput);
        form.appendChild(passwordInput);
        form.appendChild(userType);

        document.body.appendChild(form);
        form.submit();
      }
    }
}
</script>