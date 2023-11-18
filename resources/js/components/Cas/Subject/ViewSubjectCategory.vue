<template>
   <div class="row match-height">
		<div class="col-md-12 ">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-tooltip">Category Subjects</h4>
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
						<router-link :to="{ name: 'cas-create-subject-category' }">
							<button class="btn btn-primary">&lt;&lt; Back</button>
						</router-link>
						<div class="row">
							<div class="col-md-6">
									<div class="table-responsive">
										<table class="table table-striped mb-0">
											<thead>
												<tr>
													<th>#</th>
													<th>Name</th>
													<th>Category</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody >
												<tr v-if="category_name">
													<th colspan="4">{{category_name}}'s Subjects</th>
												</tr>
												<tr v-for="(subject , index) in subjects" :key="index">
													<th scope="row">{{ index+1 }}</th>
													<td>{{ subject.subject_name }}</td>
													<td>{{ subject.class_category }}</td>
													<td>
														<button @click="toggleSubject(subject.id, 0)"  class="btn btn-danger"><i class="icon-cancel"></i> Remove </button>
													</td>
												</tr>
												<tr v-if="subjects != null && subjects.length == 0">
													<td colspan="4"> No Subject Available</td>
												</tr>
												<tr v-if="subjects == null">
														<td colspan="4"> No Subject Available </td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
								<div class="col-md-6">
									<div class="table-responsive">
										<table class="table table-striped mb-0">
											<thead>
												<tr>
													<th>#</th>
													<th>Name</th>
													<th>Category</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody >
												<tr v-if="available_subjects">
													<th colspan="4">Subjects with no category</th>
												</tr>
												<tr v-for="(subject , index) in available_subjects" :key="index">
													<th scope="row">{{ index+1 }}</th>
													<td>{{ subject.subject_name }}</td>
													<td>{{ subject.class_category }}</td>
													<td>
														<button @click="toggleSubject(subject.id, 1)"  class="btn btn-success"><i class="icon-check"></i> Add </button>
													</td>
												</tr>
												<tr v-if="subjects != null && available_subjects.length == 0">
													<td colspan="4"> No Subject Available</td>
												</tr>
												<tr v-if="available_subjects == null">
														<td colspan="4"> No Subject Available </td>
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
				id :this.$route.params.categoryId,
				subjects: null,
				available_subjects: null,
				category_name : null,
			}
		},
        mounted() {
			this.getSubjects();
        },

		methods : {
			
			getSubjects() {
				this.$loading(true)
				axios.get('/api/ministry/subject/category/view-subject?id='+this.id)
				.then((res) => {
					this.subjects = res.data.data.subjects;
					this.available_subjects = res.data.data.available_subjects;
					this.category_name  = res.data.data.category_name;
					this.$loading(false);
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
									name: 'cas-login',
									params: { return_url: return_url }
									});
					}
	
				})
			},

            toggleSubject(subject_id, action) {
				if(subject_id == null || action == null) return;
				this.$loading(true)

				let data = {
					id : this.id,
					subject_id : subject_id,
					action : action
				};

                axios.post('/api/ministry/subject/category/toggle-subject',data)
				.then((res) => {
					this.subjects = res.data.data.subjects;
					this.available_subjects = res.data.data.available_subjects;

					this.$loading(false);

					this.flashMessage.success({
						title: 'Successful',
						message: res.data.data.message,
						time: 15000,
						flashMessageStyle: {
							backgroundColor: 'linear-gradient(#e66465, #9198e5)'
						}
					});
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
						this.flashMessage.error({title: 'Validation Error', 
											message: 'Their is Error with the Data you supplied',
											time: 15000, });
					}

					if(error.response.status === 401){
						let return_url = window.location.pathname;
						this.$router.push({
							name: 'cas-login',
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