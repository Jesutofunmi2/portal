<template>
    <div class="row match-height">
		<!-- Striped rows start -->
        <div class="row">
            <div class="col-xs-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">List Books</h4>
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
                            <div class="col-md-12">
                                <fieldset class="row py-2">
                                    <div class="input-group col-xs-12">
                                        <input v-model="query" type="text"  required class="form-control form-control-lg input-lg border-grey border-lighten-1 " placeholder="Search By Term" aria-describedby="button-addon2">
                                        <span class="input-group-btn" id="button-addon2">
                                            <button @click="searchByTerm" class="btn btn-lg btn-success border-grey border-lighten-1" type="submit"><i class="icon-ios-search-strong"></i></button>
                                        </span>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <div v-if="pagination">
                                <button @click="getBooks(pagination.prev)" :class="pagination.prev ? '' : 'disabled'" class="btn btn-success"> &lt;&lt;  Prev </button> {{ meta.current_page }} of {{ meta.last_page }} <button @click="getBooks(pagination.next)" :class="pagination.next ? '' : 'disabled'" class="btn btn-success"> Next &gt;&gt;  </button>
                            </div>
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Author</th>
                                        <th>Subject</th>
                                        <th>ISBN</th>
                                        <th>Copies</th>
                                        <th>Available</th>
                                        <th>Action</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(bk , index) in books" :key="index">
                                        <th scope="row">{{ index+1 }}</th>
                                        <td>{{ bk.title }}</td>
                                        <td>{{ bk.author }}</td>
                                        <td>{{ bk.subject }}</td>
                                        <td>{{ bk.isbn }}</td>
                                        <td>{{ bk.copies }}</td>
                                        <td>
                                            <span v-if="bk.available === 1">Yes</span>
                                            <span v-if="bk.available === 0">No</span>
                                        </td>
                                        <td>
                                            <button @click="editBook(bk.id)"  class="btn btn-primary"><i class="icon-edit"></i> Edit </button>
                                        </td>
                                        <td>
                                        <button @click="deleteBook(bk.id)"  class="btn btn-danger"><i class="icon-trash4"></i> Delete</button>
                                        </td>
                                    </tr>
                                
                                </tbody>
                            </table>
                            <div v-if="pagination">
                                <button @click="getBooks(pagination.prev)" :class="pagination.prev ? '' : 'disabled'" class="btn btn-success"> &lt;&lt;  Prev </button> {{ meta.current_page }} of {{ meta.last_page }} <button @click="getBooks(pagination.next)" :class="pagination.next ? '' : 'disabled'" class="btn btn-success"> Next &gt;&gt;  </button>
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

		data() {
			return {
                books : '',
                query : null,
                pagination : '',
                meta : '',
			}
        },
        
        mounted() {
            this.getBooks();
        },

		methods : {
			getBooks($url = '/api/school/library/book/view/all'){
                if($url==null) return ;
                
				this.$loading(true);
				axios.get($url)
				.then((res) => {
					this.books = res.data.data,
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

            searchByTerm() {
                if(this.query == null || this.query == '') return ;
                 this.$loading(true);
				axios.get(`/api/school/library/book/view/all?query=${this.query}`)
				.then((res) => {
					this.books = res.data.data,
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

            editBook(id){
                this.$confirm("Are you sure you want to edit this Book?","Edit Book",'question').then(() => {
                this.$router.push({
                        name: 'edit-library-book',
                        params: { bookID: id }
                        });
                });
            },

            deleteBook(id){
                this.$confirm("Are you sure you want delete this Book?","Delete Book",'warning').then(() => {
                this.$loading(true)
                axios.delete(`/api/school/library/book/${id}/delete`)
                .then((response) => {
                    this.$loading(false);
                    this.$alert(response.data.data.message,"Successful","success");
                    this.getCategories();
				})
				.catch((error) => {
                    this.$loading(false);

					if (!error.response) {
						this.$alert("You do not have internet access","Network Error","error");
						return ;
					}

                    if(error.response.status === 403) {
						this.$alert("Sorry, you do not have the permission to perfrom this action","No Permission","error");
                    }
                    
                    if(error.response.status === 422) {
						this.$alert("This Category still has Books attached to it, move or delete those Books first","Books Attached","error");
					}
				})
                });
            }

		}
    }
</script>
