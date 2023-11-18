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

                        <div class="mb-2" v-if="failures.length > 0">
                            <ul>
                                <li v-for="(fail, index) in failures" :key="index" class="text-danger">
                                    There was an issue on row: {{ fail.row }}, for {{ fail.attrib }}. <span v-if="fail.errors" class="text-danger">{{ fail.errors[0] }}</span>
                                </li>
                            </ul>
                        </div>

                        <div class="mb-2">
                            <button class="btn btn-primary ml-1" @click="downloadFile">
                                <i class="icon-download3"></i> DownLoad Registration Template
                            </button>
                        </div>

						<form class="form" novalidate @submit.prevent="registerTeacher">
							<div class="form-body">

                                <div class="form-group col-md-6">
									<label for="issueinput21">Session</label>
									<select type="text" id="issueinput21" v-model="session" @change="validationErrors.session=null" :class="{'border-danger':validationErrors.session}" class="form-control" name="session" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Session" required>
										<option value="">Select Session</option>
                                        <option :value="session" v-for ="(session, index) in sessions" :key ="index">{{ session }}/{{ session+1 }}</option>
									</select>
									<span  v-if="validationErrors.session" :class="['label text-danger']">{{ validationErrors.session[0] }}</span>
								</div>

                                <div class="form-group col-md-6">
									<label for="issueinput01">Upload Batch File</label>
									<input id="upFile" type="file" @change="onFileChange" :class="{'border-danger':validationErrors.file}" ref="file" accept="xls,xlsx,csv"  class="form-control" placeholder="Registration File" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Batch File" required>
									<span v-if="validationErrors.file" :class="['label text-danger']">{{ validationErrors.file[0] }}</span>
								</div>

							</div>

							<div class="form-actions">
								<button type="button" class="btn btn-warning mr-1">
									<i class="icon-cross2"></i> Cancel
								</button>
								<button type="submit" class="btn btn-primary">
									<i class="icon-check2"></i> Register
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
            file : '',
            session : '',
            sessions : [],
            failures : '',
            errors : '',
            validationErrors: [],
        }
    },

    mounted() {
        this.getSessions()
    },

    methods: {
        getSessions() {
            for (let i = 2010; i <= 2050; i++) {
                this.sessions.push(i)
            }
        },

        onFileChange() {
            this.validationErrors.file = null

            let files = this.$refs.file.files

            if (!files.length) return
            
            this.file = files[0]
        },

        downloadFile() {
            axios({
                url: '/exceluploads/teacherBatchRegistration.xls',
                method: 'GET',
                responseType: 'blob',
            }).then((response) => {
                    var fileURL = window.URL.createObjectURL(new Blob([response.data]));
                    var fileLink = document.createElement('a');

                    fileLink.href = fileURL;
                    fileLink.setAttribute('download', 'teacherBatchRegistration.xls');
                    document.body.appendChild(fileLink);

                    fileLink.click();
            });
        },
            
        registerTeacher() {
            let data = new FormData
            data.append('file', this.file)
            data.append('session', this.session)
            
            this.$loading(true)

            axios.post('/api/school/teacher/batchregister',data)
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
                    })

                    this.session = null
                    this.file = null

                    this.failures = response.data.data.failures
                    this.errors = response.data.data.errors
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