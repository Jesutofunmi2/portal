<template>
   <div class="row match-height">
		<!-- Striped rows start -->
<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Edit Permission</h4>
                <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="collapse"><i class="icon-minus4"></i></a></li>
                        <li><a data-action="reload"><i class="icon-reload"></i></a></li>
                        <li><a data-action="expand"><i class="icon-expand2"></i></a></li>
                        <li><a data-action="close"><i class="icon-cross2"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="card-body collapse in">
                <div style="width:100%; text-align:center;" v-if="admin" class="card-block card-dashboard row">
                    <h3> {{admin.fullname}}'s Permission </h3>
                </div>
                <div class="table-responsive">
                     
                    <div class="col-md-12">
                        <div style="text-align: right;" class="col-md-6">
                              <h4> Toggle All Checkbox</h4>
                        </div>
                        <div class="col-md-6">
                            <label class="toggle-control">
                            
                                <input @click="toggleAll" type="checkbox" :checked ="all == true ? false : true">
                                <span class="control"></span>
                            </label>
                        </div>
                      
                    </div>
                    <div v-if="permissions" class="row">
                         <div v-for="permission in permissions" :key="permission.id" class="col-md-6" style="border:1px solid #ccc; padding:3px;">
                            <div style="text-align: right;" class="col-md-9">
                                <h4> {{ permission.permission }} </h4>
                            </div>
                            <div class="col-md-3">
                                <label class="toggle-control">
                                
                                    <input @click="toggle(permission.id)" type="checkbox" :checked ="permission.status == 'checked' ? true : false" >
                                    <span class="control"></span>
                                </label>
                            </div>
                      
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Striped rows end -->
		<FlashMessage></FlashMessage>

	</div>
	
</template>

<script>

    export default {

		data(){
			return {
                userId : this.$route.params.userId,
			    admin : null,
                permissions : null,
                all : true,
			}
		},
        mounted() {
          this.getPermissions();
        },

		methods : {
            getPermissions(){
				this.$loading(true);
				axios.get('/api/ministry/permission/schoolAdmin/getPermission?id='+this.userId)
				.then((res) => {
					this.admin = res.data.data.admin;
                    this.permissions = res.data.data.permissions;
					this.$loading(false)
				})
				.catch((error) => {
                    this.$loading(false);
					if (!error.response) {
						this.$alert("You do not have internet access","Network Error","error");
						return ;
					}

                    if(error.response.status === 403){
						this.$alert("Sorry, you do not have the permission to perfrom this action","No Permission","error");
					}
                    if(error.response.status === 401){
						let return_url = window.location.pathname;
						this.$router.push({
							name: "aeo_zeo-login",
							params: { return_url: return_url }
							});
					}
				})
			},

           toggleAll(){
              let state = null;
               if(this.all == true) {
                    this.all = false;
                    this.permissions.forEach(permission => {
                       permission.status = 'checked';
                    });
                    state = 'ADD';
               }
               else if(this.all == false) {
                   this.all = true;
                   this.permissions.forEach(permission => {
                       permission.status = 'unchecked';
                    });
                    state = 'REMOVE';
               }
               this.$loading(true);
               let data = new FormData;
               data.append('id',this.userId);
               data.append('state', state);

               axios.post('/api/ministry/permission/schoolAdmin/permission/all', data)
				.then((res) => {
                   this.$alert(res.data.data.message,"Permission","success");
					this.$loading(false)
				})
				.catch((error) => {
                    this.$loading(false);
                    if(this.all == false) {
                    this.all = true;
                    this.permissions.forEach(permission => {
                       permission.status = 'unchecked';
                    });
                    }
                    else if(this.all == true) {
                        this.all = false;
                        this.permissions.forEach(permission => {
                            permission.status = 'checked';
                            });
                    }
					if (!error.response) {
						this.$alert("You do not have internet access","Network Error","error");
						return ;
					}

                    if(error.response.status === 403){
						this.$alert("Sorry, you do not have the permission to perfrom this action","No Permission","error");
					}
                    if(error.response.status === 401){
						let return_url = window.location.pathname;
						this.$router.push({
							name: "aeo_zeo-login",
							params: { return_url: return_url }
							});
					}
				})
           },
           toggle(id){
                let state = null;
                this.permissions.forEach(permission => {
                   if(permission.id == id){
                       if(permission.status == 'checked') {
                           permission.status = 'unchecked';
                           state = 'REMOVE';
                       }
                       else if(permission.status == 'unchecked') {
                           permission.status = 'checked';
                           state = 'ADD';
                       }
                   }
               });

               let data = new FormData;
               data.append('id',this.userId);
               data.append('permission_id',id);
               data.append('state', state);

               axios.post('/api/ministry/permission/schoolAdmin/permission/some', data)
				.then((res) => {
                        this.flashMessage.success({
                            title: 'Successful',
                            message: res.data.data.message,
                            time: 5000,
                            flashMessageStyle: {
                                backgroundColor: 'linear-gradient(#e66465, #9198e5)'
                            }
                        });
                   
				})
				.catch((error) => {
                    this.$loading(false);
                   this.permissions.forEach(permission => {
                        if(permission.id == id){
                            if(permission.status == 'checked') {
                                permission.status = 'unchecked';
                            }
                            else if(permission.status == 'unchecked') {
                                permission.status = 'checked';
                            }
                        }
                    });
					if (!error.response) {
						this.$alert("You do not have internet access","Network Error","error");
						return ;
					}

                    if(error.response.status === 403){
						this.$alert("Sorry, you do not have the permission to perfrom this action","No Permission","error");
					}
                    if(error.response.status === 401){
						let return_url = window.location.pathname;
						this.$router.push({
							name: "aeo_zeo-login",
							params: { return_url: return_url }
							});
					}
				})
           }
		}
    }
</script>

<style lang="scss" scoped>
$toggle-background-color-on: dodger#45b6fe;
$toggle-background-color-off: darkgray;
$toggle-control-color: white;
$toggle-width: 50px;
$toggle-height: 25px;
$toggle-gutter: 5px;
$toggle-radius: 50%;
$toggle-control-speed: .15s;
$toggle-control-ease: ease-in;

// These are our computed variables
// change at your own risk.
$toggle-radius: $toggle-height / 2;
$toggle-control-size: $toggle-height - ($toggle-gutter * 2);

.toggle-control {
  display: block;
  position: relative;
  padding-left: $toggle-width;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 22px;
  user-select: none;

  input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
    height: 0;
    width: 0;
  }

  input:checked ~ .control {
    background-color: $toggle-background-color-on;
    
    &:after {
      left: $toggle-width - $toggle-control-size - $toggle-gutter;
    }
  }

  .control {
    position: absolute;
    top: 0;
    left: 0;
    height: $toggle-height;
    width: $toggle-width;
    border-radius: $toggle-radius;
    background-color: $toggle-background-color-off;
    transition: background-color $toggle-control-speed $toggle-control-ease;

    &:after {
      content: "";
      position: absolute;
      left: $toggle-gutter;
      top: $toggle-gutter;
      width: $toggle-control-size;
      height: $toggle-control-size;
      border-radius: $toggle-radius;
      background: $toggle-control-color;
      transition: left $toggle-control-speed $toggle-control-ease;
    }
  }
}

</style>
