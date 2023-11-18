<template>
   <div class="row match-height">
		<!-- Striped rows start -->
<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">View Task</h4>
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
							
						<div class="table-responsive">
							<div v-if="pagination">
								<button @click="getTasks(meta.current_page-1)" :class="pagination.prev ? '' : 'disabled'" class="btn btn-success"> &lt;&lt;  Prev </button> {{ meta.current_page }} of {{ meta.last_page }} <button @click="getTasks(meta.current_page+1)" :class="pagination.next ? '' : 'disabled'" class="btn btn-success"> Next &gt;&gt;  </button>
							</div>
							<table class="table table-striped mb-0">
								<thead>
									<tr>
										<th>#</th>
										<th>Department</th>
										<th>Title</th>
										<th>Start Date</th>
										<th>Due Date</th>
										<th>Status</th>
										<th>Approval</th>
										<th>Action</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="(task , index) in tasks" :key="index">
										<th scope="row">{{ index+1 }}</th>
										<td>{{ task.department }}</td>
										<td>{{ task.title }}</td>
										<td>{{ task.start_date }}</td>
										<td>{{ task.due_date }}</td>
										<td>{{ task.status_label }}</td>
										<td>{{ task.approval_label }}</td>
										<td>
											<button @click="editTask(task.id)"  class="btn btn-success"><i class="icon-edit"></i> Edit </button>
										</td>
										<td>
										<button @click="taskBoard(task.id)"  class="btn btn-primary"><i class="icon-board"></i> Task Board</button>
										</td>
                            		</tr>
                          
                        		</tbody>
                    		</table>
							<div v-if="pagination">
								<button @click="getTasks(meta.current_page-1)" :class="pagination.prev ? '' : 'disabled'" class="btn btn-success"> &lt;&lt;  Prev </button> {{ meta.current_page }} of {{ meta.last_page }} <button @click="getTasks(meta.current_page+1)" :class="pagination.next ? '' : 'disabled'" class="btn btn-success"> Next &gt;&gt;  </button>
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
			
				tasks : null,
				pagination : null,
				meta : null,
			}
		},
        mounted() {
			this.getTasks();
        },

		methods : {
          
			getTasks(page = 1){

				if(this.meta && (page > this.meta.last_page || page == 0)  ) return ;

				this.$loading(true)

                axios.get('/api/ministry/task?page='+page)
				.then(res => {
					this.$loading(false)
					this.tasks = res.data.data,
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

			 editTask(id){
                this.$confirm("Are you sure you want to edit task?","Edit Task",'question').then(() => {
                this.$router.push({
                        name: 'ministry-edit-task',
                        params: { taskId: id }
                        });
                });
            },

			taskBoard(id){
				alert('Coming Soon');
			},

		}
    }
</script>

