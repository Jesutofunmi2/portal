<template>
   <div class="row match-height">
		<!-- Striped rows start -->
<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Student Result</h4>
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
                <div class="card-block card-dashboard row" v-if="sessions" >
                  
                   <div class="col-md-6">
                        <fieldset style="width:100%;" class="row py-2">
                            <div class="input-group col-xs-12">
                                <select v-model="s_session" @change="validationErrors.session=null" class="form-control form-control-lg input-lg border-grey border-lighten-1" :class="{'border-danger':validationErrors.session}" placeholder="Session"  data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select Session" required>
                                    <option value="" >Select Session</option>
                                    <option v-for="session in sessions" :key="session" :value="session">{{session}}/{{session+1}}</option>
                                </select>
                                <span  v-if="validationErrors.session" :class="['label text-danger']">{{ validationErrors.session[0] }}</span>
                            </div>
                        </fieldset> 
                   </div>

                   <div class="col-md-3">
                       <fieldset style="width:100%;" class="row py-2">
                            <div class="input-group col-xs-12">
                               <select v-model="term" @change="validationErrors.term=null" class="form-control form-control-lg input-lg border-grey border-lighten-1" :class="{'border-danger':validationErrors.term}" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select Term" required>
                                    <option selected value="">Select Term</option>
                                    <option value="First">First Term</option>
                                    <option value="Second">Second Term</option>
                                    <option value="Third">Third Term</option>
                                </select>
                                <span  v-if="validationErrors.term" :class="['label text-danger']">{{ validationErrors.term[0] }}</span>
                            </div>
                        </fieldset> 
                   </div>
                   
                    
                   <div class="col-md-3" style="padding:0px; margin:0px;">
                        <fieldset style="width:100%;" class="row py-2">
                            <div class="input-group col-xs-12">
                                <button style="background:#FF8C00; color:#fff;" class="btn btn-lg" @click="getStudentResult()">Get Result</button>
                            </div>
                        </fieldset> 
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

		data(){
			return {
                sessions:null,
                s_session:'',
                term: null,
                validationErrors: [],
			}
		},
        mounted() {
            this.getStudentSession()
        },

		methods : {

            getStudentResult() {
                if(this.s_session == '' || this.s_session == null) {
                    alert('Please select session');
                    return;
                }

                if(this.term == '' || this.term == null) {
                    alert('Please select term');
                    return;
                }

                this.$loading(true);
				axios.get('/api/student/result/check?session='+this.s_session+'&term='+this.term)
				.then((res) => {
                    if(res.data.data.status == true) {
                        let student = res.data.data.student;
                        this.$loading(false);
                
                        window.open('/api/school/result/print?student_id='+student.student_id+'&class_id='+student.class_id+'&classarm_id='+student.classarm_id+'&session='+student.session+'&term='+student.term+'&print_type=html',
                        'Student '+student.student_id+' Result','directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=850,height=900');
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
									name: 'student-login',
									params: { return_url: return_url }
									});
					}

                    if(error.response.status === 400){
						this.$alert(error.response.data.message, "Request Error","error");
					}
				})
            },

            getStudentSession() {
            
                this.$loading(true);
				axios.get('/api/student/result/session')
				.then((res) => {
                   this.sessions = res.data.data.sessions;
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
									name: 'student-login',
									params: { return_url: return_url }
									});
					}

                    if(error.response.status === 400){
						this.$alert(error.response.data.message, "Request Error","error");
					}
				})
            },

		}
    }
</script>
