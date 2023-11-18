<template>
<div>
   

    <LiberianSideBar />

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
import LiberianSideBar from '../components/Shared/Liberian/SideBarComponent'

export default {
    name : 'Liberian',
    components : {
        LiberianSideBar,
    },

    mounted(){

    }
}
</script>