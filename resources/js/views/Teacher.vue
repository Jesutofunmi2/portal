<template>
<div>
   

    <TeacherSideBar />

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
import TeacherSideBar from '../components/Shared/Teacher/SideBarComponent'

export default {
    name : 'Teacher',
    components : {
        TeacherSideBar,
    },

    mounted(){

    }
}
</script>