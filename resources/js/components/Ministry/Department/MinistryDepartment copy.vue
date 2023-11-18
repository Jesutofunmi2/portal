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

						<form class="form" novalidate @submit.prevent="createAdmin">
							<div class="row">
							
								<div class="col-md-8">
									<div class="form-body">
										<div class="form-group">
											<input type="text" @keydown="validationErrors.name=null" :class="{'border-danger':validationErrors.name}" v-model="department" class="form-control"  placeholder="Enter Department" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Enter Department">
											<span  v-if="validationErrors.name" :class="['label text-danger']">{{ validationErrors.name[0] }}</span>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									
										<button type="submit" class="btn btn-success">
											<i class="icon-check2"></i> Create Department
										</button>
									
								</div>

							</div>
							
						</form>
						<vue-table-dynamic :params="params"></vue-table-dynamic>
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
               	validationErrors : [],
			    params: {
					data: [
					['Index', 'Name', 'Action'],
					['Cell-4', 'Cell-5', 'Cell-6'],
					['Cell-7', 'Cell-8', '<button>Hello</button>']
					],
					header: 'row',
        			border: true,
					stripe:true,
					sort: [0, 1],
					enableSearch: true
				}
			}
		},
        mounted() {
         
        },

		methods : {
          
            createDepartment(){
				
				this.$loading(true)

                axios.post('/api/ministry/department/create',{'name':this.name} )
				.then(response => {
                    if(response) {
						this.$loading(false)
                        this.flashMessage.success({
                            title: 'Successful',
                            message: response.data.data.message,
                            time: 15000,
                            flashMessageStyle: {
                                backgroundColor: 'linear-gradient(#e66465, #9198e5)'
                            }
                        });
						this.name = "";
	
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
							name: 'ministry-login',
							params: { return_url: return_url }
							});
					}
					if(error.response.status === 403){
						this.$alert("Sorry, you do not have the permission to perfrom this action","No Permission","error");
					}
					
				});
            },
		}
    }
</script>

