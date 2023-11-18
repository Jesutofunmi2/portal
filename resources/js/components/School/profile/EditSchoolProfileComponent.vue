<template>
   <div class="row match-height">
		<div class="col-md-12 ">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-tooltip">Edit School Profile</h4>
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

						<form class="form" novalidate @submit.prevent="updateSchool">
							<div class="form-body">

								<div class="form-group col-md-6">
									<label for="issueinput48">School Name</label>
									<input type="text" @keydown="validationErrors.name=null" :class="{'border-danger':validationErrors.name}" v-model="school.name" class="form-control"  placeholder="Enter School Name" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Enter School Name">
									<span  v-if="validationErrors.name" :class="['label text-danger']">{{ validationErrors.name[0] }}</span>
								</div>

								<div class="form-group col-md-6">
									<label for="issueinput38">Principal Name</label>
									<input type="text" @keydown="validationErrors.principal_name=null" :class="{'border-danger':validationErrors.principal_name}" v-model="school.principal_name" class="form-control"  placeholder="Enter Principal Name" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Enter Principal Name">
									<span  v-if="validationErrors.principal_name" :class="['label text-danger']">{{ validationErrors.principal_name[0] }}</span>
								</div>

								<div class="form-group col-md-6">
									<label for="issueinput8">Counsellor Name</label>
									<input type="text" @keydown="validationErrors.counsellor_name=null" :class="{'border-danger':validationErrors.counsellor_name}" v-model="school.counsellor_name" class="form-control"  placeholder="Enter Counsellor Name" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Enter Counsellor Name">
									<span  v-if="validationErrors.counsellor_name" :class="['label text-danger']">{{ validationErrors.counsellor_name[0] }}</span>
								</div>

								<div class="form-group col-md-6">
									<label for="issueinput08">Phone</label>
									<input type="text" @keydown="validationErrors.phone=null" :class="{'border-danger':validationErrors.phone}" v-model="school.phone" class="form-control"  placeholder="Enter Phone Number" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Enter Phone Number">
									<span  v-if="validationErrors.phone" :class="['label text-danger']">{{ validationErrors.phone[0] }}</span>
								</div>

								<div class="form-group col-md-6">
									<label for="issueinput10">Local Goverment Area</label>
									<select id="issueinput10" v-model="school.lga_id" @change="validationErrors.lga_id=null" :class="{'border-danger':validationErrors.lga_id}" class="form-control" name="lga_id" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Local Goverment Area" required>
										<option value="">Select LGA</option>
										<option :value="lga.id" v-for ="(lga ,index) in lgas" :key ="index" >{{ lga.name }}</option>
									</select>
									<span  v-if="validationErrors.lga_id" :class="['label text-danger']">{{ validationErrors.lga_id[0] }}</span>
								</div>

								<div class="form-group col-md-6">
									<label for="issueinput12">School Category</label>
									<select id="issueinput12" v-model="school.school_category" @change="validationErrors.school_category=null" :class="{'border-danger':validationErrors.school_category}" class="form-control" name="school_category" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="School Category" required>
										<option value="">Select School Category</option>
										<option value="unity">Unity</option>
                                        <option value="non_unity">Non Unity</option>
									</select>
									<span  v-if="validationErrors.school_category" :class="['label text-danger']">{{ validationErrors.school_category[0] }}</span>
								</div>

								<div class="form-group">
									<label for="issueinput17">Address</label>
									<textarea id="issueinput17" @keydown="validationErrors.address=null" :class="{'border-danger':validationErrors.address}" v-model="school.address" rows="5" class="form-control" name="address" placeholder="Address" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Address" required></textarea>
									<span  v-if="validationErrors.address" :class="['label text-danger']">{{ validationErrors.address[0] }}</span>
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

		data(){
			return {
				school : {
					name : '',
					principal_name : '',
					counsellor_name : '',
					phone : '',
					address : '',
					lga_id : '',
					school_category : '',
				},
				state : '',
				lgas : '',
				validationErrors: [],
			}
		},
        mounted() {
			this.getState()
        },

		methods : {
			getSchool() {
				this.$loading(true)
				axios.get('/api/school/profile/editschool')
				.then((res) => {
					this.school.name = res.data.data.name
					this.school.principal_name = res.data.data.principal_name
					this.school.counsellor_name = res.data.data.counsellor_name
					this.school.phone = res.data.data.phone
					this.school.address = res.data.data.address
					this.school.lga_id = res.data.data.lga_id
					this.school.school_category = res.data.data.school_category

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

			getState() {
				this.$loading(true)
				axios.get('/api/general/get_state')
				.then((res) => {
					this.state = res.data.state,
					this.lgas = res.data.data
					this.$loading(false);
					this.getSchool();
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

				})
			},
			
            updateSchool() {
				let data = new FormData;
				data.append('name', this.school.name)
				data.append('principal_name', this.school.principal_name)
				data.append('counsellor_name', this.school.counsellor_name)
				data.append('phone', this.school.phone)
				data.append('address', this.school.address)
				data.append('lga_id', this.school.lga_id)
				data.append('school_category', this.school.school_category)

				this.$loading(true)

                axios.post('/api/school/profile/updateschool', data)
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
					this.getSchool()
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
			},
		}
    }
</script>