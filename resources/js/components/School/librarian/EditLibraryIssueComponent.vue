<template>
   <div class="row match-height">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-tooltip">Edit Book Issuance</h4>
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

						<form class="form" @submit.prevent="updateBookIssued">
							<div class="form-body">

								<div class="form-group col-md-6">
									<label for="issueinput0">Book</label>
									<input type="text" id="issueinput0" v-model="issue.title" class="form-control" placeholder="Book" name="book" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Book" readonly>
								</div>

								<div class="form-group col-md-6">
									<label for="issueinput1">Issued To</label>
									<input type="text" id="issueinput1" v-model="fullName" class="form-control" placeholder="Student" name="student" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Issued To" readonly>
								</div>

								<div class="form-group col-md-6">
									<label for="issueinput4">Issuance Date</label>
									<input type="text" id="issueinput4" @keydown="validationErrors.issue_date=null" :class="{'border-danger':validationErrors.issue_date}" v-model="issue.issue_date" class="form-control" placeholder="YYYY-mm-dd" name="issue_date" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Issuance Date" readonly>
									<span v-if="validationErrors.issue_date" :class="['label text-danger']">{{ validationErrors.issue_date[0] }}</span>
								</div>

								<div class="form-group col-md-6">
									<label for="issueinput6">Due Date</label>
									<input type="text" id="issueinput6" @keydown="validationErrors.due_date=null" :class="{'border-danger':validationErrors.due_date}" v-model="issue.due_date" class="form-control" placeholder="YYYY-mm-dd" name="due_date" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Due Date">
									<span v-if="validationErrors.due_date" :class="['label text-danger']">{{ validationErrors.due_date[0] }}</span>
								</div>

								<div class="form-group col-md-6">
									<label for="issueinput7">Return Date</label>
									<input type="text" id="issueinput7" @keydown="validationErrors.return_date=null" :class="{'border-danger':validationErrors.return_date}" v-model="issue.return_date" class="form-control" placeholder="YYYY-mm-dd" name="return_date" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Return Date">
									<span v-if="validationErrors.return_date" :class="['label text-danger']">{{ validationErrors.return_date[0] }}</span>
								</div>

								<div class="form-group col-md-6">
									<label for="issueinput11">Return Status</label>
									<select id="issueinput11" v-model="issue.return_status" @change="validationErrors.book_id=null" :class="{'border-danger':validationErrors.return_status}" class="form-control" name="return_status" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="return_status" required>
										<option value="">Select Status</option>
										<option value="0">Not Returned</option>
										<option value="1">Returned</option>
									</select>
									<span  v-if="validationErrors.return_status" :class="['label text-danger']">{{ validationErrors.return_status[0] }}</span>
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
				issueID : this.$route.params.issueID,
				issue : '',
				categories : '',
				validationErrors: [],
			}
		},

		computed : {
			fullName() {
				return `${this.issue.surname} ${this.issue.firstname} ${this.issue.middlename}`
			}
		}, 

        mounted() {
			this.getBookIssued();
        },

		methods : {			
			getBookIssued(){
				this.$loading(true)
				axios.get(`/api/school/library/issue/${this.issueID}/edit`)
				.then((res) => {
					this.issue = res.data.data,
				
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

            updateBookIssued(){
				let data = new FormData;
				data.append('due_date', this.issue.due_date);
				data.append('return_date', this.issue.return_date);
				data.append('return_status', this.issue.return_status);
				
				this.$loading(true)

                axios.post(`/api/school/library/issue/${this.issueID}/update`, data)
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
						this.getBookIssued();
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