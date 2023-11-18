<template>
   <div class="row match-height">
		<!-- Striped rows start -->
<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Payment Receipt | Search Student</h4>
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
                                <select v-model="s_session"  @change="validationErrors.session=null" class="form-control form-control-lg input-lg border-grey border-lighten-1" :class="{'border-danger':validationErrors.session}" placeholder="Session"  data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select Session" required>
                                    <option value="" >Select Session</option>
                                    <option v-for="year in session()" :key="year" :value="year">{{year}}/{{year+1}}</option>
                                </select>
                                <span  v-if="validationErrors.session" :class="['label text-danger']">{{ validationErrors.session[0] }}</span>
                            </div>
                        </fieldset> 
                   </div>
                   
                    <div class="col-md-3">
                        <fieldset style="width:100%;" class="row py-2">
                            <div class="input-group col-xs-12">
                                <select v-model="class_id"  @change="getClassArms()" class="form-control form-control-lg input-lg border-grey border-lighten-1" :class="{'border-danger':validationErrors.class_id}"  data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select Class" required>
                                    <option value="" >Select Class</option>
                                    <option :value="clas.id" v-for ="clas in classes" :key ="clas.id" >{{ clas.class_name }}</option>
                                </select>
                                <span  v-if="validationErrors.class_id" :class="['label text-danger']">{{ validationErrors.class_id[0] }}</span>
                            </div>
                        </fieldset> 
                   </div>
                    <div class="col-md-3">
                        <fieldset style="width:100%;" class="row py-2">
                            <div class="input-group col-xs-12">
                                <select v-model="class_arm_id" class="form-control form-control-lg input-lg border-grey border-lighten-1" @change="getStudents()" :class="{'border-danger':validationErrors.class_arm_id}"  data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select Class Arm" required>
                                    <option value="" >Select Class Arm</option>
                                    <option :value="class_arm.id" v-for ="class_arm in class_arms" :key ="class_arm.id" >{{ class_arm.class_arm }}</option>
                                </select>
                                <span  v-if="validationErrors.class_arm_id" :class="['label text-danger']">{{ validationErrors.class_arm_id[0] }}</span>
                            </div>
                        </fieldset> 
                   </div>
                   <div class="col-md-3" style="padding:0px; margin:0px;">
                        <fieldset style="width:100%;" class="row py-2">
                            <div class="input-group col-xs-12">
                                <button style="background:#FF8C00; color:#fff;" class="btn btn-lg" @click="getStudents()">Fetch</button>
                            </div>
                        </fieldset> 
                   </div>
                   
                </div>
               
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th v-if="students">
                                    <label class="toggle-control">
                                        <input @click="toggleAll()" type="checkbox" :checked ="check_all">
                                    <span class="control"></span>
                                  </label>
                                </th>
                                <th>#</th>
                                <th>Student's Fullname</th>
                                <th>OSSI Number</th>
                                <th>Passport</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody >

                            <tr v-for="(student , index) in students" :key="index">
                                <td>
                                    <span v-if="student.is_verified">
                                        <label class="toggle-control">
                                
                                            <input @click="toggleId(student.id)"  type="checkbox" :id="student.id">
                                            <span class="control"></span>
                                        </label>
                                    </span>
                                </td>
                                <th scope="row">{{ index+1 }}</th>
                                <td>{{ student.surname }} {{ student.firstname }} {{ student.middlename }}</td>
                                <td>{{ student.regnum }}</td>
                                <td><img alt="" style="max-height:100px; max-width:100px;" :src="baseUrl+student.passport"></td>
                                <td>
                                    <button  v-if="student.is_verified" class="btn btn-success" @click="printReceipt(student.id)"><i class="icon-check"></i> Print Receipt </button>
                                    <span v-else class="text-danger"> <strong>No Payment</strong> </span>
                                    
                                </td>
                                
                            </tr>
                            <tr v-if="students != null && students.length == 0">
                                <td colspan="6"> No Student Found</td>
                            </tr>
                            <tr v-if="students == null">
                                    <td colspan="6"> Please select all required field to get students </td>
                            </tr>
                            <tr v-if="ids && ids.length > 0">
                                <td colspan="6">
                                    <button class="btn btn-success" @click="printBulkReceipt()">Print Payment Receipt</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                   
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

		data(){
			return {
                students : null,
                classes :[],
                class_id : '',
                class_arms: [],
                class_arm_id:'',
                s_session:'',
                validationErrors: [],
                baseUrl:  '/public',
                check_all : false,
                ids : [],
			}
		},
        mounted() {
            this.getClasses();
        },

		methods : {
			
            getStudents(page = 1) {
                
                if(this.validationErrors && this.validationErrors.class_arm_id) this.validationErrors.class_arm_id = null;

                if(this.meta && (page > this.meta.last_page || page == 0)  ) return ;

                this.students = null;
                
				this.$loading(true);
				axios.get('/api/school/class-wallet/students?class_arm_id='+this.class_arm_id+'&class_id='+this.class_id+'&session='+this.s_session+'&page='+page)
				.then((res) => {
					this.students = res.data.data,
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
									name: 'school-login',
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
            
            session(){
				const d = new Date();
				const n = d.getFullYear();
				const year = [];
				for (let index = 2010; index <= n; index++) {
					year.push(index);
				}
				return year;
			},

           
            getClasses() {
                this.students = null;
                this.$loading(true);
                
                axios.get('/api/school/class/view/all')
                .then((res) => {
                    this.classes = res.data.data;
                    this.$loading(false);

                })
                .catch((error) => {
                    this.$loading(false)
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

                })
            },
            
			getClassArms() {
				if(this.validationErrors && this.validationErrors.class_id!=null) this.validationErrors.class_id=null;
				if(this.class_id == null || this.class_id=='') return ;
                this.$loading(true);
                this.students = null;
				axios.get('/api/general/school/getClassArms/'+this.class_id)
				.then((res) => {
					this.class_arms = res.data.data.class_arms;
					this.$loading(false);

                    if(this.classes && this.classes.length > 0) {
                        this.classes.forEach( a => {
                            if(a.id == this.class_id) this.className = a.class_name;
                        });
                    }

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
									name: 'school-login',
									params: { return_url: return_url }
									});
					}
				})
			},

            printReceipt(id) {
                if(this.class_id == null || this.class_id=='') return ;
                if(this.s_session == null || this.s_session=='') return ;
                if(this.class_arm_id == null || this.class_arm_id=='') return ;

                this.$loading(true);
				axios.post('/api/school/class-wallet/payment-receipt', {
                                        student_id : id, 
                                        class_id : this.class_id,
                                        session : this.s_session,
                                        class_arm_id : this.class_arm_id
                                        })
				.then((res) => {
                   if(res.data.data.status == true) {
                       //this.$alert(res.data.data.message, "Success","success");
                       window.open('/admin/school/class-wallet/payment-receipt?class_arm_id='+this.class_arm_id+'&student_id='+id+'&class_id='+this.class_id+'&session='+this.s_session+'&type='+1, 
                       '_blank');
                   }
                   else {
                    this.$alert(res.data.data.message, "Error","error");
                   }
					this.$loading(false);
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
									name: 'school-login',
									params: { return_url: return_url }
									});
					}

                    if(error.response.status === 400){
						this.$alert(error.response.data.message, "Request Error","error");
					}
				})
            },

            toggleId(id) {
                let index = null;
                this.ids.forEach(element => {
                    if (element == id) {
                        index = this.ids.indexOf(element);
                        this.ids.splice(index, 1);
                    } 
                });
                if (index == null) this.ids.push(id);
            },

            toggleAll() {
                this.ids = [];
                if (this.check_all == false) {

                    this.students.forEach(student => {
                        if(student.is_verified) {
                            this.ids.push(student.id);
                            document.getElementById(student.id).checked = true;
                        }
                    });
                    
                    this.check_all = true;
                } 
                else {
                    this.uncheckAll();
                }
            },

            uncheckAll() {
                if(this.students != null && this.students.length > 0) {
                    this.students.forEach(student => {
                        if(student.is_verified) {
                            document.getElementById(student.id).checked = false;
                        }
                    });
                }
                this.check_all = false;
                this.ids = [];
            },

            printBulkReceipt() {
                if(this.class_id == null || this.class_id=='') return ;
                if(this.s_session == null || this.s_session=='') return ;
                if(this.class_arm_id == null || this.class_arm_id=='') return ;
                if(this.ids.length < 1) return ;

                 window.open('/admin/school/class-wallet/payment-receipt/bulk?class_arm_id='+this.class_arm_id+'&ids='+this.ids+'&class_id='+this.class_id+'&session='+this.s_session, 
                       '_blank');
            }
		}
    }
</script>
<style lang="scss" scoped>
$toggle-background-color-on: dodger#45b6fe;
$toggle-background-color-off: darkgray;
$toggle-control-color: white;
$toggle-width: 50px;
$toggle-height: 25px;
$toggle-gutter: 5px;
$toggle-radius: 50%;
$toggle-control-speed: .15s;
$toggle-control-ease: ease-in;

// These are our computed letiables
// change at your own risk.
$toggle-radius: $toggle-height / 2;
$toggle-control-size: $toggle-height - ($toggle-gutter * 2);

.toggle-control {
  display: block;
  position: relative;
  padding-left: $toggle-width;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 22px;
  user-select: none;

  input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
    height: 0;
    width: 0;
  }

  input:checked ~ .control {
    background-color: $toggle-background-color-on;
    
    &:after {
      left: $toggle-width - $toggle-control-size - $toggle-gutter;
    }
  }

  .control {
    position: absolute;
    top: 0;
    left: 0;
    height: $toggle-height;
    width: $toggle-width;
    border-radius: $toggle-radius;
    background-color: $toggle-background-color-off;
    transition: background-color $toggle-control-speed $toggle-control-ease;

    &:after {
      content: "";
      position: absolute;
      left: $toggle-gutter;
      top: $toggle-gutter;
      width: $toggle-control-size;
      height: $toggle-control-size;
      border-radius: $toggle-radius;
      background: $toggle-control-color;
      transition: left $toggle-control-speed $toggle-control-ease;
    }
  }
}
.scontainer {  
    max-width: 620px; 
    min-width: 420px;
    margin: 40px auto;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 0.9em;
    color: #888;
}

/* Style the tabs */
.stabs {
    overflow: hidden;
    margin-left: 20px;
    margin-bottom: -2px; /* hide bottom border */
}

.stabs ul {
    list-style-type: none;
    margin-left: 20px;
}

.stabs a{
    float: left;
    cursor: pointer;
    padding: 12px 24px;
    transition: background-color 0.2s;
    border: 1px solid #ccc;
    border-right: none;
    background-color: #f1f1f1;
    border-radius: 10px 10px 0 0;
    font-weight: bold;
}
.stabs a:last-child { 
    border-right: 1px solid #ccc;
}

/* Change background color of tabs on hover */
.stabs a:hover {
    background-color: #aaa;
    color: #fff;
}

/* Styling for active tab */
.stabs a.active {
    background-color: #fff;
    color: #484848;
    border-bottom: 2px solid #fff;
    cursor: default;
}

/* Style the tab content */
.stabcontent {
    padding: 30px;
    border: 1px solid #ccc;
    border-radius: 10px;
  box-shadow: 3px 3px 6px #e1e1e1
}

    .id__card.senior{
        pointer-events: none;
		position: absolute;
	    top: 0%;
	    left: 0%;
	    right: 0%;
	    overflow: hidden;
	    bottom: 0%;
	    width: 100%;
	    height: 100%;
	    border-radius: 4px;
	    border: 5px solid #dc4901;
	    padding: 0px !important;
	}
	.id__card.senior .cover_one{
		position: absolute;
	    top: 0px;
	    left: 0px;
	    bottom: 0px;
	    right: 0px;
	    background: linear-gradient(45deg, #fff, #ffffff14);
	    z-index: 2px !important;
	    background-size: 55% 34% !important;
	    background-position: 122% 80% !important;
	    background-color: #fff !important;
	    background-repeat: no-repeat !important;
	    transform: rotate(-10deg);
	}
	.id__card.senior .cover_two{
		position: absolute;
        bottom: -170px;
        left: -170px;
        height: 250px;
        width: 250px;
        background: #9e9e9e14;
        border-radius: 50%;
		z-index: 2px !important;
	}
	.id__card .main{
		position: absolute;
		top: 0px;
		left: 0px;
		right: 0px;
		bottom: 0px;
		z-index: 2px !important;
		/*padding: 0px 50px;*/
	}
	.id__card .header{
		display: flex;
		justify-content: center;
		align-content: center;
		background: #dc4901;
		padding: 10px 10px;
		margin-bottom: 4px;
	}
	.id__card .header_bottom{
		background: #dc4901;
		padding: 3px;
	}
	.id__card .header .ods_logo{
		padding: 10px 15px;
	    background: #fff;
	    border-radius: 5px;
	}
	.id__card .header .ods_logo img{
		width: 140px;
		height: 100px;
	}
	.id__card .header .school_logo{
		padding: 10px 15px;
	    background: #fff;
	    border-radius: 5px;
	}
	.id__card .header .school_logo img{
		width: 130px !important;
		height: 100px !important;
	}
	.id__card .header .title{
		padding: 0px 10px 0px 10px;
		text-align: center;
	}
	.id__card .header .title h1{
		font-size: 35px;
		color: #f7f7f7;
		text-transform: uppercase;
		word-break: keep-all;
		margin-bottom: 0px;
	}
	.id__card .header .title p{
		font-size: 15px;
		color: #f7f7f7;
		text-transform: uppercase;
		word-break: keep-all;
	}

	/*content*/
	.id__card .contents{
		padding: 15px 50px;
		display: flex;
		justify-content: center;
	}
	.id__card .contents .user_details{
		flex: 3;
		padding-left: 10px;
	}
	.id__card .contents .user_details .form_input.row{
		display: flex;
		justify-content: flex-start;
	}
	.id__card .contents .user_details .form_input .title{
		font-size: 20px !important;
        color: #000;
        align-self: flex-end;
        padding-right: 10px;
        flex: none;
        font-weight: 700 !important;
        text-transform: uppercase !important;
    }
	.id__card .contents .user_details .form_input .line{
	    font-size: 21px !important;
        text-transform: capitalize !important;
        width: 100%;
        color: #000;
        /* border-bottom: 1px solid #333; */
        padding: 5px 19px 0px 0px;
        font-weight: 900 !important;
	}
	.id__card .contents .user_photo{
		flex: 1;
		padding-right: 10px;
		align-self: center;
	}
	.id__card .contents .user_photo img{
		width: 200px;
		height: 180px;
		border-radius: 8px;
	    border: 6px solid #dc4901;
	    background-color: #fffa;
	}
	.id__card .sfooter{
	    margin-top: 15px;
		padding: 10px 0px;
		border-top: 5px solid #dc4901;
		border-bottom: 5px solid #dc4901;
	}
	.id__card .sfooter div{
	    width: 100%;
	    text-align: center;
		text-transform: capitalize;
		font-size: 25px;
		padding: 10px;
		color: #f7f7f7;
		background: #dc4901;
	}
    .student_idcard{
        position: relative !important;
	    margin: 15px 0px !important;
	    width: 950px;
	    height: 565px;
    }
    .student_idcard .status.downloaded{
        background: #21ba45;
        color: #fff;
        z-index: 1233345679 !important;
        position: absolute;
        top: 0px;
        left: 0px;
        padding: 10px 20px;
    }
    .student_idcard .status.not_downloaded{
        background: red;
    }

  .form_row{
		display: inline-flex;
		justify-content: space-between;
	}
	.form_row .form_input{
		flex: 1;
	}
  .preview__holder{
        height: 10px;
        visibility: hidden;
        overflow: hidden;
  }
</style>

