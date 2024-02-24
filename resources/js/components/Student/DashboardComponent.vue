<template>
    <div>
        <div class="row" >
          <div class="col-md-3">
            <div class="row" style="border:solid 1px; border-radius:15px 15px 0px 0px; box-shadow:1px 1px 3px #888888;" v-if="student">
              <div class="col-md-12" style="border-bottom:1px solid #333">
                <img :src="baseUrl+student.passport" alt="" srcset="">
              </div>
              <div class="col-md-12" style="border-bottom:1px solid #333">
                <span class=""> Fullname</span>
                <h5 > <strong> {{student.title}} {{student.surname}} {{student.firstname}} {{student.middlename}} </strong></h5>
              </div>
              <div class="col-md-12" style="border-bottom:1px solid #333">
                <span class="">OSSIN</span>
                <h5><strong> {{student.regnum}}</strong></h5>
              </div>
               <div class="col-md-12" style="border-bottom:1px solid #333">
                <span class="">Date of Birth</span>
                <h5><strong> {{student.dob}}</strong></h5>
              </div>
              <div class="col-md-12" style="border-bottom:1px solid #333">
                <span class="">Gender</span>
                <h5><strong>{{student.gender}}</strong></h5>
              </div>
               <div class="col-md-12" style="border-bottom:1px solid #333">
                <span class="">Country</span>
                <h5><strong> {{student.country}}</strong></h5>
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
                <span class="">Phone Number</span>
                <h5><strong>{{student.phone}}</strong></h5>
              </div>
              <div class="col-md-12" style="border-bottom:1px solid #333">
                <span class="">Cantact Address</span>
                <h5><strong>{{student.address}}</strong></h5>
              </div>
              <div class="col-md-12" style="border-bottom:1px solid #333">
                <span class="">Student's Religion Address</span>
                <h5><strong>{{student.religion}}</strong></h5>
              </div>
              
            </div>
          </div>
          <div class="col-md-9">
            <div class="row">

                <div class="col-md-3 col-sm-4 col-xs-6">
                  <router-link :to="{ name: 'student-profile-edit' }">
                    <div style="border-radius: 15px;" class="card">
                      <img class="ui fuild image" height="150" width="100%" :src="url+'assets/images/icons/edit-profile.png'">
                      <div style="background-color: #45b6fe; padding: 5px; text-align: center;" class="text-white">
                        <h6><strong>Edit My Profile</strong></h6>
                      </div>
                    </div>
                  </router-link>
                </div>

                <div class="col-md-3 col-sm-4 col-xs-6">
                  <router-link :to="{ name: 'student-password-edit' }">
                    <div style="border-radius: 15px;" class="card">
                      <img class="ui fuild image" height="150" width="100%" :src="url+'assets/images/icons/change-password.png'">
                      <div style="background-color: #45b6fe; padding: 5px; text-align: center;" class="text-white">
                        <h6><strong>Change My Password</strong></h6>
                      </div>
                    </div>
                  </router-link>
                </div>

                <div class="col-md-3 col-sm-4 col-xs-6">
                  <router-link :to="{ name: 'student-passport-edit' }">
                    <div style="border-radius: 15px;" class="card">
                      <img class="ui fuild image" height="150" width="100%" :src="url+'assets/images/icons/passport-upload.png'">
                      <div style="background-color: #45b6fe; padding: 5px; text-align: center;" class="text-white">
                        <h6><strong>Upload Passport</strong></h6>
                      </div>
                    </div>
                  </router-link>
                </div>

                <div class="col-md-3 col-sm-4 col-xs-6">
                  <router-link :to="{ name: 'student-receipt-print' }">
                    <div style="border-radius: 15px;" class="card">
                      <img class="ui fuild image" height="150" width="100%" :src="url+'assets/images/icons/payment.png'">
                      <div style="background-color: #45b6fe; padding: 5px; text-align: center;" class="text-white">
                        <h6><strong>Print Payment Receipt</strong></h6>
                      </div>
                    </div>
                  </router-link>
                </div>

                <div class="col-md-3 col-sm-4 col-xs-6">
                  <router-link :to="{ name: 'student-transfer-form' }">
                    <div style="border-radius: 15px;" class="card">
                      <img class="ui fuild image" height="150" width="100%" :src="url+'assets/images/icons/transfer.png'">
                      <div style="background-color: #45b6fe; padding: 5px; text-align: center;" class="text-white">
                        <h6><strong>Student Transfer Form</strong></h6>
                      </div>
                    </div>
                  </router-link>
                </div>

                <div class="col-md-3 col-sm-4 col-xs-6">
                  <router-link :to="{ name: 'student-view-result' }">
                    <div style="border-radius: 15px;" class="card">
                      <img class="ui fuild image" height="150" width="100%" :src="url+'assets/images/icons/view-result.png'">
                      <div style="background-color: #45b6fe; padding: 5px; text-align: center;" class="text-white">
                        <h6><strong>View My Result</strong></h6>
                      </div>
                    </div>
                  </router-link>
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
      student : null,
      url : '/',
      state : null,
      statelga : null,
      baseUrl:  '/public',
    }
  },
    mounted(){
      this.getStudent();
    },

    methods: {
      getStudent() {
				this.$loading(true);
				axios.get('/api/student/dashboard')
				.then((res) => {
					this.student = res.data.student;
          this.state = res.data.state;
          this.statelga = res.data.statelga;
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
							name: 'student-login',
							params: { return_url: return_url }
							});
					}

          if(error.response.status === 403){
						this.$alert("Sorry, you do not have the permission to perfrom this action","No Permission","error");
					}
				})
			},
    }
}
</script>