<template>
<div>
   

    <ParentSideBar />

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
import ParentSideBar from '../components/Shared/Parent/SideBarComponent'

export default {
    name : 'Parent',
    components : {
        ParentSideBar,
    },

    mounted(){

    }
}
</script>