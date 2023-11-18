<template>
   <div class="row match-height">
		<!-- Striped rows start -->
<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Exam Scratch Card</h4>
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
					<div class="card-block card-dashboard row">
						<div class="row" style="background:#eee; border:1px solid #ccc; border-radius:5px; padding:5px; text-align:center;">
							<h5> Generate Scratch Card </h5>
							
							<div class="col-md-3" >
									<div class="input-group col-xs-12">
										
										<select id="" v-model="card_quantity" class="form-control" name="state" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select Quantity">
											<option selected value="">Select Quantity</option>
											<option value="10">10</option>
											<option value="20">20</option>
											<option value="50">50</option>
											<option value="100">100</option>
											<option value="200">200</option>
											<option value="500">500</option>
											<option value="1000">1000</option>
										</select>
									</div>
							</div>
							<div class="col-md-3" >
									<div class="input-group col-xs-12">
										
										<select id="" v-model="exam_type" class="form-control" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select Exam Type">
											<option selected value="">Select Exam Type</option>
											<option value="unity_exam">Unity Exam</option>
											<option value="jwaec">Junior Waec</option>
											<option value="pre_waec">Pre Waec</option>
											<option value="entrance">Entrace</option>
										</select>
									</div>
							</div>
							<div class="col-md-3" >
									<div class="input-group col-xs-12">
										
										<input v-model="multiple" placeholder="Enter number of student per card" class="form-control" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Number of student per card" />
									</div>
							</div>

							<div class="col-md-3">
								<button style="width:100%;" @click="generateCards" type="submit" class="btn btn-success">
									<i class="icon-check2"></i> Generate Scratch Card
								</button>
							</div>
						</div>
						<hr>
						<div class="row" style="background:#eee; border:1px solid #ccc; border-radius:5px; padding:5px; text-align:center;">
							<h5> Filter Scratch Card </h5>
							<div class="col-md-3" >
									<div class="input-group col-xs-12">
										<select type="text" id="" v-model="filter.per_page" class="form-control" name="state" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Per Page">
											<option value="">Select Per Page</option>
											<option value="10">10</option>
											<option value="20">20</option>
											<option value="50">50</option>
											<option value="100">100</option>
											<option value="200">200</option>
											<option value="500">500</option>
											<option value="1000">1000</option>
										</select>
									</div>
							</div>
							<div class="col-md-3" >
									<div class="input-group col-xs-12">
										
										<select id="" v-model="filter.exam_type" class="form-control" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select Exam Type">
											<option selected value="">Select Exam Type</option>
											<option value="unity_exam">Unity Exam</option>
											<option value="jwaec">Junior Waec</option>
											<option value="pre_waec">Pre Waec</option>
											<option value="entrance">Entrace</option>
										</select>
									</div>
							</div>
							<div class="col-md-3" >
									<div class="input-group col-xs-12">
										
										<select type="text" v-model="filter.category" class="form-control" name="state" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Select Category">
											<option selected value="">Select Category</option>
											<option value="all">All</option>
											<option value="used">Used</option>
											<option value="available">Available</option>
										</select>
									</div>
							</div>
							<div class="col-md-3">
								<button style="width:100%;" @click="getCards()" type="submit" class="btn btn-success">
									<i class="icon-check2"></i> Get Scratch Card
								</button>
							</div>
						</div>
						
                	</div>

					<div class="table-responsive">
                      	<div v-if="pagination">
                         <button @click="getCards(meta.current_page-1)" :class="pagination.prev ? '' : 'disabled'" class="btn btn-success"> &lt;&lt;  Prev </button> {{ meta.current_page }} of {{ meta.last_page }} | Total: {{ meta.total }} <button @click="getCards(meta.current_page+1)" :class="pagination.next ? '' : 'disabled'" class="btn btn-success"> Next &gt;&gt;  </button>
                      	</div>

                		<table class="table table-striped mb-0">
                        	<thead>
                            	<tr>
									<th>#</th>
									<th>Serial Number</th>
									<th>Pin</th>
									<th>ISSI Number</th>
									<th>Exam Type</th>
									<th>Student Per Card</th>
									<th>Select Cards 
									</th>
									<th> Select All<label class="toggle-control">
											<input @click="toggleAll" type="checkbox" id="all" >
											<span class="control"></span>
                            			</label>
									</th>
                            	</tr>
                        	</thead>
                        	<tbody>
								<tr v-for="(card , index) in cards" :key="index">
									<th scope="row">{{ index+1 }}</th>
									<td>{{ card.serial }}</td>
									<td>{{ card.pin }}</td>
									<td>{{ card.regnum }}</td>
									<td>{{ card.exam_type }}</td>
									<td>{{ card.multiple }}</td>
									<td colspan="2">
										Delete Card
										<label class="toggle-control">
											<input @click="toggle(card.id)" :id="card.id" type="checkbox" :checked ="card.is_delete ? true : false">
											<span class="control"></span>
                            			</label>
									</td>
								</tr>
                          
                        	</tbody>
                    	</table>
						<div v-if="pagination">
							  <button @click="getCards(meta.current_page-1)" :class="pagination.prev ? '' : 'disabled'" class="btn btn-success"> &lt;&lt;  Prev </button> {{ meta.current_page }} of {{ meta.last_page }} | Total: {{ meta.total }} <button @click="getCards(meta.current_page+1)" :class="pagination.next ? '' : 'disabled'" class="btn btn-success"> Next &gt;&gt;  </button>
						</div>
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
              card_quantity : null,
			  exam_type : null,
			  multiple :null,
			  cards : null,
			  pagination : null,
			  meta : '',
			  type : null,
			  filter :{
				  per_page : 50,
				  category : null,
				  exam_type : null
			  }
			}
		},
        mounted() {
			this.getCards();
        },

		methods : {
           generateCards(){
               let data = new FormData;

			   data.append('quantity', this.card_quantity);
			    data.append('multiple', this.multiple);
				 data.append('exam_type', this.exam_type);
			   this.$loading(true)

                axios.post('/api/ministry/exam/scratch-card/generate',data)
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
                        });
                    };
					this.getCards();
				
                })
				.catch(error => {
					this.$loading(false)
					if (!error.response) {
						this.$alert("You do not have internet access or Unknown Error","Network Error","error");
						return ;
					}
					
					if (error.response.status == 422){
					    this.validationErrors = error.response.data.errors;
					    this.flashMessage.error({title: 'Validation Error', 
											message: 'Their is Error with the Data you supplied',
											time: 15000, });
					}

					if(error.response.status === 401){
						let return_url = window.location.pathname;
						this.$router.push({
							name: "aeo_zeo-login",
							params: { return_url: return_url }
							});
					}
					if(error.response.status === 403){
						this.$alert("Sorry, you do not have the permission to perfrom this action","No Permission","error");
					}
				});
           },

		   toggleAll(){
			   
			   document.getElementById('all').checked = false;
			   this.$confirm("Are you sure you want delete all Scratch Card ?","Delete Scratch Card",'warning').then(() => {
			
				document.getElementById('all').checked = true;

				const ids = [];
				this.cards.forEach(card => {
					ids.push(card.id)
				});

                this.$loading(true)
                axios.post('/api/ministry/exam/scratch-card/delete/all',{'ids' : ids})
                .then((response) => {
                    this.$loading(false);
                    this.$alert(response.data.data.message,"Successful","success");
                    this.cards = {};
					document.getElementById('all').checked = false;
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

		   },

		   getCards(page = 1){
			   if(this.meta && (page > this.meta.last_page || page == 0)  ) return ;

			   let url = '/api/ministry/exam/scratch-card/view?page='+page+'&per_page='+this.filter.per_page

			   if((this.filter.category == 'available') || (this.filter.category == 'used')) {
				   url +='&category='+this.filter.category
			   }

			    if((this.filter.exam_type != null) && (this.filter.exam_type != '')) {
				     url +='&exam_type='+this.filter.exam_type
			   }

			    this.$loading(true)

                axios.get(url)
				.then(response => {
                    if(response) {
						this.$loading(false)
						this.cards = response.data.data;
						this.pagination = response.data.links;
						this.meta = response.data.meta;
                    }
				
                })
				.catch(error => {
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
					if(error.response.status === 403){
						this.$alert("Sorry, you do not have the permission to perfrom this action","No Permission","error");
					}
				});
		   },

		   toggle(id){

			   	document.getElementById(id).checked = false;
				
			    this.$confirm("Are you sure you want delete this Scratch Card ?","Delete Scratch Card",'warning').then(() => {
				
                axios.delete('/api/ministry/exam/scratch-card/'+id+'/delete')
                .then((response) => {
                    this.flashMessage.success({
                            title: 'Successful',
                            message: response.data.data.message,
                            time: 5000,
                            flashMessageStyle: {
                                backgroundColor: 'linear-gradient(#e66465, #9198e5)'
                            }
                        });
					let removeIndex = this.cards.map(function(card) { return card.id; }).indexOf(id);
					// remove object
					this.cards.splice(removeIndex, 1);
					this.cards = this.cards;
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

// These are our computed variables
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

</style>

