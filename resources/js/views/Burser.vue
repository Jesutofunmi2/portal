<template>
<div>
   

    <BurserSideBar />

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
import BurserSideBar from '../components/Shared/Burser/SideBarComponent'

export default {
    name : 'Burser',
    components : {
        BurserSideBar,
    },

    mounted(){

    }
}
</script>