<template>
<div>
   

    <AeozeoSideBar />

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
import AeozeoSideBar from '../components/Shared/Aeozeo/SideBarComponent'

export default {
    name : 'Aeozeo',
    components : {
        AeozeoSideBar,
    },

    mounted(){

    }
}
</script>