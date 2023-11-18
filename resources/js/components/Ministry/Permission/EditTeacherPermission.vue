<template>
   <div class="row match-height">
		<!-- Striped rows start -->
<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Search Registered Teacher</h4>
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
                                    <option selected value="">Select School</option>
                                   <option :value="school.id" v-for ="school in schools" :key ="school.id" >{{ school.name }}</option>
                                </select>
                            </div>
                        </fieldset> 
                   </div>

                </div>
                <div class="table-responsive">
                      <div v-if="pagination">
                          <button @click="getTeachers(meta.current_page-1)" :class="pagination.prev ? '' : 'disabled'" class="btn btn-success"> &lt;&lt;  Prev </button> {{ meta.current_page }} of {{ meta.last_page }} <button @click="getTeachers(meta.current_page+1)" :class="pagination.next ? '' : 'disabled'" class="btn btn-success"> Next &gt;&gt;  </button>
                      </div>
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Teacher's Fullname</th>
                                <th>ID Number</th>
                                <th>Passport</th>
                                <th>Subject Area</th>
                                <th>School</th>
                                <th>Action</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody >

                            <tr v-for="(teacher , index) in teachers" :key="index">
                                <th scope="row">{{ index+1 }}</th>
                                <td>{{ teacher.fullname }}</td>
                                <td>{{ teacher.staff_no }}</td>
                                <td>
                                    <span  v-for="subject in teacher.subjects" :key="subject.id">{{ subject.subject_name }} <hr /></span>
                                    <span class="text-danger" v-if="teacher.subjects==null">No Subject Available</span>
                                </td>
                                 <td>{{ teacher.school }}</td>
                            
                                <td>
                                    <button  class="btn btn-primary"><i class="icon-edit"></i> Edit </button>
                                </td>
                                 <td>
                                   <button  class="btn btn-danger"><i class="icon-trash4"></i> Delete</button>
                                </td>
                            </tr>
                            <tr v-if="teachers.length==0">
                                <td colspan="8"> Please select Local Govt Area and then School to get Teachers</td>
                            </tr>
                          
                        </tbody>
                    </table>
                   
                     <div v-if="pagination">
                          <button @click="getTeachers(meta.current_page-1)" :class="pagination.prev ? '' : 'disabled'" class="btn btn-success"> &lt;&lt;  Prev </button> {{ meta.current_page }} of {{ meta.last_page }} <button @click="getTeachers(meta.current_page+1)" :class="pagination.next ? '' : 'disabled'" class="btn btn-success"> Next &gt;&gt;  </button>
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
				ministries : null,
                pagination : '',
                meta : ''
                
			}
		},
        mounted() {
          
        },

		methods : {
           
		}
    }
</script>
