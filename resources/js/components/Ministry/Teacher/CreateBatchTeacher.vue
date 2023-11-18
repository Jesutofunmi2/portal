<template>
   <div class="row match-height">
		<div class="col-md-12 ">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-tooltip">Batch Teacher Registration</h4>
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

						<form class="form" novalidate @submit.prevent="createBatch">
							<div class="form-body">
								<h4 class="form-section"><i class="icon-office"></i> School Info</h4>
								<div class="row">
									
									<div class="col-md-4">
										<div class="form-group">
											<label for="issueinput1">School State</label>
											<select  type="text" class="form-control" placeholder="Select State"  data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select State" required >
												<option value="">Select State</option>
												<option selected="selected" >{{ state }}</option>
											</select>
											
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="issueinput1">School Local Govt Area.</label>
											<select  type="text" v-model="school_lga_id" @change="getSchools()" class="form-control" placeholder="Select Loca Govt Aarea."  data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select Local Govt Area." required>
												<option selected="selected" value="">Select LGA</option>
												<option :value="lga.id" v-for ="(lga ,index) in lgas" :key ="index" >{{ lga.name }}</option>
									
											</select>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="issueinput1">School </label>
											<select  type="text" @change="validationErrors.school_id=null" v-model="school_id" class="form-control" placeholder="Select School" :class="{'border-danger':validationErrors.school_id}"  data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select School" required>
												<option value="">Select School</option>
												<option :value="school.id" v-for ="school in schools" :key ="school.id" >{{ school.name }}</option>
									
											</select>
											<span  v-if="validationErrors.school_id" :class="['label text-danger']">{{ validationErrors.school_id[0] }}</span>
										</div>
									</div>
								</div>
								<div class="row">
								
									<div class="col-md-6">
										<div class="form-group">
											<label for="projectinput1">Session</label>
											<select v-model="school_session"  @change="validationErrors.session=null" class="form-control" :class="{'border-danger':validationErrors.session}" placeholder="Session"  data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select Session" required>
												<option value="" >Select Session</option>
												<option v-for="year in session()" :key="year" :value="year">{{year}}/{{year+1}}</option>
											</select>
											<span  v-if="validationErrors.session" :class="['label text-danger']">{{ validationErrors.session[0] }}</span>
										</div>
									</div>
									
									<div class="col-md-6">
										<div class="form-group">
											<label for="projectinput1">Select  File</label>
											<input type="file" @change="onFileChange"  :class="{'border-danger':validationErrors.batch_file}" class="form-control"  data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select File" required>
											<span  v-if="fileError" :class="['label text-danger']">{{ fileError }}</span>
											<span  v-if="validationErrors.batch_file" :class="['label text-danger']">{{ validationErrors.batch_file[0] }}</span>
										</div>
									</div>
								</div>
									<div v-if="duplicacy !=null &&  duplicacy.length > 0" class="row">
									<div class="col-md-12">
										<h4>Error</h4>
									</div>
									
									<div v-for="(duplicate ,index) in duplicacy" :key="index" class="col-md-12">
										<span class="text-danger">{{index + 1}}. {{ duplicate }}</span>
									</div>
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
	components: {
		
		},
		data(){
			return {
				state : '',
				lgas : [],
				school_lga_id : null,
				state_lga : [],
				schools: [],
				school_session : '',
				school_id : '',
				validationErrors: [],
				fileError : '',
				file : '',
				duplicacy : null,
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
									name: 'ministry-login',
									params: { return_url: return_url }
									});
					}
	
				})
			},
			

            createBatch(){
				let data = new FormData;
				data.append('school_id',this.school_id);
				data.append('batch_file',this.file);
				data.append('session',this.school_session);
				if(this.fileError){
					this.$alert(this.fileError,"File Error",'error');
					return
				}
				this.$loading(true)

                axios.post('/api/ministry/school/teacher/create/batch',data)
				.then(response => {
                    if(response) {
						this.$loading(false)
						this.$alert(response.data.data.message,"Imported Successfully",'success');
						this.duplicacy = response.data.data.duplicacy;
                    }
				
                })
				.catch(error => {
					this.$loading(false)
					if (!error.response) {
						this.$alert("You do not have internet access","Network Error","error");
						return ;
					}
					if (error.response.status == 400){
						this.$alert(error.response.data.data.message,"Importing Error",'error');
						this.duplicacy = error.response.data.data.duplicacy;
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

			getSchools(){
                if(this.school_lga_id == null || this.school_lga_id=='') return ;
                this.$loading(true);
				axios.get('/api/general/school/secondary/view?lga_id='+this.school_lga_id)
				.then((res) => {
					this.schools = res.data.data.schools,
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
									name: 'ministry-login',
									params: { return_url: return_url }
									});
					}
				})
            },

			onFileChange(e) {
				this.fileError = null;
				if(this.validationErrors && this.validationErrors.batch_file != null) this.validationErrors.batch_file = null;
				
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
				
				let filename =files[0].name;
				let ext=/^.+\.([^.]+)$/.exec(filename);
				ext == null ? "" :ext[1];
				let extn=['xls','xlsx','csv'];
				if(extn.includes(ext[1])){
      				let max=5242880;

					if(files[0].size > max) {
						this.fileError = "File size too large, Maximum of 5MB";
						this.$alert(this.fileError,"File Error",'error');
					}
					
					this.file = files[0];
    			}
				else{
					this.fileError = "Invalid File, Only Excel file is allowed (csv, xls, xlsx)";
					this.$alert(this.fileError,"File Error",'error');
				}
                
            },

			session(){
				const d = new Date();
				const n = d.getFullYear();
				const year = [];
				for (let index = 2010; index <= n; index++) {
					year.push(index);
				}
				return year;
			}

		}
    }
</script>