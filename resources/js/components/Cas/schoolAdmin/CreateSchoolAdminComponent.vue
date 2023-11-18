<template>
   <div class="row match-height">
		<div class="col-md-12 ">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-tooltip">Create School Admin</h4>
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

						<form class="form" novalidate @submit.prevent="createSchoolAdmin">
							<div class="form-body">

								<div class="form-group">
									<label for="issueinput1">State</label>
									<select  type="text" v-model="admin.state_id" class="form-control" placeholder="Select State"  data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select State" required>
										<option selected="selected" >{{ state }}</option>
									</select>

								</div>

								<div class="form-group">
									<label for="issueinput1">Local Goverment Area</label>
									<select type="text" id="" v-model="admin.lga_id" @change="getSchools()" :class="{'border-danger':validationErrors.lga_id}" class="form-control" placeholder="Select State" name="state" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Local Goverment Area" required>
										<option value="">Select LGA</option>
										<option :value="lga.id" v-for ="(lga ,index) in lgas" :key ="index" >{{ lga.name }}</option>
									</select>
									 <span  v-if="validationErrors.lga_id" :class="['label text-danger']">{{ validationErrors.lga_id[0] }}</span>
								</div>

								<div class="form-group">
									<label for="issueinput1">School</label>
									<select type="text" id="" v-model="admin.school_id" @change="validationErrors.school=null" :class="{'border-danger':validationErrors.school_id}" class="form-control" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select School" required>
										<option value="">Select School</option>
										<option :value="school.id" v-for ="school in schools" :key ="school.id" >{{ school.name }}</option>
									</select>
									 <span  v-if="validationErrors.school" :class="['label text-danger']">{{ validationErrors.school[0] }}</span>
								</div>


								<div class="form-group">
									<label for="issueinput8">Full Name</label>
									<input type="text" @keydown="validationErrors.fullname=null" :class="{'border-danger':validationErrors.fullname}" v-model="admin.fullname" class="form-control"  placeholder="Enter Full Name" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Enter Full Name">
									<span  v-if="validationErrors.fullname" :class="['label text-danger']">{{ validationErrors.fullname[0] }}</span>
								</div>

								<div class="form-group">
									<label for="issueinput8">Email</label>
									<input type="email" @keydown="validationErrors.email=null" :class="{'border-danger':validationErrors.email}" v-model="admin.email" class="form-control"  placeholder="Enter Email" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Enter Email">
									<span  v-if="validationErrors.email" :class="['label text-danger']">{{ validationErrors.email[0] }}</span>
								</div>

								<div class="form-group">
									<label for="issueinput8">Username</label>
									<input type="text" @keydown="validationErrors.username=null" :class="{'border-danger':validationErrors.username}" v-model="admin.username" class="form-control"  placeholder="Enter Username" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Enter Username">
									<span  v-if="validationErrors.username" :class="['label text-danger']">{{ validationErrors.username[0] }}</span>
								</div>

								<div class="form-group">
									<label for="issueinput8">Phone</label>
									<input type="text" @keydown="validationErrors.phone=null" :class="{'border-danger':validationErrors.phone}" v-model="admin.phone" class="form-control"  placeholder="Enter Phone Number" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Enter Phone Number">
									<span  v-if="validationErrors.phone" :class="['label text-danger']">{{ validationErrors.phone[0] }}</span>
								</div>

								<div class="form-group">
									<label for="issueinput8">Password</label>
									<input type="password" @keydown="validationErrors.password=null" :class="{'border-danger':validationErrors.password}" v-model="admin.password" class="form-control"  placeholder="Enter Password" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Enter Password">
									<span  v-if="validationErrors.password" :class="['label text-danger']">{{ validationErrors.password[0] }}</span>
								</div>

								<div class="form-group">
									<label for="issueinput8">Confirm Password</label>
									<input type="password" @keydown="validationErrors.password_confirmation=null" :class="{'border-danger':validationErrors.password_confirmation}" v-model="admin.password_confirmation" class="form-control"  placeholder="Confirm Password" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Confirm Password">
									<span  v-if="validationErrors.password_confirmation" :class="['label text-danger']">{{ validationErrors.password_confirmation[0] }}</span>
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
				state : '',
				lgas : [],
				schools: [],
				admin : {
					state_id : '',
					lga_id : '',
					school_id : '',
					fullname : '',
					username : '',
					phone : '',
					password : '',
					password_confirmation :'',
				},
				validationErrors: [],
				
			}
		},
        mounted() {
			this.getState()
        },

		methods : {
			getState(){
				this.$loading(true)
				axios.get('/api/general/get_state')
				.then((res) => {
					this.state = res.data.state,
					this.lgas = res.data.data
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
									name: 'cas-login',
									params: { return_url: return_url }
									});
					}
	
				})
			},

			
            createSchoolAdmin(){
				let data = new FormData;
				data.append('fullname', this.admin.fullname);
				data.append('username', this.admin.username);
				data.append('email', this.admin.email);
				data.append('phone', this.admin.phone);
				data.append('school', this.admin.school_id);
				data.append('password', this.admin.password);
				data.append('password_confirmation', this.admin.password_confirmation);
				
				this.$loading(true)

                axios.post('/api/ministry/school/admin/create',data)
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
					this.admin.fullname = null;
					this.admin.username = null;
					this.admin.email = null;
					this.admin.phone = null;
					this.admin.school_id = null;
					this.admin.password = null;
					this.admin.password_confirmation = null;
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

			getSchools(){
                if(this.admin.lga_id == null || this.admin.lga_id=='') return ;
                this.$loading(true);
				axios.get('/api/ministry/school/secondary/view?lga_id='+this.admin.lga_id)
				.then((res) => {
					this.schools = res.data.data,
					this.$loading(false)
				})
				.catch((error) => {
                    this.$loading(false)
                    if (!error.response) {
						this.$alert("You do not have internet access","Network Error","error");this.$router.go(-1) ;
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

		}
    }
</script>
