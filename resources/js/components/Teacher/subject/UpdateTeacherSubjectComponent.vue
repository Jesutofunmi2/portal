<template>
   <div class="row match-height">
		<div class="col-md-12 ">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-tooltip">Update Subjects</h4>
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

						<form class="form" novalidate @submit.prevent="updateSubject">
							<div class="form-body">

								<div class="form-group">
									<label for="issueinput1">Subjects</label>
									<select id="issueinput1" v-model="subjIDs" @change="validationErrors.subjects=null" :class="{'border-danger':validationErrors.subjects}" class="form-control" name="subjects[]" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Subjects" required multiple size="10">
										<option value="">Select Subjects</option>
										<option :value="subj.id" v-for ="(subj ,index) in subjects" :key ="index" >{{ subj.subject_name }}</option>
									</select>
									<span  v-if="validationErrors.subjects" :class="['label text-danger']">{{ validationErrors.subjects[0] }}</span>
								</div>

							</div>

							<div class="form-actions">
								<button type="button" class="btn btn-warning mr-1">
									<i class="icon-cross2"></i> Cancel
								</button>
								<button type="submit" class="btn btn-primary">
									<i class="icon-check2"></i> Update
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

		data() {
			return {
				subjIDs : [],
				subjects : '',
				validationErrors: [],
			}
		},
        mounted() {
			this.getAllSubjects()
        },

		methods : {
			getTeacherSubjects() {
				this.$loading(true);
				axios.get('/api/teacher/subject/view/all')
				.then((res) => {
					const subjects = res.data.data.subjects
					
					if (Array.isArray(subjects) && subjects.length > 0) {
						subjects.forEach(subj => {
							this.subjIDs.push(subj.id);
						});
					}

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
							name: 'teacher-login',
							params: { return_url: return_url }
							});
					}

                    if(error.response.status === 403){
						this.$alert("Sorry, you do not have the permission to perfrom this action","No Permission","error");
					}
				})
			},

			getAllSubjects() {
				this.$loading(true)
				axios.get('/api/teacher/subject/viewall')
				.then((res) => {
					this.subjects = res.data.data
					this.$loading(false);
					this.getTeacherSubjects()
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
							name: 'teacher-login',
							params: { return_url: return_url }
							});
					}

				})
			},

			updateSubject() {
				let data = new FormData;
				data.append('subjects', JSON.stringify(this.subjIDs));
				this.$loading(true)

                axios.post('/api/teacher/subject/update', data)
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
					this.getTeacherSubjects();
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
							name: 'teacher-login',
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
