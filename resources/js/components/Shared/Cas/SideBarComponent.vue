<template>
 <div data-scroll-to-active="true" class="main-menu menu-fixed menu-dark menu-accordion menu-shadow">
      <!-- main menu header-->
      <div class="main-menu-header">
        <input type="text" placeholder="Search" class="menu-search form-control round" />
      </div>
             <div  class="main-menu-content">
                <ul id="main-menu-navigation" data-menu="menu-navigation" class="navigation navigation-main">
        
                   <li class=" nav-item"><a href="javascript:void()"><i class="icon-home3"></i><span data-i18n="nav.dash.main" class="menu-title">
                     <router-link :to="{ name: 'cas-dashboard' }">Dashboard</router-link></span></a>
                  </li>
                  
                  <li class=" nav-item"><a href="javascript:void()"><i class="icon-user"></i><span data-i18n="nav.google_charts.main" class="menu-title">User Configuration</span></a>
                    <ul class="menu-content">
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'cas-create-cas-admin-account' }">Create CAS Account</router-link></a>
                      </li>
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'cas-list-cas-admin' }">View CAS Admin</router-link></a>
                      </li>
                       <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'cas-change-password' }">Change Password</router-link></a>
                      </li>
                    </ul>
                  </li>
                  
                  <li class=" nav-item"><a href="javascript:void()"><i class="icon-office"></i><span data-i18n="nav.google_charts.main" class="menu-title">School Configuration</span></a>
                    <ul class="menu-content">
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'cas-create-secondary-school' }">Create Secondary School</router-link></a>
                      </li>
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'cas-list-secondary-school' }">View Secondary School</router-link></a>
                      </li>
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'cas-create-primary-school' }">Create Primary School</router-link></a>
                      </li>
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'cas-list-primary-school' }">View Primary School</router-link></a>
                      </li>
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'cas-list-school-survey' }">School Surveys</router-link></a>
                      </li>
                    </ul>
                  </li>

                  <li class=" nav-item"><a href="javascript:void()"><i class="icon-office"></i><span data-i18n="nav.google_charts.main" class="menu-title">School Admin Configuration</span></a>
                    <ul class="menu-content">
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'cas-create-school-admin' }">Create School Admin</router-link></a>
                      </li>
                       <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'cas-list-school-admin' }">View School Admin</router-link></a>
                      </li>
                       <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'cas-print-school-admin' }">Print School Admin</router-link></a>
                      </li>
               
                    </ul>
                  </li>
                  <li class=" nav-item"><a href="javascript:void()"><i class="icon-person-stalker"></i><span data-i18n="nav.google_charts.main" class="menu-title">Teachers Configuration</span></a>
                    <ul class="menu-content">
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'cas-create-single-teacher' }">Register Single Teacher</router-link></a>
                      </li>
                       <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'cas-view-school-teacher' }">View Registered Teachers</router-link></a>
                      </li>
                       <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'cas-create-batch-teacher' }">Teacher Batch Registration</router-link></a>
                      </li>
                       <li><a href="/exceluploads/teacherBatchRegistration.xls" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                          Download Batch Registration Format
                        </a>
                      </li>
                    </ul>
                  </li>

                  
                  <li class=" nav-item"><a href="javascript:void()"><i class="icon-google-drive"></i><span data-i18n="nav.google_charts.main" class="menu-title">Teacher Transfers</span></a>
                    <ul class="menu-content">
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'cas-new-teacher-transfer' }">New Teacher Transfer</router-link></a>
                      </li>
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'cas-list-teacher-transfer' }">List Transfers</router-link></a>
                      </li>             
                    </ul>
                  </li>

                  <li class=" nav-item"><a href="javascript:void()"><i class="icon-person-stalker"></i><span data-i18n="nav.google_charts.main" class="menu-title">Student Configuration</span></a>
                    <ul class="menu-content">
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'cas-create-single-student' }">Register Single Student</router-link></a>
                      </li>
                       <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'cas-view-registered-student' }">View Registered Student</router-link></a>
                      </li>
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'cas-view-unknown-student' }">View Unknown-Gender Student</router-link></a>
                      </li>
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'cas-view-floating-student' }">View Floating Student</router-link></a>
                      </li>
                       <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'cas-create-batch-student' }">Student Batch Registration</router-link></a>
                      </li>
                       <li><a href="/exceluploads/studentBatchRegistration.xls" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                          Download Batch Registration Format
                        </a>
                      </li>
                     <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'cas-eligible-student' }">Eligible Students</router-link></a>
                      </li>
                    </ul>
                  </li>
                   <li class=" nav-item"><a href="javascript:void()"><i class="icon-book3"></i><span data-i18n="nav.google_charts.main" class="menu-title">Subject Configuration</span></a>
                    <ul class="menu-content">
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'cas-create-single-subject' }">Register Single Subject </router-link></a>
                      </li>
                       <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'cas-view-registered-subject' }">View Registered Subject</router-link></a>
                      </li>
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'cas-create-batch-subject' }">Register Batch  Subject</router-link></a>
                      </li>
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'cas-create-subject-category' }">Subject Category</router-link></a>
                      </li>
                      
                       <li><a href="/exceluploads/subjectBatchRegistration.xls" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                          Download Batch Registration Format
                        </a>
                      </li>
                    </ul>
                  </li>
                   <li class=" nav-item"><a href="javascript:void()"><i class="icon-steam2"></i><span data-i18n="nav.google_charts.main" class="menu-title">Student Results</span></a>
                    <ul class="menu-content">
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'cas-result-summary' }">Result Summary</router-link></a>
                      </li>
                    </ul>
                  </li>
                  <li class=" nav-item"><a href="javascript:void()"><i class="icon-stats-bars"></i><span data-i18n="nav.google_charts.main" class="menu-title">Statistics</span></a>
                    <ul class="menu-content">
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'cas-school-statistics' }">School Statistics</router-link></a>
                      </li>
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'cas-lga-school-statistics' }">LGA School Statistics</router-link></a>
                      </li>
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'cas-lga-broad-school-statistics' }">Broad School Statistics</router-link></a>
                      </li>
                       <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'cas-lga-result-statistics' }">Result Statistics</router-link></a>
                      </li>
                       <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'cas-lga-subject-statistics' }">Subject Statistics</router-link></a>
                      </li>
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'cas-lga-broad-subject-statistics' }">Broad Subject Statistics</router-link></a>
                      </li>
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'cas-lga-subject-teachers-statistics' }">Subject Teachers Statistics</router-link></a>
                      </li>
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'cas-lga-student-statistics' }">Student Statistics</router-link></a>
                      </li>
                      
                    </ul>
                  </li>
                  <li class=" nav-item"><a href="javascript:void()"><i class="icon-card"></i><span data-i18n="nav.google_charts.main" class="menu-title">School ID-Card</span></a>
                    <ul class="menu-content">
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'cas-school-id-request' }">School ID Card Request</router-link></a>
                      </li>
                    </ul>
                  </li>
                </ul>
             </div>
  </div>
</template>

<script>
export default {
    name : 'CasSideBar',
}
</script>

<style scoped>

</style>