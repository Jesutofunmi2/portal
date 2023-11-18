<template>
   <div class="row match-height">
		<div class="col-md-12 ">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-tooltip">Subject Category</h4>
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

							<div class="form-body" v-if="isUpdate">
									
								<h4 class="form-section">Update Subject Category</h4>
								<div class="row">
									<div class="col-md-9">
										<div class="form-group">
											<label for="projectinput1">Category Name</label>
											<input v-model="category_name" type="text" class="form-control"  data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Enter Category">
										</div>
									</div>
									
									<div class="col-md-3">
											<fieldset style="width:100%;" class="row py-2">
												<div class="input-group col-xs-12">
													<button @click="update()" style="width:100%; background:#FF8C00; color:#fff;" class="btn btn-lg">Update</button>
												</div>
											</fieldset> 
									</div>
								</div>
								
							</div>
							<div class="form-body" v-else>
									
								<h4 class="form-section">Create Subject Category</h4>
								<div class="row">
									<div class="col-md-9">
										<div class="form-group">
											<label for="projectinput1">Category Name</label>
											<input v-model="category_name" type="text" class="form-control"  data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Enter Category">
										</div>
									</div>
									
									<div class="col-md-3">
											<fieldset style="width:100%;" class="row py-2">
												<div class="input-group col-xs-12">
													<button @click="create()" style="width:100%; background:#FF8C00; color:#fff;" class="btn btn-lg">Create</button>
												</div>
											</fieldset> 
									</div>
								</div>
								
							</div>
					
                    <div class="row">
						<div class="col-md-12">
							<div class="table-responsive">
								<table class="table table-striped mb-0">
									<thead>
										<tr>
											<th>#</th>
											<th>Name</th>
											<th>Action</th>
											<th></th>
											<th></th>
										</tr>
									</thead>
									<tbody v-if="categories">
										<tr v-for="(category, index) in categories" :key="index">
											<td>{{index+1}}</td>
											<td>{{category.name}}</td>
											<td><button @click="viewSubject(category.id)" class="btn btn-success">View Subject</button></td>
											<td><button @click="edit(category.id)" class="btn btn-primary">Edit</button></td>
											<td><button @click="deleteCat(category.id)" class="btn btn-danger">Delete</button></td>
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
		<FlashMessage></FlashMessage>

	</div>
	
</template>

<script>

    export default {
	components: {
		
		},
		data(){
			return {
				categories: null,
				category_name: null,
				isUpdate : false,
				category_id : null
			}
		},
        mounted() {
			this.getSubjectCategory();
        },

		methods : {
			
			getSubjectCategory(){
				this.$loading(true)
				axios.get('/api/ministry/subject/category/view')
				.then((res) => {
					this.categories = res.data.data.categories
					this.$loading(false)
				})
				.catch((error) => {
					this.$loading(false)
					if (!error.response) {
						this.$alert("You do not have internet access","Network Error","error");
						this.$router.go(-1) ;
						return ;
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

            create() {
				if(this.category_name == null || '') return;
				this.$loading(true)

                axios.post('/api/ministry/subject/category/create',{name : this.category_name})
				.then(response => {
                    if(response) {
						this.$loading(false);
						this.category_name = null;
                        this.flashMessage.success({
                            title: 'Successful',
                            message: response.data.data.message,
                            time: 15000,
                            flashMessageStyle: {
                                backgroundColor: 'linear-gradient(#e66465, #9198e5)'
                            }
                        });
	
                    }
					this.getSubjectCategory();
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

			update() {
				if(this.category_name == null || '') return;
				this.$loading(true)

                axios.put('/api/ministry/subject/category/'+this.category_id+'/update',{name : this.category_name})
				.then(response => {
                    if(response) {
						this.$loading(false);
						this.category_name = null;
						this.isUpdate = false;
                        this.flashMessage.success({
                            title: 'Successful',
                            message: response.data.data.message,
                            time: 15000,
                            flashMessageStyle: {
                                backgroundColor: 'linear-gradient(#e66465, #9198e5)'
                            }
                        });
	
                    }
					this.getSubjectCategory();
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

			edit(id) {
                this.$confirm("Are you sure you want to edit category?","Edit Category",'question').then(() => {
					this.categories.forEach(category => {
						if (category.id == id) {
							this.isUpdate = true;
							this.category_name = category.name;
							this.category_id = category.id;
						}
					});
                });
            },
			
			deleteCat(id) {
                this.$confirm("Are you sure you want to delete category?","Delete Category",'warning').then(() => {
					this.$loading(true)
					axios.delete('/api/ministry/subject/category/'+id+'/delete')
					.then((response) => {
						this.$loading(false);
						this.$alert(response.data.data.message,"Successful","success");
						this.getSubjectCategory();
					})
					.catch((error) => {
						this.$loading(false);
						if (!error.response) {
							this.$alert("You do not have internet access or Unknown Error","Network Error","error");
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
                });
            },

			viewSubject(id) {
                this.$router.push({
								name: 'view-category-subject',
								params: { categoryId: id }
								});
            },

		}
    }
</script>