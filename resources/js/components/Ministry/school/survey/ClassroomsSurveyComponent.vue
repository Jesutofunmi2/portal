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
                                <input readonly type="number" v-model="classrooms.school_classrooms" name="" id="" class="form-control">
                                <span class="input-group-addon" style="margin-left: -10px;">Number</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Are any Classes held Outside (because classrooms are unusable or insufficient)?
                            </td>
                            <td>
                                <select readonly name="" v-model="classrooms.outside_class" id="" class="form-control">
                                    <option selected disabled>Select</option>
                                    <option>Yes</option>
                                    <option>No</option>
                                </select>
                            </td>
                        </tr>
                            <tr>
                                <td>
                                    How many Playrooms are there in the school for ECCD?
                                </td>
                                <td class="input-group">
                                    <input readonly v-model="classrooms.school_playrooms" type="number" name="" id="" class="form-control">
                                    <span class="input-group-addon square" style="margin-left: -5px;">Number</span>
                                </td>
                            </tr>
                            </table>	
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
                                        <input readonly type="number" v-model="classrooms.staff_room" name="" id="" class="form-control">
                                        <span class="input-group-addon" style="margin-left: -5px;">Number</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Offices
                                    </td>
                                    <td class="input-group">
                                        <input readonly type="number" name="" v-model="classrooms.office_room" id="" class="form-control">
                                        <span class="input-group-addon" style="margin-left: -5px;">Number</span>
                                    </td>
                                </tr>
                                    <tr>
                                        <td>
                                            Library
                                        </td>
                                        <td class="input-group">
                                            <input readonly type="number" v-model="classrooms.library_room" name="" id="" class="form-control">
                                            <span class="input-group-addon" style="margin-left: -5px;">Number</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Laboratories
                                        </td>
                                        <td class="input-group">
                                            <input readonly type="number" v-model="classrooms.laboratory_room" name="" id="" class="form-control">
                                            <span class="input-group-addon" style="margin-left: -5px;">Number</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Store Rooms
                                        </td>
                                        <td class="input-group">
                                            <input readonly type="number" v-model="classrooms.store_room" name="" id="" class="form-control">
                                            <span class="input-group-addon" style="margin-left: -5px;">Number</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Others
                                        </td>
                                        <td class="input-group">
                                            <input readonly type="number" v-model="classrooms.others_room" name="" id="" class="form-control">
                                            <span class="input-group-addon" style="margin-left: -5px;">Number</span>
                                        </td>
                                    </tr>
                            </table>
                        </div>
                    </div>
                   

					</div>

						</form>
							<div class="form-actions">
								<button type="button" class="btn btn-warning mr-1" @click="previousStage()">
									&lt;&lt; Previous Stage
								</button>
								<button type="button" class="btn btn-primary mr-1" @click="nextStage()">
									Next Stage &gt;&gt;
								</button>
							</div>
							
					</div>

                    <section id="accordion">
                            <div class="row">
                                <div class="col-xs-12 mt-1">
                                    <h4>Information on all classrooms/play rooms</h4>
                                    <hr>
                                </div>
                            </div>
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
				axios.get(`/api/ministry/school/survey/show?survey=${this.surveyId}`)
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
							name: 'ministry-login',
							params: { return_url: return_url }
							});
					}

                    if(error.response.status === 403){
						this.$alert("Sorry, you do not have the permission to perfrom this action","No Permission","error");
					}
				})
			},

			nextStage() {
				
				this.$router.push({
					name: 'ministry-facilities-school-survey',
					params: { surveyId: this.surveyId }
                });
			},

			previousStage() {
				
				this.$router.push({
					name: 'ministry-staff-school-survey',
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