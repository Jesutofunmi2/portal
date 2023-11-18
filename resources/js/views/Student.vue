<template>
<div>
   

    <StudentSideBar />

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
import StudentSideBar from '../components/Shared/Student/SideBarComponent'

export default {
    name : 'Student',
    components : {
        StudentSideBar,
    },

    mounted(){

    }
}
</script>