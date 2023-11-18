<template>
<div>
   

    <SchoolSideBar />

     <div class="app-content content container-fluid">
      <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body"><!-- stats -->

            <router-view>
                
            </router-view>

        </div>
      </div>
    </div>
</div>


    
</template>

<script>
import SchoolSideBar from '../components/Shared/School/SideBarComponent'

export default {
    name : 'School',
    components : {
        SchoolSideBar,
    },

    mounted(){

    }
}
</script>