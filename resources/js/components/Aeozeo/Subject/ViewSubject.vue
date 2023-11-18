<template>
   <div class="row match-height">
		<!-- Striped rows start -->
<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">View Subject Information</h4>
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
                  
                </div>
               
                <div class="table-responsive">
                      <div v-if="pagination">
                          <button @click="getSubjects(meta.current_page-1)" :class="pagination.prev ? '' : 'disabled'" class="btn btn-success"> &lt;&lt;  Prev </button> {{ meta.current_page }} of {{ meta.last_page }} <button @click="getSubjects(meta.current_page+1)" :class="pagination.next ? '' : 'disabled'" class="btn btn-success"> Next &gt;&gt;  </button>
                      </div>
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Subject</th>
                                <th>Teachers</th>
                                <th>Category</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody >

                            <tr v-for="(subject , index) in subjects" :key="index">
                                <th scope="row">{{ index+1 }}</th>
                                <td>{{ subject.subject }}</td>
                                <td>
                                    <span v-if="subject.teachers==null">No Teacher Available</span>
                                     <span v-for="(teacher, index) in subject.teachers" :key="index">
                                         {{ teacher.title }}  {{ teacher.surname }}  {{ teacher.firstname }}  {{ teacher.middlename }} <br />
                                     </span>
                                </td>
                                <td>{{ subject.class }}</td>
                                <td>
                                    <button @click="editSubject(subject.id)"  class="btn btn-primary"><i class="icon-edit"></i> Edit </button>
                                </td>
                                 <td>
                                   <button @click="deleteSubject(subject.id)"  class="btn btn-danger"><i class="icon-trash4"></i> Delete</button>
                                </td>
                            </tr>
                            <tr v-if="subjects == null">
                                <td colspan="8"> No subject Found</td>
                            </tr>
                        
                        </tbody>
                    </table>
                   
                     <div v-if="pagination">
                          <button @click="getSubjects(meta.current_page-1)" :class="pagination.prev ? '' : 'disabled'" class="btn btn-success"> &lt;&lt;  Prev </button> {{ meta.current_page }} of {{ meta.last_page }} <button @click="getSubjects(meta.current_page+1)" :class="pagination.next ? '' : 'disabled'" class="btn btn-success"> Next &gt;&gt;  </button>
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
                subjects : null,
                pagination : '',
                meta : '',
                
			}
		},
        mounted() {
            this.getSubjects();
        },

		methods : {
			
            getSubjects(page = 1){
                if(this.meta && (page > this.meta.last_page || page == 0)  ) return ;
                
				this.$loading(true);
				axios.get('/api/ministry/subject/view?page='+page)
				.then((res) => {
					this.subjects = res.data.data,
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
            
           editSubject(id){
                this.$confirm("Are you sure you want to edit subject?","Edit Subject",'question').then(() => {
                this.$router.push({
                        name: 'edit-subject',
                        params: { subjectId: id }
                        });
                });
            },

			deleteSubject(id){
                this.$confirm("Are you sure you want to delete subject?","Delete subject",'warning').then(() => {
                this.$loading(true)
                axios.delete('/api/ministry/subject/'+id+'/delete')
                .then((response) => {
                    this.$loading(false);
                    this.$alert(response.data.data.message,"Successful","success");
                    this.getSubjects();
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
           
		}
    }
</script>
