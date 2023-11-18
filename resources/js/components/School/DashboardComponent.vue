<template>
    <div>

    <div class="row">
      <div class="col-xl-12 col-lg-12 col-xs-12">
        <div class="card">
            <div class="card-body">
                <div class="card-block">
                    <div class="media">
                        <div class="media-body text-xs-left">
                            <h3 v-if="stats" style="text-transform: capitalize;" class="teal">Welcome to {{stats.schoolName}}'s Portal Control Dashboard</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-6 col-xs-12">
        <div class="card">
            <div class="card-body">
                <div class="card-block">
                    <div class="media">
                        <div class="media-body text-xs-left">
                            <h3 v-if="stats" class="teal">{{stats.totalTeacher}}</h3>
                            <span>Total Teacher</span>
                        </div>
                        <div class="media-right media-middle">
                            <i class="icon-person-stalker teal font-large-2 float-xs-right"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-6 col-xs-12">
        <div class="card">
            <div class="card-body">
                <div class="card-block">
                    <div class="media">
                        <div class="media-body text-xs-left">
                            <h3 v-if="stats" class="deep-#45b6fe">{{stats.totalStudent}}</h3>
                            <span>Total Student</span>
                        </div>
                        <div class="media-right media-middle">
                            <i class="icon-man-woman deep-#45b6fe font-large-2 float-xs-right"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-6 col-xs-12">
        <div class="card">
            <div class="card-body">
                <div class="card-block">
                    <div class="media">
                        <div class="media-body text-xs-left">
                            <h3 v-if="stats" class="teal">{{stats.totalSchoolAdmin}}</h3>
                            <span>Total School Admin</span>
                        </div>
                        <div class="media-right media-middle">
                            <i class="icon-ios-people teal font-large-2 float-xs-right"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
      <div class="col-xl-12 col-lg-12 col-xs-12">
        <h3 v-if="academic_session">{{ academic_session }} academic session students breakdown to class by gender</h3>
        <BarChart 
          :chart-data="myChartData" 
        />
      </div>
</div>
<p></p>

<div class="row">
      <div class="col-xl-6 col-lg-6 col-md-6 col-xs-12">
        <h3 v-if="academic_session">{{ academic_session }} academic session students by gender</h3>
        <DoughnutChart 
          :chart-data="genderChart" 
        />
      </div>
      <div class="col-xl-6 col-lg-6 col-md-6 col-xs-12">
        <h3 v-if="academic_session">{{ academic_session }} academic session students by class</h3>
        <DoughnutChart 
          :chart-data="classChart" 
        />
      </div>
</div>
<p></p>

<div class="" style="border:2px #bbb solid; border-radius:15px; padding:5px;">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <h3> <i class="icon-link"></i> Quick Links</h3>
            <hr>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <h5>User Configuration</h5>
          </div>
          <div class="col-md-2 col-sm-4 col-xs-12">
             <router-link :to="{ name: 'edit-admin-profile' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/edit-profile.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6> <strong>Edit My Profile</strong> </h6>
              </div>
            </div>
            </router-link>
          </div>

          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'change-admin-password' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/change-password.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6><strong>Change My Password</strong></h6>
              </div>
            </div>
            </router-link>
          </div>

          <div class="col-md-2 col-sm-4 col-xs-12">
             <router-link :to="{ name: 'create-admin' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/Register-512.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6> <strong>Add User</strong> </h6>
              </div>
            </div>
            </router-link>
          </div>

          <div class="col-md-2 col-sm-4 col-xs-12">
             <router-link :to="{ name: 'list-admin' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/remarks.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6> <strong>List Users</strong> </h6>
              </div>
            </div>
            </router-link>
          </div>

        </div>

        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <h5>School Configuration</h5>
          </div>
          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'edit-admin-school-profile' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/edit-profile.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6><strong>Edit School Profile</strong></h6>
              </div>
            </div>
            </router-link>
          </div>

          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'edit-school-logo' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/edit-profile.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6><strong>Edit School Logo</strong></h6>
              </div>
            </div>
            </router-link>
          </div>

          <div class="col-md-2 col-sm-4 col-xs-12">
             <router-link :to="{ name: 'edit-school-counsign' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/edit-profile.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6><strong>Edit Counsellor Signature</strong></h6>
              </div>
            </div>
            </router-link>
          </div>

        </div>

        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <h5>House Configuration</h5>
          </div>
          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'create-school-house' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/school2.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6> <strong>Create House</strong> </h6>
              </div>
            </div>
            </router-link>
          </div>
      
          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'list-school-house' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/school-icon.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6><strong>List Houses</strong></h6>
              </div>
            </div>
            </router-link>
          </div>

          
        </div>

        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <h5>Student Configuration</h5>
          </div>
          <div class="col-md-2 col-sm-4 col-xs-12">
             <router-link :to="{ name: 'register-student' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/Register-512.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6> <strong>Register Student</strong> </h6>
              </div>
            </div>
            </router-link>
          </div>
      
          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'batch-register-student' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/assignment.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6><strong>Batch Registration</strong></h6>
              </div>
            </div>
            </router-link>
          </div>

          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'batch-upload-student-passport' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/passport-upload.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6><strong>Passport Uploads</strong></h6>
              </div>
            </div>
            </router-link>
          </div>

          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'list-student' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/view-students.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6><strong>List Students</strong></h6>
              </div>
            </div>
            </router-link>
          </div>

          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'list-floating-student' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/view-students.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6><strong>List Floating Students</strong></h6>
              </div>
            </div>
            </router-link>
          </div>

          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'list-student-subject' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/subject.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6><strong>List Student Subjects</strong></h6>
              </div>
            </div>
            </router-link>
          </div>
          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'eligible-student' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/view-students.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6><strong>Eligible Students</strong></h6>
              </div>
            </div>
            </router-link>
          </div>

          <!-- <div class="col-md-2 col-sm-4 col-xs-12">
            
            <div style="border-radius: 15px; cursor: pointer;" class="card" @click="switchToOld('https://odsgmoest.org.ng/eportal/admin/student/batch-create-with-osno')">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/parent.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:90px;" class="text-white">
                <h6><strong>Batch Student Registration (Strictly for Existing Student with OSSI No)</strong></h6>
              </div>
            </div>
          </div>

           <div class="col-md-2 col-sm-4 col-xs-12">
            
            <div style="border-radius: 15px; cursor: pointer;" class="card">
              <a href="https://odsgmoest.org.ng/eportal/public/exceluploads/studentBatchRegistrationWithOsNo.xls">
                <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/parent.png'">
                <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:90px;" class="text-white">
                  <h6><strong>Download Batch Student Registration Format (Existing Student with OSSI No)</strong></h6>
                </div>
              </a>
            </div>
          </div> -->

        </div>

        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <h5>Teachers Configuration</h5>
          </div>
          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'register-teacher' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/sv.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6> <strong>Register Single Teacher</strong> </h6>
              </div>
            </div>
            </router-link>
          </div>
      
          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'batch-register-teacher' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/assignment.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6><strong>Teacher Batch Registration</strong></h6>
              </div>
            </div>
            </router-link>
          </div>

          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'list-teacher' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/view-students.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6><strong>List Teachers</strong></h6>
              </div>
            </div>
            </router-link>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <h5>Class Configuration</h5>
          </div>
          <div class="col-md-2 col-sm-4 col-xs-12">
             <router-link :to="{ name: 'add-class' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/remarks.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6> <strong>Add Class</strong> </h6>
              </div>
            </div>
            </router-link>
          </div>
      
          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'list-class' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/assignment.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6><strong>List Classes</strong></h6>
              </div>
            </div>
            </router-link>
          </div>

        </div>

        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <h5>Class Arm Configuration</h5>
          </div>
          <div class="col-md-2 col-sm-4 col-xs-12">
             <router-link :to="{ name: 'add-classarm' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/remarks.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6> <strong>Add Class Arm</strong> </h6>
              </div>
            </div>
            </router-link>
          </div>
      
          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'list-classarm' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/assignment.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6><strong>List Class Arms</strong></h6>
              </div>
            </div>
            </router-link>
          </div>

          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'list-classarm-subject' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/assignment.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6><strong>Assign Class Subjects</strong></h6>
              </div>
            </div>
            </router-link>
          </div>

          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'list-classarm-teacher' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/view-students-icon.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6><strong>Assign Class Teachers</strong></h6>
              </div>
            </div>
            </router-link>
          </div>

          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'list-classarm-counsellor' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/view-students-icon.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6><strong>Assign Class Counsellors</strong></h6>
              </div>
            </div>
            </router-link>
          </div>

          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'list-classarm-student' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/view-students-icon.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6><strong>Assign Student to Class</strong></h6>
              </div>
            </div>
            </router-link>
          </div>
          
          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'remove-classarm-student' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/view-students-icon.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6><strong>Remove Student from Class</strong></h6>
              </div>
            </div>
            </router-link>
          </div>

        </div>

        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <h5>Result Configuration</h5>
          </div>
          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'upload-school-subject-result' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/passport-upload.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6> <strong>Upload Results By Subject</strong> </h6>
              </div>
            </div>
            </router-link>
          </div>
      
          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'upload-school-result' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/passport-upload.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6><strong>Batch Upload Result All Subject (new)</strong></h6>
              </div>
            </div>
            </router-link>
          </div>

          <!-- <div class="col-md-2 col-sm-4 col-xs-12">
            
            <div style="border-radius: 15px; cursor: pointer;" class="card" @click="switchToOld('https://odsgmoest.org.ng/eportal/admin/result/upload-all-subject')">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/view-students-icon.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6><strong>Batch Upload Result All Subject (old)</strong></h6>
              </div>
            </div>
          </div> -->

          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'upload-result-comment' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/remarks.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6><strong>Upload Result Comments</strong></h6>
              </div>
            </div>
            </router-link>
          </div>
          
          
          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'update-result-sign' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/school-result-signature.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6><strong>Update Result Signatures</strong></h6>
              </div>
            </div>
            </router-link>
          </div>

          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'result-promotion-stamp' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/school-result-signature.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6><strong>Result Promotion Stamp</strong></h6>
              </div>
            </div>
            </router-link>
          </div>

          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'result-lock-release' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/change-password.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6><strong>Lock/Release Results</strong></h6>
              </div>
            </div>
            </router-link>
          </div>

          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'list-school-result' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/result_checker.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6><strong>List Results</strong></h6>
              </div>
            </div>
            </router-link>
          </div>

          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'list-term-broadsheet' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/result_checker.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6><strong>View Termly Broadsheets</strong></h6>
              </div>
            </div>
            </router-link>
          </div> 

          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'list-session-broadsheet' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/result_checker.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6><strong>View Session Broadsheets</strong></h6>
              </div>
            </div>
            </router-link>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <h5>Debtor Configuration</h5>
          </div>
          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'add-debtor' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/unity.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6> <strong>Add Debtor</strong> </h6>
              </div>
            </div>
            </router-link>
          </div>
      
          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'list-debtor' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/signature.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6><strong>List Debtors</strong></h6>
              </div>
            </div>
            </router-link>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <h5>Library Configuration</h5>
          </div>
          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'add-library-category' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/view-result.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6> <strong>Add Category</strong> </h6>
              </div>
            </div>
            </router-link>
          </div>
      
          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'list-library-category' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/signature.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6><strong>List Categories</strong></h6>
              </div>
            </div>
            </router-link>
          </div>

          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'add-library-book' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/subject.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6><strong>Add Book</strong></h6>
              </div>
            </div>
            </router-link>
          </div>

          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'list-library-book' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/subject.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6><strong>List Books</strong></h6>
              </div>
            </div>
            </router-link>
          </div>

           <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'add-library-issue' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/subject.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6><strong>Issue Book</strong></h6>
              </div>
            </div>
            </router-link>
          </div>

          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'list-library-issue' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/subject.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6><strong>List Book Issuances</strong></h6>
              </div>
            </div>
            </router-link>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <h5>Wallet Configuration</h5>
          </div>
          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'list-school-transaction' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/Wallet-512.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6> <strong>List Transactions</strong> </h6>
              </div>
            </div>
            </router-link>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <h5>Teacher Transfers</h5>
          </div>
          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'new-teacher-transfer' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/transfer.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6> <strong>New Teacher Transfer</strong> </h6>
              </div>
            </div>
            </router-link>
          </div>

          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'list-teacher-transfer-inward' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/view-result.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6> <strong>List Inward Transfers</strong> </h6>
              </div>
            </div>
            </router-link>
          </div>

          <div class="col-md-2 col-sm-4 col-xs-12">
             <router-link :to="{ name: 'list-teacher-transfer-outward' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/view-result.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6> <strong>List Outward Transfers</strong> </h6>
              </div>
            </div>
            </router-link>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <h5>Student Transfers</h5>
          </div>
          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'list-student-transfer' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/view-result.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6> <strong>List All Transfers</strong> </h6>
              </div>
            </div>
            </router-link>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <h5>School ID Card</h5>
          </div>
          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'school-id-request' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/id-card-icon.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6> <strong>Create ID Card Request</strong> </h6>
              </div>
            </div>
            </router-link>
          </div>

          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'approve-school-id-request' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/sv.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6> <strong>Approved ID Card Request</strong> </h6>
              </div>
            </div>
            </router-link>
          </div>

          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'pending-school-id-request' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/delete.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6> <strong>Pending ID Card Request</strong> </h6>
              </div>
            </div>
            </router-link>
          </div>

        </div>

</div>
        
  
</div>
</template>

<script>
  import BarChart from '../Shared/BarChart.vue'
  import DoughnutChart from '../Shared/DoughnutChart.vue'
export default {
    components: { BarChart, DoughnutChart },
    data(){
			return {
            stats : null,
            url : '/',
            academic_session : null,
            myChartData: {
              labels: [],
              datasets: [
                {
                  label: 'Loading Data....',
                  backgroundColor: '#FF8C00',
                  data: []
                }
              ]
            },
            genderChart : {
              labels: ["Loading...."],
              datasets: [
                {
                  backgroundColor: ["#41B883"],
                  data: [],
                },
              ],
            },

            classChart : {
              labels: [],
              datasets: [
                {
                  backgroundColor: [],
                  data: [],
                },
              ],
            }
			}
		},
    mounted(){
      this.getStat();
    },

    methods: {
      getStat() {
  
            this.$loading(true);
       
            axios.get('/api/school/app/statistics')
              .then((res) => {
                    this.stats = res.data.data;
                    this.$loading(false);
                    
                    this.getChartData();
              })
              .catch((error) => {
                this.$loading(false)
                  if(error.response.status === 401){
                    let return_url = window.location.pathname;
                    this.$router.push({
                      name: 'school-login',
                      params: { return_url: return_url }
                      });
                  }
                  if (!error.response) {
                    this.$alert("You do not have internet access","Network Error","error");
                    return ;
                  }
                  if(error.response.status === 401){
                    this.error_message = error.response.data.message
                  }
            });
      },

      switchToOld(url) {
        if(url == null) return;

        let raw_password = localStorage.getItem('raw_password');
        let raw_username = localStorage.getItem('raw_username');

        if(raw_username == null || raw_username== '' || raw_password == null || raw_password == '') {
          this.$alert("Sorry, login credentails not found, you can logout and login again then retry.","No Credentails","error");
          return;
        }

        let method = 'post';
        
        let form = document.createElement('form');
        form.setAttribute('method', method);
        form.setAttribute('action', 'https://odsgmoest.org.ng/eportal/admin/new-site-login');
        form.setAttribute('target', "_blank");

        let usernameInput = document.createElement("input");
        usernameInput.value=raw_username;
        usernameInput.name="username"; 
        usernameInput.type="hidden";

        let passwordInput = document.createElement("input");
        passwordInput.value=raw_password;
        passwordInput.name="password";
        passwordInput.type="hidden";

        let linkInput = document.createElement("input");
        linkInput.value=url;
        linkInput.name="link";
        linkInput.type="hidden";

        let user = JSON.parse(localStorage.getItem('user'));
        let id = user.original.user.id

        let idInput = document.createElement("input");
        idInput.value=id;
        idInput.name="userId";
        idInput.type="hidden";

        form.appendChild(usernameInput);
        form.appendChild(passwordInput);
        form.appendChild(linkInput);
        form.appendChild(idInput);

        document.body.appendChild(form);
        form.submit();
      },

      getChartData() {

        axios.get('/api/school/app/chart/data')
          .then((res) => {
            this.$loading(false);
            this.academic_session = res.data.data.session + '/' + (parseInt(res.data.data.session) + 1);
  
            this.myChartData = {
                labels: res.data.data.labels,
                datasets: [
                  {
                    label: 'Male',
                    backgroundColor: '#009688',
                    data: res.data.data.males_count
                  },
                  {
                    label: 'Female',
                    backgroundColor: '#00ff00',
                    data: res.data.data.females_count
                  },
                  {
                    label: 'Unknown',
                    backgroundColor: '#373a3c',
                    data: res.data.data.unknown_count
                  }
                ]
            };

            this.genderChart = {
              labels: ["Male", "Female", "Unknown"],
              datasets: [
                {
                  backgroundColor: ["#41B883", "#E46651", "#00D8FF"],
                  data: res.data.data.gender_chart,
                },
              ],
            };

            this.classChart = {
              labels: res.data.data.labels,
              datasets: [
                {
                  backgroundColor: this.generateColor(9),
                  data: res.data.data.class_chart,
                },
              ],
            };
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

              if(error.response.status === 400) {
                this.error_message = error.response.data.message
              }
        });
      },

      generateColor(number_of_color) {
        let generatedColor = [];
        
        for(let i = 1; i <= number_of_color; i++) {
          let randomColor = Math.floor(Math.random()*16777215).toString(16);
          generatedColor.push("#" + randomColor);
        }

        return generatedColor
      }
    }
}
</script>