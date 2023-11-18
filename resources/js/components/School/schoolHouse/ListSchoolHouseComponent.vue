<template>
   <div class="row match-height">
		<!-- Striped rows start -->
<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">List School House</h4>
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
                <div class="table-responsive">
                      <div v-if="pagination">
                          <button @click="getHouses(pagination.prev)" :class="pagination.prev ? '' : 'disabled'" class="btn btn-success"> &lt;&lt;  Prev </button> {{ meta.current_page }} of {{ meta.last_page }} <button @click="getHouses(pagination.next)" :class="pagination.next ? '' : 'disabled'" class="btn btn-success"> Next &gt;&gt;  </button>
                      </div>
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Action</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(house , index) in houses" :key="index">
                                <th scope="row">{{ index+1 }}</th>
                                <td>{{ house.name }}</td>
                                <td>
                                    <button @click="editHouse(house.id)"  class="btn btn-primary"><i class="icon-edit"></i> Edit </button>
                                </td>
                                 <td>
                                   <button @click="deleteHouse(house.id)"  class="btn btn-danger"><i class="icon-trash4"></i> Delete</button>
                                </td>
                            </tr>
                          
                        </tbody>
                    </table>
                     <div v-if="pagination">
                          <button @click="getHouses(pagination.prev)" :class="pagination.prev ? '' : 'disabled'" class="btn btn-success"> &lt;&lt;  Prev </button> {{ meta.current_page }} of {{ meta.last_page }} <button @click="getHouses(pagination.next)" :class="pagination.next ? '' : 'disabled'" class="btn btn-success"> Next &gt;&gt;  </button>
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
				houses : '',
                pagination : '',
                meta : '',
			}
		},
        mounted() {
            this.getHouses()
        },

		methods : {
            getHouses($url = '/api/school/schoolhouse/view/all'){
                if($url==null) return ;
				this.$loading(true);
				axios.get($url)
				.then((res) => {
					this.houses = res.data.data,
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
				})
            },
            
            editHouse(id){
                this.$confirm("Are you sure you want to edit this school house?","Edit School House",'question').then(() => {
                this.$router.push({
                        name: 'edit-school-house',
                        params: { houseID: id }
                        });
                });
            },

            deleteHouse(id){
                this.$confirm("Are you sure you want delete this school?","Delete School House",'warning').then(() => {
                this.$loading(true)
                axios.delete(`/api/school/schoolhouse/${id}/delete`)
                .then((response) => {
                    this.$loading(false);
                    this.$alert(response.data.data.message,"Successful","success");
                    this.getHouses();
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
				})
                });
            }

		}
    }
</script>
