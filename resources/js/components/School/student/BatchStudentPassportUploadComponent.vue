<template>
    <div class="row match-height">
		<div class="col-md-12 ">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-tooltip">Upload Student Passports</h4>
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

						<form class="form" novalidate @submit.prevent="uploadPassports">
							<div class="form-body">

                                <div class="form-group">
									<label for="issueinput25">Passport Photograph</label>
									<input ref="passport" type="file" @change="onPassChange" :class="{'border-danger':validationErrors.passport}" accept="image/*"  class="form-control" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Passport Photograph" multiple required>
									<span  v-if="validationErrors.passport" :class="['label text-danger']">{{ validationErrors.passport[0] }}</span>
								</div>

                                <div v-if="validationErrors && !validationErrors.passport">
                                    <ul>
                                        <li v-for="error, index in validationErrors" :key="index" class="text-danger">{{ error[0] }}</li>
                                    </ul>
                                </div>

                                <div v-if="issues">
                                    <ul>
                                        <li v-for="issue, index in issues" :key="index" class="text-danger">{{ issue }}</li>
                                    </ul>
                                </div>

                                <div class="mb-1">
                                    <span><b>Hold the <i>Ctrl</i> key to select multiple files</b></span>
                                    <br>
                                    <span>Also, ensure the names of the images correspond with the registration number of the intended student</span>
                                </div>

							</div>

							<div class="form-actions">
								<button type="button" class="btn btn-warning mr-1">
									<i class="icon-cross2"></i> Cancel
								</button>
								<button type="submit" class="btn btn-primary">
									<i class="icon-check2"></i> Upload
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
            passport : '',
            issues : '',
            validationErrors: [],
        }
    },

    mounted() {
    },

    methods: {
        onPassChange(e) {
            this.validationErrors.passport = null
            this.validationErrors = []
            this.passport = this.$refs.passport.files
        },
            
        uploadPassports() {
            let data = new FormData

            for (let i = 0; i < this.passport.length; i++) {
                data.append(`passport[${i}]`, this.passport[i])
            }

            this.$loading(true)

            axios.post('/api/school/student/passportupload', data)
            .then(response => {
                if(response) {
                    this.$loading(false)
                    this.issues = response.data.data.issues
                    this.flashMessage.success({
                        title: 'Successful',
                        message: response.data.data.message,
                        time: 15000,
                        flashMessageStyle: {
                            backgroundColor: 'linear-gradient(#e66465, #9198e5)'
                        }
                    });
                }
                
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
    },

}
</script>