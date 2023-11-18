<template>
 <div data-scroll-to-active="true" class="main-menu menu-fixed menu-dark menu-accordion menu-shadow">
      <!-- main menu header-->
      <div class="main-menu-header">
        <input type="text" placeholder="Search" class="menu-search form-control round" />
      </div>
             <div  class="main-menu-content">
                <ul id="main-menu-navigation" data-menu="menu-navigation" class="navigation navigation-main">
        
                   <li class=" nav-item"><a href="javascript:void()"><i class="icon-home3"></i><span data-i18n="nav.dash.main" class="menu-title">
                     <router-link :to="{ name: 'teacher-dashboard' }">Dashboard</router-link></span></a>
                  </li>

                  <li class=" nav-item"><a href="javascript:void()"><i class="icon-office"></i><span data-i18n="nav.google_charts.main" class="menu-title">Profile Configuration</span></a>
                    <ul class="menu-content">
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'edit-teacher-profile' }">Edit My Profile</router-link></a>
                      </li>
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'change-teacher-password' }">Change My Password</router-link></a>
                      </li>     
                       <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'change-teacher-signature' }">Change Signature</router-link></a>
                      </li>   
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                        <router-link :to="{ name: 'edit-teacher-overview' }">Your Overview</router-link></a>
                      </li>                  
                    </ul>
                  </li>

                  <li class=" nav-item"><a href="javascript:void()"><i class="icon-office"></i><span data-i18n="nav.google_charts.main" class="menu-title">Subject Configuration</span></a>
                    <ul class="menu-content">

                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'update-teacher-subject' }">Update Subjects</router-link></a>
                      </li>
                    
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'list-teacher-subject' }">List Subjects</router-link></a>
                      </li>
                    
                    </ul>
                  </li>
                   <li class="nav-item"><a href="javascript:void()"><i class="icon-clipboard"></i><span data-i18n="nav.google_charts.main" class="menu-title">Result</span></a>
                    <ul class="menu-content">

                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'teacher-upload-subject-result'}">Upload Subjects Result</router-link></a>
                      </li>
                    
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'teacher-upload-class-result' }">Upload Class Result</router-link></a>
                      </li>

                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'teacher-upload-class-comment' }">Upload Class Comment</router-link></a>
                      </li>

                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'teacher-list-class-result' }">View Class Result</router-link></a>
                      </li>
                    </ul>
                  </li>
                  
                </ul>
             </div>
  </div>
</template>

<script>
export default {
    name : 'TeacherSideBar',
}
</script>

<style scoped>

</style>