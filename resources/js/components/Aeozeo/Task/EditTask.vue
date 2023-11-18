<template>
   <div class="row match-height">
		<!-- Striped rows start -->
<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Create Task</h4>
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

							<div class="row">
							
								<div class="col-md-4">
									<div class="form-group">
										<label for="issueinput1">Department</label>
										<select @change="validationErrors.department_id=null" v-model="task.department_id" :class="{'border-danger':validationErrors.department_id}" class="form-control" name="state" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select Department" >
											<option value="">Select Department</option>
											<option :value="department.id" v-for ="(department ,index) in departments" :key ="index" >{{ department.name }}</option>
										</select>
										 <span  v-if="validationErrors.department_id" :class="['label text-danger']">{{ validationErrors.department_id[0] }}</span>
									</div>
								</div>
								
								<div class="col-md-8">
									
										<div class="form-group">
											<label for="issueinput1">Title</label>
											<input type="text" @keydown="validationErrors.title=null" :class="{'border-danger':validationErrors.title}" v-model="task.title" placeholder="Enter task title" class="form-control"  data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Enter Tast Title">
											<span  v-if="validationErrors.title" :class="['label text-danger']">{{ validationErrors.title[0] }}</span>
										</div>
									
								</div>

								<div class="col-md-6">
									
										<div class="form-group">
											<label for="issueinput1">Start Date</label>
											<input type="date" @change="validationErrors.start_date=null" :class="{'border-danger':validationErrors.start_date}" v-model="task.start_date" placeholder="Select Date" class="form-control"  data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Set Start Date">
											<span  v-if="validationErrors.start_date" :class="['label text-danger']">{{ validationErrors.start_date[0] }}</span>
										</div>
									
								</div>
								<div class="col-md-6">
									
										<div class="form-group">
											<label for="issueinput1">Due Date</label>
											<input type="date" @change="validationErrors.due_date=null" :class="{'border-danger':validationErrors.due_date}" v-model="task.due_date" placeholder="Select Date" class="form-control"  data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Set Due Date">
											<span  v-if="validationErrors.due_date" :class="['label text-danger']">{{ validationErrors.due_date[0] }}</span>
										</div>
									
								</div>
								<div class="col-md-12">
									
										<div class="form-group">
											<label for="issueinput1">Description</label>
											<textarea rows="5" type="date" @keypress="validationErrors.descrip=null" :class="{'border-danger':validationErrors.descrip}" v-model="task.descrip" placeholder="Enter description " class="form-control"  data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Enter description">
											</textarea>
											<span  v-if="validationErrors.descrip" :class="['label text-danger']">{{ validationErrors.descrip[0] }}</span>
										</div>
									
								</div>
								<div class="col-md-4">
										<button type="submit" class="btn btn-success" @click="updateTask()">
											<i class="icon-check2"></i> Update Task
										</button>
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
				taskId: this.$route.params.taskId,
				departments : null,
               	validationErrors : [],
				task : {
					department_id : null,
					title : null,
					descrip : null,
					start_date : null,
					due_date : null,
				}
			   
			}
		},
        mounted() {
			this.getDepartments();
        },

		methods : {

			getDepartments(){

				this.$loading(true)

                axios.get('/api/ministry/department/all')
				.then(res => {
					this.$loading(false)
					this.departments = res.data.data;
					this.getTask();
                })
				.catch(error => {
					this.$loading(false)
					if (!error.response) {
						this.$alert("You do not have internet access or Unknown Error","Network Error","error");
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
					
				});
			},
          
            updateTask(){
				
				this.$loading(true)

                axios.put('/api/ministry/task/'+this.taskId+'/update',this.task )
				.then(response => {
					this.$loading(false)
                    if(response) {
                        this.flashMessage.success({
                            title: 'Successful',
                            message: 'Task Updated Successfully',
                            time: 15000,
                            flashMessageStyle: {
                                backgroundColor: 'linear-gradient(#e66465, #9198e5)'
                            }
                        });

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

			getTask(){
				this.$loading(true);
				axios.get('/api/ministry/task/'+this.taskId+'/view')
				.then((res) => {
					this.task = res.data.data;
					this.$loading(false)
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
			},

		}
    }
</script>

