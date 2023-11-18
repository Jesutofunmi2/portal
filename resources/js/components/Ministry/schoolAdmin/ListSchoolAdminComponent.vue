<template>
   <div class="row match-height">
		<!-- Striped rows start -->
<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">List School Admin</h4>
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
                   <div class="col-md-6">
                        <fieldset class="row py-2">
                            <div class="input-group col-xs-12">
                                <input v-model="query" type="text"  required class="form-control form-control-lg input-lg border-grey border-lighten-1 " placeholder="Search Keyword" aria-describedby="button-addon2">
                                <span class="input-group-btn" id="button-addon2">
                                    <button @click="searchByTerm" class="btn btn-lg btn-success border-grey border-lighten-1" type="submit"><i class="icon-ios-search-strong"></i></button>
                                </span>
                            </div>
                        </fieldset>
                   </div>
                   <div class="col-md-6">
                        
                             <fieldset style="width:100%;" class="row py-2">
                                <div class="input-group col-xs-12">
                                    <select v-model="school_id" @change="searchBySchool" type="text" required class="form-control form-control-lg input-lg border-grey border-lighten-1 " aria-describedby="button-addon2">
                                        <option selected value="">Search by School</option>
                                        <option  v-for="school in schools" :key="school.id" :value="school.id"> {{ school.name }}</option>
                                    </select>
                                 
                                </div>
                            </fieldset>
                       
                   </div>
                </div>
                <div class="table-responsive">
                       <div v-if="pagination">
                          <button @click="getAdmins(meta.current_page-1)" :class="pagination.prev ? '' : 'disabled'" class="btn btn-success"> &lt;&lt;  Prev </button> {{ meta.current_page }} of {{ meta.last_page }} <button @click="getAdmins(meta.current_page+1)" :class="pagination.next ? '' : 'disabled'" class="btn btn-success"> Next &gt;&gt;  </button>
                      </div>
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Admin Name</th>
                                <th>School Name</th>
                                <th>Username</th>
                                <th>Phone</th>
                                <th>Action</th>
                                 <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(admin , index) in admins" :key="index">
                                <th scope="row">{{ index+1 }}</th>
                                <td>{{ admin.fullname }}</td>
                                <td>{{ admin.school_name }}</td>
                                <td>{{ admin.username }}</td>
                                <td>{{ admin.phone }}</td>
                            
                                <td>
                                    <button @click="editAdmin(admin.id)"  class="btn btn-primary"><i class="icon-edit"></i> Edit </button>
                                </td>
                                 <td>
                                   <button @click="deleteAdmin(admin.id)"  class="btn btn-danger"><i class="icon-trash4"></i> Delete</button>
                                </td>
                            </tr>
                          
                        </tbody>
                    </table>
                     <div v-if="pagination">
                          <button @click="getAdmins(meta.current_page-1)" :class="pagination.prev ? '' : 'disabled'" class="btn btn-success"> &lt;&lt;  Prev </button> {{ meta.current_page }} of {{ meta.last_page }} <button @click="getAdmins(meta.current_page+1)" :class="pagination.next ? '' : 'disabled'" class="btn btn-success"> Next &gt;&gt;  </button>
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
                school_id : '',
				schools : '',
                admins :'',
                query : null,
                pagination : '',
                meta : '',
                is_term : false,
                is_school_id : false,
			}
		},
        mounted() {
            this.getSchools();
        },

		methods : {
			getSchools(){
				this.$loading(true)
				axios.get('/api/ministry/school/secondary/view/all')
				.then((res) => {
					this.schools = res.data.data;
                    this.getAdmins();
				})
				.catch((error) => {
                    this.$loading(false);
					if (!error.response) {
						this.$alert("You do not have internet access","Network Error","error");
						this.$router.go(-1) ;
						return ;
					}
					if(error.response.status === 401){
						let return_url = window.location.pathname;
						this.$router.push({
									name: 'ministry-login',
									params: { return_url: return_url }
									});
					}

                    if(error.response.status === 403){
						this.$alert("Sorry, you do not have the permission to perfrom this action","No Permission","error");
					}
				})
			},

            getAdmins(page =1){
                if(this.meta && (page > this.meta.last_page || page == 0)  ) return ;

                let url = null;

                if(this.is_term===true){
                    url = '/api/ministry/school/admin/view?query='+this.query+'&page='+page;
                }
                else if(this.is_school_id===true){
                    url = '/api/ministry/school/admin/view?school_id='+this.school_id+'&page='+page;
                }
                else{
                    url = '/api/ministry/school/admin/view?page='+page;
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

                    if(error.response.status === 403){
						this.$alert("Sorry, you do not have the permission to perfrom this action","No Permission","error");
					}
				})
			},

            searchByTerm(){
                this.is_term = true;
                this.is_school_id = false;
                this.getAdmins()
            },

            searchBySchool(){
                    this.is_term = false;
                    this.is_school_id = true;
                    this.getAdmins()
			},

            editAdmin(id){
                this.$confirm("Are you sure you want to edit school?","Edit School",'question').then(() => {
                this.$router.push({
                        name: 'edit-school-admin',
                        params: { adminId: id }
                        });
                });
            },

            deleteAdmin(id){
                this.$confirm("Are you sure you want delete school?","Delete School",'warning').then(() => {
                this.$loading(true)
                axios.delete('/api/ministry/school/admin/'+id+'/delete')
                .then((response) => {
                    this.$loading(false);
                    this.$alert(response.data.data.message,"Successful","success");
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
				})
                });
            }

		}
    }
</script>
