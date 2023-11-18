<template>
   <div class="row match-height">
		<!-- Striped rows start -->
<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Create Department</h4>
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
                
               <div class="card-block">

							<div v-if="edit.id==null" class="row">
							
								<div class="col-md-8">
									<div class="form-body">
										<div class="form-group">
											<input type="text" @keydown="validationErrors.name=null" :class="{'border-danger':validationErrors.name}" v-model="name" class="form-control"  placeholder="Enter Department" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Enter Department">
											<span  v-if="validationErrors.name" :class="['label text-danger']">{{ validationErrors.name[0] }}</span>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									
										<button type="submit" class="btn btn-success" @click="createDepartment">
											<i class="icon-check2"></i> Create Department
										</button>
									
								</div>

							</div>
							<div v-if="edit.id" class="row">
							
								<div class="col-md-8">
									<div class="form-body">
										<div class="form-group">
											<input type="text" @keydown="validationErrors.name=null" :class="{'border-danger':validationErrors.name}" v-model="edit.name" class="form-control"  placeholder="Update Department" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Update Department">
											<span  v-if="validationErrors.name" :class="['label text-danger']">{{ validationErrors.name[0] }}</span>
										</div>
									</div>
								</div>
								<div class="col-md-4">
										<button type="submit" class="btn btn-success" @click="updateDepartment()">
											<i class="icon-check2"></i> Update Department
										</button>
								</div>

							</div>
							
						<div class="table-responsive">
							<div v-if="pagination">
								<button @click="getDepartments(meta.current_page-1)" :class="pagination.prev ? '' : 'disabled'" class="btn btn-success"> &lt;&lt;  Prev </button> {{ meta.current_page }} of {{ meta.last_page }} <button @click="getDepartments(meta.current_page+1)" :class="pagination.next ? '' : 'disabled'" class="btn btn-success"> Next &gt;&gt;  </button>
							</div>
							<table class="table table-striped mb-0">
								<thead>
									<tr>
										<th>#</th>
										<th>Department Name</th>
										<th>Action</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="(department , index) in departments" :key="index">
										<th scope="row">{{ index+1 }}</th>
										<td>{{ department.name }}</td>
                            
										<td>
											<button @click="getEdit(department.id, department.name)"  class="btn btn-primary"><i class="icon-edit"></i> Edit </button>
										</td>
										<td>
										<button @click="deleteDepartment(department.id)"  class="btn btn-danger"><i class="icon-trash4"></i> Delete</button>
										</td>
                            		</tr>
                          
                        		</tbody>
                    		</table>
							<div v-if="pagination">
								<button @click="getDepartments(meta.current_page-1)" :class="pagination.prev ? '' : 'disabled'" class="btn btn-success"> &lt;&lt;  Prev </button> {{ meta.current_page }} of {{ meta.last_page }} <button @click="getDepartments(meta.current_page+1)" :class="pagination.next ? '' : 'disabled'" class="btn btn-success"> Next &gt;&gt;  </button>
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
				name : "",
				departments : null,
               	validationErrors : [],
				pagination : null,
                meta : '',
				edit : {
					id : null,
					name : null,
				}
			   
			}
		},
        mounted() {
			this.getDepartments();
        },

		methods : {
          
            createDepartment(){
				
				this.$loading(true)

                axios.post('/api/ministry/department/create',{'name':this.name} )
				.then(response => {
                    if(response) {
                        this.flashMessage.success({
                            title: 'Successful',
                            message: 'Department Created Successfully',
                            time: 15000,
                            flashMessageStyle: {
                                backgroundColor: 'linear-gradient(#e66465, #9198e5)'
                            }
                        });
						this.name = "";
						this.getDepartments();
	
                    }
				
                })
				.catch(error => {
					this.$loading(false)
					if (!error.response) {
						this.$alert("You do not have internet access or Unknown Error","Network Error","error");
						return ;
					}
					if (error.response.status == 409){
					this.flashMessage.error({title: 'Registration Error', 
											message: error.response.data.message,
											time: 15000, });
					}

					if (error.response.status == 422){
					this.validationErrors = error.response.data.errors;
					this.flashMessage.error({title: 'Validation Error', 
											message: 'Their is Error with the Data you supplied',
											time: 15000, });
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
					
				});
            },

			getDepartments(page = 1){

				if(this.meta && (page > this.meta.last_page || page == 0)  ) return ;

				this.$loading(true)

                axios.get('/api/ministry/department?page='+page)
				.then(res => {
					this.$loading(false)
					this.departments = res.data.data,
                    this.pagination = res.data.links,
                    this.meta = res.data.meta;
                })
				.catch(error => {
					this.$loading(false)
					if (!error.response) {
						this.$alert("You do not have internet access or Unknown Error","Network Error","error");
						return ;
					}
					if (error.response.status == 400){
					this.flashMessage.error({title: 'Process Error', 
											message: error.response.data.message,
											time: 15000, });
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
					
				});
			},

			getEdit(id, name) {
				this.edit.id = id,
				this.edit.name = name;
			},

			updateDepartment(){
				if(this.edit.id == null || this.edit.id == '') return;
				if(this.edit.name == null || this.edit.name == '') return;

				this.$loading(true)

                axios.put('/api/ministry/department/'+this.edit.id+'/update',{'name':this.edit.name} )
				.then(response => {
                    if(response) {
                        this.flashMessage.success({
                            title: 'Successful',
                            message: 'Department Updated Successfully',
                            time: 15000,
                            flashMessageStyle: {
                                backgroundColor: 'linear-gradient(#e66465, #9198e5)'
                            }
                        });
						this.edit.id = null;
						this.edit.name = null;
						this.getDepartments();
	
                    }
				
                })
				.catch(error => {
					this.$loading(false)
					if (!error.response) {
						this.$alert("You do not have internet access or Unknown Error","Network Error","error");
						return ;
					}
					if (error.response.status == 409){
					this.flashMessage.error({title: 'Registration Error', 
											message: error.response.data.message,
											time: 15000, });
					}

					if (error.response.status == 422){
					this.validationErrors = error.response.data.errors;
					this.flashMessage.error({title: 'Validation Error', 
											message: 'Their is Error with the Data you supplied',
											time: 15000, });
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
					
				});
			},

			deleteDepartment(id){
				this.$loading(true)

                axios.delete('/api/ministry/department/'+id+'/delete' )
				.then(response => {
                    if(response) {
                        this.flashMessage.success({
                            title: 'Successful',
                            message: 'Department Deleted Successfully',
                            time: 15000,
                            flashMessageStyle: {
                                backgroundColor: 'linear-gradient(#e66465, #9198e5)'
                            }
                        });
						this.getDepartments();
	
                    }
				
                })
				.catch(error => {
					this.$loading(false)
					if (!error.response) {
						this.$alert("You do not have internet access or Unknown Error","Network Error","error");
						return ;
					}
					if (error.response.status == 400){
					this.flashMessage.error({title: 'Process Error', 
											message: error.response.data.message,
											time: 15000, });
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
					
				});
			}
		}
    }
</script>

