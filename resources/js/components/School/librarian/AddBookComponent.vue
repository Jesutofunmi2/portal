<template>
   <div class="row match-height">
		<div class="col-md-12 ">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-tooltip">Add Book</h4>
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

						<form class="form" novalidate @submit.prevent="addBook">
							<div class="form-body">

								<div class="form-group col-md-6">
									<label for="issueinput0">Category</label>
									<select id="issueinput0" v-model="book.cat_id" @change="validationErrors.cat_id=null" :class="{'border-danger':validationErrors.cat_id}" class="form-control" name="cat_id" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Category" required>
										<option value="">Select Category</option>
										<option :value="cat.id" v-for ="(cat ,index) in categories" :key ="index" >{{ cat.name }}</option>
									</select>
									<span  v-if="validationErrors.cat_id" :class="['label text-danger']">{{ validationErrors.cat_id[0] }}</span>
								</div>

								<div class="form-group col-md-6">
									<label for="issueinput11">Available</label>
									<select id="issueinput11" v-model="book.available" @change="validationErrors.available=null" :class="{'border-danger':validationErrors.available}" class="form-control" name="available" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Available" required>
										<option value="">Select Availability</option>
										<option value="1">Yes</option>
                                        <option value="0">No</option>
									</select>
									<span  v-if="validationErrors.available" :class="['label text-danger']">{{ validationErrors.available[0] }}</span>
								</div>

								<div class="form-group col-md-6">
									<label for="issueinput1">Title</label>
									<input type="text" id="issueinput1" @keydown="validationErrors.title=null" :class="{'border-danger':validationErrors.title}" v-model="book.title" class="form-control" placeholder="Title" name="title" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Title" required>
									<span  v-if="validationErrors.title" :class="['label text-danger']">{{ validationErrors.title[0] }}</span>
								</div>

								<div class="form-group col-md-6">
									<label for="issueinput2">Sub-Title</label>
									<input type="text" id="issueinput2" @keydown="validationErrors.sub_title=null" :class="{'border-danger':validationErrors.title}" v-model="book.sub_title" class="form-control" placeholder="Sub-Title" name="sub_title" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Sub-Title" required>
									<span  v-if="validationErrors.sub_title" :class="['label text-danger']">{{ validationErrors.sub_title[0] }}</span>
								</div>

								<div class="form-group col-md-6">
									<label for="issueinput3">Author</label>
									<textarea id="issueinput3" @keydown="validationErrors.author=null" :class="{'border-danger':validationErrors.address}" v-model="book.author" rows="5" class="form-control" name="author" placeholder="Author" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Author" required></textarea>
									<span  v-if="validationErrors.author" :class="['label text-danger']">{{ validationErrors.author[0] }}</span>
								</div>

								<div class="form-group col-md-6">
									<label for="issueinput4">Publisher</label>
									<textarea id="issueinput4" @keydown="validationErrors.publisher=null" :class="{'border-danger':validationErrors.publisher}" v-model="book.publisher" rows="5" class="form-control" name="publisher" placeholder="Publisher" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Publisher" required></textarea>
									<span  v-if="validationErrors.publisher" :class="['label text-danger']">{{ validationErrors.publisher[0] }}</span>
								</div>

								<div class="form-group col-md-6">
									<label for="issueinput5">Subject</label>
									<textarea id="issueinput5" @keydown="validationErrors.subject=null" :class="{'border-danger':validationErrors.subject}" v-model="book.subject" rows="5" class="form-control" name="subject" placeholder="Subject" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Subject" required></textarea>
									<span  v-if="validationErrors.subject" :class="['label text-danger']">{{ validationErrors.subject[0] }}</span>
								</div>

								<div class="form-group col-md-6">
									<label for="issueinput6">Description</label>
									<textarea id="issueinput6" @keydown="validationErrors.descrip=null" :class="{'border-danger':validationErrors.descrip}" v-model="book.descrip" rows="5" class="form-control" name="descrip" placeholder="Description" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Description" required></textarea>
									<span  v-if="validationErrors.descrip" :class="['label text-danger']">{{ validationErrors.descrip[0] }}</span>
								</div>

								<div class="form-group col-md-6">
									<label for="issueinput7">Location</label>
									<input type="text" id="issueinput7" @keydown="validationErrors.location=null" :class="{'border-danger':validationErrors.location}" v-model="book.location" class="form-control" placeholder="Location" name="location" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Location" required>
									<span  v-if="validationErrors.location" :class="['label text-danger']">{{ validationErrors.location[0] }}</span>
								</div>

								<div class="form-group col-md-6">
									<label for="issueinput8">ISBN</label>
									<input type="text" id="issueinput8" @keydown="validationErrors.isbn=null" :class="{'border-danger':validationErrors.isbn}" v-model="book.isbn" class="form-control" placeholder="ISBN" name="isbn" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="ISBN" required>
									<span  v-if="validationErrors.isbn" :class="['label text-danger']">{{ validationErrors.isbn[0] }}</span>
								</div>

								<div class="form-group col-md-6">
									<label for="issueinput9">Serial Number</label>
									<input type="text" id="issueinput9" @keydown="validationErrors.serial_no=null" :class="{'border-danger':validationErrors.serial_no}" v-model="book.serial_no" class="form-control" placeholder="Serial Number" name="serial_no" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Serial Number" required>
									<span  v-if="validationErrors.serial_no" :class="['label text-danger']">{{ validationErrors.serial_no[0] }}</span>
								</div>

								<div class="form-group col-md-6">
									<label for="issueinput10">Copies</label>
									<input type="number" id="issueinput10" @keydown="validationErrors.copies=null" :class="{'border-danger':validationErrors.copies}" v-model="book.copies" class="form-control" placeholder="Copies" name="copies" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Copies" required>
									<span  v-if="validationErrors.copies" :class="['label text-danger']">{{ validationErrors.copies[0] }}</span>
								</div>

							</div>

							<div class="form-actions">
								<button type="button" class="btn btn-warning mr-1">
									<i class="icon-cross2"></i> Cancel
								</button>
								<button type="submit" class="btn btn-primary">
									<i class="icon-check2"></i> Add
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
				book : {
					'cat_id' : '',
					'title' : '', 
					'sub_title' : '',
					'author' : '', 
					'publisher' : '', 
					'subject' : '', 
					'descrip' : '', 
					'location' : '', 
					'isbn' : '', 
					'serial_no' : '', 
					'copies' : '', 
					'available' : '', 
				},
				categories : '',
				validationErrors: [],
			}
		},
        mounted() {
			this.getCategories();
        },

		methods : {
			getCategories($url = '/api/school/library/category/viewall'){
                if($url==null) return ;
                
				this.$loading(true);
				axios.get($url)
				.then((res) => {
					this.categories = res.data.data,
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
							name: 'school-login',
							params: { return_url: return_url }
							});
					}

                    if(error.response.status === 403){
						this.$alert("Sorry, you do not have the permission to perfrom this action","No Permission","error");
					}
				})
            },

			addBook() {
				let data = new FormData;
				data.append('cat_id', this.book.cat_id);
				data.append('title', this.book.title); 
				data.append('sub_title', this.book.sub_title);
				data.append('author', this.book.author); 
				data.append('publisher', this.book.publisher);
				data.append('subject', this.book.subject); 
				data.append('descrip', this.book.descrip);
				data.append('location', this.book.location); 
				data.append('isbn', this.book.isbn);
				data.append('serial_no', this.book.serial_no); 
				data.append('copies', this.book.copies); 
				data.append('available', this.book.available); 

				this.$loading(true)

                axios.post('/api/school/library/book/add', data)
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
					}
					
					this.book.cat_id = null;
					this.book.title = null; 
					this.book.sub_title = null;
					this.book.author = null; 
					this.book.publisher = null;
					this.book.subject = null; 
					this.book.descrip = null;
					this.book.location = null; 
					this.book.isbn = null;
					this.book.cat_id = null; 
					this.book.cat_id = null; 
					this.book.available = null;
                })
				.catch(error => {
					this.$loading(false)
					if (!error.response) {
						this.$alert("You do not have internet access","Network Error","error");
						return ;
					}
					if (error.response.status == 422){
					this.validationErrors = error.response.data.errors;
					this.flashMessage.error({title: 'Validation Error', 
											message: 'There is an Error with the Data you supplied',
											time: 15000, });
					}
					if(error.response.status === 401){
						let return_url = window.location.pathname;
						this.$router.push({
							name: 'school-login',
							params: { return_url: return_url }
							});
					}
					if(error.response.status === 403){
						this.$alert("Sorry, you do not have the permission to perfrom this action","No Permission","error");
					}
					
				});
            }
		}
    }
</script>