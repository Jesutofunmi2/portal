<template>
 <div data-scroll-to-active="true" class="main-menu menu-fixed menu-dark menu-accordion menu-shadow">
      <!-- main menu header-->
      <div class="main-menu-header">
        <input type="text" placeholder="Search" class="menu-search form-control round" />
      </div>
             <div  class="main-menu-content">
                <ul id="main-menu-navigation" data-menu="menu-navigation" class="navigation navigation-main">
        
                   <li class="nav-item"><a href="javascript:void()"><i class="icon-home3"></i><span data-i18n="nav.dash.main" class="menu-title">
                     <router-link :to="{ name: 'student-dashboard' }">Dashboard</router-link></span></a>
                  </li>
                  <li class=" nav-item"><a href="javascript:void()"><i class="icon-user"></i><span data-i18n="nav.google_charts.main" class="menu-title">
                    <router-link :to="{ name: 'student-profile-edit' }">Edit Profile</router-link></span></a>
                  </li>
                  <li class=" nav-item"><a href="javascript:void()"><i class="icon-lock4"></i><span data-i18n="nav.google_charts.main" class="menu-title">
                   <router-link :to="{ name: 'student-password-edit' }">Change Password</router-link></span></a>
                  </li>
                  <li class=" nav-item"><a href="javascript:void()"><i class="icon-image4"></i><span data-i18n="nav.google_charts.main" class="menu-title">
                   <router-link :to="{ name: 'student-passport-edit' }">Upload Passport</router-link></span></a>
                  </li>
                  <li class=" nav-item"><a href="javascript:void()"><i class="icon-barcode"></i><span data-i18n="nav.google_charts.main" class="menu-title">
                    <router-link :to="{ name: 'student-receipt-print' }">Print Payment Receipt</router-link></span></a>
                  </li>
                  <li class=" nav-item"><a href="javascript:void()"><i class="icon-file-text"></i><span data-i18n="nav.google_charts.main" class="menu-title">
                    <router-link :to="{ name: 'student-transfer-form' }">Student Transfer Form</router-link></span></a>
                  </li>
                  <li class=" nav-item"><a href="javascript:void()"><i class="icon-profile"></i><span data-i18n="nav.google_charts.main" class="menu-title">
                    <router-link :to="{ name: 'student-view-result' }">View My Result</router-link></span></a>
                  </li>
                </ul>
             </div>
  </div>
</template>

<script>
export default {
    name : 'StudentSideBar',
}
</script>

<style scoped>

</style>