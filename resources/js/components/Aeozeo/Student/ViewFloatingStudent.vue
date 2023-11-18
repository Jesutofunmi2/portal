<template>
   <div class="row match-height">
		<!-- Striped rows start -->
<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Search Floating Student</h4>
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
                <div class="card-block card-dashboard row">
                  
                   <div class="col-md-3"> 
                        <fieldset style="width:100%;" class="row py-2">
                            <div class="input-group col-xs-12">
                                <select class="form-control form-control-lg input-lg border-grey border-lighten-1 " aria-describedby="button-addon2">
                                    <option selected value="">{{ state }}</option>
                                </select>
                            </div>
                        </fieldset>
                   </div>
                   <div class="col-md-3">
                        <fieldset style="width:100%;" class="row py-2">
                            <div class="input-group col-xs-12">
                                <select v-model="lga_id" @change="getSchools" type="text" required class="form-control form-control-lg input-lg border-grey border-lighten-1 " aria-describedby="button-addon2">
                                    <option selected value="">Select LGA</option>
                                    <option  v-for="lga in lgas" :key="lga.id" :value="lga.id"> {{ lga.name }}</option>
                                </select>
                            </div>
                        </fieldset> 
                   </div>
                   <div class="col-md-3">
                        <fieldset style="width:100%;" class="row py-2">
                            <div class="input-group col-xs-12">
                                <select  type="text" v-model="school_id" class="form-control form-control-lg input-lg border-grey border-lighten-1" placeholder="Select School" :class="{'border-danger':validationErrors.school_id}"  data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select School" required>
                                    <option value="">Select School</option>
                                    <option :value="school.id" v-for ="school in schools" :key ="school.id" >{{ school.name }}</option>
                        
                                </select>
                                <span  v-if="validationErrors.school_id" :class="['label text-danger']">{{ validationErrors.school_id[0] }}</span>
                            </div>
                        </fieldset> 
                   </div>
                   
                   <div class="col-md-3">
                        <fieldset style="width:100%;" class="row py-2">
                            <div class="input-group col-xs-12">
                                <button style="width:100%; background:#FF8C00; color:#fff;" class="btn btn-lg" @click="getStudents()">Fetch</button>
                            </div>
                        </fieldset> 
                   </div>
                </div>
               
                <div class="table-responsive">
                     <h4>Student Personal Information</h4>
                     <div>
                         <div v-if="pagination" style="float:left;">
                          <button @click="getStudents(meta.current_page-1)" :class="pagination.prev ? '' : 'disabled'" class="btn btn-success"> &lt;&lt;  Prev </button> {{ meta.current_page }} of {{ meta.last_page }} <button @click="getStudents(meta.current_page+1)" :class="pagination.next ? '' : 'disabled'" class="btn btn-success"> Next &gt;&gt;  </button>
                        </div>
                        <div v-if="students" style="float:right;">
                            <button @click="getClass()" class="btn btn-success"> Assign Class </button>
                        </div>
                     </div>
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th v-if="students">Select All <input type="checkbox" @change="toggleAll()"></th>
                                <th>Student's Fullname</th>
                                <th>OSSI Number</th>
                                <th>Gender</th>
                                <th>Action</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody >

                            <tr v-for="(student , index) in students" :key="index">
                                <th scope="row">{{ index+1 }}</th>
                                <td><input type="checkbox" @change="toggleId(student.id)" :id="student.id"></td>
                                <td>{{ student.fullname }}</td>
                                <td>{{ student.ossi }}</td>
                                <td><strong>{{ student.gender }}</strong></td>
                                <td>
                                    <button @click="editStudent(student.id)"  class="btn btn-primary"><i class="icon-edit"></i> Edit </button>
                                </td>
                                 <td>
                                   <button @click="deleteStudent(student.id)"  class="btn btn-danger"><i class="icon-trash4"></i> Delete</button>
                                </td>
                            </tr>
                            <tr v-if="students != null && students.length==0">
                                <td colspan="8"> No Student Found</td>
                            </tr>
                            <tr v-if="students == null">
                                    <td colspan="8"> Please select all required field to get students </td>
                            </tr>
                        </tbody>
                    </table>
                   
                     <div v-if="pagination">
                          <button @click="getStudents(meta.current_page-1)" :class="pagination.prev ? '' : 'disabled'" class="btn btn-success"> &lt;&lt;  Prev </button> {{ meta.current_page }} of {{ meta.last_page }} <button @click="getStudents(meta.current_page+1)" :class="pagination.next ? '' : 'disabled'" class="btn btn-success"> Next &gt;&gt;  </button>
                      </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
        <Modal v-model="showModal" title="Student Details"  @close="showModal = false">
            <div v-if="classes != null">
                
                <div class="row">
                        <div class="col-md-6">
                        <fieldset style="width:100%;" class="row py-2">
                            <div class="input-group col-xs-12">
                                <select v-model="class_data.class_id"  @change="getClassArms()" class="form-control form-control-lg input-lg border-grey border-lighten-1" :class="{'border-danger':validationErrors.class_id}"  data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select Class" required>
                                    <option :value="null" >Select Class</option>
                                    <option :value="clas.id" v-for ="clas in classes" :key ="clas.id" >{{ clas.class_name }}</option>
                                </select>
                                <span  v-if="validationErrors.class_id" :class="['label text-danger']">{{ validationErrors.class_id[0] }}</span>
                            </div>
                        </fieldset> 
                   </div>
                    <div class="col-md-6">
                        <fieldset style="width:100%;" class="row py-2">
                            <div class="input-group col-xs-12">
                                <select v-model="class_data.class_arm_id" @change="validationErrors.class_arm_id = null" class="form-control form-control-lg input-lg border-grey border-lighten-1" :class="{'border-danger':validationErrors.class_arm_id}"  data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select Class Arm" required>
                                    <option :value="null" >Select Class Arm</option>
                                    <option :value="class_arm.id" v-for ="class_arm in class_arms" :key ="class_arm.id" >{{ class_arm.class_arm }}</option>
                                </select>
                                <span  v-if="validationErrors.class_arm_id" :class="['label text-danger']">{{ validationErrors.class_arm_id[0] }}</span> <br>
                                <span class="label" id="msg" ></span>
                            </div>
                        </fieldset> 
                   </div>
                   <div class="col-md-6">
                        <fieldset style="width:100%;" class="row py-2">
                            <div class="input-group col-xs-12">
                                <select v-model="class_data.session"  @change="validationErrors.session=null" class="form-control form-control-lg input-lg border-grey border-lighten-1" :class="{'border-danger':validationErrors.session}" placeholder="Session"  data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select Session" required>
                                    <option :value="null" >Select Session</option>
                                    <option v-for="year in session()" :key="year" :value="year">{{year}}/{{year+1}}</option>
                                </select>
                                <span  v-if="validationErrors.session" :class="['label text-danger']">{{ validationErrors.session[0] }}</span>
                            </div>
                        </fieldset> 
                   </div>
                   <div class="col-md-6">
                        <fieldset style="width:100%;" class="row py-2">
                            <div class="input-group col-xs-12">
                               <select v-model="class_data.term" @change="validationErrors.term=null" class="form-control form-control-lg input-lg border-grey border-lighten-1" :class="{'border-danger':validationErrors.term}" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select Term" required>
                                    <option selected :value="null">Select Term</option>
                                    <option value="First">First Term</option>
                                    <option value="Second">Second Term</option>
                                    <option value="Third">Third Term</option>
                                </select>
                                <span  v-if="validationErrors.term" :class="['label text-danger']">{{ validationErrors.term[0] }}</span>
                            </div>
                        </fieldset> 
                   </div>
                        
                </div>
                <hr>
                <fieldset style="width:100%;" class="row py-2">
                    <div class="input-group col-xs-12">
                        <button style="width:100%; background:#FF8C00; color:#fff;" class="btn btn-lg" @click="updateStudent()" id="update">Update</button>
                    </div>
                </fieldset> 

            </div>
            <div v-else>
                <h3> Loading... </h3>
            </div>
        </Modal>
<!-- Striped rows end -->
		<FlashMessage></FlashMessage>

	</div>
	
</template>

<script>

    export default {

		data(){
			return {
                school_id : '',
                lga_id : '',
				schools : [],
                students : null,
                state : '',
				lgas : [],
                pagination : '',
                meta : '',
                validationErrors: [],
                student_data : null,
                checked_all : false,
                classes : null,
                class_arms : null,
                class_data : {
                    ids: [],
                    class_id : null,
                    class_arm_id : null,
                    session : null,
                    term : null,
                },
                showModal : false,
            }
		},
        mounted() {
            this.getState();
        },

		methods : {
			
            getStudents(page = 1){
                if(this.meta && (page > this.meta.last_page || page == 0)  ) return ;
                
				this.$loading(true);
				axios.get('/api/ministry/student/floating?school_id='+this.school_id+'&page='+page)
				.then((res) => {
					this.students = res.data.data,
                    this.pagination = res.data.links,
                    this.meta = res.data.meta,
					this.$loading(false)
				})
				.catch((error) => {
                    this.$loading(false);
					if (!error.response) {
						this.$alert("You do not have internet access or Unknown Error","Network Error","error");
						return ;
					}

                    if(error.response.status === 403){
						this.$alert("Sorry, you do not have the permission to perfrom this action","No Permission","error");
					}
                    if(error.response.status === 401){
						let return_url = window.location.pathname;
						this.$router.push({
									name: "aeo_zeo-login",
									params: { return_url: return_url }
									});
					}
                    if (error.response.status == 422){
					this.validationErrors = error.response.data.errors;
					this.flashMessage.error({title: 'Validation Error', 
											message: 'Their is Error with the Data you supplied',
											time: 15000, });
					}
				})
			},
            
            editStudent(id){
                this.$confirm("Are you sure you want to edit student?","Edit Student",'question').then(() => {
                this.$router.push({
                        name: 'ministry-edit-student',
                        params: { studentId: id }
                        });
                });
            },

            deleteStudent(id){
                this.$confirm("Are you sure you want to delete student?","Delete student",'warning').then(() => {
                this.$loading(true)
                axios.delete('/api/ministry/student/'+id+'/delete')
                .then((response) => {
                    this.$loading(false);
                    this.$alert(response.data.data.message,"Successful","success");
                    this.getStudents();
				})
				.catch((error) => {
                    this.$loading(false);
					if (!error.response) {
						this.$alert("You do not have internet access or Unknown Error","Network Error","error");
						return ;
					}

                    if(error.response.status === 403){
						this.$alert("Sorry, you do not have the permission to perfrom this action","No Permission","error");
					}
                    if(error.response.status === 401){
						let return_url = window.location.pathname;
						this.$router.push({
									name: "aeo_zeo-login",
									params: { return_url: return_url }
									});
					}
				})
                });
            },

            getSchools(){
                if(this.lga_id == null || this.lga_id=='') return ;
                this.$loading(true);
				axios.get('/api/general/school/secondary/view?lga_id='+this.lga_id)
				.then((res) => {
					this.schools = res.data.data.schools,
					this.$loading(false)
				})
				.catch((error) => {
                    this.$loading(false)
                    if (!error.response) {
						this.$alert("You do not have internet access or Unknown Error","Network Error","error");this.$router.go(-1) ;
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
						this.$alert("You do not have internet access or Unknown Error","Network Error","error");
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

            updateStudent() {
                if(this.class_data.ids.length == 0) return ;

                document.getElementById('update').innerHTML = 'Loading...';
                
				axios.post('/api/ministry/student/floating/update', this.class_data)
				.then((res) => {
					
                    this.getStudents(this.meta.current_page);
                    document.getElementById('update').innerHTML = 'Update';
                    this.class_data.ids = [];
                    this.students.forEach(student => {
                        document.getElementById(student.id).checked = false;
                    });

                    this.showModal = false,
                    this.flashMessage.success({title: 'Successful', 
											message: 'Gender updated successfully',
											time: 15000, });
                    
				})
				.catch((error) => {
                    document.getElementById('update').innerHTML = 'Update';
                    this.$loading(false);
					if (!error.response) {
						this.$alert("You do not have internet access or Unknown Error","Network Error","error");
						return ;
					}

                    if(error.response.status === 403){
						this.$alert("Sorry, you do not have the permission to perfrom this action","No Permission","error");
					}
                    if(error.response.status === 401){
						let return_url = window.location.pathname;
						this.$router.push({
									name: "aeo_zeo-login",
									params: { return_url: return_url }
									});
					}
                    if (error.response.status == 422){
					this.validationErrors = error.response.data.errors;
					this.flashMessage.error({title: 'Validation Error', 
											message: 'Their is Error with the Data you supplied',
											time: 15000, });
					}
				})
            },

            toggleId(id) {
                let index = null;
                this.class_data.ids.forEach(element => {
                    if (element == id) {
                        index = this.class_data.ids.indexOf(element);
                        this.class_data.ids.splice(index, 1);
                    } 
                });
                if (index == null) this.class_data.ids.push(id);
            },

            toggleAll() {
                this.class_data.ids = [];
                if (this.checked_all == false) {

                    this.students.forEach(student => {
                        this.class_data.ids.push(student.id);
                        document.getElementById(student.id).checked = true;
                    });
                    
                    this.checked_all = true;
                } 
                else {

                    this.students.forEach(student => {
                        document.getElementById(student.id).checked = false;
                    });
                    
                    this.checked_all = false;
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
			},

            getClass(){
				if(this.validationErrors && this.validationErrors.school_id!=null) this.validationErrors.school_id=null;
				if(this.school_id == null || this.school_id =='') return ;

                if(this.class_data.ids.length == 0) return ;

                this.showModal = true;

				axios.get('/api/general/school/getClasses/'+this.school_id)
				.then((res) => {
					this.classes = res.data.data.classes;
				})
				.catch((error) => {
                    if (!error.response) {
						this.$alert("You do not have internet access or Unknown Error","Network Error","error");
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

			getClassArms() {
				if(this.validationErrors && this.validationErrors.class_id !=null ) this.validationErrors.class_id = null;
				if(this.class_data.class_id == null || this.class_data.class_id == '') return ;

                let msg = document.getElementById('msg');
                msg.innerHTML = "loading... class arms";

				axios.get('/api/general/school/getClassArms/'+this.class_data.class_id)
				.then((res) => {
					this.class_arms = res.data.data.class_arms;
                    msg.innerHTML = '';
				})
				.catch((error) => {
                    this.$loading(false)
                    if (!error.response) {
						this.$alert("You do not have internet access or Unknown Error","Network Error","error");
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
			}

		}
    }
</script>
