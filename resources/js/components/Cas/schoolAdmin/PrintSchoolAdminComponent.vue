<template>
   <div class="row match-height">
		<!-- Striped rows start -->
<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Print School Admins</h4>
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
                   <div class="col-md-9">
                        <fieldset style="width:100%;" class="row py-2">
                            <div class="input-group col-xs-12">
                                <select v-model="lga_id" type="text" @change="lgaChanged" class="form-control form-control-lg input-lg border-grey border-lighten-1 " aria-describedby="button-addon2">
                                    <option selected :value="null">Select L.G.A</option>
                                    <option  v-for="lga in lgas" :key="lga.id" :value="lga.id"> {{ lga.name }}</option>
                                </select>
                                
                            </div>
                        </fieldset>
                   </div>
                   <div class="col-md-3">
                        <fieldset style="width:100%;" class="row py-2">
                            <div class="input-group col-xs-12">
                                <button style="width:100%; background:#FF8C00; color:#fff;" class="btn btn-lg" @click="getAdmins()">Fetch Admin</button>
                            </div>
                        </fieldset> 
                   </div>
                   
                </div>
                <div v-if="schools" class="table-responsive">
                    <div class="col-md-12" style="float:right;">
                        <button @click="getAdmins('print')" class="btn btn-success">Print PDF</button>
                    </div>
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th colspan="3" style="text-align:center;">AEOZEO Admins</th>
                            </tr>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Phone</th>
                            </tr>
                        </thead>
                        <tbody v-if="aeozeos.length > 0">
                            <tr v-for="(admin , index) in aeozeos" :key="index">
                                <th scope="row">{{ index+1 }}</th>
                                <td>{{ admin.name }}</td>
                                <td>{{ admin.phone }}</td>
                            </tr>
                        </tbody>
                        <tbody v-else>
                            <tr>
                                <td colspan="3">No AEOZEO Admin Available for this LGA</td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table table-striped mb-0">
                        <thead>
                            <th colspan="5" style="text-align:center;">School Admins</th>
                            <tr>
                                <th>#</th>
                                <th>School Name</th>
                                <th>School Phone</th>
                                <th>Principal Name</th>
                                <th>School Admin</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(school , index) in schools" :key="index">
                                <th scope="row">{{ index+1 }}</th>
                                <td>{{ school.school_name }}</td>
                                <td>{{ school.phone }}</td>
                                <td>{{ school.principal_name }}</td>
                                <td>
                                    <div style="background:#eee; border-radius:1px solid #333; margin:5px;" v-for="admin, index in school.admins" :key="index">
                                        <span>{{ admin.name }}</span> | <span>{{ admin.phone }}</span> <br />
                                    </div>
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
                lgas : [],
                lga_id : null,
                schools : null,
                aeozeos : null,
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
                    this.$loading(false)
				})
				.catch((error) => {
                    this.$loading(false);
					if (!error.response) {
						this.$alert("You do not have internet access","Network Error","error");
						return ;
					}
					if(error.response.status === 401){
						let return_url = window.location.pathname;
						this.$router.push({
									name: 'cas-login',
									params: { return_url: return_url }
									});
					}

                    if(error.response.status === 403){
						this.$alert("Sorry, you do not have the permission to perfrom this action","No Permission","error");
					}
				})
			},

            getAdmins(type='view') {
                if(this.lga_id == null) {
                    this.$alert("No L.G.A is selected","Error","error");
                    return
                }
				this.$loading(true);
				axios.get('/api/ministry/school/admin/print?lga_id='+this.lga_id+'&type='+type)
				.then((res) => {
					this.schools = res.data.schools,
                    this.aeozeos = res.data.aeozeos,
					this.$loading(false)
                    if(res.data.url) {
                        window.open(res.data.url);
                    }
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
            
            lgaChanged() {
                this.schools = null;
            }
		}
    }
</script>
