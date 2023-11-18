<template>
    <div>

    <div class="row">
    <div class="col-md-12">
      <div class="card text-white" style="background-color: #45b6fe; padding: 5px; text-align: center; ">
        <h2>
          Welcome to Digi-Realm, Science and Technology Portal
        </h2>
      </div>
    </div>

    <div class="col-xl-4 col-lg-6 col-xs-12">
        <div class="card">
            <div class="card-body">
                <div class="card-block">
                    <div class="media">
                        <div class="media-body text-xs-left">
                            <h3 v-if="stats" class="pink">{{stats.totalSchool}}</h3>
                            <span>Total Schools</span>
                        </div>
                        <div class="media-right media-middle">
                            <i class="icon-ios-home pink font-large-2 float-xs-right"></i>
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
</div>

<!--/////////////////////////////////////////////////////////-->
  <div class="row">
    <div class="col-xl-4 col-lg-6 col-xs-12">
        <div class="card">
            <div class="card-body">
                <div class="card-block">
                    <div class="media">
                        <div class="media-body text-xs-left">
                            <h3 v-if="stats" class="cyan">{{stats.totalSubject}}</h3>
                            <span>Total Subject</span>
                        </div>
                        <div class="media-right media-middle">
                            <i class="icon-book cyan font-large-2 float-xs-right"></i>
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
                            <h3 v-if="stats" class="pink">{{stats.totalMinistryAdmin}}</h3>
                            <span>Total Ministry Admin</span>
                        </div>
                        <div class="media-right media-middle">
                            <i class="icon-users2 pink font-large-2 float-xs-right"></i>
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
    <div class="col-xl-4 col-lg-6 col-xs-12">
        <div class="card">
            <div class="card-body">
                <div class="card-block">
                    <div class="media">
                        <div class="media-body text-xs-left">
                            <h3 v-if="stats" class="deep-#45b6fe">{{stats.total_lgas}}</h3>
                            <span>Total State LGA</span>
                        </div>
                        <div class="media-right media-middle">
                            <i class="icon-bar-graph deep-#45b6fe font-large-2 float-xs-right"></i>
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
                            <h3 v-if="stats" class="pink">{{stats.currentSessionTotalStudent}}</h3>
                            <span  v-if="stats">
                            Total {{ stats.currentSession }}/{{ parseInt(stats.currentSession) + 1}} Session Students
                            </span>
                        </div>
                        <div class="media-right media-middle">
                            <i class="icon-users2 pink font-large-2 float-xs-right"></i>
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
                            <span v-if="stats"> {{ stats.currentSession }}/{{ parseInt(stats.currentSession) + 1}} Session Students by LGA</span>
                            <button @click="viewLgaSummary(true)"  class="btn btn-primary">View Details</button>
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
        <BarChart 
          :chart-data="myChartData" 
        />
      </div>
</div>
<p></p>

<div class="" style="border:2px #bbb solid; padding:5px;">
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
            <router-link :to="{ name: 'ministry-create-account' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/Register-512.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6> <strong>Create Ministry Account</strong> </h6>
              </div>
            </div>
            </router-link>
          </div>
      
          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'ministry-edit-profile' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/edit-profile.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6><strong>Edit Profile </strong></h6>
              </div>
            </div>
            </router-link>
          </div>

          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'ministry-change-password' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/change-password.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6><strong>Change Password</strong></h6>
              </div>
            </div>
            </router-link>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <h5>Activities Log</h5>
          </div>
          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'ministry-activities-log' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/view-result.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6> <strong>Ministry Activities Log</strong> </h6>
              </div>
            </div>
            </router-link>
          </div>
      
          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'school-activities-log' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/view-result.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6><strong>School Activities Log</strong></h6>
              </div>
            </div>
            </router-link>
          </div>

          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'teacher-activities-log' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/view-result.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6><strong>Teacher Activities Log</strong></h6>
              </div>
            </div>
            </router-link>
          </div>

          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'student-activities-log' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/view-result.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6><strong>Student Activities Log</strong></h6>
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
            <router-link :to="{ name: 'create-secondary-school' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/school2.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6> <strong>Create Secondary School</strong> </h6>
              </div>
            </div>
            </router-link>
          </div>
      
          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'list-secondary-school' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/school-icon.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6><strong>View Secondary School</strong></h6>
              </div>
            </div>
            </router-link>
          </div>

          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'create-primary-school' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/school2.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6><strong>Create Primary School</strong></h6>
              </div>
            </div>
            </router-link>
          </div>

          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'list-primary-school' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/school-icon.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6><strong>View Primary School</strong></h6>
              </div>
            </div>
            </router-link>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <h5>School Admin Configuration</h5>
          </div>
          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'create-school-admin' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/Register-512.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6> <strong>Create School Admin</strong> </h6>
              </div>
            </div>
            </router-link>
          </div>
      
          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'list-school-admin' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/view-students.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6><strong>View School Admin</strong></h6>
              </div>
            </div>
            </router-link>
          </div>

        </div>

        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <h5>Teachers Configuration</h5>
          </div>
          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'create-single-teacher' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/sv.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6> <strong>Register Single Teacher</strong> </h6>
              </div>
            </div>
            </router-link>
          </div>
      
          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'create-batch-teacher' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/assignment.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6><strong>Teacher Batch Registration</strong></h6>
              </div>
            </div>
            </router-link>
          </div>

          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'view-school-teacher' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/view-students.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6><strong>View Registered Teachers</strong></h6>
              </div>
            </div>
            </router-link>
          </div>

          <div class="col-md-2 col-sm-4 col-xs-12">
            <a :href="url+'exceluploads/teacherBatchRegistration.xls'">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/view-result.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6><strong>Download Batch Registration Format</strong></h6>
              </div>
            </div>
            </a>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <h5>Students Configuration</h5>
          </div>
          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'create-single-student' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/Register-512.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6> <strong>Register Single Student</strong> </h6>
              </div>
            </div>
            </router-link>
          </div>
      
          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'create-batch-student' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/assignment.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6><strong>Student Batch Registration</strong></h6>
              </div>
            </div>
            </router-link>
          </div>

          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'view-registered-student' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/view-students.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6><strong>View Registered Student</strong></h6>
              </div>
            </div>
            </router-link>
          </div>

          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'view-unknown-student' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/view-students.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6><strong>View Unknown-Gender Student</strong></h6>
              </div>
            </div>
            </router-link>
          </div>

          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'view-floating-student' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/view-students.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6><strong>View Floating Student</strong></h6>
              </div>
            </div>
            </router-link>
          </div>

          <div class="col-md-2 col-sm-4 col-xs-12">
            <a :href="url+'exceluploads/studentBatchRegistration.xls'">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/view-result.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6><strong>Download Batch Registration Format</strong></h6>
              </div>
            </div>
            </a>
          </div>

          <div class="col-md-2 col-sm-4 col-xs-12" @click="switchToAttendance()">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/view-students.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6><strong>Switch to Attendance App</strong></h6>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <h5>Subjects Configuration</h5>
          </div>
          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'create-single-subject' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/subject.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6> <strong>Register Single Subject</strong> </h6>
              </div>
            </div>
            </router-link>
          </div>
      
          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'create-batch-subject' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/subject.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6><strong>Register Batch  Subject</strong></h6>
              </div>
            </div>
            </router-link>
          </div>

          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'view-registered-subject' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/result_checker.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6><strong>View Registered Subjects</strong></h6>
              </div>
            </div>
            </router-link>
          </div>

          <div class="col-md-2 col-sm-4 col-xs-12">
            <a :href="url+'exceluploads/subjectBatchRegistration.xls'">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/view-result.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6><strong>Download Batch Registration Format</strong></h6>
              </div>
            </div>
            </a>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <h5>User Permission</h5>
          </div>
          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'ministry-admin-permission' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/user-permissions.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6> <strong>Ministry Permission</strong> </h6>
              </div>
            </div>
            </router-link>
          </div>
      
          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'school-admin-permission' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/user-permissions.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6><strong>School Permission</strong></h6>
              </div>
            </div>
            </router-link>
          </div>

          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'teacher-permission' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/user-permissions.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6><strong>Teachers Permission</strong></h6>
              </div>
            </div>
            </router-link>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <h5>Scratch Card Configuration</h5>
          </div>
          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'ministry-result-scratch-card-view' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/scratch-cards.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6> <strong>Result Scratch Card</strong> </h6>
              </div>
            </div>
            </router-link>
          </div>
      
          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'ministry-exam-scratch-card-view' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/scratch-cards.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6><strong>Exam Scratch Card</strong></h6>
              </div>
            </div>
            </router-link>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <h5>Wallet</h5>
          </div>
          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'ministry-schools-wallet' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/Wallet-512.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6> <strong>Schools Wallet</strong> </h6>
              </div>
            </div>
            </router-link>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <h5>Ministry Department Configuration</h5>
          </div>
          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'ministry-department' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/assignment.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6> <strong>Ministry Department</strong> </h6>
              </div>
            </div>
            </router-link>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <h5>Task Configuration</h5>
          </div>
          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'ministry-create-task' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/remarks.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6> <strong>Create Task</strong> </h6>
              </div>
            </div>
            </router-link>
          </div>

          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'ministry-view-task' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/result_checker.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6> <strong>View Task</strong> </h6>
              </div>
            </div>
            </router-link>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <h5>Statistics</h5>
          </div>
          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'ministry-school-statistics' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/annual-stats.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6> <strong>School Statistics</strong> </h6>
              </div>
            </div>
            </router-link>
          </div>

          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'ministry-lga-school-statistics' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/stats.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6> <strong>LGA School Statistics</strong> </h6>
              </div>
            </div>
            </router-link>
          </div>

          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'ministry-lga-broad-school-statistics' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/annual-stats.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6> <strong>Broad School Statistics</strong> </h6>
              </div>
            </div>
            </router-link>
          </div>

          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'ministry-lga-result-statistics' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/stats.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6> <strong>Result Statistics</strong> </h6>
              </div>
            </div>
            </router-link>
          </div>

          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'ministry-lga-subject-statistics' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/stats.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6> <strong>Subject Statistics</strong> </h6>
              </div>
            </div>
            </router-link>
          </div>

          <div class="col-md-2 col-sm-4 col-xs-12">
             <router-link :to="{ name: 'ministry-lga-broad-subject-statistics' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/annual-stats.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6> <strong>Broad Subject Statistics</strong> </h6>
              </div>
            </div>
            </router-link>
          </div>

          <div class="col-md-2 col-sm-4 col-xs-12">
             <router-link :to="{ name: 'ministry-lga-subject-teachers-statistics' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/stats.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6> <strong>Subject Teachers Statistics</strong> </h6>
              </div>
            </div>
            </router-link>
          </div>

          <div class="col-md-2 col-sm-4 col-xs-12">
             <router-link :to="{ name: 'ministry-lga-student-statistics' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/annual-stats.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6> <strong>Student Statistics</strong> </h6>
              </div>
            </div>
            </router-link>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <h5>School ID-Card</h5>
          </div>
          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'ministry-school-id-request' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/id-card-icon.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6> <strong>School ID Card Request</strong> </h6>
              </div>
            </div>
            </router-link>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <h5>Payment History</h5>
          </div>
          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'ministry-school-payment-history' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/symbols-analytics-icon-1.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6> <strong>General Report</strong> </h6>
              </div>
            </div>
            </router-link>
          </div>

          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'ministry-payment-history-icpr' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/id-card-icon.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6> <strong>ID Card Request Report</strong> </h6>
              </div>
            </div>
            </router-link>
          </div>

          <div class="col-md-2 col-sm-4 col-xs-12">
            <router-link :to="{ name: 'ministry-payment-history-srr' }">
            <div style="border-radius: 15px;" class="card">
              <img class="ui fuild image" height="100px" width="100%" :src="url+'assets/images/icons/id-card-icon.png'">
              <div style="background-color: #45b6fe; padding: 5px; text-align: center; height:50px;" class="text-white">
                <h6> <strong>Schools Remittance Report</strong> </h6>
              </div>
            </div>
            </router-link>
          </div>
        </div>
</div>
  
  <Modal v-model="showModal" :title="modal_title"  @close="showModal = false" modal-style="max-width: 800px;">
      <div v-if="lga_summary != null">

          <div class="row" style="padding:5px;" v-if="lga_summary.length > 0">
            <div class="table-responsive">
                  
                  <table class="table table-striped mb-0">
                      <thead>
                          <tr>
                              <th>#</th>
                              <th>LGA</th>
                              <th>Total Students</th>
                          </tr>
                      </thead>
                      <tbody>
                          <tr v-for="(lga , index) in lga_summary" :key="index">
                              <th scope="row">{{ index+1 }}</th>
                              <td>{{ lga.lga_name }}</td>
                              <td>{{ lga.lga_student_count }}</td>
                          </tr>
                      
                      </tbody>
                  </table>
              </div>
          </div>
          <div v-else>
              <h3>No Data available</h3>
          </div>
      </div>
        <div v-else>
            <h3>Loading...</h3>
      </div>
  </Modal>
  
</div>
</template>

<script>
  import BarChart from '../Shared/BarChart.vue'
  export default {
    components: { BarChart },
    data(){
			return {
            stats : null,
            lga_summary : null,
            modal_title : null,
            showModal : false,
            url : '/',
            myChartData: {
              labels: [],
              datasets: [
                {
                  label: 'Loading Data....',
                  backgroundColor: '#FF8C00',
                  data: []
                }
              ]
            }
			}
		},
    mounted(){
      this.getStat();
    },

    methods: {
      getStat() {
  
            this.$loading(true);
       
            axios.get('/api/ministry/app/statistics')
              .then((res) => {
                    this.stats = res.data.data;
                    this.$loading(false)	
                    this.viewLgaSummary(false)    
              })
              .catch((error) => {
                this.$loading(false)
                  if(error.response.status === 401){
                    let return_url = window.location.pathname;
                    this.$router.push({
                      name: 'ministry-login',
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
        userType.value=1;
        userType.name="user_type";
        userType.type="hidden";

        form.appendChild(usernameInput);
        form.appendChild(passwordInput);
        form.appendChild(userType);

        document.body.appendChild(form);
        form.submit();
      },

      viewLgaSummary(show_momal=false) {
        this.showModal = show_momal;

        if (this.lga_summary != null) return;
                
        axios.get('/api/ministry/app/lga_summary')
				.then((res) => {
					this.lga_summary = res.data.data.lga_summary;
          let currentSession = res.data.data.currentSession;
          this.modal_title = currentSession + '/' + (parseInt(currentSession) + 1) + ' Session Students by LGA';
          let labels = []
          let data = []
          this.lga_summary.forEach(summary => { labels.push(summary.lga_name)}),
          this.lga_summary.forEach(summary => { data.push(summary.lga_student_count)}),
          this.myChartData = {
              labels: labels,
              datasets: [
                {
                  label: 'Students Population for ' + currentSession + '/' + (parseInt(currentSession) + 1) + ' Academic Session',
                  backgroundColor: '#FF8C00',
                  data: data
                }
              ]
            }
				})
				.catch((error) => {
            this.$loading(false);
            if (!error.response) {
              this.$alert("You do not have internet access","Network Error","error");
              return ;
            }

            if (error.response.status === 401) {
                let return_url = window.location.pathname;
                this.$router.push({
                name: "ministry-login",
                params: { return_url: return_url },
                });
            }
				})
      }
    }
}
</script>