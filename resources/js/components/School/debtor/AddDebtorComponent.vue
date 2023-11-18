<template>
   <div class="row match-height">
		<div class="col-md-12 ">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-tooltip">Add Debtor</h4>
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

						<form class="form" novalidate @submit.prevent="addDebtor">
							<div class="form-body">

								<div class="form-group col-md-6">
									<label for="issueinput12">Students</label>
									<select id="issueinput12" v-model="student_id" @change="validationErrors.student_id=null" :class="{'border-danger':validationErrors.teacher_id}" class="form-control" name="student_id" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Student" required>
										<option value="">Select Student</option>
										<option :value="stud.id" v-for ="(stud ,index) in students" :key ="index">
											{{ stud.surname }}
											{{ stud.firstname }}
											{{ stud.middlename }}
										</option>
									</select>
									<span  v-if="validationErrors.student_id" :class="['label text-danger']">{{ validationErrors.student_id[0] }}</span>
								</div>

								<div class="form-group col-md-6">
									<label for="issueinput17">Issue</label>
									<textarea id="issueinput17" @keydown="validationErrors.issue=null" :class="{'border-danger':validationErrors.issue}" v-model="issue" rows="5" class="form-control" name="issue" placeholder="Issue" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Issue" required></textarea>
									<span  v-if="validationErrors.issue" :class="['label text-danger']">{{ validationErrors.issue[0] }}</span>
								</div>

							</div>

							<div class="form-actions">
								<button type="button" class="btn btn-warning mr-1">
									<i class="icon-cross2"></i> Cancel
								</button>
								<button type="submit" class="btn btn-primary">
									<i class="icon-check2"></i> Save
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<FlashMessage></FlashMessage>

	</div>
	
</template>

<script>

    export default {

		data(){
			return {
				students : '',
				student_id : '',
				issue : '',
				validationErrors: [],
			}
		},
        mounted() {
			this.getStudents();
        },

		methods : {
			getStudents($url = '/api/school/student/view/all') {
                if($url == null) return;
                
				this.$loading(true);
				axios.get($url)
				.then((res) => {
					this.students = res.data.data,
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
									name: 'school-login',
									params: { return_url: return_url }
									});
					}

                    if(error.response.status === 403){
						this.$alert("Sorry, you do not have the permission to perfrom this action","No Permission","error");
					}
				})
            },

			addDebtor() {
				let data = new FormData;
				data.append('student_id', this.student_id);	
				data.append('issue', this.issue);			
				this.$loading(true)

                axios.post('/api/school/debtor/add',data)
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
                    }
					this.student_id = null;
					this.issue = null;
                })
				.catch(error => {
					this.$loading(false)
					if (!error.response) {
						this.$alert("You do not have internet access","Network Error","error");
						return ;
					}
					if (error.response.status == 422){
					this.validationErrors = error.response.data.errors;
					this.flashMessage.error({title: 'Validation Error', 
											message: 'There is an Error with the Data you supplied',
											time: 15000, });
					}
					if(error.response.status === 401){
						let return_url = window.location.pathname;
						this.$router.push({
							name: 'school-login',
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
