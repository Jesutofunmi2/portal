<template>
    <div class="row match-height">
		<div class="col-md-12 ">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-tooltip">Batch Upload Results</h4>
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

                        <div class="mb-2">
                            <button class="btn btn-primary ml-1" @click="downloadFile">
                                <i class="icon-download3"></i> DownLoad Results Template
                            </button>
                        </div>

						<form class="form" novalidate @submit.prevent="uploadResults">
							<div class="form-body">

                                <div class="form-group col-md-6">
									<label for="issueinput21">Session</label>
									<select type="text" id="issueinput21" v-model="session" @change="getClass" :class="{'border-danger':validationErrors.session}" class="form-control" name="session" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Session" required>
										<option value="">Select Session</option>
                                        <option :value="session" v-for ="(session, index) in sessions" :key ="index">{{ session }}/{{ session+1 }}</option>
									</select>
									<span  v-if="validationErrors.session" :class="['label text-danger']">{{ validationErrors.session[0] }}</span>
								</div>

                                <div class="form-group col-md-6">
									<label for="issueinput22">Term</label>
									<select type="text" id="issueinput22" v-model="term" @change="validationErrors.term=null" :class="{'border-danger':validationErrors.term}" class="form-control" name="term" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Term" required>
										<option value="">Select Term</option>
										<option value="First">First</option>
                                        <option value="Second">Second</option>
                                        <option value="Third">Third</option>
									</select>
									<span  v-if="validationErrors.term" :class="['label text-danger']">{{ validationErrors.term[0] }}</span>
								</div>

                                <div class="form-group col-md-12">
                                    <label for="issueinput1">Available Class & Arms</label>
                                    <select id="issueinput1" v-model="selected_class_arms" @change="classChange()" class="form-control" name="class_id" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Class" required>
                                        <option :value="null">Select Class arms</option>
                                        <option :value="class_arm" v-for ="(class_arm, index) in class_arms_list" :key ="index" >{{ class_arm.class_name }} {{ class_arm.class_arm }}</option>
                                    </select>
                                   
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="issueinput19">Class</label>
                                    <select id="issueinput19" v-model="class_id" :class="{'border-danger':validationErrors.class_id}" class="form-control" name="class_id" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Class" readonly required>
                                        <option :value="class_id">{{ class_name }}</option>
                                    </select>
                                    <span  v-if="validationErrors.class_id" :class="['label text-danger']">{{ validationErrors.class_id[0] }}</span>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="issueinput20">Class Arm</label>
                                    <select id="issueinput20" v-model="classarm_id" :class="{'border-danger':validationErrors.classarm_id}" class="form-control" name="classarm_id" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Class Arm" readonly required>
                                        <option :value="classarm_id">{{ class_arm }}</option>
                                    </select>
                                    <span  v-if="validationErrors.classarm_id" :class="['label text-danger']">{{ validationErrors.classarm_id[0] }}</span>
                                </div>

                                <div class="form-group">
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
									<i class="icon-check2"></i> Upload
								</button>
							</div>
						</form>

                        <div v-for="(fail, index) in failures" :key="index" class="text-danger">
                            <span v-if="fail.row">
                                There was an issue on row: {{ fail.row }}, for {{ fail.attrib }}.
                            </span> <span v-if="fail.errors" class="text-danger">{{ fail.errors[0] }}</span>
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
    
    data() {
        return {
            file : '',
            session : '',
            term : '',
            class_id : '',
            classarm_id : '',
            sessions : [],
            class_arm : '',
            class_name : '',
            class_arms_list : '',
            selected_class_arms : null,
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

        getClass() {
            this.validationErrors.session = null
            this.$loading(true)
            axios.get(`/api/teacher/class/${this.session}`)
            .then((res) => {
                if(res.data.data && res.data.data.length > 0) {
                    this.class_arms_list = res.data.data
                }
                else {
                     this.flashMessage.error({title: 'Error', 
                        message: 'No data retrived',
                        time: 15000, });
                }

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
                                name: 'teacher-login',
                                params: { return_url: return_url }
                                });
                }

            })
        },

        classChange() {
            if (this.selected_class_arms == null)
            {
                this.class_id = "";
                this.classarm_id = "";
                this.class_name = "";
                this.class_arm = "";
            }

            this.class_id = this.selected_class_arms.class_id;
            this.classarm_id = this.selected_class_arms.classarm_id;
            this.class_name = this.selected_class_arms.class_name;
            this.class_arm = this.selected_class_arms.class_arm;
        },

        onFileChange() {
            this.validationErrors.file = null

            let files = this.$refs.file.files

            if (!files.length) return
            
            this.file = files[0]
        },

        downloadFile() {
            if (!this.session || !this.class_id || !this.classarm_id || !this.term) {
                this.flashMessage.error({title: 'Incomplete Data Supplied', 
                        message: 'Please select a Class, a Class Arm, a Session, and a Term',
                        time: 15000, });
            } else {
                const params = new URLSearchParams();
                params.append('class_id', this.class_id);
                params.append('classarm_id', this.classarm_id);
                params.append('session', this.session);
                params.append('term', this.term);

                this.$loading(true);

                axios({
                    url: '/api/teacher/result/downloadtemplate',
                    method: 'GET',
                    params: params,
                    responseType: 'blob',
                }).then((response) => {
                        this.$loading(false);
                        let fileURL = window.URL.createObjectURL(new Blob([response.data]));
                        let fileLink = document.createElement('a');
                        let fileName = `student_result_all_subject_${this.class_name}.xls`

                        fileLink.href = fileURL;
                        fileLink.setAttribute('download', fileName);
                        document.body.appendChild(fileLink);

                        fileLink.click();

                });
            }
        },
            
        uploadResults() {
            let data = new FormData
            data.append('file', this.file)
            data.append('class_id', this.class_id)
            data.append('classarm_id', this.classarm_id)
            data.append('session', this.session)
            data.append('term', this.term)
            
            this.$loading(true)

            axios.post('/api/teacher/result/uploadall',data)
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

                    this.class_id = ''
                    this.classarm_id = ''
                    this.class_name = ''
                    this.class_arm = ''
                    this.session = ''
                    this.term = ''
                    this.file = ''

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