<template>
   <div class="row match-height">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-tooltip">Edit School </h4>
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

						<form class="form" @submit.prevent="updateSchool">
							<div class="form-body">

								<div class="form-group">
									<label for="issueinput1">Local Goverment Area</label>
									<select type="text" id="" v-model="school.lga_id" :class="{'border-danger':validationErrors.lga_id}" class="form-control" placeholder="Select State" name="state" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Local Goverment Area" required>
										<option :value="lga.id" v-for ="(lga ,index) in lgas" :key ="index" >{{ lga.name }}</option>
									</select>
									 <span  v-if="validationErrors.lga_id" :class="['label text-danger']">{{ validationErrors.lga_id[0] }}</span>
								</div>

								<div class="form-group" >
									<label for="issueinput2">School Name</label>
									<input type="text" id="" @keydown="validationErrors.school=null" :class="{'border-danger':validationErrors.school}" v-model="school.name" class="form-control" placeholder="School Name" name="school_name" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="School Name" required>
									<span  v-if="validationErrors.school" :class="['label text-danger']">{{ validationErrors.school }}</span>
								</div>


								<div class="form-group">
									<label for="issueinput8">School Address</label>
									<textarea @keydown="validationErrors.address=null" :class="{'border-danger':validationErrors.address}" v-model="school.address"  rows="5" class="form-control" name="address" placeholder="School Address" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="School Address" required></textarea>
									<span  v-if="validationErrors.address" :class="['label text-danger']">{{ validationErrors.address[0] }}</span>
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
				schoolID : this.$route.params.schoolID,
				lgas : [],
				dbSchool : [],
				school : {
					name : '',
					lga_id : '',
					address : '',
					lga_name : '',
				},
				validationErrors: [],
				
			}
		},
        mounted() {
			this.getState();
        },

		methods : {
			getState(){
				this.$loading(true)
				axios.get('/api/general/get_state')
				.then((res) => {
					this.state = res.data.state;
					this.lgas = res.data.data;
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
							name: "aeo_zeo-login",
							params: { return_url: return_url }
							});
					}
				})
			},

			getSchool(){
				this.$loading(true)
				axios.get('/api/ministry/school/primary/'+this.schoolID+'/edit')
				.then((res) => {
					this.dbSchool = res.data.data,
					this.school.name = this.dbSchool.name;
					this.school.address = this.dbSchool.address;
					this.school.lga_id = this.dbSchool.lga_id;
					this.school.lga_name = this.dbSchool.lga;
					
					this.$loading(false)
				})
				.catch((error) => {
					this.$loading(false)
					if (!error.response) {
						this.$alert("You do not have internet access","Network Error","error");
						return ;
					}

					if(error.response.status === 403){
						this.$alert("Sorry, you do not have the permission to perfrom this action","No Permission","error");
					}
				})
			},

            updateSchool(){
				let data = new FormData;
				data.append('id', this.schoolID);
				data.append('school', this.school.name);
				data.append('state_id', this.school.state_id);
				data.append('lga_id' ,this.school.lga_id);
				data.append('address' ,this.school.address);
				
				this.$loading(true)

                axios.post('/api/ministry/school/primary/'+this.schoolID+'/update',data)
				.then(response => {
                    if(response) {
						this.$loading(false);
                        this.flashMessage.success({
                            title: 'Successful',
                            message: response.data.data.message,
                            time: 15000,
                            flashMessageStyle: {
                                backgroundColor: 'linear-gradient(#e66465, #9198e5)'
                            }
                        });
						this.getSchool();
                    }
                })
				.catch(error => {
					this.$loading(false)
					if (error.response.status == 422){
						this.validationErrors = error.response.data.errors;
						this.flashMessage.error({title: 'Validation Error', 
							message: 'Their is Error with the Data you supplied',
							time: 15000, });
					}
					if(error.response.status === 403){
						this.$alert("Sorry, you do not have the permission to perfrom this action","No Permission","error");
					}
				});
            }
		}
    }
</script>
