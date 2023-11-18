<template>
 <div data-scroll-to-active="true" class="main-menu menu-fixed menu-dark menu-accordion menu-shadow">
      <!-- main menu header-->
      <div class="main-menu-header">
        <input type="text" placeholder="Search" class="menu-search form-control round" />
      </div>
             <div  class="main-menu-content">
                <ul id="main-menu-navigation" data-menu="menu-navigation" class="navigation navigation-main">
        
                  <li class=" nav-item"><a href="javascript:void()"><i class="icon-home3"></i><span data-i18n="nav.dash.main" class="menu-title">
                    <router-link :to="{ name: 'school-dashboard' }">Dashboard</router-link></span></a>
                  </li>

                  <li class=" nav-item"><a href="javascript:void()"><i class="icon-android-contact"></i><span data-i18n="nav.google_charts.main" class="menu-title">Profile Configuration</span></a>
                    <ul class="menu-content">
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'edit-admin-profile' }">Edit My Profile</router-link></a>
                      </li>
                      
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'change-admin-password' }">Change My Password</router-link></a>
                      </li>
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'create-admin' }">Add User</router-link></a>
                      </li>
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'list-admin' }">List Users</router-link></a>
                      </li>               
                    </ul>
                  </li>

                  <li class=" nav-item"><a href="javascript:void()"><i class="icon-cogs"></i><span data-i18n="nav.google_charts.main" class="menu-title">School Configuration</span></a>
                    <ul class="menu-content">
                      
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'edit-admin-school-profile' }">Edit School Profile</router-link></a>
                      </li>
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'edit-school-logo' }">Edit School Logo</router-link></a>
                      </li>
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'edit-school-counsign' }">Edit Counsellor Signature</router-link></a>
                      </li> 
                       <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'school-survey' }">School Survey</router-link></a>
                      </li>                  
                    </ul>
                  </li>

                  <li class=" nav-item"><a href="javascript:void()"><i class="icon-home22"></i><span data-i18n="nav.google_charts.main" class="menu-title">House Configuration</span></a>
                    <ul class="menu-content">
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'create-school-house' }">Create House</router-link></a>
                      </li>
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'list-school-house' }">List Houses</router-link></a>
                      </li>                     
                    </ul>
                  </li>

                  <li class=" nav-item"><a href="javascript:void()"><i class="icon-man-woman"></i><span data-i18n="nav.google_charts.main" class="menu-title">Student Configuration</span></a>
                    <ul class="menu-content">
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'register-student' }">Register Student</router-link></a>
                      </li>
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'batch-register-student' }">Batch Registration</router-link></a>
                      </li>
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'batch-upload-student-passport' }">Passport Uploads</router-link></a>
                      </li>
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'list-student' }">List Students</router-link></a>
                      </li>
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'list-floating-student' }">List Floating Students</router-link></a>
                      </li>
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'list-student-subject' }">List Student Subjects</router-link></a>
                      </li> 
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'eligible-student' }">Eligible Students</router-link></a>
                      </li>
                      <!-- <li><a href="javascript:void()" @click="switchToOld('https://odsgmoest.org.ng/eportal/admin/student/batch-create-with-osno')" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        OSSI Batch Student Registration (Strictly for Existing Student with OSSI No)</a>
                      </li>
                      <li><a href="https://odsgmoest.org.ng/eportal/public/exceluploads/studentBatchRegistrationWithOsNo.xls" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        Download Batch Student Registration Format (Existing Student with OSSI No)</a>
                      </li>                     -->
                    </ul>
                  </li>

                  <li class=" nav-item"><a href="javascript:void()"><i class="icon-user-plus"></i><span data-i18n="nav.google_charts.main" class="menu-title">Teacher Configuration</span></a>
                    <ul class="menu-content">
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'register-teacher' }">Register Teacher</router-link></a>
                      </li>
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'batch-register-teacher' }">Batch Registration</router-link></a>
                      </li>
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'list-teacher' }">List Teachers</router-link></a>
                      </li>
               
                    </ul>
                  </li>

                  <li class=" nav-item"><a href="javascript:void()"><i class="icon-list-numbered"></i><span data-i18n="nav.google_charts.main" class="menu-title">Class Configuration</span></a>
                    <ul class="menu-content">
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'add-class' }">Add Class</router-link></a>
                      </li>
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'list-class' }">List Classes</router-link></a>
                      </li>
               
                    </ul>
                  </li>

                  <li class=" nav-item"><a href="javascript:void()"><i class="icon-tree"></i><span data-i18n="nav.google_charts.main" class="menu-title">Class Arm Configuration</span></a>
                    <ul class="menu-content">
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'add-classarm' }">Add Class Arm</router-link></a>
                      </li>
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'list-classarm' }">List Class Arms</router-link></a>
                      </li>
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'list-classarm-student' }">Assign Student to Class</router-link></a>
                      </li>
                       <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'remove-classarm-student' }">Remove Student from Class</router-link></a>
                      </li>
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'list-classarm-subject' }">Assign Class Subjects</router-link></a>
                      </li>
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'list-classarm-teacher' }">Assign Class Teachers</router-link></a>
                      </li>
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'list-classarm-counsellor' }">Assign Class Counsellors</router-link></a>
                      </li>
                       <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'assign-teacher-subject' }">Assign Teacher Subject</router-link></a>
                      </li>
               
                    </ul>
                  </li>

                  <li class=" nav-item"><a href="javascript:void()"><i class="icon-table"></i><span data-i18n="nav.google_charts.main" class="menu-title">Result Configuration</span></a>
                    <ul class="menu-content">
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'upload-school-subject-result' }">Upload Results By Subject</router-link></a>
                      </li> 
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'upload-school-result' }">Batch Upload All Result</router-link></a>
                      </li>
                      <!-- <li><a href="javascript:void()" @click="switchToOld('https://odsgmoest.org.ng/eportal/admin/result/upload-all-subject')" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        Batch Upload All Result (old)</a>
                      </li> -->
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'upload-result-comment' }">Upload Result Comments</router-link></a>
                      </li>
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'update-result-sign' }">Update Result Signatures</router-link></a>
                      </li>
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'result-promotion-stamp' }">Result Promotion Stamp</router-link></a>
                      </li>
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'result-lock-release' }">Lock/Release Results</router-link></a>
                      </li>
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'list-school-result' }">List Results</router-link></a>
                      </li> 
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'list-term-broadsheet' }">View Termly Broadsheets</router-link></a>
                      </li>   
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'list-session-broadsheet' }">View Session Broadsheets</router-link></a>
                      </li>
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'list-result-summary' }">Download Result Summary</router-link></a>
                      </li>
                    </ul>
                  </li>

                  <li class=" nav-item"><a href="javascript:void()"><i class="icon-minus2"></i><span data-i18n="nav.google_charts.main" class="menu-title">Debtor Configuration</span></a>
                    <ul class="menu-content">
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'add-debtor' }">Add Debtor</router-link></a>
                      </li>
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'list-debtor' }">List Debtors</router-link></a>
                      </li>                     
                    </ul>
                  </li>

                  <li class=" nav-item"><a href="javascript:void()"><i class="icon-library"></i><span data-i18n="nav.google_charts.main" class="menu-title">Library Configuration</span></a>
                    <ul class="menu-content">
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'add-library-category' }">Add Category</router-link></a>
                      </li>
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'list-library-category' }">List Categories</router-link></a>
                      </li>
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'add-library-book' }">Add Book</router-link></a>
                      </li>
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'list-library-book' }">List Books</router-link></a>
                      </li>
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'add-library-issue' }">Issue Book</router-link></a>
                      </li>
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'list-library-issue' }">List Book Issuances</router-link></a>
                      </li>                        
                    </ul>
                  </li>

                  <li class=" nav-item"><a href="javascript:void()"><i class="icon-paragraph-justify"></i><span data-i18n="nav.google_charts.main" class="menu-title">Wallet Configuration</span></a>
                    <ul class="menu-content">
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'class-wallet' }">Class Wallet</router-link></a>
                      </li> 
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'verify-payment' }">Verify Payment</router-link></a>
                      </li> 
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'payment-receipt' }">Payment Receipt</router-link></a>
                      </li>  
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'list-school-transaction' }">List Transactions</router-link></a>
                      </li>                     
                    </ul>
                  </li>

                  <li class=" nav-item"><a href="javascript:void()"><i class="icon-google-drive"></i><span data-i18n="nav.google_charts.main" class="menu-title">Teacher Transfers</span></a>
                    <ul class="menu-content">
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'new-teacher-transfer' }">New Teacher Transfer</router-link></a>
                      </li>
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'list-teacher-transfer-inward' }">List Inward Transfers</router-link></a>
                      </li>
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'list-teacher-transfer-outward' }">List Outward Transfers</router-link></a>
                      </li>                     
                    </ul>
                  </li>

                  <li class=" nav-item"><a href="javascript:void()"><i class="icon-rotate-right"></i><span data-i18n="nav.google_charts.main" class="menu-title">Student Transfers</span></a>
                    <ul class="menu-content">
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'list-student-transfer' }">List All Transfers</router-link></a>
                      </li>                     
                    </ul>
                  </li>

                  <li class=" nav-item"><a href="javascript:void()"><i class="icon-newspaper"></i><span data-i18n="nav.google_charts.main" class="menu-title">School ID Card</span></a>
                    <ul class="menu-content">
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'school-id-request' }">Create ID Card Request</router-link></a>
                      </li>  
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'approve-school-id-request' }">Approved ID Card Request</router-link></a>
                      </li> 
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'pending-school-id-request' }">Pending ID Card Request</router-link></a>
                      </li>                    
                    </ul>
                  </li>


                </ul>
             </div>
  </div>
</template>

<script>
export default {
  name : 'SchoolSideBar',
  methods: {
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
      }
  }
}

</script>

<style scoped>

</style>