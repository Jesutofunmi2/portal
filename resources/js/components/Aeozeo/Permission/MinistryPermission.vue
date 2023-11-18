<template>
   <div class="row match-height">
		<!-- Striped rows start -->
<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Ministry Admin</h4>
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
                <div class="card-block card-dashboard row">
                  
                  <div class="col-md-12">
                        <fieldset class="row py-2">
                            <div class="input-group col-xs-12">
                                <input v-model="query" type="text"  required class="form-control form-control-lg input-lg border-grey border-lighten-1 " placeholder="Search Keyword" aria-describedby="button-addon2">
                                <span class="input-group-btn" id="button-addon2">
                                    <button @click="getAdmins(1)" class="btn btn-lg btn-success border-grey border-lighten-1" type="submit"><i class="icon-ios-search-strong"></i></button>
                                </span>
                            </div>
                        </fieldset>
                   </div>

                </div>
                <div class="row"> 
                    <div class="col-md-9">
                          <div class="table-responsive " style="max-height:350px;">
                      <div v-if="pagination">
                          <button @click="getAdmins(meta.current_page-1)" :class="pagination.prev ? '' : 'disabled'" class="btn btn-success"> &lt;&lt;  Prev </button> {{ meta.current_page }} of {{ meta.last_page }} <button @click="getAdmins(meta.current_page+1)" :class="pagination.next ? '' : 'disabled'" class="btn btn-success"> Next &gt;&gt;  </button>
                      </div>
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Fullname</th>
                                    <th>Username</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody v-if="admins">

                                <tr v-for="(admin , index) in admins" :key="index">
                                    <th scope="row">{{ index+1 }}</th>
                                    <td>{{ admin.fullname }}</td>
                                    <td>{{ admin.username }}</td>
                                    <td>
                                    <button @click="editPermission(admin.id)" class="btn btn-success"><i class="icon-pencil"></i> Edit Permission</button>
                                    </td>
                                </tr>
                                <tr v-if="admins.length==0">
                                    <td colspan="4"> No Admin Available</td>
                                </tr>
                            
                            </tbody>
                        </table>
                    
                            <div v-if="pagination">
                                <button @click="getAdmins(meta.current_page-1)" :class="pagination.prev ? '' : 'disabled'" class="btn btn-success"> &lt;&lt;  Prev </button> {{ meta.current_page }} of {{ meta.last_page }} <button @click="getAdmins(meta.current_page+1)" :class="pagination.next ? '' : 'disabled'" class="btn btn-success"> Next &gt;&gt;  </button>
                            </div>
                        
                        </div>
                    </div>
                    <div class="col-md-3">
                          <div class="table-responsive" style="max-height:350px;">

                            <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th colspan="2">All Permission</th>
                                </tr>
                                <tr>
                                    <th>#</th>
                                    <th>Permission</th>
                                </tr>
                            </thead>
                            <tbody v-if="permissions">

                                <tr v-for="(permission , index) in permissions" :key="index">
                                    <th scope="row">{{ index+1 }}</th>
                                    <td>{{ permission.permission }}</td>
                                </tr>
                                <tr v-if="permissions.length==0">
                                    <td colspan="4"> No Permissions Available</td>
                                </tr>
                            
                            </tbody>
                            </table>
                   
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
				admins : null,
                pagination : null,
                meta : '',
                query : null,
                permissions : null,
			}
		},
        mounted() {
            this.getAllPermission();
        },

		methods : {
            getAdmins(page =1){
                if(this.meta && (page > this.meta.last_page || page == 0)  ) return ;

                let url = null;

                if((this.query != null) && (this.query != '')){
                    url = '/api/ministry/permission/ministryAdmin/view?query='+this.query+'&page='+page;
                }
                else{
                    url = '/api/ministry/permission/ministryAdmin/view?page='+page;
                }

                if(url==null) return ;

				this.$loading(true);
				axios.get(url)
				.then((res) => {
					this.admins = res.data.data,
                    this.pagination = res.data.links,
                    this.meta = res.data.meta,
					this.$loading(false)
				})
				.catch((error) => {
                    this.$loading(false);
					if (!error.response) {
						this.$alert("You do not have internet access","Network Error","error");
						return ;
					}

                    if(error.response.status === 401){
						let return_url = window.location.pathname;
						this.$router.push({
							name: "aeo_zeo-login",
							params: { return_url: return_url }
							});
					}

                    if(error.response.status === 403){
						this.$alert("Sorry, you do not have the permission to perfrom this action","No Permission","error");
					}
				})
			},

            getAllPermission(){

				this.$loading(true);
				axios.get('/api/ministry/permission/view')
				.then((res) => {
                    this.permissions = res.data.data.permissions,
					this.$loading(false);
                    this.getAdmins();
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

           editPermission(id){
               this.$confirm("Are you sure you want to edit permission?","Edit Permission",'question').then(() => {
                this.$router.push({
                        name: 'edit-ministry-admin-permission',
                        params: { userId: id }
                        });
                });
           }
		}
    }
</script>
