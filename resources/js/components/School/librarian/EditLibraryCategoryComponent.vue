<template>
   <div class="row match-height">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-tooltip">Edit Library Category </h4>
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

						<form class="form" @submit.prevent="updateCategory">
							<div class="form-body">

								<div class="form-group col-md-6" >
									<label for="issueinput2">Class</label>
									<input type="text" id="issueinput2" @keydown="validationErrors.name=null" :class="{'border-danger':validationErrors.name}" v-model="category.name" class="form-control" placeholder="Category Name" name="name" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Category Name" required>
									<span  v-if="validationErrors.name" :class="['label text-danger']">{{ validationErrors.name[0] }}</span>
								</div>
									
							</div>

							<div class="form-actions">
								<button type="button" class="btn btn-warning mr-1">
									<i class="icon-cross2"></i> Cancel
								</button>
								<button type="submit" class="btn btn-primary">
									<i class="icon-check2"></i> Update
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<FlashMessage></FlashMessage>

	</div>
	
</template>

<script>

    export default {

		data() {
			return {
				catID : this.$route.params.catID,
				category : '',
				validationErrors: [],
			}
		},
        mounted() {
			this.getCategory();
        },

		methods : {
			getCategory(){
				this.$loading(true)
				axios.get(`/api/school/library/category/${this.catID}/edit`)
				.then((res) => {
					this.category = res.data.data,
				
					this.$loading(false)
				})
				.catch((error) => {
					this.$loading(false)
					if (!error.response) {
						this.$alert("You do not have internet access","Network Error","error");
						return ;
					}

					if(error.response.status === 403){
						this.$alert("Sorry, you do not have the permission to perform this action","No Permission","error");
					}
				})
			},

            updateCategory(){
				let data = new FormData;
				data.append('name', this.category.name);
				
				this.$loading(true)

                axios.post(`/api/school/library/category/${this.catID}/update`, data)
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
						this.getCategory();
                    }
                })
				.catch(error => {
					this.$loading(false)
					if (error.response.status == 422){
						this.validationErrors = error.response.data.errors;
						this.flashMessage.error({title: 'Validation Error', 
							message: 'There is an Error with the Data you supplied',
							time: 15000, });
					}
					if(error.response.status === 403){
						this.$alert("Sorry, you do not have the permission to perform this action","No Permission","error");
					}
				});
            }
		}
    }
</script>