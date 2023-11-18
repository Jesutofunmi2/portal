<template>
   <div class="row match-height">
		<div class="col-md-12 ">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-tooltip">School Survey: Facilities</h4>
					
					<SurveyProgress :currentPage="5"></SurveyProgress>
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
								<div class="row">
            <div class="col-md-6">
                <label for="" Style="Font-weight:bold">Select Source of Drinking Water</label><br>
                <span class="small">Is there a source of water in the school that is safe to drink and in sufficient quantity to provide water every day for pupils? If there is more than one source, select only the primary source.</span>
            </div>
            <div class="col-md-6"> <br> <br>
                <select readonly v-model="facilities.source_of_water" name="" id="" class="form-control">
                    <option selected disabled>Select</option>
                    <option>Pipe Borne Water</option>
                    <option>Borehole</option>
                    <option>Well</option>
                    <option>No Source of Safe Water</option>
                </select>
            </div>
        </div>
		<br>
		<div class="row">
            <div class="col-md-12">
                <label for="" Style="Font-weight:bold">Total Number of Facilities Available in Your School</label> <br>
                <span class="small"> How many Usable Facilities does the school have? (If none, write "0")</span>
                <table border="1px" style="border-collapse: collapse;" width="100%">
                    <tr>
                        <th width="100"></th>
                        <th>Toilet</th>
                        <th>Computers</th>
                        <th>Water Source(s)</th>
                        <th>Laboratories</th>
                        <th>Classrooms</th>
                        <th>Library</th>
                        <th>Play Ground(s)</th>
                        <th>Wash Hand Basin</th>
                        <th>Radio</th>
                        <th>Internet Facilities</th>
                        <th>COVID 19 Kits</th>
                        <th>Perimeter Fence</th>
                        <th>Others</th>
                    </tr>
                    <tr>
                        <th>Usable</th>
                        <td><input readonly v-model="facilities.facilities_toilet_useable" type="number" name="" id="" style="width:100%"></td>
                        <td><input readonly v-model="facilities.facilities_computer_useable" type="number" name="" id="" style="width:100%"></td>
                        <td><input readonly v-model="facilities.facilities_water_useable" type="number" name="" id="" style="width:100%"></td>
                        <td><input readonly v-model="facilities.facilities_laboratories_useable" type="number" name="" id="" style="width:100%"></td>
                        <td><input readonly v-model="facilities.facilities_classrooms_useable" type="number" name="" id="" style="width:100%"></td>
                        <td><input readonly v-model="facilities.facilities_library_useable" type="number" name="" id="" style="width:100%"></td>
                        <td><input readonly v-model="facilities.facilities_playground_useable" type="number" name="" id="" style="width:100%"></td>
                        <td><input readonly v-model="facilities.facilities_handwash_useable" type="number" name="" id="" style="width:100%"></td>
                        <td><input readonly v-model="facilities.facilities_radio_useable" type="number" name="" id="" style="width:100%"></td>
                        <td><input readonly v-model="facilities.facilities_internet_useable" type="number" name="" id="" style="width:100%"></td>
                        <td><input readonly v-model="facilities.facilities_covid_useable" type="number" name="" id="" style="width:100%"></td>
                        <td><input readonly v-model="facilities.facilities_perimeter_useable" type="number" name="" id="" style="width:100%"></td>
                        <td><input readonly v-model="facilities.facilities_others_useable" type="number" name="" id="" style="width:100%"></td>
                    </tr>
                    <tr>
                        <th>Not Usable</th>
                        <td><input readonly v-model="facilities.facilities_toilet_not_useable" type="number" name="" id="" style="width:100%"></td>
                        <td><input readonly v-model="facilities.facilities_computer_not_useable" type="number" name="" id="" style="width:100%"></td>
                        <td><input readonly v-model="facilities.facilities_water_not_useable" type="number" name="" id="" style="width:100%"></td>
                        <td><input readonly v-model="facilities.facilities_laboratories_not_useable" type="number" name="" id="" style="width:100%"></td>
                        <td><input readonly v-model="facilities.facilities_classrooms_not_useable" type="number" name="" id="" style="width:100%"></td>
                        <td><input readonly v-model="facilities.facilities_library_not_useable" type="number" name="" id="" style="width:100%"></td>
                        <td><input readonly v-model="facilities.facilities_playground_not_useable" type="number" name="" id="" style="width:100%"></td>
                        <td><input readonly v-model="facilities.facilities_handwash_not_useable" type="number" name="" id="" style="width:100%"></td>
                        <td><input readonly v-model="facilities.facilities_radio_not_useable" type="number" name="" id="" style="width:100%"></td>
                        <td><input readonly v-model="facilities.facilities_internet_not_useable" type="number" name="" id="" style="width:100%"></td>
                        <td><input readonly v-model="facilities.facilities_covid_not_useable" type="number" name="" id="" style="width:100%"></td>
                        <td><input readonly v-model="facilities.facilities_perimeter_not_useable" type="number" name="" id="" style="width:100%"></td>
                        <td><input readonly v-model="facilities.facilities_others_not_useable" type="number" name="" id="" style="width:100%"></td>
                    </tr>
                </table>
            </div>
        </div>
		<br>
		   <div class="row">
            <div class="col-md-12">
                <label for="" Style="Font-weight:bold">Shared Facilities</label> <br>
                <span class="small" >If your school shares Facilities, specify by ticking the appropriate box</span>
                <div style="font-size: 16px;">
                    <input readonly v-model="facilities.facilities_shared_toilet" type="checkbox" name="" id="" >
                    <label for="" class="mr-2">Toilet</label>   
                    <input readonly v-model="facilities.facilities_shared_computer" type="checkbox" name="" id="" >
                    <label for="" class="mr-2">Computers</label>
                    <input readonly v-model="facilities.facilities_shared_water" type="checkbox" name="" id="" >
                    <label for="" class="mr-2">Water Source(s)</label>
                    <input readonly v-model="facilities.facilities_shared_laboratory" type="checkbox" name="" id="" >
                    <label for="" class="mr-2">Laboratories</label>
                    <input readonly v-model="facilities.facilities_shared_classrooms" type="checkbox" name="" id="" >
                    <label for="" class="mr-2">Classrooms</label>
                    <input readonly v-model="facilities.facilities_shared_library" type="checkbox" name="" id="" >
                    <label for="" class="mr-2">Library</label>
                    <input readonly v-model="facilities.facilities_shared_playground" type="checkbox" name="" id="" >
                    <label for="" class="mr-2">Play Ground(s)</label>
                    <input readonly v-model="facilities.facilities_shared_others" type="checkbox" name="" id="" >
                    <label for="" class="mr-2">Others</label>
                </div>
            </div>
        </div>
		<br>
		<div class="row">
            <div class="col-md-12">
                <div>
                    <P style="font-weight: bold;">Please count the number of Usable Toilet by each type below. </P>
                </div>
                <table border="1px" style="border-collapse: collapse;" width="">
                    <tr>
                        <th width="12%">Toilet Type</th>
                        <th width="26%">Used only by Pupils
                            <table border="1px" style="border-collapse: collapse;" width="100%">
                                <tr>
                                    <td width="33%">
                                        Male
                                    </td>
                                    <td width="34%">
                                        Female
                                    </td>
                                    <td width="34%">
                                        Mixed
                                    </td>
                                </tr>
                            </table>
                        </th>
                        <th width="26%">Used only by Teachers
                            <table border="1px" style="border-collapse: collapse;"  width="100%">
                                <tr>
                                    <td width="33%">
                                        Male
                                    </td>
                                    <td width="34%">
                                        Female
                                    </td>
                                    <td width="34%">
                                        Mixed
                                    </td>
                                </tr>
                            </table>
                        </th>
                        <th width="26%">Used by Pupils and Teachers
                            <table border="1px" style="border-collapse: collapse;"  width="100%">
                                <tr>
                                    <td width="33%">
                                        Male
                                    </td>
                                    <td width="34%">
                                        Female
                                    </td>
                                    <td width="34%">
                                        Mixed
                                    </td>
                                </tr>
                            </table>
                        </th>
                        <th width="8%">Total</th>
                    </tr>
                    <tr>
                        <th>
                            Pit
                        </th>
                        <td>
                            <table>
                                <tr>
                                    <td>
                                        <input readonly v-model="facilities.pupils_male_pit" type="number" name="" id="" style="width: 100%">
                                    </td>
                                    <td>
                                        <input readonly v-model="facilities.pupils_female_pit" type="number" name="" id="" style="width: 100%">
                                    </td>
                                    <td>
                                        <input readonly v-model="facilities.pupils_mixed_pit" type="number" name="" id="" style="width: 100%">
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table>
                                <tr>
                                    <td>
                                        <input readonly v-model="facilities.teachers_male_pit" type="number" name="" id="" style="width: 100%">
                                    </td>
                                    <td>
                                        <input readonly v-model="facilities.teachers_female_pit" type="number" name="" id="" style="width: 100%">
                                    </td>
                                    <td>
                                        <input readonly v-model="facilities.teachers_mixed_pit" type="number" name="" id="" style="width: 100%">
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table>
                                <tr>
                                    <td>
                                        <input readonly v-model="facilities.teacher_pupils_male_pit" type="number" name="" id="" style="width: 100%">
                                    </td>
                                    <td>
                                        <input readonly v-model="facilities.teacher_pupils_female_pit" type="number" name="" id="" style="width: 100%">
                                    </td>
                                    <td>
                                        <input readonly v-model="facilities.teacher_pupils_mixed_pit" type="number" name="" id="" style="width: 100%">
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <input readonly v-model="facilities.total_pit" type="number" name="" id="" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Bucket System
                        </th>
                        <td>
                            <table>
                                <tr>
                                    <td>
                                        <input readonly v-model="facilities.pupils_male_bucket_system" type="number" name="" id="" style="width: 100%">
                                    </td>
                                    <td>
                                        <input readonly v-model="facilities.pupils_female_bucket_system" type="number" name="" id="" style="width: 100%">
                                    </td>
                                    <td>
                                        <input readonly v-model="facilities.pupils_mixed_bucket_system" type="number" name="" id="" style="width: 100%">
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table>
                                <tr>
                                    <td>
                                        <input readonly v-model="facilities.teachers_male_bucket_system" type="number" name="" id="" style="width: 100%">
                                    </td>
                                    <td>
                                        <input readonly v-model="facilities.teachers_female_bucket_system" type="number" name="" id="" style="width: 100%">
                                    </td>
                                    <td>
                                        <input readonly v-model="facilities.teachers_mixed_bucket_system" type="number" name="" id="" style="width: 100%">
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table>
                                <tr>
                                    <td>
                                        <input readonly v-model="facilities.teacher_pupils_male_bucket_system" type="number" name="" id="" style="width: 100%">
                                    </td>
                                    <td>
                                        <input readonly v-model="facilities.teacher_pupils_female_bucket_system" type="number" name="" id="" style="width: 100%">
                                    </td>
                                    <td>
                                        <input readonly v-model="facilities.teacher_pupils_mixed_bucket_system" type="number" name="" id="" style="width: 100%">
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <input readonly v-model="facilities.total_bucket_system" type="number" name="" id="" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <th>
                           Water Flush
                        </th>
                        <td>
                            <table>
                                <tr>
                                    <td>
                                        <input readonly v-model="facilities.pupils_male_water_flush" type="number" name="" id="" style="width: 100%">
                                    </td>
                                    <td>
                                        <input readonly v-model="facilities.pupils_female_water_flush" type="number" name="" id="" style="width: 100%">
                                    </td>
                                    <td>
                                        <input readonly v-model="facilities.pupils_mixed_water_flush" type="number" name="" id="" style="width: 100%">
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table>
                                <tr>
                                    <td>
                                        <input readonly v-model="facilities.teachers_male_water_flush" type="number" name="" id="" style="width: 100%">
                                    </td>
                                    <td>
                                        <input readonly v-model="facilities.teachers_female_water_flush" type="number" name="" id="" style="width: 100%">
                                    </td>
                                    <td>
                                        <input readonly v-model="facilities.teachers_mixed_water_flush" type="number" name="" id="" style="width: 100%">
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table>
                                <tr>
                                    <td>
                                        <input readonly v-model="facilities.teacher_pupils_male_water_flush" type="number" name="" id="" style="width: 100%">
                                    </td>
                                    <td>
                                        <input readonly v-model="facilities.teacher_pupils_female_water_flush" type="number" name="" id="" style="width: 100%">
                                    </td>
                                    <td>
                                        <input readonly v-model="facilities.teacher_pupils_mixed_water_flush" type="number" name="" id="" style="width: 100%">
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <input readonly v-model="facilities.total_water_flush" type="number" name="" id="" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <th>
                           Others
                        </th>
                        <td>
                            <table>
                                <tr>
                                    <td>
                                        <input readonly v-model="facilities.pupils_male_others" type="number" name="" id="" style="width: 100%">
                                    </td>
                                    <td>
                                        <input readonly v-model="facilities.pupils_female_others" type="number" name="" id="" style="width: 100%">
                                    </td>
                                    <td>
                                        <input readonly v-model="facilities.pupils_mixed_others" type="number" name="" id="" style="width: 100%">
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table>
                                <tr>
                                    <td>
                                        <input readonly v-model="facilities.teachers_male_others" type="number" name="" id="" style="width: 100%">
                                    </td>
                                    <td>
                                        <input readonly v-model="facilities.teachers_female_others" type="number" name="" id="" style="width: 100%">
                                    </td>
                                    <td>
                                        <input readonly v-model="facilities.teachers_mixed_others" type="number" name="" id="" style="width: 100%">
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table>
                                <tr>
                                    <td>
                                        <input readonly v-model="facilities.teacher_pupils_male_others" type="number" name="" id="" style="width: 100%">
                                    </td>
                                    <td>
                                        <input readonly v-model="facilities.teacher_pupils_female_others" type="number" name="" id="" style="width: 100%">
                                    </td>
                                    <td>
                                        <input readonly v-model="facilities.teacher_pupils_mixed_others" type="number" name="" id="" style="width: 100%">
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <input readonly v-model="facilities.total_others" type="number" name="" id="" style="width: 100%">
                        </td>
                    </tr>
                </table>
                
            </div>
        </div>
		<br>
		<div class="row">
            <div class="col-md-12">
                <label for="" Style="Font-weight:bold">Source of Power</label> <br>
                <span class="small">Is there source of power in the school?</span>
                <div style="font-size: 16px;">
                    <input readonly v-model="facilities.nepa_power_source" type="checkbox" name="" id="" >
                    <label for="" class="mr-2">PHCN / NEPA</label>   
                    <input readonly v-model="facilities.generator_power_source" type="checkbox" name="" id="" >
                    <label for="" class="mr-2">Generator</label>
                    <input readonly v-model="facilities.solar_power_source" type="checkbox" name="" id="" >
                    <label for="" class="mr-2">Solar</label>
                    <input readonly v-model="facilities.no_power_source" type="checkbox" name="" id="" >
                    <label for="" class="mr-2">No source of Power</label>
                </div>
            </div>
        </div>
		<br>
		<div class="row">
            <div class="col-md-12">
                <label for="" Style="Font-weight:bold">Health Facility</label> <br>
                <span class="small">Does the school have a health facility?</span>
                <div style="font-size: 16px;">
                    <input readonly v-model="facilities.health_clinic" type="checkbox" name="" id="" >
                    <label for="" class="mr-2">Health Clinic</label>   
                    <input readonly v-model="facilities.first_aid" type="checkbox" name="" id="" >
                    <label for="" class="mr-2">First Aid Kits</label>
                    <input readonly v-model="facilities.no_health_facilities" type="checkbox" name="" id="" >
                    <label for="" class="mr-2">No Health Facility</label>
                </div>
            </div>
        </div>
		<br>
		<div class="row">
            <div class="col-md-6">
                <label for="" style="font-weight: bold;">Fence / Wall</label> <br>
                <span class="small">Does the school have a fence or wall around it? </span>
                <select readonly v-model="facilities.school_fence_wall" name="" id="" class="form-control">
                    <option value="none" selected disabled>Select</option>
                    <option value="1">In Good Condition</option>
                    <option value="2">Needs Minor Repairs</option>
                    <option value="3">Needs Major Repairs</option>
                    <option value="4">No Fence or Wall</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="" style="font-weight: bold;">Play Room</label> <br>
                <span class="small">Does the school have a playroom for ECCD?</span>
                <select readonly v-model="facilities.school_play_room" name="" id="" class="form-control">
                    <option value="none" selected disabled>Select</option>
                    <option value="1">Yes But no Rugs or Sand Floor</option>
                    <option value="2">Yes With Play Rugs</option>
                    <option value="3">Yes With Sand Floor</option>
                    <option value="4">No Play Room</option>
                </select>
            </div>
        </div>
		<br>
		<div class="row">
                <div class="col-md-12">
                    <label for="" Style="Font-weight:bold">Play Facilities</label> <br>
                    <span class="small">Does the school have play facilities for ECCD? Tick all that apply</span>
                    <div style="font-size: 16px;">
                        <input readonly v-model="facilities.play_facilities_merry_go_round" type="checkbox" name="" id="" >
                        <label for="" class="mr-2">Merry Go Round</label>   
                        <input readonly v-model="facilities.play_facilities_swing" type="checkbox" name="" id="" >
                        <label for="" class="mr-2">Swing</label>
                        <input readonly v-model="facilities.play_facilities_ladder_slide" type="checkbox" name="" id="" >
                        <label for="" class="mr-2">Ladder Slide</label>
                        <input readonly v-model="facilities.play_facilities_see_saw" type="checkbox" name="" id="" >
                        <label for="" class="mr-2">See Saw</label>
                        <input readonly v-model="facilities.play_facilities_indoor" type="checkbox" name="" id="" >
                        <label for="" class="mr-2">Indoor Play Activity Materials</label>
                    </div>
                </div>
            </div>
			<br>
			<div class="row">
                <div class="col-md-12">
                    <label for="" Style="Font-weight:bold">Learning Materials</label> <br>
                    <span class="small">Does the School have Learning Materials? Tick all that apply</span>
                    <div style="font-size: 16px;">
                        <input readonly v-model="facilities.learning_material_chart" type="checkbox" name="" id="" >
                        <label for="" class="mr-2">Charts</label>   
                        <input readonly v-model="facilities.learning_material_poster" type="checkbox" name="" id="" >
                        <label for="" class="mr-2">Posters</label>
                        <input readonly v-model="facilities.learning_material_toys" type="checkbox" name="" id="" >
                        <label for="" class="mr-2">Toys</label>
                        <input readonly v-model="facilities.learning_material_audio_visual" type="checkbox" name="" id="" >
                        <label for="" class="mr-2">Audio / Visual(Radio, TV, DVD)</label>
                        <input readonly v-model="facilities.learning_material_word" type="checkbox" name="" id="" >
                        <label for="" class="mr-2">Word Puzzle Box</label>
                        <input readonly v-model="facilities.learning_material_caregiver" type="checkbox" name="" id="" >
                        <label for="" class="mr-2">Caregiver Guide</label>
                    </div>
                </div>
            </div>
			<br>
			 <div class="row">
                <div class="col-md-12">
                    <label for="" style="font-weight: bold;">Additional Information</label> <br>
                    <span class="small">Please indicate seating available by grade. Only count seats where both a seat and a writing desk are available.
                        Only seats and desks owned by the school should be counted.
                       </span>
                    <table border="1px" style="border-collapse: collapse; width: 100%;">
                        <tr>
                            <th width="10%">
                                Class
                            </th>
                            <th width="90%">
                                Seating Available
                                <table border="1px" style="border-collapse: collapse; width: 100%;">
                                    <tr>
                                        <th width="16%">
                                            1 Seater
                                        </th>
                                        <th width="16%">
                                            2 Seater
                                        </th>
                                        <th width="16%">
                                            3 Seater
                                        </th>
                                        <th width="16%">
                                            4 Seater
                                        </th>
                                        <th width="16%">
                                            5 Seater
                                        </th>
                                        <th width="16%">
                                            6 Seater
                                        </th>
                                    </tr>
                                </table>
                            </th>
                        </tr>
                        <tr>
                            <th>
                                ECCDE
                            </th>
                            <td>
                                <input readonly v-model="facilities.ecced_1_seater" type="number" name="" id="" style="width: 16.5%; margin-left: 1px;">
                                <input readonly v-model="facilities.ecced_2_seater" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input readonly v-model="facilities.ecced_3_seater" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input readonly v-model="facilities.ecced_4_seater" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input readonly v-model="facilities.ecced_5_seater" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input readonly v-model="facilities.ecced_6_seater" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Pre-Primary
                            </th>
                            <td>
                                <input readonly v-model="facilities.pre_primary_1_seater" type="number" name="" id="" style="width: 16.5%; margin-left: 1px;">
                                <input readonly v-model="facilities.pre_primary_2_seater" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input readonly v-model="facilities.pre_primary_3_seater" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input readonly v-model="facilities.pre_primary_4_seater" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input readonly v-model="facilities.pre_primary_5_seater" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input readonly v-model="facilities.pre_primary_6_seater" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
							</td>
                        </tr>
                        <tr>
                            <th>
                                Primary 1
                            </th>
                            <td>
                                <input readonly v-model="facilities.premary_one_1_seater" type="number" name="" id="" style="width: 16.5%; margin-left: 1px;">
                                <input readonly v-model="facilities.premary_one_2_seater" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input readonly v-model="facilities.premary_one_3_seater" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input readonly v-model="facilities.premary_one_4_seater" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input readonly v-model="facilities.premary_one_5_seater" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input readonly v-model="facilities.premary_one_6_seater" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Primary 2
                            </th>
                            <td>
                                <input readonly v-model="facilities.premary_two_1_seater" type="number" name="" id="" style="width: 16.5%; margin-left: 2px;">
                                <input readonly v-model="facilities.premary_two_2_seater" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input readonly v-model="facilities.premary_two_3_seater" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input readonly v-model="facilities.premary_two_4_seater" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input readonly v-model="facilities.premary_two_5_seater" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input readonly v-model="facilities.premary_two_6_seater" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Primary 3
                            </th>
                            <td>
                                <input readonly v-model="facilities.premary_three_1_seater" type="number" name="" id="" style="width: 16.5%; margin-left: 1px;">
                                <input readonly v-model="facilities.premary_three_2_seater" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input readonly v-model="facilities.premary_three_3_seater" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input readonly v-model="facilities.premary_three_4_seater" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input readonly v-model="facilities.premary_three_5_seater" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input readonly v-model="facilities.premary_three_6_seater" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Primary 4
                            </th>
                            <td>
                                <input readonly v-model="facilities.premary_four_1_seater" type="number" name="" id="" style="width: 16.5%; margin-left: 1px;">
                                <input readonly v-model="facilities.premary_four_2_seater" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input readonly v-model="facilities.premary_four_3_seater" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input readonly v-model="facilities.premary_four_4_seater" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input readonly v-model="facilities.premary_four_5_seater" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input readonly v-model="facilities.premary_four_6_seater" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Primary 5
                            </th>
                            <td>
                                <input readonly v-model="facilities.premary_five_1_seater" type="number" name="" id="" style="width: 16.5%; margin-left: 1px;">
                                <input readonly v-model="facilities.premary_five_2_seater" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input readonly v-model="facilities.premary_five_3_seater" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input readonly v-model="facilities.premary_five_4_seater" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input readonly v-model="facilities.premary_five_5_seater" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input readonly v-model="facilities.premary_five_6_seater" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Primary 6
                            </th>
                            <td>
                                <input readonly v-model="facilities.premary_siz_1_seater" type="number" name="" id="" style="width: 16.5%; margin-left: 1px;">
                                <input readonly v-model="facilities.premary_siz_2_seater" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input readonly v-model="facilities.premary_siz_3_seater" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input readonly v-model="facilities.premary_siz_4_seater" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input readonly v-model="facilities.premary_siz_5_seater" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input readonly v-model="facilities.premary_siz_6_seater" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Total
                            </th>
                            <td>
                                <input readonly v-model="facilities.total_1_seater" type="number" name="" id="" style="width: 16.5%; margin-left: 1px;">
                                <input readonly v-model="facilities.total_2_seater" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input readonly v-model="facilities.total_3_seater" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input readonly v-model="facilities.total_4_seater" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input readonly v-model="facilities.total_5_seater" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                                <input readonly v-model="facilities.total_6_seater" type="number" name="" id="" style="width: 16.5%; margin-left: -3px;">
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
			<br>
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
				facilities: {
                    source_of_water: null,
                    facilities_toilet_useable : null,
                    facilities_computer_useable : null,
                    facilities_water_useable : null,
                    facilities_laboratories_useable : null,
                    facilities_classrooms_useable : null,
                    facilities_library_useable : null,
                    facilities_playground_useable : null,
                    facilities_handwash_useable : null,
                    facilities_radio_useable : null,
                    facilities_internet_useable : null,
                    facilities_covid_useable : null,
                    facilities_perimeter_useable : null,
                    facilities_others_useable : null,

                    facilities_toilet_not_useable : null,
                    facilities_computer_not_useable : null,
                    facilities_water_not_useable : null,
                    facilities_laboratories_not_useable : null,
                    facilities_classrooms_not_useable : null,
                    facilities_library_not_useable : null,
                    facilities_playground_not_useable : null,
                    facilities_handwash_not_useable : null,
                    facilities_radio_not_useable : null,
                    facilities_internet_not_useable : null,
                    facilities_covid_not_useable : null,
                    facilities_perimeter_not_useable : null,
                    facilities_others_not_useable : null,

                    facilities_shared_toilet : null,
                    facilities_shared_computer : null,
                    facilities_shared_water : null,
                    facilities_shared_laboratory : null,
                    facilities_shared_classrooms : null,
                    facilities_shared_library : null,
                    facilities_shared_playground : null,
                    facilities_shared_others : null,

                    pupils_male_pit : null,
                    pupils_female_pit : null,
                    pupils_mixed_pit : null,
                    teachers_male_pit : null,
                    teachers_female_pit : null,
                    teachers_mixed_pit : null,
                    teacher_pupils_male_pit : null,
                    teacher_pupils_female_pit : null,
                    teacher_pupils_mixed_pit : null,
                    total_pit : null,

                    pupils_male_bucket_system : null,
                    pupils_female_bucket_system : null,
                    pupils_mixed_bucket_system : null,
                    teachers_male_bucket_system : null,
                    teachers_female_bucket_system : null,
                    teachers_mixed_bucket_system : null,
                    teacher_pupils_male_bucket_system : null,
                    teacher_pupils_female_bucket_system : null,
                    teacher_pupils_mixed_bucket_system : null,
                    total_bucket_system : null,

                    pupils_male_water_flush : null,
                    pupils_female_water_flush : null,
                    pupils_mixed_water_flush : null,
                    teachers_male_water_flush : null,
                    teachers_female_water_flush : null,
                    teachers_mixed_water_flush : null,
                    teacher_pupils_male_water_flush : null,
                    teacher_pupils_female_water_flush : null,
                    teacher_pupils_mixed_water_flush : null,
                    total_water_flush : null,

                    pupils_male_others : null,
                    pupils_female_others : null,
                    pupils_mixed_others : null,
                    teachers_male_others : null,
                    teachers_female_others : null,
                    teachers_mixed_others : null,
                    teacher_pupils_male_others : null,
                    teacher_pupils_female_others : null,
                    teacher_pupils_mixed_others : null,
                    total_others : null,

                    nepa_power_source : null,
                    generator_power_source : null,
                    solar_power_source : null,
                    no_power_source : null,

                    health_clinic : null,
                    first_aid : null,
                    no_health_facilities : null,

                    school_fence_wall : null,
                    school_play_room : null,

                    play_facilities_merry_go_round : null,
                    play_facilities_swing : null,
                    play_facilities_ladder_slide : null,
                    play_facilities_see_saw : null,
                    play_facilities_indoor : null,

                    learning_material_chart : null,
                    learning_material_poster : null,
                    learning_material_toys : null,
                    learning_material_audio_visual : null,
                    learning_material_word : null,
                    learning_material_caregiver : null,

                    ecced_1_seater : null,
                    ecced_2_seater : null,
                    ecced_3_seater : null,
                    ecced_4_seater : null,
                    ecced_5_seater : null,
                    ecced_6_seater : null,

                    pre_primary_1_seater : null,
                    pre_primary_2_seater : null,
                    pre_primary_3_seater : null,
                    pre_primary_4_seater : null,
                    pre_primary_5_seater : null,
                    pre_primary_6_seater : null,

                    premary_one_1_seater : null,
                    premary_one_2_seater : null,
                    premary_one_3_seater : null,
                    premary_one_4_seater : null,
                    premary_one_5_seater : null,
                    premary_one_6_seater : null,

                    premary_two_1_seater : null,
                    premary_two_2_seater : null,
                    premary_two_3_seater : null,
                    premary_two_4_seater : null,
                    premary_two_5_seater : null,
                    premary_two_6_seater : null,

                    premary_three_1_seater : null,
                    premary_three_2_seater : null,
                    premary_three_3_seater : null,
                    premary_three_4_seater : null,
                    premary_three_5_seater : null,
                    premary_three_6_seater : null,

                    premary_four_1_seater : null,
                    premary_four_2_seater : null,
                    premary_four_3_seater : null,
                    premary_four_4_seater : null,
                    premary_four_5_seater : null,
                    premary_four_6_seater : null,

                    premary_five_1_seater : null,
                    premary_five_2_seater : null,
                    premary_five_3_seater : null,
                    premary_five_4_seater : null,
                    premary_five_5_seater : null,
                    premary_five_6_seater : null,

                    premary_siz_1_seater : null,
                    premary_siz_2_seater : null,
                    premary_siz_3_seater : null,
                    premary_siz_4_seater : null,
                    premary_siz_5_seater : null,
                    premary_siz_6_seater : null,

                    total_1_seater : null,
                    total_2_seater : null,
                    total_3_seater : null,
                    total_4_seater : null,
                    total_5_seater : null,
                    total_6_seater : null,
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

					if(this.survey.facilities) {
                         this.facilities = this.survey.facilities;
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
					name: 'ministry-pupilteacher-school-survey',
					params: { surveyId: this.surveyId }
                });
			},

			previousStage() {
				
				this.$router.push({
					name: 'ministry-classrooms-school-survey',
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
table,
tr,
td, 
th {
    text-align: center;
}
</style>