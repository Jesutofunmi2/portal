<template>
   <div class="row match-height">
		<!-- Striped rows start -->
<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title" v-if="fullname">Activities Log for {{fullname}}</h4>
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
                   <div class="col-md-5">
                       <div class="form-body">
                            <div class="form-group">
                                <input type="date" @change="validationErrors.start_date=null" :class="{'border-danger':validationErrors.start_date}" v-model="start_date" class="form-control" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Start date">
                                <span  v-if="validationErrors.start_date" :class="['label text-danger']">{{ validationErrors.start_date[0] }}</span>
                            </div>
                        </div>
                   </div>
                   <div class="col-md-5">
                         <div class="form-body">
                            <div class="form-group">
                                <input type="date" @change="validationErrors.end_date=null" :class="{'border-danger':validationErrors.end_date}" v-model="end_date" class="form-control" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="End date">
                                <span  v-if="validationErrors.end_date" :class="['label text-danger']">{{ validationErrors.end_date[0] }}</span>
                            </div>
                        </div>
                   </div>
                   <div class="col-md-2">
                         <div class="form-body">
                            <button class="btn btn-primary" @click="getLogs()">Filter</button>
                        </div>
                   </div>
                   <div class="col-md-12">
                         <div class="form-body">
                            <button class="btn btn-primary" @click="back()">&lt;&lt; Back</button>
                        </div>
                   </div>
                </div>
                <div class="table-responsive">
                      <div v-if="pagination">
                          <button @click="getLogs(meta.current_page-1)" :class="pagination.prev ? '' : 'disabled'" class="btn btn-success"> &lt;&lt;  Prev </button> {{ meta.current_page }} of {{ meta.last_page }} <button @click="getLogs(meta.current_page+1)" :class="pagination.next ? '' : 'disabled'" class="btn btn-success"> Next &gt;&gt;  </button>
                      </div>
                      <p></p>
                   <div class="" v-if="logs">
                       <div v-for="log, index in logs" :key="index" class="card">
                            <div class="card-body">
                                <div class="media">
                                    <div class="p-2 text-xs-center bg-success media-left media-middle">
                                        <img :src="baseUrl+log.logo" alt="School Logo" width="60px" height="60px" style="border-radius:30px;" >
                                    </div>
                                    <div class="p-2 media-body">
                                        <div class="row">
                                             <h5 > <span style="text-transform:capitalize;"><strong class="text-success">{{log.fullname}}</strong> - {{log.message}}</span> {{log.created_at}}</h5>
                                         </div>
                                        
                                        <h6 class="text-bold-400">Visited: {{log.type}} {{log.path}}</h6>
                                        <h6 class="text-bold-400">IP: {{log.ip}} <a target="_blank" :href="'https://whatismyipaddress.com/ip/'+log.ip"><i class="icon-eye"></i></a></h6>
                                        <h6 class="text-bold-400">Device: {{log.device}}</h6>
                                    </div>
                                </div>
                            </div>
                       </div>
                   </div>
                      <div v-if="pagination">
                          <button @click="getLogs(meta.current_page-1)" :class="pagination.prev ? '' : 'disabled'" class="btn btn-success"> &lt;&lt;  Prev </button> {{ meta.current_page }} of {{ meta.last_page }} <button @click="getLogs(meta.current_page+1)" :class="pagination.next ? '' : 'disabled'" class="btn btn-success"> Next &gt;&gt;  </button>
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
                adminId : this.$route.params.adminId,
                fullname : null,
				logs : null,
                lga_id : null,
                start_date : null,
                end_date : null,
                pagination : '',
                meta : '',
                validationErrors : [],
                baseUrl : '/public',
			}
		},
        mounted() {
            this.getLogs()
        },

		methods : {
            getLogs(page = 1) {
                if(this.meta && (page > this.meta.last_page || page == 0)  ) return ;

                let url = '/api/ministry/activities-log/school/'+this.adminId+'?page='+page;
                
                if(this.start_date != null) {
                    if(this.end_date == null){
                        alert('End date is empty');
                        return;
                    } 
                    url += '&start_date='+this.start_date;
                }
                if(this.end_date != null) {
                    if(this.start_date == null){
                        alert('Start date is empty');
                        return;
                    } 
                    url += '&end_date='+this.end_date;
                }

                if(url==null) return ;

                this.validationErrors = [];

				this.$loading(true);
				axios.get(url)
				.then((res) => {
					this.logs = res.data.data,
                    this.pagination = res.data.links,
                    this.meta = res.data.meta,
                    this.fullname = res.data.fullname,
					this.$loading(false)
				})
				.catch((error) => {
                    this.$loading(false);
					if (!error.response) {
						this.$alert("You do not have internet access","Network Error","error");
						return ;
					}

                    if (error.response.status == 422){
					this.validationErrors = error.response.data.errors;
					this.flashMessage.error({title: 'Validation Error', 
											message: 'Their is Error with the Data you supplied',
											time: 15000, });
					}

                    if (error.response.status === 401) {
                        let return_url = window.location.pathname;
                        this.$router.push({
                        name: "ministry-login",
                        params: { return_url: return_url },
                        });
                    }


                    if(error.response.status === 403){
						this.$alert("Sorry, you do not have the permission to perfrom this action","No Permission","error");
					}
				})
			},

            back(){
                this.$router.back(-1);
            },

		}
    }
</script>
