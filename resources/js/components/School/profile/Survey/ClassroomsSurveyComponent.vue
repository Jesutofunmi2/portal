<template>
   <div class="row match-height">
		<div class="col-md-12 ">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-tooltip">School Survey: Classrooms</h4>
					
					<SurveyProgress :currentPage="4"></SurveyProgress>
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

						<form class="form" novalidate @submit.prevent="submitSurvey">
							<div class="form-body">
								<div class="row form-group">
									<table class="table" width="100%">
                        <tr>
                            <td>
                                How many Classrooms are there in the school?
                            </td>
                            <td class="input-group">
                                <input type="number" v-model="classrooms.school_classrooms" name="" id="" class="form-control">
                                <span class="input-group-addon" style="margin-left: -10px;">Number</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Are any Classes held Outside (because classrooms are unusable or insufficient)?
                            </td>
                            <td>
                                <select name="" v-model="classrooms.outside_class" id="" class="form-control">
                                    <option selected disabled>Select</option>
                                    <option>Yes</option>
                                    <option>No</option>
                                </select>
                            </td>
                        </tr>
                            </table>	
						</div>
						
					 <br>
                    
                     <h5>Information on all classrooms</h5><br>
						<div class="row form-group">
                            <div class="col-md-4">
                            <label for="">Year of Construction</label>
                            <input type="number" v-model="classrooms_list.year_of_construction" name="" id="" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="">Present Condition</label>
                            <select name="" v-model="classrooms_list.present_condition" id="" class="form-control">
                                <option>Good</option>
                                <option>Needs Minor Repairs</option>
                                <option>Needs Major Repairs</option>
                                <option>Under Construction</option>
                                <option>Unusable</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="">Lenght in Metres</label>
                            <div class="input-group">
                                <input type="number" v-model="classrooms_list.length_in_meters" name="" id="" class="form-control">
                                <span class="input-group-addon" style="margin-left: -5px;">Metres</span>
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-4">
                            <label for="">Width in Metres</label>
                            <div class="input-group">
                                <input type="number" v-model="classrooms_list.width_in_meters" name="" id="" class="form-control">
                                <span class="input-group-addon" style="margin-left: -5px;">Metres</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="">Floor Material</label>
                            <select name="" v-model="classrooms_list.floor_material" id="" class="form-control">
                                <option>Mud / Earth</option>
                                <option>Concrete</option>
                                <option>Wood</option>
                                <option>Tile / Terrazo</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="">Wall Material</label>
                            <select name="" v-model="classrooms_list.wall_material" id="" class="form-control">
                                <option>Mud / Earth</option>
                                <option>Cement / Concrete</option>
                                <option>Wood / Bamboo</option>
                                <option>Burnt Bricks</option>
                                <option>Iron Sheet</option>
                                <option>Stone</option>
                                <option>No Walls / Dwarf Walls</option>
                            </select>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-4"><br>
                            <label for="">Roof Material</label> <br><br> 
                            <select name="" id="" v-model="classrooms_list.roof_material" class="form-control">
                                <option>Mud</option>
                                <option>Cement / Concrete</option>
                                <option>Wood / Bamboo</option>
                                <option>Burnt Bricks</option>
                                <option>Iron Sheet</option>
                                <option>Abestos</option>
                                <option>No Roof</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="">Seating</label> <br> 
                            <span style="font-size: 13px;">Are there enough seats for the children in this classrooom?</span>
                            <select name="" v-model="classrooms_list.seating" id="" class="form-control">
                                <option>Yes</option>
                                <option>No</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="">Good Blackboard</label> <br> 
                            <span style="font-size: 12px;">Does the School have good Blackboard that the studentd can read from?</span>
                            <select name="" id="" v-model="classrooms_list.writing_board" class="form-control">
                                <option>Yes</option>
                                <option>No</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row form-group">
                        <div class="col-md-12">
                            <table class="table" width="100%">
                                <h6>Number of Rooms other than classrooms are there in the school by type of room?</h6>
                                <tr>
                                    <td>
                                        Staff Room
                                    </td>
                                    <td class="input-group">
                                        <input type="number" v-model="classrooms.staff_room" name="" id="" class="form-control">
                                        <span class="input-group-addon" style="margin-left: -5px;">Number</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Offices
                                    </td>
                                    <td class="input-group">
                                        <input type="number" name="" v-model="classrooms.office_room" id="" class="form-control">
                                        <span class="input-group-addon" style="margin-left: -5px;">Number</span>
                                    </td>
                                </tr>
                                    <tr>
                                        <td>
                                            Library
                                        </td>
                                        <td class="input-group">
                                            <input type="number" v-model="classrooms.library_room" name="" id="" class="form-control">
                                            <span class="input-group-addon" style="margin-left: -5px;">Number</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Laboratories
                                        </td>
                                        <td class="input-group">
                                            <input type="number" v-model="classrooms.laboratory_room" name="" id="" class="form-control">
                                            <span class="input-group-addon" style="margin-left: -5px;">Number</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Store Rooms
                                        </td>
                                        <td class="input-group">
                                            <input type="number" v-model="classrooms.store_room" name="" id="" class="form-control">
                                            <span class="input-group-addon" style="margin-left: -5px;">Number</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Others
                                        </td>
                                        <td class="input-group">
                                            <input type="number" v-model="classrooms.others_room" name="" id="" class="form-control">
                                            <span class="input-group-addon" style="margin-left: -5px;">Number</span>
                                        </td>
                                    </tr>
                            </table>
                        </div>
                    </div>
                    <br>

                    <h5>Information on all workshops</h5><br>
					<div class="row form-group">
                        <div class="col-md-4"><br>
                            <label for="">Type of Workshop</label>
                            <select name="" v-model="classrooms_list.present_condition" id="" class="form-control">
                                <option> Electrical installation</option>
                                <option>Computer Operation</option>
                                <option>Basic Computer Electronics</option>
                                <option>Computer Programming</option>
                                <option>Wood Metal Finishing</option>
                                <option>Furniture Design and Construction</option>
                                <option>Automechics</option>
                                <option>Building Construction</option>
                                <option>General Woodwork </option>
                                <option>Electrical/Electronics</option>
                                <option> Clothing & Textile Design </option>
                                <option>Upholstery</option>
                                <option>Introduction to Building </option>
                                <option>Walls, Floors and Ceiling Finishing </option>
                                <option>Concreting </option>
                                <option>Garment Construction </option>
                                <option>Brick, Block Laying </option>
                                <option>Refrigeration And Air Conditioning </option>
                                <option>Fabrication And Welding  </option>
                                <option>Plumbing  </option>
                                <option>Technical drawing studies </option>
                                <option>Mechanical crafting</option>
                                <option>Printing </option>
                                <option>Agricultural mechanization </option>
                                <option>Catering </option>
                                <option>Carpenter and Joinery</option>   
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="">Shared</label>
                            <span style="font-size: 13px;">Is the workshop shared with another school(s)?</span>
                            <select name="" v-model="classrooms_list.seating" id="" class="form-control">
                                <option>Yes</option>
                                <option>No</option>
                            </select>
                        </div>
                        <div class="col-md-4"><br>
                            <label for="">Year of Construction</label>
                            <input type="number" v-model="classrooms_list.year_of_construction" name="" id="" class="form-control">
                        </div>
                    </div>

                    <div class="row form-group">
                         <div class="col-md-4">
                            <label for="">Present Condition</label>
                            <select name="" v-model="classrooms_list.present_condition" id="" class="form-control">
                                <option>Good</option>
                                <option>Needs Minor Repairs</option>
                                <option>Needs Major Repairs</option>
                                <option>Under Construction</option>
                                <option>Unusable</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="">Lenght in Metres</label>
                            <div class="input-group">
                                <input type="number" v-model="classrooms_list.length_in_meters" name="" id="" class="form-control">
                                <span class="input-group-addon" style="margin-left: -5px;">Metres</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="">Width in Metres</label>
                            <div class="input-group">
                                <input type="number" v-model="classrooms_list.width_in_meters" name="" id="" class="form-control">
                                <span class="input-group-addon" style="margin-left: -5px;">Metres</span>
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-4">
                            <label for="">Floor Material</label>
                            <select name="" v-model="classrooms_list.floor_material" id="" class="form-control">
                                <option>Mud / Earth</option>
                                <option>Concrete</option>
                                <option>Wood</option>
                                <option>Tile / Terrazo</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="">Wall Material</label>
                            <select name="" v-model="classrooms_list.wall_material" id="" class="form-control">
                                <option>Mud / Earth</option>
                                <option>Cement / Concrete</option>
                                <option>Wood / Bamboo</option>
                                <option>Burnt Bricks</option>
                                <option>Iron Sheet</option>
                                <option>Stone</option>
                                <option>No Walls / Dwarf Walls</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="">Roof Material</label> 
                            <select name="" id="" v-model="classrooms_list.roof_material" class="form-control">
                                <option>Mud</option>
                                <option>Cement / Concrete</option>
                                <option>Wood / Bamboo</option>
                                <option>Burnt Bricks</option>
                                <option>Iron Sheet</option>
                                <option>Abestos</option>
                                <option>No Roof</option>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-4">
                            <label for="">Seating</label> <br> 
                            <span style="font-size: 13px;">Are there enough seats for the children in this classrooom?</span>
                            <select name="" v-model="classrooms_list.seating" id="" class="form-control">
                                <option>Yes</option>
                                <option>No</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="">Good Blackboard</label> <br> 
                            <span style="font-size: 12px;">Does the School have good Blackboard that the studentd can read from?</span>
                            <select name="" id="" v-model="classrooms_list.writing_board" class="form-control">
                                <option>Yes</option>
                                <option>No</option>
                            </select>
                        </div>
                    </div>

					</div>

						</form>
							<div class="form-actions">
                                 <button v-if="! is_submitted" type="submit" class="btn btn-info" 
								 @click="addStaff()">
									<i class="icon-plus3"></i> Add New
								</button>
								<button type="submit" v-if="! is_submitted" class="btn btn-success" 
								 @click="submitSurvey()">
									<i class="icon-check2"></i> Save
								</button>
								<button type="button" class="btn btn-warning mr-1" @click="previousStage()">
									&lt;&lt; Previous Stage
								</button>
								<button type="button" class="btn btn-primary mr-1" @click="nextStage()">
									Next Stage &gt;&gt;
								</button>
							</div>
							
					</div>

                    <section id="accordion">
                            <div class="row match-height">
                                <div class="col-lg-12 col-xl-12">
                        
                                    <div id="accordionWrapa1" role="tablist" aria-multiselectable="true">
                                        <div class="card">
                                            
                                            <div v-for="class_room, index in classrooms.classrooms_data" :key="index">
                                                <div :id="'heading'+index"  class="card-header">
                                                    <a data-toggle="collapse" data-parent="#accordionWrapa1" :href="'#accordion'+index" aria-expanded="true" aria-controls="accordion1" class="card-title lead">Class room {{index + 1}}</a>
                                                </div>
                                                <div :id="'accordion'+index" role="tabpanel" :aria-labelledby="'heading'+index" class="card-collapse collapse in" aria-expanded="true">
                                                    <div class="card-body">
                                                        <div class="card-block">
                                                            <table class="table table-striped mb-0">
                                                                <tr>
                                                                    <td>Year of Construction: {{class_room.year_of_construction}}</td>
                                                                    <td>Present Condition: {{class_room.present_condition}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Lenght in Metres: {{class_room.length_in_meters}}</td>
                                                                    <td>Width in Metres: {{class_room.width_in_meters}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Floor Material: {{class_room.floor_material}}</td>
                                                                    <td>Wall Material: {{class_room.wall_material}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Roof Material: {{class_room.roof_material}}</td>
                                                                    <td>Seating: {{class_room.seating}}</td>
                                                                </tr>
                                                                 <tr>
                                                                    <td colspan="2">Writing Board: {{class_room.writing_board}}</td>
                                                                </tr>
                                                                 <tr>
                                                                   <button class="btn btn-danger" @click="removeRecord(index)">Remove Record</button>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <!-- Accordion end -->

				</div>
			</div>
		</div>
		<FlashMessage></FlashMessage>

	</div>
	
</template>

<script>
	import SurveyProgress from '../../../Shared/School/SurveyProgress.vue';
    export default {
		components: {
			SurveyProgress
		},

		data(){
			return {
				surveyId : this.$route.params.surveyId,
				classrooms : {
                    school_classrooms : null,
                    outside_class : null,
                    school_playrooms : null,
                    classrooms_data : [],
                    staff_room : null,
                    office_room : null,
                    library_room : null,
                    laboratory_room : null,
                    store_room : null,
                    others_room : null,
                },
                classrooms_list : {
                    year_of_construction : null,
                    present_condition : null,
                    length_in_meters : null,
                    width_in_meters : null,
                    floor_material : null,
                    wall_material : null,
                    roof_material : null,
                    seating : null,
                    writing_board : null,
                },
				validationErrors: [],
				survey: null,

                is_submitted : false
			}
		},
        mounted() {
			window.scrollTo(0, 0);
			this.getSurvey();
        },

		methods : {
			getSurvey() {
				this.$loading(true)
				axios.get(`/api/school/surveys/show?survey=${this.surveyId}`)
				.then((res) => {
					this.survey = res.data.data;
                    this.is_submitted = this.survey.submit_status;
					if(this.survey.class_rooms) {
                         this.classrooms = this.survey.class_rooms;
                    }

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
			
            submitSurvey() {
				let data = {
                    'survey' : this.surveyId,
                    'classrooms' : this.classrooms
                }

				this.$loading(true)

                axios.post('/api/school/surveys/create/classrooms', data)
				.then(response => {
					this.survey = response.data.data;
					this.$loading(false)
					this.flashMessage.success({
						title: 'Successful',
						message: 'Survey saved successfully',
						time: 15000,
						flashMessageStyle: {
							backgroundColor: 'linear-gradient(#e66465, #9198e5)'
						}
					});
					this.nextStage();
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
			},

            addStaff() {
                if(this.classrooms_list.year_of_construction == null || this.classrooms_list.present_condition == null) {
                    this.$alert("Please fill all required field", "Data Error","error");
                    return;
                }

                let class_data = {};

				Object.keys(this.classrooms_list).forEach(key => {
                    class_data[key] = this.classrooms_list[key]
                    this.classrooms_list[key] = null;
                });

                this.classrooms.classrooms_data.push(class_data);

                 this.flashMessage.success({
                    title: "Successful",
                    message: "Classroom added successfully",
                    time: 15000,
                    flashMessageStyle: {
                        backgroundColor: "linear-gradient(#e66465, #9198e5)"
                    }
                });
               
            },

            removeRecord(index) {
                if (index > -1) {
                    this.classrooms.classrooms_data.splice(index, 1); // 2nd parameter means remove one item only
                    this.flashMessage.success({
                    title: "Successful",
                    message: "Classroom reoved successfully",
                    time: 15000,
                    flashMessageStyle: {
                        backgroundColor: "linear-gradient(#e66465, #9198e5)"
                    }
                });
                }
            },

			nextStage() {
				// if(this.survey.class_rooms == null) {
				// 	this.$alert("Sorry, you have to complete this stage.","Not Allowed","error");
				// 	return;
				// }

				this.$router.push({
					name: 'facilities-school-survey',
					params: { surveyId: this.surveyId }
                });
			},

			previousStage() {
				
				this.$router.push({
					name: 'staff-school-survey',
					params: { surveyId: this.surveyId }
                });
			}
		}
    }
</script>

<style scoped>
.small_text {
	font-size: 0.8rem;
}
.move_down {
	padding-top: 20px;
}
</style>