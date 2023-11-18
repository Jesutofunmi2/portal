<template>
   <div class="row match-height">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-tooltip">Edit Class Arm </h4>
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

						<form class="form" @submit.prevent="updateClassArm">
							<div class="form-body">

								<div class="form-group col-md-6">
									<label for="issueinput1">Class</label>
									<select id="issueinput1" v-model="classarm.class_id" :class="{'border-danger':validationErrors.class_id}" class="form-control" name="class_id" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Class" readonly required>
										<option value="">Select Class</option>
										<option :value="clas.id" v-for ="(clas, index) in classes" :key ="index" >{{ clas.class_name }}</option>
									</select>
									<span  v-if="validationErrors.class_id" :class="['label text-danger']">{{ validationErrors.class_id[0] }}</span>
								</div>

								<div class="form-group col-md-6" >
									<label for="issueinput2">Class Arm</label>
									<input type="text" id="issueinput2" @keydown="validationErrors.class_arm=null" :class="{'border-danger':validationErrors.class_arm}" v-model="classarm.class_arm" class="form-control" placeholder="Class Arm" name="class_arm" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Class Arm" required>
									<span  v-if="validationErrors.class_arm" :class="['label text-danger']">{{ validationErrors.class_arm[0] }}</span>
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
				classArmID : this.$route.params.classArmID,
				classes : '',
				classarm : '',
				validationErrors: [],
			}
		},
        mounted() {
			this.getClasses();
        },

		methods : {
			getClassArm(){
				this.$loading(true)
				axios.get(`/api/school/classarm/${this.classArmID}/edit`)
				.then((res) => {
					this.classarm = res.data.data,
				
					this.$loading(false)
				})
				.catch((error) => {
					this.$loading(false)
					if (!error.response) {
						this.$alert("You do not have internet access","Network Error","error");
						return ;
					}

					if(error.response.status === 403){
						this.$alert("Sorry, you do not have the permission to perform this action","No Permission","error");
					}

					if(error.response.status === 400){
						this.$alert(error.response.data.message, "Request Error","error");
					}
				})
			},

			getClasses() {
				this.$loading(true)
				axios.get('/api/school/class/view/all')
				.then((res) => {
					this.classes = res.data.data
					this.$loading(false);
					this.getClassArm();
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
									name: 'school-login',
									params: { return_url: return_url }
									});
					}

					if(error.response.status === 400){
						this.$alert(error.response.data.message, "Request Error","error");
					}

				})
			},

            updateClassArm(){
				let data = new FormData;
				data.append('class_arm', this.classarm.class_arm);
				
				this.$loading(true)

                axios.post(`/api/school/classarm/${this.classArmID}/update`, data)
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
						this.getClassArm();
                    }
                })
				.catch(error => {
					this.$loading(false)
					if (error.response.status == 422){
						this.validationErrors = error.response.data.errors;
						this.flashMessage.error({title: 'Validation Error', 
							message: 'There is an Error with the Data you supplied',
							time: 15000, });
					}
					if(error.response.status === 403){
						this.$alert("Sorry, you do not have the permission to perform this action","No Permission","error");
					}

					if(error.response.status === 400){
						this.$alert(error.response.data.message, "Request Error","error");
					}
				});
            }
		}
    }
</script>