<template>
    <div class="row match-height">
		<!-- Striped rows start -->
        <div class="row">
            <div class="col-xs-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Teacher Transfers</h4>
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
                            <div class="col-md-4">
                                <fieldset style="width:100%;" class="row py-2">
                                    <div class="input-group col-xs-12">
                                        <select v-model="lga_id" @change="getSchools" type="text" required class="form-control form-control-lg input-lg border-grey border-lighten-1 " aria-describedby="button-addon2">
                                            <option selected value="">Select LGA</option>
                                            <option  v-for="lga in lgas" :key="lga.id" :value="lga.id"> {{ lga.name }}</option>
                                        </select>
                                    </div>
                                </fieldset> 
                            </div>
                            <div class="col-md-4">
                                <fieldset style="width:100%;" class="row py-2">
                                    <div class="input-group col-xs-12">
                                        <select v-model="school_id" @change="getTeachers()" type="text" required class="form-control form-control-lg input-lg border-grey border-lighten-1 " aria-describedby="button-addon2">
                                            <option selected value="">Filter School</option>
                                        <option :value="school.id" v-for ="school in schools" :key ="school.id" >{{ school.name }}</option>
                                        </select>
                                    </div>
                                </fieldset> 
                            </div>
                            <div class="col-md-4">
                                <fieldset style="width:100%;" class="row py-2">
                                    <div class="input-group col-xs-12">
                                        <select v-model="transfer_status" @change="getTeachers()" type="text" required class="form-control form-control-lg input-lg border-grey border-lighten-1 " aria-describedby="button-addon2">
                                            <option selected value="">Filter Status</option>
                                            <option value="0">Pending</option>
                                            <option value="1">Approved</option>
                                        </select>
                                    </div>
                                </fieldset> 
                            </div>
                            <div class="col-md-12">
                                <fieldset class="row py-2">
                                    <div class="input-group col-xs-12">
                                        <input v-model="query" type="text"  required class="form-control form-control-lg input-lg border-grey border-lighten-1 " placeholder="Search By Name" aria-describedby="button-addon2">
                                        <span class="input-group-btn" id="button-addon2">
                                            <button @click="getTeachers()" class="btn btn-lg btn-success border-grey border-lighten-1" type="submit"><i class="icon-ios-search-strong"></i></button>
                                        </span>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <div v-if="pagination">
                                <button @click="getTeachers(pagination.prev)" :class="pagination.prev ? '' : 'disabled'" class="btn btn-success"> &lt;&lt;  Prev </button> {{ meta.current_page }} of {{ meta.last_page }} <button @click="getTeachers(pagination.next)" :class="pagination.next ? '' : 'disabled'" class="btn btn-success"> Next &gt;&gt;  </button>
                            </div>
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Full Name</th>
                                        <th>New Staff No.</th>
                                        <th>Old Staff No.</th>
                                        <th>Old School</th>
                                        <th>New School</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(teacher, index) in teachers" :key="index">
                                        <th scope="row">{{ index+1 }}</th>
                                        <td>
                                            {{ teacher.surname }}
                                            {{ teacher.firstname }}
                                            {{ teacher.middlename }}
                                        </td>
                                        <td>{{ teacher.new_staff_no }}</td>
                                        <td>{{ teacher.former_staff_no }}</td>
                                        <td>{{ teacher.former_school }}</td>
                                        <td>{{ teacher.new_school }}</td>
                                        <td v-if="teacher.status === 0">Pending</td>
                                        <td v-else>Approved</td>
                                        <td>
                                           <button v-if="teacher.status === 0" @click="confirmTransfer(teacher.id)" class="btn btn-primary"> Confirm Transfer </button>
                                           <button v-else-if="teacher.status === 1" class="btn btn-primary" disabled> Confirmed </button>
                                           <button v-if="teacher.status === 0" @click="deleteTransfer(teacher.id)" class="btn btn-danger"> Delete Transfer </button>
                                        </td>
                                    </tr>
                                
                                </tbody>
                            </table>
                            <div v-if="pagination">
                                <button @click="getTeachers(pagination.prev)" :class="pagination.prev ? '' : 'disabled'" class="btn btn-success"> &lt;&lt;  Prev </button> {{ meta.current_page }} of {{ meta.last_page }} <button @click="getTeachers(pagination.next)" :class="pagination.next ? '' : 'disabled'" class="btn btn-success"> Next &gt;&gt;  </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Striped rows end -->
		<FlashMessage></FlashMessage>

	</div>
	
</template>

<script>

    export default {

		data() {
			return {
                school_id : '',
                lga_id : '',
				schools : [],
                teachers :[],
                state : '',
				lgas : [],
                query : null,
                transfer_status: '',
                pagination : '',
                meta : '',
			}
        },
        
        mounted() {
            this.getState();
        },

		methods : {
            getState() {
				this.$loading(true)
				axios.get('/api/general/get_state')
				.then((res) => {
					this.state = res.data.state;
					this.lgas = res.data.data;
					this.$loading(false);
                    this.getTeachers();
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
            
			getTeachers($url = '/api/ministry/transfer/teachers-inward-outward?page=1') {
                if($url==null) return ;

                if(this.school_id != null && this.school_id != '') {
                    $url = $url + '&school_id='+this.school_id
                }

                if(this.transfer_status != null && this.transfer_status != '') {
                    $url = $url + '&transfer_status='+this.transfer_status
                }

                if(this.query != null && this.query != '') {
                    $url = $url + '?query='+this.query
                }

				this.$loading(true);
				axios.get($url)
				.then((res) => {
					this.teachers = res.data.data,
                    this.pagination = res.data.links,
                    this.meta = res.data.meta,
                    this.$loading(false)
				})
				.catch((error) => {
                    this.$loading(false);
					if (!error.response) {
						this.$alert("You do not have internet access","Network Error","error");
						return ;
					}

                    if(error.response.status === 403){
						this.$alert("Sorry, you do not have the permission to perfrom this action","No Permission","error");
					}

                    if(error.response.status === 400){
						this.$alert(error.response.data.message, "Request Error","error");
					}
				})
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

            confirmTransfer(id) {
                this.$confirm("Do you want to confirm this teacher's transfer?","Confirm Transfer",'question').then(() => {
                    let data = new FormData
                    data.append('id', id)
                
                    this.$loading(true)

                    axios.post(`/api/ministry/transfer/teacherconfirm`, data)
                    .then((res) => {
                        this.flashMessage.success({
                            title: 'Successful',
                            message: res.data.data.message,
                            time: 15000,
                            flashMessageStyle: {
                                backgroundColor: 'linear-gradient(#e66465, #9198e5)'
                            }
                        })
                        this.getTeachers()
                        this.$loading(false)
                    })
                    .catch((error) => {
                        this.$loading(false);
                        if (!error.response) {
                            this.$alert("You do not have internet access","Network Error","error");
                            return ;
                        }

                        if(error.response.status === 400) {
                            this.$loading(false)
                            this.flashMessage.error({title: 'Error', 
                                message: error.response.data.message,
                                time: 15000, })
                        }
                        
                        if(error.response.status === 401){
                            let return_url = window.location.pathname;
                            this.$router.push({
                                        name: 'ministry-login',
                                        params: { return_url: return_url }
                                        });
                        }

                        if(error.response.status === 403){
                            this.$alert("Sorry, you do not have the permission to perform this action","No Permission","error");
                        }
                    })
                })
            },

            deleteTransfer(id) {
                this.$confirm("Do you want to delete this teacher's transfer?","Delete Transfer",'question').then(() => {
                    let data = new FormData
                    data.append('id', id)
                
                    this.$loading(true)

                    axios.post(`/api/ministry/transfer/teacherdelete`, data)
                    .then((res) => {
                        this.flashMessage.success({
                            title: 'Successful',
                            message: res.data.message,
                            time: 15000,
                            flashMessageStyle: {
                                backgroundColor: 'linear-gradient(#e66465, #9198e5)'
                            }
                        });
                        this.getTeachers();
                    })
                    .catch((error) => {
                        this.$loading(false);
                        if (!error.response) {
                            this.$alert("You do not have internet access","Network Error","error");
                            return ;
                        }

                        if(error.response.status === 400) {
                            this.$loading(false)
                            this.flashMessage.error({title: 'Error', 
                                message: error.response.data.message,
                                time: 15000, })
                        }
                        
                        if(error.response.status === 401){
                            let return_url = window.location.pathname;
                            this.$router.push({
                                        name: 'ministry-login',
                                        params: { return_url: return_url }
                                        });
                        }

                        if(error.response.status === 403){
                            this.$alert("Sorry, you do not have the permission to perform this action","No Permission","error");
                        }
                    })
                })
            },
		}
    }
</script>