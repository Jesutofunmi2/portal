<template>
   <div class="row match-height">
		<div class="col-md-12 ">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-tooltip">Issue Book</h4>
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

						<form class="form" novalidate @submit.prevent="addIssue">
							<div class="form-body">

								<div class="form-group col-md-6">
									<label for="issueinput0">Book</label>
									<select id="issueinput0" v-model="issue.book_id" @change="validationErrors.book_id=null" :class="{'border-danger':validationErrors.book_id}" class="form-control" name="book_id" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Book" required>
										<option value="">Select Book</option>
										<option :value="bk.id" v-for ="(bk ,index) in books" :key ="index" >{{ bk.title }}</option>
									</select>
									<span  v-if="validationErrors.book_id" :class="['label text-danger']">{{ validationErrors.book_id[0] }}</span>
								</div>

								<div class="form-group col-md-6">
									<label for="issueinput0">Issue To</label>
									<select id="issueinput0" v-model="issue.issued_to" @change="validationErrors.book_id=null" :class="{'border-danger':validationErrors.issued_to}" class="form-control" name="issued_to" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Issue To" required>
										<option value="">Select Student</option>
										<option :value="stud.id" v-for ="(stud ,index) in students" :key ="index" >
											{{ stud.surname }} {{ stud.firstname }} {{ stud.middlename }}
										</option>
									</select>
									<span  v-if="validationErrors.issued_to" :class="['label text-danger']">{{ validationErrors.issued_to[0] }}</span>
								</div>

								<div class="form-group col-md-6">
									<label for="issueinput4">Issuance Date</label>
									<input type="text" id="issueinput4" @keydown="validationErrors.issue_date=null" :class="{'border-danger':validationErrors.issue_date}" v-model="issue.issue_date" class="form-control" placeholder="YYYY-mm-dd" name="issue_date" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Issuance Date">
									<span v-if="validationErrors.issue_date" :class="['label text-danger']">{{ validationErrors.issue_date[0] }}</span>
								</div>

								<div class="form-group col-md-6">
									<label for="issueinput6">Due Date</label>
									<input type="text" id="issueinput6" @keydown="validationErrors.due_date=null" :class="{'border-danger':validationErrors.due_date}" v-model="issue.due_date" class="form-control" placeholder="YYYY-mm-dd" name="due_date" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Due Date">
									<span v-if="validationErrors.due_date" :class="['label text-danger']">{{ validationErrors.due_date[0] }}</span>
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
				issue : {
					'book_id' : '', 
					'issued_to' : '', 
					'issue_date' : '', 
					'due_date' : '', 
				},
				students : '',
				books : '',
				validationErrors: [],
			}
		},
        mounted() {
			this.getStudents();
        },

		methods : {
			getBooks($url = '/api/school/library/book/viewall') {
                if($url==null) return ;
                
				this.$loading(true);
				axios.get($url)
				.then((res) => {
					this.books = res.data.data,
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
			
			getStudents($url = '/api/school/student/view/all') {
				if($url == null) return ;
                
				this.$loading(true);
				axios.get($url)
				.then((res) => {
					this.students = res.data.data,
					this.$loading(false);
					this.getBooks();
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

			addIssue() {
				let data = new FormData;
				data.append('book_id', this.issue.book_id);
				data.append('issued_to', this.issue.issued_to);
				data.append('issue_date', this.issue.issue_date);
				data.append('due_date', this.issue.due_date);

				this.$loading(true)

                axios.post('/api/school/library/issue/add', data)
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
					
					this.issue.book_id = null;
					this.issue.issue_to = null;
					this.issue.issue_date = null;
					this.issue.due_date = null;
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