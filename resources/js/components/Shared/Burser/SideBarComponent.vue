<template>
 <div data-scroll-to-active="true" class="main-menu menu-fixed menu-dark menu-accordion menu-shadow">
      <!-- main menu header-->
      <div class="main-menu-header">
        <input type="text" placeholder="Search" class="menu-search form-control round" />
      </div>
             <div  class="main-menu-content">
                <ul id="main-menu-navigation" data-menu="menu-navigation" class="navigation navigation-main">
        
                   <li class=" nav-item"><a href="javascript:void()"><i class="icon-home3"></i><span data-i18n="nav.dash.main" class="menu-title">
                     <router-link :to="{ name: 'burser-dashboard' }">Dashboard</router-link></span></a>
                  </li>
                 <li class=" nav-item"><a href="javascript:void()"><i class="icon-office"></i><span data-i18n="nav.google_charts.main" class="menu-title">Example</span></a>
                    <ul class="menu-content">
                    
                      <li><a href="javascript:void()" data-i18n="nav.google_charts.google_bar_charts" class="menu-item">
                         <router-link :to="{ name: 'burser-example-page' }">Show Example Page</router-link></a>
                      </li>
                    
                    </ul>
                  </li>
                </ul>
             </div>
  </div>
</template>

<script>
export default {
    name : 'BurserSideBar',
}
</script>

<style scoped>

</style>