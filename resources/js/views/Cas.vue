<template>
<div>
   

    <CasSideBar />

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
import CasSideBar from '../components/Shared/Cas/SideBarComponent'

export default {
    name : 'Ministry',
    components : {
        CasSideBar,
    },

    mounted(){

    }
}
</script>