<template>
 <div data-scroll-to-active="true" class="main-menu menu-fixed menu-dark menu-accordion menu-shadow">
      <!-- main menu header-->
      <div class="main-menu-header">
        <input type="text" placeholder="Search" class="menu-search form-control round" />
      </div>
             <div  class="main-menu-content">
                <ul id="main-menu-navigation" data-menu="menu-navigation" class="navigation navigation-main">
        
                   <li class=" nav-item"><a href="javascript:void()"><i class="icon-home3"></i><span data-i18n="nav.dash.main" class="menu-title">
                     <router-link :to="{ name: 'aeo-zeo-dashboard' }">Dashboard</router-link></span></a>
                  </li>
                  <li class=" nav-item"><a href="javascript:void()"><i class="icon-user"></i><span data-i18n="nav.google_charts.main" class="menu-title">User Configuration</span></a>
                    <ul class="menu-content">
                       <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'ministry-change-password' }">Change Password</router-link></a>
                      </li>
                       <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'ministry-edit-profile' }">Edit Profile</router-link></a>
                      </li>
                    </ul>
                  </li>
                  
                  <li class=" nav-item"><a href="javascript:void()"><i class="icon-office"></i><span data-i18n="nav.google_charts.main" class="menu-title">School Configuration</span></a>
                    <ul class="menu-content">
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'aeo-zeo-create-secondary-school' }">Create Secondary School</router-link></a>
                      </li>
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'aeo-zeo-list-secondary-school' }">View Secondary School</router-link></a>
                      </li>
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'aeo-zeo-create-primary-school' }">Create Primary School</router-link></a>
                      </li>
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'aeo-zeo-list-primary-school' }">View Primary School</router-link></a>
                      </li>
                     
                    </ul>
                  </li>

                  <li class=" nav-item"><a href="javascript:void()"><i class="icon-office"></i><span data-i18n="nav.google_charts.main" class="menu-title">School Admin Configuration</span></a>
                    <ul class="menu-content">
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'aeo-zeo-create-school-admin' }">Create School Admin</router-link></a>
                      </li>
                       <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'aeo-zeo-list-school-admin' }">View School Admin</router-link></a>
                      </li>
               
                    </ul>
                  </li>
                  <li class=" nav-item"><a href="javascript:void()"><i class="icon-person-stalker"></i><span data-i18n="nav.google_charts.main" class="menu-title">Teachers Configuration</span></a>
                    <ul class="menu-content">
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'aeo-zeo-create-single-teacher' }">Register Single Teacher</router-link></a>
                      </li>
                       <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'aeo-zeo-view-school-teacher' }">View Registered Teachers</router-link></a>
                      </li>
                       <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'aeo-zeo-create-batch-teacher' }">Teacher Batch Registration</router-link></a>
                      </li>
                       <li><a href="/exceluploads/teacherBatchRegistration.xls" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                          Download Batch Registration Format
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class=" nav-item"><a href="javascript:void()"><i class="icon-person-stalker"></i><span data-i18n="nav.google_charts.main" class="menu-title">Student Configuration</span></a>
                    <ul class="menu-content">
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'aeo-zeo-create-single-student' }">Register Single Student</router-link></a>
                      </li>
                       <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'aeo-zeo-view-registered-student' }">View Registered Student</router-link></a>
                      </li>
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'aeo-zeo-view-unknown-student' }">View Unknown-Gender Student</router-link></a>
                      </li>
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'aeo-zeo-view-floating-student' }">View Floating Student</router-link></a>
                      </li>
                       <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'aeo-zeo-create-batch-student' }">Student Batch Registration</router-link></a>
                      </li>
                       <li><a href="/exceluploads/studentBatchRegistration.xls" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                          Download Batch Registration Format
                        </a>
                      </li>
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'aeozeo-eligible-student' }">Eligible Student</router-link></a>
                      </li>
                    </ul>
                  </li>
                   <li class=" nav-item"><a href="javascript:void()"><i class="icon-book3"></i><span data-i18n="nav.google_charts.main" class="menu-title">Subject Configuration</span></a>
                    <ul class="menu-content">
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'aeo-zeo-create-single-subject' }">Register Single Subject </router-link></a>
                      </li>
                       <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'aeo-zeo-view-registered-subject' }">View Registered Subject</router-link></a>
                      </li>
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'aeo-zeo-create-batch-subject' }">Register Batch  Subject</router-link></a>
                      </li>
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'aeo-zeo-create-subject-category' }">Subject Category</router-link></a>
                      </li>
                      
                       <li><a href="/exceluploads/subjectBatchRegistration.xls" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                          Download Batch Registration Format
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class=" nav-item"><a href="javascript:void()"><i class="icon-card"></i><span data-i18n="nav.google_charts.main" class="menu-title">Scratch Card Configuration</span></a>
                    <ul class="menu-content">
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'aeo-zeo-ministry-result-scratch-card-view' }">Result Scratch Card</router-link></a>
                      </li>
                       <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'aeo-zeo-ministry-exam-scratch-card-view' }">Exam Scratch Card</router-link></a>
                      </li>
                      
                    </ul>
                  </li>
            
                  <li class=" nav-item"><a href="javascript:void()"><i class="icon-dashboard2"></i><span data-i18n="nav.google_charts.main" class="menu-title">Ministry Department Config</span></a>
                    <ul class="menu-content">
                       <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'aeo-zeo-ministry-department' }">Ministry Department</router-link></a>
                      </li>
                      
                    </ul>
                  </li>
                  <li class=" nav-item"><a href="javascript:void()"><i class="icon-steam2"></i><span data-i18n="nav.google_charts.main" class="menu-title">Task Configuration</span></a>
                    <ul class="menu-content">
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'aeo-zeo-ministry-create-task' }">Create Task</router-link></a>
                      </li>
                       <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'aeo-zeo-ministry-view-task' }">View Task</router-link></a>
                      </li>
                      
                    </ul>
                  </li>
                  <li class=" nav-item"><a href="javascript:void()"><i class="icon-stats-bars"></i><span data-i18n="nav.google_charts.main" class="menu-title">Statistics</span></a>
                    <ul class="menu-content">
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'aeo-zeo-ministry-school-statistics' }">School Statistics</router-link></a>
                      </li>
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'aeo-zeo-ministry-lga-school-statistics' }">LGA School Statistics</router-link></a>
                      </li>
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'aeo-zeo-ministry-lga-broad-school-statistics' }">Broad School Statistics</router-link></a>
                      </li>
                       <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'aeo-zeo-ministry-lga-result-statistics' }">Result Statistics</router-link></a>
                      </li>
                       <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'aeo-zeo-ministry-lga-subject-statistics' }">Subject Statistics</router-link></a>
                      </li>
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'aeo-zeo-ministry-lga-broad-subject-statistics' }">Broad Subject Statistics</router-link></a>
                      </li>
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'aeo-zeo-ministry-lga-subject-teachers-statistics' }">Subject Teachers Statistics</router-link></a>
                      </li>
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'aeo-zeo-ministry-lga-student-statistics' }">Student Statistics</router-link></a>
                      </li>
                      
                    </ul>
                  </li>
                  <li class=" nav-item"><a href="javascript:void()"><i class="icon-card"></i><span data-i18n="nav.google_charts.main" class="menu-title">School ID-Card</span></a>
                    <ul class="menu-content">
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'aeo-zeo-ministry-school-id-request' }">School ID Card Request</router-link></a>
                      </li>
                    </ul>
                  </li>
                  <li class=" nav-item"><a href="javascript:void()"><i class="icon-cash"></i><span data-i18n="nav.google_charts.main" class="menu-title">Payment History</span></a>
                    <ul class="menu-content">
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'aeo-zeo-ministry-school-payment-history' }">General Report</router-link></a>
                      </li>
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'aeo-zeo-ministry-payment-history-icpr' }">ID Card Request Report</router-link></a>
                      </li>
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'aeo-zeo-ministry-payment-history-srr' }">Schools Remittance Report</router-link></a>
                      </li>
                    </ul>
                  </li>
                </ul>
             </div>
  </div>
</template>

<script>
export default {
    name : 'AeozeoSideBar',
}
</script>

<style scoped>

</style>